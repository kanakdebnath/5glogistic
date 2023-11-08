<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Change payment password</title>
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
            font-weight: 700;
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
        }

        div#div1 {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
        }

        div#div1>img {
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
            border-radius: 5px;
            color: #000;
        }

        .layui-input {
            border-style: none;
            border-radius: 5px !important;
        }

        .layui-select-title {
            border-radius: 10px !important;
        }

    </style>
    <script type="text/javascript">
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules/')}}/"
        }).use(['element', 'layer', 'cookie'], function() {
            var $ = layui.jquery
                , layer = layui.layer;

            $().ready(function() {

                $("#new-password").submit(function(e) {
                    e.preventDefault();

                    var index = layer.load();
                    var password1 = $("#password1").val();
                    var password2 = $("#password2").val();
                    var url = "{{route('user.setWithdrawlPassword')}}";
                    var pm = {
                        _token: "{{csrf_token()}}"
                        , password: password1
                        , password_confirmation: password2
                    , };

                    $.ajax({
                        url: url
                        , method: "POST"
                        , dataType: "json"
                        , data: pm
                        , success: function(data) {
                            $("#oldpassword").val("");
                            $("#password1").val("");
                            $("#password2").val("");
                            error(data.message);
                            layer.close(index);
                            window.location.reload();
                        }
                        , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function(index, value) {
                                if(typeof value == 'object')
                                {
                                    for(var i = 0; i < value.length; i++) {
                                        errorsHtml += '<p style="text-align:left;">' + value[i] + '</p>';
                                    }
                                }
                                else
                                {
                                    errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                                }
                            });
                            error(errorsHtml);
                            layer.close(index);
                        }
                    });

                });

                $("#old-password").submit(function(e) {
                    e.preventDefault();

                    var index = layer.load();
                    var oldpassword = $("#oldpassword").val();
                    var password1 = $("#password1").val();
                    var password2 = $("#password2").val();
                    var url = "{{route('user.updateWithdrawlPassword')}}";
                    var pm = {
                        _token: "{{csrf_token()}}"
                        , current_password: oldpassword
                        , password: password1
                        , password_confirmation: password2
                    , };

                    $.ajax({
                        url: url
                        , method: "POST"
                        , dataType: "json"
                        , data: pm
                        , success: function(data) {
                            $("#oldpassword").val("");
                            $("#password1").val("");
                            $("#password2").val("");
                            error(data.message);
                            layer.close(index);
                        }
                        , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function(index, value) {
                                if(typeof value == 'object')
                                {
                                    for(var i = 0; i < value.length; i++) {
                                        errorsHtml += '<p style="text-align:left;">' + value[i] + '</p>';
                                    }
                                }
                                else
                                {
                                    errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                                }
                            });
                            error(errorsHtml);
                            layer.close(index);
                        }
                    });

                });

                $("#btnClose").click(function() {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                });
            });
        });

    </script>
</head>

<body style="background-size: 100% auto; background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% auto;">
    <div style="width: 100%; margin: 0 auto; border-bottom: 0px solid #fff; background: none;" class="top">
        <div style="float:left; text-align:left; line-height:46px;width:50%;" id="btnClose">
            <i class="layui-icon" style=" color: #fff; margin-left: 12px; font-size: 18px; font-weight: bold;">&#xe603;</i>
        </div>
        <font class="topname" style="color: #fff;" id="topname1">Ubah sandi penarikan</font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">

        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;  ">
        <div class="layui-form layui-tab-content" style="padding:5px 10px; margin-top:50px;">
            <div class="layui-form layui-tab-content" style="padding: 10px 0;">
                @if(Auth::user()->withdrawl_password === null)
                <form class="layui-form" id="new-password">
                    <div class="layui-form layui-form-pane">
                        <div class="layui-form-item layui-form-text">
                            <div class="layui-input-block" style="">
                                <div style="margin: 10px; line-height:20px; color:#808080;   margin-top:0px;">
                                    <br />
                                    <div class="layui-form layui-form-pane">
                                        {{-- <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="oldpassword" maxlength="20" placeholder="Sandi penarikan sebelumnya" class="layui-input" autocomplete="off">
                                            </div>
                                        </div> --}}
                                        <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="password1" maxlength="20" placeholder="Sandi penarikan baru" class="layui-input" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="password2" maxlength="20" placeholder="Konfirmasi sandi penarikan" class="layui-input" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" style="height:48px;">
                                            <input class="layui-btn" id="confirm" value="Simpan perubahan" style="width: 100%; border: 0px; color: #fff; background-image: linear-gradient(to right,#ddc088,#c0892f); border-radius: 25px;" type="submit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <form class="layui-form" id="old-password">
                    <div class="layui-form layui-form-pane">
                        <div class="layui-form-item layui-form-text">
                            <div class="layui-input-block" style="">
                                <div style="margin: 10px; line-height:20px; color:#808080;   margin-top:0px;">
                                    <br />
                                    <div class="layui-form layui-form-pane">
                                        <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="oldpassword" maxlength="20" placeholder="Sandi penarikan sebelumnya" class="layui-input" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="password1" maxlength="20" placeholder="Sandi penarikan baru" class="layui-input" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" style="height:48px;">
                                            <div class="inputdiv">
                                                <i class="layui-icon layui-icon-password"></i>
                                                <input type="password" id="password2" maxlength="20" placeholder="Konfirmasi sandi penarikan" class="layui-input" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" style="height:48px;">
                                            <input class="layui-btn" id="confirm" value="Simpan perubahan" style="width: 100%; border: 0px; color: #fff; background-image: linear-gradient(to right,#ddc088,#c0892f); border-radius: 25px;" type="submit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
