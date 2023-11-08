@extends('layouts.app')
@section('title', @lang('Email Verify'))

@section('content')


<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <h1>@lang('Mulai Langkah Investasi Dengan Platform Kami')</h1>
                        <p>@lang('Nikmati segala kemudahan dan penarikan instan.')</p>
                <h2>@lang('Email Verify')</h2>
            </div>
        </div>
    </div>
</div>
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->
<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 profile-inputs">
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf

                    <div class="form-body">
                        <div class="col-md-12 mb-3">
                            {{ lang('Before proceeding, please check your email for a verification link.') }}
                            {{ lang('If you did not receive the email') }},
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary">@lang('click here to request another')</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ========================= SIGNIN SECTION END HERE ====================== -->

@endsection

