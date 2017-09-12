<!DOCTYPE html>
<html>
<head>
    <title>双色球 - 投注列表</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/tz.min.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinePhone.js" type="text/javascript"></script>
</head>
<body>
<div id="tx_c" class="logints" style="display:none;"></div>
<section id="dConfirm" class="zfPop weige_" style="position: fixed;z-index: 1000;display: none"><h4>提示</h4>
    <div class="clearfix pdLeft08 center"></div>
    <div class="zfTrue clearfix">
        <input type="button" value="取消" class="zfqx" id="zfqx"/>
        <input type="button" value="确定" id="zfqd"/>
    </div>
</section>
<div id="Mask"
     style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>
<script type="text/javascript">
    var ires = "http://res.qcwddd.com/iqucai.touch/images/";
    var dres = "http://data.qcwddd.com/matchdata/";
</script>

<div style="position: relative;" id="outer">
    <div class="wrap">
        <section>
            <article>
                <header class="moreHeader">
                    <a href="javascript:history.go(-1)" class="back">&lt;</a>
                    <h1>双色球-投注列表</h1>
                </header>
            </article>
            <article>
                <div class="clearfix ssqbtn">
                    <input class="handBtn" type="submit" value="自选一注" name="" onclick="window.location.href='/buy/SSQ'">
                    <input id="jxbtn" class="handBtn" type="submit" value="机选一注" name="">
                    <span id="clearAll" class="handBtn relative clearBtn">清空号码</span>
                </div>
                <div class="ssqNum">
                    <div class="ssqtzNum" gametype="DS">
                        <cite class="errorBg"><em class="error2"></em></cite>
                        <span><em>02 04 11 12 19 32</em><cite>14</cite></span>
                        <p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p>
                    </div>
                    <div class="ssqtzNum" gametype="DS">
                        <cite class="errorBg"><em class="error2"></em></cite>
                        <span><em>02 04 11 12 19 32</em><cite>14</cite></span>
                        <p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p>
                    </div>
                    <div class="ssqtzNum" gametype="DS">
                        <cite class="errorBg"><em class="error2"></em></cite>
                        <span><em>02 04 11 12 19 32</em><cite>14</cite></span>
                        <p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p>
                    </div>
                    <div class="ssqtzNum" gametype="DS">
                        <cite class="errorBg"><em class="error2"></em></cite>
                        <span><em>02 04 11 12 19 32</em><cite>14</cite></span>
                        <p>普通投注&nbsp;&nbsp;&nbsp;1注2元</p>
                    </div>
                </div>
                <p class="pact clearfix">
                    <input class="left check" type="checkbox">
                    我已阅读并同意《用户购彩服务协议》
                </p>
            </article>
            <footer class="ssqFooter">
                <div class="fixed">
                    <ul class="ssqdouble clearfix">
                        <li>
                            <cite>追</cite>
                    <span>
                        <!--<em class="qminus">-</em>-->
                        <input type="tel" value="1" name="qs"/>
                        <!--<em class="qplus">+</em>-->
                    </span>
                            <cite>期</cite>
                        </li>
                        <li>
                            <cite>投</cite>
                    <span>
                        <!--<em class="bminus">-</em>-->
                        <input type="tel" value="1" name="bs"/>
                        <!--<em class="bplus">+</em>-->
                    </span>
                            <cite>倍</cite>
                        </li>
                    </ul>
                    <ul class="ssqzh clearfix" style="display:none">
                        <li q="10"><em>10期</em><cite>新手最爱</cite></li>
                        <li q="30"><em>30期</em><cite>人气最高</cite></li>
                        <li q="60"><em>60期</em><cite>大奖必备</cite></li>
                        <li q="100"><em>100期</em><cite>双色球包年</cite></li>
                    </ul>
                    <div class="zjStop" style="display:none"><em class="left check"></em>中奖后停止追号</div>
                    <div class="buyFloat">
                        <input id="fqhm" class="fqhm" type="button" value="发起合买"/>
                <span>共
                    <cite id="count_Notes" class="yellow">0</cite>注&nbsp;&nbsp;
                    <cite id="count_Money" class="yellow">0</cite>元
                </span>
                        <a id="pay" class="ture" href="javascript:;">确认</a>
                    </div>
                </div>
            </footer>
        </section>

        <input id="Red_BallValue" type="hidden" name="RedBallValue" value=""/>
        <input id="Blue_BallValue" type="hidden" name="BlueBallValue" value=""/>
        <script type="text/javascript">
            var gameCode = "SSQ", gameName = "双色球";
        </script>
        <script src="/scripts/user.js" type="text/javascript"></script>
        <script src="/scripts/tz.js" type="text/javascript"></script>
    </div>
</div>

</body>
</html>
