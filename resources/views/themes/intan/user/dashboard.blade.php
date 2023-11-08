@extends($theme.'layouts.user')
@section('title',trans('Beranda'))

@section('content')
@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/style1.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/home.css')}}">
@endpush

 <header class="jewlery-header">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                         <div class="banner">
                         <img src="{{asset('assets/frontend/images/Profileicon.png')}}" style="height:110px"; alt="">
                            <h1>{{Auth::user()->fullname}}</h1>
                             <p>{{Auth::user()->email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
<center>
                             <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                          </center>
<!-- ================== DASHBOARD BUTTON SECTION START HERE ===================== -->
<div class="container">
    <div class="btn-sec">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="{{route('user.paymentmethods.list')}}">
                    <button>
                        <img src="{{asset('assets/frontend/intan/img/banner-btn-5.jpg')}}" alt="">
                        @lang('Payment Methods')
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="{{route('user.payout.money')}}">
                    <button>
                        <img src="{{asset('assets/frontend/intan/img/banner-btn-4.jpg')}}" alt="">
                        @lang('Withdraw Money')
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="{{route('user.transaction')}}">
                    <button>
                        <img src="{{asset('assets/frontend/intan/img/banner-btn-2 .jpg')}}" alt="">
                        @lang('Transactions')
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="{{route('user.profile')}}">
                    <button>
                    <img src="{{asset('assets/frontend/intan/img/banner-btn-1.jpg')}}" alt="">
                    @lang('Profile')
                </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="https://play.google.com/store/apps/details?id=com.apps.perhiasanintan">
                <button>
                    <img src="{{asset('assets/frontend/intan/img/banner-btn-3.jpg')}}" alt="">
                    @lang('Unduh APK')
                </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="{{asset('assets/upload/company.pdf')}}" download>
                <button>
                    <img src="{{asset('assets/frontend/intan/img/banner-btn-8.jpg')}}" alt="">
                    @lang('Panduan')
                </button>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="https://t.me/perhiasanintandiscussion">
                <button>
                    <img src="{{asset('assets/frontend/intan/img/banner-btn-9.jpg')}}" alt="">
                    @lang('Grup Resmi')
                </button>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <button onclick="document.getElementById('logout-form').submit();">
                        <img src="{{asset('assets/frontend/intan/img/banner-btn-6.jpg')}}" alt="">
                        @lang('Log Out')

                    <form action="{{route('logout')}}"  method="post" id="logout-form" style="display: none !important;">
                        @csrf
                    </form>
                    
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================== DASHBOARD BUTTON SECTION END HERE ==================== -->

<!-- ================ DASHBOARD INVESTEMENT SECTION STRAT HERE =============== -->
<div class="container">
    <div class="investment">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 inves col-sm-12 col-12">
                <center>
                    <a href="{{route('user.investments')}}">
                        <button>@lang('Status Investasi')</button>
                    </a>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="withdraw">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 draw">
                <h1>@lang('Saldo Tersedia')</h1>
                <p>{{trans($basic->currency_symbol)}} {{number_format($walletBalance)}}</p>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="profit">
        <div class="row">
            <div class="col-md-6 recently">
                <h1>@lang('Total Investasi')</h1>
                <p>@lang('Investasi Berjalan') : <strong>{{Auth::user()->invests()->count()}} @lang('Investasi')</strong></p>
                <h6>@lang('Investasi Selesai') : <span>{{Auth::user()->invests()->where('status', 0)->count()}} @lang('Investasi')</span>
                </h6>
            </div>
            <div class="col-md-6 recently">
                <h1>@lang('Keuntungan & Bonus')</h1>
                <p>@lang('Total Keuntungan') : <strong>{{trans($basic->currency_symbol)}} {{number_format($totalProfit)}}</strong></p>
                <h6>@lang('Keuntungan Bulanan') : <span>{{trans($basic->currency_symbol)}} {{number_format($totalProfitMonthly)}}</span>
                </h6>
            </div>
        </div>
    </div>
</div>
<!-- ================ DASHBOARD INVESTEMENT SECTION END HERE =============== -->


@endsection



