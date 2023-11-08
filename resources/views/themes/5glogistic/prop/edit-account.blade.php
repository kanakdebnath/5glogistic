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
    <script type="text/javascript">
        layui.config({
            base: "{{asset('assets/frontend/Lay/lay/modules')}}/"
        }).use(['form', 'element', 'layer', 'cookie'], function () {
            var $ = layui.jquery, layer = layui.layer;
            var cookie = layui.cookie;
            var form = layui.form
            var topindex = parent.layer.getFrameIndex(window.name);

            function diaoyong() {
                parent.upbanklist();
            }

            $().ready(function () {

                $("#edit-form").submit(function (e) {
                    e.preventDefault();

                    var index = layer.load();
                    var bank_account = $("#bank_account").val();
                    var url = "{{route('user.update-account', $id)}}";
                    var pm = {
                        _token: "{{csrf_token()}}",
                        bank_account: bank_account
                    };

                    $.ajax({
                        url: url
                        , method: "POST"
                        , dataType: "json"
                        , data: pm
                        , success: function(data) {
                            error(data.message);
                            layer.close(index);
                            setTimeout(() => {
                                parent.upbanklist();
                                parent.layer.close(topindex);
                            }, 1000);
                        }
                        , error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function(index, value) {
                                errorsHtml += '<p style="text-align:left;">' + value + '</p>';
                            });
                            error(errorsHtml);
                            layer.close(index);
                        }
                    });

                });


                $("#btnClose").click(function () {
                    parent.upbanklist();
                    parent.layer.close(topindex);
                });
            });
        });
    </script>
    <style>
        .layui-select-title {
            border: 1px solid #444 !important;
        }
        .layui-input, .layui-select, .layui-textarea {
            height: 38px;
            line-height: 1.3;
            background:none !important;
            color: #fff;
            border-width: 0px;
            border-style: solid;
            border-radius: 2px;
        }

        .top {
            border-bottom: 1px solid #fff;
            z-index: 100;
            width: 100%;
            margin-bottom: 5px;
            height: 46px;
            position: fixed;
            left: 0px;
            top: 0px;
        }

        .topname {
            font-weight: bold;
            line-height: 46px;
            width: 80%;
            text-align: center;
            color: #000;
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

        .inputdiv {
            display: flex;
            border: 1px solid #444 !important;
            background-color: none;
            height: 38px;
            line-height: 38px;
            padding: 0px 19px;
            border-radius: 3px;
            color: #fff;
        }

        .layui-form-select dl dd.layui-this {
            background-image: linear-gradient(to right,#ddc088,#c0892f);
            color: #fff !important;
        }

        .layui-unselect layui-form-select {
            border-radius: 15px !important;
            border: 1px solid #444 !important;
        }


        .layui-input-block {
            margin-left: 0px !important;
            min-height: 36px;
        }
        .layui-form-select .layui-input {
            padding-right: 30px;
            width:300px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background: url({{asset('assets/frontend/ui/bg4.png')}}) no-repeat; background-size: 100% auto;">
    <input type="hidden" id="_bank_t3" value="" />
    <div style=" max-width:450px; margin:0 auto; height:auto; overflow:hidden;">
        <div class="top" style="background:none; border:0px;">
            <div style="float:left; line-height:46px;width:50%;">
                <i class="layui-icon" style="color:#fff;  margin-left:12px; font-size:18px;  font-weight:bold;" id="btnClose">&#xe603;</i>
            </div>
            <font class="topname" id="topname1" style="color: #fff;">
                Ubah akun bank
            </font>
            <div style="float:right; text-align:right; line-height:46px;width:50%;">

            </div>
        </div>
        <div class="layui-form layui-tab-content" style="padding:10px 10px; margin-top:46px;">
            <div class="layui-form layui-tab-content" style="padding: 20px 0;margin-top:10px;">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form layui-form-pane">
                        <form class="layui-form" id="edit-form">
                            <div class="layui-form-item" style="height:45px;">
                                <div >
                                    <select id="bankcode" class="layui-input" disabled style="color: #fff; display: none; width:100%; border: 0px; background: none;" placeholder="" lay-search="">
                                        @foreach ($banks as $bank)
                                        <option value="{{$bank->id}}" @if($bank->id == $account->bank_id) selected @endif>{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                    <!--<input type="text" id="bank_id" maxlength="49" autocomplete="new-password" readonly="readonly" value="All banks supported" style="color: #fff; border: 0px; background: none;" placeholder="" class="layui-input" />-->
                                </div>
                            </div>
                            <div class="layui-form-item" style="height:45px;">
                                <div class="inputdiv">
                                    <img src="{{asset('assets/frontend/ui/icon-name.png')}}" style="height:18px; margin-right:5px; margin-top:8px;" />
                                    <input type="text" id="account_holder" maxlength="49" autocomplete="new-password" style="color: #fff; border: 0px; background: none;" placeholder="Please enter your name" value="{{$account->account_holder}}" disabled class="layui-input" />
                                </div>
                            </div>
                            <div class="layui-form-item" style="height:45px;">
                                <div class="inputdiv">
                                    <img src="{{asset('assets/frontend/ui/icon-bank.png')}}" style="height: 18px; margin-right: 5px; margin-top: 8px;" />
                                    <input type="number" id="bank_account" autocomplete="new-password" style="color: #fff; border: 0px; background: none;" maxlength="49" placeholder="Please enter your bank account" value="{{$account->bank_account}}" class="layui-input" />
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top:25px;">
                                <input class="layui-btn" id="edit" value="Ubah" style="width: 100%; border-radius: 25px; color: #fff; font-weight: bold; background-image: linear-gradient(to right,#ddc088,#c0892f); font-size: 16px; border: 0px; border-radius: 10px; " type="submit" />
                            </div>
                             <div style="width: 100%; margin: 0 auto; ">
                <div style="width: 98%; margin: 0 auto; padding-bottom: 10px; border-radius: 3px; ">
                    <div style="height: 35px; line-height: 35px; text-align: center; "><span style=" color:#fff; font-weight:bold;" id="_recharge_t5">Informasi Akun bank</span></div>
                    <br>
                    <div style="text-align: left; padding: 20px; font-size:12px !important; padding-top: 0px; height: auto; overflow: hidden; color: #fff;" id="payinfo">
                        <p>1. Pastikan data bank anda diisi dengan valid</p>
                        <p><br></p>
                        <p>2. Jika menggunakan E-Wallet harap langsung memasukkan nomor E-Wallet yg terdaftar anda (Tidak menggunakan Virtual Account)</p>
                        <p><br></p>
                        <p>3. Kesalahan penulisan akan membuat penarikan anda gagal oleh bank</p>
                        <p><br></p>
                        <p>4. Kami tidak bertanggung jawab atas segala kesalahan yg dilakukan oleh pengguna</p>
                        <p><br></p>
                    </div>
                </div>
                <br />
            </div>
    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>

