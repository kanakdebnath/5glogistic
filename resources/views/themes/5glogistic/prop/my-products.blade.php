<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My device</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css')}}">
    {{-- <link href="../../css/video-js.min.css" rel="stylesheet" />
    <script src="../../js/video.min.js"></script> --}}
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <style type="text/css">
        .topname {
            line-height: 46px;
            width: 75%;
            text-align: center;
            color: #fff;
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
                // plist();
                // myprototal();
            });


            function plist() {
                var url = "{{route('user.my-products-ajax')}}";
                var pm = {};
                $.getJSON(url, pm
                    , function(json) {
                        var html = "";
                        if (json.investments.length == 0) {
                            html += "<div style='height:150px;line-height:150px; color:#fff;'>You don't have a device yet</div>";
                        } else {
                            for (var i = 0; i < json.investments.length; i++) {
                                html += "<div style=\" height: auto; overflow: hidden; padding-top:15px; border-bottom:1px solid #333;\">";
                                html += "<div style=\"float:left;width:20%;position:relative;\">";
                                html += "<img src=\"" + json.investments[i].imgurl + "\" style=\"width:100%;margin-left:5px; border-radius: 10px;\" />";
                                html += "<div style='padding:2px; padding-left:5px;padding-right:5px; position:absolute; left:5px; top:0px; font-size:12px; border-radius: 10px; background:#c0892f;color:#fff;'><img src=\"/ui/vip.png\" style='height:15px;' /> " + json.investments[i].vipname + "</div>";
                                html += "</div>";
                                html += "<div style=\"float:left;width:60%;\">";
                                html += "<div style=\"width:100%;\">";
                                html += "<div style=\"padding: 10px; padding-left:20px; padding-top:3px; font-size:12px; text-align:left; color:#fff;\">";
                                html += json.investments[i].plan.name;
                                html += "</div>";
                                html += "</div>";
                                html += "<div>";
                                html += "<div style=\"float: left; width: 50%; color: #C28F36\">";
                                html += "<div style=\"padding-top:5px; padding-bottom:0px;font-weight:bold; font-size:14px;\">Rp " + json.investments[i].recurring_time * json.investments[i].profit + "</div>";
                                html += "</div>";
                                html += "<div style=\"float: left; width: 50%; color: #C28F36\">";
                                html += "<div style=\"padding-top: 5px; padding-bottom: 0px; font-weight: bold; font-size: 14px;\">Rp " + json.investments[i].plan.repeatable * json.investments[i].profit + "</div>";
                                html += "</div>";
                                html += "</div>";
                                html += "<div>";
                                html += "<div style=\"float: left; width: 50%; color: #394969\">";
                                html += "<div style=\"padding:15px; padding-top:10px; font-size:12px;\">Income obtained</div>";
                                html += "</div>";
                                html += "<div style=\"float: left; width: 50%; color: #394969\">";
                                html += "<div style=\"padding: 15px; padding-top: 10px; font-size: 12px;\">";
                                html += "Total revenue";
                                html += "</div>";
                                html += "</div>";
                                html += "</div>";
                                html += "</div>";
                                html += "<div style=\"float:left;width:20%; text-align:center; line-height:70px;\">";
                                html += "<button style=\"width: 90%; font-size:12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 5px; height: 27px;\">";
                                html += "Running";
                                html += "</button>";
                                html += "</div>";
                                html += "</div>";
                            }
                        }
                        $("#list").html(html);
                    });
            }

            function myprototal() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "myprototal"
                    , time: Math.random()
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm
                    , function(json) {
                        if (json.State == "200") {
                            $("#number1").html(json.investments.number1);
                            $("#number2").html("Rp  " + json.investments.number2);
                        }
                        CommAlert(json);

                    });
            }

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
<body style="background-size: 100% auto; background: linear-gradient(to top, #071730, #071730);  ">
    <div class="top" style="background: #071730;">
        <div style="float:left; line-height:46px;width:50%;cursor:pointer;" id="btnClose">
            <i class="layui-icon" style="color:#fff;  margin-left:12px; font-size:16px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname" id="topname1">
            My device
        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">
        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;  ">
        <div style="width:98%; margin:0 auto; margin-top:60px;">
            <div style="width: 98%; margin: 0 auto; margin-top: 20px; height: auto; overflow: hidden; ">
                <div style="width:100%; margin:0 auto; margin-bottom:10px;">
                    <div style="width:49%;float:left; border-radius: 10px !important;">
                        <button id="Invite" style="width: 100%; border:0px; font-size: 12px; text-align: center; height: 80px; border-radius: 5px !important; background: linear-gradient(to right,#ddc088,#c0892f); background-size: 100% 100%;" type="button">
                            <div>
                                <div style="color: #fff; font-weight: bold;padding-bottom: 0px; font-size: 16px; " id="number1">{{$roi['totalInvest']}}</div>
                                <div style=" font-size: 12px; color: #fff; margin-top:5px;">Equipment Quantity</div>
                            </div>
                        </button>
                    </div>
                    <div style="width:49%;float:left; margin-left:2%; ">
                        <button id="HOW" style="width: 100%; border: 0px; text-align: center; font-size: 12px; height: 80px; border-radius: 5px !important; background: linear-gradient(to right,#ddc088,#c0892f); background-size: 100% 100%;" type="button">
                            <div>
                                <div style="color: #fff; font-weight: bold; padding-bottom: 0px; font-size: 16px; " id="number2">{{config('basic.currency_symbol').' '.getAmount($roi['returnProfit'])}}</div>
                                <div style="font-size: 12px; color: #fff; margin-top: 5px; ">Total equipment revenue</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; background: #06163A; width: 98%; margin: 0 auto; margin-top: 20px; padding-bottom: 15px; height: auto; overflow: hidden; position: relative; ">
            <div id="list">
                @forelse ($investments as $investment)
                <div style=" height: auto; overflow: hidden; padding-top:15px; border-bottom:1px solid #333;">
                    <div style="float:left;width:20%;position:relative;">
                        <img src="{{getFile(config('location.plan.path').$investment->plan->image) ? : 0}}" style="width:100%;margin-left:5px; border-radius: 10px;">
                    </div>
                    <div style="float:left;width:60%;">
                        <div style="width:100%;">
                            <div style="padding: 10px; padding-left:20px; padding-top:3px; font-size:12px; text-align:left; color:#fff;">{{$investment->plan->name}}</div>
                        </div>
                        <div>
                            <div style="float: left; width: 50%; color: #C28F36">
                                <div style="padding-top:5px; padding-bottom:0px;font-weight:bold; font-size:14px;">Rp {{$investment->recurring_time * $investment->profit }}</div>
                            </div>
                            <div style="float: left; width: 50%; color: #C28F36">
                                <div style="padding-top: 5px; padding-bottom: 0px; font-weight: bold; font-size: 14px;">Rp {{$investment->plan->repeatable * $investment->profit }}</div>
                            </div>
                        </div>
                        <div>
                            <div style="float: left; width: 50%; color: #394969">
                                <div style="padding:15px; padding-top:10px; font-size:12px;">Income obtained</div>
                            </div>
                            <div style="float: left; width: 50%; color: #394969">
                                <div style="padding: 15px; padding-top: 10px; font-size: 12px;">Total revenue</div>
                            </div>
                        </div>
                    </div>
                    @if($investment->status == 1)
                    <div style="float:left;width:20%; text-align:center; line-height:70px;"><button style="width: 90%; font-size:12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 5px; height: 27px;">Running</button></div>
                    @else
                    <div style="float:left;width:20%; text-align:center; line-height:70px;"><button style="width: 90%; font-size:12px; background-image: linear-gradient(to right,#88c9dd,#2f88c0); margin: 0 auto; border: 0px; color: #fff; border-radius: 5px; height: 27px;">Completed</button></div>
                    @endif
                </div>
                @empty
                <div style='height:150px;line-height:150px; color:#fff;'>You don't have a device yet</div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
