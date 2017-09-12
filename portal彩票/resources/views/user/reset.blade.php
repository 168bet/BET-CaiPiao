<!DOCTYPE html>
<html>
<head>
    <title>密码重置 - 用户中心</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="/css/main.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/my_common.css" rel="stylesheet" type="text/css"/>
    <link href="/css/user.min.css" rel="stylesheet" type="text/css"/>
    <script src="/scripts/share.touch.min.js" type="text/javascript"></script>
    <script src="/scripts/common.js" type="text/javascript"></script>
    <script src="/scripts/iscroll.js" type="text/javascript"></script>
    <script src="/scripts/onlinephone.js" type="text/javascript"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            text-align: center;
            padding-bottom: 40px;
            margin: 0;
            font-family: "Microsoft YaHei", sans-serif;
        }

        .show {
            display: block;
        }

        .hide {
            display: none;
        }

        .green {
            color: #31B567;
        }

        .bg-cyan {
            background-color: #72C47C;
            border-radius: 2px;
        }

        .try {
            text-decoration: none;
            color: white;
            margin: 15px auto;
            height: 40px;
            width: 260px;
            overflow: hidden;
            display: inline-block;
        }

        .font-28 {
            font-size: 28px;
        }

        .font-15 {
            font-size: 15px;
        }

        .font-14 {
            font-size: 14px;
        }

        .font-16 {
            font-size: 16px;
        }

        .title {
            margin-bottom: 40px;
        }

        .title > h1 {
            margin: 0;
        }

        .title > p {
            margin: 5px 0 0 0;
        }

        #pop {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
            overflow: auto;
        }

        .gt_mobile_holder {
            margin-top: 100px;
            display: inline-block;
        }

        .buyHeader h1 {
            color: #fff;
            font-size: 1.0rem;
            margin: 0 auto;
            text-align: center;
            width: 11rem;
            font-weight: 100;
            width: 100%;
            height: 2.6rem;
            line-height: 2.6rem;
        }

        .gray .img img {
            width: 8rem;
            height: 8rem;
            border-radius: 8rem;
            margin: 3rem auto 1rem;
            background: #CD0508;
        }


        .checkBox input {
            float: left;
            height: 2.5rem;
            line-height: 2.5rem
        }

        .checkBox input#checkCode {
            width: 70%;
        }

        .checkBox input#checkSendBtn {
            width: 30%;
            background: #CD0508;
            color: #fff
        }

        .other {
            height: 4rem;
        }

        .other a {
            height: 2rem;
            line-height: 3rem;
            padding: 1rem;
        }
    </style>
</head>
<body>
<div id="tx_c" class="logints" style="display:none;"></div>
<section id="dConfirm" class="zfPop weige_" style="position: fixed;z-index: 1000;display: none">
    <h4>提示</h4>
    <div class="clearfix pdLeft08 center"></div>
    <div class="zfTrue clearfix">
        <input type="button" value="取消" class="zfqx" id="zfqx"/>
        <input type="button" value="确定" id="zfqd"/>
    </div>
</section>
<div id="Mask"
     style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; background: none repeat scroll 0% 0% gray; opacity: 0.5; z-index: 999;">
</div>
<script type="text/javascript">
    var ires = "http://res.qcwddd.com/iqucai.touch/images/";
    var dres = "http://data.qcwddd.com/matchdata/";
</script>

<div style="position: relative;" id="outer">
    <div class="wrap">
        <header class="tzHeader">
            <section class="buyHeader">
                <h1 id="titel_">密码重置</h1>
            </section>
        </header>
        <section>
            <article id="content_home" style="">
                <article class="gray">

                    <div class="img">
                        <img src="images/0-1注册_r2_c4.gif">
                    </div>
                    <div class="pdLfrt09 pdTop06">
                        <div class="s1 relative">
                            <input id="phone" placeholder="请输入您的手机号" type="text">
                            <em class="error" style="display:none;"></em>
                        </div>
                        <div class="s1 relative checkBox">
                            <input id="checkCode" placeholder="请输入短信验证码" type="text">
                            <input id="checkSendBtn" type="button" value="获取验证码">
                        </div>
                        <div class="s1 relative">
                            <input id="iCode" placeholder="请输入新的登录密码" type="text" onpaste="return false"
                                   ondragenter="return false" onkeyup="this.value=check(this.value)">
                            <em class="zhuceOpen" style="display: block;">***</em>
                            <em style="display: none;" class="zhuceOpen2">123</em>
                        </div>


                        <a href="javascript:;" class="payment" id="bott_">确认</a>
                    </div>
                    <input id="hidGeetest" type="hidden" value='Defalut'/>
                    <input type="hidden" id="hidType" value="register"/>
                </article>
            </article>
            <div class="other">
                <a href="" class="red">登录518彩票</a>|<a href="">注册账号</a>
            </div>
        </section>
        <div id="pop" class="hide">
        </div>
        <script src="/scripts/gt.js"></script>
        <script src="/scripts/user.js" type="text/javascript"></script>

    </div>
</div>
<div class="hide">

</div>
</body>
</html>
