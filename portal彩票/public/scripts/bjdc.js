var PollNum = localStorage.getItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");

var ele =
{
    tbody: $("#content_"),
    PollNum_t: [],
    PollNum_c: []
};

var jcpage = {
    constant_: {
        //常量
        wk: ["日", "一", "二", "三", "四", "五", "六"],
        hhcount: [
            '客胜', '主胜',
            '让分客胜', '让分主胜',
            '大分', '小分',
            '客胜1-5', '客胜6-10', '客胜11-15', '客胜16-20', '客胜21-25', '客胜26+',
            '主胜1-5', '主胜6-10', '主胜11-15', '主胜16-20', '主胜21-25', '主胜26+'
        ],
        express: {
            bf: {
                "1:0": "10",
                "2:0": "20",
                "2:1": "21",
                "3:0": "30",
                "3:1": "31",
                "3:2": "32",
                "4:0": "40",
                "4:1": "41",
                "4:2": "42",
                "胜其他": "X0",
                "0:0": "00",
                "1:1": "11",
                "2:2": "22",
                "3:3": "33",
                "平其他": "XX",
                "0:1": "01",
                "0:2": "02",
                "1:2": "12",
                "0:3": "03",
                "1:3": "13",
                "2:3": "23",
                "0:4": "04",
                "1:4": "14",
                "2:4": "24",
                "负其他": "0X"
            },
            bqccode: { "33": "胜胜", "31": "胜平", "30": "胜负", "13": "平胜", "11": "平平", "10": "平负", "03": "负胜", "01": "负平", "00": "负负" },
            bfcode: {
                "10": "1:0", "20": "2:0", "21": "2:1", "30": "3:0", "31": "3:1", "32": "3:2", "40": "4:0", "41": "4:1", "42": "4:2", "X0": "胜其它",
                "00": "0:0", "11": "1:1", "22": "2:2", "33": "3:3", "XX": "平其他",
                "01": "0:1", "02": "0:2", "12": "1:2", "03": "0:3", "13": "1:3", "23": "2:3", "04": "0:4", "14": "1:4", "24": "2:4", "0X": "负其它"
            },
            bqc: { "胜-胜": "33", "胜-平": "31", "胜-负": "30", "平-胜": "13", "平-平": "11", "平-负": "10", "负-胜": "03", "负-平": "01", "负-负": "00" }
        }
    },
    var_: {
        spArray: "", //保存所有sp数组
        game: "",
        play: "",
        ishungg: false, //页面玩法(spf,jqs)
        isDg: false, //是否是单关
        allorsingle: false, //是点全选还是单个点--单个点击有效果，全选没有效果
        type: "", //玩法类型
        time: "", //服务器时间
        sort: [], //排序重组html
        isupload: "", //是不是先发起后上传
        object: {}, //奖金预测、投注时用到
        queryDay: "",
        curIssues: "",
        data: { match: {}, issue: {}, sp: {} },
        matchdata: { sale: {}, stop: {} },
        endTr: new Set(), //结束的比赛
        hideTr: new Set() //隐藏的比赛
    },
    static_: {
        //静态内容
        loadMatches: function () { //调取对阵函数
            try {
                ele.tbody.empty().append("<div class=\"load\" style=\"height:130px;line-height:150px;text-align:center;\"><img src=\"" + ires + "loading-b.gif\"/></div>");
                //请求比赛信息
                //var selected = ele.querySelect.attr("data-key");
                //期数列表
                var issueUrl = dres + gameCode + "/match_issusenumber_list.json";
                var allGameInfo = dres + gameCode + "/{0}/match_list.json";
                var gameSp = dres + gameCode + "/{0}/sp_{1}.json";
                var mdata = jcpage.var_.data;
                //var play=jcpage.var_.play
                $.getScript(issueUrl, function () {
                    if (typeof (data) != "undefined" && data != null && data.length > 0) {
                        var issueNumber = data.sort(function compare(a, b) {
                            return a.IssuseNumber > b.IssuseNumber ? -1 : 1;
                        });
                        mdata.issue = issueNumber;

                        //当前正在销售的期号
                        var curentissue = issueNumber[0].IssuseNumber;
                        var issue = requestIssues == "" ? issueNumber[0].IssuseNumber : requestIssues;
                        if (issue == null || issue == "") {
                            Box.alert("期号格式错误");
                            return;
                        }
                        //下拉
                        //if (selected) issue = selected;
                        jcpage.var_.curIssues = issue;
                        allGameInfo = $.format(allGameInfo, issue);
                        data = null;
                        $.getScript(allGameInfo, function () {
                            if (data != null && typeof (data) != "undefined" && data.length > 0) {
                                mdata.match = data;
                                gameSp = $.format(gameSp, issue, play);
                                data = null;
                                $.getScript(gameSp, function () {
                                    if (data != null && typeof (data) != "undefined" && data.length > 0) {
                                        mdata.sp = data;
                                        jcpage.static_.dealMatchData();
                                        jcpage.dymanic_.startMatch();
                                    }
                                });
                            }
                        });
                    }
                });
            } catch (e) {
                Box.alert(e);
            }
        },
        dealMatchData: function () {
            var data = jcpage.var_.data.match;
            if (data.length == 0 || !data) return;
            var t, startDateTimes = [], leagues = new Set();
            //队伍排序
            data.sort(function compare(a, b) {
                return a.MatchOrderId < b.MatchOrderId ? -1 : 1;
            });
            //筛选出开始时间大于当前时间
            $.each(data, function (index, item) {
                t = stringToDateTime(item.MatchStartTime);
                if (t > servertime) {
                    startDateTimes.push(t);
                    //联盟信息
                    if (!leagues.contain(item.MatchName)) {
                        leagues.push(item.MatchName);
                    }
                }
            });
            if (startDateTimes.length == 0) {
                ele.tbody.find(".load").html("暂无对阵");
                return;
            }

            jcpage.var_.data.match = data;
        },
        staticHtml: {
            header: function (date) {
                var play = jcpage.var_.play.toLowerCase();
                var h = "", d = date.toFormatString("MM-dd"), week = jcpage.constant_.wk[date.getDay()];
                //if (date.toFormatString("yyyyMMdd") >= servertime.toFormatString("yyyyMMdd")) {
                    if (play != null && play == "spf" && gameCode == "bjdc") {
                        h = "<section class=\"bjdcSpf\">";
                    } else if (play != null && play == "zjq" && gameCode == "bjdc") {
                        h = "<section class=\"bjdcZjq\">";
                    } else if (play != null && play == "sxds" && gameCode == "bjdc") {
                        h = "<section class=\"bjdcSxds\">";
                    } else if (play != null && play == "bf" && gameCode == "bjdc") {
                        h = "<section class=\"bjdcBf\">";
                    } else if (play != null && play == "bqc" && gameCode == "bjdc") {
                        h = "<section class=\"bjdcBqc\">";
                    } else {
                        h = "<section>";
                    }

                    h += "<div class=\"sfcTitle\">";
                    h += d + " 周" + week + "(10:00-次日10:00)";
                    h += "<em class=\"up\"></em>";
                    h += "</div><div>";
                //}

                return h;
            },
            sp: function (id, sp) {
                return "<td id=\"" + id + "\" class=\"p\"><a class=\"bet\" href=\"javascript:\"><span>" + fix(sp) + "</span><em class=\"tip\"></em><sup></sup></a></td>";
            },
            bf: function (width, id, type, sp, rel) {
                return '<td width="' + width + '" class="p" id="' + id + '" rel="' + rel + '"><a class="bet"><em>' + type + '</em><span class="sp">' + fix(sp) + '</span><em class="tip"></em></a></td>';
            },
            getLeagueHref: function (leaugeid, fxid) {
                if (leaugeid == 0 || fxid == 0) {
                    return "javascript:void(0)";
                }
                return "/info/?zsurl=/league/index/" + leaugeid + "/" + fxid;
            },
            getTeamHref: function (teamid) {
                if (teamid == 0) {
                    return "javascript:void(0)";
                } else {
                    return "/info?zsurl=/team/index/" + teamid;
                }
            },
            getyxo: function (fxid, matchdata, matchnumber) {
                var href = "<td class=\"datas\">";
                if (fxid == 0) {
                    href += "<a target=\"_blank\" href=\"javascript:void(0)\">亚</a><a target=\"_blank\" href=\"javascript:void(0)\">欧</a><a target=\"_blank\" href=\"javascript:void(0)\">析</a>";
                } else {
                    href += "<a target=\"_blank\" href=\"/odds?zsurl=/match/asia/" + fxid + "\">亚</a><a target=\"_blank\" href=\"/odds?zsurl=/match/odds/" + fxid + "\">欧</a><a target=\"_blank\" href=\"/odds?zsurl=/match/analysis/" + fxid + "\">析</a>";
                }
                return href;
            },
            getbfEx: function () {
                var bf = {};
                for (var i = 14; i <= 45; i++) {
                    if (i == 26) {
                        bf[i] = "X0";
                    } else if (i == 31) {
                        bf[i] = "XX";
                    } else if (i == 44) {
                        bf[i] = "0X";
                    } else {
                        bf[i] = jcpage.constant_.hhcount[i].replace(":", "");
                    }
                }
                jcpage.constant_.express.bf = bf;
            }
        },
        checkSp: function (arr) {
            if (arr == null) return true;
            for (var i in arr) {
                if (typeof (arr[i]) == "function") break;
                if (parseFloat(arr[i]) <= 0) return true; ;
            }
            return false;
        }
    },
    dymanic_: {
        //动态内容
        startMatch: function () {
            if (jcpage.var_.game.toLowerCase() == "bjdc") {
                var data = jcpage.var_.data.match;
                var h = [];
                if (PollNum) {
                    var PollNum1 = PollNum.split("|")[0].split(",");
                    for (var n = 0; n < PollNum1.length; n++) {
                        ele.PollNum_t[n] = PollNum1[n].split("=")[0];
                        ele.PollNum_c[n] = PollNum1[n].split("=")[1];
                    }
                }
                if (data.length > 0) {
                    var endTime = stringToDateTime(data[0].MatchStartTime);
                    if (endTime.getHours() < 10) {
                        endTime = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate());
                        endTime.setHours(endTime.getHours() + 10);
                    } else {
                        endTime.setDate(endTime.getDate() + 1);
                        endTime = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate());
                        endTime.setHours(endTime.getHours() + 10);
                    }
                    var sh = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate() - 1);
                    //开始组合
                    var week = jcpage.constant_.wk[sh.getDay()];
                    h[h.length] = jcpage.static_.staticHtml.header(sh, week);
                    var func = jcpage.dymanic_.html[jcpage.var_.play.toUpperCase()];
                    for (var i = 0, il = data.length; i < il; i++) {
                        if (stringToDateTime(data[i].MatchStartTime) >= endTime) {
                            endTime.setDate(endTime.getDate() + 1);
                            sh = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate() - 1);
                            //上一个table结束
                            h[h.length] = "</div></section>";
                            week = jcpage.constant_.wk[sh.getDay()];
                            //开始新的table
                            h[h.length] = jcpage.static_.staticHtml.header(sh, week);
                        }
                        //分离出已经停止的比赛
                        if (stringToDateTime(data[i].LocalStopTime) > servertime && data[i].MatchStateName != "Cancel" && data[i].MatchStateName != "Late") {
                            h[h.length] = func(data[i], endTime, 1, i, week);
                        }
                        /*else {
                            jcpage.var_.endTr.push(data[i].MatchOrderId);
                            jcpage.var_.hideTr.push(data[i].MatchOrderId);
                            h[h.length] = func(data[i], endTime, 0, i, week);
                        }*/
                    }
                    ele.tbody.html(h.join(""));
                    BindEvent();
                    my_play();
                }
            }
        },
        //动态拼接html
        html: {
            commonHtml: function (item, endTime, sale, i, week) {
                var h = "", d = stringToDateTime(item.MatchStartTime);
                var play = jcpage.var_.play.toLowerCase();
                if (play == "spf" || play == "bf") {
                    h += "<li class=\"li_weige\">";
                    h += "<em>" + item.MatchOrderId + "</em>";
                    h += "<p style=\"color:#FF6699\">" + item.MatchName + "</p>";
                    h += "<cite>" + d.toFormatString("HH:mm") + "</cite><i class=\"xzup xzdown\"></i></li>";
                } else {
                    h += "<li class=\"li_weige\">";
                    h += "<em>" + item.MatchOrderId + "</em>";
                    h += "<p style=\"color:#FF6699\">" + item.MatchName + "</p>";
                    h += "<cite>" + d.toFormatString("HH:mm") + "</cite></li>";
                }
                return h;
            },
            //胜平负
            SPF: function (item, stoptime, sale, i, week) {

                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, week), matchid = item.MatchOrderId.toString(), html = jcpage.static_.staticHtml;
                var pc = "";
                //让球
                var d = item.LetBall;
                var arr = jQuery.grep(vari.data.sp, function (it, idx) {
                    return (it.MatchOrderId == item.MatchOrderId);
                });

                if (arr[0]) {
                    var spf = arr[0];
                    if (PollNum && $.inArray(matchid, ele.PollNum_t) > -1) {
                        pc = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        h += '<ul class="sfcxs" t="' + matchid + '" v="y" c="' + pc.replace(/\//g, ",") + '">';
                    } else {
                        h += '<ul class="sfcxs" t="' + matchid + '">';
                    }
                    h += str;
                    h += "<li><p class=\"spfzpk spfzpk2\">";
                    if (pc != "") {
                        h += "<span sp=\"" + (spf != null && spf.Win_Odds != "" ? spf.Win_Odds : "--") + "\" v=\"3\" " + (pc.indexOf("3") >= 0 ? 'class="cur"' : "") + "><em>" + item.HomeTeamName + "<i class=\"" + (d > 0 ? "dc_red" : d < 0 ? "dc_blue" : "") + "\">(" + (d != 0 ? (d > 0 ? "+" + d : d) : "0") + ")</i></em><cite>胜</cite></span>";
                        h += "<span sp=\"" + (spf != null && spf.Flat_Odds != "" ? spf.Flat_Odds : "未开售") + "\" v=\"1\" class=\"spfvs " + (pc.indexOf("1") >= 0 ? "cur" : "") + "\"><em>VS</em><cite>平</cite></span>";
                        h += "<span sp=\"" + (spf != null && spf.Lose_Odds != "" ? spf.Lose_Odds : "--") + "\" v=\"0\" " + (pc.indexOf("0") >= 0 ? 'class="cur"' : "") + "><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                    } else {
                        h += "<span sp=\"" + (spf != null && spf.Win_Odds != "" ? spf.Win_Odds : "--") + "\" v=\"3\" ><em>" + item.HomeTeamName + "<i class=\"" + (d > 0 ? "dc_red" : d < 0 ? "dc_blue" : "") + "\">(" + (d != 0 ? (d > 0 ? "+" + d : d) : "0") + ")</i></em><cite>胜</cite></span>";
                        h += "<span sp=\"" + (spf != null && spf.Flat_Odds != "" ? spf.Flat_Odds : "未开售") + "\" v=\"1\" class=\"spfvs\"><em>VS</em><cite>平</cite></span>";
                        h += "<span sp=\"" + (spf != null && spf.Lose_Odds != "" ? spf.Lose_Odds : "--") + "\" v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                    }
                    h += "</p><p class=\"spfpl\">";
                    h += "<span>赔率" + spf.Win_Odds + "</span><span class=\"spfvs\">赔率" + spf.Flat_Odds + "</span><span>赔率" + spf.Lose_Odds + "</span>";
                }
                h += "</p></li></ul>";
                h += "<div class=\"sfcpl\" style=\"display:none;\">";
                h += "<dl><dt>平均赔率</dt><dd>" + fix(item.WinOdds, 2) + "</dd><dd>" + fix(item.FlatOdds, 2) + "</dd><dd>" + fix(item.LoseOdds, 2) + "</dd></dl>";
                h += "</div>";
                return h;
            },
            //总进球
            ZJQ: function (item, stoptime, sale, i, week) {
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, week), matchid = item.MatchOrderId.toString();
                var arr = jQuery.grep(vari.data.sp, function (it, idx) {
                    return (it.MatchOrderId == item.MatchOrderId);
                });
                var pc = "";
                if (PollNum && ele.PollNum_t.indexOf(matchid) >= 0) {
                    pc = ele.PollNum_c[ele.PollNum_t.indexOf(matchid)];
                    h += '<ul class="sfcxs jqzpk" t="' + matchid + '" v="y" c="' + pc.replace(/\//g, ",") + '">';
                } else {
                    h += '<ul class="sfcxs jqzpk" t="' + matchid + '">';
                }
                h += str;
                h += "<li><p class=\"spfzpkNum\">";
                h += "<span>" + item.HomeTeamName + "</span>";
                h += "<span class=\"spfvs\">VS</span>";
                h += "<span>" + item.GuestTeamName + "</span>";
                h += "</p><p class=\"spfzpk\">";
                if (arr[0]) {
                    var zjq = arr[0];
                    if (pc != "") {
                        for (i = 0; i <= 7; i++) {
                            h += "<span " + (pc.indexOf(i) > -1 ? "class='cur'" : "") + "  v=" + i + " sp='" + fix(zjq["JinQiu_" + i + "_Odds"]) + "'><b>" + i + "</b><cite>" + fix(zjq["JinQiu_" + i + "_Odds"]) + "</cite></span>";
                        }
                    } else {
                        for (i = 0; i <= 7; i++) {
                            h += "<span v=" + i + " sp='" + fix(zjq["JinQiu_" + i + "_Odds"]) + "'><b>" + i + "</b><cite>" + fix(zjq["JinQiu_" + i + "_Odds"]) + "</cite></span>";
                        }
                    }

                }

                h += "</p></li></ul>";
                return h;
            },
            //上下单双
            SXDS: function (item, stoptime, sale, i, week) {
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, week), matchid = item.MatchOrderId.toString(), pc = "";
                var arr = jQuery.grep(vari.data.sp, function (it, idx) {
                    return (it.MatchOrderId == item.MatchOrderId);
                });
                if (PollNum && ele.PollNum_t.indexOf(matchid) >= 0) {
                    pc = ele.PollNum_c[ele.PollNum_t.indexOf(matchid)];
                    h += '<ul class="sfcxs jqNum" t="' + matchid + '" v="y" c="' + pc.replace(/\//g, "") + '">';
                } else {
                    h += '<ul class="sfcxs jqNum" t="' + matchid + '">';
                }
                //h += "<ul class=\"sfcxs jqNum\">";
                h += str;
                h += "<li><p class=\"spfzpkNum\">";
                h += "<span>" + item.HomeTeamName + "</span>";
                h += "<span class=\"spfvs\">VS</span>";
                h += "<span>" + item.GuestTeamName + "</span>";
                h += "</p><p class=\"spfzpk\">";
                if (arr[0]) {
                    var sxds = arr[0];
                    h += "<span v=\"SD\" sp='" + fix(sxds.SH_D_Odds) + "' " + (pc != "" && pc.indexOf("SD") > -1 ? "class='cur'" : "") + "><b>上单</b><cite>" + fix(sxds.SH_D_Odds) + "</cite></span>";
                    h += "<span v=\"SS\" sp='" + fix(sxds.SH_S_Odds) + "'" + (pc != "" && pc.indexOf("SS") > -1 ? "class='cur'" : "") + "><b>上双</b><cite>" + fix(sxds.SH_S_Odds) + "</cite></span>";
                    h += "<span v=\"XD\" sp='" + fix(sxds.X_D_Odds) + "'" + (pc != "" && pc.indexOf("XD") > -1 ? "class='cur'" : "") + "><b>下单</b><cite>" + fix(sxds.X_D_Odds) + "</cite></span>";
                    h += "<span v=\"XS\" sp='" + fix(sxds.X_S_Odds) + "'" + (pc != "" && pc.indexOf("XS") > -1 ? "class='cur'" : "") + "><b>下双</b><cite>" + fix(sxds.X_S_Odds) + "</cite></span>";
                }
                h += "</p></li></ul>";
                return h;
            },
            //比分
            BF: function (item, stoptime, sale, i, week) {
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, week), matchid = item.MatchOrderId.toString(), p = "", code = "";
                var arr = jQuery.grep(vari.data.sp, function (it, idx) {
                    return (it.MatchOrderId == matchid);
                });
                if (arr[0]) {
                    var bf = arr[0];
                    if (PollNum != "" && $.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        var c = p.split('/');
                        if (c.length > 5) {
                            code += "已选" + c.length + "项";
                        }
                        $.each(c, function (k, v) {
                            var v1 = v.substring(0, v.length - 1);
                            var v2 = v.substring(v.length - 1, v.length);
                            var z = "";
                            if (v == "X0" || Number(v1) > Number(v2))
                                z = "S_" + (v == "X0" ? "QT" : v);
                            else if (v == "XX" || Number(v1) == Number(v2))
                                z = "P_" + (v == "XX" ? "QT" : v);
                            else if (v == "0X" || Number(v1) < Number(v2))
                                z = "F_" + (v == "0X" ? "QT" : v);
                            code += "<cite " + (c.length > 5 ? 'style="display:none"' : "") + " sp='" + bf[z] + "' v='" + v + "'" + (v == "X0" || v == "0X" || v == "XX" ? 'class="sqt"' : "") + ">" + jcpage.constant_.express.bfcode[v] + "</cite>";
                        });


                        h += "<ul class=\"sfcxs\" t='" + matchid + "' v='y' c='" + p.replace(/\//g, ",") + "' >";
                    } else {
                        h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                    }

                    h += str;
                    h += "<li><p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "</p><p class=\"spfzpk bfpk\">";

                    h += "<span " + (code != "" ? "class='cur'" : "") + ">" + (code != "" ? code : "立即投注") + "</span>";

                    h += "</p></li></ul>";
                    h += "<div class=\"sfcpl\" style=\"display:none;\">";
                    h += "<dl><dt>平均赔率</dt><dd>" + fix(item.WinOdds, 2) + "</dd><dd>" + fix(item.FlatOdds, 2) + "</dd><dd>" + fix(item.LoseOdds, 2) + "</dd></dl>";
                    h += "</div>";
                    h += "<div style=\"margin-top: -180px; display:none;\" class=\"bfPop bf_\" " + (p != "" ? "a='c'" : "") + ">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "<span class=\"right\"><em>V</em></span></p>";
                    h += "<p><span class=\"left\"><em>S</em></span>" + item.GuestTeamName + "</p>";
                    h += "</div>";
                    h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">" + item.HomeTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";


                    h += "<span v=\"1:0\" " + (p.indexOf("10") > -1 ? "class=cur" : "") + "><strong>1:0</strong><em>" + bf.S_10 + "</em></span>";
                    h += "<span v=\"2:0\" " + (p.indexOf("20") > -1 ? "class=cur" : "") + "><strong>2:0</strong><em>" + bf.S_20 + "</em></span>";
                    h += "<span v=\"2:1\" " + (p.indexOf("21") > -1 ? "class=cur" : "") + "><strong>2:1</strong><em>" + bf.S_21 + "</em></span>";
                    h += "<span v=\"3:0\" " + (p.indexOf("30") > -1 ? "class=cur" : "") + "><strong>3:0</strong><em>" + bf.S_30 + "</em></span>";
                    h += "<span v=\"3:1\" " + (p.indexOf("31") > -1 ? "class=cur" : "") + "><strong>3:1</strong><em>" + bf.S_31 + "</em></span>";
                    h += "<span v=\"3:2\" " + (p.indexOf("32") > -1 ? "class=cur" : "") + "><strong>3:2</strong><em>" + bf.S_32 + "</em></span>";
                    h += "<span v=\"4:0\" " + (p.indexOf("40") > -1 ? "class=cur" : "") + "><strong>4:0</strong><em>" + bf.S_40 + "</em></span>";
                    h += "<span v=\"4:1\" " + (p.indexOf("41") > -1 ? "class=cur" : "") + "><strong>4:1</strong><em>" + bf.S_41 + "</em></span>";
                    h += "<span v=\"4:2\" " + (p.indexOf("42") > -1 ? "class=cur" : "") + "><strong>4:2</strong><em>" + bf.S_42 + "</em></span>";
                    h += "<span v=\"X:0\" class=\"bflast " + (p.indexOf("X0") > -1 ? "cur" : "") + "\"><strong>胜其它</strong><em>" + bf.S_QT + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">打平</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span v=\"0:0\" " + (p.indexOf("00") > -1 ? "class=cur" : "") + "><strong>0:0</strong><em>" + bf.P_00 + "</em></span>";
                    h += "<span v=\"1:1\" " + (p.indexOf("11") > -1 ? "class=cur" : "") + "><strong>1:1</strong><em>" + bf.P_11 + "</em></span>";
                    h += "<span v=\"2:2\" " + (p.indexOf("22") > -1 ? "class=cur" : "") + "><strong>2:2</strong><em>" + bf.P_22 + "</em></span>";
                    h += "<span v=\"3:3\" " + (p.indexOf("33") > -1 ? "class=cur" : "") + "><strong>3:3</strong><em>" + bf.P_33 + "</em></span>";
                    h += "<span v=\"X:X\" class=\"bflast " + (p.indexOf("XX") > -1 ? "cur" : "") + "\"><strong>平其它</strong><em>" + bf.P_QT + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">" + item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span v=\"0:1\" " + (p.indexOf("01") > -1 ? "class=cur" : "") + "><strong>0:1</strong><em>" + bf.F_01 + "</em></span>";
                    h += "<span v=\"0:2\" " + (p.indexOf("02") > -1 ? "class=cur" : "") + "><strong>0:2</strong><em>" + bf.F_02 + "</em></span>";
                    h += "<span v=\"1:2\" " + (p.indexOf("12") > -1 ? "class=cur" : "") + "><strong>1:2</strong><em>" + bf.F_12 + "</em></span>";
                    h += "<span v=\"0:3\" " + (p.indexOf("03") > -1 ? "class=cur" : "") + "><strong>0:3</strong><em>" + bf.F_03 + "</em></span>";
                    h += "<span v=\"1:3\" " + (p.indexOf("13") > -1 ? "class=cur" : "") + "><strong>1:3</strong><em>" + bf.F_13 + "</em></span>";
                    h += "<span v=\"2:3\" " + (p.indexOf("23") > -1 ? "class=cur" : "") + "><strong>2:3</strong><em>" + bf.F_23 + "</em></span>";
                    h += "<span v=\"0:4\" " + (p.indexOf("04") > -1 ? "class=cur" : "") + "><strong>0:4</strong><em>" + bf.F_04 + "</em></span>";
                    h += "<span v=\"1:4\" " + (p.indexOf("14") > -1 ? "class=cur" : "") + "><strong>1:4</strong><em>" + bf.F_14 + "</em></span>";
                    h += "<span v=\"2:4\" " + (p.indexOf("24") > -1 ? "class=cur" : "") + "><strong>2:4</strong><em>" + bf.F_24 + "</em></span>";
                    h += "<span v=\"0:X\" class=\"bflast " + (p.indexOf("0X") > -1 ? "cur" : "") + "\"><strong>负其它</strong><em>" + bf.F_QT + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\" href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div></div>";
                }

                return h;
            },
            //半全场
            BQC: function (item, stoptime, sale) {
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchOrderId.toString(), p = "", code = "";
                var arr = jQuery.grep(vari.data.sp, function (it, idx) {
                    return (it.MatchOrderId == matchid);
                });
                if (arr[0]) {
                    var bqc = arr[0];
                    if (PollNum != "" && $.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        var c = p.split('/');
                        if (c.length > 5) {
                            code += "已选" + c.length + "项";

                        }
                        $.each(c, function (k, v) {
                            var v1 = v.substring(0, v.length - 1);
                            var v2 = v.substring(v.length - 1, v.length);
                            var z = "";
                            var v3 = { "3": "SH", "1": "P", "0": "F" };
                            z = v3[v1] + "_" + v3[v2] + "_Odds";
                            code += "<cite " + (c.length > 5 ? 'style="display:none"' : "") + " sp='" + bqc[z] + "' v='" + v + "'>" + jcpage.constant_.express.bqccode[v] + "</cite>";
                        });
                        h += "<ul class=\"sfcxs\" t='" + matchid + "' v='y' c='" + p.replace(/\//g, ",") + "'>";
                    } else {
                        h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                    }

                    h += str;
                    h += "<li><p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "</p><p class=\"spfzpk bfpk\">";
                    h += "<span " + (code != "" ? "class='cur'" : "") + ">" + (code != "" ? code : "立即投注") + "</span>";
                    h += "</p></li></ul>";
                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop bqc_\"" + (p != "" ? "a='c'" : "") + ">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "<span class=\"right\"><em>V</em></span></p>";
                    h += "<p><span class=\"left\"><em>S</em></span>" + item.GuestTeamName + "</p>";
                    h += "</div>";
                    h += "<p>[例] 胜负：上半场主胜 且 全场主负</p>";
                    h += "<div class=\"competitions bfcom\">";

                    h += "<span v='33' sp='" + fix(bqc.SH_SH_Odds) + "'" + (p.indexOf("33") > -1 ? "class='cur'" : "") + "><strong>胜:胜</strong><em>" + fix(bqc.SH_SH_Odds) + "</em></span>";
                    h += "<span v='31' sp='" + fix(bqc.SH_P_Odds) + "'" + (p.indexOf("31") > -1 ? "class='cur'" : "") + " ><strong>胜:平</strong><em>" + fix(bqc.SH_P_Odds) + "</em></span>";
                    h += "<span v='30' sp='" + fix(bqc.SH_F_Odds) + "'" + (p.indexOf("30") > -1 ? "class='cur'" : "") + "><strong>胜:负</strong><em>" + fix(bqc.SH_F_Odds) + "</em></span>";
                    h += "<span v='13' sp='" + fix(bqc.P_SH_Odds) + "'" + (p.indexOf("13") > -1 ? "class='cur'" : "") + "><strong>平:胜</strong><em>" + fix(bqc.P_SH_Odds) + "</em></span>";
                    h += "<span v='11' sp='" + fix(bqc.P_P_Odds) + "'" + (p.indexOf("11") > -1 ? "class='cur'" : "") + "><strong>平:平</strong><em>" + fix(bqc.P_P_Odds) + "</em></span>";
                    h += "<span v='10' sp='" + fix(bqc.P_F_Odds) + "'" + (p.indexOf("10") > -1 ? "class='cur'" : "") + "><strong>平:负</strong><em>" + fix(bqc.P_F_Odds) + "</em></span>";
                    h += "<span v='03' sp='" + fix(bqc.F_SH_Odds) + "'" + (p.indexOf("03") > -1 ? "class='cur'" : "") + "><strong>负:胜</strong><em>" + fix(bqc.F_SH_Odds) + "</em></span>";
                    h += "<span v='01' sp='" + fix(bqc.F_P_Odds) + "'" + (p.indexOf("01") > -1 ? "class='cur'" : "") + "><strong>负:平</strong><em>" + fix(bqc.F_P_Odds) + "</em></span>";
                    h += "<span v='00' sp='" + fix(bqc.F_F_Odds) + "'" + (p.indexOf("00") > -1 ? "class='cur'" : "") + "><strong>负:负</strong><em>" + fix(bqc.F_F_Odds) + "</em></span>";
                    h += "<div class=\"clear\"></div>";

                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\" href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div></div>";
                }
                return h;
            }
        },
        //传递到右侧投注单中
        orderList: function (obj) {
            var list = ele.selectTb,
                listid = list.find("#id_" + obj.id).length,
                idx = Number(obj.id),
                lose = obj.lose;
            if (listid == 0) {
                var h = [];
                h[h.length] = '<tr id="id_' + idx + '" abbr="' + idx + '" date="' + obj.ft + '" class="list_tr">';
                h[h.length] = '<td class="show"><p><span>' + obj.week + '</span><s title="删除" class="del">删除</s></td>';
                if (obj.play == "SPF" || obj.play == "ZJQ" || obj.play == "SXDS" || obj.play == "BF" || obj.play == "BQC") {
                    if (obj.play == "SPF") {
                        h[h.length] = '<td>' + obj.host.slice(0, 3) + 'vs' + obj.visit.slice(0, 3) + '</td>';
                        h[h.length] = '<td><div class="code_list code_list_ot">';
                        h[h.length] = '<a style="display:none;" id="b_' + idx + '_spf_3">胜</a><a style="display:none;" id="b_' + idx + '_spf_1">平</a><a style="display:none;" id="b_' + idx + '_spf_0">负</a>';
                    } else if (obj.play == "ZJQ") {
                        h[h.length] = '<td>' + obj.host.slice(0, 4) + '</td>';
                        h[h.length] = '<td><div class="code_list code_list_ot">';
                        for (var k = 0; k < 8; k++) {
                            h[h.length] = "<a style=\"display:none;\" id=\"b_" + idx + "_zjq_" + k + "\">" + (k == 7 ? "7+" : k) + "</a>";
                        }
                    } else if (obj.play == "SXDS") {
                        h[h.length] = '<td>' + obj.host.slice(0, 4) + '</td>';
                        h[h.length] = '<td><div class="code_list code_list_ot">';
                        h[h.length] = '<a style="display:none;" id="b_' + idx + '_sxds_SD">上单</a><a style="display:none;" id="b_' + idx + '_sxds_SS">上双</a><a style="display:none;" id="b_' + idx + '_sxds_XD">下单</a><a style="display:none;" id="b_' + idx + '_sxds_XS">下双</a>';
                    } else if (obj.play == "BF") {
                        h[h.length] = '<td>' + obj.host.slice(0, 4) + '</td>';
                        h[h.length] = '<td><div class="code_list code_list_ot">';
                        var bf = jcpage.constant_.express.bf;
                        for (k in bf) {
                            if (typeof (bf[k]) == "function") break;
                            h[h.length] = '<a style="display:none;" id="b_' + idx + '_bf_' + bf[k] + '">' + k + '</a>';
                        }
                    } else if (obj.play == "BQC") {
                        h[h.length] = '<td>' + obj.host.slice(0, 4) + '</td>';
                        h[h.length] = '<td><div class="code_list code_list_ot">';
                        var bqc = jcpage.constant_.express.bqc;
                        for (k in bqc) {
                            if (typeof (bqc[k]) == "function") break;
                            h[h.length] = '<a style="display:none;" id="b_' + idx + '_bqc_' + bqc[k] + '">' + k + '</a>';
                        }
                    }
                    h[h.length] = '</div></td><td><input type="checkbox" name="dans" onclick="jcpage.dymanic_.danAndChuan();jcpage.dymanic_.count.main()"></td>';
                    h[h.length] = '</tr>';
                }
                var html = h.join("");
                if (list.find('.list_tr').length == 0 || idx > Number($(".list_tr:last").attr("abbr") || 0)) {
                    list.append(html);
                } else {
                    list.find(".list_tr").each(function () {
                        if (idx < Number($(this).attr("abbr") || 0)) {
                            $(this).before(html);
                            return false;
                        }
                    });
                }
            }
            var b = $("#b_" + idx + "_" + obj.flag + "_" + obj.select);
            if (b) {
                b.toggle().toggleClass("n");
            }
            jcpage.dymanic_.checkOrder();
        }
    }

};

var BindEvent = function () {
    //点击比赛添加背景效果   给当前上一级元素加上标记 表示选择了
    $(".bjdcSpf").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 15;
        if (c_ >= n_ && !$(this).parent().find(".cur").length) {
            Box.alert("最多选" + n_ + "场");
            return;
        }

        if (t == "未开售") {
            return;
        }

        $(this).toggleClass("cur");
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
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        $("#c_").html(c_);

    });
    $(".bjdcZjq").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 15;
        if (c_ >= n_ && !$(this).parent().find(".cur").length) {
            Box.alert("最多选" + n_ + "场");
            return;
        }

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
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        $("#c_").html(c_);

    });
    $(".bjdcSxds").find("ul.sfcxs p.spfzpk span").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 15;
        if (c_ >= n_ && !$(this).parent().find(".cur").length) {
            Box.alert("最多选" + n_ + "场");
            return
        }

        if (t == "未开售") {
            return
        } else {
            $(this).toggleClass("cur")
        }
        if ($(this).parent().find("span").hasClass("cur")) {
            var c = "";
            $(this).parent().find("span.cur").each(function () {
                c += $(this).attr("v") + ","
            });

            c = c.substring(0, c.length - 1);
            $(this).parent().parent().parent().attr("v", "y");
            $(this).parent().parent().parent().attr("c", c)
        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c")
        }
        //自己选择了多少场比赛
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        $("#c_").html(c_);

    });
    //弹出遮罩  并显示对应数据
    //比分
    $(".bjdcBf").find("ul.sfcxs p.spfzpk span").Touch(function () {
        $(".zhezhao").show();
        $(this).closest(".sfcxs").nextAll("[class$='bf_']:first").show();
    });
    $(".bjdcBf .bf_ div.competitions span").Touch(function () {
        $(this).toggleClass("cur");
        publick_bf($(this).parent().parent());
    });
    //取消
    $("section[class='bjdcBf'] [class*='_']").find("a.zfqx").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
        $(this).parent().parent().find(".cur").removeClass("cur");
        publick_bf($(this).parent().parent());

    });
    $("section[class='bjdcBf'] [class*='_']").find("a.zfqr").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
    });
    //半全场
    $(".bjdcBqc").find("ul.sfcxs p.spfzpk span").Touch(function () {
        $(".zhezhao").show();
        $(this).closest(".sfcxs").nextAll("[class$='bqc_']:first").show();
    });
    $(".bjdcBqc .bqc_ div.competitions span").Touch(function () {
        $(this).toggleClass("cur");
        publick_bqc($(this).parent().parent());
    });
    //取消
    $("section[class='bjdcBqc'] [class*='_']").find("a.zfqx").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
        $(this).parent().parent().find(".cur").removeClass("cur");
        publick_bqc($(this).parent().parent());

    });
    $("section[class='bjdcBqc'] [class*='_']").find("a.zfqr").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
    });


    //比赛详情
    $(".li_weige").Touch(function () {
        $(this).find(".xzup").toggleClass("xzdown");
        $(this).parents(".sfcxs").next(".sfcpl:first").slideToggle(300);
    });
    //显示隐藏赔率
    $(".sfcTitle").Touch(function () {
        $(this).find(".up").toggleClass("down");
        $(this).next().slideToggle(300);
    });
};


function publick_bf(obj) {
    var l = obj.find("span.cur").length;
    var n = 5, m = "", c = "", k = "";
    if (l) {
        obj.attr("a", "c");
        obj.prevAll("ul.sfcxs:first").attr("v", "y");
        if (l > n) {
            m += "已选" + l + "项";
        }
        obj.find("span.cur").each(function () {
            var sp = $(this).find("em").html();
            var s = $(this).find("strong").html();
            k = {
                "胜其它": "X0",
                "平其它": "XX",
                "负其它": "0X"
            }[s] || s;
            m += "<cite  " + (l > n ? 'style="display:none"' : "") + "  " + (s == "胜其它" || s == "负其它" || s == "平其它" ? 'class="sqt"' : "") + " sp='" + sp + "' v=" + k.replace(":", "") + ">" + s + "</cite>";
            c += k.replace(":", "") + ",";
        });
        obj.prevAll("ul.sfcxs:first").attr("c", c.substring(0, c.length - 1));
        obj.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span").addClass("cur");
        obj.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span").html(m);
    } else {
        obj.removeAttr("a");
        obj.prevAll("ul.sfcxs:first").removeAttr("v").removeAttr("c").find("li:eq(1) p:eq(1) span.cur").removeClass("cur").html("立即投注");
    }
    my_play();
}
function publick_bqc(obj) {
    var l = obj.find("span.cur").length;
    var n = 5, m = "", c = "", k = "";
    if (l) {
        obj.attr("a", "c");
        obj.prevAll("ul.sfcxs:first").attr("v", "y");
        if (l > 5) {
            m += "已选" + l + "项";
        }
        obj.find("span.cur").each(function () {
            var sp = $(this).attr("sp");
            var v = $(this).attr("v");
            var h = $(this).find("strong").html();
            m += "<cite " + (l > n ? 'style="display:none"' : "") + " sp='" + sp + "' v='" + v + "'>" + h.replace(":", "") + "</cite>";
            k = {
                "胜胜": "33",
                "胜平": "31",
                "胜负": "30",
                "平胜": "13",
                "平平": "11",
                "平负": "10",
                "负胜": "03",
                "负平": "01",
                "负负": "00"
            }[h.replace(":", "")] || h;
            c += k + ",";
        });
        obj.prevAll("ul.sfcxs:first").attr("c", c.substring(0, c.length - 1));
        obj.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span").addClass("cur");
        obj.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span").html(m);

    }
    else {
        obj.removeAttr("a");
        obj.prevAll("ul.sfcxs:first").removeAttr("v").removeAttr("c").find("li:eq(1) p:eq(1) span.cur").removeClass("cur").html("立即投注");
    }
    my_play();
}
//自己选择了多少场比赛
function my_play() {
    var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
    $("#c_").html(c_);
};
function bindClick() {
    //清空
    $(".deleted").Touch(function () {
        if (play.toLowerCase() == "bf" || play.toLowerCase() == "bqc") {
            $("#content_ ul.sfcxs[v=y]").find("span.cur").removeClass("cur").html("立即投注");
            $("#content_ ul.sfcxs[v=y]").nextAll("div.bfPop:first").removeAttr("a").find("span.cur").removeClass("cur");
        }
        localStorage.removeItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
        $("#content_ ul.sfcxs[v=y]").removeAttr("v").removeAttr("c").find(".cur").removeClass("cur");
        $("#c_").html(0);
    });
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
    //订单提交
    $(".ture").Touch(function () {
        if ($(this).hasClass("true_disabled")) return;
        var h = [];
        var count = parseInt($("#c_").html());
        if (count <= 0) {
            Box.tx("请至少选择1场比赛");
            return;
        }
        switch (play.toLowerCase()) {
            case "spf":
                $("#content_  ul[v=y]").each(function () {
                    var c = $(this).attr("c");
                    var t = $(this).attr("t");
                    var a = $(this).find("li:eq(1) p:eq(0)").html();
                    var b = $(this).find("li:eq(1) p:eq(1)").html();
                    h[h.length] = "<li v=\"y\" c='" + c + "' t='" + t + "'>";
                    h[h.length] = "<cite class=\"errorBg\"><em class=\"error2\"></em></cite>";
                    h[h.length] = "<div class=\"spfzpk spfzpk2\">";
                    h[h.length] = a;
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"spfpl bjdcspfpl\">";
                    h[h.length] = b;
                    h[h.length] = "</div>";
                    h[h.length] = "</li>";
                });
                break;
            case "zjq":
            case "sxds":
                $("#content_  ul[v=y]").each(function () {
                    var c = $(this).attr("c");
                    var t = $(this).attr("t");
                    var a = $(this).find("li:eq(1) p:eq(0)").html();
                    var b = $(this).find("li:eq(1) p:eq(1)").html();
                    h[h.length] = "<li v=\"y\" c='" + c + "' t='" + t + "'>";
                    h[h.length] = "<cite class=\"errorBg\"><em class=\"error2\"></em></cite>";
                    h[h.length] = "<div class=\"spfzpkNum\">";
                    h[h.length] = a;
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"spfzpk\">";
                    h[h.length] = b;
                    h[h.length] = "</div>";
                    h[h.length] = "</li>";
                });
                break;
            case "bf":
            case "bqc":
                $("#content_ ul[v=y]").each(function () {
                    var c = $(this).attr("c");
                    var t = $(this).attr("t");
                    var a = $(this).find("li:eq(1) p:eq(0)").html();
                    var b = $(this).find("li:eq(1) p:eq(1)").html();
                    var bflayout = $(this).nextAll("div." + play.toLowerCase() + "_:first").html();

                    h[h.length] = "<li v=\"y\" c='" + c + "' t='" + t + "'>";
                    h[h.length] = "<cite class=\"errorBg\"><em class=\"error2\"></em></cite>";
                    h[h.length] = "<div class=\"spfzpkNum\">";
                    h[h.length] = a;
                    h[h.length] = "</div>";
                    h[h.length] = "<div class=\"spfzpk bfpk\">";
                    h[h.length] = b;
                    h[h.length] = "</div>";
                    h[h.length] = "</li>";
                    h[h.length] = "<div class=\"bfPop " + play.toLowerCase() + "_\" style=\"margin-top: -180px; display: none;\" a=\"c\" id=" + play.toLowerCase() + ">";
                    h[h.length] = bflayout;
                    h[h.length] = "</div>";
                });
                break;
        }

        h[h.length] = "<input type='hidden' id='issues' value='" + jcpage.var_.curIssues + "' />";
        localStorage.setItem(gameCode.toLowerCase() + play.toLowerCase() + "_SelectNum", h.join(""));
        localStorage.removeItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
        window.location.href = "/buy/zctz/" + gameCode + "/?gametype=" + play.toLowerCase();
    });
}

$(function () {
    jcpage.static_.loadMatches();
    jcpage.var_.game = gameCode;
    jcpage.var_.play = play;
    bindClick();
});