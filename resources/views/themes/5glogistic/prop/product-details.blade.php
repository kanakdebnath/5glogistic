<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v1.3')}}">
    <style type="text/css">
        .topname {
            line-height: 46px;
            width: 75%;
            text-align: center;
            color: #000;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
            font-size: 14px;
        }

    </style>
    <script type="text/javascript">
        layui.use(['form', 'carousel', 'flow', 'element', 'cookie'], function() {
            var $ = layui.jquery;
            var layer = layui.layer;
            var flow = layui.flow;
            var element = layui.element;
            var cookie = layui.cookie;
            var topindex = parent.layer.getFrameIndex(window.name);

            $().ready(function() {
                // proinfor();
            });

            function proinfor() {
                var id = getUrlParam("id");
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "proinfo"
                    , id: id
                    , time: Math.random()
                };
                $.getJSON(url, pm
                    , function(json) {
                        if (json.State == "200") {
                            $("#imgurl").attr("src", json.JsonResult.imgurl);
                            $("#price").html("Rp  " + json.JsonResult.price);
                            $("#allincome").html(json.JsonResult.allincome);
                            $("#hourincome").html(json.JsonResult.hourincome);
                            $("#dayincome").html(json.JsonResult.dayincome);
                            $("#day").html(json.JsonResult.day + " days");
                        }
                        CommAlert(json);
                    });
            }


            $(document).on("click", '#Lease', function() {

                $('#Lease').attr('disabled', true);
                $('#Lease').text('Processing...');

                var index = layer.load();
                var id = $("#plan_id").val();
                var url = "{{route('user.acpay.checkout')}}";
                var pm = {
                    _token: "{{csrf_token()}}"
                    , plan_id: id
                , };

                $.ajax({
                    url: url
                    , method: "POST"
                    , dataType: "json"
                    , data: pm
                    , success: function(data) {
                        error(data.message);
                        layer.close(index);

                        $('#Lease').attr('disabled', false);
                        $('#Lease').text('Lease');
                    }
                    , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';
                        $.each(errors['errors'], function(index, value) {
                            errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                        });
                        error(errorsHtml);
                        layer.close(index);

                        $('#Lease').attr('disabled', false);
                        $('#Lease').text('Lease');
                    }
                });

            });

            $(document).on("click", '#btnClose', function() {
                parent.layer.close(topindex);
            });

        });

    </script>
    <style>
        p {
            line-height: 20px;
            font-size: 12px;
        }

    </style>
</head>

<body style="min-height: 100%; width: 100%; background-size: 100% auto; background: linear-gradient(to top, #071730, #071730); ">
    <div class="indexdiv"></div>
    <div style=" max-width:450px; margin:0 auto;">
        <div class="top1">
        </div>
        <div class="top" style="background: #071730; ">
            <div style="float:left; line-height:46px;width:50%;cursor:pointer;" id="btnClose">
                <i class="layui-icon" style="color:#fff;  margin-left:12px; font-size:16px;  font-weight:bold;">&#xe603;</i>
            </div>
            <font class="topname" id="title" style="color: #fff; text-overflow: ellipsis; overflow: hidden; ">
                Detail produk
            </font>
            <div style="float:right; text-align:right; line-height:46px;width:50%;">

            </div>
        </div>

        <div style="width: 98%; margin: 0 auto; margin-top: 60px; border-radius: 5px;">
            <input type="hidden" id="plan_id" name="plan_id" value="{{$plan->id}}">
            <div style="">
                <div style="text-align:center;">
                    <img src="{{getFile(config('location.plan.path').$plan->image) ? : 0}}" id="imgurl" style="width:70%;" />
                </div>
            </div>
            <div style="width: 95%; margin: 0 auto; background: linear-gradient(to right,#ddc088,#c0892f); border-radius: 5px; height: 75px; text-align: center; color: #fff; font-size: 26px; line-height: 75px; ">
                <div style="float:left;width:50%; "> Harga</div>
                <div style="float: left; width: 50%;" id="price">{{$plan->price}}</div>
            </div>
            <div style=" width: 95%; margin: 0 auto; background: linear-gradient(to right,#0f2756,#0f2756); border-radius: 5px; height: 120px; text-align: center; color: #fff; font-size: 12px; ">
                <div style="float:left;width:40%; ">
                    <div style="padding-top:32px;font-size:25px;color:#ddc088;font-weight:bold;" id="allincome">
                        {{getAmount($plan->profit * $plan->repeatable)}}</div>
                    <div style="padding-top:10px;">Jumlah penghasilan({{config('basic.currency_symbol')}})</div>
                </div>
                <div style="float: left; width: 60%;">
                    <div style="padding-top:32px;">Profit harian : <font style="color: #ddc088; " id="dayincome"> Rp {{getAmount($plan->profit)}}</font>
                    </div>
                    <div style="padding-top:10px;">Durasi produk : <font style="color: #ddc088; " id="day">
                            {{$plan->repeatable}} hari</font>
                    </div>
                    <div style="padding-top:10px;">Pengembalian modal : <span @if($plan->is_capital_back ==1)
                            style="color:green;" @else style="color:red;" @endif>{{($plan->is_capital_back==1) ?
                            trans('Ya'): trans('Tidak')}}</span></div>
                </div>
            </div>
            <div style="margin-top:25px; text-align: center; color: #fff; font-size: 12px; ">
                <button id="Lease" style="width: 80%; font-size:12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 100px; height: 45px; ">
                    Pembelian
                </button>
            </div>
            <div style="background: #0f275650; height: auto; width: 80%; margin: 0 auto; margin-top: 25px; text-align: left; color: #fff; font-size: 12px; ">
                <div style="padding:20px; text-align:left;">
                    1. Produk <i><b>Spaceship 1 & Spaceship 2</b></i> hanya dapat dibeli 1 kali, dan untuk produk lainnya dapat dibeli tanpa ada batasan.<br /><br />
                    
                    2. Anda akan menerima keuntungan setiap 24 jam pada waktu yang sama ketika produk mulai berjalan.<br /><br />

                    3. Pengembalian modal akan otomatis diberikan saat produk kadarluasa.<br />
                    <br />

                    4. Setelah produk berjalan profit harian otomatis masuk ke akun anda tanpa tugas apapun, silahkan cek profit harian anda pada halaman "Riwayat saldo"<br /><br />
                </div>
            </div>
        </div>
    </div>
</body>
</html>
