<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Recharge</title>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css?1.2')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css?v1.2')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v1.3')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/meun.css?v1.3')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/layer_mobile/need/layer.css?v1.3')}}">
    <script src="{{asset('assets/frontend/js/clipboard.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <script type="text/javascript">
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules')}}/"
        }).use(['form', 'layedit', 'laydate', 'layer', 'upload', 'carousel', 'flow', 'element', 'cookie', 'mobile'], function() {
            var form = layui.form;
            var element = layui.element;
            var $ = layui.jquery
                , layer = layui.layer;
            var carousel = layui.carousel;
            var cookie = layui.cookie;
            var mobile = layui.mobile;
            var mobilelayer = mobile.layer;
            var upload = layui.upload;
            var topindex = parent.layer.getFrameIndex(window.name);
            $().ready(function() {
                bankcardinfo();

                getsiteconfig();
                getpaywiinfo();
                pay_channel();


                function getsiteconfig() {
                    var url = "/ashx/LoginServer.ashx";
                    var pm = {
                        action: "getcon"
                        , time: Math.random()
                    };
                    $.ajaxSettings.async = false;
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                $("#uhuilv").val(json.JsonResult.uhuilv);
                                var re = (1 / (json.JsonResult.uhuilv * 1)).toFixed(6);
                                re = Number(re.toString().match(/^\d+(?:\.\d{0,2})?/))
                                $("#jjg").html(re.toFixed(2));
                                if (json.JsonResult.amounts != "") {
                                    var amounts = json.JsonResult.amounts.split(',');
                                    var html = "";
                                    for (var i = 0; i < amounts.length; i++) {
                                        if (i % 4 == 0)
                                            html += "<button style=\"width:24%; float:left; margin-top:10px;background:#fff; text-align:center;cursor:pointer; border:0px;border-radius: 5px; height:35px; \" class='item' value='" + amounts[i] + "'>";
                                        else
                                            html += "<button style=\"width:24%; float:left;margin-left:1%;background:#fff; margin-top:10px;cursor:pointer;border:0px;border-radius: 5px; text-align:center;height:35px; \" class='item' value='" + amounts[i] + "'>";
                                        html += "<div style=\"border: 1px solid #fff; padding:7px;  color:#888; padding-left:0px; padding-right:0px; border-radius: 5px;\">";
                                        html += "<i class=\"layui-icon \" style='font-size:12px;'></i> " + amounts[i] + "";
                                        html += "</div>";
                                        html += "</button>";
                                    }
                                    $("#amountlist").html(html);
                                }
                            }
                            CommAlert(json);
                        });
                }

                upload.render({
                    elem: "#upload1"
                    , acceptMime: 'image/*'
                    , size: 51200
                    , url: "/ashx/UpLoadServer.ashx?action=uploadimg&time=" + Math.random()
                    , done: function(res) {
                        if (res.code = "200") {
                            $("#upload1").attr("src", res.url);
                            $("#upimgurl").val(res.url);
                        } else
                            $("#upload1").attr("src", res.url);
                        layer.msg(res.msg);
                    }
                });


                function getpaywiinfo() {
                    var url = "/ashx/BusServer.ashx";
                    var pm = {
                        action: "getpaywiinfo"
                        , time: Math.random()
                    };
                    $.ajaxSettings.async = false;
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                $("#payinfo").html(json.JsonResult.payinfo);

                            }
                            CommAlert(json);
                        });
                }

                function bankcardinfo() {
                    var url = "/ashx/BusServer.ashx";
                    var pm = {
                        action: "bankcardinfo"
                        , time: Math.random()
                    };
                    $.ajaxSettings.async = false;
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                $("#cardname").val(json.JsonResult.cardname);
                                $("#carduname").val(json.JsonResult.carduname);
                                $("#account").val(json.JsonResult.account);
                                $("#copy1").attr("data-clipboard-text", json.JsonResult.cardname);
                                $("#copy2").attr("data-clipboard-text", json.JsonResult.carduname);
                                $("#copy3").attr("data-clipboard-text", json.JsonResult.account);
                            }
                            CommAlert(json);
                        });
                }

                function pay_channel() {
                    var url = "/ashx/BusServer.ashx";
                    var pm = {
                        action: "pay_channel"
                        , time: Math.random()
                    };
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                var html = "";
                                if (json.JsonResult.length == 0) {
                                    var _recharge_t15 = $('#_recharge_t15').val();
                                    html += "<div style=\"height:50px;line-height:50px; text-align:center; width:100%;\">";
                                    html += _recharge_t15;
                                    html += "</div>";
                                } else {
                                    for (var i = 0; i < json.JsonResult.length; i++) {

                                        if (i == 0) {
                                            if (json.JsonResult[i].id == "3") {
                                                $("#cards1").show();
                                                $("#cards2").show();
                                                $("#cards3").show();
                                                $("#cards4").show();
                                                bankcardinfo();
                                            }
                                            if (json.JsonResult[i].id == "2") {
                                                $("#Uhl").show();
                                            } else {
                                                $("#Uhl").hide();
                                            }
                                            $("#pay_min").html("Rp " + json.JsonResult[i].minamount + " - Rp " + json.JsonResult[i].maxamount);
                                            $("#channel").val(json.JsonResult[i].id);
                                            html += "<div min='" + json.JsonResult[i].minamount + "' max='" + json.JsonResult[i].maxamount + "' style=\"width:47%; border: 1px solid #fff;cursor:pointer;color:#000; height:40px;line-height:20px; float:left;margin-left:2%; margin-top:10px; text-align:center;position: relative;border-radius: 5px;\" class='payitem channelitem' value=\"" + json.JsonResult[i].id + "\">";
                                        } else
                                            html += "<div min='" + json.JsonResult[i].minamount + "' max='" + json.JsonResult[i].maxamount + "' style=\"width:47%;  border: 1px solid #fff;cursor:pointer;color:#000; height:40px;line-height:20px; float:left;margin-left:2%; margin-top:10px; text-align:center;position: relative;border-radius: 5px;\" class='payitem1 channelitem' value=\"" + json.JsonResult[i].id + "\">";
                                        html += "<div style=\"padding:10px; padding-left:0px; font-size:12px; padding-right:0px;\">";
                                        html += json.JsonResult[i].name;
                                        html += "</div>";
                                        html += "</div>";
                                    }
                                }
                                $("#paylist").html(html);
                            }
                            CommAlert(json);
                        });
                }

                $(document).on("click", '#log', function() {
                    var url = "{{route('user.payin-log')}}";
                    parent.layer.open({
                        type: 2
                        , title: false
                        , area: ['100%', '100%']
                        , shadeClose: true
                        , isOutAnim: false
                        , closeBtn: 0
                        , anim: 5
                        , shade: [0.8, '#393D49']
                        , maxmin: false
                        , content: url
                    });
                });

                $(document).on("click", '.channelitem', function() {
                    $(".channelitem").each(function() {
                        $(this).addClass("payitem1");
                        $(this).removeClass("payitem");
                    });
                    $(this).addClass("payitem");
                    $(this).removeClass("payitem1");
                    var id = $(this).attr("value");
                    var min = $(this).attr("min");
                    var max = $(this).attr("max");
                    $("#channel").val(id);
                    if (id == "3") {
                        $("#cards1").show();
                        $("#cards2").show();
                        $("#cards3").show();
                        $("#cards4").show();
                        bankcardinfo();
                        $("#Uhl").hide();
                    } else {
                        if (id == "2") {
                            $("#Uhl").show();
                        } else {
                            $("#Uhl").hide();
                        }
                        $("#cards1").hide();
                        $("#cards2").hide();
                        $("#cards3").hide();
                        $("#cards4").hide();
                    }
                    $("#pay_min").html("Rp " + min + " - Rp " + max);
                });

                $("#amount").keydown(function() {
                    var a = $("#amount").val();
                    var bili = $("#uhuilv").val() * 1;
                    var re = (a / bili).toFixed(6);
                    re = Number(re.toString().match(/^\d+(?:\.\d{0,2})?/))
                    $("#jieguo").html("Rp " + a + " = U " + re.toFixed(2) + " ");
                });

                $("#amount").keyup(function() {
                    var a = $("#amount").val();
                    var bili = $("#uhuilv").val() * 1;
                    var re = (a / bili).toFixed(6);
                    re = Number(re.toString().match(/^\d+(?:\.\d{0,2})?/))
                    $("#jieguo").html("Rp " + a + " = U " + re.toFixed(2) + " ");
                });

                $(document).on("click", '.item', function() {
                    $("#amount").val($(this).attr("value"));
                    var a = $("#amount").val();
                    var bili = $("#uhuilv").val() * 1;
                    var re = (a / bili).toFixed(6);
                    re = Number(re.toString().match(/^\d+(?:\.\d{0,2})?/))
                    $("#jieguo").html("Rp " + a + " = U " + re.toFixed(2) + " ");
                });

                $(document).on("submit", '#recharge-form', function(e) {
                    e.preventDefault();

                    $('#recharge-btn').attr('disabled', true);
                    $('#recharge-btn').text('Processing...');

                    var amount = $("#amount").val();

                    var url = "{{route('user.acpay.deposit')}}";
                    var pm = {
                        _token: "{{csrf_token()}}"
                        , amount: amount
                    };

                    var index = layer.load();

                    $.ajax({
                        url: url
                        , method: "POST"
                        , dataType: "json"
                        , data: pm
                        , success: function(data) {

                            layer.close(index);

                            parent.layer.open({
                                type: 2
                                , title: "Recharge"
                                , area: ['100%', '100%']
                                , shadeClose: true
                                , isOutAnim: false
                                , closeBtn: 1
                                , anim: 5
                                , shade: [0.8, '#393D49']
                                , maxmin: false
                                , content: data.url
                                , end: function() {

                                    var index = layer.load();

                                    setTimeout(() => {
                                        $.ajax({
                                            url: "{{route('user.acpay.check-payin')}}"
                                            , method: "POST"
                                            , dataType: "json"
                                            , data: {_token: "{{csrf_token()}}"}
                                            , success: function(data) {
                                                error(data.message);
                                                layer.close(index);

                                                $('#recharge-btn').attr('disabled', false);
                                                $('#recharge-btn').text('Top Up');

                                            }
                                            , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                                                var errors = jqXhr.responseJSON;
                                                var errorsHtml = '';
                                                $.each(errors['errors'], function(index, value) {
                                                    errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                                                });
                                                error(errorsHtml);
                                                parent.layer.close(index);

                                                $('#recharge-btn').attr('disabled', false);
                                                $('#recharge-btn').text('Top Up');
                                            }
                                        });
                                    }, 1000);


                                }
                            });


                        }
                        , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function(index, value) {
                                errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                            });
                            error(errorsHtml);
                            layer.close(index);
                        }
                    });
                });

                $(document).on("click", '#btnClose', function() {
                    parent.layer.close(topindex);
                });
            });
        });

    </script>
    <style type="text/css">
        input::placeholder {
            color: #bbb;
            font-weight: 100;
        }

        h3 {
            color: #fff !important;
            font-weight: bold;
        }

        .layui-m-layerbtn span[no] {
            border-right: 1px solid #D0D0D0;
            border-radius: 0 0 0 5px;
            color: #000 !important;
        }

        .layui-m-layerbtn span[yes] {
            color: orange !important;
            font-weight: bold;
        }

        .layui-m-layerchild {
            color: #fff !important;
            position: relative;
            display: inline-block;
            text-align: left;
            background-color: #085efa;
            font-size: 14px;
            border-radius: 5px;
            box-shadow: 0 0 8px rgb(0 0 0 / 10%);
            pointer-events: auto;
            -webkit-overflow-scrolling: touch;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation-duration: .2s;
            animation-duration: .2s;
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

        .bofang {
            position: absolute;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            height: 30px;
            border-radius: 100px;
        }

        .layui-border-green {
            border-color: #009688 !important;
            color: #009688 !important;
        }

        .layui-border-red {
            border-color: #FF5722 !important;
            color: #FF5722 !important;
        }

        .layui-border-blue {
            border-color: #1E9FFF !important;
            color: #1E9FFF !important;
        }

        .layui-form-item {
            margin-bottom: 10px;
            clear: both;
            *zoom: 1;
        }

        .layui-m-layercont {
            padding: 30px 15px;
            padding-top: 5px;
            line-height: 22px;
            text-align: center;
        }

        .layui-m-layerbtn span[yes] {
            color: #009688;
        }


        .layui-m-layercont {
            padding: 30px 15px;
            padding-top: 5px;
            line-height: 22px;
            text-align: center;
        }

        .layui-m-layerbtn span[yes] {
            color: #009688;
        }

        .payitem1 {
            border: 1px solid #fff !important;
            border-radius: 25px;
            background: #fff;
            color: #000 !important;
        }

        .payitem {
            border: 1px solid #c0892f !important;
            border-radius: 25px;
            background: linear-gradient(to right, #ddc088, #c0892f);
            color: #fff !important;
        }

        .payitem:before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            background: #fff;
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
            border-bottom: 1px solid #888 !important;
            background-color: #fff;
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
</head>

<body style="width: 100%; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% 200%;">
    <input type="hidden" id="min" value="0" />
    <input type="hidden" id="channel" value="2" />
    <input type="hidden" id="uhuilv" value="0" />
    <input type="hidden" id="upimgurl" value="" />
    <input type="hidden" id="_recharge_t15" value="" />

    <div class="top" style="background: none;">
        <div style="float:left; line-height:46px;width:50%; height:46px;cursor:pointer;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <div class="topname" id="topname1" style="line-height: 50px; font-weight: bold; color: #fff;">
            Top Up
        </div>
        <div style="float:right; text-align:right; line-height:46px;width:50%;" id="log">
            <img src="{{asset('assets/frontend/imgss/iconlog.png')}}" style="height: 27px;  margin-right: 10px; margin-bottom: 2px; border-radius: 50px;">
        </div>
    </div>

    <div style=" max-width:450px; margin:0 auto;">
        <div style="margin-top:40px;height:auto; overflow:hidden;">

            <div style="width:100%; margin:0 auto; margin-top:15px;  padding-bottom:15px; ">
                <div style="width: 98%; margin: 0 auto; padding-top: 10px;  border-radius: 5px; height: auto; overflow: hidden;">
                    <div style="padding-left:10px; padding-bottom:10px;font-weight:bold; color:#fff;">Metode pembayaran
                    </div>
                    <div id="paylist">
                        <div min="1500.00" max="50000.00" style="width:47%; border: 1px solid #fff;cursor:pointer;color:#000; height:40px;line-height:20px; float:left;margin-left:2%; margin-top:10px; text-align:center;position: relative;border-radius: 5px;" class="channelitem payitem" value="1">
                            <div style="padding:10px; padding-left:0px; font-size:12px; padding-right:0px;">Bank Transfer
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div style="width: 100%; margin: 0 auto;  padding-bottom: 3px; ">
                <div style="width:95%; margin:0 auto;  margin-top:5px; padding-bottom:3px;border-radius:2px; overflow:hidden;">
                    <div id="cards1" style="width: 100%; margin: 0 auto; display: none; background: #f1f1f1; margin-top: 10px; padding-top: 10px; padding-bottom: 20px; border-radius: 5px; height: auto; overflow: hidden;">
                        <div style="padding-left:10px;  padding-bottom:10px; margin-top:10px; font-weight:bold; "><span style="color:#000;" id="_recharge_t7">Transfer Information</span> <span style="font-size:12px; color:#ff6a00; font-weight:100; "></span></div>
                        <div id="cards2" style="display: none;">
                            <div style="text-align: center; width: 98%; margin: 0 auto; margin-bottom: 15px; ">
                                <div class="inputdiv">
                                    <div style="width:60px;text-align:right;" id="_recharge_t8">Payee</div>
                                    <input type="text" id="cardname" readonly="readonly" style="font-size:12px; color:#777; text-align:center;" class="layui-input" autocomplete="off">
                                    <button style="font-size: 12px; color: #0094ff; width: auto; height: 37px; border: 0px; background: #fff; font-weight: bold; " id="copy1">Copy</button>
                                </div>
                            </div>

                            <div style="text-align: center; width:98%; margin:0 auto; margin-bottom:15px; ">
                                <div class="inputdiv">
                                    <div style="width: 60px; text-align: right;" id="_recharge_t9">Bank</div>
                                    <input type="text" id="carduname" readonly="readonly" style="font-size: 12px; color: #777; text-align: center; " class="layui-input" autocomplete="off">
                                    <button style="font-size: 12px; color: #0094ff; width: auto; height: 37px; border: 0px; background: #fff; font-weight: bold; " id="copy2">Copy</button>
                                </div>
                            </div>

                            <div style="text-align: center; width:98%; margin:0 auto; margin-bottom:15px; ">
                                <div class="inputdiv">
                                    <div style="width: 60px; text-align: right;" id="_recharge_t10">Account</div>
                                    <input type="text" id="account" readonly="readonly" style="font-size: 12px; color: #777; text-align: center; " class="layui-input" autocomplete="off">
                                    <button style="font-size: 12px; color: #0094ff; width: auto; height: 37px; border: 0px; background: #fff; font-weight: bold; " id="copy3">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('user.acpay.deposit')}}" method="POST" id="recharge-form">
                        @csrf

                        <div style="width: 100%; margin: 0 auto; padding-top: 10px; padding-bottom: 20px; border-radius: 5px; height: auto; overflow: hidden; ">
                            <div>
                                <div style="width: 100%; margin: 0 auto; margin-top: 10px; padding-top: 10px; padding-bottom: 10px; height: auto; overflow: hidden; ">
                                    <div style="padding-left:5px; padding-bottom:10px;">
                                        <font style="font-weight: bold; color: #fff;">Jumlah topup</font>
                                        <font style="color:#fff;" class="small-font">（ Minimum Rp 10.000 ）</font>
                                    </div>
                                </div>

                                <div style="text-align: center; width:98%; margin:0 auto; margin-bottom:15px; margin-top:15px; ">
                                    <div class="inputdiv">
                                        <div style="width:25px;text-align:center;">
                                        Rp
                                        </div>
                                        <input type="number" id="amount" name="amount" maxlength="8" oninput="if(value.length>8)value=value.slice(0,8)" style="font-size: 14px; padding-left:0px; color: #666; font-weight:bold;  background-color: #fff;" placeholder=" Input nominal topup" class="layui-input" autocomplete="off">
                                    </div>
                                    <div class="inputdiv" style="margin-top: 10px; display: none;" id="cards3">
                                        <div style="line-height: 14px; margin-top:5px; width: 50px; font-size:12px;" id="_recharge_t2">Payer Name</div>
                                        <input type="text" id="transfername" maxlength="50" style="font-size:12px;" placeholder="Please enter the transfer name" class="layui-input" autocomplete="off">
                                    </div>
                                    <div style="text-align: center; float: left; width: 100%; height:auto; overflow: hidden; margin-top: 15px; display:none;" id="Uhl">
                                        <div style="width: 100%; margin:0 auto;">
                                            <div class="inputdiv" style="color: #eee; border: 0px !important; font-size: 12px;">
                                                <font style="color: #aaa;" id="jieguo">Rp 1 = U <font id="jjg">0</font>
                                                </font>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: center; float: left; width: 100%; height:auto; overflow: hidden; margin-top: 15px; display:none;">
                                        <div style="width: 100%; margin:0 auto; font-size:12px; color:red;">
                                            <font id="_recharge_t6">Recharge range</font>: <font id="pay_min">Rp 100.00 -
                                                Rp 49999.00</font>
                                        </div>
                                    </div>
                                    <div class="inputdiv" style="margin-top: 10px; height: 120px; display: none;" id="cards4">
                                        <div style=" width: 50px;" id="_recharge_t11">Proof</div>
                                        <div style="">
                                            <img src="{{asset('assets/frontend/imgs/up.png')}}" style='height:85px;width:85px; margin-top:10px; border-radius:5px;' class='upload' id="upload1" />
                                        </div>
                                    </div>
                                    <!--<div style="width:92%; height:25px;line-height:30px; display:none;  border-width: 0px;border-style: solid;border-radius: 2px 2px 2px 2px;  text-align:left;" id="Uhl">
                                        <span style=" float:left;  margin-left:10px; font-size:12px; color:#ff6a00;  " id="jieguo">(1 $ = <font id="jjg">0.0</font> USDT)</span>
                                    </div>-->
                                    <!--<div style="width:92%;display:none; height:25px;line-height:30px;  border-width: 0px;border-style: solid;border-radius: 2px 2px 2px 2px;  text-align:left;" id="Uhl1">
                                        <span style=" float:left;  margin-left:10px; font-size:12px; color:#ff6a00;  " id="jieguo1">(1 U = <font id="jjg1">3.7</font> $)</span>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center; width: 98%; margin: 0 auto; margin-bottom: 15px; margin-top: 20px; height: auto; overflow: hidden;">
                            <button class="layui-btn" id="recharge-btn" style="width: 100%; font-weight: bold; font-size: 14px; color: #fff; height: 45px; line-height: 45px; border-radius: 100px; border: 0px; background-image: linear-gradient(to right,#ddc088,#c0892f);" type="submit">
                                Top Up
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <div style="width: 100%; margin: 0 auto; ">
                <div style="width: 98%; margin: 0 auto; padding-bottom: 10px; border-radius: 3px; ">
                    <div style="height: 35px; line-height: 35px; text-align: center; "><span style=" color:#fff; font-weight:bold;" id="_recharge_t5">Informasi Topup</span></div>
                    <br>
                    <div style="text-align: left; padding: 20px; font-size:12px !important; padding-top: 0px; height: auto; overflow: hidden; color: #fff;" id="payinfo">
                        <p>1. Minimum pengisian topup adalah sebesar Rp 10.000</p>
                        <p><br></p>
                        <p>2. Jika saldo belum diterima dalam waktu setengah jam setelah pengisian ulang berhasil, mohon segera hubungi layanan pelanggan dan kirimkan kepada kami nomor akun dan bukti pembayaran yang sukses.</p>
                        <p><br></p>
                        <p>3. Jangan menyimpan akun penerima sebelumnya untuk transfer. Kwitansi pengisian ulang harus sesuai dengan jumlah pembayaran. Hindari kesalahan pembayaran.</p>
                        <p><br></p>
                        <p>4. Jangan mentransfer uang kepada orang asing, topup hanya dilakukan melalui halaman ini.</p>
                        <p><br></p>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </div>
</body>
</html>

<a href="#" target="_blank" style="display:none;"><span id="jump"></span></a>
