var PollNum = localStorage.getItem(gameCode.toLowerCase() + type.toLowerCase() + "_PollNum");
var minMacthCount = function () {

    switch (type.toLowerCase()) {
        case "t14c":
            return 14;
        case "tr9":
            return 9;
        case "t6bqc":
            return 12;
        case "t4cjq":
            return 8;
        default:
            return 14;
    }

};
var ele = {
    tbody: $("#content"),
    PollNum_t: [],
    PollNum_c: []
};
//全局变量
var val_ = {
    matchData: "",
    IssueNumList: [],
    issueData: [],
    selectedIssume: "",
    //平均赔率
    matchCount: 0,
    selectoption: "",
    stoptime: 0,
    currentIss: "",
    gametype: ""
};
//读取json
var ctzqpage = {

    static_: {
        loadMatches: function (issue) {
            ele.tbody.empty().append("<div class=\"load\" style=\"height:130px;line-height:150px;width: 926px;text-align:center;\"><img src=\"" + ires + "loading-b.gif\"/></div>");
            try {
                var matchlisturl = dres + gameCode + "/match_" + type + "_issuse_list.json";
                $.getScript(matchlisturl, function () {
                    if (typeof (data) != "undefined" && data != null && data.length > 0) {
                        val_.matchData = data;
                        ctzqpage.static_.dealMatchData(val_.matchData);
                    }
                });
            } catch (e) {
                Box.alert(e.message);
            }
        },
        dealMatchData: function (data) {
            if (data.length == 0 || !data) return;
            //排序
            data.sort(function compare(a, b) {
                return a.IssuseNumber < b.IssuseNumber ? -1 : 1;
            });
            var t, stopIssue = [], h = [], curIssue = "";

            //筛选出开始时间大于当前时间的内容
            $.each(data, function (index, item) {
                t = item.StopBettingTime.replace(/-/g, '/');
                var date = new Date(t);
                if (date > servertime) {
                    val_.IssueNumList.push({ issue: item.IssuseNumber, stop: date });
                } else {
                    stopIssue.push(item.IssuseNumber);
                }
            });

            var current = val_.IssueNumList[0], currentIssue = current.issue;
            val_.stoptime = current.stop;
            //浏览器地址中的期号
            if (IssuesNum != "") curIssue = IssuesNum;
            else curIssue = currentIssue;
            val_.currentIss = currentIssue;

            //当前期
            $(".present").html("<b>当前期：" + currentIssue + "</b>")
            //截止时间
            $(".stoptime").html("<b>" + val_.stoptime.toFormatString("MM-dd HH:mm") + "</b>")
            ////赛事回查
            var issueselect = $(".issueselect");
            issueselect.html("第" + curIssue + "期");
            var issues = $(".issueselect").next();
            //class=\"red\"
            h[h.length] = "<a " + (curIssue == currentIssue ? "class='red'" : "") + " data-key=\"" + currentIssue + "\" href=\"/buy/toto/" + type + "?IssuesNum=" + currentIssue + "\">第" + currentIssue + "期</a>";
            t = stopIssue.length - 1;
            for (var i = t; i >= 0; i--) {
                h[h.length] = "<a " + (curIssue == stopIssue[i] ? "class='red'" : "") + " data-key=\"" + stopIssue[i] + "\" href=\"/buy/toto/" + type + "?IssuesNum=" + stopIssue[i] + "\">第" + stopIssue[i] + "期</a>";
            }

            issues.html(h.join(""));
            //绑定数据
            ctzqpage.static_.Bindbs(curIssue);


        },
        //绑定比赛数据
        Bindbs: function (issueNum) {
            //debugger;
            $("#issuseNumber").attr("value", issueNum);
            var issueNumRul = dres + gameCode + "/" + issueNum + "/match_" + type + "_list.json";
            var spurl = dres + gameCode + "/" + issueNum + "/match_" + type + "_odds_list.json";
            data = null;
            $.getScript(issueNumRul, function () {
                if (typeof (data) != "undefined" && data != null && data.length > 0) {
                    val_.issueData = data;
                    data = null;
                    $.getScript(spurl, function () {
                        if (typeof (data) != "undefined" && data != null && data.length > 0) {
                            ctzqpage.html.construct(val_.issueData, data);
                        }
                    });
                    // ctzqpage.html.T14C(val_.issueData);
                }
            });
        }
    },
    html: {
        construct: function (data, spdata) {
            var h = [], maxtime = "", dtime, aveArr = "", orderid, i = 0, j = 0;
            var href = ctzqpage.html;
            if (PollNum) {
                var pollNum1 = PollNum.split(',');
                $.each(pollNum1, function (n, k) {
                    ele.PollNum_c[n] = k.split('=')[0];
                    ele.PollNum_t[n] = k.split("=")[1];

                });
            }
            $.each(data, function (index, item) {
                var tt = item.MatchStartTime;
                tt = tt.replace(/-/g, '/');
                //var arr = item2.AverageOdds;
                if (index == 0 || maxtime < tt) {
                    maxtime = tt;
                }

                dtime = new Date(tt);  //开始时间
                orderid = item.OrderNumber;
                $("#issueState").attr("value", new Date(maxtime) < new Date() ? 0 : 1);
                var arr = jQuery.grep(spdata, function (it, idx) {
                    return (it.Id == item.Id);
                });
                var ypArr = arr[0].YPSW != "" ? arr[0].YPSW.split('|') : "";
                aveArr = arr[0].AverageOdds != "" ? arr[0].AverageOdds.split('|') : "";
                var pc = "";
                var mid = item.Mid;
                switch (type) {
                    case "t4cjq":
                        if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                            pc = ele.PollNum_t[$.inArray(mid.toString(), ele.PollNum_c)];
                            var p = pc.split(";");

                            if (p.length > 1) {
                                h[h.length] = "<ul class=\"sfcxs zujqs\" t=" + item.Mid + " v='y' b='" + p[1].substring(p[1].indexOf(":") + 1, p[1].length).replace(/\//g, ",") + "' c='" + p[0].replace(/\//g, ",") + "'  p='" + aveArr + "'>";
                            } else {
                                if (p[0].indexOf("b:") > -1) {
                                    h[h.length] = "<ul class=\"sfcxs zujqs\" t=" + item.Mid + " v='y' b='" + p[0].substring(p[0].indexOf(":") + 1, p[0].length).replace(/\//g, ",") + "'  p='" + aveArr + "'>";
                                } else {
                                    h[h.length] = "<ul class=\"sfcxs zujqs\" t=" + item.Mid + " v='y' c='" + p[0].replace(/\//g, ",") + "'  p='" + aveArr + "'>";
                                }
                            }


                        } else {
                            h[h.length] = "<ul class=\"sfcxs zujqs\" t=" + item.Mid + "  p='" + aveArr + "'>";
                        }

                        h[h.length] = ctzqpage.html.gettop(orderid, item, dtime);
                        if (item.IssuseNumber != val_.currentIss) {
                            h[h.length] = "<li><p class=\"spfzpkNum\">";
                            h[h.length] = "<span>" + item.HomeTeamName + "</span>";
                            h[h.length] = "<span class=\"spfvs\">VS</span>";
                            h[h.length] = "<span>" + item.GuestTeamName + "</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span class=\"chang bgred\">主队</span>";
                            h[h.length] = "<span>0</span>";
                            h[h.length] = "<span>1</span>";
                            h[h.length] = "<span>2</span>";
                            h[h.length] = "<span>3+</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span class=\"chang bgblue\">客队</span>";
                            h[h.length] = "<span>0</span>";
                            h[h.length] = "<span>1</span>";
                            h[h.length] = "<span>2</span>";
                            h[h.length] = "<span>3+</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfpl\">";
                            h[h.length] = "<span class=\"pei\">赔率</span>";
                            h[h.length] = "<span></span>";
                            h[h.length] = "<span></span>";
                            h[h.length] = "<span></span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        else {

                            h[h.length] = "<li><p class=\"spfzpkNum\">";
                            h[h.length] = "<span>" + item.HomeTeamName + "</span>";
                            h[h.length] = "<span class=\"spfvs\">VS</span>";
                            h[h.length] = "<span>" + item.GuestTeamName + "</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                                if (p.length > 1) {
                                    h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                    h[h.length] = "<span class=\"chang bgred\">主队</span>";
                                    h[h.length] = "<span v='0'" + (p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">0</span>";
                                    h[h.length] = "<span v='1' " + (p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">1</span>";
                                    h[h.length] = "<span v='2' " + (p[0].indexOf("2") > -1 ? 'class="cur"' : "") + ">2</span>";
                                    h[h.length] = "<span v='3' " + (p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">3+</span>";
                                    h[h.length] = "</p>";
                                    h[h.length] = "<div class=\"clear\"></div>";
                                    h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                    h[h.length] = "<span class=\"chang bgblue\">客队</span>";
                                    h[h.length] = "<span v='0' " + (p[1].indexOf("0") > -1 ? 'class="cur"' : "") + ">0</span>";
                                    h[h.length] = "<span v='1'" + (p[1].indexOf("1") > -1 ? 'class="cur"' : "") + ">1</span>";
                                    h[h.length] = "<span v='2'" + (p[1].indexOf("2") > -1 ? 'class="cur"' : "") + ">2</span>";
                                    h[h.length] = "<span v='3'" + (p[1].indexOf("3") > -1 ? 'class="cur"' : "") + ">3+</span>";
                                    h[h.length] = "</p>";
                                } else {
                                    if (p[0].indexOf("b:") > -1) {
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgred\">主队</span>";
                                        h[h.length] = "<span v='0'>0</span>";
                                        h[h.length] = "<span v='1' >1</span>";
                                        h[h.length] = "<span v='2' >2</span>";
                                        h[h.length] = "<span v='3' >3+</span>";
                                        h[h.length] = "</p>";
                                        h[h.length] = "<div class=\"clear\"></div>";
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgblue\">客队</span>";
                                        h[h.length] = "<span v='0' " + (p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">0</span>";
                                        h[h.length] = "<span v='1'" + (p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">1</span>";
                                        h[h.length] = "<span v='2'" + (p[0].indexOf("2") > -1 ? 'class="cur"' : "") + ">2</span>";
                                        h[h.length] = "<span v='3'" + (p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">3+</span>";
                                        h[h.length] = "</p>";
                                    } else {
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgred\">主队</span>";
                                        h[h.length] = "<span v='0'" + (p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">0</span>";
                                        h[h.length] = "<span v='1' " + (p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">1</span>";
                                        h[h.length] = "<span v='2' " + (p[0].indexOf("2") > -1 ? 'class="cur"' : "") + ">2</span>";
                                        h[h.length] = "<span v='3' " + (p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">3+</span>";
                                        h[h.length] = "</p>";
                                        h[h.length] = "<div class=\"clear\"></div>";
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgblue\">客队</span>";
                                        h[h.length] = "<span v='0' >0</span>";
                                        h[h.length] = "<span v='1'>1</span>";
                                        h[h.length] = "<span v='2'>2</span>";
                                        h[h.length] = "<span v='3'>3+</span>";
                                        h[h.length] = "</p>";
                                    }
                                }

                            } else {
                                h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                h[h.length] = "<span class=\"chang bgred\">主队</span>";
                                h[h.length] = "<span v='0'>0</span>";
                                h[h.length] = "<span v='1'>1</span>";
                                h[h.length] = "<span v='2'>2</span>";
                                h[h.length] = "<span v='3'>3+</span>";
                                h[h.length] = "</p>";
                                h[h.length] = "<div class=\"clear\"></div>";
                                h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                h[h.length] = "<span class=\"chang bgblue\">客队</span>";
                                h[h.length] = "<span v='0'>0</span>";
                                h[h.length] = "<span v='1'>1</span>";
                                h[h.length] = "<span v='2'>2</span>";
                                h[h.length] = "<span v='3'>3+</span>";
                                h[h.length] = "</p>";

                            }

                            h[h.length] = "<div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfpl\">";
                            h[h.length] = "<span class=\"pei\">赔率</span>";
                            h[h.length] = "<span>" + (aveArr.length > 0 ? aveArr[0] : "") + "</span>";
                            h[h.length] = "<span>" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + "</span>";
                            h[h.length] = "<span>" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + "</span>";
                            h[h.length] = "</p></li></ul>";

                        }
                        break;
                    case "t14c":
                        if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                            pc = ele.PollNum_t[$.inArray(mid.toString(), ele.PollNum_c)];
                            h[h.length] = "<ul class=\"sfcxs\" t=" + item.Mid + " v='y' c='" + pc.replace(/\//g, ",") + "'>";
                        } else {
                            h[h.length] = "<ul class=\"sfcxs\" t=" + item.Mid + " >";
                        }

                        h[h.length] = ctzqpage.html.gettop(orderid, item, dtime);
                        if (item.IssuseNumber != val_.currentIss) {
                            h[h.length] = "<li><p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 ? aveArr[0] : "") + " v=\"3\"><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + " v=\"1\" class=\"spfvs\"><em>VS</em><cite>平</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + " v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "</p><p class=\"spfpl\">";
                            h[h.length] = "<span></span>";
                            h[h.length] = "<span class=\"spfvs\"></span>";
                            h[h.length] = "<span></span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        else {
                            h[h.length] = "<li><p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 ? aveArr[0] : "") + " v=\"3\" " + (pc.indexOf("3") > -1 ? "class='cur'" : "") + "><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + " v=\"1\" class=\"spfvs " + (pc.indexOf("1") > -1 ? 'cur' : "") + "\"><em>VS</em><cite>平</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + " v=\"0\" " + (pc.indexOf("0") > -1 ? "class='cur'" : "") + "><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "</p><p class=\"spfpl\">";
                            h[h.length] = "<span>赔率" + (aveArr.length > 0 ? aveArr[0] : "") + "</span>";
                            h[h.length] = "<span class=\"spfvs\">赔率" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + "</span>";
                            h[h.length] = "<span>赔率" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + "</span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        break;
                    case "t6bqc":
                        aveArr = arr[0].HalfAverageOdds != "" ? arr[0].HalfAverageOdds.split('|') : "";
                        fullAve = arr[0].FullAverageOdds != "" ? arr[0].FullAverageOdds.split('|') : "";
                        var p = "";
                        if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                            pc = ele.PollNum_t[$.inArray(mid.toString(), ele.PollNum_c)];
                            p = pc.split(";");
                            if (p.length > 1) {
                                h[h.length] = "<ul class=\"sfcxs zubqc\" t=" + item.Mid + "  v='y'  b='" + p[1].substring(p[1].indexOf(":") + 1, p[1].length).replace(/\//g, ",") + "' c='" + p[0].replace(/\//g, ",") + "' p='" + aveArr + ";" + fullAve + "'>";
                            } else {
                                if (p[0].indexOf("b:") > -1) {
                                    h[h.length] = "<ul class=\"sfcxs zubqc\" t=" + item.Mid + "  v='y'  b='" + p[0].substring(p[0].indexOf(":") + 1, p[0].length).replace(/\//g, ",") + "' p='" + aveArr + ";" + fullAve + "'>";
                                } else {
                                    h[h.length] = "<ul class=\"sfcxs zubqc\" t=" + item.Mid + "  v='y'  c='" + p[0].replace(/\//g, ",") + "' p='" + aveArr + ";" + fullAve + "'>";
                                }
                            }

                        } else {
                            h[h.length] = "<ul class=\"sfcxs zubqc\" t=" + item.Mid + " p='" + aveArr + ";" + fullAve + "'>";
                        }


                        h[h.length] = ctzqpage.html.gettop(orderid, item, dtime);
                        if (item.IssuseNumber != val_.currentIss) {
                            h[h.length] = "<li><p class=\"spfzpkNum\">";
                            h[h.length] = "<span>" + item.HomeTeamName + "</span>";
                            h[h.length] = "<span class=\"spfvs\">VS</span>";
                            h[h.length] = "<span>" + item.GuestTeamName + "</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span class=\"chang bgred\">半场</span>";
                            h[h.length] = "<span v='3'>胜</span>";
                            h[h.length] = "<span v='1'>平</span>";
                            h[h.length] = "<span v='0'>负</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                            h[h.length] = "<span v='3'>胜</span>";
                            h[h.length] = "<span v='1'>平</span>";
                            h[h.length] = "<span v='0'>负</span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        else {
                            h[h.length] = "<li><p class=\"spfzpkNum\">";
                            h[h.length] = "<span>" + item.HomeTeamName + "</span>";
                            h[h.length] = "<span class=\"spfvs\">VS</span>";
                            h[h.length] = "<span>" + item.GuestTeamName + "</span>";
                            h[h.length] = "</p><div class=\"clear\"></div>";
                            if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                                if (p.length > 1) {
                                    h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                    h[h.length] = "<span class=\"chang bgred\">半场</span>";
                                    h[h.length] = "<span v='3' " + (p.length > 1 && p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">胜 " + (aveArr.length > 0 ? (aveArr[0].replace("半:", '') == '' ? '0.00' : aveArr[0].replace("半:", '')) : "") + "</span>";
                                    h[h.length] = "<span v='1' " + (p.length > 1 && p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">平 " + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "0.00") + "</span>";
                                    h[h.length] = "<span v='0' " + (p.length > 1 && p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">负 " + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "0.00") + "</span>";
                                    h[h.length] = "</p>";
                                    h[h.length] = "<div class=\"clear\"></div>";
                                    h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                    h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                                    h[h.length] = "<span v='3' " + (p.length > 1 && p[1].indexOf("3") > -1 ? 'class="cur"' : "") + ">胜 " + (fullAve.length > 0 ? (fullAve[0].replace("全:", '') == '' ? '0.00' : fullAve[0].replace("全:", '')) : "") + "</span>";
                                    h[h.length] = "<span v='1' " + (p.length > 1 && p[1].indexOf("1") > -1 ? 'class="cur"' : "") + ">平 " + (fullAve.length > 0 && fullAve.length > 1 != "" ? fullAve[1] : "0.00") + "</span>";
                                    h[h.length] = "<span v='0' " + (p.length > 1 && p[1].indexOf("0") > -1 ? 'class="cur"' : "") + ">负 " + (fullAve.length > 0 && fullAve.length > 2 != "" ? fullAve[2] : "0.00") + "</span>";
                                    h[h.length] = "</p>";
                                } else {
                                    if (p[0].indexOf("b:") > -1) {
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgred\">半场</span>";
                                        h[h.length] = "<span v='3'>胜 " + (aveArr.length > 0 ? (aveArr[0].replace("半:", '') == '' ? '0.00' : aveArr[0].replace("半:", '')) : "") + "</span>";
                                        h[h.length] = "<span v='1'>平 " + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "0.00") + "</span>";
                                        h[h.length] = "<span v='0'>负 " + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "0.00") + "</span>";
                                        h[h.length] = "</p>";
                                        h[h.length] = "<div class=\"clear\"></div>";
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                                        h[h.length] = "<span v='3' " + (p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">胜 " + (fullAve.length > 0 ? (fullAve[0].replace("全:", '') == '' ? '0.00' : fullAve[0].replace("全:", '')) : "") + "</span>";
                                        h[h.length] = "<span v='1' " + (p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">平 " + (fullAve.length > 0 && fullAve.length > 1 != "" ? fullAve[1] : "0.00") + "</span>";
                                        h[h.length] = "<span v='0' " + (p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">负 " + (fullAve.length > 0 && fullAve.length > 2 != "" ? fullAve[2] : "0.00") + "</span>";
                                        h[h.length] = "</p>";
                                    } else {
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgred\">半场</span>";
                                        h[h.length] = "<span v='3' " + (p[0].indexOf("3") > -1 ? 'class="cur"' : "") + ">胜 " + (aveArr.length > 0 ? (aveArr[0].replace("半:", '') == '' ? '0.00' : aveArr[0].replace("半:", '')) : "") + "</span>";
                                        h[h.length] = "<span v='1' " + (p[0].indexOf("1") > -1 ? 'class="cur"' : "") + ">平 " + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "0.00") + "</span>";
                                        h[h.length] = "<span v='0' " + (p[0].indexOf("0") > -1 ? 'class="cur"' : "") + ">负 " + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "0.00") + "</span>";
                                        h[h.length] = "</p>";
                                        h[h.length] = "<div class=\"clear\"></div>";
                                        h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                        h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                                        h[h.length] = "<span v='3'>胜 " + (fullAve.length > 0 ? (fullAve[0].replace("全:", '') == '' ? '0.00' : fullAve[0].replace("全:", '')) : "") + "</span>";
                                        h[h.length] = "<span v='1'>平 " + (fullAve.length > 0 && fullAve.length > 1 != "" ? fullAve[1] : "0.00") + "</span>";
                                        h[h.length] = "<span v='0'>负 " + (fullAve.length > 0 && fullAve.length > 2 != "" ? fullAve[2] : "0.00") + "</span>";
                                        h[h.length] = "</p>";
                                    }
                                }

                            } else {
                                h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                h[h.length] = "<span class=\"chang bgred\">半场</span>";
                                h[h.length] = "<span v='3' >胜 " + (aveArr.length > 0 ? (aveArr[0].replace("半:", '') == '' ? '0.00' : aveArr[0].replace("半:", '')) : "") + "</span>";
                                h[h.length] = "<span v='1' >平 " + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "0.00") + "</span>";
                                h[h.length] = "<span v='0' >负 " + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "0.00") + "</span>";
                                h[h.length] = "</p>";
                                h[h.length] = "<div class=\"clear\"></div>";
                                h[h.length] = "<p class=\"spfzpk spfzpk2\">";
                                h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                                h[h.length] = "<span v='3'>胜 " + (fullAve.length > 0 ? (fullAve[0].replace("全:", '') == '' ? '0.00' : fullAve[0].replace("全:", '')) : "") + "</span>";
                                h[h.length] = "<span v='1'>平 " + (fullAve.length > 0 && fullAve.length > 1 != "" ? fullAve[1] : "0.00") + "</span>";
                                h[h.length] = "<span v='0'>负 " + (fullAve.length > 0 && fullAve.length > 2 != "" ? fullAve[2] : "0.00") + "</span>";
                                h[h.length] = "</p>";
                            }


                            h[h.length] = " </li></ul>";

                        }
                        break;
                    case "tr9":
                        if ($.inArray(mid.toString(), ele.PollNum_c) > -1) {
                            pc = ele.PollNum_t[$.inArray(mid.toString(), ele.PollNum_c)];

                            h[h.length] = "<ul class=\"sfcxs\" t=" + item.Mid + " v='y' c='" + pc.replace(/\//g, ",") + "'>";
                        } else {
                            h[h.length] = "<ul class=\"sfcxs\" t=" + item.Mid + ">";
                        }

                        h[h.length] = ctzqpage.html.gettop(orderid, item, dtime);
                        if (item.IssuseNumber != val_.currentIss) {
                            h[h.length] = "<li><p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 ? aveArr[0] : "") + " v=\"3\"><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + " v=\"1\" class=\"spfvs\"><em>VS</em><cite>平</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + " v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "</p><p class=\"spfpl\">";
                            h[h.length] = "<span>&nbsp;</span>";
                            h[h.length] = "<span class=\"spfvs\">&nbsp;</span>";
                            h[h.length] = "<span>&nbsp;</span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        else {
                            h[h.length] = "<li><p class=\"spfzpk spfzpk2\">";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 ? aveArr[0] : "") + " v=\"3\" " + (pc.indexOf("3") > -1 ? "class='cur'" : "") + "><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + " v=\"1\" class=\"spfvs " + (pc.indexOf("1") > -1 ? "cur" : "") + "\"><em>VS</em><cite>平</cite></span>";
                            h[h.length] = "<span sp=" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + " v=\"0\" " + (pc.indexOf("0") > -1 ? "class='cur'" : "") + "><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                            h[h.length] = "</p><p class=\"spfpl\">";
                            h[h.length] = "<span>赔率" + (aveArr.length > 0 ? aveArr[0] : "") + "</span>";
                            h[h.length] = "<span class=\"spfvs\">赔率" + (aveArr.length > 0 && aveArr.length > 1 != "" ? aveArr[1] : "") + "</span>";
                            h[h.length] = "<span>赔率" + (aveArr.length > 0 && aveArr.length > 2 != "" ? aveArr[2] : "") + "</span>";
                            h[h.length] = "</p></li></ul>";
                        }
                        break;
                }

            });

            ele.tbody.html(h.join(""));
            BindEvent();
            showCount();
        },
        getLeagueHref: function (id, fixid) {
            if (id == 0 || fixid == 0) return "javascript:void(0)";
            return "/info?zsurl=/league/index/" + id + "/" + fixid;
        },
        getTeamHref: function (teamid) {
            if (teamid == 0) return "javascript:void(0)";
            return "/info?zsurl=/team/index/" + teamid;
        },
        /*edit by chen*/
        gettop: function (orderid, item, dtime) {
         var h = [], href = ctzqpage.html;
            h[h.length] = "<li class=\"li_weige\">";
            h[h.length] = "<em>" + orderid + "</em>";
            h[h.length] = "<p>" + item.MatchName + "</p>";
            h[h.length] = "<cite>" + dtime.toFormatString("MM-dd HH:mm") + "</cite>";
            h[h.length] = "</li>";
            return h.join("").toString();
        }
    },
    input_: function () {
        var count = parseInt($("#c_").html());
        var mincount = minMacthCount();
        if (count < mincount) {
            Box.tx("请至少选择" + mincount + "场比赛");
            return;
        }
        ctzqpage.local_();
        window.location.href = "/buy/zctz/" + gameCode + "/?gametype=" + val_.gametype.toLowerCase();

    },
    local_: function () {
        var h = [];
        switch (type.toLowerCase()) {
            case "tr9":
            case "t14c":
                $("#content ul").each(function (i, item) {
                    if ($(item).attr("v")) {
                        h[h.length] = "<li t=" + $(item).attr("t") + " v=" + $(item).attr("v") + " c='" + $(item).attr("c") + "'>";
                    } else {
                        h[h.length] = "<li t=" + $(item).attr("t") + ">";
                    }
                    h[h.length] = "<div class=\"spfzpk spfzpk2\">";
                    h[h.length] = $(item).find("li:eq(1) p:eq(0)").html();
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"spfpl\">";
                    h[h.length] = $(item).find("li:eq(1) p:eq(1)").html();
                    h[h.length] = "</div>";
                    h[h.length] = "</li>";
                });
                break;
            case "t4cjq":
                $("#content ul[v=y]").each(function (i, item) {

                    var c = $(this).attr("c");
                    var a = $(this).attr("b");

                    h[h.length] = "<li t=" + $(item).attr("t") + " v=" + $(item).attr("v") + " c='" + c + "' b='" + a + "'>";
                    h[h.length] = "<div class=\"spfzpkNum\">" + $(item).find("li:eq(1) p:eq(0)").html() + "</div>";
                    h[h.length] = "<div class=\"zcjq spfzpk\">";
                    h[h.length] = $(this).find("li:eq(1) p:eq(1)").html();
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"zcjq spfzpk\">";
                    h[h.length] = $(this).find("li:eq(1) p:eq(2)").html();
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"spfpl t4cjqsp\">";
                    h[h.length] = $(this).find("li:eq(1) p:eq(3)").html();
                    h[h.length] = "</div";
                    h[h.length] = "</li>";

                });
                break;
            case "t6bqc":
                $("#content ul[v=y]").each(function (i, item) {
                    var sp_ = $(this).attr("p");
                    var c = $(this).attr("c");
                    var a = $(this).attr("b");
                    var sp = sp_.split(';');
                    var b = sp[0].length > 0 ? sp[0].split(',') : "0.00";
                    var q = sp[1].length > 0 ? sp[1].split(',') : "0.00";
                    h[h.length] = "<li t=" + $(item).attr("t") + " v=" + $(item).attr("v") + " c='" + $(item).attr("c") + "' b='" + $(item).attr("b") + "'>";
                    h[h.length] = "<div class=\"spfzpkNum\">" + $(item).find("li:eq(1) p:eq(0)").html() + "</div>";
                    h[h.length] = "<div class=\"zcbqc spfzpk\">";
                    h[h.length] = "<span class=\"chang bgred\">半场</span>";
                    h[h.length] = "<span v='3' " + (c.indexOf("3") > -1 ? 'class="cur""' : "") + ">胜<cite>" + (b.length > 0 ? (b[0].replace("半:", "") == "" ? "0.00" : b[0].replace("半:", "")) : "0.00") + "</cite></span>";
                    h[h.length] = "<span v='1' " + (c.indexOf("1") > -1 ? 'class="cur"' : "") + ">平<cite>" + (b.length > 0 && b.length > 1 ? b[1] : "0.00") + "</cite></span>";
                    h[h.length] = "<span v='0'" + (c.indexOf("0") > -1 ? 'class="cur"' : "") + ">负<cite>" + (b.length > 0 && b.length > 2 ? b[2] : "0.00") + "</cite></span>";
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"zcbqc spfzpk\">";
                    h[h.length] = "<span class=\"chang bgblue\">全场</span>";
                    h[h.length] = "<span v='3' " + (a.indexOf("3") > -1 ? 'class="cur""' : "") + ">胜<cite>" + (q.length > 0 ? (q[0].replace("全:", "") == "" ? "0.00" : q[0].replace("全:", "")) : "0.00") + "</cite></span>";
                    h[h.length] = "<span v='1' " + (a.indexOf("1") > -1 ? 'class="cur""' : "") + ">平<cite>" + (q.length > 0 && q.length > 1 ? q[1] : "0.00") + "</cite></span>";
                    h[h.length] = "<span v='0' " + (a.indexOf("0") > -1 ? 'class="cur""' : "") + ">负<cite>" + (q.length > 0 && q.length > 2 ? q[2] : "0.00") + "</cite></span>";
                    h[h.length] = "</div></li>";

                });

                break;
        }

        h[h.length] = "<input type='hidden' id='issues' value='" + val_.currentIss + "' />";
        localStorage.setItem(gameCode.toLowerCase() + val_.gametype.toLowerCase() + "_SelectNum", h.join(""));
        localStorage.removeItem(gameCode.toLowerCase() + val_.gametype.toLowerCase() + "_PollNum");
    }

};
var BindEvent = function () {
    //点击比赛添加背景效果   给当前上一级元素加上标记 表示选择了
    $(".ctzqT14C").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();

        if (t == "未开售") {
            return;
        } else {
            $(this).toggleClass("cur");
        }
        if ($(this).parent().find("span").hasClass("cur")) {
            var c = "";
            $(this).parent().find("span.cur").each(function () {
                c += $(this).attr("v") + ",";
            });

            c = c.substring(0, c.length - 1);
            $(this).parent().parent().parent().attr("v", "y");
            $(this).parent().parent().parent().attr("c", c);
        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c");
        }
        //自己选择了多少场比赛
        showCount();

    });
    $(".ctzqTR9").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();

        if (t == "未开售") {
            return;
        } else {
            $(this).toggleClass("cur");
        }
        if ($(this).parent().find("span").hasClass("cur")) {
            var c = "";
            $(this).parent().find("span.cur").each(function () {
                c += $(this).attr("v") + ",";
            });

            c = c.substring(0, c.length - 1);
            $(this).parent().parent().parent().attr("v", "y");
            $(this).parent().parent().parent().attr("c", c);
        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c");
        }
        //自己选择了多少场比赛
        showCount();

    });
    $(".ctzqT6BQC").find("ul.sfcxs p.spfzpk span").Touch(function () {
        $(this).toggleClass("cur");

        if ($(this).parent().parent().find("span").hasClass("cur")) {
            var c = "", b = "";
            $(this).parent().parent().find("p:eq(1) span.cur").each(function () {
                c += $(this).attr("v") + ",";
            });
            c = c.substring(0, c.length - 1);
            $(this).parent().parent().find("p:eq(2) span.cur").each(function () {
                b += $(this).attr("v") + ",";
            });
            b = b.substring(0, b.length - 1);
            if (c != "")
                $(this).parent().parent().parent().attr("c", c);
            else
                $(this).parent().parent().parent().removeAttr("c");

            if (b != "")
                $(this).parent().parent().parent().attr("b", b);
            else
                $(this).parent().parent().parent().removeAttr("b");

            $(this).parent().parent().parent().attr("v", "y");

        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c");
            $(this).parent().parent().parent().removeAttr("b");
        }
        //自己选择了多少场比赛
        showCount();

    });
    $(".ctzqT4CJQ").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        if (t == "未开售") {
            return;
        } else {
            $(this).toggleClass("cur");
        }
        if ($(this).parent().find("span").hasClass("cur")) {
            var c = "", b = "";
            $(this).parent().parent().find("p:eq(1) span.cur").each(function () {
                c += $(this).attr("v") + ",";
            });
            $(this).parent().parent().find("p:eq(2) span.cur").each(function () {
                b += $(this).attr("v") + ",";
            });


            c = c.substring(0, c.length - 1);
            b = b.substring(0, b.length - 1);

            if (c != "")
                $(this).parent().parent().parent().attr("c", c);
            else
                $(this).parent().parent().parent().removeAttr("c");
            if (b != "")
                $(this).parent().parent().parent().attr("b", b);
            else
                $(this).parent().parent().parent().removeAttr("b");

            $(this).parent().parent().parent().attr("v", "y");

        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c");
        }
        showCount();

    });
    $(".ture").Touch(function () {
        if ($(this).hasClass("true_disabled")) return false;
        ctzqpage.input_();

    });
    //比赛详情
    $(".li_weige").Touch(function () {
        $(this).find(".xzup").toggleClass("xzdown");
        $(this).parents(".sfcxs").next(".sfcpl:first").slideToggle(300);
    });
};
function showCount() {
    var count = 0, c = 0, b = 0;
    switch (type.toLowerCase()) {
        case "t6bqc":
        case "t4cjq":
            $("#content_ ul[v=y]").each(function (k, item) {
                if ($(item).attr("b"))
                    b++;
                if ($(item).attr("c"))
                    c++;
            });
            count = c + b;
            break;
        case "t14c":
        case "tr9":
            count = $("#content_ ul[v=y]").length;
            break; ;
    }
    $("#c_").html(count);
}
function bindClick() {
    //头部选项
    $(".pullDown").click(function () {
        if ($(".pullText").is(":visible")) {
            $(this).removeClass("pullHover");
            $(".pullText").hide();
        } else {
            $(this).addClass("pullHover");
            $(".pullText").show();
        }
    });
    //头部彩种
    $("#wanfa_").click(function () {
        if ($(".tzPull").is(":visible")) {
            $(this).removeClass("tzTit");
            $(".tzPull").hide();
        } else {
            $(this).addClass("tzTit");
            $(".tzPull").show();
        }
    });
    $(".deleted").click(function () {
        $("#content_ ul.sfcxs[v=y]").removeAttr("v").removeAttr("c").find(".cur").removeClass("cur");
        localStorage.removeItem(gameCode.toLowerCase() + type.toLowerCase() + "_PollNum");
        $("#c_").html(0);
    });
};

$(function () {
    ctzqpage.static_.loadMatches();
    val_.gametype = type;
    bindClick();
});