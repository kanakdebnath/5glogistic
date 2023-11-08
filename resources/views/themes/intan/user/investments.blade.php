@extends($theme.'layouts.user')
@section('title','Status Investasi')


@push('style')
<!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/investment.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/model.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">

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

<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('user.home')}}">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Status Investasi</li>
    </ol>
</nav>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->

    <!-- ================ INVESTMENT SECTION START HERE ===================== -->
    <div class="container">
        <div class="row">
            <div class="inves">
                <div class="col-md-12">
                    <h1>Status Investasi</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- ================ INVESTMENT SECTION END HERE ===================== -->

    <!-- ================= CARD SECTION START HERE ================== -->
    <div class="container">
        <div class="card-sec">
            <div class="row">

                @forelse($investments as $key => $invest)
                        @php
                        $plan = App\Models\ManagePlan::find($invest->plan_id)
                        @endphp


                <div class="col-md-6">
                    <div class="card-sec-1">
                        <center> <img src="{{getFile(config('location.plan.path').$plan->image) ? : 0}}" alt=""></center>
                        <h1>{{trans(optional($invest->plan)->name)}}</h1>
                        <p>@lang('Price') : <span>{{trans($basic->currency_symbol)}} {{number_format($plan->fixed_amount)}}</span></p>
                        <p>@lang('Profit') : <span>{{trans($basic->currency_symbol)}} {{number_format($invest->profit)}}</span></p>

                        @php
                            $expired_on = Carbon\Carbon::parse($invest->created_at)->addDays($invest->maturity);
                            $expiry_date = Carbon\Carbon::parse($invest->created_at)->addDays($invest->maturity)->format('d M Y');
                            $today_date  = Carbon\Carbon::now();
                            // $diff_day = Carbon\Carbon::now()->diffInDays($expiry_date);
                        @endphp


                        <p>@lang('Status') : 
                            @if($today_date->isBefore($expired_on))
                            <span class="text-success">@lang('AKTIF')</span>
                            @else
                            <span class="text-danger">@lang('SELESAI')</span>
                            @endif
                        </p>
                        <p>@lang('Tanggal Selesai') : <span>{{$expiry_date}}</span></p>

                        <p class='pb-2 text-center'>
                            @if ($invest->recurring_time >= $invest->maturity && $invest->maturity != '-1')
                               @if ($invest->status != 0)
                               @if($plan->category->capital_back == 1)
                               <a href="#" data-val='{{ $invest->amount }}' data-id='{{ $invest->id }}' class="confirm-btn btn btn-sm bg-info text-white" data-bs-toggle="modal" data-bs-target="#confirmModal">Tarik Modal</a>
                               @endif
                               <a href="#" data-id='{{ $invest->id }}' data-url='{{ route('user.upgrade-plan') }}' class="upgrade-btn btn btn-sm bg-danger text-white">Upgrade</a>
                               @else
                               <hr>
                               <p class="text-danger text-center">Investasi telah selesai</p>
                               @endif
                           @endif
                        </p>

                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>

    <!-- ================= CARD SECTION END HERE ================== -->


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <h3 class="modal-heding">@lang('Attention!')</h3>
        <p class="model-text">Konfirmasi penarikan modal ?</p>

            <form  style="margin-bottom: 0px; margin-top: 0px; padding-top: 0px;"   autocomplete="off" method="post">
                <input type="hidden" id="invest_id" name="invest_id" value="">
                <input type="hidden" id="price" name="price" value="">
            </form>

        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal">@lang('Batal')</button>
            <button type="button" onClick="captialBack($(this))" class="confir-btn" id="captialBackButton" ><span id="confirmButon">@lang('Konfirmasi')</span></button>
        </div>
        </div>
    </div>
</div>




<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <h3 class="modal-heding">@lang('Attention!')</h3>
        <p class="model-text">Pilih perangkat yang ingin di upgrade</p>

        <div class="table">
            <div class="details-data">

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal">@lang('Batal')</button>
            <button type="button" onclick="upform.submit();" class="confir-btn">@lang('Konfirmasi')</button>
        </div>
        </div>
    </div>
</div>

@endsection



@push('scripts')
<script>
    function captialBack(elm){
        var invest_id = $("#invest_id").val();
        var price = $("#price").val();
        $.ajax({
            type : "POST",
            url  : "{{route('user.capitalback')}}",
            data : {
                '_token' : "{{csrf_token()}}",
                'invest_id' : invest_id,
                'price' : price,
            },
            beforeSend : function(res){
                var spinner = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                $("#confirmButon").html(spinner);
                $("#captialBackButton").attr('disabled',true);
            },
            success : function(res){
                var data = "@lang('Konfirmasi')";
                $("#confirmButon").html(data);
                if(res.success == true){
                    $("#confirmModal").modal('hide');
                    window.location.href = '{{route("user.home")}}';
                }
            },
            error   : function(res){
                $("#confirmButon").html(spinner);
            $("#captialBackButton").attr('disabled',false);
             $("#confirmModal").modal('hide');
            }
        });
    }
    $(document).ready(function(){
        $('.confirm-btn').on('click', function(){
            $('#price').val($(this).attr("data-val"));
            $('#invest_id').val($(this).attr("data-id"));
        });
    })

    $(document).ready(function(){
        $('.upgrade-btn').on('click', function(){
            var id = $(this).data('id');
            var url = $(this).data('url');
            $('#upgradeModal').modal('show');

            $.ajax({
              type: "POST",
              url: url,
              data: {
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function (data) {
                    $('.details-data').html(data);

                  }
          });

        });
    })
</script>
@endpush

