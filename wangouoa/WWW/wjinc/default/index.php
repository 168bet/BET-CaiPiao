<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->display('inc_skin.php', 0, '首页'); ?>
    <!--本程序由启凡网络提供 网址:http://qq:3161386858/ -->
    <link href="/skin/main/home.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        $(document).ready(function () {
            $(".phbtbl").each(function () {
                $(this).find('tr:even').addClass("phbtbl_color");
            });
            $(".phbtbl td span:eq(0)").html("&nbsp;").addClass("jp");
            $(".phbtbl td span:eq(1)").html("&nbsp;").addClass("yp");
            $(".phbtbl td span:eq(2)").html("&nbsp;").addClass("tp");
            $(".phbtbl td span").css("backgroundColor", "#d70002");

            $(".tipstxt:first").css("display", "block");
            $("ul.tipslist li a").click(
                function toggle() {
                    $(".tipstxt").css("display", "none");
                    $(this).parent().find("span").css("display", "block")
                });
            var _length = $(".tipstxt").length;
            var _height = 250 - (_length - 1) * 25;
            $(".tipstxt").css("height", _height);
        })
    </script>
</head>
<body ondrag="return false;">
<div id="mainbody">
    <?php $this->display('inc_header.php'); ?>
    <div class="pagetop"></div>
    <div class="pagemain">
        <div class="homelayout">
            <div class="homelist">
                <ul class="clist">
                    <li><a href="/index.php/index/game/1/6">
                            <img alt="" src="/images/index/c1.png"><span>重庆时时彩</span></a></li>
                    <li><a href="/index.php/index/game/14/72">
                            <img alt="" src="/images/index/c1.png"><span>澳门五分彩</span></a></li>
                    <li><a href="/index.php/index/game/6/10">
                            <img alt="" src="/images/index/c4.png"><span>广东11选5</span></a></li>
                    <li><a href="/index.php/index/game/15/9">
                            <img alt="" src="/images/index/c4.png"><span>重庆11选5</span></a></li>
                    <li><a href="/index.php/index/game/9/16">
                            <img alt="" src="/images/index/c5.png"><span>福彩3D</span></a></li>
                    <li><a href="/index.php/index/game/10/16">
                            <img alt="" src="/images/index/c6.png"><span>排列3</span></a></li>
                </ul>
            </div>

            <div class="homebox">
                <?php
                if ($this->settings['paihang'] == 1)
                {
                ?>
                <div class="homeboxleft">
                    <div class="hometitle" id="phb">即时中奖排行榜</div>
                    <div id="andyscroll">
                        <div id="scrollmessage">
                            <ul>
                                <?php
                                $this->getSystemSettings();
                                $this->getTypes();
                                $types = array(1, 3, 5, 6, 9, 10, 12, 14, 15, 16, 20, 7);
                                $name = explode('|', $this->settings['paihangsjnr']);
                                $name2 = explode('|', $this->settings['paihangsjje']);
                                $gg = $this->getRows("select * from {$this->prename}bets where zjCount=1 and bonus>? order by id desc limit 10", $this->settings['sbje']);
                                if ($gg) foreach ($gg as $var) {
                                    $gg = $this->getRows("select * from {$this->prename}bets where zjCount=1 and bonus>? order by id desc limit 10", $this->settings['sbje']);
                                    switch ($var['type']) {
                                        case 1:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp重庆时时彩&nbsp ', '<b style="color:#ff0000">', $var['actionNo'], '</b>&nbsp期', '&nbsp喜中&nbsp<b style="color:#76EE00">', $var['bonus'], '</b>&nbsp元</li>
			             <li>恭喜会员&nbsp【<b style="color:#63B8FF">', $name[rand(0, count($name) - 1)], '</b>】&nbsp', $this->types[$num = $types[rand(0, 14)]]['title'], '&nbsp', '<b style="color:#ff0000">', $this->iff($sss = $this->getGameLastNo($num), $sss['actionNo'], '--'), '</b>&nbsp期', '&nbsp喜中&nbsp<b style="color:#76EE00">', $name2[rand(0, count($name2) - 1)], '</b>&nbsp元</li>';
                                            break;
                                        case 3:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp江西时时彩&nbsp ', '<b style="color:#fedcbd">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#6a6da9">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 6:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp粤11选5&nbsp&nbsp', '<b style="color:#c37e00">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 9:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp福彩3D&nbsp', '<b style="color:#e6d12e">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#0c212b">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 10:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp排列三&nbsp', '<b style="color:#a3cf62">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 12:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp新疆时时彩&nbsp', '<b style="color:#817936">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#2b4490">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 14:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp澳门五分彩&nbsp', '<b style="color:#817936">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#2b4490">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 15:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp重庆11选5&nbsp', '<b style="color:#e6d12e">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 16:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp江西11选5&nbsp', '<b style="color:#705628">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 20:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp北京pk10&nbsp&nbsp', '<b style="color:#f47920">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#80752c">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 30:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp天天六合彩&nbsp&nbsp', '<b style="color:#f47920">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#80752c">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 7:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp山东11选5&nbsp', '<b style="color:#e6d12e">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                        case 5:
                                            echo '<li>恭喜会员&nbsp【<b style="color:#63B8FF">', $var['nickname'], '</b>】&nbsp分分彩&nbsp', '<b style="color:#e6d12e">', $var['actionNo'], '</b>期', '&nbsp喜中&nbsp<b style="color:#e6d12e">', $var['bonus'], '</b>&nbsp元</li>';
                                            break;
                                    }
                                }
                                //
                                ?>
                            </ul>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var stopscroll = false;
                        var scrollElem = document.getElementById("andyscroll");
                        var marqueesHeight = scrollElem.style.height;
                        scrollElem.onmouseover = new Function('stopscroll = true');
                        scrollElem.onmouseout = new Function('stopscroll = false');
                        var preTop = 0;
                        var currentTop = 0;
                        var stoptime = 0;
                        var leftElem = document.getElementById("scrollmessage");
                        scrollElem.appendChild(leftElem.cloneNode(true));
                        init_srolltext();

                        function init_srolltext() {
                            scrollElem.scrollTop = 0;
                            setInterval('scrollUp()', 100);//确定滚动速度的, 数值越小, 速度越快
                        }

                        function scrollUp() {
                            if (stopscroll) return;
                            currentTop += 2; //设为1, 可以实现间歇式的滚动; 设为2, 则是连续滚动
                            if (currentTop == 19) {
                                stoptime += 1;
                                currentTop -= 1;
                                if (stoptime == 180) {
                                    currentTop = 0;
                                    stoptime = 0;
                                }
                            } else {
                                preTop = scrollElem.scrollTop;
                                scrollElem.scrollTop += 1;
                                if (preTop == scrollElem.scrollTop) {
                                    scrollElem.scrollTop = 0;
                                    scrollElem.scrollTop += 1;
                                }
                            }
                        }
                    </script>
                    <style type="text/css">
                        <!--
                        ul {
                            margin: 0px;
                            padding: 0px;
                            list-style: none;
                        }

                        #andyscroll {
                            overflow: hidden;
                            padding: 0 13px;
                            text-align: left;
                            line-height: 3em;
                            width: 440px;
                            height: 277px;
                            overflow: hidden;
                        }

                        -->
                    </style>
                </div>
                <div class="homeboxright">
                    <?php }else{ ?>
                    <div class="homeboxright" style="width:950px;">
                        <?php } ?>
                        <div class="hometitle" id="tips">通知公告<a href="/index.php/notice/info">更多...</a></div>
                        <ul class="tipslist">
                            <?php
                            $data = $this->getRows("select id,title,content,addtime from {$this->prename}content where nodeId=1 and enable=1 order by addtime desc limit 4");
                            if ($data) foreach ($data as $var) {
                                echo "<li><a href=\"#\">{$var['title']}</a><em>" . date('Y/m/d h:i:s', $var['addtime']) . "</em><span class=\"tipstxt\">{$var['content']}</span></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php $this->display('inc_footer.php'); ?>
        </div>
        <div class="pagebottom"></div>
    </div>
</body>
</html>