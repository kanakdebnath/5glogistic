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
        layui.use(['form', 'carousel', 'flow', 'element', 'cookie'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var flow = layui.flow;
            var element = layui.element;
            var cookie = layui.cookie;
            var topindex = parent.layer.getFrameIndex(window.name);

            $().ready(function () {
                infor();
            });

            function infor() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "noticeinfo",
                    time: Math.random()
                };
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            $("#info").html(json.JsonResult.howinfo);
                        }
                        // CommAlert(json);
                    });
            }

            $(document).on("click", '#btnClose', function () {
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
                How to earn money
            </font>
            <div style="float:right; text-align:right; line-height:46px;width:50%;">
            </div>
        </div>

        <div style="width: 98%; margin: 0 auto; margin-top: 60px; background: #0d1C43; color:#fff; border-radius: 5px;">
            <div style="padding:10px;" id="info">

            </div>
        </div>
    </div>
</body>
</html>
