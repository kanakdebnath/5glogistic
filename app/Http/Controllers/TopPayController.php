<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PayoutLog;
use App\Models\Investment;
use App\Models\ManagePlan;
use App\Models\UserAccount;
use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Facades\App\Services\BasicService;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;

class TopPayController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function checkout(Request $request){
        
        //return back()->with('warning', 'System is not live yet');
        
        $this->validate($request, [
            'balance_type' => 'required',
            'amount' => 'required|numeric',
            'plan_id' => 'required',
        ]);


        $plan = ManagePlan::where('id', $request->plan_id)->where('status', 1)->first();
        if (!$plan && $request->balance_type != 'checkout' && $request->amount < 10000) {
            return back()->with('error', 'Invalid Plan Request');
        }

        $investAllUsers = Investment::where('plan_id', $request->plan_id)->get()->count();
        if ($investAllUsers >= $plan->max_users)
        {
            return back()->with('error', 'Stok tidak tersedia');
        }

        $investPerUser = Investment::where(['plan_id' => $request->plan_id, 'user_id' => Auth::user()->id])->get()->count();
        if ($investPerUser >= $plan->max_per_user)
        {
            return back()->with('error', 'Telah mencapai batas pembelian.');
        }


        // $method = 'CHECKOUT';
        $merchantCode = env('TOPPAY_MERCHANT_NO_TEST');
        $orderType = "0";
        $orderNum = mt_rand(1000000000000,9999999999999);
        $payMoney = (int)$request->amount;
        $productDetail = "text";
        $notifyUrl = route('payin.toppay.webhook');
        $expiryPeriod = 1440;
        $dateTime = Date('d-m-Y');
        $email = Auth::user()->email;
        $name = Auth::user()->firstname." ".Auth::user()->lastname;
        $phone = Auth::user()->phone;
        $redirectUrl = route('user.toppay.callback');
        $sign = '';

        $params = array(
            'merchantCode' => $merchantCode,
            'orderType' => $orderType,
            'orderNum' => $orderNum,
            'payMoney' => $payMoney,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notifyUrl' => $notifyUrl,
            'redirectUrl' => $redirectUrl,
            'dateTime' => $dateTime,
            'expiryPeriod' => $expiryPeriod,
            'productDetail' => $productDetail
        );

        ksort($params);
        $params_str = '';
        foreach ($params as $key => $val) {
            $params_str = $params_str . $val;
        }

        $sign = $this->pivate_key_encrypt($params_str, env('TOPPAY_MERCHANT_PRIVATE_KEY'));

        $params['sign'] = $sign;

        $response = Http::withoutVerifying()
        ->withOptions(["verify"=>false])
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post(env('TOPPAY_PAYIN_URL'), $params);

        if($response->status() == 200 && $response->object()->platRespCode == "SUCCESS")
        {
            try
            {
                session()->put('platOrderNum', $response->object()->platOrderNum);

                DB::table('toppay_payins')->insert([
                    'user_id' => Auth::user()->id,
                    'plan_id' => $plan->id,
                    'orderNum' => $response->object()->orderNum,
                    'platOrderNum' => $response->object()->platOrderNum,
                    'url' => $response->object()->url,
                    'payMoney' => $response->object()->payMoney,
                    'platRespCode' => $response->object()->platRespCode,
                    'platRespMessage' => $response->object()->platRespMessage,
                    'status' => "PENDING",
                    'created_at' => Carbon::now(),
                ]);
            }
            catch (\Exception $e)
            {
                return back()->with('error', 'Sever Error! Please Contact Admin');
            }

            return redirect()->intended($response->object()->url);
        }
        else
        {
            return back()->with('error', 'Sever Error! Please Contact Admin');
        }


    }
    
    

    public function callback()
    {
        $platOrderNum = session()->get('platOrderNum');
        $payment = DB::table('toppay_payins')->where('platOrderNum', $platOrderNum)->first();
        if($payment->status == 'SUCCESS')
        {
            return redirect()->route('user.home')->with('success', 'Pembayaran Berhasil, silahkan cek status investasi anda.');
        }
        else
        {
            return redirect()->route('user.home')->with('warning', 'Pembayaran akan diproses setelah sistem menerima dana');
        }
        session()->forget('platOrderNum');
    }
    
    public function toppay_plan_upgrade(Request $request)
    {

        $this->validate($request, [
            'plan_id' => 'required',
            'invest_amount' => 'required',
            'invest_id' => 'required'
        ]);

        $plan_id = $request->plan_id;
        $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();
        $amount = ($plan->fixed_amount - $request->invest_amount );


        $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();
        if (!$plan) {
            return back()->with('error', 'Invalid Plan Request');
        }

        $investAllUsers = Investment::where('plan_id', $plan_id)->get()->count();
        if ($investAllUsers >= $plan->max_users)
        {
            return back()->with('error', 'Stok telah habis.');
        }

        $investPerUser = Investment::where(['plan_id' => $plan_id, 'user_id' => Auth::user()->id])->get()->count();
        if ($investPerUser >= $plan->max_per_user)
        {
            return back()->with('error', 'Telah mencapai batas pembelian.');
        }

        // $method = 'CHECKOUT';
        $merchantCode = env('TOPPAY_MERCHANT_NO_TEST');
        $orderType = "0";
        $orderNum = mt_rand(1000000000000,9999999999999);
        $payMoney = (int)$amount;
        $productDetail = "text";
        $notifyUrl = route('plan_upgrade.toppay.webhook');
        $expiryPeriod = 1440;
        $dateTime = Date('d-m-Y');
        $email = Auth::user()->email;
        $name = Auth::user()->firstname." ".Auth::user()->lastname;
        $phone = Auth::user()->phone;
        $redirectUrl = route('user.toppay.callback');
        $sign = '';

        $params = array(
            'merchantCode' => $merchantCode,
            'orderType' => $orderType,
            'orderNum' => $orderNum,
            'payMoney' => $payMoney,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notifyUrl' => $notifyUrl,
            'redirectUrl' => $redirectUrl,
            'dateTime' => $dateTime,
            'expiryPeriod' => $expiryPeriod,
            'productDetail' => $productDetail
        );

        ksort($params);
        $params_str = '';
        foreach ($params as $key => $val) {
            $params_str = $params_str . $val;
        }

        $sign = $this->pivate_key_encrypt($params_str, env('TOPPAY_MERCHANT_PRIVATE_KEY'));

        $params['sign'] = $sign;

        $response = Http::withoutVerifying()
        ->withOptions(["verify"=>false])
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post(env('TOPPAY_PAYIN_URL'), $params);

        if($response->status() == 200 && $response->object()->platRespCode == "SUCCESS")
        {
            try
            {
                session()->put('invest_id', $request->invest_id);
                session()->put('platOrderNum', $response->object()->platOrderNum);

                DB::table('toppay_payins')->insert([
                    'user_id' => Auth::user()->id,
                    'plan_id' => $plan->id,
                    'old_invest_id' => $request->invest_id,
                    'orderNum' => $response->object()->orderNum,
                    'platOrderNum' => $response->object()->platOrderNum,
                    'url' => $response->object()->url,
                    'payMoney' => $response->object()->payMoney,
                    'platRespCode' => $response->object()->platRespCode,
                    'platRespMessage' => $response->object()->platRespMessage,
                    'status' => "PENDING",
                    'created_at' => Carbon::now(),
                ]);
            }
            catch (\Exception $e)
            {
                return back()->with('error', 'Sever Error! Please Contact Admin');
            }

            return redirect()->intended($response->object()->url);
        }
        else
        {
            return back()->with('error', 'Sever Error! Please Contact Admin');
        }
    }


    public function payoutMoneyRequest(Request $request)
    {
        

        //return back()->with('warning', 'System is not live yet');

        $dt = Carbon::now();

        if ($dt->format('H') < 9 || $dt->format('H') >= 17) {
            return back()->with('warning', 'Penarikan hanya tersedia pada pukul 09.00 - 17.00 WIB setiap harinya');
        }

        $this->validate($request, [
            'wallet_type' => ['required', Rule::in(['balance','interest_balance'])],
            'gateway' => 'required|integer',
            'amount' => ['required', 'numeric'],
            'account_id' => ['required']
        ],[
            'account_id.required' => 'Please select your account'
        ]);

        $basic = (object)config('basic');
        $method = PayoutMethod::where('id', $request->gateway)->where('status', 1)->firstOrFail();
        $authWallet = $this->user;

        if ($request->amount < $method->minimum_amount) {
            session()->flash('error', 'Minimum payout Amount ' . round($method->minimum_amount, 2) . ' ' . $basic->currency);
            return back();
        }
        if ($request->amount > $method->maximum_amount) {
            session()->flash('error', 'Maximum payout Amount ' . round($method->maximum_amount, 2) . ' ' . $basic->currency);
            return back();
        }

        if ($request->amount > $authWallet[$request->wallet_type]) {
            session()->flash('error', 'Insufficient '.snake2Title($request->wallet_type) .' For Withdraw.');
            return back();
        } else {

            $count = PayoutLog::where('user_id', Auth()->user()->id)->where('status', 2)
           ->whereDate('created_at', Carbon::today())
           ->get()
           ->count();

           if ($count >= 1) {
                session()->flash('warning', 'Telah mencapai batas limit penarikan');
                return back();
            }


            $account = UserAccount::findOrFail($request->account_id);
            $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);

            $merchantCode = env('TOPPAY_MERCHANT_NO_TEST');
            $orderNum = mt_rand(1000000000000,9999999999999);
            $payment_method = 'Transfer';
            $orderType = '0';
            $money = (int)($request->amount - $charge);
            $feeType = '1';
            $dateTime = date("YmdHis",time());
            $number = $account->bank_account;
            $bankCode = $account->bank->bankCode;
            $name = $account->account_holder;
            $mobile = Auth::user()->phone;
            $email = Auth::user()->email;
            $description = 'Payout Money';
            $notifyUrl = route('payout.toppay.webhook');

            $params = array(
                'merchantCode' => $merchantCode,
                'orderType' => $orderType,
                'method' => $payment_method,
                'orderNum' => $orderNum,
                'money' => $money,
                'feeType' => $feeType,
                'dateTime' => $dateTime,
                'number' => $number,
                'bankCode' => $bankCode,
                'name' => $name,
                'mobile' => $mobile,
                'email' => $email,
                'notifyUrl' => $notifyUrl,
                'description' => $description
            );


            ksort($params);
            $params_str = '';
            foreach ($params as $key => $val) {
                $params_str = $params_str . $val;
            }

            $sign = $this->pivate_key_encrypt($params_str, env('TOPPAY_MERCHANT_PRIVATE_KEY'));

            $params['sign'] = $sign;
            
            


            $response = "";

            if($request->amount <= 5000000){
                $response = Http::withoutVerifying()
                ->withOptions(["verify"=>false])
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(env('TOPPAY_PAYOUT_URL'), $params);
                
                if($response->object()->platRespCode == "FAIL")
                {
                    $file = fopen('./error.txt','a');
                    fwrite($file, json_encode($response->object())."\n");
                    fclose($file);
                    return back()->with('error', 'Oops! Something went wrong.');
                }
            }
            

            $FP_payout_id = "";

            if($request->amount <= 5000000 && $response->status() == "200" && $response->object()->platRespCode == "SUCCESS")
            {
                try
                {

                    $FP_payout = array(
                        'user_id' => Auth::user()->id,
                        'orderNum' => $response->object()->orderNum,
                        'platOrderNum' => $response->object()->platOrderNum,
                        'money' => $response->object()->money,
                        'fee' => $response->object()->fee,
                        'feeType' => $response->object()->feeType,
                        'bankCode' => $response->object()->bankCode,
                        'mobile' => $mobile,
                        'number' => $response->object()->number,
                        'name' => $response->object()->name,
                        'description' => $response->object()->description,
                        'platRespCode' => $response->object()->platRespCode,
                        'platRespMessage' => $response->object()->platRespMessage,
                        'status' => '0',
                        'statusMsg' => $response->object()->statusMsg,
                        'created_at' => Carbon::now(),
                    );

                    $FP_payout_id = DB::table('toppay_payouts')->insertGetId($FP_payout);

                }
                catch (\Exception $e)
                {
                    
                    return back()->with('error', 'Oops! Something went wrong.');
                }
            }

            try{
                $trx = strRandom();
                $withdraw = new PayoutLog();
                $withdraw->user_id = $authWallet->id;
                $withdraw->method_id = $method->id;
                $withdraw->user_account_id = $request->account_id;
                $withdraw->toppay_payout_id = $FP_payout_id;
                $withdraw->amount = $request->amount;
                $withdraw->charge = $charge;
                $withdraw->net_amount = ($request->amount - $charge);
                $withdraw->trx_id = $trx;
                $withdraw->status = 1;
                $withdraw->balance_type = $request->wallet_type;
                $withdraw->save();

                $withdraw = PayoutLog::latest()->where('trx_id', $trx)->where('status', 1)->with('method', 'user', 'account')->firstOrFail();

                $user = $this->user;

                $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
                $user[$withdraw->balance_type] -= $request->amount;
                $user->save();

                $remarks = 'Penarikan';
                BasicService::makeTransaction($user, $withdraw->amount, $withdraw->charge, '-', $withdraw->balance_type, $withdraw->trx_id, $remarks);


                $this->sendMailSms($user, $type = 'PAYOUT_REQUEST', [
                    'method_name' => optional($withdraw->method)->name,
                    'amount' => getAmount($withdraw->amount),
                    'charge' => getAmount($withdraw->charge),
                    'currency' => $basic->currency_symbol,
                    'trx' => $withdraw->trx_id,
                ]);


                $msg = [
                    'username' => $user->username,
                    'amount' => getAmount($withdraw->amount),
                    'currency' => $basic->currency_symbol,
                ];
                $action = [
                    "link" => route('admin.user.withdrawal', $user->id),
                    "icon" => "fa fa-money-bill-alt "
                ];
                $this->adminPushNotification('PAYOUT_REQUEST', $msg, $action);

                session()->flash('success', 'Payment transfered successfully');
                return redirect()->back();
            } catch (\Exception $e)
            {

              return back()->with('error', 'Oops! Something went wrong.');
            }

            // session()->put('wtrx', $trx);

            // if (getAmount($withdraw->net_amount) > $user[$withdraw->balance_type]) {
            //     session()->flash('error', 'Insufficient '.snake2Title($withdraw->balance_type).' For Payout.');
            //     return redirect()->back();
            // } else {



            // // return redirect()->route('user.payout.preview');
            // }
        }
    }

    function pivate_key_encrypt($data, $pivate_key)
    {
        $pivate_key = '-----BEGIN PRIVATE KEY-----'."\n".$pivate_key."\n".'-----END PRIVATE KEY-----';
        $pi_key = openssl_pkey_get_private($pivate_key);
        $crypto = '';
        foreach (str_split($data, 117) as $chunk) {
            openssl_private_encrypt($chunk, $encryptData, $pi_key);
            $crypto .= $encryptData;
        }

        return base64_encode($crypto);
    }


    public function public_key_decrypt($data, $public_key)
    {
        $public_key = '-----BEGIN PUBLIC KEY-----'."\n".$public_key."\n".'-----END PUBLIC KEY-----';
        $data = base64_decode($data);
        $pu_key =  openssl_pkey_get_public($public_key);
        $crypto = '';
        foreach (str_split($data, 128) as $chunk) {
            openssl_public_decrypt($chunk, $decryptData, $pu_key);
            $crypto .= $decryptData;
        }

        return $crypto;


  }
}