@extends($theme.'layouts.5glogistic')
@push('head')
<link rel="stylesheet" href="{{asset('assets/frontend/styles/register.css')}}" />
<link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
@endpush

@section('content')

    <header></header>

    <section class="overflow-hidden">
        <div class="row">
          <button class="col border-0 bg-warning p-3 px-0">
            <a
              class="fs-5 text-decoration-none text-secondary d-block"
              href="{{ route('login') }}"
              >@lang('Login')</a
            >
          </button>
          <button class="col border-0 bg-warning p-3 px-0 position-relative">
            <a
              class="fs-5 fw-bold text-decoration-none text-dark d-block"
              href="#"
              >Register
              <i
                style="bottom: -10px; color: black"
                class="fa-solid fa-diamond position-absolute start-0 end-0"
              ></i>
            </a>
          </button>
        </div>

        <form class="register-form" action="{{ route('register') }}" method="post">
            @csrf

  
        <div class="px-3 py-4">

            <p class="text-white mb-1 mt-3">@lang('First Name')</p>
            <div >
                <input id="firstname" name="firstname" 
                class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
                type="password"
                placeholder="@lang('First Name')"
                />
                @error('firstname')
                <small class="text-danger">@lang($message)</small>
                @enderror
            </div>

            <p class="text-white mb-1 mt-3">@lang('Last Name')</p>
            <div >
                <input id="lastname" name="lastname" 
                class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
                type="password"
                placeholder="@lang('Last Name')"
                />
                @error('lastname')
                <small class="text-danger">@lang($message)</small>
                @enderror
            </div>

          <p class="text-white mb-1">@lang('Phone number')</p>
          <div class="position-relative">
            <span class="text-white position-absolute" style="bottom: 8px"
              >+92</span
            >
            <input name="phone" id="phone"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-left"
              type="text"
              placeholder="@lang('Enter phone number')"
            />
            <input type="hidden" name="phone_code" value="+62">
            <input type="hidden" name="country_code" value="+62">

            @error('phone')
            <small class="text-danger">@lang($message)</small>
            @enderror
          </div>
          <p class="text-white mb-1 mt-3">@lang('Kata Sandi')</p>
          <div class="position-relative">
            <span class="text-white position-absolute end-0" style="bottom: 8px"
              ><i class="fa-regular fa-eye-slash text-secondary"></i
            ></span>
            <input name="password"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="password"
              placeholder="@lang('Kata Sandi')"
            />
            @error('password')
            <small class="text-danger">@lang($message)</small>
            @enderror
          </div>


          <p class="text-white mb-1 mt-3">@lang('Konfirmasi Kata Sandi')</p>
          <div class="position-relative">
            <span class="text-white position-absolute end-0" style="bottom: 8px"
              ><i class="fa-regular fa-eye-slash text-secondary"></i
            ></span>
            <input name="password_confirmation"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="password"
              placeholder="@lang('Konfirmasi Kata Sandi')"
            />
            @error('password_confirmation')
                <small class="text-danger">@lang($message)</small>
                @enderror
          </div>

          

          <p class="text-white mb-1 mt-3">@lang('Input captcha')</p>
          <div class="position-relative">

            <span  class=" position-absolute end-0" style="bottom: 8px">
                {!! captcha_image_html('RegisterCaptcha') !!}
            </span>
            <input name="captcha"  id="CaptchaCode"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="text"
              placeholder="@lang('Input captcha')"
            />
          </div>
          <p class="text-white mb-1 mt-3">@lang('Optional')</p>
          <div>
            <input name="sponsor"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white ps-0"
              type="number"
              placeholder="@lang('Invitation code')"
            />
          </div>
  
          <button class="bg-warning w-100 fs-5 fw-bold text-dark rounded-5 border-0 p-2 my-5">
            @lang('Register') 
        </button>
        </div>

    </form>


        <div class="row border-top border-secondary pt-1">
            <a href="#" class="text-decoration-none text-white h5 text-center">
              <img src="{{asset('assets/frontend/images/icons/file.png')}}" width="50" alt="" /><span
                class="ms-2"
                >@lang('Download app')</span
              >
            </a>
          </div>
      </section>


@endsection
@push('script')
<script>
    function showPass() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    </script>
@endpush
