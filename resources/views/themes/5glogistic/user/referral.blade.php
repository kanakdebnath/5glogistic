@extends($theme.'layouts.starline')

@section('head')
<link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v2.7')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/layer_mobile/need/layer.css')}}?v1.6" />
<script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
<script src="{{asset('assets/frontend/js/comm.js')}}"></script>
<script src="{{asset('assets/frontend/js/clipboard.min.js')}}"></script>
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate', 'layer', 'carousel', 'flow', 'element', 'cookie', 'mobile'], function () {
        var form = layui.form;
        var element = layui.element;
        var $ = layui.jquery, layer = layui.layer;
        var carousel = layui.carousel;
        var mobile = layui.mobile;
        var mobilelayer = mobile.layer;
        var flow = layui.flow;
        var cookie = layui.cookie;

        $().ready(function () {

            $("#copy").attr("data-clipboard-text", "{{Auth::user()->referral_link}}");
            var clipboard = new ClipboardJS('#copy');
            clipboard.on('success', function (e) {
                error("Copy successfully");
            });

            $("#copy1").attr("data-clipboard-text", "{{Auth::user()->referral_code}}");
            var clipboard1 = new ClipboardJS('#copy1');
            clipboard1.on('success', function (e) {
                error("Copy successfully");
            });
            onloads();

            function onloads() {
                getcon();
                userinfo();
                teaminfo();
                invite_task();
            }

            window.uplist = function () {
                onloads();
            };

            function getcon() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "getcon",
                    time: Math.random()
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            $("#P1").html(json.JsonResult.P1);
                            $("#P2").html(json.JsonResult.P2);
                            $("#P3").html(json.JsonResult.P3);
                            $("#site_http").val(json.JsonResult.site_http);
                        }
                    });
            }


            $(document).on("click", '#task', function () {
                url = "{{route('user.team-info')}}";
                layer.open({
                    type: 2,
                    title: false,
                    area: ['100%', '100%'],
                    offset: 'b',
                    shadeClose: true,
                    isOutAnim: false,
                    closeBtn: 0,
                    anim: 2,
                    shade: [0.8, '#393D49'],
                    maxmin: false,
                    content: url
                });
            });

            function invite_task() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "invite_task",
                    time: Math.random()
                };
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            var html = "";
                            for (var i = 0; i < json.JsonResult.length; i++) {
                                html += "<div style=\"background: rgb(170,171,204); border-radius: 10px; width: 95%; margin: 0 auto; height: 70px; overflow: hidden; margin-top: 10px; position: relative;\">";
                                html += "<div style=\"width: 70%; float: left;\">";
                                html += "<div style=\"padding:20px; color:#fff; text-align:left; font-size:12px;\">";
                                html += "Invite " + json.JsonResult[i].count + " valid members (deposit users) to join Reward Rp  " + json.JsonResult[i].amount;
                                html += "</div>";
                                html += "</div>";
                                html += "<div style=\"width: 30%; float: left; text-align: center; color: #fff;\">";
                                var nnv = $("#taskcount").html();
                                if (nnv * 1 >= json.JsonResult[i].count) {
                                    if (json.JsonResult[i].status == "2")
                                        html += "<div  style=\"font-size: 12px; background: rgb(64,2,148); border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">Received</div>";
                                    else
                                        html += "<div class='Receive' value='" + json.JsonResult[i].id + "' style=\"font-size: 12px; background: rgb(64,2,148); border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">" + nnv + "/" + json.JsonResult[i].count + "</div>";
                                } else {
                                    html += "<div style=\"font-size: 12px; background: #888; border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">" + nnv + "/" + json.JsonResult[i].count + "</div>";
                                }

                                //if (json.JsonResult[i].status == "0") {
                                //    html += "<div style=\"font-size: 12px; background: #888; border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">Not activated</div>";
                                //}
                                //if (json.JsonResult[i].status == "1") {
                                //    html += "<div class='Receive' value='" + json.JsonResult[i].id + "' style=\"font-size: 12px; background: rgb(64,2,148); border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">Receive</div>";
                                //}
                                //if (json.JsonResult[i].status == "2") {
                                //    html += "<div style=\"font-size: 12px; background:#999; border-radius: 25px; height: 30px; width: 90%; margin: 0 auto; line-height: 30px; margin-top: 20px;\">Received</div>";
                                //}
                                html += "</div>";
                                html += "</div>";
                            }
                            $("#tasklist").html(html);
                        }
                    });
            }


            function userinfo() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "userinfo",
                    time: Math.random()
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            $("#inv").html(json.JsonResult.invitation);
                            $("#taskcount").html(json.JsonResult.task_count);

                            $("#lv1_team_income").html(json.JsonResult.lv1_team_income);
                            $("#lv2_team_income").html(json.JsonResult.lv2_team_income);
                            $("#lv3_team_income").html(json.JsonResult.lv3_team_income);

                            $("#lvcount").html(json.JsonResult.task_count);
                            $("#lvincome").html("Rp " + json.JsonResult.team_income);


                            $("#task_count1").html(json.JsonResult.task_count1);
                            $("#task_count2").html(json.JsonResult.task_count2);

                            $("#task_count3").html(json.JsonResult.task_count3);
                            $("#task_count4").html(json.JsonResult.task_count4);

                            $("#task_income1").html("Rp " + json.JsonResult.task_income1);
                            $("#task_income2").html("Rp " + json.JsonResult.task_income2);

                            $("#task_income3").html("Rp " + json.JsonResult.task_income3);
                            $("#task_income4").html("Rp " + json.JsonResult.task_income4);


                            if (json.JsonResult.task_count1 * 1 < 1) {
                                $("#task_count_1").html(json.JsonResult.task_count1);
                                $("#task_income_1").html("Rp 0");
                                $("#task_count_2").html(json.JsonResult.task_count1);
                                $("#task_income_2").html("Rp 0");
                                $("#task_count_3").html(json.JsonResult.task_count1);
                                $("#task_income_3").html("Rp 0");
                            } else {
                                if (json.JsonResult.task_count1 * 1 < 4) {
                                    $("#task_count_2").html(json.JsonResult.task_count1);
                                    $("#task_income_2").html("Rp 0");
                                    $("#task_count_3").html(json.JsonResult.task_count1);
                                    $("#task_income_3").html("Rp 0");
                                } else {
                                    if (json.JsonResult.task_count1 * 1 < 20) {
                                        $("#task_count_3").html(json.JsonResult.task_count1);
                                        $("#task_income_3").html("Rp 0");
                                    } else {
                                        $("#task_count_3").html("20");
                                        $("#task_income_3").html("Rp 5,000");
                                    }
                                    $("#task_count_2").html("4");
                                    $("#task_income_2").html("Rp 500");
                                }
                                $("#task_count_1").html("1");
                                $("#task_income_1").html("Rp 200");
                            }

                            var site_http = $("#site_http").val();
                            $("#link").html(site_http + "reg.html?v=" + json.JsonResult.invitation);
                            $("#copy").attr("data-clipboard-text", site_http + "reg.html?v=" + json.JsonResult.invitation);
                            var clipboard = new ClipboardJS('#copy');
                            clipboard.on('success', function (e) {
                                error("Copy successfully");
                            });

                            $("#copy1").attr("data-clipboard-text", json.JsonResult.invitation);
                            var clipboard1 = new ClipboardJS('#copy1');
                            clipboard1.on('success', function (e) {
                                error("Copy successfully");
                            });
                        }
                    });
            }
            function teaminfo() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "teaminfo",
                    time: Math.random()
                };
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            $("#number1").html(json.JsonResult.number1);
                            $("#number2").html("Rp " + json.JsonResult.number2);
                            $("#lv1count").html(json.JsonResult.number3);
                            $("#lv2count").html(json.JsonResult.number4);
                            $("#lv3count").html(json.JsonResult.number5);
                        }
                    });
            }

            $(document).on("click", '#lottery', function () {
                var url1 = "prop/lottery77e6.html?time=" + Math.random();
                layer.open({
                    type: 2,
                    title: false,
                    area: ['100%', '100%'],
                    shadeClose: true,
                    isOutAnim: false,
                    closeBtn: 0,
                    anim: 5,
                    shade: [0.8, '#393D49'],
                    maxmin: false,
                    content: url1
                });
            });


            $(document).on("click", '#teamdetails', function () {
                var url1 = "teaminfo77e6.html?time=" + Math.random();
                layer.open({
                    type: 2,
                    title: false,
                    area: ['100%', '100%'],
                    shadeClose: true,
                    isOutAnim: false,
                    closeBtn: 0,
                    anim: 5,
                    shade: [0.8, '#393D49'],
                    maxmin: false,
                    content: url1
                });
            });

            $(document).on("click", '#kf', function () {
                var url1 = "cs77e6.html?time=" + Math.random();
                layer.open({
                    type: 2,
                    title: false,
                    area: ['100%', '100%'],
                    shadeClose: true,
                    isOutAnim: false,
                    closeBtn: 0,
                    anim: 5,
                    shade: [0.8, '#393D49'],
                    maxmin: false,
                    content: url1
                });
            });

            $(document).on("click", '.navtab', function () {
                var urlx = $(this).attr("url");
                location.href = urlx;
            });
        });
    });
</script>
<style type="text/css">
    .top1 {
        position: fixed;
        background: #fff;
        z-index: 10000;
        width: 100%;
        height: 30px;
        top: -30px;
    }

    .small-font {
        font-size: 12px;
        -webkit-transform-origin-x: 0;
        -webkit-transform: scale(0.80);
    }

    .smallsize-font {
        font-size: 9.6px;
    }

    .navtab {
        cursor: pointer;
    }

    .gray {
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: grayscale(100%);
        filter: blue;
    }

    .topname {
        line-height: 46px;
        font-weight: 700;
        font-size: 16px;
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

    .indexdiv {
        background: #000000;
        position: fixed;
        left: 0px;
        top: 0px;
        bottom: 0px;
        width: 100%;
        height: 100%;
        z-index: 101;
        filter: alpha(opacity=95);
        opacity: 0.95 !important;
        display: none;
    }
</style>
@endsection

@section('content')
<body style="background-size: 100% auto; background: linear-gradient(to top, #071730, #071730); ">
    <input id="site_http" type="hidden" value="" />
    <div class="indexdiv"></div>
    <div style=" max-width:450px; margin:0 auto;">
        <div style="height:50px;line-height:50px; text-align:center;  color:#fff;">
            <div style="margin-top:25px;color: #FFFFFF; text-align:center; height:25px; line-height:25px;position:relative;">

                <div style="position: absolute; top: -5px; text-align: right;  right:12px; ">
                    <div class="layui-btn layui-btn-sm" style="background-image: linear-gradient(to right,#0f2756,#0f2756); border: 0px; border-radius: 3px; color: #fff; " id="task">
                        Tim saya&nbsp;
                        <img src="{{asset('assets/frontend/ui/team.png')}}" style="height:15px;" />
                    </div>
                </div>
            </div>
        </div>
        <div class="top1">
        </div>
        <div style="  margin-bottom: 100px;">
            <div style="width: 100%; height: auto; overflow: hidden;">
                <div style="color: #fff; font-size: 14px; padding-left: 15px;">
                    Kode & tautan undangan :
                </div>
            </div>
            <div style=" background: url({{asset('assets/frontend/ui/teambg.png')}}) no-repeat; background-size: 100% auto; height: auto; overflow: hidden; border-radius: 5px; color: #fff; width: 98%; height: auto; margin: 0 auto; margin-top: 12px; position: relative; ">
                <div style="padding: 10px;font-size: 16px; margin-top: 10px; height: auto; overflow: hidden;">
                    <div style="float: left; width: 70%; height: 30px; line-height: 30px;">
                        <img src="{{asset('assets/frontend/ui/t1.png')}}" style="height:20px; margin-left:20px; " /><span style="margin-left:10px;" id="inv">{{Auth::user()->referral_code}}</span>
                    </div>
                    <div style="float:left;width:30%;">
                        <button id="copy1" style="width: 80%; height: 30px; font-size: 12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 20px; ">
                            Copy
                        </button>
                    </div>
                </div>
                <div style="padding: 10px; font-size: 12px; height: auto; overflow: hidden; padding-bottom:35px;">
                    <div style="float: left; width: 70%; height: 30px; ">
                        <img src="{{asset('assets/frontend/ui/t2.png')}}" style="height: 20px; margin-left: 20px; " /><span style="margin-left: 10px; width: 170px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; " id="link">{{Auth::user()->referral_link}}</span>
                    </div>
                    <div style="float:left;width:30%;">
                        <button id="copy" style="width: 80%; height: 30px; font-size: 12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 20px; ">
                            Copy
                        </button>
                    </div>
                </div>
                <div style="width:100%; font-size:12px; text-align:center;padding-top:65px;height:50px;">
                    <div style="font-size: 12px; text-align: center; height: auto; overflow: hidden; color: #394969; margin:0 auto; ">
                        <div style="float:right;width:33.33%;"><div style="margin:0 auto;">Bonus diberikan</div></div>
                        <div style="float:left;width:33.33%;"><div  style="margin:0 auto;">Bagikan kode</div></div>
                        <div style="float:left;width:33.33%;"><div  style="margin:0 auto;">Teman input kode</div></div>
                    </div>
                </div>
            </div>
            <!--<div style="width: 100%; margin-top:20px; height: auto; overflow: hidden;">
                <div style="float:left; width:65%;">
                    <div style="padding: 15px; padding-top: 0px; color: #fff; padding-bottom: 3px; font-weight: bold; font-size: 15px; ">Invite link</div>
                    <div style="padding:15px; padding-top:0px; color:#fff;  padding-top:3px; padding-bottom:3px;">
                        <div style=" border-bottom: 1px solid #888; padding-bottom: 8px; font-size: 12px; " class="small-font" id="link">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div style="float:left; width:35%;">
                    <br />
                    <div id="copy" style="width: 80%; margin: 0 auto; background: rgb(42,175,254); text-align: center; height: 40px; line-height: 40px; border-radius: 25px; color: #fff; ">
                        Copy
                    </div>
                </div>
            </div>-->
            <div style="width: 100%; height: auto; overflow: hidden; ">
                <div style="color: #fff; font-size: 14px; padding-left: 15px; padding-top:15px;">
                    Rekapan tim
                </div>

            </div>
            <div style="margin-top: 15px; color: #fff; height: auto; overflow: hidden;">
                <div style="float:left;width:50%; text-align:center;">
                    <div style="height: 60px; line-height: 20px; width: 90%; margin: 0 auto; background: linear-gradient(to right,#ddc088,#c0892f); border-radius: 5px;">
                        <div style=" width: 100%; padding-top: 10px; font-size: 16px;" id="number1">{{$levelOneUsers + $levelTwoUsers + $levelThreeUsers}}</div>
                        <div style=" width:100%;">Jumlah tim</div>
                    </div>
                </div>
                <div style="float: left; width: 50%; text-align: center;">
                    <div style="height: 60px; line-height: 20px; width: 90%; margin: 0 auto; background: linear-gradient(to right,#ddc088,#c0892f); border-radius: 5px; ">
                        <div style="width: 100%; padding-top: 10px; font-size:16px;" id="lvincome">Rp {{getAmount($levelOneIncome) + getAmount($levelTwoIncome) + getAmount($levelThreeIncome)}}</div>
                        <div style=" width:100%;">Total bonus</div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; width: 100%;color: #FFFFFF; text-align: center; height: auto; overflow: hidden;">
                <table style="width: 98%; background: #091427; color: #394969; font-size: 12px; border: 1px solid #222; margin-top: 0px; padding-top: 0px; margin: 0 auto;">
                    <tr style="height: 35px; border: 1px solid #222; line-height: 35px; ">
                        <td>Persentase</td>
                        <td style="font-size:12px;">Jumlah</td>
                        <td style="font-size:12px;">Pendapatan</td>
                    </tr>
                    <tr style="background: #091427; border: 1px solid #222; height: 35px; line-height: 35px; ">
                        <td style="font-size:12px;">Level 1 team {{$referrals->where('level', 1)->first()->percent}}%</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_count1">{{$levelOneUsers}}</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_income1">Rp {{getAmount($levelOneIncome)}}</td>
                    </tr>
                    <tr style="background: #091427; border: 1px solid #222; height: 35px; line-height: 35px; ">
                        <td style="font-size:12px;">Level 2 team {{$referrals->where('level', 2)->first()->percent}}%</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_count3">{{$levelTwoUsers}}</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_income3">Rp {{getAmount($levelTwoIncome)}}</td>
                    </tr>
                    <tr style="background: #091427; border: 1px solid #222; height: 35px; line-height: 35px; ">
                        <td style="font-size:12px;">Level 3 team {{$referrals->where('level', 3)->first()->percent}}%</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_count4">{{$levelThreeUsers}}</td>
                        <td style="font-size:12px;color:#FFE393;" id="task_income4">Rp {{getAmount($levelThreeIncome)}}</td>
                    </tr>
                </table>
            </div>

            <div style="width: 100%; height: auto; overflow: hidden;">
                <div style="color: #fff; font-size: 16px;  padding-left: 15px; padding-top:15px;">
                    Invite tasks
                </div>
            </div>
            <!--<div style="margin-top: 15px; color: #fff; height: auto; overflow: hidden;">
                <div style=" width: 100%; text-align: center;">
                    <div style="height: 50px; line-height: 50px; width: 95%; margin: 0 auto; background: linear-gradient(to right,#ddc088,#c0892f); border-radius: 5px; ">
                        <div style="float:left; width:50%;">Total task revenue</div>
                        <div style="float:left; width:50%;">Rp  0.00</div>
                    </div>
                </div>
            </div>-->
            <div style="width: 100%; height: auto; overflow: hidden;">
                <div style="color: @if(Auth::user()->active_invites >= 5) #c0892f @else #aaa @endif; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Undang 5 teman untuk membeli produk, dan dapatkan bonus Rp 20,000
                </div>
                <div style="width: 100%; height: auto; overflow: hidden; border-bottom: 1px solid #c0892f; padding-bottom:35px;">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" >
                            <font id="task_count_1">@if(Auth::user()->active_invites > 5) 5 @else {{Auth::user()->active_invites}} @endif</font> / 5
                        </div>
                        <div style="color: #fff; padding-top: 8px;">Proses</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income_1">Rp @if(Auth::user()->active_invites > 4) 20,000 @else 0 @endif</div>
                        <div style="color: #fff; padding-top: 8px;">Bonus</div>
                    </div>
                </div>

                <div style="color: @if(Auth::user()->active_invites >= 30) #c0892f @else #aaa @endif; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Undang 30 teman untuk membeli produk, dan dapatkan bonus Rp 100,000
                </div>
                <div style="width: 100%; height: auto; overflow: hidden; border-bottom: 1px solid #c0892f; padding-bottom:35px;">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" >
                            <font id="task_count_2">@if(Auth::user()->active_invites > 30) 30 @else {{Auth::user()->active_invites}} @endif</font> / 30
                        </div>
                        <div style="color: #fff; padding-top: 8px;">Proses</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income_2">Rp @if(Auth::user()->active_invites > 29) 1,00,000 @else 0 @endif</div>
                        <div style="color: #fff; padding-top: 8px;">Bonus</div>
                    </div>
                </div>

                <div style="color: @if(Auth::user()->active_invites >= 65) #c0892f @else #aaa @endif; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Undang 65 teman untuk membeli produk, dan dapatkan bonus Rp 250,000
                </div>
                <div style="width: 100%; height: auto; overflow: hidden; border-bottom: 1px solid #c0892f; padding-bottom:35px;">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" >
                            <font id="task_count_3">@if(Auth::user()->active_invites > 65) 65 @else {{Auth::user()->active_invites}} @endif</font> / 65
                        </div>
                        <div style="color: #fff; padding-top: 8px;">Proses</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income_3">Rp @if(Auth::user()->active_invites > 64) 2,50,000 @else 0 @endif</div>
                        <div style="color: #fff; padding-top: 8px;">Bonus</div>
                    </div>
                </div>

                <div style="color: @if(Auth::user()->active_invites >= 180) #c0892f @else #aaa @endif; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Undang 180 teman untuk membeli produk, dan dapatkan bonus Rp 1,000,000
                </div>
                <div style="width: 100%; height: auto; overflow: hidden; border-bottom: 1px solid #c0892f; padding-bottom:35px;">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" >
                            <font id="task_count_3">@if(Auth::user()->active_invites > 180) 180 @else {{Auth::user()->active_invites}} @endif</font> / 180
                        </div>
                        <div style="color: #fff; padding-top: 8px;">Proses</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income_3">Rp @if(Auth::user()->active_invites > 179) 10,00,000 @else 0 @endif</div>
                        <div style="color: #fff; padding-top: 8px;">Bonus</div>
                    </div>
                </div>

                <div style="color: @if(Auth::user()->active_invites >= 500) #c0892f @else #aaa @endif; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Undang 500 teman untuk membeli produk, dan dapatkan bonus Rp 4,000,000
                </div>
                <div style="width: 100%; height: auto; overflow: hidden; border-bottom: 1px solid #c0892f; padding-bottom:35px;">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" >
                            <font id="task_count_3">@if(Auth::user()->active_invites > 499) 500 @else {{Auth::user()->active_invites}} @endif</font> / 500
                        </div>
                        <div style="color: #fff; padding-top: 8px;">Proses</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income_3">Rp @if(Auth::user()->active_invites > 499) 40,00,000 @else 0 @endif</div>
                        <div style="color: #fff; padding-top: 8px;">Bonus</div>
                    </div>
                </div>

                <!--<div style="width: 100%; height: auto; margin-top: 5px; overflow: hidden;">
                    <div style="color: #fff; font-size: 16px; padding-left: 15px; padding-top: 15px;">
                        Lucky draw
                    </div>
                </div>
                <div style="color: #aaa; background: linear-gradient(to left,#0f2756,#061324); font-size: 14px; width: 92%; margin: 0 auto; padding: 8px; margin-top: 10px; border-radius: 3px; ">
                    Every time you invite a valid user, you will get a lucky draw chance
                </div>
                <div style="width: 100%; height: auto; overflow: hidden;  ">
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f;" id="task_count2">0</div>
                        <div style="color: #fff; padding-top: 8px;">Number of lucky draws</div>
                    </div>
                    <div style="width:50%; float:left;text-align:center;">
                        <div style="font-weight: bold; font-size: 20px; padding-top: 15px; color: #c0892f; " id="task_income2">0.00</div>
                        <div style="color: #fff; padding-top:8px;">Bonus</div>
                    </div>
                    <div style="width:100%; float:left;text-align:center; margin-top:25px;">
                        <div id="lottery" style="height: 50px; width: 60%; font-size:18px; margin: 0 auto; background: linear-gradient(to right,#ddc088,#c0892f); line-height:50px; font-weight:bold; border-radius: 25px; ">
                            Click to get bonus
                        </div>
                    </div>
                </div>-->
            </div>
        </div>


        <nav class="nav" style="background-size:100% 100%; height:60px; ">
            <div url="{{route('home')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/1.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn1">Utama</span>
            </div>
            <div url="{{route('user.my-products')}}" class="navtab ">
                <img src="{{asset('assets/frontend/ui/nav/2.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn2">Portofolio</span>
            </div>
            <div url="#">
                <img src="{{asset('assets/frontend/ui/nav/7.png')}}" class="logo" style="height: 55px; margin-top: -20px;" /> <br />
            </div>
            <div style="color: #AF873F !important; font-weight: bold; ">
                <img src="{{asset('assets/frontend/ui/nav/4.png')}}" style="height: 25px; " /> <br />
                <span id="nav_btn3">Bonus Team</span>
            </div>
            <div url="{{route('user.home')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/5.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn4">Akun Anda</span>
            </div>
        </nav>
    </div>
</body>
@endsection




















{{-- @extends($theme.'layouts.user')
@section('title',trans($title))
@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.home')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans($title)}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div id="feature">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card secbg ">
                            <div class="card-header media justify-content-between">
                                <h5 class="card-title mb-3">@lang($title)</h5>
                            </div>

                            <div class="card-body ">
                                <div class="row mb-50">
                                    <div class="col-xl-12">
                                        <div class="form-group form-block br-4">
                                            <h5 class="mb-15">@lang('Referral Link')</h5>
                                            <div class="input-group mb-50">
                                                <input type="text" value="{{route('register.sponsor',[Auth::user()->username])}}"
                                                       class="form-control form-control-lg bg-transparent" id="sponsorURL"
                                                       readonly>
                                                <div class="input-group-append">
                                            <span class="input-group-text copytext" id="copyBoard"
                                                  onclick="copyFunction()">
                                                <i class="fa fa-copy"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                @if(0 < count($referrals))
                                <div class="d-flex align-items-start">
                                    <div class="nav nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        @foreach($referrals as $key => $referral)
                                       <a class="nav-link @if($key == '1')  active  @endif " id="v-pills-{{$key}}-tab" data-toggle="pill" href="#v-pills-{{$key}}"  role="tab" aria-controls="v-pills-{{$key}}" aria-selected="true">@lang('Level') {{$key}}</a>
                                        @endforeach
                                    </div>

                                    <div class="tab-content" id="v-pills-tabContent">

                                        @foreach($referrals as $key => $referral)
                                            <div class="tab-pane fade @if($key == '1') show active  @endif " id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                                @if( 0 < count($referral))
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-striped text-white">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">@lang('Name')</th>
                                                                <th scope="col">@lang('Email')</th>
                                                                <th scope="col">@lang('Phone Number')</th>
                                                                <th scope="col">@lang('Joined At')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($referral as $user)
                                                                <tr>

                                                                    <td data-label="@lang('Name')">{{$user->username}}</td>
                                                                    <td data-label="@lang('Email')">{{$user->email}}</td>
                                                                    <td data-label="@lang('Phone Number')">
                                                                        {{$user->mobile}}
                                                                    </td>
                                                                    <td data-label="@lang('Joined At')">
                                                                        {{dateTime($user->created_at)}}
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                    @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

    <script>
        "use strict";
        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>

@endpush --}}
