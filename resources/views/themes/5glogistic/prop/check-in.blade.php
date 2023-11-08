<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Check-in</title>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/meun.css')}}">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <script type="text/javascript">
        var time = 5;
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules/')}}/"
        }).use(['form', 'layedit', 'laydate', 'layer', 'carousel', 'flow', 'element', 'cookie'], function () {
            var form = layui.form;
            var element = layui.element;
            var $ = layui.jquery, layer = layui.layer;
            var carousel = layui.carousel;
            var cookie = layui.cookie;
            var topindex = parent.layer.getFrameIndex(window.name);
            $().ready(function () {

                function getuserinfo() {
                    var url = "{{route('user.check-in-count-ajax')}}";
                    var pm = {
                    };
                    $.getJSON(url, pm,
                        function (json) {
                            $("#amount").html(json.amount);
                            $("#check_income").html(json.check_income);
                        });
                }

                $(document).on("click", '#Start', function () {
                    var index = layer.load();
                    var url = "{{route('user.check-in-ajax')}}";
                    var pm = {
                    };
                    $.getJSON(url, pm,
                        function (json) {
                            getuserinfo();
                            error(json.message);
                            $("#Start").addClass("gray");
                            $("#Start").attr("id", "Start1");
                            layer.close(index);
                        });
                });



                $("#btnClose").click(function () {
                    parent.layer.close(topindex);
                });
            });
        });

    </script>

    <style type="text/css">
        .indexdiv {
            background: #000;
            position: fixed;
            left: 0px;
            top: 0px;
            bottom: 0px;
            width: 100%;
            height: 100%;
            display: none;
            z-index: 101;
            filter: alpha(opacity=85);
            opacity: 0.85 !important;
        }

        .topname {
            line-height: 46px;
            font-weight: 700;
            font-size: 16px;
            width: 50%;
            text-align: center;
            color: #000;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
        }

        .layui-layer-tips {
            width: 250px !important;
            background: 0 0;
            box-shadow: none;
            border: none;
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

        .layui-layer-btn .layui-layer-btn0 {
            border-color: #117546 !important;
            background-color: #117546 !important;
            color: #fff;
        }

        .gray {
            /*grayscale(val):val值越大灰度就越深*/
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            -ms-filter: grayscale(100%);
            -o-filter: grayscale(100%);
            filter: grayscale(100%);
            filter: gray;
        }

        .itemtype {
            float: left;
            width: 33.33%;
            height: 50px;
            font-weight: bold;
            color: #fff;
            font-family: PingFang SC-Regular, PingFang SC;
        }

        .itemtypeover {
            float: left;
            width: 33.33%;
            height: 50px;
            text-align: center;
            font-weight: bold;
            color: #FED76F;
            font-family: PingFang SC-Regular, PingFang SC;
        }
    </style>
</head>

<body style="background-size: 100% auto; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat;  background-size: 100% auto; ">
    <div style=" max-width:450px; margin:0 auto;">
        <div style="width: 100%; margin: 0 auto; background: none; border-bottom: 0px solid #117546; " class="top">
            <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
                <i class="layui-icon"
                    style=" color: #fff; margin-left: 12px; font-size: 18px; font-weight: bold;">&#xe603;</i>
            </div>
            <font class="topname" style="color: #fff;">
                Check-in
            </font>
            <div style="float:right; text-align:right; line-height:46px;width:50%;">
                <!--<i class="layui-icon" style=" color:#fff; margin-right:10px; font-size:20px; " id="Record">&#xe60a;</i>-->
            </div>
        </div>

        <div
            style=" height: auto; width: 95%; background: url({{asset('assets/frontend/ui/bg1-4.png')}}) no-repeat; background-size: 100% auto; margin: 0 auto; overflow: hidden; margin-top: 100px; padding-bottom: 100px; ">
            <div class="btn"
                style="  height:70px; margin-top:15px; width:100%;  line-height:35px ; text-align:center; font-size: 13px;border:0px; border-radius: 5px; font-size: 13px;">
                <div style="width:50%; float:left;">
                    <div style="color:#fff; font-size:16px;">Rp <font id="amount">{{$walletBalance}}</font>
                    </div>
                    <div style="color: #999; font-size: 14px;">Saldo tersedia</div>
                </div>
                <div style="width:50%; float:left;">
                    <div style="color: #fff; font-size: 16px;">Rp <font id="check_income">{{$checkInRevenue}}</font>
                    </div>
                    <div style="color: #999; font-size: 14px;">Total bonus</div>
                </div>
            </div>
            <div
                style="width:100%;position:relative; margin:0 auto; margin-top:10px;height:auto;   overflow:hidden;border:0px;  ">
                <div
                    style="width: 100%; text-align: center; height: 50px; line-height: 50px; color: #ddc088; border-radius: 5px; ">
                    Jumlah bonus kehadiran: <font id="dayss" style="font-weight:bold;">Rp 2000</font>
                </div>
            </div>
            <div style="width:100%;position:relative; margin:0 auto; margin-top:15%;border-radius:5px; height:auto; text-align:center; overflow:hidden;border:0px;  ">
                @if(Auth::user()->checked_in == 1)
                <div id="Start1" class="gray" style="width: 120px; text-align: center; margin:0 auto; height: 120px; line-height: 120px; color: #fff; border-radius: 100px; background: linear-gradient(to right,#ddc088,#c0892f); ">
                    Bonus terambil
                </div>
                @else
                <div id="Start" style="width: 120px; text-align: center; margin:0 auto; height: 120px; line-height: 120px; color: #fff; border-radius: 100px; background: linear-gradient(to right,#ddc088,#c0892f); ">
                    Ambil bonus
                </div>
                @endif

            </div>
        </div>
    </div>
</body>
</html>
