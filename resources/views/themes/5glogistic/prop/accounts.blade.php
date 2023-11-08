<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
    <script src="{{asset('assets/frontend/js/comm.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/Lay/lay/modules/i18n.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v2.7')}}">
    <style>
        .indexdiv {
            background: #000000;
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

        .layui-layer-btn .layui-layer-btn0 {
            border-color: #0C2467 !important;
            background-color: #0C2467 !important;
            color: #fff;
        }

        .topname {
            line-height: 46px;
            font-weight: 700;
            font-size: 14px;
            width: 80%;
            text-align: center;
            color: #fff;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: auto;
        }

        .carditem {
            width: 100%;
            height: 110px;
            margin: 0 auto;
            border-width: 0px;
            border-color: #fff;
            border-style: solid;
            border-radius: 5px;
            box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.20);
            /*background-color: #fff;*/
            background: url("{{asset('assets/frontend/ui/bank.png')}}") no-repeat;
            background-size: 100% 100%;
            color: #808080;
            overflow: hidden;
        }

        .cmbtn {
            margin: 0 auto;
            width: 30%;
            margin-left: 20%;
            float: left;
            background: linear-gradient(to right, #FFE393, #FCC12D);
            cursor: pointer;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            margin-top: 20px;
            border-radius: 20px !important;
            color: #000;
            border-width: 1px;
            border-color: #FCC12D;
            border-style: solid;
            box-shadow: 0 2px 3px 0 rgb(245 188 44);
        }

        .cmbtn1 {
            margin: 0 auto;
            width: 30%;
            margin-left: 10%;
            float: left;
            background: linear-gradient(to right, gray, #aaa);
            cursor: pointer;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            margin-top: 20px;
            border-radius: 20px !important;
            color: #fff;
            border-width: 1px;
            border-color: #aaa;
            border-style: solid;
            box-shadow: 0 2px 3px 0 #aaa;
        }

    </style>
    <script type="text/javascript">
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules/')}}/"
        }).use(['form', 'layedit', 'laydate', 'jquery', 'layer', 'cookie'], function() {
            var $ = layui.jquery
                , layer = layui.layer;
            var topindex = parent.layer.getFrameIndex(window.name);
            $().ready(function() {

                banklist();
                window.upbanklist = function() {
                    banklist();
                };


                $(document).on("click", ".items", function() {
                    var bankid = $(this).attr("value");
                    var bankcard = $(this).attr("bankcard");
                    parent.layui.jquery("#bankid").val(bankid);
                    parent.layui.jquery("#select_card").html(bankcard);
                    parent.layer.close(topindex);
                });

                function banklist() {
                    var url = "{{route('user.my-accounts')}}";
                    var pm = {};
                    $.getJSON(url, pm
                        , function(json) {
                            var html = "";
                            if (json.accounts.length == 0) {
                                $('#add').show();
                                var _bank_t1 = $("#_bank_t1").val();
                                html += "<div style=\"padding:2px; width:100%; margin:0 auto; margin-top:50px;\" >";
                                html += "<div style=\"border-radius: 5px; color:#fff; text-align:center; margin-top:35px;position:relative;\">";
                                html += "<img src=\"{{asset('assets/frontend/imgss/no.png')}}\" style=\" width:100%;\">";
                                html += "<br>";
                                html += "</div>";
                                html += "</div>";
                                $("#card").html(html);
                            } else {
                                $('#add').hide();
                                var _banklist_t1 = $("#_banklist_t1").val();
                                var _banklist_t2 = $("#_banklist_t2").val();
                                var _banklist_t3 = $("#_banklist_t3").val();
                                for (var i = 0; i < json.accounts.length; i++) {
                                    html += "<div class=\"carditem\" id=\"edit\" data-id=\""+json.accounts[i].id+"\" style='margin-top:10px;position: relative;'>";
                                    //html += "<div style=\"width:25%; float:left;\"  class='items' value='" + json.JsonResult[i].id + "'  bankcard='" + json.JsonResult[i].bankcard + "' >";
                                    //html += "<img src=\"/img/mine/bank.png\" style=\" height:60px; margin:15px; margin-left:10px;margin-top:25px;\" />";
                                    //html += "</div>";
                                    html += "<div style=\"width:92%;float:left;text-align:left;line-height:22px; \" class='items' value='" + json.accounts[i].id + "'  bankcard='" + json.accounts[i].bank.name + "' >";
                                    html += "<div style=\"margin-top:10px; margin-left:35px; font-size:12px; \">" + json.accounts[i].bank.name + "</div > ";
                                    html += "<div style=\"margin-top:2px; margin-left:35px; font-size:12px; \">" + _banklist_t2 + "：" + json.accounts[i].account_holder + "</div>";
                                    html += "<div style=\"margin-top:4px;margin-left:35px;font-size:18px;color:#fff; font-weight:bold; \">" + json.accounts[i].bank_account + "</div>";
                                    /*   html += "<div style=\"margin-top:2px;margin-left:35px;font-size:12px;color:#888;  \">IFSC:" + json.JsonResult[i].IFSC + "</div>";*/

                                    html += "</div>";
                                    html += "<div style=\"width:8%; float:left; line-height:28px;\">";
                                    html += "<div style=\"margin-top:28px;\">&nbsp;";
                                    html += "</div>";
                                    html += "<div>";
                                    html += "<i class=\"layui-icon layui-icon-edit\" data-id=\"" + json.accounts[i].id + "\" id=\"carddel_" + json.accounts[i].id + "\" cardid='" + json.accounts[i].id + "' bankcard='" + json.accounts[i].bank_account + "' bankname='" + json.accounts[i].bank.name + "' uname='" + json.accounts[i].account_holder + "'  style=\"font-size:24px;position: absolute; color:#fff; top:1px; right:70px;\"></i>";
                                    html += "</div>";
                                    html += "</div>";
                                    html += "</div>";
                                }
                                $("#card").html(html);
                            }
                        });
                }


                $(document).on("click", "i[id^='carddel_']", function() {
                    var id = $(this).data('id');
                    var url = "{{route('user.edit-account')}}/" + id;
                    layer.open({
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

                $("#Cancel").click(function() {
                    $('.indexdiv').hide();
                    $("#noctie").hide();
                });

                $("#add").click(function() {
                    var url = "{{route('user.add-account')}}"
                    layer.open({
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

                $("#btnClose").click(function() {
                    parent.layer.close(topindex);
                });
            });
        });

    </script>
</head>

<body style="background-size: 100% auto; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% auto;">
    <input type="hidden" id="_bank_t1" value="" />
    <input type="hidden" id="_banklist_t1" value="" />
    <input type="hidden" id="_banklist_t2" value="Account Holder" />
    <input type="hidden" id="_banklist_t3" value="" />
    <div class="indexdiv"></div>
    <div style=" position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; margin: 0 auto; z-index: 102; width: 100%;height:auto; overflow:hidden; display:none; " id="noctie">
        <div style="position: relative; width: 100%; text-align: center; background: #000; height: auto; margin: 0 auto; width: 80%; border: 1px solid #ddc088 !important; border-radius: 10px; color: #fff; margin-top: 10px;">
            <div style=" width: 100%;height:40px; position: absolute; top: -23px;  ">
                <img src="{{asset('assets/frontend/img/noticetitle.png')}}" style=" width:240px; margin:0 auto;" />
            </div>
            <div style=" width: 100%;height:40px; position: absolute; top: -5px;  font-size:18px; font-weight:bold; text-align: right;  text-align:center; ">
                Tips
            </div>
            <br />
            <br />
            <br />
            <div style="width:90%;position:relative; margin:0 auto;  height:auto; overflow:hidden;border:0px;  font-size:12px;line-height:20px; text-align:left; ">
                <font id="banklist_t1"></font> ：<font id="bankname"></font><br />
                <font id="banklist_t2"></font> ：<font id="cardholder"></font><br />
                <font id="banklist_t3"></font> ：<font id="bankcard"></font><br />
                <!--<font >IFSC</font> ：<font id="IFSC"></font><br />-->
            </div>
            <div style="margin-bottom:20px; margin-top:20px; height:50px; ">
                <div id="Cancel" class="cmbtn1">
                    Cancel
                </div>
                <div id="Confirm1" value="" class="cmbtn">
                    Confirm
                </div>
            </div>
            <br />
        </div>
    </div>

    <div style="width: 100%; margin: 0 auto; background:none; border-bottom: 0px solid #fff; " class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color:#fff; margin-left:12px; font-size:18px;  font-weight:bold;">&#xe603;</i>
        </div>
        <font class="topname" id="topname1" style="color: #fff;">

        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>

    <div style=" max-width:450px; margin:0 auto;  ">
        <div class="layui-form layui-tab-content" style="padding: 5px 10px; margin-top: 55px;">
            <div id="card" style="width:100%;">

            </div>
            <div class="layui-form-item" style="margin-top:25px;">
                <div style="width:95%; margin:0 auto;">
                    <input class="layui-btn" id="add" value="Tambahkan" style="width: 100%; border-radius: 25px; color: #fff; font-weight: bold; background-image: linear-gradient(to right,#ddc088,#c0892f); font-size: 16px; border: 0px; border-radius: 10px; display: none;" type="button" />
                </div>
            </div>
        </div>
    </div>
</body>
</html>
