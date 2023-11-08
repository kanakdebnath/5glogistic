<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css?1.0')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v1.3')}}">
    <style type="text/css">
        .topname {
            line-height: 46px;
            font-size: 14px;
            width: 75%;
            text-align: center;
            color: #fff;
            position: absolute;
            font-weight:bold;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
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
            font-weight: bold;
            margin-left: 3%;
            cursor: pointer;
            font-family: 黑体;
            font-size: 13px;
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
                            document.title = $.i18n.prop('_pay_title');
                            $("#topname1").html($.i18n.prop('_pay_title'));
                            $("#_more_info").val($.i18n.prop('_more_info'));
                            $("#_pay_t1").html($.i18n.prop('_pay_t1'));
                            $("#_pay_t2").html($.i18n.prop('_pay_t2'));
                            $("#_pay_t3").html($.i18n.prop('_pay_t3'));
                            $("#_pay_t4").html($.i18n.prop('_pay_t4'));
                            form.render();
                        }
                    });
                }
            });


            $(document).on("click", '#typelist span', function () {
                $("#typelist span").each(function () {
                    $(this).addClass("typeitem");
                    $(this).removeClass("typeitemover");
                });
                $(this).addClass("typeitemover");
                $(this).removeClass("typeitem");
                var id = $(this).attr("value");
                $("#status").val(id);
                itemlist();
            });





            function getitemlist(page, pagesize, lis) {
                var liss = [];
                var totolcount = 0;
                var status = $("#status").val();
                var url = "{{route('user.payin-log-ajax')}}";
                var pm = {
                    _token: "{{csrf_token()}}",
                    page: page,
                    limit: pagesize,
                    status: status,
                };
                $.ajaxSettings.async = false;
                $.getJSON(url, pm,
                    function (json) {
                        var html = "";
                        totolcount = json.PageTotal;
                        if (json.logs.length == 0) {
                            html += "<div style=\"padding:2px; width:100%; margin:0 auto; margin-top:50px;\" >";
                            html += "<div style=\"border-radius: 5px; color:#fff; text-align:center; margin-top:35px;position:relative;\">";
                            html += "<img src=\"{{asset('assets/frontend/imgss/no.png')}}\" style=\" width:100%;\">";
                            html += "<br>";
                            html += "</div>";
                            html += "</div>";
                        }
                        for (var i = 0; i < json.logs.length; i++) {
                            html += "<div style=\"height:auto;overflow:hidden;color:#333;background:linear-gradient(to right,#ddc088,#c0892f);margin:0 auto; width:100%; margin-top:10px;\">";
                            html += "<div style=\"padding:10px;border-bottom: 1px solid #eee;height: auto; overflow: hidden;\">";
                            html += "<div style=\"float:left;width:45%; margin-left:5%\">";
                            html += "<div style=\"height:27px; line-height:27px;\">";
                            html += "<span style =\"padding:3px; padding-left: 0px;padding-right:10px;border-radius: 10px; color: #fff\">" + json.logs[i].orderNum + "</span></div>";
                            html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#fff;\">Deposit</div>";
                            html += "<div style=\"height:27px; line-height:27px;font-size:12px; color:#eee;\">" + json.logs[i].creation_time + "</div>";
                            html += "</div>";
                            html += "<div style=\"float:left;width:45%; text-align:right; margin-right:5%\">";
                            html += "<div style=\"height:27px; line-height:27px; font-size:16px; font-weight: 200;color: #fff;\">Rp  " + json.logs[i].payMoney + "</div>";
                            html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#888;\">&nbsp;</div>";
                            html += "<div style=\"height:27px; line-height:27px;font-size:12px;color:#fff;\">" + json.logs[i].status + "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                        }
                        lis.push(html);
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
<body style="background-size: 100% auto; background: linear-gradient(to top, #071730, #071730); background-size: 100% auto; ">
    <input type="hidden" id="status" value="-1" />
    <input type="hidden" id="_more_info" value="" />

    <div style="width: 100%; margin: 0 auto; background: none; border-bottom: 0px solid #117546; " class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname" id="topname1">

        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto; height:auto; overflow:hidden;">
        <div style=" width:100%;margin:0 auto;margin-top:46px;color:#fff; display:none; background:#f1f1f1; position:relative;">
            <div style="height:auto; margin:0 auto; text-align:left; line-height:18px;padding-top:10px; padding-bottom:10px; overflow:hidden;" id="typelist">
                <span class="typeitemover" value="-1" id="_pay_t1"></span>
                <span class="typeitem" value="0" id="_pay_t2"> </span>
                <span class="typeitem" value="1" id="_pay_t3"> </span>
                <span class="typeitem" value="2" id="_pay_t4"> </span>
            </div>
        </div>
        <div style=" width: 100%; margin: 0 auto; position: relative; margin-top: 50px;" id="itemlist">

        </div>
    </div>
</body>
</html>
