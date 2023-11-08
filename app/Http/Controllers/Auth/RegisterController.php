<?php

namespace App\Http\Controllers\Auth;

use App\Http\Traits\Notify;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Facades\App\Services\BasicService;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use Notify;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (config('basic.registration') == 0) {
            return redirect('/')->with('warning', 'Platform akan segera launching');
        }

        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code  = null;
        if(!empty($info['code'])){
        $country_code = @$info['code'][0];
        }
        $countries = config('country');

        return view(template().'auth.register',compact('country_code','countries'));
    }

    public function sponsor($sponsor)
    {
        if (config('basic.registration') == 0) {
            return redirect('/')->with('warning', 'Platform akan segera launching');
        }

        session()->put('sponsor', $sponsor);
        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code  = null;
        if(!empty($info['code'])){
            $country_code = @$info['code'][0];
        }
        $countries = config('country');

        return view(template().'auth.register', compact('sponsor', 'countries','country_code'));

    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:91'],
            'lastname' => ['required', 'string', 'max:91'],
            'phone' => ['required', 'min:6', 'max:14', 'unique:users,phone'],
            'password' => ['required', 'min:6', 'max:20', 'confirmed'],
            'captcha' => ['required','valid_captcha'],
        ],
        [
            'firstname.required' => "Bidang nama depan wajib diisi.",
            'firstname.string' => "Nama depan harus berupa string.",
            'firstname.max' => "Nama depan tidak boleh lebih dari 91 karakter.",
            'lastname.required' => "Bidang nama keluarga wajib diisi.",
            'lastname.string' => "Nama keluarga harus berupa string.",
            'lastname.max' => "Nama keluarga tidak boleh lebih dari 91 karakter.",
            'phone.required' => "Bidang nomor telepon wajib diisi.",
            'phone.min' => "Nomor telepon minimal harus 6 karakter.",
            'phone.max' => "Nomor telepon tidak boleh lebih dari 14 karakter.",
            'phone.unique' => "Telepon sudah diambil.",
            'password.required' => "Bidang kata sandi wajib diisi.",
            'password.min' => "Kata sandi minimal harus 6 karakter.",
            'password.max' => "Kata sandi tidak boleh lebih dari 20 karakter.",
            'password.confirmed' => "Konfirmasi kata sandi tidak cocok.",
            'captcha.required' => "Bidang Captcha telepon wajib diisi.",
            'captcha.captcha' => "Captchanya tidak cocok.",
        ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $basic = (object) config('basic');

        $sponsor = session()->get('sponsor');
        if ($sponsor != null) {
            $sponsorId = User::where('username', $sponsor)->first();
        } elseif(isset($data['sponsor'])){
            $sponsorId = User::where('username', $data['sponsor'])->first();
        }
        else {
            $sponsorId = null;
        }

        $user =   User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => strRandom(6),
            'referral_id' => ($sponsorId != null) ? $sponsorId->id : null,
            'country_code' => '62',
            'phone_code' => '62',
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'email_verification' => 1,
            'sms_verification' => 1,
        ]);
        return $user;

    }

    public function register(Request $request)
    {
        // dd($request->all());
        
        // $smsVerification = 0;
        // $basic = (object) config('basic');

        // $sponsor = session()->get('sponsor');
        // if ($sponsor != null) {
        //     $sponsorId = User::where('username', $sponsor)->first();
        // } else {
        //     $sponsorId = null;
        // }

        // $this->validator($request->all())->validate();
        // $verificationCode = VerificationCode::where('phone',$request->phone)->where('code',$request->verification_code)->where('status',1)->first();
        // if(!empty($verificationCode)){
        //     $verificationCode->status = 0;
        //     $verificationCode->save();
        //     $smsVerification = 1;
        // }
        // else{
        //     return redirect()->back()->with('error','OTP tidak valid');
        // }
        
        // $request->offsetUnset('verification_code');
        
        
        // $user =   User::create([
        //     'firstname' => $request->firstname,
        //     'lastname' => $request->lastname,
        //     'username' => $request->username,
        //     'email' => $request->email,
        //     'referral_id' => ($sponsorId != null) ? $sponsorId->id : null,
        //     'country_code' => $request->country_code,
        //     'phone_code' => $request->phone_code,
        //     'phone' => $request->phone,
        //     'password' => Hash::make($request->password),
        //     'email_verification' => ($basic->email_verification) ? 0 : 1,
        //     // 'sms_verification' => ($basic->sms_verification) ? 0 : 1,
        //     'sms_verification' => $smsVerification,
        // ]);



        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        
        $msg = [
            'username' => $user->username,
        ];
        $action = [
            "link" => route('admin.user-edit',$user->id),
            "icon" => "fas fa-user text-white"
        ];

        $this->adminPushNotification('ADDED_USER', $msg, $action);

        $this->guard()->login($user);


        session()->forget('sponsor');

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        if($request->ajax()) {
            return route('user.home');
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->save();

        $basic = (object) config('basic');

        if ($basic->joining_bonus == 1) {
            $amount = $basic->bonus_amount;
            $user->balance += $amount;
            $user->save();
            $remarks = 'Bonus Registrasi';
            BasicService::makeTransaction($user, getAmount($amount), 0, '+', $balance_type = 'deposit', strRandom(), $remarks);
        }

    }

    protected function guard()
    {
        return Auth::guard();
    }

}