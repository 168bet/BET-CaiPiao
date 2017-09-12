<!DOCTYPE html>
<html>
<head>
    <title>帐户余额 - 个人中心</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/member.css" rel="stylesheet" type="text/css"/>
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
        <script src="/scripts/member.js" type="text/javascript"></script>

        <div>
            <!DOCTYPE html>
            <html>
            <head>
                <title>我的返点</title>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                <meta charset="utf-8"/>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
                <meta content="yes" name="apple-mobile-web-app-capable">
                <meta content="black" name="apple-mobile-web-app-status-bar-style">
                <meta content="telephone=no" name="format-detection">
                <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
                <link href="/css/common.css" rel="stylesheet" type="text/css"/>
                <link href="/css/member.css" rel="stylesheet" type="text/css"/>
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
                    <script src="/scripts/member.js" type="text/javascript"></script>


                    <header class="tzHeader">
                        <section class="fcHeader">
                            <a href="javascript:history.go(-1)" class="back">&lt;</a>
                            <h1 id="wanfa_">购彩明细</h1>
                            <div style="display: none;" class="tzPull">
                                <a href="accountincome" class="cur" id="gcmx">购彩明细</a>
                                <a href="winningrecord" id="zjmx">中奖明细</a>
                                <a href="freezerecord" id="djmx">冻结明细</a>
                                <a href="drawingsrecord" id="tkmx">提款明细</a>
                                <a href="rechargerecord" id="czmx">充值明细</a>
                            </div>
                        </section>
                    </header>
                    <script type="text/javascript">
                        $("#wanfa_").Touch(function () {
                            $(this).toggleClass("hmTit");
                            $(this).next().toggle()
                        });
                    </script>

                </div>
            </div>

            <div class="divColor">
                <table class="list">
                    <tr>
                        <th>
                            序号
                        </th>
                        <th>
                            彩种
                        </th>
                        <th>
                            交易时间
                        </th>
                        <th>
                            订单金额
                        </th>
                        <th>
                            交易详情
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <link href="/css/mycenter.css" rel="stylesheet" type="text/css"/>
                            <div class="pager4">
                                <em style="color: #999999;">暂无数据</em>
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $("#wanfa_").html("购彩明细");
            $(".tzPull a").removeClass("cur");
            $("#gcmx").addClass("cur");
        </script>

    </div>
</div>
<div class="hide">

</div>
</body>
</html>
