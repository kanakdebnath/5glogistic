@extends($theme.'layouts.app')
@section('title','Halaman Login')

@section('content')



<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <form action="{{ route('login') }}" method="post">
                @csrf
            <div class="col-md-12 profile-inputs">
                <div class="form-group has-search mb-3">
                     <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
                    <label for="exampleFormControlInput1" class="form-label">@lang('Username')</label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" name="username" class="form-control" placeholder="@lang('Username')">

                    @error('username')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                    @error('email')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password :</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" type="password" name="password" class="form-control" placeholder="******">
                    <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>

                    @error('password')
                        <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        @lang('Remember Me')
                    </label>
                    <span><a href="{{ route('password.request') }}">@lang("Forgot password?")</a> </span>
                </div>
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary">Login</button>
                </center>
               
                <p>Belum Bergabung ?<a href="{{ route('register') }}"><span> Daftar</span></a></p>
                 <center>
                    <img src="{{asset('assets/frontend/intan/img/ojk.png')}}" style="height: 30px;" />
                </center>
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
</script>
@endpush
