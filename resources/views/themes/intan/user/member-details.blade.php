@extends($theme.'layouts.user')
@section('title',trans('Detail Anggota'))

@section('content')

@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/member-detail.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">

@endpush


<!-- BEGIN: JEWLERY HEADER SECTION -->
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
                            <li class="breadcrumb-item active" aria-current="page">Detail Anggota</li>
                        </ol>
                    </nav>
                    <!-- END: BREADCRUMB -->
                </div>
                <div class="row" id="member-detail-card">
                    <div class="col-md-12">
                        <h1>Level {{ $level }}</h1>
                        <table>
                            <tr>
                                <th>Total Anggota</th>
                                <td><b>{{ $total }}</b> Anggota</td>
                            </tr>
                            <tr>
                                <th>Berinvestasi</th>
                                <td><b>{{ $active }}</b> Anggota</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="table-heading">Detail Anggota</h1>
                    </div>
                </div>
                <!-- table -->
                <div class="row referral-table">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <table class="table table-separate">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor HP</th>
                                        <th>Investasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index=>$d)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{isset($d) ? $d->phone : null}}</td>
                                        <td class='text-{{count(IsActiveUser($d->id)) > 0?'success':'danger'}}'style='text-align:center;'>{{count(IsActiveUser($d->id)) > 0?'Ya':'Tidak'}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <!-- ========================= TRANSACTION PAGINATION START HERE ====================== -->
                            <div class="mt-3" style="float:right">
                                {{$data->onEachSide(0)->links()}}
                            </div>
                            <!-- ========================= TRANSACTION PAGINATION END HERE ====================== -->
                            
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