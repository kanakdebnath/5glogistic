@extends($theme.'layouts.app')
@section('title', trans('Home'))

@section('content')

    <!-- BEGIN: JEWLERY HEADER SECTION -->
    <header class="jewlery-header">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <br>
                        <br>
                        <h1>@lang('Investasi Perhiasan Pertama di Indonesia')</h1>
                        <br>
                        <p>@lang('Resmi legalitas & Diawasi oleh lembaga keuangan yang berlaku')</p>
                        <h1>@lang('Lisensi dan Sertifikasi :')</h1>


                        <center>
                       <img src="{{asset('assets/frontend/images/SSL secure.png')}}" style="height: 30px;"  />
                       <img src="{{asset('assets/frontend/images/guaranteed-safe-checkout-5.png')}}" style="width: 60px;"style="height: 30px;"  />
                       <img src="{{asset('assets/frontend/images/Trustlock.png')}}" style="height: 20px;" style="width: 50px;"  />
                       <img src="{{asset('assets/frontend/images/Logo DJP.png')}}" style="height: 30px;"  />
                       <img src="{{asset('assets/frontend/intan/img/ojk.png')}}" style="height: 20px;"  /> </center>

                        <center>
                             <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 90px;" />
                          </center>


                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: JEWLERY HEADER SECTION -->

    <section class="installment-plan-section" id="Product-card" style="margin-bottom: 50px;">
        <div class="container-fluid">
            <div class="container">
                <!-- BEGIN: JEWLERY CARD SECTION -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1>@lang('PILIHAN INVESTASI')</h1>
                        <p>@lang('Klik tombol pembayaran untuk memulai')</p>
                        <ul class="nav nav-pills mb-3" style="gap: 10px;" id="pills-tab" role="tablist">
                            @foreach($categories as $key => $category)
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link @if($key == 0) active @endif" id="pills-tab-{{$key}}" data-bs-toggle="pill" data-bs-target="#pills-{{$key}}" type="button" role="tab" aria-controls="pills-{{$key}}" aria-selected="false">{{$category->name}}</button>
                            </li>
                            @endforeach
                        </ul>


                        <p></p>
                        <div class="tab-content" id="pills-tabContent">
                            
                            @foreach($categories as $key => $category)
                            <div class="tab-pane fade @if($key == 0) show active @endif" id="pills-{{$key}}" role="tabpanel" aria-labelledby="pills-tab-{{$key}}">
                                <!-- BEGIN: SECOND TAB CARDS -->
                                <section class="jewlery-card-section">
                                    <div class="container">
                                        <div class="row">
                                            @if(0 < count($category->plans))
                                            @foreach($category->plans as $k=> $data)
                                            @php
                                            $getTime = \App\Models\ManageTime::where('time', $data->schedule)->first();
                                            @endphp
                                            <div class="col-md-4 col-sm-6 col-12 p-0">
                                                <div class="ribbon-1">
                                                    <h6>Batas Pembelian</h6>
                                                    <p></p>
                                                    <p>{{$data->max_per_user}} x</p>

                                                </div>
                                                <img src="{{getFile(config('location.plan.path').$data->image) ? : 0}}" alt="">
                                                <h4>{{$data->name}}</h4>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th>Harga :</th>
                                                        <td>{{$data->price}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Durasi :</th>
                                                        <td>{{$data->repeatable}} @lang('Days')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Keuntungan</th>
                                                        <td>@if ($data->profit_type == 1)
                                                        <td>{{getAmount($data->profit)}}{{'%'}}
                                                         @else
                                                         {{trans($basic->currency_symbol)}} {{number_format($data->profit)}}

                                                         @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Penghasilan :</th>
                                                        <td>@if($data->is_lifetime == 0)
                                                           {{trans($basic->currency_symbol)}} {{number_format($data->profit*$data->repeatable)}}
                                                            {{($data->profit_type == 1)}}
                                                            @if($data->is_capital_back == 1)

                                                            @endif
                                                            @else
                                                            @lang('Lifetime Earning')
                                                            @endif</td>
                                                    </tr>
                                                </table>
                                                
                                                <form action="{{route('user.toppay.checkout')}}" onsubmit="return formSubmit('#submit-{{$data->id}}');" method="post">
                                                    @csrf
                                                    <input type="hidden" name="plan_id" value="{{ $data->id }}">
                                                    <input type="hidden" name="amount" value="{{ $data->fixed_amount }}">
                                                    <input type="hidden" name="balance_type" value="checkout">
                                                    
                                                    <button type="submit" id="submit-{{$data->id}}" class="btn">@lang('Pembayaran')</button>
                                                </form>
                                                
                                                {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Pembayaran</button> --}}
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </section>
                                <!-- END: SECOND TAB CARDS -->
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <!-- END: JEWLERY CARD SECTION -->
            </div>
        </div>
    </section>
    <!-- Footer  -->
 

<div id="myModal" class="modal fade show active" role="dialog">
  <div class="modal-dialog" style="margin-top: 70px;">
    
    <!-- Modal content-->
    <div class="modal-content">
     
      <div class="modal-body" style="padding:0px;position:relative;">
           <a href="javascript:void(0)" id="modalCrossButton" data-bs-dismiss="modal"><i class="fa fa-times"></i></a>
        <a href><img src="https://perhiasanintan.com/assets/uploads/img.jpeg" alt="" style="width:100%;"></a>
      </div>
      <!--<div class="modal-footer" style="padding:0px;">-->
      <!--    <div class="cstm">-->
      <!--      <button type="button" id="modalCrossButton" class="btn btn-defualt" style="background: #bd9277; color: #ffffff;"  data-bs-dismiss="modal">Don't show again</button>-->
      <!--    </div>-->
      <!--</div>-->
    </div>

  </div>
</div>


    
    <script type="text/javascript">
            function formSubmit(id)
            {
                $(id).attr('disabled', true).html('Proses');
            }
            
            $(document).ready(function(){
                $(document).on('click','#modalCrossButton',function(){
                   $('#myModal').modal('hide');
                    $('#myModal').hide();
                    
                });
            });
            
            $(document).ready(function() {
              //  Check if modal was already shown today
              if (localStorage.getItem('lastShown') && (Date.now() - localStorage.getItem('lastShown')) < (0 * 0 * 60 * 1000)) {
              //   Modal was already shown within the last 24 hours, do not show it again
                return;
              }
              
             //  Show the modal if it hasn't been shown today
              $('#myModal').modal('show');
              
              // Store the current timestamp in local storage to mark it as shown
              localStorage.setItem('lastShown', Date.now());
            });

            
            
</script>
    
    
    
    
    @include('themes.intan.partials.footer')

@endsection
