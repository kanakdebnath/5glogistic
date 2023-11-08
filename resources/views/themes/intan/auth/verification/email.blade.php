@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')

<!-- Navbar  -->
@include('themes.darkgray.layouts.components.navbar-with-background')

<div id="login-page">

    <!-- login-Form -->

    <div class="container">
        <div class="row">

        </div>
    </div>

    <div class="login-form uni-padding">

        <form action="{{route('user.mailVerify')}}" method="post">
            @csrf
            <div class="col-md-12 mx-5">
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif
            </div>
            <div class="wellcome">
                <h2>@lang('Wellcome')</h2>
                <p>@lang($page_title)</p>
            </div>
            <div class="form-body">
                <div class="col-md-12 mb-3">
                    <label for="code" class="form-label">@lang('Code')</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                        <input type="text" name="code" value="{{old('code')}}" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="@lang('Code')" required>
                    </div>
                    @error('code')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                    @error('error')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                </div>

                <button type="submit" value="Login" class="btn form-btn">@lang('Submit')</button>

            </div>
            <div class="form-bottom">
                <p class="text-center m-0">
                    @lang('Didn\'t get Code? Click to')
                    <a href="{{route('user.resendCode')}}?type=email">@lang('Resend code')</a>
                    <br>
                    @error('resend')
                        <small class="text-danger mt-1">{{ $message }}</small>
                    @enderror
                </p>
            </div>
        </form>
    </div>

    <br>
    <br>

    <!-- Footer  -->
    @include('themes.darkgray.layouts.components.footer-responsive')

</div>

@endsection

