<!DOCTYPE html>
<html>
<head>
    <title>发起合买 </title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinephone.js" type="text/javascript"></script>
</head>
<body>
<div id="tx_c" class="logints" style="display:none;"></div>
<div class="zhezhao" style=" display:block"></div>
<section id="dConfirm" class="zfPop weige_" style="display: block">
    <h4>提示</h4>
    <div class="clearfix pdLeft08 center">
        <p>投注金额：<span class="red">2</span></p>
        <p>账户余额：<span class="red">0</span></p>
    </div>
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
        <link href="/css/pay.css" rel="stylesheet" type="text/css"/>
        <section>
            <article id="content_home" style="display: block;">
                <header class="tzHeader">
                    <section class="buyHeader">
                        <a href="javascript:history.go(-1)" class="back">&lt;</a>
                        <h1>竞彩足球-发起合买</h1>
                    </section>
                </header>
                <div class="pdLeft04">
                    <p class="pdTop03 pdLeft06" id="detail">本方案共<cite class="red">0</cite>注<cite
                                class="red">0</cite>倍，总金额<cite class="red">0</cite>元</p>
                    <div class="s2">
                        <i>认购</i>
                        <span>
                            <input onkeyup="this.value=this.value.replace(/\D/g,'')" id="rg" class="hmInput" value="1"
                                   type="tel">
                            元（<cite class="red" id="rg_bl">0%</cite>）
                        </span>
                    </div>
                    <div class="s2">
                        <i>保底</i>
                        <span>
                            <input onkeyup="this.value=this.value.replace(/\D/g,'')" id="bd" class="hmInput" value="0"
                                   type="tel">
                            元（<cite class="red" id="bd_bl">0%</cite>）
                            <input type="checkbox" id="chk">
                            <em class="gray">全额保底</em>
        </span></div>
                    <div class="s2">
                        <i class="tcheight">中奖提成</i>
                        <ul class="left scale" id="ratio">
                            <li v="0" class="cur">0%</li>
                            <li v="1">1%</li>
                            <li v="2">2%</li>
                            <li v="3">3%</li>
                            <li v="4">4%</li>
                            <li v="5">5%</li>
                            <li v="6">6%</li>
                            <li v="7">7%</li>
                            <li v="8">8%</li>
                            <li v="9">9%</li>
                            <li v="10">10%</li>
                        </ul>
                    </div>
                    <div class="s2">
                        <i class="gkheight">是否公开</i>
                        <ul class="left scale" id="isPublic">
                            <li v="1" class="cur">公开</li>
                            <li v="2" class="along">跟单公开</li>
                            <li v="3">截止公开</li>
                            <li v="4" class="along">永久保密</li>
                        </ul>
                    </div>
                    <div class="s2">
                        <i class="">方案标题</i>
                        <span> <input type="text" id="title" placeholder="一起玩" class="hmInput" size="20"/></span>
                    </div>
                    <div class="s2">
                        <i class="faheight">方案宣言</i>
                        <textarea id="desc" class="xyText" placeholder="一起玩，一起中大奖"></textarea>
                    </div>
                </div>
                <footer class="buyFooter">
                    <div class="buyFloat fixed">
                        <span id="my_">认购<cite>0</cite>元 保底<cite>0</cite>元 共<cite class="red">0</cite>元</span>
                        <a href="javascript:;" class="ture">提 交</a>
                    </div>
                </footer>
            </article>
        </section>
        <script type="text/javascript">
            var gameCode = "JCZQ";
        </script>
        <script src="/scripts/user.js" type="text/javascript"></script>

        <script src="/scripts/fqhm.js" type="text/javascript"></script>


    </div>
</div>
<div class="hide">

</div>
<script>
    $('#zfqd').click(function () {
        $('.zhezhao').hide();
        $('#dConfirm').hide();
    })
    $('a.ture').click(function () {
        $('.zhezhao').show();
        $('#dConfirm').show();
    })
</script>
</body>
</html>
