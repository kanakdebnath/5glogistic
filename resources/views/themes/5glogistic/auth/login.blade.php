@extends($theme.'layouts.5glogistic')
@push('head')
<link rel="stylesheet" href="{{asset('assets/frontend/styles/login.css')}}" />
@endpush

@section('content')

    <header></header>

    <section class="overflow-hidden">
      <div class="row">
        <button class="col border-0 bg-warning p-3 px-0 position-relative">
          <a
            class="fs-5 fw-bold text-decoration-none text-dark d-block"
            href="#"
            >@lang('Login')
            <i
              style="bottom: -10px; color: black"
              class="fa-solid fa-diamond position-absolute start-0 end-0"
            ></i>
          </a>
        </button>
        <button class="col border-0 bg-warning p-3 px-0">
          <a class="fs-5 text-decoration-none text-secondary d-block" href="{{ route('register') }}"
            >@lang('Register')</a
          >
        </button>
      </div>

      <form action="{{route('login')}}" method="post" id="login-form">
        @csrf
      <div class="px-3 py-4">
        <p class="text-white mb-1">@lang('Phone number')</p>
        <div class="position-relative">
          <span class="text-white position-absolute" style="bottom: 8px"
            >+92</span
          >
          <input type="number" name="phone" pattern="[0-9]*" id="moblie"
          oninput="if(value.length>14)value=value.slice(0,14)"
            class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-left"
            placeholder="@lang('Enter phone number')"
          />

          @error('phone')
            <small class="text-danger">@lang($message)</small>
            @enderror
        </div>
        <p class="text-white mb-1 mt-3">@lang('Password')</p>
        <div class="position-relative">
          <span onclick="showPass()" class="text-white position-absolute end-0" style="bottom: 8px"
            ><i class="fa-regular fa-eye-slash text-secondary"></i
          ></span>
          <input id="password"
            class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
            type="password" name="password"
            placeholder="@lang('Enter password')"
          />
          @error('password')
              <small class="text-danger">@lang($message)</small>
          @enderror
        </div>

        <button
          class="bg-warning w-100 fs-5 fw-bold text-dark rounded-5 border-0 p-2 my-5"
        >
        @lang('Login')
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
{{-- @extends($theme.'layouts.app')
@section('title','Login')


@section('content')
<section id="about-us" class="about-page secbg-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-block py-5">
                    <form class="login-form" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="signin">
                            <h3 class="title mb-30">@lang('Login Form')</h3>

                            <div class="form-group mb-30">
                                <input class="form-control" type="text" name="username"
                                    placeholder="@lang('Email Or Username')">
                                @error('username')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                @error('email')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group mb-20">
                                <input class="form-control" type="password" name="password"
                                    placeholder="@lang('Password')">
                                @error('password')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div
                                class="remember-me d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mb-30">
                                <div class="checkbox custom-control custom-checkbox mt-10">
                                    <input id="remember" type="checkbox" class="custom-control-input" name="remember" {{
                                        old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">@lang('Remember Me')</label>
                                </div>
                                <a class="text-white mt-10" href="{{ route('password.request') }}">@lang("Forgot
                                    password?")</a>
                            </div>

                            <div class="btn-area">
                                <button class="btn-login login-auth-btn"
                                    type="submit"><span>@lang('Login')</span></button>
                            </div>

                            <div class="login-query mt-30 text-center">
                                <a href="{{ route('register') }}">@lang("Don't have any account? Sign Up")</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="connectivity wow fadeIn" data-wow-duration="1s" data-wow-delay="0.35s">
                    <div class="d-flex align-items-center justify-content-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection --}}
