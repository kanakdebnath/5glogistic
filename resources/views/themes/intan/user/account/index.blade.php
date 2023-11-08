@extends($theme.'layouts.user')
@section('title',trans('Akun Bank'))
@section('content')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- stylesheet -->
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/Account.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/change-detail.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/Bank-account.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/model.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">

@endpush



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

<!-- ========== START SECOND ========== -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- START BTEADCRUM -->
             <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Beranda</a></li>
                    <li class="breadcrumb-item active banck-crum" aria-current="page">Akun Bank</li>
                </ol>
            </nav>

            <!-- END BTEADCRUM -->

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="Second-heading">Akun Bank</h3>
        </div>
    </div>

    @if($accounts->count() < 1)
        <div class="row">
            <div class="col-md-12">
                    <div class="debit-card">
                        <a href="{{route('user.paymentmethods.create')}}">
                        <img src="{{asset('assets/frontend/intan/img/add-bank-account.png')}}" alt="">
                        <p class="nbr">ADD YOUR BANK ACCOUNT</p>
                        </a>
                    </div>
            </div>
        </div>
    @else
    <div class="row">
        @forelse($accounts as $key => $account)
        <div class="col-md-12">
            <div class="debit-card">
                <p class="james" style="margin-bottom: 15px;">{{$account->account_holder}}</p>
                <img src="{{asset('assets/frontend/intan/bank_logo/'.$account->bank->logo)}}" width="100px" style="margin-bottom: 15px;" class="img-fluid rounded-top" alt="">
                <p class="account-no">@lang('Nomor Rekening')</p>
                <p class="nbr">{{getTruncatedCCNumber($account->bank_account)}}</p>
            </div>
        </div>
        @empty
        @endforelse
    </div>
    @endif
</div>


     @forelse($accounts as $key => $account)
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="last-heading">Apakah Ingin Mengganti Data ?</h3>
            <a href="{{route('user.paymentmethods.edit',$account->id)}}">
                <button class="last-btn" type="text">
                    Ganti Data
                </button>
            </a>
        </div>
    </div>
    @empty
    @endforelse
</div>
<!-- ===== input end ===== -->

@php
    function getTruncatedCCNumber($ccNum){
        return str_replace(range(0,9), "*", substr($ccNum, 0, -4)) . substr($ccNum, -4);
    }
@endphp



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <center>
        <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 70px;" />
        </center>
        <h3 class="modal-heding">PERHATIAN</h3>
        <p class="model-text">Pastikan kembali data berikut sudah benar</p>

        <div class="table">
            <p><span class="left-side-list">@lang('Full Name') :</span> <span class="right-side-list" id="account_holder"></span></p>
            <p><span class="left-side-list">@lang('Jenis Bank') :</span> <span class="right-side-list" id="selected_bank"></span></p>
            <p><span class="left-side-list">@lang('Account Number') :</span> <span class="right-side-list" id="account_number"></span>
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal">@lang('Batal')</button>
        <button type="button" onclick="msform.submit();" class="confir-btn">@lang('Confirm')</button>
        </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="{{asset('assets/frontend/js/script.js')}}"></script>
<script>
    $(document).ready(function(){
        $('input[name="account_holder"]').on('keyup', function(){
            $('#account_holder').text($(this).val());
        });
        $('select[name="bank_id"]').on('change', function(){
            $('#selected_bank').text($(this).find('option:selected').text());
        });
        $('input[name="bank_account"]').on('keyup', function(){
            $('#account_number').text($(this).val());
        });
    })
</script>
@endpush
