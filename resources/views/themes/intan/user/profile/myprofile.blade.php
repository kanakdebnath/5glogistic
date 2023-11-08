@extends($theme.'layouts.user')
@section('title',trans('Ubah Profil'))
@section('content')
@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/changeProfile.css')}}">
@endpush


<!-- BEGIN: JEWLERY HEADER SECTION -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
            </div>
        </div>
    </div>
</div>
<!-- END: JEWLERY HEADER SECTION -->


<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid changePass-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.home')}}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah Profil & Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TABS SECTION START HERE ====================== -->
<div class="container-fluid" style="margin-bottom: 90px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabset">
                    <!-- Tab 1 -->
                    <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                    <label for="tab1">Ubah Profil</label>
                    <!-- Tab 2 -->
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                    <label for="tab2" class="chngePass-tab">Ubah Password</label>

                    <div class="tab-panels">
                        <section id="marzen" class="tab-panel profile-inputs">
                            <form class="register-form" method="post" action="{{ route('user.updateInformation')}}">
                                @method('put')
                                @csrf
                                <input type="hidden" name="language_id" value="1">
                            <h2>@lang('Ubah Profil')</h2>
                             <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Username') :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" style="background-color: #cccccc;" name="username" class="form-control" id="username" placeholder="@lang('Username')" value="{{old('username')?: $user->username }}" disabled>
                            </div>
                            @if($errors->has('username'))
                                    <span class="text-danger">@lang($errors->first('username')) </span>
                                @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Email'):</label>
                                <i class="fa-solid fa-envelope pro-icon"></i>
                                <input type="email" style="background-color: #cccccc;" name="email" class="form-control" id="email" placeholder="@lang('Email Address')" value="{{old('email')?: $user->email }}" disabled>
                            </div>
                            @if($errors->has('email'))
                                    <span class="text-danger">@lang($errors->first('email')) </span>
                                @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('First Name') :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" name="firstname" class="form-control" placeholder="@lang('First Name')" value="{{old('firstname')?: $user->firstname }}" required>
                            </div>
                            @if($errors->has('firstname'))
                                    <span class="text-danger">@lang($errors->first('firstname')) </span>
                                @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Last Name') :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="@lang('Last Name')" value="{{old('lastname')?: $user->lastname }}" required>
                            </div>
                            @if($errors->has('lastname'))
                                    <span class="text-danger">@lang($errors->first('lastname')) </span>
                                @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Nomor HP') :</label>
                                <i class="fa-solid fa-phone pro-icon"></i>
                                <input type="text" class="form-control" id="phone" style="background-color: #cccccc;" placeholder="Phone Number" value="{{old('phone')?: $user->phone }}" readonly>
                            </div>
                            @if($errors->has('phone'))
                            <span class="text-danger">@lang($errors->first('phone')) </span>
                        @endif
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">@lang('Address') :</label>
                                <textarea name="address" class="form-control textarea-sec" id="address" cols="30" rows="3">{{old('address')?: $user->address }}</textarea>
                            </div>
                            @if($errors->has('address'))
                                    <span class="text-danger">@lang($errors->first('address'))</span>
                                @endif
                            <center>
                                <button type="submit" class="btn btn-primary">@lang('Update Profile')</button>
                            </center>
                        </form>
                        </section>
                        <section id="rauchbier" class="tab-panel profile-inputs">
                            <form class="register-form" method="post" action="{{ route('user.updatePassword') }}">
                                @csrf

                            <h2>@lang('Change Password')</h2>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Current Password') :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="current_password" class="form-control" id="old-password" placeholder="@lang('Current Password')" required>
                            </div>
                            @if($errors->has('current_password'))
                                    <span class="text-danger">@lang($errors->first('current_password')) </span>
                                @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('New Password') :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="password" class="form-control" id="password-field" placeholder="@lang('New Password')" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                            </div>
                            @if($errors->has('password'))
                            <span class="text-danger">@lang($errors->first('password')) </span>
                        @endif
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Confirm Password') :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="password_confirmation" class="form-control" id="password-field1" placeholder="@lang('Confirm Password')" required>
                                <span toggle="#password-field1" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                            </div>
                            @if($errors->has('password_confirmation'))
                                    <span class="text-danger">@lang($errors->first('password_confirmation')) </span>
                                @endif
                            <center>
                                <button type="submit" class="btn btn-primary">@lang('Ubah Password')</button>
                            </center>
                        </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================= TABS SECTION END HERE ====================== -->
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