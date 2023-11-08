@extends($theme.'layouts.app')
@section('title',trans('Setel Password'))


@section('content')

<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-inputs">
                <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
                <form action="{{route('password.update')}}" method="post">
                    @csrf
                    @error('token')
                    <div class="col-md-12 px-5">
                        <div class="alert alert-danger" role="alert">
                            {{ trans($message) }}
                        </div>
                    </div>
                    @enderror

                <div class="form-group has-search mb-3">
                    <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                    <label for="exampleFormControlInput1" class="form-label">@lang('Kata Sandi Baru')</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="@lang('Kata Sandi Baru')">
                    <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    @error('password')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Konfirmasi Kata Sandi')</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input name="password_confirmation" id="password-field1" type="password" class="form-control" placeholder="@lang('Konfirmasi Kata Sandi')">
                    <span toggle="#password-field1" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    @error('password_confirmation')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary">@lang('Konfirmasi')</button>
                </center>
                <center>
                    <img src="{{asset('assets/frontend/intan/img/ojk.png')}}" style="height: 30px;" />
                </center>
            </div>
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
</script>
@endpush
