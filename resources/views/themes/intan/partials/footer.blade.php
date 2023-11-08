
    <!--=============== NAVBAR ===============-->
    <nav class="menu">
        <input type="radio" name="menu" id="one" checked>
        <input type="radio" name="menu" id="two">
        <input type="radio" name="menu" id="three">
        <input type="radio" name="menu" id="four">
        <div class="list">
            <div class="link-wrap">
                <label for="one">
                <!-- <i class="material-icons">home</i> -->
                <a href="{{route('home')}}"><img src="{{asset('assets/frontend/intan/img/home.png')}}" alt="" /></a>
                <span>Awal</span>
            </label>
            <label for="two">
                <!-- <i class="material-icons">settings</i> -->
                <a href="https://play.google.com/store/apps/details?id=com.apps.perhiasanintan"><img src="{{asset('assets/frontend/intan/img/play-store.png')}}" alt=""></a>
                <span>Aplikasi</span>
            </label>
                <label for="three">
                <!-- <i class="material-icons">cloud_upload</i> -->
                <a href="{{route('user.referral')}}"><img src="{{asset('assets/frontend/intan/img/add-user.png')}}" alt=""></a>
                <span>Referral</span>
            </label>
                <label for="four">
                <!-- <i class="material-icons">settings</i> -->
                <a href="{{route('user.home')}}"><img src="{{asset('assets/frontend/intan/img/dashboard.png')}}" alt=""></a>
                <span>Dashboard</span>
            </label>
            </div>
        </div>
    </nav>