@extends($theme.'layouts.app')
@section('title',trans('Confirm Password'))

@section('content')

<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-inputs">
                 <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
                <form action="{{ route('password.confirm') }}" method="post">
                    @csrf

                <div class="form-group has-search mb-3">

                    <label for="exampleFormControlInput1" class="form-label">@lang('Password')</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="@lang('Password')">
                    <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    @error('password')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <center>
                    <button type="submit" class="btn btn-primary">@lang('Forgot Your Password?')</button>
                </center>

                @if (Route::has('password.request'))
                <div class="form-bottom">
                    <p class="text-center m-0">
                        <a href="{{ route('password.request') }}">@lang('Forgot Your Password?')</a>
                    </p>
                </div>
            @endif
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

