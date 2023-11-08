@extends($theme.'layouts.starline')

@section('head')
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

    .gray {
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: grayscale(100%);
        filter: blue;
    }

    .navtab {
        cursor: pointer;
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

        $(document).on("click", '.navtab', function() {
            var url = $(this).attr("url");
            location.href = url;
        });

    });

</script>
<style>
    p {
        line-height: 20px;
        font-size: 12px;
    }

</style>
@endsection

@section('content')
<body style="background-size: 100% auto; background: linear-gradient(to top, #071730, #071730);  ">
    <div style=" max-width:450px; margin:0 auto;  ">
        <div style="height:50px;line-height:50px;  text-align:center;  font-weight:bold; color:#fff;">Portofolio</div>
        <div style="width:98%; margin:0 auto; margin-top:0px;">
            <div style="width: 98%; margin: 0 auto; margin-top: 20px; height: auto; overflow: hidden; ">
                <div style="width:100%; margin:0 auto; margin-bottom:10px;">
                    <div style="width:49%;float:left; border-radius: 10px !important;">
                        <button id="Invite" style="width: 100%; border:0px; font-size: 12px; text-align: center; height: 80px; border-radius: 5px !important; background: linear-gradient(to right,#ddc088,#c0892f); background-size: 100% 100%;" type="button">
                            <div>
                                <div style="color: #fff; font-weight: bold;padding-bottom: 0px; font-size: 16px; " id="number1">{{$roi['totalInvest']}}</div>
                                <div style=" font-size: 12px; color: #fff; margin-top:5px;">Produk aktif</div>
                            </div>
                        </button>
                    </div>
                    <div style="width:49%;float:left; margin-left:2%; ">
                        <button id="HOW" style="width: 100%; border: 0px; text-align: center; font-size: 12px; height: 80px; border-radius: 5px !important; background: linear-gradient(to right,#ddc088,#c0892f); background-size: 100% 100%;" type="button">
                            <div>
                                <div style="color: #fff; font-weight: bold; padding-bottom: 0px; font-size: 16px; " id="number2">{{config('basic.currency_symbol').' '.getAmount($roi['returnProfit'])}}</div>
                                <div style="font-size: 12px; color: #fff; margin-top: 5px; ">Total penghasilan</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; background: #06163A; width: 98%; margin: 0 auto; margin-top: 20px; padding-bottom: 200px; height: auto; overflow: hidden; position: relative; ">
            <div id="list">
                @forelse ($investments as $investment)
                @php
                    $plan = App\Models\ManagePlan::find($investment->plan_id)
                @endphp
                @php
                    $start_date = Carbon\Carbon::parse($investment->created_at)->format('Y M d H:i');
                    $end_date = Carbon\Carbon::parse($investment->created_at)->addDays($investment->maturity)->format('Y M d H:i');
                @endphp

                <div style="height: auto; overflow: hidden; padding-top:15px; padding-bottom:25px;">
                    <div>
                        <img src="{{getFile(config('location.plan.path').$investment->plan->image) ? : 0}}" style="width:150px; margin-left:5px; border-radius: 10px;">
                    </div>
                    <div>
                        <div>
                            <div style="padding-top: 10px; font-size:16px; text-align:center; color:#fff;">{{$investment->plan->name}}</div>
                        </div>
                        <div style="padding-top: 10px;">
                            <div style="display: flex; padding: 5px 20px; border-bottom: 1px solid #394969;">
                                <div style="flex:1; text-align:left; font-size:14px; color: #394969;">Harga : </div>
                                <div style="flex:1; text-align:right; font-weight:bold; font-size:14px; color: #C28F36;">{{$basic->currency_symbol}} {{number_format($plan->fixed_amount)}}</div>
                            </div>
                            <div style="display: flex; padding: 5px 20px; border-bottom: 1px solid #394969;">
                                <div style="flex:1; text-align:left; font-size:14px; color: #394969;">Profit : </div>
                                <div style="flex:1; text-align:right; font-weight:bold; font-size:14px; color: #C28F36;">{{$basic->currency_symbol}} {{number_format($investment->profit)}} / Hari </div>
                            </div>
                            <div style="display: flex; padding: 5px 20px; border-bottom: 1px solid #394969;">
                                <div style="flex:1; text-align:left; font-size:14px; color: #394969;">Waktu mulai: </div>
                                <div style="flex:1; text-align:right; font-weight:bold; font-size:14px; color: #C28F36;">{{$start_date}} WIB</div>
                            </div>
                            <div style="display: flex; padding: 5px 20px; border-bottom: 1px solid #394969;">
                                <div style="flex:1; text-align:left; font-size:14px; color: #394969;">Durasi: </div>
                                <div style="flex:1; text-align:right; font-weight:bold; font-size:14px; color: #C28F36;">
                                    @if($investment->maturity == -1)
                                    Lifetime
                                    @else
                                    {{$investment->maturity}}
                                    @endif
                                    Hari
                                </div>
                            </div>
                            <div style="display: flex; content-align:center; padding: 5px 20px;">
                                <div style="flex:1; text-align:left; font-size:14px; color: #394969;">Status: </div>
                                <div style="flex:1; text-align:right; font-weight:bold; font-size:14px; color: #C28F36;">
                                    @if($investment->status == 1)
                                    <button style="padding: 3px 5px; font-size:12px; background-image: linear-gradient(to right,#ddc088,#c0892f); margin: 0 auto; border: 0px; color: #fff; border-radius: 5px;">Aktif</button>
                                    @else
                                    <button style="padding: 3px 5px; font-size:12px; background-image: linear-gradient(to right,#88c9dd,#2f88c0); margin: 0 auto; border: 0px; color: #fff; border-radius: 5px;">Selesai</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style='height:150px;line-height:150px; color:#fff;'>Anda tidak memiliki produk aktif.</div>
                @endforelse
            </div>
        </div>


         <nav class="nav" style="background-size:100% 100%; height:60px; ">
            <div url="{{route('home')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/1.png')}}" class ="gray" style="height: 25px;" /> <br />
                <span id="nav_btn1">Utama</span>
            </div>
            <div style="color: #AF873F !important; font-weight: bold; ">
                <img src="{{asset('assets/frontend/ui/nav/2.png')}}" style="height: 25px;" /> <br />
                <span id="nav_btn2">Portofolio</span>
            </div>
            <div url="#">
                <img src="{{asset('assets/frontend/ui/nav/7.png')}}" class="logo" style="height: 55px; margin-top: -20px;" /> <br />
            </div>
            <div url="{{route('user.referral')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/4.png')}}" class="gray" style="height: 25px; " /> <br />
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
