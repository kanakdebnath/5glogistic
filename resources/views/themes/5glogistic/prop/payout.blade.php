<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Withdrawal</title>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css?1.2')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css?v1.2')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v1.3')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/meun.css?v1.3')}}">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <style type="text/css">
        input::placeholder {
            color: #bbb;
            font-weight: 100;
        }

        .topname {
            line-height: 46px;
            font-weight: bold;
            font-size: 14px;
            width: 50%;
            text-align: center;
            color: #fff;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
        }

        layer-page .layui-layer-btn {
            padding-top: 0px !important;
        }

        .layui-layer-btn {
            text-align: center !important;
            padding: 0 0px 12px;
            pointer-events: auto;
            user-select: none;
            -webkit-user-select: none;
        }

        .layui-layer-btn a {
            margin: 5px 5px 0;
            padding: 0 0px !important;
            height: 28px;
            line-height: 28px;
            text-align: center;
            width: 50%;
            border: 1px solid #dedede;
            background-color: #fff;
            color: #333;
            border-radius: 2px;
            font-weight: 400;
            cursor: pointer;
            text-decoration: none;
            border-radius: 20px !important;
        }

        .layui-layer-page {
            border-radius: 20px !important;
        }

        .layui-layer-setwin .layui-layer-close2 {
            background-position: -179px -31px;
            cursor: pointer
        }

        .layui-layer-setwin a {
            position: absolute;
            width: 32px;
            height: 40px;
            _overflow: hidden;
            top: -28px;
        }

        .payitem1 {
            border: 1px solid #fff !important;
            border-radius: 5px;
            background: #fff !important;
            color: #000;
            height: 40px;
        }

        .payitem {
            border: 1px solid #c0892f !important;
            border-radius: 5px;
            background: linear-gradient(to right, #ddc088, #c0892f);
            color: #fff;
            height: 40px;
        }

        .payitem:before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            background: #c0892f;
            /* border: 16px solid #0081ff;
                border-top-color: transparent;
                border-left-color: transparent;
                border-bottom-right-radius: 3px;*/
        }

        .payitem:after {
            content: '';
            width: 5px;
            height: 12px;
            position: absolute;
            right: 6px;
            bottom: 6px;
            background: #c0892f;
            /*  border: 2px solid #fff;
                border-top-color: transparent;
                border-left-color: transparent;
                transform: rotate(45deg);
                border-bottom-right-radius: 5px;*/
        }

        div#div1 {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
        }

        div#div1>img {
            height: 100%;
            width: 100%;
            border: 0;
        }

        .inputdiv {
            display: flex;
            border: 1px solid #111 !important;
            background-color: #243a62;
            height: 38px;
            line-height: 38px;
            padding: 0px 15px;
            border-radius: 5px;
            color: #000;
        }

        .layui-input {
            border-style: none;
            background-color: none;
        }

        .small-font {
            font-size: 12px;
            -webkit-transform-origin-x: 0;
            -webkit-transform: scale(0.80);
        }

        .smallsize-font {
            font-size: 9.6px;
        }

    </style>
    <script type="text/javascript">
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules/')}}"
        }).use(['form', 'layedit', 'laydate', 'layer', 'carousel', 'flow', 'element', 'cookie'], function() {
            var form = layui.form;
            var element = layui.element;
            var $ = layui.jquery
                , layer = layui.layer;
            var carousel = layui.carousel;
            var cookie = layui.cookie;
            var topindex = parent.layer.getFrameIndex(window.name);
            $().ready(function() {

                $(document).on("click", '#log', function() {
                    var url = "{{route('user.payout-log')}}"
                    layer.open({
                        type: 2
                        , title: false
                        , area: ['100%', '100%']
                        , offset: 'b'
                        , shadeClose: true
                        , isOutAnim: false
                        , closeBtn: 0
                        , anim: 5
                        , shade: [0.8, '#393D49']
                        , maxmin: false
                        , content: url
                    });
                });

                // $("#Amount").keydown(function () {
                //     var channel = $("#channel").val();
                //     var a = $("#Amount").val();
                //     if (a == null || a == "")
                //         a = 1;
                //     var free = $("#bank_free").val();
                //     var freeamount = a * free * 1;
                //     var sjamount = a - freeamount;
                //     sjamount = Number(sjamount.toString().match(/^\d+(?:\.\d{0,0})?/))
                //     $("#jieguo1").html("Rp " +sjamount.toFixed(2) );
                // });

                // $("#Amount").keyup(function () {
                //     var channel = $("#channel").val();
                //     var a = $("#Amount").val();
                //     if (a == null || a == "")
                //         a = 1;
                //     var free = $("#bank_free").val();
                //     var freeamount = a * free * 1;
                //     var sjamount = a - freeamount;
                //     sjamount = Number(sjamount.toString().match(/^\d+(?:\.\d{0,0})?/))
                //     $("#jieguo1").html("Rp " + sjamount.toFixed(2) );
                // });

                $('#Amount').on('keydown keyup', function() {


                    var amount = parseInt($(this).val());
                    if (isNaN(amount) || amount == null || amount == "" || amount < 0) {
                        $("#jieguo1").html("Rp " + "0.00");
                        return;
                    }

                     var fixed_charge = 7500;
                    var percentage_charge = parseFloat("{{$gateway->percent_charge}}");
                    var total_charge = Number(amount - Number(fixed_charge));

                    $("#jieguo1").html("Rp " + total_charge.toFixed(2));
                    // $('#charge').val(Number(parseInt($(this).val()) - parseInt("{{$gateway->fixed_charge}}") - (parseInt($(this).val()) / 100 * parseInt("{{$gateway->percent_charge}}"))));
                });

                // $(document).on("click", '#Amount', function () {
                //     var channel = $("#channel").val();
                //     var a = $("#Amount").val();
                //     if (a == null || a == "")
                //         a = 1;
                //     var free = $("#bank_free").val();
                //     var freeamount = a * free * 1;
                //     var sjamount = a - freeamount;
                //     sjamount = Number(sjamount.toString().match(/^\d+(?:\.\d{0,0})?/))

                //     $("#jieguo1").html("Rp " +sjamount.toFixed(2) );
                // });


                $(document).on("submit", '#withdraw-form', function(e) {
                    e.preventDefault();

                    $('#withdraw-btn').attr('disabled', true);
                    $('#withdraw-btn').text('Processing...');

                    var gateway = $("#gateway").val();
                    var bankid = $("#bankid").val();
                    var amount = $("#Amount").val();
                    var paypassword = $("#paypassword").val();
                    var url = "{{route('user.acpay.payout')}}";
                    var pm = {
                        _token: "{{csrf_token()}}"
                        , gateway: gateway
                        , amount: amount
                        , account_id: bankid
                        , password: paypassword

                    , };

                    var index = layer.load();

                    $.ajax({
                        url: url
                        , method: "POST"
                        , dataType: "json"
                        , data: pm
                        , success: function(data) {
                            layer.close(index);
                            error(data.message);
                            // $("#Amount").val("");
                            $('#withdraw-btn').attr('disabled', false);
                            $('#withdraw-btn').text('Withdraw money now');
                        }
                        , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function(index, value) {
                                errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                            });
                            error(errorsHtml);
                            layer.close(index);

                            $('#withdraw-btn').attr('disabled', false);
                            $('#withdraw-btn').text('Withdraw money now');
                        }
                    });

                });

                $(document).on("click", '#selectcard', function() {
                    var url = "{{route('user.accounts')}}";
                    layer.open({
                        type: 2
                        , title: false
                        , area: ['100%', '100%']
                        , offset: 'b'
                        , shadeClose: true
                        , isOutAnim: false
                        , closeBtn: 0
                        , anim: 5
                        , shade: [0.8, '#393D49']
                        , maxmin: false
                        , content: url
                    });
                });

                $(document).on("click", '#btnClose', function() {
                    parent.layer.close(topindex);
                });

            });
        });

    </script>
</head>
<body style="width: 100%; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% 200%; ">
    <input id="_withdrawal_t5" type="hidden" value="" />
    <input id="_withdrawal_t6" type="hidden" value="" />
    <input id="_withdrawal_t11" type="hidden" value="" />

    <input id="bankid" type="hidden" value="0" />
    <input id="channel" type="hidden" value="0" />

    <input id="uhuilv" type="hidden" value="0" />
    <input id="bank_free" type="hidden" value="0" />

    <input type="hidden" name="gateway" id="gateway" value="{{$gateway->id}}">
    <input type="hidden" name="wallet_type" value="balance">

    <div class="top" style="background: none; border: 0px !important;">
        <div style="float:left; line-height:46px;width:50%; height:46px;cursor:pointer;" id="btnClose">
            <i class="layui-icon" style="color:#fff; margin-left:12px; font-size:18px;font-weight:bold;">&#xe603;</i>
        </div>
        <div class="topname" id="topname1" style="line-height: 50px; font-weight: bold; color: #fff;">
            Withdraw
        </div>
        <div style="float:right; text-align:right; line-height:46px;width:50%;" id="log">
            <img src="{{asset('assets/frontend/imgss/iconlog.png')}}" style="height: 27px;  margin-right: 10px; margin-bottom: 2px; border-radius: 50px;">
        </div>
    </div>

    <div style=" max-width:450px; margin:0 auto;">
        <div style=" margin-top: 48px;  height:auto; overflow:hidden; ">
            <div style="width: 100%; margin: 0 auto; background: none;  padding-top:10px; padding-bottom:10px;  height: auto; overflow: hidden; ">
                <div style="background: url({{asset('assets/frontend/ui/icon-bg.png')}}) no-repeat; background-size: 100% 100%; width: 95%; margin: 0 auto; height: 100px; ">
                    <div style="padding-left: 20px; padding-top: 18px; font-weight: bold; color: #fff; font-size:12px;">Saldo anda :</div>
                    <div style="color: #fff; padding-left: 20px; padding-top: 5px; ">
                        {{config('basic.currency_symbol')}}
                        <font id="useramount" style="padding-left:5px; font-weight:bold; font-size:22px; padding-top:15px;">{{$walletBalance}}</font>
                    </div>
                </div>
            </div>

            <div style="width: 100%; margin: 0 auto; background: none; padding-bottom: 3px; ">
                <div style="width:95%; margin:0 auto;  padding-bottom:3px;border-radius:2px; overflow:hidden;">

                    <div style="width:100%; margin:0 auto;  margin-top:10px; padding-top:10px; padding-bottom:20px;border-radius:5px;height:auto; overflow:hidden;">
                        <div style="padding-left:10px; padding-bottom:10px;font-weight:bold; color:#fff;">Metode withdraw</div>
                        <div id="paylist">
                            <div style="width:47%; border: 1px solid #fff;cursor:pointer;color:#fff; height:40px;line-height:20px; float:left;margin-left:2%; margin-top:10px; text-align:center;position: relative;border-radius: 5px;" class="channelitem payitem" value="1">
                                <div style="padding:10px; padding-left:0px; font-size:12px; padding-right:0px;">Kartu bank
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-left:10px; height:25px; line-height:25px; " id="FreeUi">
                        <span style="color: #fff; font-size: 12px;">
                            <font>Pajak</font>: <font id="free">Rp {{number_format($gateway->fixed_charge)}}</font>
                        </span>
                        <font id="ttinfo" style="margin-left:5px;"></font>
                    </div>

                    <form action="{{route('user.acpay.payout')}}" method="POST" id="withdraw-form">
                        @csrf
                        <div>
                            <div class="layui-form-item">
                                <div style="width:98%; margin:0 auto;" id="amountlist">

                                </div>
                            </div>

                            <div style="text-align: center; width: 98%; margin: 0 auto; margin-bottom: 15px; height: auto; overflow: hidden;">
                                <button type="button" class="inputdiv" style="line-height: 42px; width: 100%; height: 45px; border: 0px; background: #243a62; padding: 0 0px; z-index: 500;" id="selectcard">
                                    <img src="{{asset('assets/frontend/imgs/nav.png')}}" style="height: 22px; padding-left:10px; margin-top: 7px; padding-bottom:5px;" id="imgurl" />
                                    <font style="margin-left:10px; height:38px; width:100%; color:#fff; text-align:left;" id="select_card"> Pilih akun bank </font>
                                    <div style="float: left; width: 10%; text-align: right; height: 35px; line-height: 38px; color: #FFF; ">
                                        <i class="layui-icon layui-icon-right"></i>
                                    </div>
                                </button>

                                <div style="width: 98%; margin: 0 auto; text-align: left; margin-bottom:10px; margin-top: 20px; color: #fff; font-weight: bold;">
                                    Jumlah withdraw <span class="text-muted"><small>( {{$basic->currency_symbol}} {{number_format($gateway->minimum_amount)}} - {{$basic->currency_symbol}} {{number_format($gateway->maximum_amount)}} )</small></span>
                                </div>
                                <div class="inputdiv">

                                    <!--<div style="width:30px;color:#fff;">
                                        Rp
                                    </div>-->
                                    <input type="number" id="Amount" style="font-size: 12px; background: #243a62; color: #fff; padding-left: 0px;" placeholder="Input jumlah withdraw" class="layui-input" autocomplete="off">
                                </div>

                                <div style="width: 98%; margin: 0 auto; text-align: left; margin-bottom: 10px; margin-top: 20px; color: #fff; font-weight: bold;">
                                    Sandi penarikan
                                </div>
                                <div class="inputdiv">
                                    <div style="width: 30px; color: #fff;">
                                        <i class="layui-icon layui-icon-password"></i>
                                    </div>
                                    <input type="password" id="paypassword" maxlength="20" style="color: #fff; background: #243a62; padding-left: 0px; " placeholder="Input sandi penarikan" autocomplete="one-time-code" class="layui-input" />
                                </div>

                                <!--<div style="text-align: center; float: left; width: 100%;  height:auto; overflow: hidden;display:none; margin-top: 10px; margin-bottom:10px;" id="Uhl">
                                    <div style="width: 100%; margin:0 auto;  text-align:center;">
                                        <div class="inputdiv" style="color: #ccc; width: 100%; text-align: center; padding-left: 10px; font-size: 12px; ">
                                            <font style="color: #ccc;" id="jieguo">Rp  1 = U <font id="jjg">0</font></font>
                                        </div>
                                    </div>
                                </div>-->
                                <div style="width:100%; height:25px;  line-height:25px; text-align:left;margin-top:10px; display:none;">
                                    <span style="float: left; color: #ff6a00; margin-left:10px; font-size:12px;">
                                        <font id="_withdrawal_t11">Minimum</font>
                                        <font id="wi_min">0.00</font> Rp
                                    </span>
                                    <font style="float:right;color: #ff6a00; font-size:12px;">
                                        <font id="_withdrawal_t12">Maximum</font>
                                        <font id="wi_max">0.00</font> Rp
                                    </font>
                                </div>
                                <div style="width: 100%; height: 25px; line-height: 30px; margin-top:10px;  border-width: 0px; border-style: solid; border-radius: 2px 2px 2px 2px; text-align: left;">
                                    <span style=" float:left;font-size:12px; color:#ff6a00;  ">
                                        <font>Jumlah bersih</font>:
                                        <font id="jieguo1">{{config('basic.currency_symbol')}} 0</font>
                                    </span>
                                </div>
                                <!--<div style="float: right;color:rgb(42,175,254); text-decoration: underline;cursor:pointer; text-align:right; font-size:12px; height:25px; line-height:25px;" id="change">Change wallet password</div>-->
                            </div>
                        </div>
                        <div style="text-align: center;width:98%; margin:0 auto; margin-bottom:15px;">
                            <input class="layui-btn" value="Ajukan penarikan" id="withdraw-btn" style="width: 100%; margin-top: 25px; font-weight: bold; color: #fff; font-size: 14px; border-radius: 25px; border: 0px; background: linear-gradient(to right,#ddc088,#c0892f); " type="submit" />
                        </div>
                    </form>
                </div>

            </div>

            <div style="width:98%; margin:0 auto;  margin-top:10px;">
                <div style="height:35px; line-height:35px; text-align:center;"><span style="margin-left:5%; color:#fff; font-weight:bold;" id="_withdrawal_t10">Informasi withdraw</span></div>
                <div style="text-align: left; padding:20px; padding-top:0px; height:auto; overflow:hidden;color:#fff; font-size:12px !important; " id="wiinfo">
                    <p>1. Penarikan dibuka 24 jam setiap hari nya tanpa adanya hari libur.</p>
                    <p>2. Batas penarikan pengguna adalah 1 kali / hari.</p>
                    <p>3. Rp 7,500 pajak penarikan digunakan untuk operasional platform</p>
                    <p>4. Penarikan anda akan diterima dalam waktu 1-30 menit setelah pengajuan, terkecuali terdapat gangguan pada bank anda</p>
                    <p>5. Harap masukan jumlah dan data penarikan dengan benar agar penarikan anda berhasil, silahkan ajukan penarikan ulang jika penarikan mengalami kegagalan</p>
                    <p>6. Kecurangan pada penarikan akan menyebabkan akun bank anda dibekukan oleh platform. </p>
                    <p>7. Pengguna diwajibkan memiliki minimal 1 prodik investasi apapun untuk melakukan penarikan</p>
                </div>
            </div>
            <br />
            <br />
        </div>
    </div>
</body>
</html>
