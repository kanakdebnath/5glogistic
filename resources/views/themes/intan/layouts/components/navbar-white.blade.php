<nav class="navbar navbar-expand-lg uni-padding">
    <div class="container-fluid">
        <a href="{{route('home')}}" class="navbar-brand mx-auto p-0">
            <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 60px;" />
        </a>
        @auth
        <button class="navbar-toggler position-absolute" style="right: 27px;" type="button" onclick="document.getElementById('logout-form').submit();">
            <span class="bi bi-box-arrow-right"></span>
        </button>
        <form action="{{route('logout')}}"  method="post" id="logout-form" style="display: none !important;">
            @csrf
        </form>
        @endauth
        {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('home')}}">@lang('Home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('promotion')}}">@lang('Promotion')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.referral')}}">@lang('Referral')</a>
                </li>
            </ul>
            <img src="{{asset('assets/frontend/images/logo.png')}}" width="50" class="img-fluid">
        </div> --}}
    </div>
</nav>
