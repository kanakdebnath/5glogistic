@extends($theme.'layouts.starline')

@section('head')
<meta charset="utf-8">
<title>404</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<script src="{{asset('assets/frontend/Lay/layui.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/frontend/Lay/css/layui.css')}}">
<script src="{{asset('assets/frontend/js/comm.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/frontend/css/main.css')}}">
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
        <div style="height:50px;line-height:50px;  text-align:center;  font-weight:bold; color:#fff;">404</div>

        <div style="text-align: center; background: #06163A; width: 98%; margin: 0 auto; margin-top: 20px; padding-bottom: 15px; height: auto; overflow: hidden; position: relative; ">
            <div id="list">
                <div style='height:150px;line-height:150px; color:#fff;'>!Oops 404 Page Not Found</div>
            </div>
        </div>


        <nav class="nav" style="background-size:100% 100%; height:60px; ">
            <div url="{{route('home')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/1.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn1">Home</span>
            </div>
            <div url="{{route('user.my-products')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/2.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn2">Finance</span>
            </div>
            <div url="#">
                <img src="{{asset('assets/frontend/ui/nav/3.png')}}" class="gray" style="height: 60px; margin-top: -20px;" /> <br />
            </div>
            <div url="{{route('user.referral')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/4.png')}}" class="gray" style="height: 25px; " /> <br />
                <span id="nav_btn3">Team</span>
            </div>
            <div url="{{route('user.home')}}" class="navtab">
                <img src="{{asset('assets/frontend/ui/nav/5.png')}}" class="gray" style="height: 25px;" /> <br />
                <span id="nav_btn4">Mine</span>
            </div>
        </nav>
    </div>
</body>
@endsection
