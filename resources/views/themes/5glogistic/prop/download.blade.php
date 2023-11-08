<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Download app</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v2.7')}}">
    <script>
        layui.config({
            base: '{{url("assets/frontend/Lay/lay/modules")}}/'
        }).use(['form', 'layedit', 'jquery', 'layer', 'cookie'], function () {
            var $ = layui.jquery, layer = layui.layer;
            var topindex = parent.layer.getFrameIndex(window.name);
            $("#Android").click(function () {
                location.href = $("#androidurl").val();
            });

            $("#btnClose").click(function () {
                parent.layer.close(topindex);
            });
        });
    </script>
    <style>
        .layui-form-item {
            margin-bottom: 6px;
            clear: both;
            *zoom: 1;
        }

        div#div1 {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
        }

            div#div1 > img {
                height: 100%;
                width: 100%;
                border: 0;
            }

        .inputdiv {
            display: flex;
            border: 1px solid #D2D2D2 !important;
            background-color: #fff;
            height: 38px;
            line-height: 38px;
            padding: 0px 19px;
            border-radius: 10px;
            color: #000;
        }

        .layui-input {
            border-style: none;
        }

        .bgimg {
            position: absolute;
            height: 95%;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            margin: auto;
            width: 90%;
            padding: 10px;
            padding-top: 4px;
            background: rgba(255, 255, 255, 0.50);
            color: #000;
            /*  border-width: 1px;
            border-color: #e6e6e6;
            border-style: solid;
            border-radius: 5px;
            box-shadow: 0 5px 15px 0 rgb(0 0 0 / 50%);*/
            border-radius: 5px;
        }

        .top {
            background-color: #117546;
            border-bottom: 1px solid #117546;
            z-index: 100;
            width: 100%;
            margin-bottom: 5px;
            height: 46px;
            position: fixed;
            left: 0px;
            top: 0px;
        }

        .topname {
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            line-height: 46px;
            width: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
        }
    </style>
</head>
<body style="background: url({{asset('assets/frontend/ui/bg0.png')}}) no-repeat; background-color: #071730; background-size: 100% auto; ">
    <input type="hidden" id="androidurl" value="" />
    <div style=" max-width:450px; margin:0 auto;">
        <div >
            <div>
                <div style="width: 100%; text-align: center; margin-top: 10px; " id="android">
                    <div style="width:85%; margin:0 auto;">
                        <button class="layui-btn" id="Android" style="width: 100%; background: linear-gradient(to right,#ddc088,#c0892f); color: #fff; font-size: 12px; border-radius: 25px; ">
                            <i class="layui-icon">&#xe684;</i><span id="down_t1">Download Android</span>
                        </button>
                    </div>
                </div>
                {{-- <div style="width: 100%; text-align: center; margin-top: 10px;display:none;" id="apple">
                    <div style="width: 85%; margin: 0 auto;">
                        <button class="layui-btn" id="IOS" style="width: 100%; background: linear-gradient(to right,#ddc088,#c0892f); color: #fff; font-size: 12px; border-radius: 25px; ">
                            <i class="layui-icon">&#xe680;</i> <span id="down_t2">Download IOS</span>
                        </button>
                    </div>
                </div>
                <div style="width:100%;text-align:center; margin-top:10px; display:none;" id="google">
                    <div style="width: 85%; margin: 0 auto;">
                        <button class="layui-btn" id="Android1" style="width: 100%; background: linear-gradient(to right,#ddc088,#c0892f); color: #fff; font-size: 12px; border-radius: 25px; ">
                            <i class="layui-icon">&#xe684;</i><span id="down_t3">Google Play Store Download</span>
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</body>
</html>
<a href="#" target="_blank" style="display:none;"><span id="jump"></span></a>
