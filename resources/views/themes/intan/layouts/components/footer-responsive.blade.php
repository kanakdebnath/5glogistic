<div class="ro ni-padding" style="position: fixed !important; bottom: 0 !important; width: 100%; z-index: 99 !important;">
    <div class="col-md-12">
        <div id="footer-2" class="ps-0 pe-0">
            <a href="{{route('home')}}" class="footer-item-2 @if(isset($menu) && $menu == 'Home') footer-active @endif">
                <div><img src="{{asset('assets/frontend/images/home-ic.png')}}" alt="">
                <p>@lang('Home')</p></div>
            </a>

            <a href="{{route('user.referral')}}" class="footer-item-2 @if(isset($menu) && $menu == 'Referral') footer-active @endif">
                <div><img src="{{asset('assets/frontend/images/team.png')}}" alt="">
                <p>@lang('Referral')</p></div>
            </a>
            
            <a href="https://play.google.com/store/apps/details?id=com.app.geaindonesia"  class="footer-item-2 @if(isset($menu) && $menu == 'APK') footer-active @endif">
                <div><img src="{{asset('assets/frontend/images/gplay.png')}}" alt="">
                <p>@lang('APK')</p></div>
            </a>

            <a href="{{route('user.home')}}" class="footer-item-2 @if(isset($menu) && $menu == 'Account') footer-active @endif">
                <div><img src="{{asset('assets/frontend/images/dbuser.png')}}" alt="">
                <p>@lang('Dashboard')</p></div>
            </a>
        </div>
    </div>
</div>
