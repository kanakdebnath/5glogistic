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
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v2.7')}}">
    <style type="text/css">
        .topname {
            line-height: 46px;
            font-size: 14px;
            width: 75%;
            text-align: center;
            color: #fff;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
            font-weight: bold;
        }

        div {
            cursor: pointer;
        }

        .typeitem {
            color: #888;
            float: left;
            margin-left: 3%;
            cursor: pointer;
            font-family: 黑体;
            font-size: 13px;
            margin-top: 10px;
            margin-bottom: 2px;
        }

        .typeitemover {
            margin-top: 10px;
            color: #085efa;
            border-bottom: 1px solid #085efa;
            margin-bottom: 1px;
            float: left;
            margin-left: 3%;
            cursor: pointer;
            font-family: 黑体;
            font-size: 13px;
        }

    </style>
    <script>
        layui.use(['form', 'carousel', 'flow', 'element', 'carousel', 'flow', 'element', 'cookie'], function() {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var carousel = layui.carousel;
            var flow = layui.flow;
            var element = layui.element;
            var topindex = parent.layer.getFrameIndex(window.name);

            $().ready(function() {
                getcsinfo();
                getkefu();

                function getkefu() {
                    var url = "/ashx/BusServer.ashx";
                    var pm = {
                        action: "getkefu1"
                        , time: Math.random()
                    };
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                $("#telegram").val(json.JsonResult.telegram);
                                $("#whatsapp").val(json.JsonResult.whatsapp);
                            }
                            CommAlert(json);

                        });
                }

                function getcsinfo() {
                    var url = "/ashx/BusServer.ashx";
                    var pm = {
                        action: "getcsinfo"
                        , time: Math.random()
                    };
                    $.getJSON(url, pm
                        , function(json) {
                            if (json.State == "200") {
                                $("#techannel").val(json.JsonResult.techannel);
                                $("#telgroup").val(json.JsonResult.telgroup);
                                $("#whatsgroup").val(json.JsonResult.whatsgroup);

                                $("#kefutime").html(json.JsonResult.kefutime);
                                $("#kfinfo").html(json.JsonResult.kfinfo);
                            }
                            CommAlert(json);
                        });
                }


                $(document).on("click", '#btn1', function() {
                    var url = document.getElementById("telegram").value;
                    if (window.android) {
                        window.android.callAndroid("open," + url);
                        return;
                    }
                    if (window.webkit && window.webkit.messageHandlers) {
                        window.webkit.messageHandlers.nativeExt.postMessage({
                            msg: 'open,' + url
                        });
                        return;
                    }
                    window.open("https://t.me/starlineid")
                });

                $(document).on("click", '#btn2', function() {
                    var url = document.getElementById("whatsapp").value;
                    if (window.android) {
                        window.android.callAndroid("open," + url);
                        return;
                    }
                    if (window.webkit && window.webkit.messageHandlers) {
                        window.webkit.messageHandlers.nativeExt.postMessage({
                            msg: 'open,' + url
                        });
                        return;
                    }
                    window.open("https://wa.me/14142310787")
                });

                $(document).on("click", '#btn3', function() {
                    var url = document.getElementById("techannel").value;
                    if (window.android) {
                        window.android.callAndroid("open," + url);
                        return;
                    }
                    if (window.webkit && window.webkit.messageHandlers) {
                        window.webkit.messageHandlers.nativeExt.postMessage({
                            msg: 'open,' + url
                        });
                        return;
                    }
                    window.open("https://t.me/starlineidofficial")
                });

                $(document).on("click", '#btn4', function() {
                    var url = document.getElementById("telgroup").value;
                    if (window.android) {
                        window.android.callAndroid("open," + url);
                        return;
                    }
                    if (window.webkit && window.webkit.messageHandlers) {
                        window.webkit.messageHandlers.nativeExt.postMessage({
                            msg: 'open,' + url
                        });
                        return;
                    }
                    window.open("https://chat.whatsapp.com/HqJxlnVnRX7GPENPR1NtWA")
                });

                $(document).on("click", '#btn5', function() {
                    var url = document.getElementById("whatsgroup").value;
                    if (window.android) {
                        window.android.callAndroid("open," + url);
                        return;
                    }
                    if (window.webkit && window.webkit.messageHandlers) {
                        window.webkit.messageHandlers.nativeExt.postMessage({
                            msg: 'open,' + url
                        });
                        return;
                    }
                    window.open("https://chat.whatsapp.com/D3Ya9Qdc82k5fKKOTi6RXa")
                });

            });

            $(document).on("click", '#btnClose', function() {
                parent.layer.close(topindex);
            });

        });

    </script>
</head>
<body style="background-size: 100% auto; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% auto; ">
    <input type="hidden" id="telegram" value="" />
    <input type="hidden" id="whatsapp" value="" />
    <input type="hidden" id="techannel" value="" />
    <input type="hidden" id="telgroup" value="" />
    <input type="hidden" id="whatsgroup" value="" />
    <div style="width: 100%; margin: 0 auto; background: none; border-bottom: 0px solid #117546; " class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname">
            Bantuan Pengguna
        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;">
        <div style="width: 100%; margin: 0 auto; margin-top: 50px; margin-bottom:20px;  text-align: center; position: relative; height: auto; overflow: hidden;  ">
            <img src="{{asset('assets/frontend/ui/cs.jpg')}}" style=" width:100%;" />
        </div>
        <div style="width: 100%; margin: 0 auto; height: 55px; margin-top: 5px; line-height: 55px; border-radius:5px !important; ">
            <div style="float:left;width:50%; text-align:center;">
                <button style="background: linear-gradient(to right,#002759,#c0892f); border: 0px; height: 45px; border-radius: 25px; width: 94%; margin: 0 auto; " id="btn1">
                    <div style="float: left; width: 25%; text-align: right; height: 45px;line-height: 45px; ">
                        <img src="{{asset('assets/frontend/ui/share1.png')}}" style="height:30px;" />
                    </div>
                    <div style="float: left; text-align: center; height: 45px; width: 75%; color: #fff;">
                        <div style="margin-top:7px;">Telegram</div>
                        <div style="font-size:12px;margin-top:3px;">CS resmi</div>
                    </div>
                </button>
            </div>
            <div style="float: left; width: 50%;">
                <button style="background: linear-gradient(to right,#002759,#c0892f); border: 0px; height: 45px; border-radius: 25px; width: 94%; margin: 0 auto; " id="btn2">
                    <div style="float: left; width: 25%; text-align: right; height: 45px;line-height: 45px; ">
                        <img src="{{asset('assets/frontend/ui/share2.png')}}" style="height:25px;" />
                    </div>
                    <div style="float: left; text-align: center; height: 45px; width: 75%; color: #fff;">
                        <div style="margin-top:7px;">WhatsApp</div>
                        <div style="font-size: 12px; margin-top: 3px;">CS resmi</div>
                    </div>
                </button>
            </div>
        </div>

        <div style="width: 98%; margin: 0 auto; background: #002759; height: auto; overflow: hidden; margin-top: 10px; margin-bottom: 15px; border-radius: 5px !important; ">
            <br>
            <div style="padding:10px; color:#bbb; padding-top:0px; font-size:14px; text-align:center; ">
                Jam penarikan : 24 jam tanpa hari libur <br />
                Jam CS : 09:00 WIB - 17:00 WIB
            </div>
            <div style="padding: 25px; color: #bbb; padding-top: 0px; font-size: 12px; display:none; text-align: left; " id="kfinfo">
            </div>

        </div>

        <div style="width: 98%; margin: 0 auto; background: #002759; color:#fff; margin-top: 10px; border-radius: 5px !important; ">
            <br /><br />
            <div style="width: 90%; margin: 0 auto; background: linear-gradient(to left,#ddc088,#002759); height: 55px; margin-top: 10px; line-height: 55px; border-radius: 5px !important; " id="btn3">
                <div style="float:left;width:25%; text-align:center;">
                    <img src="{{asset('assets/frontend/ui/share1.png')}}" style="height:35px;" />
                </div>
                <div style="float:left;width:65%;">Telegram Group</div>
                <div style="float:left;width:10%;">
                    <img src="{{asset('assets/frontend/ui/jt.png')}}" style="height:20px;" />
                </div>
            </div>

            <div style="width: 90%; margin: 0 auto; background: linear-gradient(to left,#ddc088,#002759); height: 55px; margin-top: 10px; line-height: 55px; border-radius: 5px !important; " id="btn4">
                <div style="float:left;width:25%; text-align:center;">
                    <img src="{{asset('assets/frontend/ui/share2.png')}}" style="height:35px;" />
                </div>
                <div style="float:left;width:65%;">Whatsapp Group 1</div>
                <div style="float:left;width:10%;">
                    <img src="{{asset('assets/frontend/ui/jt.png')}}" style="height:20px;" />
                </div>
            </div>

            <div style="width: 90%; margin: 0 auto; background: linear-gradient(to left,#ddc088,#002759); height: 55px; margin-top: 10px; line-height: 55px; border-radius: 5px !important; " id="btn5">
                <div style="float:left;width:25%; text-align:center;">
                    <img src="{{asset('assets/frontend/ui/share2.png')}}" style="height:35px;" />
                </div>
                <div style="float:left;width:65%;">WhatsApp Group 2</div>
                <div style="float:left;width:10%;">
                    <img src="{{asset('assets/frontend/ui/jt.png')}}" style="height:20px;" />
                </div>
            </div>
            <br /><br />
        </div>


    </div>
</body>
</html>
<a href="#" target="_blank" style="display:none;"><span id="jump"></span></a>
