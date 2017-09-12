<!DOCTYPE html>
<html>
<head>
    <title>竞彩胜平负 - 支付 - 体育彩票 | 福利彩票 | 中国体育彩票 - 趣彩网(触屏版)</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/pay.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinePhone.js" type="text/javascript"></script>
    <script type="text/javascript">
        var gamename = "竞彩胜平负", gameCode = "JCZQ", gametype = "BRQSPF";
    </script>
    <script src="/scripts/zcpay.js" type="text/javascript"></script>

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
        <article class="gray">
            <header class="tzHeader">
                <section class="buyHeader">
                    <h1>支付</h1>
                    <a href="javascript:history.go(-1)" class="backIco2"></a>
                </section>
            </header>
            <div class="pdLfrt09">
                <div class="zfText">
                    <div class="" id="slideLoop">
                        <p><cite>竞彩胜平负</cite>&nbsp;&nbsp;<cite></cite><em class="fr downArrow"></em></p>
                        <p>应付金额&nbsp;&nbsp;<cite class="yellow">0</cite>&nbsp;&nbsp;元</p>
                    </div>
                    <div id="updownContent" style="display:none">
                        <p><cite>0注0倍</cite></p>
                        <div class="clearfix">
                            <i class="left w4">过关方式</i>
                            <div class="left zfNum w11 yellow" id="mp_content">&nbsp;</div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="pdLfrt104">
                <div class="zfMoney">
                    <span id="rgspn">使用红包金额：<input type="text" onkeyup="checkRb(this)" onafterpaste="checkRb(this)"
                                                   class="balancepwd" id="kybanlance" style="width:50px">&nbsp;&nbsp;(红包&nbsp;<cite
                                class="yellow" id="ttbanlance">10.00</cite>&nbsp;元，最大可使用红包&nbsp;<cite class="yellow"
                                                                                                      id="maxbanlance"
                                                                                                      data-ratio="0.20">0</cite>&nbsp;元)</span>
                </div>
                <p>账号余额 <cite class="blue" id="yue">10.00</cite> 元</p>
                <input type="hidden" id="hideyue" value="10.0000"/>
                <p class="pdTop03" style="display:none;">差&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额 <cite
                            id="chae">0</cite> 元</p>
                <a href="javascript:;" style="" id="pay" class="payment">支&nbsp;&nbsp;付</a>
                <a href="/member/recharge" style="display:none;" id="cz" class="payment">去充值</a>
            </div>
            <footer class="buyFooter">
                <div class="buyFloat fixed tellNum"><a href="tel:400-1155658"><em class="tell"></em>客服电话：400-1155658</a>
                </div>
            </footer>
            <input id="codes" type="hidden" value="">
        </article>

        <script type="text/javascript">
            function checkRb(obj) {
                var ttbanlance = $("#ttbanlance");
                var maxbanlance = $("#maxbanlance").html();
                var kybanlance = obj.value;
                obj.value = kybanlance.replace(/[^\d.]/g, '');
                kybanlance = obj.value;
                if (parseFloat(kybanlance) > parseFloat(maxbanlance)) {
                    obj.value = maxbanlance;
                }
                if (parseFloat(obj.value) > parseFloat(ttbanlance.text())) {
                    obj.value = ttbanlance.text();
                }
            }
        </script>
    </div>
</div>
</body>
</html>
