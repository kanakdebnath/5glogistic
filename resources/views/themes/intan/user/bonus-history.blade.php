@extends($theme.'layouts.user')
@section('title',trans('Daftar Bonus'))

@section('content')

@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/bonus_history.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">

@endpush



<!-- BEGIN: JEWLERY HEADER SECTION -->
<header class="jewlery-referral-header">
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
</header>
<!-- END: JEWLERY HEADER SECTION -->
<!-- BEGIN: PROFILE SECTION -->
<section class="referral-table-section">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="row referral-breadcrumb">
                    <!-- BEGIN: BREADCRUMB -->
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="p-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.referral') }}">Referral</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Bonus</li>
                        </ol>
                    </nav>
                    <!-- END: BREADCRUMB -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="table-heading">Daftar Bonus</h1>
                    </div>
                </div>
                <!-- table -->
                <div class="row referral-table">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <table class="table table-separate" style="width:100%">
                                <thead>
                                    <tr>
                                    <th  style="text-align:center;">@lang('Anggota')</th>
                                    <th  style="text-align:center;">@lang('Level')</th>
                                    <th  style="text-align:center;">@lang('Jumlah')</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $trx)
                                <tr>
                                    <td class="bonus-name" style="text-align:center;">{{$trx->bonusBy->phone}}</td>
                                    <td class="bonus-name" style="text-align:center;">{{$trx->level}}</td>
                                    <td class="bonus-amount text-success"  style="text-align:center;"><small>{{trans($basic->currency_symbol)}}</small>{{number_format($trx->amount)}}</td>
                                    
                                </tr>
                                @endforeach

                                
                                    
                                </tbody>
                            </table>
                            <div class="mt-3" style="float:right">
                                {{$transactions->onEachSide(0)->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- table -->
            </div>
        </div>
    </div>
</section>
<!-- END: PROFILE SECTION -->


@endsection