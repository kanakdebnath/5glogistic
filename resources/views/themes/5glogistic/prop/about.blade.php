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
    <link rel="stylesheet" href="{{asset('assets/frontend/css/main.css?v2.7')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/video-js.min.css')}}">
    <script src="{{asset('assets/frontend/js/video.min.js')}}"></script>
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
                agreement();
            });

            function agreement() {
                var url = "/ashx/BusServer.ashx";
                var pm = {
                    action: "getaboutus"
                    , time: Math.random()
                };
                $.getJSON(url, pm
                    , function(json) {
                        if (json.State == "200") {
                            $("#nr").html(json.JsonResult);
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

<body style="background-size: 100% auto; background: linear-gradient(to top, #071730, #071730); ">
    <div class="top" style="background: #071730;">
        <div style="float:left; line-height:46px;width:50%;cursor:pointer;" id="btnClose">
            <i class="layui-icon" style="color:#fff;  margin-left:12px; font-size:16px;  font-weight:bold;"></i>
        </div>
        <font class="topname" id="topname1">
            Tentang Kami
        </font>
        <div style="float:right; text-align:right; line-height:46px;width:50%;">
        </div>
    </div>
    <div style=" max-width:450px; margin:0 auto;  ">
        <div style="width:98%; margin:0 auto; margin-top:60px;">
            <div style="border-width: 0px; width: 100%; margin: 0 auto; " id="videom">

            </div>
            <div style="border-radius: 5px; padding: 5px; margin-top: 10px; color:#fff; background: #0d1C43; text-align: left; position: relative;" id="nr">
                <p>
                    SpaceX proposed the Starlink
                    program in 2015 and launched the first batch of prototype satellites in 2018. The plan aims to
                    launch tens of thousands of small satellites into low-Earth orbit to build a huge constellation of
                    satellites to provide broadband Internet services around the
                </p>
                <p><br></p>
                <p>
                    Starlink is a space service company SpaceX that provides high-speed Internet access services covering
                    the world through a group of low-Earth orbit satellites. As of July 23, 2022, Starlink services are
                    available in 36 countries and regions.
                </p>
                <p><br></p>
                <p>60 Starlink satellites are stacked together.</p>
                <p><br></p>
                <p>
                    SpaceX CEO Elon Musk announced in Seattle the launch of a space high-speed internet project: the
                    Starlink project.
                </p>
                <p><br></p>
                <p>
                    Starlink is a constellation of low earth orbit satellites used in the field of communications. It is
                    planned to consist of 42,000 satellites, which can provide users with large-capacity, low-latency
                    satellite Internet services.
                </p>
                <p>
                    SpaceX's efficiency of 50-60
                    satellites per launch since May 2019 has been maintained for almost a few months. As of October 14,
                    2022, 3,399 satellites have been launched, including 3,168 in-orbit satellites (2,700 in-orbit) .
                    services) , 231 pieces were scrapped. Its users currently primarily include most of North America,
                    Europe, parts of Latin America, and most of Australia.</p>
                <p><br></p>
                <p><br></p>
                <p><br></p>
                <p>
                    The existing in-orbit satellites of Starlink can provide global users with high-throughput and
                    low-latency satellite Internet services, which can be divided into four categories: home use,
                    business use, RV special use and navigation special use
                    <br>
                </p>
                <p><br></p>
                <p>
                    Although as the world's first
                    satellite Internet product, it is more avant-garde than the traditional fiber-optic Internet that
                    people are familiar with, but from the perspective of customer experience, there will be no obvious
                    difference.
                </p>
                <p><br></p>
                <p><br></p>
                <p>
                    Compared with traditional Internet services with a high market penetration rate, satellite Internet
                    charges are too high and uncompetitive; but in areas where traditional Internet is difficult to
                    reach, satellite Internet has obvious price advantages, which is mainly due to the characteristics
                    of global coverage of satellite Internet .
                </p>
                <p><br></p>
                <p><br></p>
                <p>
                    Since the satellite Internet is a specific application of satellite communication, the satellite
                    communication system uses the communication satellite transponder as a relay station to realize
                    signal transmission between the ground by transmitting or forwarding wireless signals. The reception
                    of ground signals does not rely on erection like the traditional Internet. A large number of
                    road-based equipment can be transferred, so it can provide services even in inaccessible areas such
                    as desert Gobi, polar regions and oceans
                </p>
                <p><br></p>
                <p><br></p>
                <p>
                    In terms of satellite launches, SpaceX's multi-satellite launch capability and single launch cost are
                    very competitive, which constitutes SpaceX's core competitiveness in the process of building
                    satellite Internet constellations
                    <br>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
