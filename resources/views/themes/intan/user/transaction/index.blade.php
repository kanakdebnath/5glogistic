@extends($theme.'layouts.user')
@section('title',trans('Transaksi'))
@section('content')
@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/transaction.css')}}">

@endpush


<!-- ============ TRANSACTION HEADER START HERE =================== -->
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
<!-- ============ TRANSACTION HEADER END HERE =================== -->
<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid transaction-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.home')}}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TRANSACTION SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row transaction-sec">
            <div class="col-md-12">
                <h1>Transaksi</h1>
                <p>Daftar Transaksi Anda</p>
            </div>
        </div>
        <div class="row">

            @forelse($transactions as $transaction)

            <div class="col-lg-4 col-md-6">
                <div class="transaction-card">
                    <h6>@lang($transaction->remarks)</h6>
                    <p class="date-line">Date : <span>{{ dateTime($transaction->created_at, 'd M Y H:i') }} WIB</span></p>
                    <p class="income-line">Income : <span class="{{($transaction->trx_type == "+") ? '': 'expire-income'}}" >{{($transaction->trx_type == "+") ? '+': '-'}} {{trans($basic->currency_symbol)}} {{number_format($transaction->amount)}}</span></p>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
<!-- ========================= TRANSACTION SECTION END HERE ====================== -->
<!-- ========================= TRANSACTION PAGINATION START HERE ====================== -->
<div class="container-fluid pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    {{ $transactions->onEachSide(0)->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ========================= TRANSACTION PAGINATION END HERE ====================== -->

@endsection
