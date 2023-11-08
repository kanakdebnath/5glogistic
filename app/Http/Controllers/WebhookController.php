<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Investment;
use App\Models\ManagePlan;
use App\Models\PayoutLog;
use App\Models\ManageTime;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Facades\App\Services\BasicService;

class WebhookController extends Controller
{
    use Upload, Notify;

    public function payin(Request $request)
    {

        if($request->orderStatus == "SUCCESS")
        {

            $flashpays = DB::table('flashpays')->where('platOrderNo', $request->platOrderNo)->first();

            if($flashpays->orderStatus == "PENDING")
            {

                $platOrderNo = $request->platOrderNo;
                $order = DB::table('flashpays')->where('platOrderNo', $platOrderNo)->first();
                $user = User::find($order->user_id);
                $plan = ManagePlan::where('id', $order->plan_id)->where('status', 1)->first();
                $timeManage = ManageTime::where('time', $plan->schedule)->first();

                $amount = $order->payAmount;
                $basic = (object)config('basic');

                $trx = strRandom();

                $remarks = 'Memulai Investasi';
                BasicService::makeTransaction($user, $amount, '', $trx_type = '-', $balance_type = 'payment',  $trx, $remarks);

                $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
                $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

                BasicService::makeInvest($user, $plan, $order, $amount, $profit, $maturity, $timeManage, $trx);

                if ($basic->investment_commission == 1) {
                    BasicService::setBonus($user, $order->payAmount, $type = 'invest');
                }

                $this->sendMailSms($user, $type = 'PLAN_PURCHASE', [
                    'transaction_id' => $trx,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'profit_amount' => $profit,
                ]);

                $msg = [
                    'username' => $user->username,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'plan_name' => $plan->name
                ];

                $action = [
                    "link" => route('admin.user.plan-purchaseLog', $user->id),
                    "icon" => "fa fa-money-bill-alt "
                ];

                $this->adminPushNotification('PLAN_PURCHASE', $msg, $action);

                DB::table('flashpays')->where('platOrderNo', $platOrderNo)->update(['orderStatus' => $request->orderStatus]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }
    }

    public function payout(Request $request)
    {
        if($request->orderStatus == "SUCCESS")
        {
            $flashpays = DB::table('flashpays_payout')->where('platOrderNo', $request->platOrderNo)->first();

            if($flashpays->orderStatus == "PENDING")
            {
                $platOrderNo = $request->platOrderNo;

                $payout_log = PayoutLog::where('flashpays_payout_id', $flashpays->id)->first();
                $payout_log->feedback = $request->orderMessage;
                $payout_log->status = 2;
                $payout_log->save();

                DB::table('flashpays_payout')->where('platOrderNo', $platOrderNo)->update(['orderStatus' => $request->orderStatus]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }

        if($request->orderStatus == "FAILED")
        {
            $flashpays = DB::table('flashpays_payout')->where('platOrderNo', $request->platOrderNo)->first();

            if($flashpays->orderStatus == "PENDING")
            {
                $platOrderNo = $request->platOrderNo;

                $payout_log = PayoutLog::where('flashpays_payout_id', $flashpays->id)->first();
                $payout_log->feedback = $request->orderMessage;
                $payout_log->status = 3;
                $payout_log->save();

                $user = User::find($flashpays->user_id);
                $user->balance += $payout_log->amount;
                $user->save();

                $trx = strRandom();

                $remarks = $request->orderMessage;
                BasicService::makeTransaction($user, $payout_log->amount, '', $trx_type = '+', $balance_type = 'refund',  $trx, $remarks);


                DB::table('flashpays_payout')->where('platOrderNo', $platOrderNo)->update(['orderStatus' => $request->orderStatus]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }
    }

    public function webhook_new(Request $request)
    {

        $file = fopen('./req.txt','a');
        fwrite($file, json_encode($request->all())."\n");
        fclose($file);

        if($request->orderStatus == "SUCCESS")
        {

            $flashpays = DB::table('flashpays')->where('platOrderNo', $request->platOrderNo)->first();

            if($flashpays->orderStatus == "PENDING")
            {

                $platOrderNo = $request->platOrderNo;
                $order = DB::table('flashpays')->where('platOrderNo', $platOrderNo)->first();
                 $invest_id = $order->old_invest_id;
                $user = User::find($order->user_id);
                $plan = ManagePlan::where('id', $order->plan_id)->where('status', 1)->first();
                $timeManage = ManageTime::where('time', $plan->schedule)->first();

                $amount = $order->payAmount;
                $basic = (object)config('basic');

                $trx = strRandom();

                $remarks = 'Peningkatan Investasi ';
                BasicService::makeTransaction($user, $amount, '', $trx_type = '-', $balance_type = 'payment',  $trx, $remarks);

                $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
                $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

                BasicService::makeInvest($user, $plan, $order, $amount, $profit, $maturity, $timeManage, $trx);

                if ($basic->investment_commission == 1) {
                    BasicService::setBonus($user, $order->payAmount, $type = 'invest');
                }

                $this->sendMailSms($user, $type = 'PLAN_PURCHASE', [
                    'transaction_id' => $trx,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'profit_amount' => $profit,
                ]);

                $msg = [
                    'username' => $user->username,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'plan_name' => $plan->name
                ];

                $action = [
                    "link" => route('admin.user.plan-purchaseLog', $user->id),
                    "icon" => "fa fa-money-bill-alt "
                ];

                $this->adminPushNotification('PLAN_PURCHASE', $msg, $action);

                DB::table('flashpays')->where('platOrderNo', $platOrderNo)->update(['orderStatus' => $request->orderStatus]);

                if($invest_id){
                    DB::table('investments')->where('id', $invest_id)->update(['status' => 0]);
                    session()->put('invest_id', '');
                }
                echo 'SUCCESS';
                exit;
            }

            echo 'FAILED';
            exit;
        }
    }

    public function toppay_payin(Request $request)
    {

        $file = fopen('./req.txt','a');
        fwrite($file, json_encode($request->all())."\n");
        fclose($file);

        if($request->status == "SUCCESS")
        {

            $toppay_payin = DB::table('toppay_payins')->where('platOrderNum', $request->platOrderNum)->first();

            if($toppay_payin->status == "PENDING")
            {

                $platOrderNum = $request->platOrderNum;
                $order = $toppay_payin;

                $user = User::find($order->user_id);
                $plan = ManagePlan::where('id', $order->plan_id)->where('status', 1)->first();
                $timeManage = ManageTime::where('time', $plan->schedule)->first();

                $amount = $order->payMoney;
                $basic = (object)config('basic');

                $trx = strRandom();

                $remarks = 'Memulai Investasi';
                BasicService::makeTransaction($user, $amount, '', $trx_type = '-', $balance_type = 'payment',  $trx, $remarks);

                $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
                $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

                BasicService::makeInvest($user, $plan, $order, $amount, $profit, $maturity, $timeManage, $trx);

                if ($basic->investment_commission == 1) {
                    BasicService::setBonus($user, $order->payMoney, $type = 'invest');
                }

                $this->sendMailSms($user, $type = 'PLAN_PURCHASE', [
                    'transaction_id' => $trx,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'profit_amount' => $profit,
                ]);

                $msg = [
                    'username' => $user->username,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'plan_name' => $plan->name
                ];

                $action = [
                    "link" => route('admin.user.plan-purchaseLog', $user->id),
                    "icon" => "fa fa-money-bill-alt "
                ];

                $this->adminPushNotification('PLAN_PURCHASE', $msg, $action);

                DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->update(['status' => $request->status]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }
        else
        {
            $platOrderNum = $request->platOrderNum;
            DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->update(['status' => $request->status]);
        }

        echo 'SUCCESS';
        exit;
    }

    public function toppay_payout(Request $request)
    {

        $file = fopen('./req.txt','a');
        fwrite($file, json_encode($request->all())."\n");
        fclose($file);

        if($request->status == "2")
        {
            $toppay_payout = DB::table('toppay_payouts')->where('platOrderNum', $request->platOrderNum)->first();

            if($toppay_payout->status == "0")
            {

                $payout_log = PayoutLog::where('toppay_payout_id', $toppay_payout->id)->first();
                $payout_log->feedback = $request->statusMsg;
                $payout_log->status = 2;
                $payout_log->save();

                DB::table('toppay_payouts')->where('platOrderNum', $request->platOrderNum)->update(['status' => $request->status]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }

        if($request->status == "4")
        {
            $toppay_payout = DB::table('toppay_payouts')->where('platOrderNum', $request->platOrderNum)->first();

            if($toppay_payout->status == "0")
            {
                $platOrderNum = $request->platOrderNum;

                $payout_log = PayoutLog::where('toppay_payout_id', $toppay_payout->id)->first();
                $payout_log->feedback = $request->statusMsg;
                $payout_log->status = 3;
                $payout_log->save();

                $user = User::find($toppay_payout->user_id);
                $user->balance += $payout_log->amount;
                $user->save();

                $trx = strRandom();

                $remarks = $request->statusMsg;
                BasicService::makeTransaction($user, $payout_log->amount, '', $trx_type = '+', $balance_type = 'refund',  $trx, $remarks);


                DB::table('toppay_payouts')->where('platOrderNum', $platOrderNum)->update(['status' => $request->status]);

                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }
    }
    
    public function toppay_plan_upgrade(Request $request)
    {

        $file = fopen('./req.txt','a');
        fwrite($file, json_encode($request->all())."\n");
        fclose($file);

        if($request->status == "SUCCESS")
        {

            $toppay_payin = DB::table('toppay_payins')->where('platOrderNum', $request->platOrderNum)->first();

            if($toppay_payin->status == "PENDING")
            {

                $platOrderNum = $request->platOrderNum;
                $order = DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->first();
                $invest_id = $order->old_invest_id;
                $user = User::find($order->user_id);
                $plan = ManagePlan::where('id', $order->plan_id)->where('status', 1)->first();
                $timeManage = ManageTime::where('time', $plan->schedule)->first();

                $amount = $order->payMoney;
                $basic = (object)config('basic');

                $trx = strRandom();

                $remarks = 'Peningkatan Investasi ';
                BasicService::makeTransaction($user, $amount, '', $trx_type = '-', $balance_type = 'payment',  $trx, $remarks);

                $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
                $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

                BasicService::makeInvest($user, $plan, $order, $amount, $profit, $maturity, $timeManage, $trx);

                if ($basic->investment_commission == 1) {
                    BasicService::setBonus($user, $order->payMoney, $type = 'invest');
                }

                $this->sendMailSms($user, $type = 'PLAN_PURCHASE', [
                    'transaction_id' => $trx,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'profit_amount' => $profit,
                ]);

                $msg = [
                    'username' => $user->username,
                    'amount' => getAmount($amount),
                    'currency' => $basic->currency_symbol,
                    'plan_name' => $plan->name
                ];

                $action = [
                    "link" => route('admin.user.plan-purchaseLog', $user->id),
                    "icon" => "fa fa-money-bill-alt "
                ];

                $this->adminPushNotification('PLAN_PURCHASE', $msg, $action);

                DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->update(['status' => $request->status]);

                if($invest_id){
                    DB::table('investments')->where('id', $invest_id)->update(['status' => 0]);
                    session()->put('invest_id', '');
                }
                echo 'SUCCESS';
                exit;
            }

            echo 'SUCCESS';
            exit;
        }
        else
        {
            $platOrderNum = $request->platOrderNum;
            DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->update(['status' => $request->status]);
        }

        echo 'SUCCESS';
        exit;
    }

    // public function resetInvestment(Request $request)
    // {

    //     $orders = DB::table('flashpays')->where('id', '>', 667)->where('orderStatus', 'SUCCESS')->get();

    //     foreach($orders as $order)
    //     {

    //         $user = User::find($order->user_id);
    //         $plan = ManagePlan::where('id', $order->plan_id)->where('status', 1)->first();
    //         $timeManage = ManageTime::where('time', $plan->schedule)->first();

    //         $amount = $order->payAmount;
    //         $basic = (object)config('basic');

    //         $trx = strRandom();

    //         $remarks = 'Invested On ' . $plan->name;
    //         BasicService::makeTransaction($user, $amount, '', $trx_type = '-', $balance_type = 'payment',  $trx, $remarks);

    //         $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
    //         $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

    //         BasicService::makeInvest($user, $plan, $order, $amount, $profit, $maturity, $timeManage, $trx);

    //         if ($basic->investment_commission == 1) {
    //             BasicService::setBonus($user, $order->payAmount, $type = 'invest');
    //         }

    //         sleep(1);

    //     }

    //     echo "Done";
    // }

}