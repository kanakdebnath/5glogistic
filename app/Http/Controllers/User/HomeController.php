<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\KYC;
use App\Models\Fund;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Template;
use App\Models\PayoutLog;
use App\Models\Investment;
use App\Models\ManagePlan;
use App\Models\ManageTime;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Transaction;
use App\Models\IdentifyForm;
use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use App\Models\MoneyTransfer;
use App\Models\ContentDetails;
use Illuminate\Validation\Rule;
use App\Models\UserAccount;
use Illuminate\Support\Facades\DB;
use App\Helper\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\FlashpayPayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use Facades\App\Services\BasicService;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use hisorange\BrowserDetect\Parser as Browser;

class HomeController extends Controller
{
    use Upload, Notify;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menu'] = 'Account';

        $data['walletBalance'] = getAmount($this->user->balance);
        $data['interestBalance'] = getAmount($this->user->interest_balance);
        $data['totalDeposit'] = getAmount($this->user->funds()->whereNull('plan_id')->whereStatus(1)->sum('amount'));
        $data['totalPayout'] = getAmount($this->user->payout()->whereStatus(2)->sum('amount'));
        $data['depositBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'deposit')->sum('amount'));
        $data['investBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'invest')->sum('amount'));
        $data['lastBonus'] = getAmount(optional($this->user->referralBonusLog()->latest()->first())->amount);

        $data['totalProfit'] = getAmount($this->user->transaction()->where('balance_type', 'balance')->where('trx_type', '+')->sum('amount'));
        $data['totalProfitMonthly'] = getAmount($this->user->transaction()->where('balance_type', 'balance')->where('trx_type', '+')->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('amount'));

        $roi = Investment::where('user_id', $this->user->id)
            ->selectRaw('SUM( amount ) AS totalInvestAmount')
            ->selectRaw('COUNT( id ) AS totalInvest')
            ->selectRaw('COUNT(CASE WHEN status = 0  THEN id END) AS completed')
            ->selectRaw('COUNT(CASE WHEN status = 1  THEN id END) AS running')
            ->selectRaw('SUM(CASE WHEN maturity != -1  THEN maturity * profit END) AS expectedProfit')
            ->selectRaw('SUM(recurring_time * profit) AS returnProfit')
            ->get()->makeHidden('nextPayment')->toArray();
        $data['roi'] = collect($roi)->collapse();
        $data['ticket'] = Ticket::where('user_id', $this->user->id)->count();

        $monthlyInvestment = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        Investment::where('user_id', $this->user->id)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->makeHidden('nextPayment')->map(function ($item) use ($monthlyInvestment) {
                $monthlyInvestment->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['investment'] = $monthlyInvestment;


        $monthlyPayout = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->payout()->whereStatus(2)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyPayout) {
                $monthlyPayout->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['payout'] = $monthlyPayout;


        $monthlyFunding = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->funds()->whereNull('plan_id')->whereStatus(1)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyFunding) {
                $monthlyFunding->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['funding'] = $monthlyFunding;

        $monthlyReferralInvestBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->referralBonusLog()->where('type', 'invest')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralInvestBonus) {
                $monthlyReferralInvestBonus->put($item['months'], round($item['totalAmount'], 2));
            });

        $monthly['referralInvestBonus'] = $monthlyReferralInvestBonus;


        $monthlyReferralFundBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);

        $this->user->referralBonusLog()->where('type', 'deposit')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralFundBonus) {
                $monthlyReferralFundBonus->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['referralFundBonus'] = $monthlyReferralFundBonus;


        $latestRegisteredUser = User::where('referral_id', $this->user->id)->latest()->first();

        $investments = $this->user->invests()->paginate(config('basic.paginate'));

        return view($this->theme . 'user.dashboard', $data, compact('monthly', 'latestRegisteredUser', 'investments'));
    }


    public function transaction()
    {
        $transactions = $this->user->transaction()->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.index', compact('transactions'));
    }


    public function investments()
    {
        $investments = $this->user->invests()->paginate(config('basic.paginate'));
        return view($this->theme . 'user.investments', compact('investments'));
    }

    public function transactionSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $transaction = Transaction::where('user_id', $this->user->id)->with('user')
            ->when(@$search['transaction_id'], function ($query) use ($search) {
                return $query->where('trx_id', 'LIKE', "%{$search['transaction_id']}%");
            })
            ->when(@$search['remark'], function ($query) use ($search) {
                return $query->where('remarks', 'LIKE', "%{$search['remark']}%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $transactions = $transaction->appends($search);


        return view($this->theme . 'user.transaction.index', compact('transactions'));

    }

    public function fundHistory()
    {
        $funds = Fund::where('user_id', $this->user->id)->where('status', '!=', 0)->where('plan_id', null)->orderBy('id', 'DESC')->with('gateway')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));
    }

    public function fundHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $funds = Fund::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('transaction', 'LIKE', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('gateway')
            ->paginate(config('basic.paginate'));
        $funds->appends($search);

        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));

    }


    public function addFund()
    {
        if (session()->get('plan_id') != null) {
            return redirect(route('user.payment'));
        }

        $data['totalPayment'] = null;
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view($this->theme . 'user.addFund', $data);
    }

    public function payment()
    {
        $encPlanId = session()->get('plan_id');
        if ($encPlanId == null) {
            return redirect(route('user.addFund'));
        }
        $plan = ManagePlan::where('id', decrypt($encPlanId))->where('status', 1)->firstOrFail();
        $amount = session()->get('amount');
        $data['totalPayment'] = decrypt($amount);
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        $data['plan'] = $plan;
        return view($this->theme . 'user.payment', $data);
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['languages'] = Language::all();
        $data['identityFormList'] = IdentifyForm::where('status', 1)->get();
        if ($request->has('identity_type')) {
            $validator->errors()->add('identity', '1');
            $data['identity_type'] = $request->identity_type;
            $data['identityForm'] = IdentifyForm::where('slug', trim($request->identity_type))->where('status', 1)->firstOrFail();
            return view($this->theme . 'user.profile.myprofile', $data)->withErrors($validator);
        }

        return view($this->theme . 'user.profile.myprofile', $data);
    }


    public function updateProfile(Request $request)
    {
        $allowedExtensions = array('jpg', 'png', 'jpeg');

        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        return $fail("Images MAX  2MB ALLOW!");
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                }
            ]
        ]);
        $user = $this->user;
        if ($request->hasFile('image')) {
            $path = config('location.user.path');
            try {
                $user->image = $this->uploadImage($image, $path);
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload your ' . $image)->withInput();
            }
        }
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updateInformation(Request $request)
    {

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = Purify::clean($request->all());
        $user = $this->user;
        $rules = [
            'firstname' => 'required|min:4',
            'lastname' => 'required',
            'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
            'address' => 'required',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name field is required',
            'lastname.required' => 'Last Name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user->language_id = $req['language_id'];
        $user->firstname = $req['firstname'];
        $user->lastname = $req['lastname'];
        // $user->username = $req['username'];
        $user->address = $req['address'];
        $user->save();
        return back()->with('success', 'Berhasil Diubah.');
    }


    public function updatePassword(Request $request)
    {

        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Berhasil Diubah.');
            } else {
                throw new \Exception('Password saat ini salah.');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function twoStepSecurity()
    {
        $basic = (object)config('basic');
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $secret);
        $previousCode = $this->user->two_fa_code;

        $previousQR = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $previousCode);
        return view($this->theme . 'user.twoFA.index', compact('secret', 'qrCodeUrl', 'previousCode', 'previousQR'));
    }

    public function twoStepEnable(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = $request->key;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);
            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }


    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = $this->user;
        $ga = new GoogleAuthenticator();

        $secret = $user->two_fa_code;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['two_fa'] = 0;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = null;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_DISABLED', [
                'action' => 'Disabled',
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Disabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }

    public function purchasePlan(Request $request)
    {
        $this->validate($request, [
            'balance_type' => 'required',
            'amount' => 'required|numeric',
            'plan_id' => 'required',
        ]);

        $user = $this->user;
        $plan = ManagePlan::where('id', $request->plan_id)->where('status', 1)->first();
        if (!$plan) {
            return back()->with('error', 'Invalid Plan Request');
        }

        $timeManage = ManageTime::where('time', $plan->schedule)->first();

        $balance_type = $request->balance_type;
        if (!in_array($balance_type, ['balance', 'interest_balance', 'checkout'])) {
            return back()->with('error', 'Invalid Wallet Type');
        }


        $amount = $request->amount;
        $basic = (object)config('basic');
        if ($plan->fixed_amount == '0' && $amount < $plan->minimum_amount) {
            return back()->with('error', "Invest Limit " . $plan->price);
        } elseif ($plan->fixed_amount == '0' && $amount > $plan->maximum_amount) {
            return back()->with('error', "Invest Limit " . $plan->price);
        } elseif ($plan->fixed_amount != '0' && $amount != $plan->fixed_amount) {
            return back()->with('error', "Please invest " . $plan->price);
        }

        if ($balance_type == "checkout") {
            session()->put('amount', encrypt($amount));
            session()->put('plan_id', encrypt($plan->id));
            return redirect()->route('user.payment');
        }

        if ($amount > $user->$balance_type) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $new_balance = getAmount($user->$balance_type - $amount);
        $user->$balance_type = $new_balance;
        $user->save();

        $trx = strRandom();
        $remarks = 'Memulai Investasi';
        BasicService::makeTransaction($user, $amount, 0, $trx_type = '-', $balance_type, $trx, $remarks);


        $profit = ($plan->profit_type == 1) ? ($amount * $plan->profit) / 100 : $plan->profit;
        $maturity = ($plan->is_lifetime == 1) ? '-1' : $plan->repeatable;

        //// For Fixed Plan
        if ($plan->fixed_amount != 0 && ($plan->fixed_amount == $amount)) {
            BasicService::makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage, $trx);
        } elseif ($plan->fixed_amount == 0) {
            BasicService::makeInvest($user, $plan, $amount, $profit, $maturity, $timeManage, $trx);
        }

        if ($basic->investment_commission == 1) {
            BasicService::setBonus($user, $request->amount, $type = 'invest');
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

        return back()->with('success', 'Pembayaran diterima. Investasi berhasil');
    }

    public function checkout(Request $request)
    {

        // return back()->with('warning', 'Sistem pembelian sedang dalam pemeliharaan');

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
            return back()->with('error', 'Stok telah habis.');
        }

        $investPerUser = Investment::where(['plan_id' => $request->plan_id, 'user_id' => Auth::user()->id])->get()->count();
        if ($investPerUser >= $plan->max_per_user)
        {
            return back()->with('error', 'Anda melebihi batas pembelian.');
        }

        $email = Auth::user()->email;
        $expiryPeriod = 1440;
        $merchantNo = env('FLASHPAY_MERCHANT_NO_PROD');
        $merchantOrderNo = mt_rand(1000000000000,9999999999999);
        $method = 'CHECKOUT';
        $mobile = Auth::user()->phone;
        $name = Auth::user()->firstname." ".Auth::user()->lastname;
        $notifyUrl = route('payin.webhook');
        $payAmount = $request->amount;
        $redirectUrl = route('user.payment.callback');
        $sign = '';
        $str = $email.$expiryPeriod.$merchantNo.$merchantOrderNo.$method.$mobile.$name.$notifyUrl.$payAmount.$redirectUrl;
        $sign = $this->sign($str);

        $response = Http::withoutVerifying()
        ->withOptions(["verify"=>false])
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post(env('FLASHPAY_BASE_URL_PROD').'/api/pay', [
            'email' => $email,
            'expiryPeriod' => $expiryPeriod,
            'merchantNo' => $merchantNo,
            'merchantOrderNo' => $merchantOrderNo,
            'method' => $method,
            'mobile' => $mobile,
            'name' => $name,
            'notifyUrl' => $notifyUrl,
            'payAmount' => $payAmount,
            'redirectUrl' => $redirectUrl,
            'sign' => $sign,
        ]);


        if($response->object() && $response->object()->status == "200")
        {
            try
            {
                session()->put('platOrderNo', $response->object()->data->platOrderNo);

                DB::table('flashpays')->insert([
                    'user_id' => Auth::user()->id,
                    'plan_id' => $plan->id,
                    'merchantOrderNo' => $response->object()->data->merchantOrderNo,
                    'platOrderNo' => $response->object()->data->platOrderNo,
                    'method' => $response->object()->data->method,
                    'accountNumber' => $response->object()->data->accountNumber,
                    'paymentUrl' => $response->object()->data->paymentUrl,
                    'payAmount' => $response->object()->data->payAmount,
                    'merchantFee' => $response->object()->data->merchantFee,
                    'description' => $response->object()->data->description,
                    'orderStatus' => "PENDING",
                    'orderMessage' => "Payment is Pending",
                    'created_at' => Carbon::now(),
                ]);
            }
            catch (\Exception $e)
            {
                return back()->with('error', 'Sever Error');
            }

            return redirect()->intended($response->object()->data->paymentUrl);
        }
        else
        {
            return back()->with('error', 'Server Error');
        }

    }



    public function callback(Request $request)
    {
        $platOrderNo = session()->get('platOrderNo');
        $payment = DB::table('flashpays')->where('platOrderNo', $platOrderNo)->first();
        if($payment->orderStatus == 'PENDING')
        {
            return redirect()->route('user.home')->with('warning', 'Proses anda telah diterima, setelah pembayaran diterima refresh halaman dan silahkan cek status investasi.');
        }
        else
        {
            return redirect()->route('user.home')->with('success', 'Pembayaran diterima. Investasi berhasil');
        }
        session()->forget('platOrderNo');
    }

    public function sign($str)
    {

        $res = openssl_pkey_get_private(config('keys.private_key'));

        $content = '';

        foreach (str_split($str, 117) as $item) {
            openssl_private_encrypt($item, $crypted, $res);
            $content .= $crypted;
        }

        return base64_encode($content);
    }


    public function investHistory()
    {
        $investments = $this->user->invests()->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.investLog', compact('investments'));
    }

    /*
     * User payout Operation
     */
    public function payoutMoney()
    {
        $user = $this->user;

        $data['title'] = "Payout Money";
        $data['gateway'] = PayoutMethod::find(2);
        $data['accounts'] = UserAccount::where('user_id', Auth::user()->id)->get();
        $data['payoutLog'] = PayoutLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->with('user', 'method', 'account')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.payout.money', $data);
    }

    public function payoutMoneyRequest(Request $request)
    {

        // return back()->with('warning', 'Sistem pembelian sedang dalam pemeliharaan');

        $dt = Carbon::now();

        // if ($dt->format('H') < 9 || $dt->format('H') >= 18) {
        //    return back()->with('warning', 'Penarikan sedang di jam offline, akan kembali tersedia pada pukul 09.00 - 18.00 WIB');
       // }

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
            session()->flash('error', 'Minimal Penarikan ' . round($method->minimum_amount, 2) . ' ' . $basic->currency);
            return back();
        }
        if ($request->amount > $method->maximum_amount) {
            session()->flash('error', 'Maksimal Penarikan. ' . round($method->maximum_amount, 2) . ' ' . $basic->currency);
            return back();
        }

        if ($request->amount > $authWallet[$request->wallet_type]) {
            session()->flash('error', 'Insufficient '.snake2Title($request->wallet_type) .' For Withdraw.');
            return back();
        } else {

            $count = PayoutLog::where('user_account_id', $request->account_id)
        ->where('user_id', $authWallet->id)
           ->whereDate('created_at', Carbon::today())
           ->count();

           if ($count >= 1) {
                session()->flash('warning', 'Penarikan hanya dapat dilakukan 1 kali sehari');
                return back();
            }



            $account = UserAccount::findOrFail($request->account_id);
            $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);

            $accountHoldName = $account->account_holder;
            $bankCode = $account->bank->code;
            $bankNumber = $account->bank_account;
            $merchantNo = env('FLASHPAY_MERCHANT_NO_PROD');
            $merchantOrderNo = mt_rand(1000000000000,9999999999999);
            $mobile = Auth::user()->phone;
            $notifyUrl = route('payout.webhook');
            $payAmount = ($request->amount - $charge);

            $sign = '';

            $str = $accountHoldName.$bankCode.$bankNumber.$merchantNo.$merchantOrderNo.$mobile.$notifyUrl.$payAmount;
            $sign = $this->sign($str);

            $response = "";

            if($request->amount <= 50000){
                $response = Http::withoutVerifying()
                ->withOptions(["verify"=>false])
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(env('FLASHPAY_BASE_URL_PROD').'/api/cash', [
                    'accountHoldName' => $accountHoldName,
                    'bankCode' => $bankCode,
                    'bankNumber' => $bankNumber,
                    'merchantNo' => $merchantNo,
                    'merchantOrderNo' => $merchantOrderNo,
                    'mobile' => $mobile,
                    'notifyUrl' => $notifyUrl,
                    'payAmount' => $payAmount,
                    'sign' => $sign,
                ]);
            }

            $FP_payout_id = "";

            if($request->amount <= 50000 && !empty($response) && $response->object() && $response->object()->status == "200")
            {
                try
                {

                    $FP_payout = array(
                        'user_id' => Auth::user()->id,
                        'merchantOrderNo' => $response->object()->data->merchantOrderNo,
                        'platOrderNo' => $response->object()->data->platOrderNo,
                        'payAmount' => $response->object()->data->payAmount,
                        'merchantFee' => $response->object()->data->merchantFee,
                        'bankCode' => $bankCode,
                        'mobile' => $mobile,
                        'bankNumber' => $bankNumber,
                        'accountHoldName' => $accountHoldName,
                        'description' => $response->object()->data->description,
                        'orderStatus' => $response->object()->data->orderStatus,
                        'orderMessage' => $response->object()->data->orderMessage,
                        'created_at' => Carbon::now(),
                    );

                    $FP_payout_id = FlashpayPayout::insertGetId($FP_payout);

                }
                catch (\Exception $e)
                {
                    return back()->with('error', 'Sever Error');
                }
            }

            try{
                $trx = strRandom();
                $withdraw = new PayoutLog();
                $withdraw->user_id = $authWallet->id;
                $withdraw->method_id = $method->id;
                $withdraw->user_account_id = $request->account_id;
                $withdraw->flashpays_payout_id = $FP_payout_id;
                $withdraw->amount = $request->amount;
                $withdraw->charge = $charge;
                $withdraw->net_amount = $request->amount - $charge;
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

                session()->flash('success', 'Permintaan penarikan berhasil.');
                return redirect()->back();
            } catch (\Exception $e)
            {
              return back()->with('error', 'Server Error 2');
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

    // public function payoutRequestSubmit($trx)
    // {
    //     $basic = (object)config('basic');
    //     $withdraw = PayoutLog::latest()->where('trx_id', $trx)->where('status', 0)->with('method', 'user', 'account')->firstOrFail();

    //     $user = $this->user;

    //     if (getAmount($withdraw->net_amount) > $user[$withdraw->balance_type]) {
    //         session()->flash('error', 'Insufficient '.snake2Title($withdraw->balance_type).' For Payout.');
    //         return redirect()->route('user.payout.money');
    //     } else {

    //         $withdraw['information'] = null;

    //         $withdraw->status = 1;
    //         $withdraw->save();

    //         $user[$withdraw->balance_type] -= $withdraw->net_amount ;
    //         $user->save();


    //         $remarks = 'Withdraw Via ' . optional($withdraw->method)->name;
    //         BasicService::makeTransaction($user, $withdraw->amount, $withdraw->charge, '-', $withdraw->balance_type, $withdraw->trx_id, $remarks);


    //         $this->sendMailSms($user, $type = 'PAYOUT_REQUEST', [
    //             'method_name' => optional($withdraw->method)->name,
    //             'amount' => getAmount($withdraw->amount),
    //             'charge' => getAmount($withdraw->charge),
    //             'currency' => $basic->currency_symbol,
    //             'trx' => $withdraw->trx_id,
    //         ]);


    //         $msg = [
    //             'username' => $user->username,
    //             'amount' => getAmount($withdraw->amount),
    //             'currency' => $basic->currency_symbol,
    //         ];
    //         $action = [
    //             "link" => route('admin.user.withdrawal', $user->id),
    //             "icon" => "fa fa-money-bill-alt "
    //         ];
    //         $this->adminPushNotification('PAYOUT_REQUEST', $msg, $action);

    //         session()->flash('success', 'Payout request Successfully Submitted. Wait For Confirmation.');
    //         return redirect()->route('user.payout.money');
    //     }
    // }


    public function payoutHistory()
    {
        $user = $this->user;
        $data['payoutLog'] = PayoutLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->with('user', 'method', 'account')->paginate(config('basic.paginate'));
        $data['title'] = "Payout Log";
        return view($this->theme . 'user.payout.log', $data);
    }


    public function listPaymentMethods()
    {
        $accounts = UserAccount::where('user_id', Auth::user()->id)->get();
        $banks = Bank::get();
        $title = "Payment Methods";
        $page_title = "Payment Methods";

        return view($this->theme . 'user.account.index', compact('accounts', 'title', 'page_title', 'banks'));
    }

    public function createPaymentMethods()
    {
        $title = "Add Payment Methods";
        $page_title = "Add Payment Methods";
        $banks = Bank::get();

        return view($this->theme . 'user.account.create', compact('title','banks', 'page_title'));
    }

    public function editPaymentMethods($id)
    {
        $account = UserAccount::find($id);
        $title = "Edit Payment Methods";
        $page_title = "Edit Payment Methods";
        $banks = Bank::get();

        return view($this->theme . 'user.account.edit', compact('account', 'title', 'page_title','banks'));
    }

    public function storePaymentMethods(Request $request)
    {
        //return back()->with('warning', 'System is not live yet');
        $this->validate($request, [
            'bank_id' => 'required',
            'account_holder' => 'required',
            'bank_account' => 'required'
        ], [
            'bank_id.required' => 'Harap pilih jenis bank',
            // 'bank_account.unique' => 'Akun Bank ini sudah terdaftar.'
        ]);

        $account = UserAccount::where('bank_id',$request->bank_id)->where('bank_account',$request->bank_account)->get();

        if(count($account) > 0){
            return redirect()->route('user.paymentmethods.list')->with('warning', 'Akun Bank Sudah terdaftar');
        }else{

            if(UserAccount::where('user_id', Auth::user()->id)->count() < 1)
            {
                $account = new UserAccount;
                $account->user_id = Auth::user()->id;
                $account->bank_id = $request->bank_id;
                $account->account_holder = $request->account_holder;
                $account->bank_account = $request->bank_account;
                $account->save();

                return redirect()->route('user.paymentmethods.list')->with('success', 'Bank Account Added');
            }

            return redirect()->route('user.paymentmethods.list')->with('warning', 'You can attack only 1 bank account');
        }
    }

    public function updatePaymentMethods(Request $request, $id)
    {
        // return back()->with('warning', 'System is not live yet');
        $this->validate($request, [
            'bank_account' => ['required']
        ], [
            // 'bank_id.required' => 'Please select a bank',
            // 'bank_account.unique' => 'Akun Bank Sudah terdaftar'
        ]);

        $account = UserAccount::where('bank_id',$request->bank_id)->where('bank_account',$request->bank_account)->where('id','!=',$id)->get();


        if(count($account) > 0){
            return redirect()->back()->with('warning', 'Akun Bank Sudah terdaftar');
        }else{
            $account = UserAccount::where('bank_id',$request->bank_id)->get();

            $account = UserAccount::find($id);
            $account->bank_account = $request->bank_account;
            $account->save();

            return redirect()->route('user.paymentmethods.list')->with('success', 'Akun Bank berhasil diubah.');

        }
    }



// capital back

    public function oldCapitalBack(Request $request)
    {
       $invest = Investment::find($request->invest_id);
       $user = $invest->user;
       $basic = (object) config('basic');

       // Complete the investment if user get full amount as plan
       if ($invest->recurring_time >= $invest->maturity && $invest->maturity != '-1') {
        $invest->status = 0; // stop return Back
        // Give the capital back if plan says the same
            if ($invest->capital_back == 1) {
                $capital =  $invest->amount;
                $new_balance = getAmount($user->balance + $capital);
                $user->balance = $new_balance;
                $user->save();
                $remarks = ' Penarikan Modal';
                BasicService::makeTransaction($user, getAmount($capital), 0, $trx_type = '+', $balance_type = 'balance',  $trx = strRandom(), $remarks);
            }
         $invest->save();
         return redirect()->route('user.investments')->with('success', 'Anda telah menerima kembali modal.');
        }



    }

    public function CapitalBack(Request $request)
    {
       $invest = Investment::find($request->invest_id);
       $user = $invest->user;
       $basic = (object) config('basic');

       // Complete the investment if user get full amount as plan
       if ($invest->recurring_time >= $invest->maturity && $invest->maturity != '-1') {
        $invest->status = 0; // stop return Back
        // Give the capital back if plan says the same
            if ($invest->capital_back == 1) {
                $capital =  $invest->amount;
                $new_balance = getAmount($user->balance + $capital);
                $user->balance = $new_balance;
                $user->save();
                $remarks = ' Penarikan Modal ';
                BasicService::makeTransaction($user, getAmount($capital), 0, $trx_type = '+', $balance_type = 'balance',  $trx = strRandom(), $remarks);
            }
         $invest->save();
         return response()->json(['success' => true, 'msg' => 'Anda telah menerima kembali modal.']);
        }
        return response()->json(['success' => false, 'msg' => 'Something Went Wrong']);
    }



// Upgrade Plan

    public function upgradePlan(Request $request)
    {
        $invest = Investment::find($request->id);
        $plan = ManagePlan::find($invest->plan_id);
        $managePlans = ManagePlan::where('status','1')->get();
        return view($this->theme . 'user.upgradeplan', compact('invest', 'managePlans', 'plan'));

    }

    public function upgradePlanStore(Request $request)
    {


        $plan_id = $request->plan_id;
        $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();
        $amount = ($plan->fixed_amount - $request->invest_amount );


        $plan = ManagePlan::where('id', $plan_id)->where('status', 1)->first();
        if (!$plan && $request->balance_type != 'checkout') {
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
            return back()->with('error', 'Telah melebihi batas pembelian.');
        }



        $email = Auth::user()->email;
        $expiryPeriod = 1440;
        $merchantNo = env('FLASHPAY_MERCHANT_NO_PROD');
        $merchantOrderNo = mt_rand(1000000000000,9999999999999);
        $method = env('FLASHPAY_METHOD_PROD');
        $mobile = Auth::user()->phone;
        $name = Auth::user()->firstname." ".Auth::user()->lastname;
        $notifyUrl = route('payin.webhook_new');
        $payAmount = $amount;
        $redirectUrl = route('user.payment.callback');
        $sign = '';
        $str = $email.$expiryPeriod.$merchantNo.$merchantOrderNo.$method.$mobile.$name.$notifyUrl.$payAmount.$redirectUrl;
        $sign = $this->sign($str);

        $response = Http::withoutVerifying()
        ->withOptions(["verify"=>false])
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post(env('FLASHPAY_BASE_URL_PROD').'/api/pay', [
            'email' => $email,
            'expiryPeriod' => $expiryPeriod,
            'merchantNo' => $merchantNo,
            'merchantOrderNo' => $merchantOrderNo,
            'method' => $method,
            'mobile' => $mobile,
            'name' => $name,
            'notifyUrl' => $notifyUrl,
            'payAmount' => $amount,
            'redirectUrl' => $redirectUrl,
            'sign' => $sign,
        ]);



        if($response->object() && $response->object()->status == "200")
        {
            try
            {
                session()->put('invest_id', $request->invest_id);
                session()->put('platOrderNo', $response->object()->data->platOrderNo);

                DB::table('flashpays')->insert([
                    'user_id' => Auth::user()->id,
                    'plan_id' => $plan->id,
                    'old_invest_id' => $request->invest_id,
                    'merchantOrderNo' => $response->object()->data->merchantOrderNo,
                    'platOrderNo' => $response->object()->data->platOrderNo,
                    'method' => $response->object()->data->method,
                    'accountNumber' => $response->object()->data->accountNumber,
                    'paymentUrl' => $response->object()->data->paymentUrl,
                    'payAmount' => $response->object()->data->payAmount,
                    'merchantFee' => $response->object()->data->merchantFee,
                    'description' => $response->object()->data->description,
                    'orderStatus' => "PENDING",
                    'orderMessage' => "Payment is Pending",
                    'created_at' => Carbon::now(),
                ]);
            }
            catch (\Exception $e)
            {
                return back()->with('error', 'Sever Error');
            }

            return redirect()->intended($response->object()->data->paymentUrl);
        }
        else
        {
            return back()->with('error', 'Server Error');
        }
    }



    public function payoutPreview()
    {
        $withdraw = PayoutLog::latest()->where('trx_id', session()->get('wtrx'))->where('status', 0)->latest()->with('method', 'user')->firstOrFail();
        $title = "Payout Form";

        if($withdraw['balance_type'] == 'balance'){
            $wallet =   auth()->user()->balance;
        }else{
            $wallet =   auth()->user()->interest_balance;
        }
        $remaining = getAmount($wallet - $withdraw->net_amount) ;
        return view($this->theme . 'user.payout.preview', compact('withdraw', 'title','remaining'));
    }

    public function payoutHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $payoutLog = PayoutLog::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('trx_id', 'LIKE', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('user', 'method')->paginate(config('basic.paginate'));
        $payoutLog->appends($search);

        $title = "Payout Log";
        return view($this->theme . 'user.payout.log', compact('title', 'payoutLog'));
    }

    public function referral()
    {
        $menu = 'Referral';
        $title = "My Referral";
        $referrals = getLevelUser($this->user->id);
        $transactions = $this->user->referralBonusLog()->latest()->with('bonusBy:id,firstname,lastname')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.referral', compact('menu', 'title', 'referrals', 'transactions'));
    }

    public function bonus_history()
    {
        $menu = 'Referral';
        $title = "Bonus History";
        $transactions = $this->user->referralBonusLog()->latest()->with('bonusBy:id,firstname,lastname,phone')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.bonus-history', compact('menu', 'title', 'transactions'));

    }

    public function referralBonus()
    {
        $title = "Referral Bonus";
        $transactions = $this->user->referralBonusLog()->latest()->with('bonusBy:id,firstname,lastname')->paginate(config('basic.paginate'));
        $referrals = getLevelUser($this->user->id);
        return view($this->theme . 'user.transaction.referral-bonus', compact('title', 'transactions'));
    }

    public function referralBonusSearch(Request $request)
    {
        $title = "Referral Bonus";
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $transaction = $this->user->referralBonusLog()->latest()
            ->with('bonusBy:id,firstname,lastname')
            ->when(isset($search['search_user']), function ($query) use ($search) {
                return $query->whereHas('bonusBy', function ($q) use ($search) {
                    $q->where(DB::raw('concat(firstname, " ", lastname)'), 'LIKE', "%{$search['search_user']}%")
                        ->orWhere('firstname', 'LIKE', '%' . $search['search_user'] . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $search['search_user'] . '%')
                        ->orWhere('username', 'LIKE', '%' . $search['search_user'] . '%');
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $transactions = $transaction->appends($search);

        return view($this->theme . 'user.transaction.referral-bonus', compact('title', 'transactions'));
    }

    public function moneyTransfer()
    {
        $page_title = "Balance Transfer";
        return view($this->theme . 'user.money-transfer', compact('page_title'));
    }

    public function moneyTransferConfirm(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'amount' => 'required',
            'wallet_type' => ['required', Rule::in(['balance', 'interest_balance'])],
            'password' => 'required'
        ], [
            'wallet_type.required' => 'Please Select a wallet'
        ]);

        $basic = (object)config('basic');
        $email = trim($request->email);

        $receiver = User::where('email', $email)->first();


        if (!$receiver) {
            session()->flash('error', 'This Email  could not Found!');
            return back();
        }
        if ($receiver->id == Auth::id()) {
            session()->flash('error', 'This Email  could not Found!');
            return back()->withInput();
        }

        if ($receiver->status == 0) {
            session()->flash('error', 'Invalid User!');
            return back()->withInput();
        }


        if ($request->amount < $basic->min_transfer) {
            session()->flash('error', 'Minimum Transfer Amount ' . $basic->min_transfer . ' ' . $basic->currency);
            return back()->withInput();
        }
        if ($request->amount > $basic->max_transfer) {
            session()->flash('error', 'Maximum Transfer Amount ' . $basic->max_transfer . ' ' . $basic->currency);
            return back()->withInput();
        }

        $transferCharge = ($request->amount * $basic->transfer_charge) / 100;

        $user = Auth::user();
        $wallet_type = $request->wallet_type;
        if ($user[$wallet_type] >= ($request->amount + $transferCharge)) {

            if (Hash::check($request->password, $user->password)) {


                $sendMoneyCheck = MoneyTransfer::where('sender_id', $user->id)->where('receiver_id', $receiver->id)->latest()->first();

                if (isset($sendMoneyCheck) && Carbon::parse($sendMoneyCheck->send_at) > Carbon::now()) {

                    $time = $sendMoneyCheck->send_at;
                    $delay = $time->diffInSeconds(Carbon::now());
                    $delay = gmdate('i:s', $delay);

                    session()->flash('error', 'You can send money to this user after  delay ' . $delay . ' minutes');
                    return back()->withInput();
                } else {

                    $user[$wallet_type] = round(($user[$wallet_type] - ($transferCharge + $request->amount)), 2);
                    $user->save();

                    $receiver[$wallet_type] += round($request->amount, 2);
                    $receiver->save();


                    $trans = strRandom();

                    $sendTaka = new MoneyTransfer();
                    $sendTaka->sender_id = $user->id;
                    $sendTaka->receiver_id = $receiver->id;
                    $sendTaka->amount = round($request->amount, 2);
                    $sendTaka->charge = $transferCharge;
                    $sendTaka->trx = $trans;
                    $sendTaka->send_at = Carbon::parse()->addMinutes(1);
                    $sendTaka->save();


                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = round($request->amount, 2);
                    $transaction->charge = $transferCharge;
                    $transaction->trx_type = '-';
                    $transaction->balance_type = $wallet_type;
                    $transaction->remarks = 'Balance Transfer to  ' . $receiver->email;
                    $transaction->trx_id = $trans;
                    $transaction->final_balance = $user[$wallet_type];
                    $transaction->save();


                    $transaction = new Transaction();
                    $transaction->user_id = $receiver->id;
                    $transaction->amount = round($request->amount, 2);
                    $transaction->charge = 0;
                    $transaction->trx_type = '+';
                    $transaction->balance_type = $wallet_type;
                    $transaction->remarks = 'Balance Transfer From  ' . $user->email;
                    $transaction->trx_id = $trans;
                    $transaction->final_balance = $receiver[$wallet_type];
                    $transaction->save();


                    session()->flash('success', 'Balance Transfer  has been Successful');
                    return redirect()->route('user.money-transfer');
                }
            } else {
                session()->flash('error', 'Password Do Not Match!');
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Saldo tidak mencukupi.');
            return back()->withInput();
        }
    }

    public function verificationSubmit(Request $request)
    {
        $identityFormList = IdentifyForm::where('status', 1)->get();
        $rules['identity_type'] = ["required", Rule::in($identityFormList->pluck('slug')->toArray())];
        $identity_type = $request->identity_type;
        $identityForm = IdentifyForm::where('slug', trim($identity_type))->where('status', 1)->firstOrFail();

        $params = $identityForm->services_form;

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('identity', '1');

            return back()->withErrors($validator)->withInput();
        }


        $path = config('location.kyc.path').date('Y').'/'.date('m').'/'.date('d');
        $collection = collect($request);

        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $this->uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    session()->flash('error', 'Could not upload your ' . $inKey);
                                    return back()->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
        }

        try {

            DB::beginTransaction();

            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = $identityForm->slug;
            $kyc->details = $reqField;
            $kyc->save();

            $user->identity_verify =  1;
            $user->save();

            if(!$kyc){
                DB::rollBack();
                $validator->errors()->add('identity', '1');
                return back()->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'KYC request has been submitted.');

        } catch (\Exception $e) {
            return redirect()->route('user.profile')->withErrors($validator)->with('error', $e->getMessage());
        }
    }

    public function addressVerification(Request $request)
    {

        $rules = [];
        $rules['addressProof'] = ['image','mimes:jpeg,jpg,png', 'max:2048'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('addressVerification', '1');
            return back()->withErrors($validator)->withInput();
        }

        $path = config('location.kyc.path').date('Y').'/'.date('m').'/'.date('d');

        $reqField = [];
        try {
            if($request->hasFile('addressProof')){
                $reqField['addressProof'] = [
                    'field_name' => $this->uploadImage($request['addressProof'], $path),
                    'type' => 'file',
                ];
            }else{
                $validator->errors()->add('addressVerification', '1');

                session()->flash('error', 'Please select a ' . 'address Proof');
                return back()->withInput();
            }
        } catch (\Exception $exp) {
            session()->flash('error', 'Could not upload your ' . 'address Proof');
            return redirect()->route('user.profile')->withInput();
        }

        try {

            DB::beginTransaction();
            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = 'address-verification';
            $kyc->details = $reqField;
            $kyc->save();
            $user->address_verify =  1;
            $user->save();

            if(!$kyc){
                DB::rollBack();
                $validator->errors()->add('addressVerification', '1');
                return redirect()->route('user.profile')->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'Your request has been submitted.');

        } catch (\Exception $e) {
            $validator->errors()->add('addressVerification', '1');
            return redirect()->route('user.profile')->with('error', $e->getMessage())->withErrors($validator);
        }
    }

    public function planList()
    {

        $data['menu'] = 'Plan';

        if (auth()->user()) {
            $data['extend_blade'] = $this->theme . 'layouts.user';
        } else {
            $data['extend_blade'] = $this->theme . 'layouts.app';
        }

        $data['plans'] = ManagePlan::where('status', 1)->get();

        $templateSection = ['investment', 'calculate-profit', 'faq', 'we-accept', 'deposit-withdraw'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['investment', 'calculate-profit', 'faq', 'we-accept', 'deposit-withdraw'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        session()->forget('amount');
        session()->forget('plan_id');

        return view($this->theme . 'user.plan', $data);

    }

    public function level($level){

        $menu = 'Referral';
        $title = "Member Details";

        if($level == '1'){
            $data = LevelOneMemberAllDetails(auth()->user()->id);
            $total = LevelOneTotal(Auth::id());
            $active = LevelOneMember(Auth::id());
        }
        elseif($level == '2'){
            $data = LevelTwoMemberAllDetails(auth()->user()->id);
            $total = LevelTwoTotal(Auth::id());
            $active = LevelTwoMember(Auth::id());
        }
        elseif($level == '3'){
            $data = LevelThreeMemberAllDetails(auth()->user()->id);
            $total = LevelThreeTotal(Auth::id());
            $active = LevelThreeMember(Auth::id());
        }
        return view($this->theme . 'user.member-details', compact('total','active','menu','title','level', 'data'));
    }
}