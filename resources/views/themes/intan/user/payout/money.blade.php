@extends($theme.'layouts.user')
@section('title',trans($title))


@push('style')
<!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/table.css')}}">
@endpush

@section('content')
<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
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
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->
<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid changePass-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.home')}}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Penarikan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TABS SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabset">
                    <!-- Tab 1 -->
                    <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                    <label for="tab1">Formulir Penarikan</label>
                    <!-- Tab 2 -->
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                    <label for="tab2" class="chngePass-tab">Riwayat Penarikan</label>

                    <div class="tab-panels">
        
                        <section id="marzen" class="tab-panel profile-inputs">
                            <form action="{{route('user.toppay.moneyRequest')}}" enctype="multipart/form-data" autocomplete="off" id="payout" method="post">
                                @csrf
                            <input type="hidden" name="gateway" value="{{$gateway->id}}">
                            <input type="hidden" name="wallet_type" value="balance">
                            <h2>Formulir Penarikan</h2>
                            
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Nominal Penarikan') :</label>
                                <i class="fa-solid fa-box pro-icon"></i>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan Nominal">
                                <p>Min. {{$basic->currency_symbol}} {{number_format($gateway->minimum_amount, $basic->fraction_number)}} - {{$basic->currency_symbol}} {{number_format($gateway->maximum_amount, $basic->fraction_number)}}</p>
                                @error('amount')
                                    <small class="text-danger">@lang($message)</small>
                                    @enderror
                            </div>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Jumlah Diterima :</label>
                                <i class="fa-solid fa-box pro-icon"></i>
                                <input type="number" id="charge" readonly class="form-control" placeholder="Jumlah Diterima">
                                
                            </div>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label">@lang('Akun Bank') :</label>
                                <i class="fa-solid fa-building-columns pro-icon"></i>

                                <select name="account_id" class="form-control" required>
                                    <option value="" disabled selected>@lang('Bank Name')</option>
                                    @foreach ($accounts as $key => $account)
                                        <option value="{{$account->id}}">{{$account->bank->name}}</option>
                                    @endforeach
                                </select>
                                <p>* Pajak Penarikan Rp {{number_format($gateway->fixed_charge)}}</p>

                                @error('account_id')
                                <small class="text-danger">@lang($message)</small>
                                @enderror
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">@lang('Proses')</button>
                                <button id="processing" style="display: none" disabled class="btn form-btn ">Proses</button>
                            </center>
                            </form>
                        </section>
                        <section id="rauchbier" class="tab-panel profile-inputs1">
                            <h2>@lang('Riwayat Penarikan')</h2>
                            <!-- table -->
                            <a class="btn btn-primary" onClick="window.location.reload();">Refresh</a>
                            <div class="row referral-table" style="margin-bottom: 90px;">
                                <div class="col-md-12 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-separate">
                                            <thead>
                                                <tr>
                                                   
                                                    <th>@lang('Date')</th>
                                                    <th>@lang('Amount')</th>
                                                    <th>@lang('Bank')</th>
                                                    <th>@lang('Status')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($payoutLog as $key => $item)
                                                @if($item->status == 1)
                                                <tr>
                                                   
                                                    <td class="withdraw-date">{{ dateTime($item->created_at, 'd M Y H:i')}} WIB </td>
                                                    <td class="withdraw-success text-success">@lang($basic->currency_symbol) {{number_format($item->net_amount)}} </td>
                                                    <td class="text">{{$account->bank->name}} </td>
                                                    <td class="text-warning pending">@lang('Proses')</td>
                                                </tr>
                                                @elseif($item->status == 2)
                                                <tr>
                                                   
                                                    <td class="withdraw-date">{{ dateTime($item->created_at, ' d M Y H:i')}} WIB</td>
                                                    <td class="withdraw-success text-success">@lang($basic->currency_symbol) {{number_format($item->net_amount)}}</td>
                                                    <td class="text">{{$account->bank->name}} </td>
                                                    <td class="withdraw-success text-success">@lang('Sukses')</td>
                                                </tr>
                                                @elseif($item->status == 3)
                                                <tr>
                                                    
                                                    <td class="withdraw-date">{{ dateTime($item->created_at, 'd M Y H:i')}} WIB</td>
                                                    <td class="withdraw-success text-success">@lang($basic->currency_symbol) {{number_format($item->net_amount)}}</td>
                                                    <td class="text">{{$account->bank->name}} </td>
                                                    <td class="cancled text-danger">@lang('Gagal')</td>
                                                </tr>
                                                @endif
                                                @empty
                                                @endforelse
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- table -->

                            <div class="container-fluid pagination-sec">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <nav aria-label="Page navigation example">
                                                {{ $payoutLog->onEachSide(0)->links() }}
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#amount').on('keyup', function(){
            $('#charge').val(Number(parseInt($(this).val()) - parseInt("{{$gateway->fixed_charge}}") - (parseInt($(this).val()) / 100 * parseInt("{{$gateway->percent_charge}}")) ));
        });
    })
    
    $('form#payout').submit(function(){
            $(this).find(':button[type=submit]').hide();
            $(this).find('#processing').show();
        });
</script>
@endpush
