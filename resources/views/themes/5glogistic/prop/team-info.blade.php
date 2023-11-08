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
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
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


        .typeitem {
            float: left;
            width: 33.33%;
        }

        .over {
            border-bottom: 1px solid #fff;
        }
    </style>
    <script>
        layui.use(['form', 'carousel', 'flow', 'element', 'carousel', 'flow', 'element', 'cookie'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var carousel = layui.carousel;
            var flow = layui.flow;
            var element = layui.element;
            var topindex = parent.layer.getFrameIndex(window.name);

            $().ready(function () {
                itemlist();
                teaminfo();
            });

            function teaminfo() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "teaminfo",
                    time: Math.random()
                };
                $.getJSON(url, pm,
                    function (json) {
                        if (json.State == "200") {
                            $("#number3").html(json.referrals.number3);
                            $("#number4").html(json.referrals.number4);
                            $("#number5").html(json.referrals.number5);
                            $("#number6").html(json.referrals.number6);
                            $("#number7").html(json.referrals.number7);
                            $("#number8").html(json.referrals.number8);
                            $("#number9").html("₨  " + json.referrals.number9);
                        }
                    });
            }
            $(document).on("click", '.typeitem', function () {
                $(".typeitem").each(function () {
                    $(this).removeClass("over");
                });
                $(this).addClass("over");
                var id = $(this).attr("value");
                $("#type").val(id);
                itemlist();
            });


            function getitemlist(page, pagesize, lis) {
                var liss = [];
                var totolcount = 0;
                var type = $("#type").val();
                var url = "{{route('user.team-info-ajax')}}";
                var pm = {
                    page: page,
                    limit: pagesize,
                    type: type,
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm,
                    function (json) {
                        var html = "";
                            totolcount = json.PageTotal;
                            if (json.referrals.length == 0) {
                                html += "<div style=\"padding:2px; width:95%; margin:0 auto; margin-top:50px;\" >";
                                html += "<div style=\"border-radius: 5px; color:#fff; text-align:center; margin-top:35px;position:relative;\">";
                                html += "<img src=\"{{asset('assets/frontend/imgss/no.png')}}\" style=\" width:100%;\">";
                                html += "<br>";
                                html += "</div>";
                                html += "</div>";
                            }
                            for (var i = 0; i < json.referrals.length; i++) {

                                html += "<div style=\"height:45px;padding-top:10px; border-bottom:1px solid #333;\">";
                                html += "<div style=\"float:left;width:20%;text-align:center; position:relative;\">";
                                html += "<img src=\"{{asset('assets/frontend//ui/team.png')}}\" style=\"height:20px;\" />";
                                // if (json.referrals[i].viptype != "0") {
                                //     html += "<div style='padding:2px; padding-left:5px;padding-right:5px; position:absolute; left:11px; bottom:-20px; font-size:12px; border-radius: 10px; background:#c0892f;color:#fff;'><img src=\"/ui/vip.png\" style='height:15px;' />VIP" + json.referrals[i].viptype + "</div>";
                                // }

                                html += "</div>";
                                html += "<div style=\"float:left;width:50%;\">";
                                html += "<div style=\"font-weight:bold;color:#fff;\">" + json.referrals[i].phone + "</div>";
                                html += "<div style=\"color:#ccc; padding-top:4px; font-size:12px;\">" + json.referrals[i].creation_time + "</div>";
                                html += "</div>";
                                // html += "<div style=\"float:left;width:30%;text-align:center;\">";
                                // html += "<div style=\"font-weight: bold; color: #ddc088;\">₨  " + json.referrals[i].pay_amount + "</div>";
                                // html += "</div>";
                                html += "</div>";

                                //html += "<div style=\"height:auto;overflow:hidden;color:#333;background:#fff;margin:0 auto; width:98%;border-radius: 5px; margin-top:10px;padding-bottom:15px;\">";
                                //html += "<div style=\"padding:10px;\">";
                                //html += "<div style=\"float:left;width:45%; margin-left:5%\">";
                                //html += "<div style=\"height:27px; line-height:27px;\">";
                                //if (json.referrals[i].type == "1")
                                //    html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; font-weight:bold; color: #000;\">Bank Card</span>";
                                //if (json.referrals[i].type == "2")
                                //    html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; font-weight:bold;color: #000;\">USDT</span>";
                                //html += "</div>";
                                //html += "<div style=\"height:27px; line-height:27px;\">";
                                //html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; color: #000;\">" + json.referrals[i].orderno + "</span></div>";
                                //html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\">" + _withdrawal_t14 + " : $ " + json.referrals[i].realamount + " </div>";
                                //html += "<div style=\"height:27px; line-height:27px;font-size:12px; color:#999;\">" + json.referrals[i].createtime + "</div>";
                                //html += "</div>";
                                //html += "<div style=\"float:left;width:45%; text-align:right; margin-right:5%\">";
                                //html += "<div style=\"height:27px; line-height:27px; font-size:20px; font-family: Roboto Condensed-Regular,Roboto Condensed;font-weight: 400;color: #fa5151;\">$ " + json.referrals[i].amount + "</div>";
                                //html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\">&nbsp;</div>";
                                //html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\">" + json.referrals[i].status + "</div>";
                                //html += "</div>";
                                //if (json.referrals[i].userremark != "")
                                //    html += "<div style='margin-left:5%; color:#ff6a00;float:left;width:95%;'>" + json.referrals[i].userremark + "</div>";
                                //html += "</div>";
                                //html += "</div>";
                            }
                            lis.push(html);
                    });
                liss.push(totolcount);
                liss.push(lis);
                return liss;
            }

            function itemlist() {
                $("#itemlist").html("");
                var _more = "No more data";
                flow.load({
                    elem: '#itemlist',
                    isAuto: true,
                    end: _more
                    , done: function (page, next) {
                        setTimeout(function () {
                            var lis = [];
                            var josn = getitemlist(page, 10, lis);
                            var totolpage = josn[0];
                            var totolpage = totolpage / 10;
                            if (totolpage < 1)
                                totolpage = 1;
                            else
                                totolpage = modFoat(totolpage);
                            next(josn[1].join(''), page < totolpage);
                            element.init();
                        }, 200);
                    }
                });
            }

            function modFoat(v) {
                var _max = parseInt(v) + 1;
                if (_max - v <= 1) {
                    return _max;
                }
            }

            $(document).on("click", '#btnClose', function () {
                parent.layer.close(topindex);
            });

        });
    </script>
</head>
<body style="width: 100%; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% 100vh;">
    <input type="hidden" id="type" value="1" />
    <div style="width: 100%; margin: 0 auto; background: none; border-bottom: 0px solid #117546; " class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname">
            Tim saya
        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;">
        <div style="margin-top:60px;">
            <div style=" width: 100%; margin: 0 auto; margin-top: 15px; text-align: center; background:none; color:#fff; position: relative; height: auto; overflow: hidden;">
                <div class="typeitem over" value="1">
                    <div style="padding:10px; padding-top:0px; font-size:12px;">Level 1 (<font id="number3">{{$levelOneUsers}}</font>)</div>
                </div>
                <div class="typeitem" value="2">
                    <div style="padding: 10px; padding-top: 0px; font-size: 12px; ">Level 2 (<font id="number4">{{$levelTwoUsers}}</font>)</div>
                </div>
                <div class="typeitem" value="3">
                    <div style="padding: 10px; padding-top: 0px; font-size: 12px; ">Level 3 (<font id="number5">{{$levelThreeUsers}}</font>)</div>
                </div>
            </div>
            <div style="width: 100%; margin: 0 auto; position: relative; margin-top: 10px; background: none; height: auto; overflow: hidden; padding-top:10px; padding-bottom:10px; " id="itemlist">

            </div>
        </div>

    </div>
</body>
</html>
