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
</div>
<!-- ===== inputs start ===== -->
<div class="container">

    <form id="msform" action="{{route('user.paymentmethods.store')}}" enctype="multipart/form-data" autocomplete="off" method="post">
        @csrf


    <div class="row">
        <div class="col-md-6">
            <div class="main">
                <!-- Actual search box -->
                <p class="owner-text">@lang('Full Name') :</p>
                <div class="form-group has-search">
                    <span class="fa fa-user form-control-feedback user-icon"></span>
                    <input type="text" name="account_holder" class="form-control " placeholder="Nama Pemilik">
                </div>

                @error('account_holder')
                        <div class="text-danger">@lang($message)</div>
                    @enderror
                <!-- Another variation with a button -->
            </div>
        </div>

        <div class="col-md-6">
            <p class="owner-text">@lang('Jenis Bank') :</p>

            <div class="form-group has-search">
                <span class="fa fa-briefcase form-control-feedback user-icon"></span>
                <select name="bank_id" class="form-control" required>
                    <option value="">@lang('Jenis Bank')</option>
                    @foreach ($banks as $key => $bank)
                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                    @endforeach
                </select>
                @error('bank_id')
                    <div class="text-danger">@lang($message)</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p class="owner-text">@lang('Account Number') :</p>
            <div class="form-group has-search">
                <span class="fa fa-briefcase form-control-feedback user-icon"></span>
                <input type="text" name="bank_account" class="form-control " placeholder="@lang('Account Number')">
            </div>
            @error('bank_account')
                <div class="text-danger">@lang($message)</div>
            @enderror
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="last-btn confirm-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Confirm
            </button>
        </div>
    </div>

</form>
</div>
<!-- ===== input end ===== -->




<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <h3 class="modal-heding">PERHATIAN</h3>
        <p class="model-text">Pastikan data berikut sudah benar !</p>

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
