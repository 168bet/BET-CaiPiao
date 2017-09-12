<!DOCTYPE html>
<html>
<head>
    <title>竞彩足球 - 投注列表 - 体育彩票 | 福利彩票 | 中国体育彩票 - 趣彩网(触屏版)</title>
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
    <link href="/css/jczq.css" rel="stylesheet" type="text/css"/>
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
            <article id="content_home" style="display: block;">
                <style>
                    .ww_ {
                        border-left: 1px solid #d5d5d5;
                        margin: 0 4%;
                        width: 92%;
                        background: #fff
                    }

                    .ww_ span {
                        float: left;
                        position: relative;
                        font-size: 0.95rem;
                        line-height: 2.6rem;
                        width: 32.96%;
                        text-align: center;
                        border-right: 1px solid #d5d5d5;
                        border-bottom: 1px solid #d5d5d5
                    }

                    .ww_ span.cur {
                        color: #f6851f
                    }

                    .ww_ span.cur:before {
                        content: "";
                        position: absolute;
                        left: -1px;
                        top: -1px;
                        width: 100%;
                        height: 2.6rem;
                        border: 1px solid #f6851f
                    }

                    .ww_ span.cur:after {
                        content: "";
                        position: absolute;
                        bottom: -1px;
                        right: -1px;
                        width: 1.4rem;
                        height: 1.4rem;
                        background: url('http://res.qcwddd.com/iqucai.touch/images//buy/hmCur.png') no-repeat center;
                        background-size: 1.4rem 1.4rem;
                        -webkit-background-size: 1.4rem 1.4rem;
                        -moz-background-size: 1.4rem 1.4rem
                    }
                </style>
                <div class="zhezhao" style="display:none;"></div>
                <section id="chuan_"
                         style="display:none;position: fixed; z-index: 1000; left:50%; top:50%;margin-left:-9.25rem;"
                         class="zfPop chuan_">
                    <h4>自由过关</h4>
                    <div class="ww_">
                        <!-- -->
                        <span v="2_1" class="cur" style="border-top:1px solid #d5d5d5;">2串1</span>
                        <span v="3_1" style="border-top:1px solid #d5d5d5;">3串1</span>
                        <span v="4_1" style="border-top:1px solid #d5d5d5;">4串1</span>
                        <span v="5_1">5串1</span>
                        <span v="6_1">6串1</span>
                        <span v="7_1">7串1</span>
                        <span v="8_1">8串1</span>

                        <div class="clear"></div>
                    </div>
                    <a class="tureBtn" href="javascript:;">确定</a>
                </section>
                <form id="optimize" method="post" action="/buy/optimize" target="_blank">
                    <input id="op_multiple" type="hidden" name="optimizeForm.multiple" value="0">
                    <input id="op_period" type="hidden" name="optimizeForm.periodId" value="">
                    <input id="op_units" type="hidden" name="optimizeForm.units" value="0">
                    <input id="op_schemecost" type="hidden" name="optimizeForm.schemeCost" value="0">
                    <input id="op_pass" type="hidden" name="optimizeForm.passContent" value="">
                    <input id="op_items" type="hidden" name="optimizeForm.itemsContent" value="0">
                    <input id="op_playtype" type="hidden" name="playType" value="HT">
                </form>

                <div id="Mask_chuan"
                     style="display:none;position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>
                <article>
                    <header class="tzHeader">
                        <section class="buyHeader">
                            <a href="javascript:history.go(-1)" class="back">&lt;</a>
                            <h1>竞彩足球-投注</h1>
                        </section>
                    </header>
                    <div class="pdLfrt09 ">
                        <div class="clearfix">
                            <input id="tjss" name="" value="+ 添加赛事" class="handBtn left" type="button">
                            <span class="handBtn relative clearBtn right" id="clearTab">清除列表</span>
                        </div>
                        <ul class="spfNum  " id="content">

                        </ul>
                        <p class="pact clearfix"><em class="left check"></em>我已阅读并同意《委托投注规则》</p>
                    </div>
                    <footer class="buyFooter">
                        <div class="fixed">
                            <p class="spfjj">若中奖，理论奖金 <em id="rangeMoney" class="yellow">0</em>元</p>
                            <div class="double clearfix">

                                <input v="2" id="selectPlay" value="2串1" readonly="readonly" class="left spfinput"
                                       type="text">
                                <span class="right">投<input id="bs_" name="bs" value="1" type="tel">倍</span>
                            </div>
                            <div class="buyFloat">
                                <input id="fqhm" class="fqhm" value="发起合买" type="button">
                                <p id="count_">共<cite class="yellow">0</cite>注<cite class="yellow"
                                                                                    id="CTZQ_Money">0</cite>元</p>
                                <a href="javascript:;" class="ture" id="payment">投 注</a>
                            </div>
                        </div>
                    </footer>
                </article>
                <input id="PlayID" value="72" type="hidden">
            </article>
        </section>
        <script type="text/javascript">
            var type = "BRQSPF", gameCode = "JCZQ";
        </script>
        <script src="/scripts/ture.js" type="text/javascript"></script>
    </div>
</div>

</body>
</html>
