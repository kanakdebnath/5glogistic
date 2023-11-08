@extends($theme.'layouts.app')
@section('title','Pendaftaran')

@section('content')



<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <form class="register-form" action="{{ route('register') }}" method="post">
                @csrf
            <div class="col-md-12 profile-inputs">
                 <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Username')</label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input name="username" id="username" type="text" class="form-control" placeholder="@lang('Username')">
                    @error('username')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                 <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Email')</label>
                    <i class="fa-solid fa-envelope pro-icon"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="@lang('Email')" disabled>
                    @error('email')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('First Name')</label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="@lang('First Name')" disabled>
                    @error('firstname')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Last Name')</label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="@lang('Last Name')" disabled>
                    @error('lastname')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Nomor HP')</label>
                    <i class="fa-solid fa-phone pro-icon"></i>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="@lang('08xxxxxxx')" disabled>
                    <input type="hidden" name="phone_code" value="+62">
                            <input type="hidden" name="country_code" value="+62">
                    @error('phone')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Kata Sandi')</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="@lang('Kata Sandi')" disabled>
                    <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    @error('password')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Confirm Password')</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input name="password_confirmation" id="password-field1" type="password" class="form-control" placeholder="@lang('Konfirmasi Kata Sandi')" disabled>
                    <span toggle="#password-field1" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    @error('password_confirmation')
                        <small class="text-danger">@lang($message)</small>
                        @enderror
                </div>
                
                <div class="form-group has-search mb-3">
                    <div class="row">
                        <div class="col-8">
                            <label for="exampleFormControlInput1" class="form-label">@lang('Kode OTP')</label>
                            <i class="fa-solid fa-key pro-icon"></i>
                            <input name="verification_code" type="number" id="verificationCode" class="form-control" placeholder="@lang('Kirim Kode')" disabled>
                            <small class="text-success" id="verificationMsg"></small>        
                        </div>
                        <div class="col-4" style="margin-top:26px;">
                            <button type="button" class="btn btn-primary" onClick="sendCode($(this))" id="send_code" disabled>Kirim Code</button>
                            <small id="timer_div"></small>
                        </div>
                    </div>
                    
                </div>
                
                               <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary" id="signup" disabled>@lang('Sign Up')</button>
                </center>
                <p>Sudah Memiliki Akun ? <a href="{{ route('login') }}"><span> Login</span></a></p>
                 <center>
                    <img src="{{asset('assets/frontend/intan/img/ojk.png')}}" style="height: 30px;" />
                </center>
                <br>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- ========================= SIGNIN SECTION END HERE ====================== -->
@endsection


@push('scripts')
<script>
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    
    $("#username").keyup(function(){
        $("#email").attr('disabled',false);
    });
    $("#email").keyup(function(){
        $("#firstname").attr('disabled',false);
    });
    $("#firstname").keyup(function(){
        $("#lastname").attr('disabled',false);
    });
    $("#lastname").keyup(function(){
        $("#phone").attr('disabled',false);
    });
    $("#phone").keyup(function(){
        $("#password-field").attr('disabled',false);
    });
    $("#password-field").keyup(function(){
        $("#password-field1").attr('disabled',false);
    });
    $("#password-field1").keyup(function(){
        $("#send_code").attr('disabled',false);
    });
    function sendCode(elm){
        var verificationCode = $("#verificationCode").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        if(verificationCode == ""){
            $("#verificationCode").attr('disabled',false);
            $("#verificationMsg").html('');
            $("#send_code").attr('disabled',true);
            $.ajax({
                type : "GET",
                url  : "{{route('verificationCode')}}",
                data : {
                    'phone'  : phone,
                    'email'  : email,
                    'verificationCode' : verificationCode,
                },
                beforeSend : function(res){
                    $("#send_code").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>');
                },
                success : function(res){
                    timer(25);
                    $("#send_code").html('Send Code');
                    if(res.success == true){ 
                        $("#signup").attr('disabled',false);
                        $("#verificationMsg").html('Kode OTP Telah dikirim');
                    }
                    else{
                        $("#signup").attr('disabled',true);
                        $("#verificationMsg").html('Nomor HP Salah');
                    }
                },
                error   : function(res){
                    $("#signup").attr('disabled',false);
                    timer(25);
                    $("#send_code").html('Kirim Code');
                }
                
            });    
        }
        else{
            // $("#verificationMsg").html('Code is required');
        }
        
    }

    function timer(time){
       var timeLeft = 60;
      //   var timeLeft = 10;
      var elem = document.getElementById("send_code");
      var timerId = setInterval(countdown, 1000);
      function countdown() {
        if (timeLeft == 0) {
          clearTimeout(timerId);
          $("#send_code").html('Send Code');
          $("#send_code").attr('disabled',false);
        } else {
          elem.innerHTML = timeLeft;
          timeLeft--;
        }
      }
      
    }
    

  
</script>
@endpush

