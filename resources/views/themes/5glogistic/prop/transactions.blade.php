<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>About us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v1.3')}}">
    <style type="text/css">
        .topname {
            line-height: 46px;
            font-weight: bold;
            font-size: 14px;
            width: 75%;
            text-align: center;
            color: #000;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
        }



        .typeitem {
            float: left;
            width: 50%;
            height: auto;
            overflow: hidden;
        }

        .over {
            border-bottom: 1px solid #aaa;
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
                // checklanguage();
                itemlist();
                function checklanguage() {
                    var language = "en";
                    language = $.cookie('language');
                    if (language == "" || language == null) {
                        $.cookie('language', "en", { path: '/', expires: 180 });
                        language = "en";
                    }
                    $.i18n.properties({
                        name: 'strings',
                        path: '/Languages/',
                        mode: 'map',
                        language: language,
                        cache: false,
                        encoding: 'UTF-8',
                        callback: function () {
                            document.title = $.i18n.prop('_accountdetails_title');
                            $("#topname1").html($.i18n.prop('_accountdetails_title'));
                            $("#_more_info").val($.i18n.prop('_more_info'));
                            $("#_accountdetails_t1").html($.i18n.prop('_accountdetails_t1'));
                            $("#_accountdetails_t2").html($.i18n.prop('_accountdetails_t2'));
                            $("#_accountdetails_t3").html($.i18n.prop('_accountdetails_t3'));
                            $("#_accountdetails_t4").html($.i18n.prop('_accountdetails_t4'));
                            $("#_accountdetails_t5").html($.i18n.prop('_accountdetails_t5'));
                            $("#_accountdetails_t6").html($.i18n.prop('_accountdetails_t6'));
                            $("#_accountdetails_t7").html($.i18n.prop('_accountdetails_t7'));
                            $("#_accountdetails_t8").html($.i18n.prop('_accountdetails_t8'));
                            $("#_accountdetails_t9").html($.i18n.prop('_accountdetails_t9'));
                            $("#_accountdetails_t10").html($.i18n.prop('_accountdetails_t10'));
                            $("#_accountdetails_t11").html($.i18n.prop('_accountdetails_t11'));
                            $("#_accountdetails_t12").html($.i18n.prop('_accountdetails_t12'));
                            form.render();
                        }
                    });
                }
            });



            function getitemlist(page, pagesize, lis) {
                var liss = [];
                var totolcount = 0;
                var status = $("#status").val();
                var url = "{{route('user.transaction-ajax')}}";
                var pm = {
                    page: page,
                    limit: pagesize,
                    status: status,
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm,
                    function (json) {
                        var html = "";
                            totolcount = json.PageTotal;
                            if (json.transactions.length == 0) {
                                html += "<div style=\"padding:2px; width:100%; margin:0 auto; margin-top:50px;\" >";
                                html += "<div style=\"border-radius: 5px; color:#fff; text-align:center; margin-top:35px;position:relative;\">";
                                html += "<img src=\"{{asset('assets/frontend/imgs/no.png')}}\" style=\" width:100%;\">";
                                html += "<br>";
                                html += "</div>";
                                html += "</div>";
                            }
                            for (var i = 0; i < json.transactions.length; i++) {
                                html += "<div style=\"height:auto;overflow:hidden;color:#333;background:none;margin:0 auto; width100%; margin-top:5px;\">";
                                html += "<div style=\"padding:10px; border-bottom: 1px solid #222;height: auto; overflow: hidden;\">";
                                html += "<div style=\"float:left;width:55%; margin-left:0%\">";
                                html += "<div style=\"height:27px; line-height:27px;\">";
                                if(json.transactions[i].trx_type == "+")
                                {
                                    html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; color: green\">" + json.transactions[i].remarks + json.transactions[i].trx_type + "</span></div>";
                                }
                                else
                                {
                                    html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; color: red\">" + json.transactions[i].remarks + json.transactions[i].trx_type + "</span></div>";
                                }

                                /* html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\"></div>";*/
                                // html += "<div style=\"height:27px; line-height:27px;font-size:12px; color:#999;\">" + json.transactions[i].creation_time + "</div>";
                                html += "</div>";
                                html += "<div style=\"float:left;width:35%; text-align:right; margin-right:0%\">";
                                html += "<div style=\"height:27px; line-height:27px; font-size:14px; font-weight: 200;color: #fff;\">Rp  " + json.transactions[i].amount + "</div>";
                                // html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\">&nbsp;</div>";
                                html += "<div style=\"height:27px; line-height:27px;font-size:12px; color:#999;\">" + json.transactions[i].creation_time + "</div>";
                                //html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#999;\">" + json.JsonResult[i].status + "</div>";
                                html += "</div>";
                                html += "</div>";
                                html += "</div>";
                            }
                            lis.push(html);
                        CommAlert(json);
                    });
                liss.push(totolcount);
                liss.push(lis);
                return liss;
            }

            function itemlist() {
                $("#itemlist").html("");
                var _more_info = $("#_more_info").val();
                flow.load({
                    elem: '#itemlist',
                    isAuto: true,
                    end: _more_info
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
            $(document).on("click", '.typeitem', function () {
                $(".typeitem").each(function () {
                    $(this).removeClass("over");
                });
                $(this).addClass("over");
                var id = $(this).attr("value");
                $("#status").val(id);
                itemlist();
            });

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

<body style="background: linear-gradient(to top, #071730, #071730); background-size: 100% 100%;">
    <input type="hidden" id="status" value="1" />
    <input type="hidden" id="_more_info" value="" />

    <div style="width: 100%; margin: 0 auto; background:none; border-bottom: 0px solid #117546; " class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname" style="color: #fff;">
            Riwayat saldo
        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;">
        <div style=" width:100%;margin:0 auto;margin-top:56px;color:#fff;position:relative;">
            <div
                style=" width: 100%; margin: 0 auto; margin-top: 55px;  text-align: center; background:none; color:#fff; position: relative; height: auto; overflow: hidden;">
                <div class="typeitem over" value="1">
                    <div style="padding: 10px; height: 30px; line-height:30px; overflow: hidden;">Kenaikan saldo</div>
                </div>
                <div class="typeitem" value="2">
                    <div style="padding: 10px; height: 30px; line-height: 30px; overflow: hidden; ">Penurunan saldo</div>
                </div>
            </div>
        </div>
        <div style="width:100%;margin:0 auto; position:relative;" id="itemlist">

        </div>
    </div>
</body>
</html>
