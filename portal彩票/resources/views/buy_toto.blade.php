<!DOCTYPE html>
<html>
<head>
    <title>福彩3D - 订单投注 </title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
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
<div style="position: relative;" id="outer">
    <div class="wrap">
        <style>
            body {
                background-color: #fff;
            }
        </style>
        <header class="tzHeader">
            <section class="fcHeader">
                <a href="javascript:history.go(-1)" class="back">&lt;</a>
                <h1>福彩<b>3D</b></h1>
                <!--<div style="position: absolute; right: 2.1rem; top: 0.6rem; font-size: 0.85rem; line-height: 29px; height: 29px;">
                    <span style="height: 29px; line-height: 29px; display: block; float: left; color: red;">加奖50%</span>
                </div>-->
                <div class="pullDown">
                    <em id="pullIco" class="fcpullIco"></em>
                    <div id="pullText" class="pullText" style="display:none">

                        <a href="/hemai.html">合买跟单</a>
                        <a href="/statichtml/lottery/index.html">开奖结果</a>
                    </div>
                </div>
            </section>
        </header>
        <nav id="fc3d_tab" class="sdTab fc3dTab relative">
            <ul class="clearfix">
                <li class="cur" val="FS" v="zx">直选</li>
                <li val="ZX3DS" v="zs">组三</li>
                <li val="HZ" v="hz">直选和值</li>
                <li val="ZSBH" v="zsbh">组三包号</li>
                <li val="ZLBH" v="zlbh">组六包号</li>
            </ul>
            <em class="downline" style="width:22%; left:5%"></em>
        </nav>
        <section>
            <article>
                <div class="p5kj clearfix">
                    <div hidden="" class="fl" style="display: block;">
                        第<em id="c_expect">2017292</em>期
                        <em id="c_date">2017-03-19</em>
                        <time class="red">21:30（周六）</time>
                        截止
                    </div>
                    <div class="fr">
				<span class="left fl">
					开奖历史 
				</span>
                        <em class="p5kjup p5kjdown"></em>
                    </div>
                </div>
                <div id="kj_code" style="display: none;">
                    <ul class="k3listtt">
                        <li class="wb20">期号</li>
                        <li class="wb17">开奖结果</li>
                        <li class="wb21">形态</li>
                    </ul>
                    <div class="fc3dkjlist k3kjlist">
                        <ul>
                            <li class="wb20">092期</li>
                            <li class="wb16 red">3 0 5</li>
                            <li class="wb21">组六</li>
                        </ul>
                        <ul>
                            <li class="wb20">092期</li>
                            <li class="wb16 red">3 0 5</li>
                            <li class="wb21">组六</li>
                        </ul>
                        <ul>
                            <li class="wb20">092期</li>
                            <li class="wb16 red">3 0 5</li>
                            <li class="wb21">组六</li>
                        </ul>
                        <ul>
                            <li class="wb20">092期</li>
                            <li class="wb16 red">3 0 5</li>
                            <li class="wb21">组六</li>
                        </ul>
                    </div>
                </div>
            </article>
            <article class="p5xhlist">
                <div class="relative k3xh sdxh" id="bonus_details">
                    <div>分别猜中百位、十位、个位，奖金<em class="red">1040</em>元</div>
                    <div style="display: none;">
                        <p>选择同号与不同号的组合，奖金<em class="red">346</em>元</p>
                        <p>例:选号22,3,若开奖号码223或232或322,即中奖</p>
                    </div>
                    <div style="display: none;">猜中开奖号码之和,奖金<em class="red">1040</em>元</div>
                    <div style="display: none;">
                        <p>选2个号，猜中组3号码，奖金<em class="red">346</em>元</p>
                        <p>组三:3个号码中有2个相同,如232</p>
                    </div>
                    <div style="display: none;">
                        <p>选3个号，猜中后3位组六号码，奖金<em class="red">173</em>元</p>
                        <p>组六:3个号码各不相同,如234</p>
                    </div>
                    <div class="shakeOmit" id="shake">
                        <em class="shakeico"></em>
                        <cite class="red" style="padding:.75rem 0 0 .05rem;display:inline-block">摇一注</cite>
                    </div>
                </div>
                <div style="overflow: hidden; ">
                    <div id="content" style=" width:10000px; position: relative; left: 0;">
                        <!-- 直选start -->
                        <div class="jxsscxhlist sdlist" id="zx" style="float: left; ">
                            <ul class="clearfix hide">
                                <li class="cur" v="百位" m="y"><span>百位</span></li>
                                <li class="cur" v="十位" m="y"><span>十位</span></li>
                                <li class="cur" v="个位" m="y"><span>个位</span></li>
                            </ul>
                            <div class="jxsscxhBall mgTop03 jxsscline clearfix">
                                <span>百位</span>
                                <p><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b></p>
                            </div>
                            <div class="jxsscxhBall mgTop03 jxsscline clearfix">
                                <span>十位</span>
                                <p><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b></p>
                            </div>
                            <div class="jxsscxhBall mgTop03 clearfix">
                                <span>个位</span>
                                <p><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b></p>
                            </div>
                        </div>
                        <!-- 直选end -->
                        <!-- 组三start -->
                        <div class="jxsscxhlist" id="zs" style="float: left;">
                            <div class="jxsscxhBall mgTop03 jxsscline clearfix">
                                <span>同号</span>
                                <p><b>00</b><b>11</b><b>22</b><b>33</b><b>44</b><b>55</b><b>66</b><b>77</b><b>88</b><b>99</b>
                                </p>
                            </div>
                            <div class="jxsscxhBall mgTop03 clearfix">
                                <span>不同号</span>
                                <p><b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b></p>
                            </div>
                        </div>
                        <!-- 组三end -->
                        <!-- 和值start -->
                        <div id="hz" style="float: left; ">
                            <div class="jxsscxhBall jxsscxhBall2 clearfix">
                                <b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><b>10</b><b>11</b><b>12</b><b>13</b><b>14</b><b>15</b><b>16</b><b>17</b><b>18</b><b>19</b><b>20</b><b>21</b><b>22</b><b>23</b><b>24</b><b>25</b><b>26</b><b>27</b>
                            </div>
                        </div>
                        <!-- 和值end -->
                        <!-- 组三包号start -->
                        <div id="zsbh" style="float: left; ">
                            <div class="jxsscxhBall jxsscxhBall2 clearfix">
                                <b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b>
                            </div>
                        </div>
                        <!-- 组三包号end -->
                        <!-- 组6包号start -->
                        <div id="zlbh" style="float: left; ">
                            <div class="jxsscxhBall jxsscxhBall2 clearfix">
                                <b>0</b><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b>
                            </div>
                        </div>
                        <!-- 组6包号end -->
                    </div>
                </div>
            </article>
        </section>

        <footer class="buyFooter">
            <div class="fixed buyFloat">
                <em class="fc3ddeleted" id="deleted">机选</em>
                <span class="gray">共
                    <cite id="countNotes">0</cite>注
                    <cite id="countMoney">0</cite>元
                </span>
                <a id="pay_" class="ture" href="javascript:;">确认</a>
            </div>
        </footer>
        <script type="text/javascript">
            var gameCode = "FC3D", gameName = "福彩3D";
        </script>
        <script src="/scripts/bet.js" type="text/javascript"></script>
        <script src="/scripts/utils.js" type="text/javascript"></script>
    </div>
</div>
<div class="hide">

</div>
</body>
</html>
