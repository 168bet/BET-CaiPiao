<!DOCTYPE html>
<html>
<head>
    <title>提款 - 个人中心</title>
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
    <script src="/scripts/onlinePhone.js" type="text/javascript"></script>
</head>
<body>
<!-- layout s -->
<div id="tx_c" class="logints" style="display:none;"></div>
<section id="dConfirm" class="zfPop weige_" style="position: fixed;z-index: 1000;display: none"><h4>提示</h4>
    <div class="clearfix pdLeft08 center"></div>
    <div class="zfTrue clearfix">
        <input type="button" value="取消" class="zfqx" id="zfqx"/>
        <input type="button" value="确定" id="zfqd"/>
    </div>
</section>
<div id="Mask" style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;"></div>
<!-- layout end -->
<script type="text/javascript">
    var ires = "http://res.qcwddd.com/iqucai.touch/images/";
    var dres = "http://data.qcwddd.com/matchdata/";
</script>

<div style="position: relative;" id="outer">
    <div class="wrap">
        <link href="/css/member.css" rel="stylesheet" type="text/css"/>
        <script src="/scripts/member.js" type="text/javascript"></script>
        <header class="moreHeader">
            <a class="backIco2 moreico" href="order"></a>
            <h1>提款</h1>
        </header>
        <div>
            <div style="border-right: medium none; border-left: medium none;" class="recharge1 recharge2">
                <ul>
                    <li id="pay1" class="cur" onclick="setZfShow(0);"><cite>
                            <a href="/member/drawings">储蓄卡</a></cite></li>

                    <div class="clear">
                    </div>
                </ul>
            </div>
            <div class="tip2">
                <i></i><b class="leftdesc">温馨提示：</b><span>为保障您的账户安全，提款前请填写您的真实身份信息、银行卡信息、手机信息！</span>
            </div>
            <link href="/css/member.css" rel="stylesheet" type="text/css"/>
            <form action="/member/authrealname" method="post" onsubmit="return checkInput();">
                <div>
                    <div class="idcardsucceed">
                    </div>
                    <div class="record_import divColor">
                        <span class="reminder">真实姓名</span>
                        <input class="input_width" name="txt_realName" id="txt_realName" maxlength="16" size="26"
                               placeholder="请输入真实姓名" type="text"/>
                    </div>
                    <div class="record_import divColor">
                        <span class="reminder">身份证号</span>
                        <input class="input_width" id="idCardNumber" name="idCardNumber" size="26" maxlength="18"
                               placeholder="请输入身份证号"
                               type="tel"/>
                    </div>
                    <div class="record_import divColor">
                        <span class="reminder">重复输入</span>
                        <input class="input_width" id="idCardNumber2" name="idCardNumber2" placeholder="请输入身份证号"
                               type="tel" size="26"
                               maxlength="18"/>
                    </div>
                    <br/>
                    <br/>
                    <div class="record_import drawingsColor">
                        <input type="submit" value="提交"><input type="hidden" value="bindidcardexcute"
                                                               name="backurl"/>
                    </div>
                </div>
            </form>
            <br/>
            <br/>
            <div class="tips magin_title">
                <i></i><b class="leftdesc">温馨提醒：</b> <br/>
                <span class="desc gray">
                    1.暂不支持港澳台身份证，军官证，护照等相关证件进行实名认证。如果您没有中国大陆内地身份证，请咨询客服热线。<br/>
                    2.为保证您的实名认证顺利进行，推荐使用IE8、IE6、360安全浏览器进行认证。<br/>
                    3.如有任何疑问，请联系网站客服
                </span>
            </div>
            <script type="text/javascript">
                var msg = '';
                showMsg(msg);

                function showMsg(msg) {
                    if (msg.length > 0) {
                        Box.alert(msg)
                    }
                    else {
                        $("#authRealNameERR").text("");
                        $("#errbox").hide();
                    }
                }

                function checkInput() {
                    var realName = $.trim($("#txt_realName").val());
                    var id1 = $.trim($("#idCardNumber").val());
                    var id2 = $.trim($("#idCardNumber2").val());
                    msg = "";
                    var reg = /^[\u4e00-\u9fa5·]+$/i;
                    if (realName == "" || realName == null) {
                        msg = "请输入您的真实姓名";
                        Box.alert(msg);
                        $("#txt_realName").focus();
                        return false;
                    }
                    if (id1 == "" || id1 == null) {
                        msg = "请输入您的身份证号码";
                        Box.alert(msg);
                        $("#idCardNumber").focus();
                        return false;
                    }
                    if (id2 == "" || id2 == null) {
                        msg = "请再次输入您的身份证号码";
                        Box.alert(msg);
                        $("#idCardNumber").focus();
                        return false;
                    }
                    if (!Tool.isCardNo(id2) || id1 != id2) {
                        msg = "输入身份证号码有误";
                        Box.alert(msg);
                        $("#idCardNumber2").focus();
                        return false;
                    }
                    showMsg(msg);
                    return !msg.length > 0;
                }
            </script>
        </div>

    </div>
</div>
<div class="hide">

</div>
</body>
</html>
