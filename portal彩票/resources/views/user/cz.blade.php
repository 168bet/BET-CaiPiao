<!DOCTYPE html>
<html>
<head>
    <title>账户充值 - 个人中心</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/index.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/user.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/member.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/css/flexslider.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinePhone.js" type="text/javascript"></script>
    <script src="/scripts/noreferrer.yui.js" type="text/javascript"></script>
    <script src="/scripts/jquery.flexslider-min.js" type="text/javascript"></script>
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


        <header class="moreHeader list">
            <a class="backIco2 moreico" href="javascript:history.go(-1)"></a>
            <h1>充值</h1>
        </header>
        <div class="float_left  list">
            <input type="hidden" id="hd_ips_jump_url" value="http://pay2.shaotou.net"/>
            <input type="hidden" id="hd_zf_jump_url" value="http://pay2.xsahedejs.cn"/>
            <input type="hidden" id="hd_hc_jump_url" value="http://pay1.denei.top"/>
            <input type="hidden" id="hd_hc_nocard_jump_url" value="http://pay3.denei.top"/>
            <input type="hidden" id="hd_ys_jump_url" value="http://pay4.yongyecn.com"/>
            <input type="hidden" id="hd_yf_jump_url" value="http://pay2.yongyecn.com"/>
            <input type="hidden" id="hd_zt_jump_url" value="http://pay4.yongyecn.com"/>
            <input type="hidden" id="hd_ka101_jump_url" value="http://pay1.denei.top"/>
            <div class="recharge_import divColor">
                <span class="reminder" style="min-width: 5rem;">充值金额</span>

                <form id="frm_alipay" method="post" target="_blank" action="http://pay4.yongyecn.com/user/redirectpay"
                      accept-charset="gbk">
                    <input type="hidden" name="optEmail" value="pay@qucai.com"/>
                    <input type="hidden" name="title" value="admin123465"/>
                    <input type="hidden" id="txt_domain" name="fromDomain" value="http://paytz.qcw.com"/>
                    <input type="hidden" id="txt_userId" name="userId" value="627593"/>
                    <input type="hidden" name="memo" value="请勿修改付款说明里的内容,否则将无法自动完成充值"/>
                    <input type="hidden" value="50000" id="hd_maxFillMoney"/>
        <span style="margin-top: 0.4rem; display: inline-block; margin-right: 2rem; float: right;">
            元</span>
                    <input class="input_width" id="recharge" name="payAmount" placeholder="请输入充值金额" type="tel"
                           value="100" style="color: Red; width: 40%;">
                    <input type="hidden" name="HdpayType" id="HdpayType"/>
                </form>
            </div>
            <div class="recharge_div divColor">
                <div id="slf_bank" class="recharge_way_off float_left" data-p="slf_bank_p" gateway="ztbank"
                     data-v="slf_bank|0">
                    网银
                </div>
                <div id="zhifubao_" class="recharge_way_off float_left" data-p="zhifubao_p" gateway="alipay"
                     data-v="alipay|alipay">
                    支付宝
                </div>
                <div id="slf_alipay" class="recharge_way_off float_left" data-p="slf_alipay_p" gateway="hwalipay"
                     data-v="slf_alipay|Alipay">
                    支付宝
                </div>
                <div id="slf_weixin" class="recharge_way_off float_left" data-p="slf_weixin_p" gateway="hwalipay"
                     data-v="slf_weixin|weixin">
                    微信
                </div>
            </div>
            <div id="chuxu_hc_p" style="display: none; height: 4.5rem;">
                <ul class="pay_list" style="width: 92%; padding-top: 10px">
                    <li><span title="中国工商银行">
                <label class="icon-box" for="bank_type6" value="hc_bank|ICBC">
                    <span class="bank-icon icbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国建设银行">
                <label class="icon-box" for="bank_type7" value="hc_bank|CCB">
                    <span class="bank-icon ccb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="广东发展银行">
                <label class="icon-box" for="bank_type8" value="hc_bank|GDB">
                    <span class="bank-icon gdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国农业银行">
                <label class="icon-box" for="bank_type8" value="hc_bank|ABC">
                    <span class="bank-icon abc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="招商银行">
                <label class="icon-box" for="bank_type5" value="hc_bank|CMB">
                    <span class="bank-icon cmb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="交通银行">
                <label class="icon-box" for="bank_type9" value="hc_bank|BOCOM">
                    <span class="bank-icon comm"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国银行(大额)">
                <label class="icon-box" for="bank_type11" value="hc_bank|BOC">
                    <span class="bank-icon boc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18" value="hc_bank|SPDB">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国光大银行">
                <label class="icon-box" for="bank_type17" value="hc_bank|CEB">
                    <span class="bank-icon cebb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国邮政储蓄银行">
                <label class="icon-box" for="bank_type22" value="hc_bank|PSBC">
                    <span class="bank-icon psbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中信银行">
                <label for="bank_type10" class="icon-box" value="hc_bank|CNCB">
                    <span class="bank-icon citic"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国民生银行">
                <label class="icon-box" for="bank_type12" value="hc_bank|CMBC">
                    <span class="bank-icon cmbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="平安银行">
                <label class="icon-box" for="bank_type19" value="hc_bank|PAB">
                    <span class="bank-icon spab"><i></i></span>
                </label>
            </span></li>
                    <li><span title="兴业银行">
                <label class="icon-box" for="bank_type16" value="hc_bank|CIB">
                    <span class="bank-icon cib"><i></i></span>
                </label>
            </span></li>
                    <li><span title="华夏银行">
                <label for="bbpay_bank_type30" class="icon-box" value="hc_bank|HXB">
                    <span class="bank-icon hxyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京银行">
                <label for="bank_type20" class="icon-box" value="hc_bank|BCCB">
                    <span class="bank-icon bjb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海银行">
                <label for="bank_type29" class="icon-box" value="hc_bank|BOS">
                    <span class="bank-icon shanghyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海农商银行">
                <label for="bank_type29" class="icon-box" value="hc_bank|SRCB">
                    <span class="bank-icon shanghainsyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="其它">
                <label for="bank_type29" class="icon-box" value="hc_bank|UNIONPAY">
                    <span class="bank-icon bank-hc-more"><i></i></span>
                </label>
            </span></li>
                </ul>
                <div style="clear: both;">
                </div>
            </div>
            <div id="chuxu_zf_p" style="display: none; height: 4.5rem;">
                <ul class="pay_list" style="width: 92%; padding-top: 10px">
                    <li><span title="中国工商银行">
                <label class="icon-box" for="bank_type6" value="zf_bank|ICBC">
                    <span class="bank-icon icbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国建设银行">
                <label class="icon-box" for="bank_type7" value="zf_bank|CCB">
                    <span class="bank-icon ccb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国农业银行">
                <label class="icon-box" for="bank_type8" value="zf_bank|ABC">
                    <span class="bank-icon abc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="招商银行">
                <label class="icon-box" for="bank_type5" value="zf_bank|CMB">
                    <span class="bank-icon cmb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="交通银行">
                <label class="icon-box" for="bank_type9" value="zf_bank|BCOM">
                    <span class="bank-icon comm"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国银行">
                <label class="icon-box" for="bank_type11" value="zf_bank|BOC">
                    <span class="bank-icon boc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18" value="zf_bank|SPDB">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国光大银行">
                <label class="icon-box" for="bank_type17" value="zf_bank|CEBB">
                    <span class="bank-icon cebb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国邮政储蓄银行">
                <label class="icon-box" for="bank_type22" value="zf_bank|PSBC">
                    <span class="bank-icon psbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中信银行">
                <label for="bank_type10" class="icon-box" value="zf_bank|ECITIC">
                    <span class="bank-icon citic"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国民生银行">
                <label class="icon-box" for="bank_type12" value="zf_bank|CMBC">
                    <span class="bank-icon cmbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="平安银行">
                <label class="icon-box" for="bank_type19" value="zf_bank|SPABANK">
                    <span class="bank-icon spab"><i></i></span>
                </label>
            </span></li>
                    <li><span title="兴业银行">
                <label class="icon-box" for="bank_type16" value="zf_bank|CIB">
                    <span class="bank-icon cib"><i></i></span>
                </label>
            </span></li>
                    <li><span title="华夏银行">
                <label for="bbpay_bank_type30" class="icon-box" value="zf_bank|HXB">
                    <span class="bank-icon hxyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京银行">
                <label for="bank_type20" class="icon-box" value="zf_bank|BOB">
                    <span class="bank-icon bjb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="宁波银行">
                <label for="bank_type27" class="icon-box" value="zf_bank|NBB">
                    <span class="bank-icon ningbyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海银行">
                <label for="bank_type29" class="icon-box" value="zf_bank|SHB">
                    <span class="bank-icon shanghyh"><i></i></span>
                </label>
            </span></li>
                </ul>
                <div style="clear: both;">
                </div>
            </div>
            <div id="chuxu_p" style="display: none; height: 4.5rem;">
                <ul class="pay_list" style="width: 92%; padding-top: 10px">
                    <li><span title="中国工商银行">
                <label class="icon-box" for="bank_type6" value="ips_bank|00004">
                    <span class="bank-icon icbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国建设银行">
                <label class="icon-box" for="bank_type7" value="ips_bank|00003">
                    <span class="bank-icon ccb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国农业银行">
                <label class="icon-box" for="bank_type8" value="ips_bank|00017">
                    <span class="bank-icon abc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="招商银行">
                <label class="icon-box" for="bank_type5" value="ips_bank|00021">
                    <span class="bank-icon cmb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="交通银行">
                <label class="icon-box" for="bank_type9" value="ips_bank|00005">
                    <span class="bank-icon comm"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国银行">
                <label class="icon-box" for="bank_type11" value="ips_bank|00083">
                    <span class="bank-icon boc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18" value="ips_bank|00032">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国光大银行">
                <label class="icon-box" for="bank_type17" value="ips_bank|00057">
                    <span class="bank-icon cebb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="广东发展银行">
                <label class="icon-box" for="bank_type13" value="ips_bank|00052">
                    <span class="bank-icon gdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国邮政储蓄银行">
                <label class="icon-box" for="bank_type22" value="ips_bank|00051">
                    <span class="bank-icon psbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中信银行">
                <label for="bank_type10" class="icon-box" value="ips_bank|00054">
                    <span class="bank-icon citic"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国民生银行">
                <label class="icon-box" for="bank_type12" value="ips_bank|00013">
                    <span class="bank-icon cmbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="平安银行">
                <label class="icon-box" for="bank_type19" value="ips_bank|00006">
                    <span class="bank-icon spab"><i></i></span>
                </label>
            </span></li>
                    <li><span title="兴业银行">
                <label class="icon-box" for="bank_type16" value="ips_bank|00016">
                    <span class="bank-icon cib"><i></i></span>
                </label>
            </span></li>
                    <li><span title="深圳发展银行">
                <label for="kuaiqian_bank_type15" class="icon-box" value="ips_bank|00023">
                    <span class="bank-icon sdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="华夏银行">
                <label for="bbpay_bank_type30" class="icon-box" value="ips_bank|00041">
                    <span class="bank-icon hxyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京银行">
                <label for="bank_type20" class="icon-box" value="ips_bank|00050">
                    <span class="bank-icon bjb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京农村商业银行">
                <label for="bank_type21" class="icon-box" value="ips_bank|00056">
                    <span class="bank-icon bjncsyyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="渤海银行">
                <label for="bank_type23" class="icon-box" value="ips_bank|00095">
                    <span class="bank-icon bohyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="东亚银行">
                <label for="bank_type24" class="icon-box" value="ips_bank|00096" style="background-color: white;">
                    <span class="bank-icon1 dyyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="杭州银行">
                <label for="bank_type25" class="icon-box" value="ips_bank|00081">
                    <span class="bank-icon hangzyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="南京银行">
                <label for="bank_type26" class="icon-box" value="ips_bank|00055">
                    <span class="bank-icon nanjyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="宁波银行">
                <label for="bank_type27" class="icon-box" value="ips_bank|00085">
                    <span class="bank-icon ningbyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海银行">
                <label for="bank_type29" class="icon-box" value="ips_bank|00084">
                    <span class="bank-icon shanghyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="浙江泰隆商业银行">
                <label for="bank_type30" class="icon-box" value="ips_bank|00209" style="background-color: white;">
                    <span class="bank-icon2 zjltsyyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="浙商银行">
                <label for="bank_type31" class="icon-box" value="ips_bank|00086">
                    <span class="bank-icon zjsyyh"><i></i></span>
                </label>
            </span></li>
                </ul>
                <div style="clear: both;">
                </div>
            </div>

            <div id="chuxu_zt_p" style="display: none; height: 4.5rem;">
                <ul class="pay_list" style="width: 92%; padding-top: 10px">
                    <li><span title="中国工商银行">
                <label class="icon-box" for="bank_type6_zt" value="zt_bank|10018">
                    <span class="bank-icon icbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国建设银行">
                <label class="icon-box" for="bank_type7_zt" value="zt_bank|10020">
                    <span class="bank-icon ccb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国农业银行">
                <label class="icon-box" for="bank_type8_zt" value="zt_bank|10022">
                    <span class="bank-icon abc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="招商银行">
                <label class="icon-box" for="bank_type5_zt" value="zt_bank|10001">
                    <span class="bank-icon cmb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="交通银行">
                <label class="icon-box" for="bank_type9_zt" value="zt_bank|10016">
                    <span class="bank-icon comm"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国银行">
                <label class="icon-box" for="bank_type11_zt" value="zt_bank|10009">
                    <span class="bank-icon boc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18_zt" value="zt_bank|10012">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国光大银行">
                <label class="icon-box" for="bank_type17_zt" value="zt_bank|10005">
                    <span class="bank-icon cebb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国邮政储蓄银行">
                <label class="icon-box" for="bank_type22_zt" value="zt_bank|10011">
                    <span class="bank-icon psbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中信银行">
                <label for="bank_type10_zt" class="icon-box" value="zt_bank|10003">
                    <span class="bank-icon citic"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国民生银行">
                <label class="icon-box" for="bank_type12_zt" value="zt_bank|10004">
                    <span class="bank-icon cmbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="平安银行">
                <label class="icon-box" for="bank_type19_zt" value="zt_bank|10017">
                    <span class="bank-icon spab"><i></i></span>
                </label>
            </span></li>
                    <li><span title="兴业银行">
                <label class="icon-box" for="bank_type16_zt" value="zt_bank|CIB">
                    <span class="bank-icon cib"><i></i></span>
                </label>
            </span></li>
                    <li><span title="华夏银行">
                <label for="bbpay_bank_type30_zt" class="icon-box" value="zt_bank|10002">
                    <span class="bank-icon hxyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京银行">
                <label for="bank_type20_zt" class="icon-box" value="zt_bank|10010">
                    <span class="bank-icon bjb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="宁波银行">
                <label for="bank_type27_zt" class="icon-box" value="zt_bank|10021">
                    <span class="bank-icon ningbyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海银行">
                <label for="bank_type29_zt" class="icon-box" value="zt_bank|10025">
                    <span class="bank-icon shanghyh"><i></i></span>
                </label>
            </span></li>
                </ul>
                <div style="clear: both;">
                </div>
            </div>

            <div id="zhifubao_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div id="wxpay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_wxpay">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div id="chuxu_hc_nocard_p" class="savingsmindiv divColor" style="display: none;
        height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">快捷支付</span><br/>
                    <span class="character">只支持借记卡</span>
                </div>
            </div>
            <div id="chuxu_ys_p" style="display: none; height: 4.5rem;">
                <ul class="pay_list" style="width: 92%; padding-top: 10px">
                    <li><span title="中国工商银行">
                <label class="icon-box" for="bank_type6_ys" value="ys_bank|1021000">
                    <span class="bank-icon icbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国建设银行">
                <label class="icon-box" for="bank_type7_ys" value="ys_bank|1051000">
                    <span class="bank-icon ccb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国农业银行">
                <label class="icon-box" for="bank_type8_ys" value="ys_bank|1031000">
                    <span class="bank-icon abc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="招商银行">
                <label class="icon-box" for="bank_type5_ys" value="ys_bank|3085840">
                    <span class="bank-icon cmb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="交通银行">
                <label class="icon-box" for="bank_type9_ys" value="ys_bank|3012900">
                    <span class="bank-icon comm"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国银行">
                <label class="icon-box" for="bank_type11_ys" value="ys_bank|1041000">
                    <span class="bank-icon boc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18_ys" value="ys_bank|3102900">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国光大银行">
                <label class="icon-box" for="bank_type17_ys" value="ys_bank|3031000">
                    <span class="bank-icon cebb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="广东发展银行">
                <label class="icon-box" for="bank_type13_ys" value="ys_bank|3065810">
                    <span class="bank-icon gdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中国民生银行">
                <label class="icon-box" for="bank_type12_ys" value="ys_bank|3051000">
                    <span class="bank-icon cmbc"><i></i></span>
                </label>
            </span></li>
                    <li><span title="兴业银行">
                <label class="icon-box" for="bank_type16_ys" value="ys_bank|3093910">
                    <span class="bank-icon cib"><i></i></span>
                </label>
            </span></li>
                    <li><span title="宁波银行">
                <label for="bank_type27_ys" class="icon-box" value="ys_bank|3133320">
                    <span class="bank-icon ningbyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海浦发银行">
                <label class="icon-box" for="bank_type18_ys" value="ys_bank|3102900">
                    <span class="bank-icon spdb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="中信银行">
                <label for="bank_type10_ys" class="icon-box" value="ys_bank|3021000">
                    <span class="bank-icon citic"><i></i></span>
                </label>
            </span></li>
                    <li><span title="平安银行">
                <label class="icon-box" for="bank_type19_ys" value="ys_bank|3071000">
                    <span class="bank-icon spab"><i></i></span>
                </label>
            </span></li>
                    <li><span title="北京银行">
                <label for="bank_type20_ys" class="icon-box" value="ys_bank|3131000">
                    <span class="bank-icon bjb"><i></i></span>
                </label>
            </span></li>
                    <li><span title="东亚银行">
                <label for="bank_type24_ys" class="icon-box" value="ys_bank|5021000">
                    <span class="bank-icon1 dyyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="上海农村商业银行">
                <label for="bank_type25_ys" class="icon-box" value="ys_bank|3222900">
                    <span class="bank-icon shanghainongshangyh"><i></i></span>
                </label>
            </span></li>
                    <li><span title="南京银行">
                <label for="bank_type26_ys" class="icon-box" value="ys_bank|3133010">
                    <span class="bank-icon nanjyh"><i></i></span>
                </label>
            </span></li>

                </ul>

                <div style="clear: both;">
                </div>
            </div>
            <div id="yf_weixin_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_wxpay">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div id="ztpay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_wxpay">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div id="ztalipay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div id="hwalipay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="chuxu_hw_nocard_p" class="savingsmindiv divColor" style="display: none;
        height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">快捷支付</span><br/>
                    <span class="character">只支持借记卡</span>
                </div>
            </div>

            <div id="hw_bank_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">网银支付</span><br/>
                    <span class="character">只支持借记卡</span>
                </div>
            </div>

            <div id="ka101_express_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">快捷支付</span><br/>
                    <span class="character">输入卡号就能支付</span>
                </div>
            </div>

            <div id="ka101_weixin_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="ka101_alipay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="slf_alipay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="slf_weixin_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_wxpay">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="slf_bank_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">网银支付</span><br/>
                    <span class="character">只支持借记卡</span>
                </div>
            </div>

            <div id="slf_express_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">快捷支付</span><br/>
                    <span class="character">输入卡号就能支付</span>
                </div>
            </div>

            <div id="duobao_bank_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_hc_nocard">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">网银支付</span><br/>
                    <span class="character">只支持借记卡</span>
                </div>
            </div>

            <div id="duobao_alipay_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_zhifubao">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">支付宝支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>

            <div id="duobao_weixin_p" class="savingsmindiv divColor" style="display: none; height: 4.5rem;">
                <div class="float_left icon_width">
                    <div class="icon_wxpay">
                    </div>
                </div>
                <span class="float_right savings_link"></span>
                <div class="float_left">
                    <span class="character_biaoti character">微信支付</span><br/>
                    <span class="character">0手续费,无限额</span>
                </div>
            </div>
            <div style="text-align: center;">
                <input type="button" value="提交充值" id="bt_sub_fill" style="background: #db150b none repeat scroll 0 0;
            border-radius: 0.2rem; bottom: 0.5rem; color: #fff; font-size: 0.875rem; line-height: 1.875rem;
            padding: 0 1.3rem; right: 0.65rem; text-align: center; width: 100%;"/>
            </div>

            <div style="margin-top: 30px; clear: both; height: 50px; text-align: center; display: none;"
                 id="p_weixin_help">
                <a href="/help/weixin" target="_blank" style="color: Red; text-decoration: underline;
            font-size: large;" id="link_go_weixinselfhelp">微信充值说明(手机打开微信扫一扫二维码支付)</a>
            </div>
            <div style="margin-top: 30px; clear: both; height: 50px; text-align: center; display: none;"
                 id="p_hwalipay_help">
                <a href="/help/hwalipay" target="_blank" style="color: Red; text-decoration: underline;
            font-size: large;" id="link_go_hwalipayselfhelp">支付宝(扫码)充值说明(若充值失败，请使用其他充值方式或反复充值几次)</a>
            </div>
            <input type="hidden" id="hd_loginName" value="admin123465"/>
            <a id="sendalipayurl" rel="noreferrer"></a>
        </div>
        <div id="popup_div" class="popup_div" style="display: none">
        </div>
        <div id="popup_content" class="divColor popup_content" style="display: none">
            <table id="center">
                <tr>
                    <td class="popup_first">
                        提示
                    </td>
                </tr>
                <tr>
                    <td>
                        最小充值10元
                    </td>
                </tr>
                <tr>
                    <td class="popup_last">
                        <div id="quedin">
                            确定
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <script type="text/javascript">
            $(function () {
                var first_g = $(".recharge_div div:eq(0)");
                var p = first_g.removeClass("recharge_way_off").addClass("recharge_way_no").attr("data-p");
                var v = first_g.removeClass("recharge_way_off").addClass("recharge_way_no").attr("data-v");
                $("#" + p).show();
                if (p == "chuxu_hc_nocard_p") {
                    $("#HdpayType").val("hc_bank|NOCARD");
                }
                else if (p == "slf_bank_p") {
                    $("#HdpayType").val("slf_bank|0");
                }
                else if (p == "chuxu_ys_p") {
                    $("#HdpayType").val("ys_bank|1021000");
                }
                else {
                    $("#HdpayType").val(v);
                }

            })


            var IsIE = false;
            if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)) {
                IsIE = true;
            }
            $('.input_width').bind('keyup', function () {
                this.value = this.value.replace(/\D/g, '');
            });
            var alipayurl = function (payAmount, orderId) {
                var url = $.format("https://shenghuo.alipay.com/send/payment/fill.htm?optEmail={0}&payAmount={1}&title={2}", encodeURI("pay@qucai.com"), payAmount, orderId);
                return url;
            }
            // 支付宝充值 跳转
            $("#zhifubao_p").click(function () {
                var money = $.trim($('#recharge').val());
                if (money == '' || money < 10) {
                    Box.alert('最小充值10元');
                    return;
                }
                Box.alert('为了即时到账，支付宝充值请备注网站登录名');
                $("#frm_alipay").attr("action", "/help/AlipayPay");

                //支付宝充值
                //        document.forms[0].submit();
                return false;
            });
            //银行卡点击事件
            $(".icon-box").click(function () {
                $(this).parent().parent().parent().find("span.cur").removeClass("cur");
                $(this).find("span.bank-icon,span.bank-icon1,span.bank-icon2").addClass("cur");
                var type_ = $(this).attr("value");
                var money = $.trim($('#recharge').val());
                if (money == '' || money < 10) {
                    Box.alert('最小充值10元');
                    return;
                }

                var payType = $(this).attr("value")
                var payTypeArray = payType.split('|');
                if (payTypeArray.length == 2) {
                    var gateWay = payTypeArray[0];
                    if (gateWay == "ips_bank") {
                        $("#frm_alipay").attr("action", $("#hd_ips_jump_url").val() + "/user/redirectpay");
                    }
                    if (gateWay == "zf_bank") {
                        $("#frm_alipay").attr("action", $("#hd_zf_jump_url").val() + "/user/redirectpay");
                    }
                    if (gateWay == "hc_bank") {
                        $("#frm_alipay").attr("action", $("#hd_hc_jump_url").val() + "/user/redirectpay");
                    }
                    if (gateWay == "ys_bank") {
                        $("#frm_alipay").attr("action", $("#hd_ys_jump_url").val() + "/user/redirectpay");
                    }
                    if (gateWay == "zt_bank") {
                        $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                    }
                }
                var HdpayType = $("#HdpayType").val(payType);
            })
            //提交充值
            $("#bt_sub_fill").click(function () {
                var max = parseFloat($("#hd_maxFillMoney").val());
                var current = parseFloat($("#recharge").val());
                if (current > max) {
                    alert("单笔充值金额最大为" + max);
                    $("#recharge").val(max);
                    return false;
                }
                var gateWay = $(".recharge_way_no").attr("gateWay");
                //        console.warn(gateWay)
                //        console.warn($("#HdpayType").val())
                if ((gateWay == "zf" || gateWay == "hc" || gateWay == "ips") && !$("#HdpayType").val()) {
                    alert("请选择银行卡");
                    return false;
                }
                if (gateWay == "alipay") {
                    Box.alert('为了即时到账，支付宝充值请备注网站登录名');
                }

                if (gateWay == "yf_weixin") {
                    if (current < 2 || current > 5000) {
                        Box.alert('支付金额必须在2-5000元内!');
                        return false;
                    }
                }

                document.charset = 'gbk';
                document.forms[0].submit();
            })

            $("#recharge").blur(function () {
                var money = $("#recharge").val();
                if (money < 10 && money != "") {
                    $("#popup_div").css("display", "block");
                    $("#popup_content").css("display", "block");
                }
            });
            $("#chuxu_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "block");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");

                $("#chuxu_").removeClass("recharge_way_off");
                $("#chuxu_").addClass("recharge_way_no");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");

                $(".wwbox").hide();
                $(".record_import").hide();
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#frm_alipay").attr("action", $("#hd_ips_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })
            $("#chuxu_zf").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "block");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");

                $("#chuxu_zf").removeClass("recharge_way_off");
                $("#chuxu_zf").addClass("recharge_way_no");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $(".wwbox").hide();
                $(".record_import").hide();
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#frm_alipay").attr("action", $("#hd_zf_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })
            $("#chuxu_hc").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "block");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");

                $("#chuxu_hc").removeClass("recharge_way_off");
                $("#chuxu_hc").addClass("recharge_way_no");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $(".wwbox").hide();
                $(".record_import").hide();
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#HdpayType").val("");
                $("#frm_alipay").attr("action", $("#hd_hc_jump_url").val() + "/user/redirectpay");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#p_hwalipay_help").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");

            })
            $("#zhifubao_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "block");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");

                $("#zhifubao_").removeClass("recharge_way_off");
                $("#zhifubao_").addClass("recharge_way_no");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");

                $(".wwbox").show();
                $(".record_import").show();
                $("#frm_alipay").attr("action", "/help/AlipayPay");
                $("#p_alpay_help").show();
                $("#p_weixin_help").hide();
                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })
            $("#wxpay_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "block");

                $("#wxpay_").removeClass("recharge_way_off");
                $("#wxpay_").addClass("recharge_way_no");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#frm_alipay").attr("action", "/member/WXRequestPay");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            $("#chuxu_hc_nocard").click(function () {
                pay_off_all();
                $("#chuxu_hc_nocard_p").css("display", "block");
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#wxpay_p").css("display", "none");

                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_off");
                $("#chuxu_hc_nocard").addClass("recharge_way_no");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $(".wwbox").show();
                $(".record_import").show();
                $("#frm_alipay").attr("action", $("#hd_hc_nocard_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hc_bank|NOCARD");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            $("#chuxu_ys_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                //$("#frm_alipay").attr("action", "/member/WXRequestPay");
                //$("#frm_alipay").attr("action", $("#hd_ys_jump_url").val() + "/user/redirectpay");
                //$("#HdpayType").val("ys_bank|NOCARD");
                $("#chuxu_ys_").removeClass("recharge_way_off");
                $("#chuxu_ys_").addClass("recharge_way_no");
                $("#chuxu_ys_p").css("display", "block");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })


            $("#yf_weixin").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").show();
                //$("#frm_alipay").attr("action", "/member/WXRequestPay");
                $("#frm_alipay").attr("action", $("#hd_yf_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("yf_weixin|WEIXIN");
                $("#yf_weixin").removeClass("recharge_way_off");
                $("#yf_weixin").addClass("recharge_way_no");
                $("#yf_weixin_p").css("display", "block");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            $("#ztpay_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").show();
                $("#p_hwalipay_help").hide();
                //$("#frm_alipay").attr("action", "/member/WXRequestPay");
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("ztpay|WEIXIN");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_off");
                $("#ztpay_").addClass("recharge_way_no");
                $("#ztpay_p").css("display", "block");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            //ztalipay_p
            $("#ztalipay_").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_alpay_help").show();
                $("#p_weixin_help").hide();
                //$("#frm_alipay").attr("action", "/member/WXRequestPay");
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("ztalipay|Alipay");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_off");
                $("#ztalipay").addClass("recharge_way_no");
                $("#ztalipay_p").css("display", "block");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            $("#hwalipay_").click(function () {
                pay_off_all();

                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_hwalipay_help").show();
                $("#p_weixin_help").hide();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hwalipay|Alipay");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_off");
                $("#hwalipay_").addClass("recharge_way_no");
                $("#hwalipay_p").css("display", "block");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");

                // $("#p_hwalipay_help").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })

            $("#chuxu_zt").click(function () {
                pay_off_all();
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#wxpay_p").css("display", "none");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");
                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_no");
                $("#chuxu_hc_nocard").addClass("recharge_way_off");
                $("#p_hwalipay_help").show();
                $("#p_weixin_help").hide();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hwalipay|Alipay");
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");


                $("#chuxu_zt").removeClass("recharge_way_off");
                $("#chuxu_zt").addClass("recharge_way_no");

                $("#chuxu_zt_p").css("display", "block");
                $("#p_hwalipay_help").css("display", "none");
                $("#chuxu_hw_nocard_p").css("display", "none");
            })


            $("#chuxu_hw_nocard").click(function () {

                pay_off_all();
                $("#chuxu_hc_nocard_p").css("display", "none");
                $("#chuxu_p").css("display", "none");
                $("#chuxu_zf_p").css("display", "none");
                $("#chuxu_hc_p").css("display", "none");
                $("#zhifubao_p").css("display", "none");
                $("#wxpay_p").css("display", "none");

                $("#zhifubao_").removeClass("recharge_way_no");
                $("#zhifubao_").addClass("recharge_way_off");
                $("#chuxu_hc").removeClass("recharge_way_no");
                $("#chuxu_hc").addClass("recharge_way_off");
                $("#chuxu_").removeClass("recharge_way_no");
                $("#chuxu_").addClass("recharge_way_off");
                $("#chuxu_zf").removeClass("recharge_way_no");
                $("#chuxu_zf").addClass("recharge_way_off");
                $("#chuxu_hc_nocard").removeClass("recharge_way_off");
                $("#chuxu_hc_nocard").addClass("recharge_way_no");
                $("#wxpay_").removeClass("recharge_way_no");
                $("#wxpay_").addClass("recharge_way_off");

                $("#chuxu_ys_").removeClass("recharge_way_no");
                $("#chuxu_ys_").addClass("recharge_way_off");
                $("#chuxu_ys_p").css("display", "none");

                $(".wwbox").show();
                $(".record_import").show();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hw_quick|1001");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#yf_weixin").removeClass("recharge_way_no");
                $("#yf_weixin").addClass("recharge_way_off");
                $("#yf_weixin_p").css("display", "none");

                $("#ztpay").removeClass("recharge_way_no");
                $("#ztpay").addClass("recharge_way_off");
                $("#ztpay_p").css("display", "none");

                $("#ztalipay").removeClass("recharge_way_no");
                $("#ztalipay").addClass("recharge_way_off");
                $("#ztalipay_p").css("display", "none");

                $("#hwalipay").removeClass("recharge_way_no");
                $("#hwalipay").addClass("recharge_way_off");
                $("#hwalipay_p").css("display", "none");

                $("#chuxu_zt").removeClass("recharge_way_no");
                $("#chuxu_zt").addClass("recharge_way_off");
                $("#chuxu_zt_p").css("display", "none");
                $("#p_hwalipay_help").css("display", "none");

                pay_on("chuxu_hw_nocard");
                //$("#chuxu_hw_nocard_p").css("display", "block");
            })

            $("#ka101_express").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_ka101_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("ka101_express|Alipay");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#ztpay_p").hide();
                $("#p_hwalipay_help").css("display", "none");
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#ka101_express_p").removeClass("recharge_way_off");
                pay_on("ka101_express");
            })

            $("#ka101_weixin").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_ka101_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("ka101_weixin|weixin");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#p_hwalipay_help").css("display", "none");
                pay_on("ka101_weixin");
            })

            $("#ka101_alipay").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_ka101_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("ka101_alipay|Alipay");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").show();
                pay_on("ka101_alipay");
            })


            $("#slf_alipay").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("slf_alipay|Alipay");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").show();
                pay_on("slf_alipay");
            })

            $("#slf_weixin").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("slf_weixin|weixin");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").show();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("slf_weixin");
            })

            $("#slf_express").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("slf_express|0");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("slf_express");
            })

            $("#slf_bank").click(function () {
                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("slf_bank|0");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("slf_bank");
            })

            $("#hw_bank").click(function () {
                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hw_bank|1003");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("hw_bank");
            })


            $("#hwweixin").click(function () {
                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("hwweixin|weixin");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").show();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("hwweixin");
            })

            $("#duobao_bank").click(function () {
                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("duobao_bank|0");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("duobao_bank");
            })


            $("#duobao_alipay").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("duobao_alipay|Alipay");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").hide();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").show();
                pay_on("duobao_alipay");
            })

            $("#duobao_weixin").click(function () {

                pay_off_all();
                $("#frm_alipay").attr("action", $("#hd_zt_jump_url").val() + "/user/redirectpay");
                $("#HdpayType").val("duobao_weixin|weixin");
                $("#p_alpay_help").hide();
                $("#p_weixin_help").show();
                $("#hwalipay_p").hide();
                $("#ztpay_p").hide();
                $("#zhifubao_p").hide();
                $("#chuxu_ys_p").hide();
                $("#p_hwalipay_help").hide();
                pay_on("duobao_weixin");
            })


            $("#quedin").click(function () {
                $("#popup_div").css("display", "none");
                $("#popup_content").css("display", "none");
            })


            function pay_off(payid) {
                $("#" + payid).removeClass("recharge_way_no");
                $("#" + payid).addClass("recharge_way_off");
                $("#" + payid + "_p").css("display", "none");
            }

            function pay_on(payid) {
                $("#" + payid).removeClass("recharge_way_off");
                $("#" + payid).addClass("recharge_way_no");
                $("#" + payid + "_p").css("display", "block");
            }

            function pay_off_all() {
                pay_off("chuxu_hc_nocard");
                pay_off("chuxu_ys_");
                pay_off("chuxu_hc");
                pay_off("chuxu_zf");
                pay_off("chuxu_");
                pay_off("chuxu_zt");
                pay_off("chuxu_hw_nocard");
                pay_off("zhifubao_");
                pay_off("ztalipay_");
                pay_off("hwalipay_");
                pay_off("wxpay_");
                pay_off("yf_weixin");
                pay_off("ztpay_");
                pay_off("slf_alipay");
                pay_off("slf_weixin");
                pay_off("slf_bank");
                pay_off("slf_express");
                pay_off("hw_bank");
                pay_off("duobao_bank");
                pay_off("duobao_alipay");
                pay_off("duobao_weixin");

                pay_off("ka101_express");
                pay_off("ka101_weixin");
                pay_off("ka101_alipay");
                $("#hwalipay_p").hide();
                $("#p_alpay_help").hide();
                $("#hw_bank_p").hide();
                $("#p_hwalipay_help").css("display", "none");
            }
        </script>

    </div>
</div>
<div class="hide">

</div>
</body>
</html>
