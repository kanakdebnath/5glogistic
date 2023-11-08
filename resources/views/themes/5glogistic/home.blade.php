@extends($theme.'layouts.5glogistic')

@push('head')
<link rel="stylesheet" href="{{asset('assets/frontend/styles/index.css')}}" />
@endpush

@section('content')
<header>
    @include('themes.5glogistic.inc.bottom-nav')
</header>

<!-- top Banner -->
<section class="top-banner">
    <div class="mx-auto">
        <div class="d-flex justify-content-between align-items-center mx-auto" style="width: 95%; padding-top: 35px">
            <div class="d-flex align-items-center gap-2">
                <img src="{{asset('assets/frontend/images/icons/welcome.png')}}" width="45px" alt="" />
                <span class="fs-3 fw-medium" style="font-family: 'Times New Roman'">Welcome!</span>
            </div>
            <div>
                <a href="#" class="d-block text-end">
                    <img class="w-50" src="{{asset('assets/frontend/images/icons/note.png')}}" alt="" />
                </a>
            </div>
        </div>
    </div>

    <div class="d-flex gap-5 ps-2 mt-2">
        <div>
            <p class="m-0">My balance(Rs.)</p>
            <p class="h1 fw-bold">40.08</p>
        </div>
        <div>
            <p class="m-0">Total income(Rs.)</p>
            <p class="h1 fw-bold">40.08</p>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3 pb-1 ps-2 pe-3">
        <div class="col">
            <a href="{{ route('user.addFund') }}" class="d-flex flex-column align-items-center text-decoration-none text-dark fw-semibold"><img style="width: 27px" src="{{asset('assets/frontend/images/icons/recharge.png')}}" alt="" />
                <p>Recharge</p>
            </a>
        </div>
        <div class="col">
            <a href="pages/withdraw.html" class="d-flex flex-column align-items-center text-decoration-none text-dark fw-semibold"><img style="width: 27px" src="{{asset('assets/frontend/images/icons/withdraw.png')}}" alt="" />
                <p>Withdraw</p>
            </a>
        </div>
        <div class="col">
            <a href="pages/account.html" class="d-flex flex-column align-items-center text-decoration-none text-dark fw-semibold"><img style="width: 27px" src="{{asset('assets/frontend/images/icons/account.png')}}" alt="" />
                <p>Account</p>
            </a>
        </div>
        <div class="col">
            <a href="pages/taskReward.html" class="d-flex flex-column align-items-center text-decoration-none text-dark fw-semibold"><img style="width: 27px" src="{{asset('assets/frontend/images/icons/task.png')}}" alt="" />
                <p>Task reward</p>
            </a>
        </div>
    </div>
</section>

<!-- Banner Section -->
<section>
    <img src="{{asset('assets/frontend/images/icons/banner_bar.png')}}" class="w-100" alt="" />
</section>

<!-- Notice Section -->
<section class="row border-5 border-top border-bottom py-3 px-2 me-0">
    <div class="col-3 pe-1">
        <img class="w-100" src="{{asset('assets/frontend/images/icons/notice.png')}}" alt="" />
    </div>
    <div class="col-9 border-1 border-start ps-2 pe-3">
        <marquee class="fw-medium textOrange" behavior="" direction="">
            Welcome to join "5G Logistics"1. You can receive a 10-day free device,
            get Rs.40 every day, and experience how the device makes money.2.
            Invitation registration reward Rs.8.3. Invite those who invest in
            equipment for the first time to get 16% cash back.4. Team commission
            17%.If you have any questions please contact customer service.
        </marquee>
    </div>
</section>

<section class="row align-items-center px-2 mt-3 mb-10" style="height: 30px">
    <div class="col-8 d-flex align-items-center">
        <img style="width: 25px" src="{{asset('assets/frontend/images/icons/recommend.png')}}" alt="" />
        <p class="m-0">
            <span class="fw-bold mx-1" style="font-size: 17px">Recommend</span><span style="font-size: 14px">(Device List)</span>
        </p>
    </div>
    <div class="col-4">
        <img class="h-50 w-100" src="{{asset('assets/frontend/images/icons/whatsApp.png')}}" alt="" />
    </div>
</section>

<!-- Card Section -->
<section class="px-2 mt-3" style="padding-bottom: 100px;">
    <!-- card -->
    
    @foreach ($plans as $data)
    @php
    $getTime = \App\Models\ManageTime::where('time', $data->schedule)->first();
    @endphp

        
    <div class="row m-0 mb-3" style="background: #f6f6f6">
        <div class="col-4 p-0">
            <img class="w-100 h-100" src="{{getFile(config('location.plan.path').$data->image) ? : 0}}" alt="" />
        </div>
        <div class="col-8 p-0 ps-2">
            <p class="m-0 d-flex justify-content-between align-items-center">
                <span class="fs-3 fw-bold">{{$data->price}}</span>
                <span class="bg-blue px-2 rounded-5" style="font-size: 13px"><img style="width: 15px" src="{{asset('assets/frontend/images/icons/time.png')}}" alt="" />
                    {{$data->repeatable}}
                    </span>
            </p>
            <small class="fw-semibold">{{$data->name}}</small>
            <p class="m-0 d-flex align-items-center justify-content-between">
                <span>Daily Income</span>
                <span class="textOrange fs-6 fw-medium">
                    @if ($data->profit_type == 1)
                    {{getAmount($data->profit)}}{{'%'}}
                        @else
                        {{trans($basic->currency_symbol)}} {{number_format($data->profit)}}

                        @endif
                </span>
            </p>
            <p class="m-0 d-flex align-items-center justify-content-between">
                <span>Total Income</span>
                <span class="textOrange fs-6 fw-medium">
                    @if($data->is_lifetime == 0)
                    {{trans($basic->currency_symbol)}} {{number_format($data->profit*$data->repeatable)}}
                     {{($data->profit_type == 1)}}
                     @if($data->is_capital_back == 1)

                     @endif
                     @else
                     @lang('Lifetime Earning')
                     @endif
                </span>
            </p>
            <button class="btn btn-warning w-100 fs-6 fw-bold">
                <a class="text-decoration-none text-dark" href="{{ route('plan.details', $data->id) }}"><img style="width: 17px" src="{{asset('assets/frontend/images/icons/cart.png')}}" alt="" />
                    @lang('Purchases')</a>
            </button>
        </div>
    </div>
    
    @endforeach
</section>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#modal" id="modalBtn">
    Launch demo modal
</button>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog mx-auto modal-dialog-centered" style="width: 80%">
        <div class="modal-content border-0">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="position-absolute border-0 bg-transparent" style="top: -195px; right: 10px">
                <i class="fa-solid fa-circle-xmark fs-3 text-white"></i>
            </button>
            <div class="p-3 position-absolute" style="top: -65px">
                <p class="m-0">Welcome to join "5G Logistics"</p>
                <p class="m-0">
                    1. You can receive a 10-day free device, get Rs.40 every day, and
                    experience how the device makes money.
                </p>
                <p class="m-0">2. Invitation registration reward Rs.8</p>
                <p class="m-0">
                    3. Invite those who invest in equipment for the first time to get
                    16% cash back
                </p>
                <p class="m-0">4. Team commission 17%</p>
                <p class="m-0">
                    If you have any questions please contact customer service
                </p>
                <button class="modal-btn-style ps-2">
                    Click to join Telegram Channel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <!-- Modal clicker -->
<script>
    function defaultClick() {
        window.onload = function() {
            document.getElementById("modalBtn").click();
        };
    }
    defaultClick();


</script>

@endpush

