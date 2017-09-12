<!DOCTYPE html>
<html>
<head>
    <title>双色球 - 订单投注</title>
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
    <link href="/css/szc.min.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinephone.js" type="text/javascript"></script>
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
<div id="Mask" style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>
<script type="text/javascript">
    var ires = "http://res.qcwddd.com/iqucai.touch/images/";
    var dres = "http://data.qcwddd.com/matchdata/";
</script>
<header class="tzHeader">
	<section class="fcHeader">
		<a href="javascript:history.go(-1)" class="back">&lt;</a>
		<h1>双色球</h1>
		<div class="pullDown">
			<em id="pullIco" class="fcpullIco"></em>
			<div id="pullText" class="pullText" style="display:none">
				<a href="" class="red">投注选号</a>
				<a href="">开奖结果</a>
				<a href="">玩法帮助</a>
			</div>
		</div>
	</section>
</header>
<div style="position: relative;" id="outer">
    <div class="wrap">

        <nav id="ssq_tab" class="sdTab ssqTab relative" style="display: none">
            <ul class="clearfix">
                <li id="pttz" class="cur" val="DS" url="BZXH" playid="1">普通投注</li>
            </ul>
            <em class="downline" style="width:22%; left:14%"></em>
        </nav>
        <article>
            <div class="p5kj clearfix">
                <div class="left fl cp_ssq">
                    第2017041期 2017-04-11 19:40（周四）截止
                </div>
                <div id="lskj" class="right fr">
                    <span class="left">历史开奖</span> <em class="ssqup ssqdown"></em>
                </div>
            </div>
            <div class="ssqkjlist" style="display:none">
                <ul>
                    <li class="first">040期</li>
                    <li>
                        <span class="red">15  19  23  28  29  33</span>
                        <span class="blue">04</span>
                    </li>
                </ul>
                <ul>
                    <li class="first">040期</li>
                    <li>
                        <span class="red">15  19  23  28  29  33</span>
                        <span class="blue">04</span>
                    </li>
                </ul>
                <ul>
                    <li class="first">040期</li>
                    <li>
                        <span class="red">15  19  23  28  29  33</span>
                        <span class="blue">04</span>
                    </li>
                </ul>
            </div>
        </article>

        <article id="GameBallsContanior">
            <!--普通投注start-->
            <div id="cpttz" class="relative">
                <div class="shakeomit">
                    <span id="shake" class="left fl red"><em class="shakeico"></em><cite>摇一注</cite> </span>
                    <span id="yl" class="left fl"><em class="ylico"></em><cite>遗漏</cite> </span>
                </div>
                <p class="gray">
                    至少选择 <em class="red">6个红球</em> ， <em class="blue">1个蓝球</em>
                </p>
                <p id="ylz" class="gray" style="display: none">遗漏值：该号码自上次开出到本期间隔期数</p>
                <div id="pt_buyChoice">
                    <!--红球-->
                    <div class="relative pdLeft08" id="xzhq" style="z-index: 5">
                        <div class="ssqBall">
                            <cite class="">01</cite>
                            <cite>02</cite>
                            <cite>03</cite>
                            <cite>04</cite>
                            <cite>05</cite>
                            <cite>06</cite>
                            <cite>07</cite>
                            <cite>08</cite>
                            <cite>09</cite>
                            <cite>10</cite>
                            <cite>11</cite>
                            <cite>12</cite>
                            <cite>13</cite>
                            <cite>14</cite>
                            <cite>15</cite>
                            <cite>16</cite>
                            <cite>17</cite>
                            <cite>18</cite>
                            <cite>19</cite>
                            <cite>20</cite>
                            <cite>21</cite>
                            <cite>22</cite>
                            <cite>23</cite>
                            <cite>24</cite>
                            <cite>25</cite>
                            <cite>26</cite>
                            <cite>27</cite>
                            <cite>28</cite>
                            <cite>29</cite>
                            <cite>30</cite>
                            <cite>31</cite>
                            <cite>32</cite>
                            <cite>33</cite>
                        </div>
                        <div class="omitnum" style="display: none">
                            <cite>0</cite>
                            <cite>2</cite>
                            <cite>15</cite>
                            <cite>34</cite>
                            <cite>5</cite>
                            <cite>0</cite>
                            <cite>3</cite>
                            <cite>12</cite>
                            <cite>1</cite>
                            <cite>6</cite>
                            <cite>0</cite>
                            <cite>3</cite>
                            <cite>2</cite>
                            <cite>7</cite>
                            <cite>5</cite>
                            <cite>1</cite>
                            <cite>0</cite>
                            <cite>5</cite>
                            <cite>7</cite>
                            <cite>1</cite>
                            <cite>11</cite>
                            <cite>2</cite>
                            <cite>3</cite>
                            <cite>11</cite>
                            <cite>6</cite>
                            <cite>4</cite>
                            <cite>16</cite>
                            <cite>0</cite>
                            <cite>1</cite>
                            <cite>2</cite>
                            <cite>10</cite>
                            <cite>8</cite>
                            <cite>0</cite>
                        </div>
                    </div>
                    <!--篮球-->
                    <div class="ssqxhblue relative pdLeft08" id="xzlq" style="z-index: 5">
                        <div class="ssqBall ssqblueBall">
                            <cite class="">01</cite>
                            <cite>02</cite>
                            <cite>03</cite>
                            <cite>04</cite>
                            <cite>05</cite>
                            <cite>06</cite>
                            <cite>07</cite>
                            <cite>08</cite>
                            <cite>09</cite>
                            <cite>10</cite>
                            <cite>11</cite>
                            <cite>12</cite>
                            <cite>13</cite>
                            <cite>14</cite>
                            <cite>15</cite>
                            <cite>16</cite>
                        </div>
                        <div class="omitnum" style="display: none">
                            <cite>29</cite>
                            <cite>12</cite>
                            <cite>5</cite>
                            <cite>3</cite>
                            <cite>0</cite>
                            <cite>13</cite>
                            <cite>10</cite>
                            <cite>27</cite>
                            <cite>2</cite>
                            <cite>9</cite>
                            <cite>1</cite>
                            <cite>40</cite>
                            <cite>19</cite>
                            <cite>24</cite>
                            <cite>17</cite>
                            <cite>7</cite>
                        </div>
                    </div>
                </div>
            </div>
            <!--普通投注end-->

            <input type="hidden" id="BlueBallValue" value=""/>
            <input type="hidden" id="RedBallValue" value=""/>
            <input id="dRedBallValue" type="hidden" name="dRedBallValue" value=""/>
            <input id="tRedBallValue" type="hidden" name="tRedBallValue" value=""/>
            <input id="dtBlueBallValue" type="hidden" name="dtBlueBallValue" value=""/>
        </article>

        <footer class="buyFooter">
            <div class="fixed buyFloat">
                <em class="ssqdeleted">清空</em>
                <span class="gray">共
                    <cite id="countNotes" class="red">0</cite>&nbsp;注
                    <cite id="countMoney" class="red">0</cite>&nbsp;元
                </span>
                <a class="ture" href="javascript:;">确认</a>
            </div>
        </footer>
        <script type="text/javascript">
            var gameCode = "SSQ", gameName = "双色球";
        </script>
        <script src="/scripts/bet.js" type="text/javascript"></script>
        <script src="/scripts/utils.js" type="text/javascript"></script>
    </div>
</div>
<div class="hide">

</div>
</body>
</html>
