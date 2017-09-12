
var PollNum = localStorage.getItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
var ele =
{
    tbody: $("#content_"),
    PollNum_t: [],
    PollNum_c: []
};
var jcpage =
{
    constant_: {
        //常量
        wk: ["日", "一", "二", "三", "四", "五", "六"],
        hhcount: ['胜', '平', '负', '胜', '平', '负',
            '0', '1', '2', '3', '4', '5', '6', '7',
            '1:0', '2:0', '2:1', '3:0', '3:1', '3:2', '4:0', '4:1', '4:2', '5:0', '5:1', '5:2', '胜其他',
            '0:0', '1:1', '2:2', '3:3', '平其他',
            '0:1', '0:2', '1:2', '0:3', '1:3', '2:3', '0:4', '1:4', '2:4', '0:5', '1:5', '2:5', '负其他',
            '胜胜', '胜平', '胜负', '平胜', '平平', '平负', '负胜', '负平', '负负'
        ],
        bqccode: { "33": "胜胜", "31": "胜平", "30": "胜负", "13": "平胜", "11": "平平", "10": "平负", "03": "负胜", "01": "负平", "00": "负负" },
        bfcode: {
            "10": "1:0", "20": "2:0", "21": "2:1", "30": "3:0", "31": "3:1", "32": "3:2", "40": "4:0", "41": "4:1", "42": "4:2", "50": "5:0", "51": "5:1", "52": "5:2", "X0": "胜其它",
            "00": "0:0", "11": "1:1", "22": "2:2", "33": "3:3", "XX": "平其他",
            "01": "0:1", "02": "0:2", "12": "1:2", "03": "0:3", "13": "1:3", "23": "2:3", "04": "0:4", "14": "1:4", "24": "2:4", "05": "0:5", "15": "1:5", "25": "2:5", "0X": "负其它"
        },
        express: { bf: {}, bqc: { 45: 33, 46: 31, 47: 30, 48: 13, 49: 11, 50: 10, 51: "03", 52: "01", 53: "00"} },
        play: { brqspf: "brqspf", spf: "spf", bf: "bf", zjq: "zjq", bqc: "bqc", hh: "hh" },
        AnteCode: {
            brqspf: { "3": "胜", "1": "平", "0": "负" },
            spf: { "3": "让胜", "1": "让平", "0": "让负" },
            bqc: { "33": "胜胜", "31": "胜平", "30": "胜负", "13": "平胜", "11": "平平", "10": "平负", "03": "负胜", "01": "负平", "00": "负负" },
            bf: {
                "10": "1:0",
                "20": "2:0",
                "21": "2:1",
                "30": "3:0",
                "31": "3:1",
                "32": "3:2",
                "40": "4:0",
                "41": "4:1",
                "42": "4:2",
                "50": "5:0",
                "51": "5:1",
                "52": "5:2",
                "X0": "胜其它",
                "00": "0:0",
                "11": "1:1",
                "22": "2:2",
                "33": "3:3",
                "XX": "平其他",
                "01": "0:1",
                "02": "0:2",
                "12": "1:2",
                "03": "0:3",
                "13": "1:3",
                "23": "2:3",
                "04": "0:4",
                "14": "1:4",
                "24": "2:4",
                "05": "0:5",
                "15": "1:5",
                "25": "2:5",
                "0X": "负其它"
            },
            jqs: {
                "0": "0球",
                "1": "1球",
                "2": "2球",
                "3": "3球",
                "4": "4球",
                "5": "5球",
                "6": "6球",
                "7": "7球"
            }
        }

    },
    var_: {
        spArray: "", //保存所有sp数组
        game: "",
        play: "",
        ishungg: false, //页面玩法(spf,jqs)
        isDg: false,  //是否是单关
        allorsingle: false,  //是点全选还是单个点--单个点击有效果，全选没有效果
        type: "", //玩法类型
        time: "", //服务器时间
        sort: [], //排序重组html
        isupload: "", //是不是先发起后上传
        object: {}, //奖金预测、投注时用到
        queryDay: "",
        data: { jczq: {} },
        extro_data: { jczq: {} },
        endTr: new Set(), //结束的比赛
        hideTr: new Set(), //隐藏的比赛
        IsDg: false//单关
    },
    static_: {
        //静态内容
        loadMatches: function () { //调去对阵函数 
            ele.tbody.empty().append("<div class=\"load\" style=\"height:130px;line-height:150px;text-align:center;\"><img src=\"" + ires + "/default/loading-b.gif\"/></div>");
            var allGameInfo = dres + gameCode + "/match_list" + (jcpage.var_.IsDg ? "_hh" : ((play == "hh" || play == "brqspf" || play == "spf") ? "_FB" : "_" + play)) + ".json";
            var gameSp = dres + gameCode + "/" + ((play == "spf" || play == "hh" || play == "brqspf") ? "sp" : play + "_sp") + ".json";

            $.getScript(allGameInfo, function () {
                if (typeof (data) != "undefined" && data.length > 0) {
                    var matchData = data;
                    data = null;
                    //附加赔率信息
                    $.getScript(gameSp, function () {
                        if (data != null && typeof (data) != "undefined" && data.length > 0) {
                            jcpage.var_.extro_data[jcpage.var_.game] = data;
                            //jcpage.static_.dealMatchData(matchData);
                            //构建比赛信息
                            //jcpage.dymanic_.startMatch(jcpage.var_.data[jcpage.var_.game]);
                            jcpage.dymanic_.startMatch(matchData);
                        }
                    });
                }
            });
        },
        dealMatchData: function (data) {
            if (data.length == 0 || !data) return;
            var t, startDateTimes = [], minsaledate, leagues = new Set();
            //队伍排序
            data.sort(function compare(a, b) {
                return a.MatchId < b.MatchId ? -1 : 1;
            });
            //筛选出开始时间大于当前时间
            $.each(data, function (index, item) {
                t = stringToDateTime(item.StartDateTime);
                if (t > servertime) {
                    startDateTimes.push(t);
                    //联盟信息
                    if (!leagues.contain(item.LeagueName)) {
                        leagues.push(item.LeagueName);
                    }
                }
            });

            if (startDateTimes.length == 0) {
                ele.tbody.html("暂无对阵");
                return;
            }
            //取得最小时间
            startDateTimes.sort(function compare(a, b) {
                return a < b ? -1 : 1;
            });
            minsaledate = startDateTimes[0];
            if (minsaledate.getHours() < 11) {
                minsaledate.setDate(minsaledate.getDate() - 1);
            } else {
                minsaledate = new Date(minsaledate.getFullYear(), minsaledate.getMonth(), minsaledate.getDate());
            }
            t = new Date(minsaledate.getFullYear(), minsaledate.getMonth(), minsaledate.getDate());
            minsaledate.setHours(minsaledate.getHours() + 11);
            data = $.grep(data, function (item, index) {
                return stringToDateTime(item.StartDateTime) > minsaledate;
            });

            //单关
            //            if (jcpage.var_.IsDg) {
            //                data = $.grep(data, function (item, index) {
            //                    return item.State == "1" || item.State == "R" || item.State == "NR";
            //                });
            //            }
            jcpage.var_.data[jcpage.var_.game] = data;
            //组合回查下拉查询框
            // jcpage.dymanic_.callbackSelect(t);
            //组合联盟信息
            //jcpage.dymanic_.getLeagues(leagues.elements);
        },
        staticHtml: {
            header: function (date) {
                var play = jcpage.var_.play.toLowerCase();
                var h = "", d = date.toFormatString("MM-dd"), week = jcpage.constant_.wk[date.getDay()];
                if (play != null && play == "hh" && gameCode == "jczq") {
                    h = "<section class=\"jczqHh\">";
                }
                else if (play != null && play == "bqc" && gameCode == "jczq") {
                    h = "<section class=\"jczqBqc\">";
                }
                else if (play != null && play == "bf" && gameCode == "jczq") {
                    h = "<section class=\"jczqBf\">";
                }
                else if (play != null && play == "spf" && gameCode == "jczq") {
                    h = "<section class=\"jczqSpf\">";
                }
                else if (play != null && play == "brqspf" && gameCode == "jczq") {
                    h = "<section class=\"jczqBrqspf\">";
                }
                else if (play != null && play == "zjq" && gameCode == "jczq") {
                    h = "<section class=\"jczqZjq\">";
                }
                else {
                    h += "<section>";
                }
                h += "<div class=\"sfcTitle\">";
                h += d + "周" + week + "(11：00--次日11：00)";
                h += "<em class=\"up\"></em>";
                h += "</div><div>";
                return h;
            },
            sp: function (id, sp) {
                return fix(sp);
            },
            bf: function (sp) {
                return fix(sp);
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
                //                if (play == "spf") {
                //                    href += "<a target=\"_blank\" href=\"/betPointList/index?gameCode=jczq&matchId=" + matchdata + "_" + matchnumber + "\">评</a></td>";
                //                }
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
            if (arr["NoSaleState"] == 1 || arr["NoSaleState"] == "null") {
                return true;
            } else {
                delete arr["NoSaleState"];
            }
            delete arr["function"];
            for (var i in arr) {
                if (parseFloat(arr[i]) <= 0) return true; ;
            }
            return false;
        }
    },
    dymanic_: {
        //动态内容
        startMatch: function (data) {
            if (jcpage.var_.game.toLowerCase() == "jczq") {
                var h = [], play = jcpage.var_.play;
                if (PollNum) {
                    var PollNum1 = PollNum.split("|")[0].split(",");
                    for (var n = 0; n < PollNum1.length; n++) {
                        ele.PollNum_t[n] = PollNum1[n].split("=")[0];
                        ele.PollNum_c[n] = PollNum1[n].split("=")[1];
                    }
                }
                if (data.length > 0) {
                    var matchdata, sh;
                    var year = new Date().getFullYear();
                    var stopTime, func = jcpage.var_.IsDg ? jcpage.dymanic_.html.DGGD : jcpage.dymanic_.html[jcpage.var_.play.toUpperCase()];
                    for (var i = 0, il = data.length; i < il; i++) {
                        stopTime = stringToDateTime(data[i].FSStopBettingTime);
                        if (stopTime <= servertime) {
                            continue;
                        }
                        if (matchdata != data[i].MatchData) {
                            if (typeof (matchdata) != "undefined") {
                                h[h.length] = "</div></section>";
                            }
                            matchdata = data[i].MatchData;
                            sh = new Date(year + "/" + matchdata.substr(2, 2) + "/" + matchdata.substr(4, 2));
                            //开始新的table
                            h[h.length] = jcpage.static_.staticHtml.header(sh);
                        }
                        h[h.length] = func(data[i], sh, 1, i, play);
                    }
                    ele.tbody.html(h.join(""));
                    BindEvent();
                    my_play();
                }
            }

        },
        html: {
            commonHtml: function (item, endTime, sale) {
                var h = "", st = stringToDateTime(item.FSStopBettingTime);
                h += "<li class=\"li_weige\">";
                h += "<em>" + item.MatchNumber + "</em>";
                h += "<p title=\"" + item.LeagueName + "\" style=\"color:" + item.LeagueColor + "\">" + item.ShortLeagueName + "</p>";
                h += "<cite>" + st.toFormatString("HH:mm") + "</cite><i class=\"xzup xzdown\"></i></li>";
                return h;
            },
            BRQSPF: function (item, stoptime, sale) {

                var vari = jcpage.var_;
                var stop = item.MatchStopDesc;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), html = jcpage.static_.staticHtml;
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });
                var itemid = item.MatchId, st = stringToDateTime(item.FSStopBettingTime);
                var abbr = item.MatchIdName + "|" + item.HomeTeamName + "|" + item.GuestTeamName + "|0|" + st.toFormatString("yyyy-MM-dd HH:mm:ss");
                if (arr[0]) {
                    var brq = JSON.parse(arr[0].BRQSPF);
                    //                    var spf = JSON.parse(arr[0].SPF);
                    if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                        var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");
                        h += '<ul class="sfcxs" t="' + itemid + '" v="y" c="' + pc + '" abbr="' + abbr + '">';
                    } else {
                        h += '<ul class="sfcxs" t="' + itemid + '" abbr="' + abbr + '">';
                    }
                    h += str;
                    h += "<li><p class=\"spfzpk spfzpk2\">";
                    if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                        var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");
                        h += "<span id='brqspf'  sp=\"" + (brq != null && brq.WinOdds != "" ? brq.WinOdds : "未开售") + "\" v=\"3\"  class='" + (pc.indexOf("3") >= 0 ? 'cur' : "") + (stop == "2" || brq == null || brq.WinOdds == "" ? "no_dg" : "") + "'><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                        h += "<span id='brqspf' sp=\"" + (brq != null && brq.FlatOdds != "" ? brq.FlatOdds : "未开售") + "\" v=\"1\"  class=\"spfvs  " + (pc.indexOf("1") >= 0 ? "cur" : "") + (stop == "2" || brq == null || brq.FlatOdds == "" ? "no_dg" : "") + "\"><em>VS</em><cite>平</cite></span>";
                        h += "<span  id='brqspf'" + (stop == "2" ? "class='no_dg'" : "") + " sp=\"" + (brq != null && brq.LoseOdds != "" ? brq.LoseOdds : "未开售") + "\" v=\"0\"  class='" + (pc.indexOf("0") >= 0 ? 'cur' : "") + (stop == "2" || brq == null || brq.LoseOdds == "" ? "no_dg" : "") + "'><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                    } else {
                        h += "<span id='brqspf' " + (stop == "2" || brq == null || brq.WinOdds == "" ? "class='no_dg'" : "") + " sp=\"" + (brq != null && brq.WinOdds != "" ? brq.WinOdds : "未开售") + "\" v=\"3\" ><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                        h += "<span id='brqspf' sp=\"" + (brq != null && brq.FlatOdds != "" ? brq.FlatOdds : "未开售") + "\" v=\"1\"  class=\"spfvs " + (stop == "2" || brq == null || brq.FlatOdds == "" ? "no_dg" : "") + "\"><em>VS</em><cite>平</cite></span>";
                        h += "<span  id='brqspf'" + (stop == "2" || brq == null || brq.LoseOdds == "" ? "class='no_dg'" : "") + " sp=\"" + (brq != null && brq.LoseOdds != "" ? brq.LoseOdds : "未开售") + "\" v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                    }
                    h += " </p>";
                    h += "<p class=\"spfpl\"><span>赔率：" + (brq != null && brq.WinOdds != "" ? brq.WinOdds.toFixed(2) : "0.00") + "</span>";
                    h += "<span class=\"spfvs\">赔率：" + (brq != null && brq != "" ? brq.FlatOdds.toFixed(2) : "0.00") + "</span>";
                    h += "<span>赔率：" + (brq != null && brq.LoseOdds != "" ? brq.LoseOdds.toFixed(2) : "0.00") + "</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                } else {
                    if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                        var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");
                        h += '<ul class="sfcxs" t="' + itemid + '" v="y" c="' + pc + '">';
                    } else {
                        h += '<ul class="sfcxs" t="' + itemid + '">';
                    }
                    h += str;
                    h += "<li><p class=\"spfzpk spfzpk2\"><span sp='未开售' v=\"3\" class='no_dg'><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                    h += "<span sp=\"未开售\" v=\"1\" class=\"spfvs no_dg\"><em>VS</em><cite>平</cite></span><span  class='no_dg' sp=\"未开售\"  v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span></p><p class=\"spfpl\"><span>赔率：0.00</span><span class=\"spfvs\">赔率：0.00</span><span>赔率:0.00</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                }
                //h[h.length] = "<span class=\"op\" id=\"odd_" + item.MatchId + "_1\">" + fix(item.WinOdds, 2) + "</span><span class=\"op\" id=\"odd_" + item.MatchId + "_2\">" + fix(item.FlatOdds, 2) + "</span><span class=\"op\" id=\"odd_" + item.MatchId + "_3\">" + fix(item.LoseOdds, 2) + "</span></div></td>";
                h += "<div style=\"display:none;\" class=\"sfcpl\">";
                h += "<dl>";
                h += "<dt>平均赔率</dt>";
                h += "<dd>" + item.WinOdds + "</dd>";
                h += "<dd>" + item.FlatOdds + "</dd>";
                h += "<dd>" + item.LoseOdds + "</dd>";
                h += "</dl>";
                h += "</div>";

                return h;
            },
            SPF: function (item, stoptime, sale) {
                var stop = item.MatchStopDesc;
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), html = jcpage.static_.staticHtml;
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });
                var itemid = item.MatchId, st = stringToDateTime(item.FSStopBettingTime);
                var abbr = item.MatchIdName + "|" + item.HomeTeamName + "|" + item.GuestTeamName + "|" + item.LetBall + "|" + st.toFormatString("yyyy-MM-dd HH:mm:ss");
                if (arr[0]) {
                    //                    var brq = JSON.parse(arr[0].BRQSPF);
                    var spf = JSON.parse(arr[0].SPF);
                    if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                        var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");
                        h += '<ul class="sfcxs" t="' + itemid + '" v="y" c="' + pc + '" abbr="' + abbr + '">';
                    } else {
                        h += '<ul class="sfcxs" t="' + itemid + '" abbr="' + abbr + '">';
                    }
                    h += str;
                    h += "<li><p class=\"spfzpk spfzpk2\">";
                    if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                        var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");

                        h += "<span id='spf' sp=\"" + (spf != null && spf.WinOdds != "" ? spf.WinOdds : "未开售") + "\" v=\"3\"  class='" + (pc.indexOf("3") >= 0 ? 'cur' : "") + (stop == "2" ? "no_dg" : "") + "'><em>" + item.HomeTeamName + "<i r=" + item.LetBall + " class='" + (item.LetBall > 0 ? "red" : "blue") + "'>(" + (item.LetBall > 0 ? "+" + item.LetBall : item.LetBall) + ")</i></em><cite>胜</cite></span>";
                        h += "<span id='spf' sp=\"" + (spf != null && spf.FlatOdds != "" ? spf.FlatOdds : "未开售") + "\" v=\"1\"  class=\"spfvs " + (pc.indexOf("1") >= 0 ? "cur" : "") + (stop == "2" ? "no_dg" : "") + "\"><em>VS</em><cite>平</cite></span>";
                        h += "<span  id='spf' sp=\"" + (spf != null && spf.LoseOdds != "" ? spf.LoseOdds : "未开售") + "\" v=\"0\" class='" + (pc.indexOf("0") >= 0 ? 'cur' : "") + (stop == "2" ? "no_dg" : "") + "'><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                        //h += '<ul class="sfcxs" t="' + itemid + '" v="y" c="' + pc + '">'
                    } else {
                        h += "<span id='spf' class='" + (stop == "2" || spf == null || spf.WinOdds == "" ? "no_dg" : "") + "' sp=\"" + (spf != null && spf.WinOdds != "" ? spf.WinOdds : "未开售") + "\" v=\"3\" ><em>" + item.HomeTeamName + "<i  r=" + item.LetBall + " class='" + (item.LetBall > 0 ? "red" : "blue") + "'>(" + (item.LetBall > 0 ? "+" + item.LetBall : item.LetBall) + ")</i></em><cite>胜</cite></span>";
                        h += "<span id='spf' sp=\"" + (spf != null && spf.FlatOdds != "" ? spf.FlatOdds : "未开售") + "\" v=\"1\"  class=\"spfvs " + (stop == "2" || spf == null || spf.FlatOdds == "" ? "no_dg" : "") + "\"><em>VS</em><cite>平</cite></span>";
                        h += "<span id='spf'  class='" + (stop == "2" || spf == null || spf.LoseOdds == "" ? "no_dg" : "") + "' sp=\"" + (spf != null && spf.LoseOdds != "" ? spf.LoseOdds : "未开售") + "\" v=\"0\"><em>" + item.GuestTeamName + "</em><cite>胜</cite></span>";
                        //h += '<ul class="sfcxs" t="' + itemid + '">'
                    }
                    h += " </p>";
                    h += "<p class=\"spfpl\"><span>赔率：" + (spf != null && spf.WinOdds != "" ? spf.WinOdds.toFixed(2) : "0.00") + "</span>";
                    h += "<span class=\"spfvs\">赔率：" + (spf != null && spf != "" ? spf.FlatOdds.toFixed(2) : "0.00") + "</span>";
                    h += "<span>赔率：" + (spf != null && spf.LoseOdds != "" ? spf.LoseOdds.toFixed(2) : "0.00") + "</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                } else {
                    if (PollNum && PollNum_t.indexOf(itemid) >= 0) {
                        var pc = PollNum_c[PollNum_t.indexOf(itemid)];
                        pc = pc.split("/");
                        h += '<ul class="sfcxs" t="' + itemid + '" v="y" c="' + pc + '">';
                    } else {
                        h += '<ul class="sfcxs" t="' + itemid + '">';
                    }
                    h += str;
                    h += "<li><p class=\"spfzpk spfzpk2\"><span sp='未开售' v=\"3\" class='no_dg'><em>" + item.HomeTeamName + "</em><cite>胜</cite></span>";
                    h += "<span sp='未开售' v=\"1\" class=\"spfvs  no_dg\"><em>VS</em><cite>平</cite></span><span sp=\"未开售\" v=\"0\" class='no_dg'><em>" + item.GuestTeamName + "</em><cite>胜</cite></span></p><p class=\"spfpl\"><span>赔率：0.00</span><span class=\"spfvs\">赔率：0.00</span><span>赔率:0.00</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                }
                //h[h.length] = "<span class=\"op\" id=\"odd_" + item.MatchId + "_1\">" + fix(item.WinOdds, 2) + "</span><span class=\"op\" id=\"odd_" + item.MatchId + "_2\">" + fix(item.FlatOdds, 2) + "</span><span class=\"op\" id=\"odd_" + item.MatchId + "_3\">" + fix(item.LoseOdds, 2) + "</span></div></td>";
                h += "<div style=\"display:none;\" class=\"sfcpl\">";
                h += "<dl>";
                h += "<dt>平均赔率</dt>";
                h += "<dd>" + item.WinOdds + "</dd>";
                h += "<dd>" + item.FlatOdds + "</dd>";
                h += "<dd>" + item.LoseOdds + "</dd>";
                h += "</dl>";
                h += "</div>";

                return h;
            },
            ZJQ: function (item, stoptime, sale) {
                var vari = jcpage.var_;
                var stop = item.MatchStopDesc;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId;
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });

                if (arr[0]) {
                    var p = "";
                    if ($.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];

                        h += "<ul class=\"sfcxs jqzpk\" t='" + item.MatchId + "' v='y' c='" + p.replace(/\//g, ",") + "'>";
                    } else {
                        h += "<ul class=\"sfcxs jqzpk\" t='" + item.MatchId + "'>";
                    }
                    var zjq = arr[0];

                    h += str;
                    h += "<li >";
                    h += " <p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "  <span class=\"spfvs\">VS</span>";
                    h += " <span>" + item.GuestTeamName + "</span>";
                    h += "  </p>";
                    h += " <p class=\"spfzpk\">";
                    for (var i = 0; i < 4; i++) {
                        h += " <span v='" + i + "' class='" + (p.indexOf(i.toString()) > -1 ? 'cur' : '') + (stop == "2" || zjq == null || zjq["JinQiu_" + i + "_Odds"] == 0 || zjq["JinQiu_" + i + "_Odds"] == "" ? "no_dg" : "") + "'  sp='" + fix(zjq["JinQiu_" + i + "_Odds"]) + "'><b>" + i + "</b><cite>" + fix(zjq["JinQiu_" + i + "_Odds"]) + "</cite></span>";
                    }

                    h += "</p>";
                    h += "   <p class=\"spfzpk\">";
                    for (var j = 4; j < 8; j++) {
                        h += "<span v='" + j + "' class='" + (p.indexOf(i.toString()) > -1 ? 'cur' : '') + (stop == "2" || zjq == null || zjq["JinQiu_" + j + "_Odds"] == 0 || zjq["JinQiu_" + j + "_Odds"] == "" ? "no_dg" : "") + "' sp='" + fix(zjq["JinQiu_" + j + "_Odds"]) + "'><b>" + j + "</b><cite>" + fix(zjq["JinQiu_" + j + "_Odds"]) + "</cite></span>";
                    }
                    h += " </p>";
                    h += "</li>";
                    h += " </ul>";
                    h += "<div class=\"sfcpl\" style=\"display:none;\">";
                    h += "<dl><dt>平均赔率</dt><dd>" + item.WinOdds + "</dd><dd>" + item.FlatOdds + "</dd><dd>" + item.LoseOdds + "</dd></dl>";

                    h += "</div> ";
                }
                return h;
            },
            BF: function (item, stoptime, sale) {
                var stop = item.MatchStopDesc;
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId;
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });

                if (arr[0]) {
                    var bf = arr[0];
                    var p = "", code = "";
                    if ($.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        h += "<ul class=\"sfcxs\" t='" + matchid + "' v='y' c=" + p.replace(/\//g, ",") + ">";
                        var c = p.split("/");
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
                            code += "<cite " + (c.length > 5 ? 'style="display:none"' : "") + " sp='" + bf[z] + "' " + (v == "X0" || v == "0X" || v == "XX" ? 'class="sqt"' : "") + ">" + jcpage.constant_.bfcode[v] + "</cite>";
                        });
                    } else {
                        h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                    }
                    h += str;
                    h += "<li>";
                    h += "<p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "</p>";
                    h += "<p class=\"spfzpk bfpk\">";
                    h += "<span  class='" + (code != "" ? 'class="cur"' : "") + (stop == "2" ? "no_dg" : "") + "'>" + (code == "" ? "立即投注" : code) + "</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                    h += "<div class=\"sfcpl\" style=\"display:none;\">";
                    h += "<dl><dt>平均赔率</dt><dd>" + item.WinOdds + "</dd><dd>" + item.FlatOdds + "</dd><dd>" + item.LoseOdds + "</dd></dl>";
                    h += "</div>";


                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop bf_\" " + (p != "" ? "a='c'" : "") + ">";
                    h += "<div class=\"bfTitle clearfix\">";

                    h += "<p>" + item.HomeTeamName;
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName;
                    h += "</p>";
                    h += "</div>";
                    h += "<div style=\"height:17rem; overflow:auto\">";
                    h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">";
                    h += item.HomeTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span " + (p.indexOf("10") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_10 == "" || bf.S_10 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:0</strong><em>" + bf.S_10.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("20") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_20 == "" || bf.S_20 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:0</strong><em>" + bf.S_20.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("21") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_21 == "" || bf.S_21 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:1</strong><em>" + bf.S_21.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("30") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_30 == "" || bf.S_30 == 0 ? 'class="unsale"' : '') + "") + "><strong>3:0</strong><em>" + bf.S_30.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("31") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_31 == "" || bf.S_31 == 0 ? 'class="unsale"' : '') + "") + "><strong>3:1</strong><em>" + bf.S_31.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("32") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_32 == "" || bf.S_32 == 0 ? 'class="unsale"' : '') + "") + "><strong>3:2</strong><em>" + bf.S_32.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("40") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_40 == "" || bf.S_40 == 0 ? 'class="unsale"' : '') + "") + "><strong>4:0</strong><em>" + bf.S_40.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("41") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_41 == "" || bf.S_41 == 0 ? 'class="unsale"' : '') + "") + "><strong>4:1</strong><em>" + bf.S_41.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("42") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_42 == "" || bf.S_42 == 0 ? 'class="unsale"' : '') + "") + "><strong>4:2</strong><em>" + bf.S_42.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("50") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_50 == "" || bf.S_50 == 0 ? 'class="unsale"' : '') + "") + "><strong>5:0</strong><em>" + bf.S_50.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("51") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_51 == "" || bf.S_51 == 0 ? 'class="unsale"' : '') + "") + "><strong>5:1</strong><em>" + bf.S_51.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("52") > -1 ? 'class="cur"' : "" + (bf == null || bf.S_52 == "" || bf.S_52 == 0 ? 'class="unsale"' : '') + "") + "><strong>5:2</strong><em>" + bf.S_52.toFixed(2) + "</em></span>";
                    h += "<span class=\"bflast " + (p.indexOf("X0") > -1 ? 'cur' : "" + (bf == null || bf.S_QT == "" || bf.S_QT == 0 ? 'class="unsale"' : '') + "") + " \"><strong>胜其它</strong><em>" + bf.S_QT.toFixed(2) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">";
                    h += " 打平</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span " + (p.indexOf("00") > -1 ? 'class="cur"' : "" + (bf == null || bf.P_00 == "" || bf.P_00 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:0</strong><em>" + bf.P_00.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("11") > -1 ? 'class="cur"' : "" + (bf == null || bf.P_11 == "" || bf.P_11 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:1</strong><em>" + bf.P_11.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("22") > -1 ? 'class="cur"' : "" + (bf == null || bf.P_22 == "" || bf.P_22 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:2</strong><em>" + bf.P_22.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("33") > -1 ? 'class="cur"' : "" + (bf == null || bf.P_33 == "" || bf.P_33 == 0 ? 'class="unsale"' : '') + "") + "><strong>3:3</strong><em>" + bf.P_33.toFixed(2) + "</em></span>";
                    h += "<span class=\"bflast " + (p.indexOf("XX") > -1 ? 'cur' : "" + (bf == null || bf.P_QT == "" || bf.P_QT == 0 ? 'class="unsale"' : '') + "") + "\"><strong>平其它</strong><em>" + bf.P_QT.toFixed(2) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">";
                    h += item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span " + (p.indexOf("01") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_01 == "" || bf.F_01 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:1</strong><em>" + bf.F_01.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("02") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_02 == "" || bf.F_02 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:2</strong><em>" + bf.F_02.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("12") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_12 == "" || bf.F_12 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:2</strong><em>" + bf.F_12.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("03") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_03 == "" || bf.F_03 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:3</strong><em>" + bf.F_03.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("13") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_13 == "" || bf.F_13 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:3</strong><em>" + bf.F_13.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("23") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_23 == "" || bf.F_23 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:3</strong><em>" + bf.F_23.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("04") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_04 == "" || bf.F_04 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:4</strong><em>" + bf.F_04.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("14") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_14 == "" || bf.F_14 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:4</strong><em>" + bf.F_14.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("24") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_24 == "" || bf.F_24 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:4</strong><em>" + bf.F_24.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("05") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_05 == "" || bf.F_05 == 0 ? 'class="unsale"' : '') + "") + "><strong>0:5</strong><em>" + bf.F_05.toFixed(2) + "</em></span>";
                    h += "<span " + (p.indexOf("15") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_15 == "" || bf.F_15 == 0 ? 'class="unsale"' : '') + "") + "><strong>1:5</strong><em>" + bf.F_15.toFixed(2) + "</em></span>";
                    h += "<span" + (p.indexOf("25") > -1 ? 'class="cur"' : "" + (bf == null || bf.F_25 == "" || bf.F_25 == 0 ? 'class="unsale"' : '') + "") + "><strong>2:5</strong><em>" + bf.F_25.toFixed(2) + "</em></span>";
                    h += "<span class=\"bflast " + (p.indexOf("0X") > -1 ? 'cur' : "" + (bf == null || bf.F_QT == "" || bf.F_QT == 0 ? 'class="unsale"' : '') + "") + "\"><strong>负其它</strong><em>" + bf.F_QT.toFixed(2) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                }
                return h;
            },
            BQC: function (item, stoptime, sale) {
                var vari = jcpage.var_;
                var stop = item.MatchStopDesc;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId;
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });
                if (arr[0]) {
                    var bqc = arr[0];
                    var p = "", code = "";
                    if ($.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        var c = p.split("/");
                        h += "<ul class=\"sfcxs\" t='" + item.MatchId + "' v='y' c='" + p.replace(/\//g, ",") + "'>";
                        if (c.length > 5) {
                            code += "已选" + c.length + "项";
                        }
                        $.each(c, function (k, v) {
                            var v1 = v.substring(0, v.length - 1);
                            var v2 = v.substring(v.length - 1, v.length);
                            var z = "";
                            var v3 = { "3": "SH", "1": "P", "0": "F" };
                            z = v3[v1] + "_" + v3[v2] + "_Odds";
                            code += "<cite " + (c.length > 5 ? 'style="display:none"' : "") + " sp='" + bqc[z] + "' v='" + v + "'>" + jcpage.constant_.bqccode[v] + "</cite>";
                        });
                    } else {
                        h += "<ul class=\"sfcxs\" t='" + item.MatchId + "'>";
                    }

                    h += str;
                    h += "<li>";
                    h += "<p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "</p>";
                    h += "<p class=\"spfzpk bfpk\">";
                    h += "<span class='" + (code != "" ? 'cur' : "") + (stop == "2" ? "no_dg" : "") + "'>" + (code != "" ? code : "立即投注") + "</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                    h += "<div class=\"sfcpl\" style=\"display:none;\">";
                    h += "<dl><dt>平均赔率</dt><dd>" + item.WinOdds + "</dd><dd>" + item.FlatOdds + "</dd><dd>" + item.LoseOdds + "</dd></dl>";
                    h += "</div>";

                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop bqc_\" " + (p != "" ? "a='c'" : "") + ">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName;
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName;
                    h += "</p>";
                    h += "</div>";
                    h += "<p>[例] 胜负：上半场主胜 且 全场主负</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span value=\"33\" " + (p.indexOf("33") > -1 ? 'class="cur"' : "") + "><strong>胜:胜</strong><em>" + fix(bqc.SH_SH_Odds) + "</em></span>";
                    h += "<span value=\"31\" " + (p.indexOf("31") > -1 ? 'class="cur"' : "") + "><strong>胜:平</strong><em>" + fix(bqc.SH_P_Odds) + "</em></span>";
                    h += "<span value=\"30\" " + (p.indexOf("30") > -1 ? 'class="cur"' : "") + "><strong>胜:负</strong><em>" + fix(bqc.SH_F_Odds) + "</em></span>";
                    h += "<span value=\"13\" " + (p.indexOf("13") > -1 ? 'class="cur"' : "") + "><strong>平:胜</strong><em>" + fix(bqc.P_SH_Odds) + "</em></span>";
                    h += "<span value=\"11\" " + (p.indexOf("11") > -1 ? 'class="cur"' : "") + "><strong>平:平</strong><em>" + fix(bqc.P_P_Odds) + "</em></span>";
                    h += "<span value=\"10\" " + (p.indexOf("10") > -1 ? 'class="cur"' : "") + "><strong>平:负</strong><em>" + fix(bqc.P_F_Odds) + "</em></span>";
                    h += "<span value=\"03\" " + (p.indexOf("03") > -1 ? 'class="cur"' : "") + "><strong>负:胜</strong><em>" + fix(bqc.F_SH_Odds) + "</em></span>";
                    h += "<span value=\"01\" " + (p.indexOf("01") > -1 ? 'class="cur"' : "") + "><strong>负:平</strong><em>" + fix(bqc.F_P_Odds) + "</em></span>";
                    h += "<span value=\"00\" " + (p.indexOf("00") > -1 ? 'class="cur"' : "") + "><strong>负:负</strong><em>" + fix(bqc.F_F_Odds) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\" href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                }

                return h;
            },
            HH: function (item, stoptime, sale) {
                var vari = jcpage.var_;
                var stop = item.MatchStopDesc;
                var h = "", p = "", j = [], str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), html = jcpage.static_.staticHtml, matchid = item.MatchId, st = stringToDateTime(item.FSStopBettingTime);
                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                    return (it.MatchId == item.MatchId);
                });
                var abbr = item.MatchIdName + "|" + item.HomeTeamName + "|" + item.GuestTeamName + "|" + item.LetBall + "|" + st.toFormatString("yyyy-MM-dd HH:mm:ss");
                if (arr[0]) {
                    var brq = JSON.parse(arr[0].BRQSPF),
                        spf = JSON.parse(arr[0].SPF),
                        zjq = JSON.parse(arr[0].ZJQ),
                        bqc = JSON.parse(arr[0].BQC),
                        bf = JSON.parse(arr[0].BF);

                    h += "<div>";
                    h += "<ul class=\"sfcxs\" t='" + matchid + "' abbr='" + abbr + "'>";
                    h += str;
                    h += "<li>";
                    h += "<p class=\"spfzpkNum\">";
                    h += "<span>" + item.HomeTeamName + "<i r=" + item.LetBall + " class='" + (item.LetBall > 0 ? "red" : "blue") + "'>(" + (item.LetBall > 0 ? "+" + item.LetBall : item.LetBall) + ")</i></span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "</p>";
                    h += "<p class=\"spfzpk spfzpk2\">";
                    h += "<span class=\"brqspf " + (stop == "2" ? "no_dg" : "") + "\" id='brqspf'>胜平负</span>";
                    h += "<span class=\"spf " + (stop == "2" ? "no_dg" : "") + "\" id='spf'>让球胜平负</span>";
                    h += "<span class=\"bf " + (bf == null || stop == "2" ? "no_dg" : "") + "\" id='bf'>比分</span>";
                    h += "<span class=\"jqs " + (stop == "2" ? "no_dg" : "") + "\" id='jqs'>总进球</span>";
                    h += "<span class=\"bqc " + (stop == "2" ? "no_dg" : "") + "\" id='bqc'>半全场</span>";
                    h += "</p>";

                    h += "</li>";
                    h += "</ul>";
                    h += "<div style=\"display:none;\" class=\"sfcpl\">";
                    h += "<dl>";
                    h += "<dt>平均赔率</dt>";
                    h += "<dd>" + item.WinOdds + "</dd>";
                    h += "<dd>" + item.FlatOdds + "</dd>";
                    h += "<dd>" + item.LoseOdds + "</dd>";
                    h += "</dl>";
                    h += "</div>";
                    // 让球胜平负 （开始）

                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop spf_\">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "";
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName + "";
                    h += "</p>";
                    h += "</div>";
                    h += "<p></p>";
                    h += "<div class=\"competitions bfcom\">";
                    if (jcpage.static_.checkSp(spf)) {
                        h += "<span class=\"unsale\"><strong>未开售</strong><em></em></span>";
                    } else {
                        h += "<span v='3' sp='" + spf.WinOdds + "'><strong>胜</strong><em>" + html.sp("", spf.WinOdds) + "</em></span>";
                        h += "<span v='1' sp='" + spf.FlatOdds + "'><strong>平</strong><em>" + html.sp("", spf.FlatOdds) + "</em></span>";
                        h += "<span v='0' sp='" + spf.LoseOdds + "'><strong>负</strong><em>" + html.sp("", spf.LoseOdds) + "</em></span>";
                    }
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                    //不让球胜平负
                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop brqspf_\">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "";
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName + "";
                    h += "</p>";
                    h += "</div>";
                    h += "<p></p>";
                    h += "<div class=\"competitions bfcom\">";
                    if (jcpage.static_.checkSp(brq)) {
                        h += "<span class=\"unsale\"><strong>未开售</strong><em></em></span>";
                    } else {
                        h += "<span  v='3' sp='" + brq.WinOdds + "' ><strong>胜</strong><em>" + html.sp("", brq.WinOdds) + "</em></span>";
                        h += "<span v='1' sp='" + brq.FlatOdds + "'><strong>平</strong><em>" + html.sp("", brq.FlatOdds) + "</em></span>";
                        h += "<span v='0' sp='" + brq.LoseOdds + "'><strong>负</strong><em>" + html.sp("", brq.LoseOdds) + "</em></span>";
                    }

                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                    //比分
                    if (bf != null) {
                        h += "<div style=\"margin-top: -165px; display:none;\" class=\"bfPop bf_\">";
                        h += "<div class=\"bfTitle clearfix\">";
                        h += "<p>" + item.HomeTeamName + "";
                        h += "<span class=\"right\">";
                        h += "<em>V</em>";
                        h += "</span>";
                        h += "</p>";
                        h += "<p>";
                        h += "<span class=\"left\">";
                        h += "<em>S</em>";
                        h += "</span>" + item.GuestTeamName + "";
                        h += "</p>";
                        h += "</div>";
                        h += "<div style=\"height:17rem; overflow:auto\">";
                        h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">";
                        h += "" + item.HomeTeamName + "&nbsp;&nbsp;胜</p>";
                        h += "<div class=\"competitions bfcom\">";
                        h += "<span v='10' sp='" + jcpage.static_.staticHtml.bf(bf.S_10) + "'><strong>1:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_10) + "</em></span>";
                        h += "<span v='20' sp='" + jcpage.static_.staticHtml.bf(bf.S_20) + "'><strong>2:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_20) + "</em></span>";
                        h += "<span v='21' sp='" + jcpage.static_.staticHtml.bf(bf.S_21) + "'><strong>2:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_21) + "</em></span>";
                        h += "<span v='30' sp='" + jcpage.static_.staticHtml.bf(bf.S_30) + "'><strong>3:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_30) + "</em></span>";
                        h += "<span v='31' sp='" + jcpage.static_.staticHtml.bf(bf.S_31) + "'><strong>3:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_31) + "</em></span>";
                        h += "<span v='32' sp='" + jcpage.static_.staticHtml.bf(bf.S_32) + "'><strong>3:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_32) + "</em></span>";
                        h += "<span  v='40' sp='" + jcpage.static_.staticHtml.bf(bf.S_40) + "'><strong>4:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_40) + "</em></span>";
                        h += "<span v='41' sp='" + jcpage.static_.staticHtml.bf(bf.S_41) + "'><strong>4:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_41) + "</em></span>";
                        h += "<span v='42' sp='" + jcpage.static_.staticHtml.bf(bf.S_42) + "'><strong>4:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_42) + "</em></span>";
                        h += "<span v='50' sp='" + jcpage.static_.staticHtml.bf(bf.S_50) + "'><strong>5:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_50) + "3</em></span>";
                        h += "<span  v='51' sp='" + jcpage.static_.staticHtml.bf(bf.S_51) + "'><strong>5:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_51) + "</em></span>";
                        h += "<span  v='52' sp='" + jcpage.static_.staticHtml.bf(bf.S_52) + "'><strong>5:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_52) + "</em></span>";
                        h += "<span class=\"bflast\"  v='X0' sp='" + jcpage.static_.staticHtml.bf(bf.S_QT) + "'><strong>胜其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_QT) + "</em></span>";
                        h += "<div class=\"clear\"></div>";
                        h += "</div>";
                        h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">";
                        h += "打平</p>";
                        h += "<div class=\"competitions bfcom\">";
                        h += "<span v='00' sp='" + jcpage.static_.staticHtml.bf(bf.P_00) + "'><strong>0:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_00) + "</em></span>";
                        h += "<span v='11' sp='" + jcpage.static_.staticHtml.bf(bf.P_11) + "'><strong>1:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_11) + "</em></span>";
                        h += "<span v='22' sp='" + jcpage.static_.staticHtml.bf(bf.P_22) + "'><strong>2:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_22) + "</em></span>";
                        h += "<span v='33' sp='" + jcpage.static_.staticHtml.bf(bf.P_33) + "'><strong>3:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_33) + "</em></span>";
                        h += "<span class=\"bflast\" v='XX' sp='" + jcpage.static_.staticHtml.bf(bf.P_QT) + "'><strong>平其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_QT) + "</em></span>";
                        h += "<div class=\"clear\"></div>";
                        h += "</div>";
                        h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">";
                        h += "" + item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                        h += "<div class=\"competitions bfcom\">";
                        h += "<span v='01' sp='" + jcpage.static_.staticHtml.bf(bf.F_01) + "' ><strong>0:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_01) + "</em></span>";
                        h += "<span v='02' sp='" + jcpage.static_.staticHtml.bf(bf.F_02) + "'><strong>0:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_02) + "</em></span>";
                        h += "<span v='12' sp='" + jcpage.static_.staticHtml.bf(bf.F_12) + "'><strong>1:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_12) + "</em></span>";
                        h += "<span v='03' sp='" + jcpage.static_.staticHtml.bf(bf.F_03) + "'><strong>0:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_03) + "</em></span>";
                        h += "<span v='13' sp='" + jcpage.static_.staticHtml.bf(bf.F_13) + "'><strong>1:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_13) + "</em></span>";
                        h += "<span v='23' sp='" + jcpage.static_.staticHtml.bf(bf.F_23) + "'><strong>2:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_23) + "</em></span>";
                        h += "<span v='04' sp='" + jcpage.static_.staticHtml.bf(bf.F_04) + "'><strong>0:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_04) + "</em></span>";
                        h += "<span v='14' sp='" + jcpage.static_.staticHtml.bf(bf.F_14) + "'><strong>1:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_14) + "</em></span>";
                        h += "<span v='24' sp='" + jcpage.static_.staticHtml.bf(bf.F_24) + "'><strong>2:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_24) + "</em></span>";
                        h += "<span v='05' sp='" + jcpage.static_.staticHtml.bf(bf.F_05) + "'><strong>0:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_05) + "</em></span>";
                        h += "<span v='15' sp='" + jcpage.static_.staticHtml.bf(bf.F_15) + "'><strong>1:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_15) + "</em></span>";
                        h += "<span v='25' sp='" + jcpage.static_.staticHtml.bf(bf.F_25) + "'><strong>2:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_25) + "</em></span>";
                        h += "<span class=\"bflast\" v='0X' sp='" + jcpage.static_.staticHtml.bf(bf.F_QT) + "'><strong>负其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_QT) + "</em></span>";
                        h += "<div class=\"clear\"></div>";
                        h += "</div>";
                        h += "</div>";
                        h += "<div class=\"zfTrue clearfix\">";
                        h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                        h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                        h += "</div>";
                        h += "</div>";
                    }

                    //进球数
                    h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop jqs_\">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "";
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName + "";
                    h += "</p>";
                    h += "</div>";
                    h += "<p></p>";
                    h += "<div class=\"competitions bfcom\">";
                    for (var i = 0; i <= 7; i++) {
                        h += "<span v='" + i + "' sp='" + fix(zjq["JinQiu_" + i + "_Odds"]) + "' class='" + (zjq == null || zjq["JinQiu_" + i + "_Odds"] == "" || zjq["JinQiu_" + i + "_Odds"] == 0 ? "unsale" : "") + "'><strong>" + i + "球</strong><em>" + fix(zjq["JinQiu_" + i + "_Odds"]) + "</em></span>";
                    }
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                    //半全场
                    h += "<div style=\"margin-top: -150px; display:none;\" class=\"bfPop bqc_\">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "";
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>";
                    h += "" + item.GuestTeamName + "";
                    h += "</p>";
                    h += "</div>";
                    h += "<div style=\"height:15rem; overflow:auto\">";
                    h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">";
                    h += "" + item.HomeTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    if (bqc != null) {
                        h += "<span sp='" + fix(bqc.SH_SH_Odds) + "' v='33'><strong>胜胜</strong><em>" + fix(bqc.SH_SH_Odds) + "</em></span>";
                        h += "<span sp='" + fix(bqc.SH_P_Odds) + "' v='31'><strong>胜平</strong><em>" + fix(bqc.SH_P_Odds) + "</em></span>";
                        h += "<span sp='" + fix(bqc.SH_F_Odds) + "' v='30'><strong>胜负</strong><em>" + fix(bqc.SH_F_Odds) + "</em></span>";
                    } else {
                        h += "<span class='unsale' v='33'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale' v='31'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale' v='30'><strong>未开售</strong><em>未开售</em></span>";
                    }

                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">";
                    h += "打平</p>";
                    h += "<div class=\"competitions bfcom\">";
                    if (bqc != null) {
                        h += "<span sp='" + fix(bqc.P_SH_Odds) + "' v='13'><strong>平胜</strong><em>" + fix(bqc.P_SH_Odds) + "</em></span>";
                        h += "<span  sp='" + fix(bqc.P_P_Odds) + "' v='11'><strong>平平</strong><em>" + fix(bqc.P_P_Odds) + "</em></span>";
                        h += "<span sp='" + fix(bqc.P_F_Odds) + "' v='10'><strong>平负</strong><em>" + fix(bqc.P_F_Odds) + "</em></span>";
                    } else {
                        h += "<span class='unsale'  v='13'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale'  v='11'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale'  v='10'><strong>未开售</strong><em>未开售</em></span>";
                    }

                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">";
                    h += "" + item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    if (bqc != null) {
                        h += "<span sp='" + fix(bqc.F_SH_Odds) + "' v='03'><strong>负胜</strong><em>" + fix(bqc.F_SH_Odds) + "</em></span>";
                        h += "<span  sp='" + fix(bqc.F_P_Odds) + "' v='01'><strong>负平</strong><em>" + fix(bqc.F_P_Odds) + "</em></span>";
                        h += "<span sp='" + fix(bqc.F_F_Odds) + "' v='00'><strong>负负</strong><em>" + fix(bqc.F_F_Odds) + "</em></span>";
                    } else {
                        h += "<span class='unsale' v='03'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale' v='01'><strong>未开售</strong><em>未开售</em></span>";
                        h += "<span class='unsale' v='00'><strong>未开售</strong><em>未开售</em></span>";
                    }
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div></div>";
                }
                return h;
            },
            DGGD: function (item, stoptime, sale) {
                //debugger;
                var stop = item.MatchStopDesc;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), html = jcpage.static_.staticHtml, matchid = item.MatchId;
                var state = item.State;
                //                var arr = jQuery.grep(vari.extro_data[vari.game], function (it, idx) {
                //                    return (it.MatchId == item.MatchId);
                //                });
                //if (arr[0]) {
                var brq = JSON.parse(item.BRQSPF),
                    spf = JSON.parse(item.SPF),
                    zjq = JSON.parse(item.ZJQ),
                    bqc = JSON.parse(item.BQC),
                    bf = JSON.parse(item.BF);

                h += "<div>";
                h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                h += str;
                h += "<li>";
                h += "<p class=\"spfzpkNum\">";
                h += "<span>" + item.HomeTeamName + "</span>";
                h += "<span class=\"spfvs\">VS</span>";
                h += "<span>" + item.GuestTeamName + "</span>";
                h += "</p>";
                h += "<p class=\"spfzpk spfzpk2\">";
                h += "<span class=\"brqspf " + (state.indexOf(2) > -1 && stop == "1" ? "" : "no_dg") + "\" id='brqspf'>胜平负</span>";
                h += "<span class=\"spf " + (state.indexOf(1) > -1 && stop == "1" ? "" : "no_dg") + "\" id='spf'>让球胜平负</span>";
                h += "<span class=\"bf " + (state.indexOf(3) > -1 && stop == "1" ? "" : "no_dg") + "\" id='bf'>比分</span>";
                h += "<span class=\"jqs " + (state.indexOf(5) > -1 && stop == "1" ? "" : "no_dg") + "\" id='jqs'>总进球</span>";
                h += "<span class=\"bqc " + (state.indexOf(4) > -1 && stop == "1" ? "" : "no_dg") + "\" id='bqc'>半全场</span>";
                h += "</p>";

                h += "</li>";
                h += "</ul>";
                h += "<div style=\"display:none;\" class=\"sfcpl\">";
                h += "<dl>";
                h += "<dt>平均赔率</dt>";
                h += "<dd>" + item.WinOdds + "</dd>";
                h += "<dd>" + item.FlatOdds + "</dd>";
                h += "<dd>" + item.LoseOdds + "</dd>";
                h += "</dl>";
                h += "</div>";
                // 让球胜平负 （开始）

                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop spf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.HomeTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.GuestTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";
                h += "<div class=\"competitions bfcom\">";
                if (jcpage.static_.checkSp(spf)) {
                    h += "<span><strong>未开售</strong><em></em></span>";
                } else {
                    h += "<span v='3' sp='" + spf.WinOdds + "'><strong>胜</strong><em>" + html.sp("", spf.WinOdds) + "</em></span>";
                    h += "<span v='1' sp='" + spf.FlatOdds + "'><strong>平</strong><em>" + html.sp("", spf.FlatOdds) + "</em></span>";
                    h += "<span v='0' sp='" + spf.LoseOdds + "'><strong>负</strong><em>" + html.sp("", spf.LoseOdds) + "</em></span>";
                }
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";
                //不让球胜平负
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop brqspf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.HomeTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.GuestTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";
                h += "<div class=\"competitions bfcom\">";
                if (jcpage.static_.checkSp(brq)) {
                    h += "<span><strong>未开售</strong><em></em></span>";
                } else {
                    h += "<span  v='3' sp='" + brq.WinOdds + "' ><strong>胜</strong><em>" + html.sp("", brq.WinOdds) + "</em></span>";
                    h += "<span v='1' sp='" + brq.FlatOdds + "'><strong>平</strong><em>" + html.sp("", brq.FlatOdds) + "</em></span>";
                    h += "<span v='0' sp='" + brq.LoseOdds + "'><strong>负</strong><em>" + html.sp("", brq.LoseOdds) + "</em></span>";
                }

                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";
                //比分
                if (bf != null) {

                    h += "<div style=\"margin-top: -165px; display:none;\" class=\"bfPop bf_\">";
                    h += "<div class=\"bfTitle clearfix\">";
                    h += "<p>" + item.HomeTeamName + "";
                    h += "<span class=\"right\">";
                    h += "<em>V</em>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p>";
                    h += "<span class=\"left\">";
                    h += "<em>S</em>";
                    h += "</span>" + item.GuestTeamName + "";
                    h += "</p>";
                    h += "</div>";
                    h += "<div style=\"height:17rem; overflow:auto\">";
                    h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">";
                    h += "" + item.HomeTeamName + "&nbsp;&nbsp;胜</p>";


                    h += "<div class=\"competitions bfcom\">";
                    h += "<span v='10' sp='" + jcpage.static_.staticHtml.bf(bf.S_10) + "'><strong>1:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_10) + "</em></span>";
                    h += "<span v='20' sp='" + jcpage.static_.staticHtml.bf(bf.S_20) + "'><strong>2:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_20) + "</em></span>";
                    h += "<span v='21' sp='" + jcpage.static_.staticHtml.bf(bf.S_21) + "'><strong>2:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_21) + "</em></span>";
                    h += "<span v='30' sp='" + jcpage.static_.staticHtml.bf(bf.S_30) + "'><strong>3:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_30) + "</em></span>";
                    h += "<span v='31' sp='" + jcpage.static_.staticHtml.bf(bf.S_31) + "'><strong>3:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_31) + "</em></span>";
                    h += "<span v='32' sp='" + jcpage.static_.staticHtml.bf(bf.S_32) + "'><strong>3:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_32) + "</em></span>";
                    h += "<span  v='40' sp='" + jcpage.static_.staticHtml.bf(bf.S_40) + "'><strong>4:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_40) + "</em></span>";
                    h += "<span v='41' sp='" + jcpage.static_.staticHtml.bf(bf.S_41) + "'><strong>4:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_41) + "</em></span>";
                    h += "<span v='42' sp='" + jcpage.static_.staticHtml.bf(bf.S_42) + "'><strong>4:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_42) + "</em></span>";
                    h += "<span v='50' sp='" + jcpage.static_.staticHtml.bf(bf.S_50) + "'><strong>5:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_50) + "3</em></span>";
                    h += "<span  v='51' sp='" + jcpage.static_.staticHtml.bf(bf.S_51) + "'><strong>5:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_51) + "</em></span>";
                    h += "<span  v='52' sp='" + jcpage.static_.staticHtml.bf(bf.S_52) + "'><strong>5:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_52) + "</em></span>";
                    h += "<span class=\"bflast\"  v='X0' sp='" + jcpage.static_.staticHtml.bf(bf.S_QT) + "'><strong>胜其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.S_QT) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";

                    h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">";
                    h += "打平</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span v='00' sp='" + jcpage.static_.staticHtml.bf(bf.P_00) + "'><strong>0:0</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_00) + "</em></span>";
                    h += "<span v='11' sp='" + jcpage.static_.staticHtml.bf(bf.P_11) + "'><strong>1:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_11) + "</em></span>";
                    h += "<span v='22' sp='" + jcpage.static_.staticHtml.bf(bf.P_22) + "'><strong>2:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_22) + "</em></span>";
                    h += "<span v='33' sp='" + jcpage.static_.staticHtml.bf(bf.P_33) + "'><strong>3:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_33) + "</em></span>";
                    h += "<span class=\"bflast\" v='XX' sp='" + jcpage.static_.staticHtml.bf(bf.P_QT) + "'><strong>平其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.P_QT) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">";
                    h += "" + item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                    h += "<div class=\"competitions bfcom\">";
                    h += "<span v='01' sp='" + jcpage.static_.staticHtml.bf(bf.F_01) + "' ><strong>0:1</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_01) + "</em></span>";
                    h += "<span v='02' sp='" + jcpage.static_.staticHtml.bf(bf.F_02) + "'><strong>0:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_02) + "</em></span>";
                    h += "<span v='12' sp='" + jcpage.static_.staticHtml.bf(bf.F_12) + "'><strong>1:2</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_12) + "</em></span>";
                    h += "<span v='03' sp='" + jcpage.static_.staticHtml.bf(bf.F_03) + "'><strong>0:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_03) + "</em></span>";
                    h += "<span v='13' sp='" + jcpage.static_.staticHtml.bf(bf.F_13) + "'><strong>1:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_13) + "</em></span>";
                    h += "<span v='23' sp='" + jcpage.static_.staticHtml.bf(bf.F_23) + "'><strong>2:3</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_23) + "</em></span>";
                    h += "<span v='04' sp='" + jcpage.static_.staticHtml.bf(bf.F_04) + "'><strong>0:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_04) + "</em></span>";
                    h += "<span v='14' sp='" + jcpage.static_.staticHtml.bf(bf.F_14) + "'><strong>1:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_14) + "</em></span>";
                    h += "<span v='24' sp='" + jcpage.static_.staticHtml.bf(bf.F_24) + "'><strong>2:4</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_24) + "</em></span>";
                    h += "<span v='05' sp='" + jcpage.static_.staticHtml.bf(bf.F_05) + "'><strong>0:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_05) + "</em></span>";
                    h += "<span v='15' sp='" + jcpage.static_.staticHtml.bf(bf.F_15) + "'><strong>1:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_15) + "</em></span>";
                    h += "<span v='25' sp='" + jcpage.static_.staticHtml.bf(bf.F_25) + "'><strong>2:5</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_25) + "</em></span>";
                    h += "<span class=\"bflast\" v='0X' sp='" + jcpage.static_.staticHtml.bf(bf.F_QT) + "'><strong>负其它</strong><em>" + jcpage.static_.staticHtml.bf(bf.F_QT) + "</em></span>";
                    h += "<div class=\"clear\"></div>";
                    h += "</div>";
                    h += "</div>";
                    h += "<div class=\"zfTrue clearfix\">";
                    h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                    h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                    h += "</div>";
                    h += "</div>";
                }

                //进球数
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop jqs_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.HomeTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.GuestTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";
                h += "<div class=\"competitions bfcom\">";
                for (var i = 0; i <= 7; i++) {
                    h += "<span v='" + i + "' sp='" + fix(zjq["JinQiu_" + i + "_Odds"]) + "'><strong>" + i + "球</strong><em>" + fix(zjq["JinQiu_" + i + "_Odds"]) + "</em></span>";
                }
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";
                //半全场
                h += "<div style=\"margin-top: -150px; display:none;\" class=\"bfPop bqc_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.HomeTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>";
                h += "" + item.GuestTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<div style=\"height:15rem; overflow:auto\">";
                h += "<p class=\"red pdTop06 pdLeft08 pdBot03\">";
                h += "" + item.HomeTeamName + "&nbsp;&nbsp;胜</p>";
                h += "<div class=\"competitions bfcom\">";

                if (bqc != null) {
                    h += "<span  sp='" + fix(bqc.SH_SH_Odds) + "' v='33'><strong>胜胜</strong><em>" + fix(bqc.SH_SH_Odds) + "</em></span>";
                    h += "<span sp='" + fix(bqc.SH_P_Odds) + "' v='31'><strong>胜平</strong><em>" + fix(bqc.SH_P_Odds) + "</em></span>";
                    h += "<span sp='" + fix(bqc.SH_F_Odds) + "' v='30'><strong>胜负</strong><em>" + fix(bqc.SH_F_Odds) + "</em></span>";
                } else {
                    h += "<span class='unsale' v='33'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale' v='31'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale' v='30'><strong>未开售</strong><em>未开售</em></span>";
                }

                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<p class=\"blue pdTop06 pdLeft08 pdBot03\">";
                h += "打平</p>";
                h += "<div class=\"competitions bfcom\">";
                if (bqc != null) {
                    h += "<span sp='" + fix(bqc.P_SH_Odds) + "' v='13'><strong>平胜</strong><em>" + fix(bqc.P_SH_Odds) + "</em></span>";
                    h += "<span  sp='" + fix(bqc.P_P_Odds) + "' v='11'><strong>平平</strong><em>" + fix(bqc.P_P_Odds) + "</em></span>";
                    h += "<span sp='" + fix(bqc.P_F_Odds) + "' v='10'><strong>平负</strong><em>" + fix(bqc.P_F_Odds) + "</em></span>";
                } else {
                    h += "<span class='unsale'  v='13'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale'  v='11'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale'  v='10'><strong>未开售</strong><em>未开售</em></span>";
                }

                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<p class=\"green pdTop06 pdLeft08 pdBot03\">";
                h += "" + item.GuestTeamName + "&nbsp;&nbsp;胜</p>";
                h += "<div class=\"competitions bfcom\">";
                if (bqc != null) {
                    h += "<span sp='" + fix(bqc.F_SH_Odds) + "' v='03'><strong>负胜</strong><em>" + fix(bqc.F_SH_Odds) + "</em></span>";
                    h += "<span  sp='" + fix(bqc.F_P_Odds) + "' v='01'><strong>负平</strong><em>" + fix(bqc.F_P_Odds) + "</em></span>";
                    h += "<span sp='" + fix(bqc.F_F_Odds) + "' v='00'><strong>负负</strong><em>" + fix(bqc.F_F_Odds) + "</em></span>";
                } else {
                    h += "<span class='unsale' v='03'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale' v='01'><strong>未开售</strong><em>未开售</em></span>";
                    h += "<span class='unsale' v='00'><strong>未开售</strong><em>未开售</em></span>";
                }

                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div></div>";
                // }
                return h;
            }
        }
    }
};

var BindEvent = function () {
    $(".jczqSpf").find("ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 15;
        if (c_ >= n_ && !$(this).parent().find(".cur").length) {
            Box.tx("最多选" + n_ + "场");
            return
        }

        if (t == "未开售") {
            return;
        }

        else {
            $(this).toggleClass("cur");
        }
        if ($(this).parent().find("span").hasClass("cur")) {
            var c = "";
            $(this).parent().find("span.cur").each(function () {
                c += $(this).attr("v") + ","
            });

            c = c.substring(0, c.length - 1);
            $(this).parent().parent().parent().attr("v", "y");
            $(this).parent().parent().parent().attr("c", c);
        }

        else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c")
        }
        my_play();
    });
    $(".jczqBrqspf").find("ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
        var t = $(this).parent().next().find("span:eq(1)").html();
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 10;
        if (c_ >= n_ && !$(this).parent().find(".cur").length) {
            Box.tx("最多选" + n_ + "场");
            return;
        }

        if (t == "未开售") {
            return;
        }

        else {
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
        }

        else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c")
        }
        my_play();
    });
    //显示隐藏比赛
    $(".li_weige").Touch(function () {
        $(this).find(".xzup").toggleClass("xzdown");
        $(this).parents(".sfcxs").next(".sfcpl:first").slideToggle(300);
    });
    //显示隐藏赔率
    $(".sfcTitle").Touch(function () {
        $(this).find(".up").toggleClass("down");
        $(this).next().slideToggle(300);
    });


    //比分点击  立即投注
    $("#content_").find(".jczqBf ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        if (c_ > 14) {
            Box.tx("最多选择15场比赛");
            return false;
        }

        $(this).parent().parent().parent().next().next().css("marginTop", "-170px");
        $(this).parent().parent().parent().next().next().show();
        $(".zhezhao").show();
        my_play();
    });

    $("section[class='jczqBf'] [class$='bf_']").find("a.zfqx").Touch(function () {
        $(this).parent().parent().find(".cur").removeClass("cur");
        public_bf($(this).parent().parent());
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
    });

    $("section[class='jczqBf'] [class$='bf_']").find("a.zfqr").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
    });

    $(".jczqBf .bf_ div.competitions span").Touch(function () {
        $(this).toggleClass("cur");
        public_bf($(this).parent().parent().parent());
    });

    //混合选择过关方式显示相应的数据
    $("#content_").find(".jczqHh ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
        $(".zhezhao").show();
        var this_class = $(this).attr("class");
        if ($(this).hasClass("spf")) {
            $(this).closest(".sfcxs").nextAll("[class$='spf_']:first").show();
        }
        if ($(this).hasClass("brqspf")) {
            $(this).closest(".sfcxs").nextAll("[class$='brqspf_']:first").show();
        }
        if ($(this).hasClass("bf")) {
            $(this).closest(".sfcxs").nextAll("[class$='bf_']:first").show();
        }
        if ($(this).hasClass("jqs")) {
            $(this).closest(".sfcxs").nextAll("[class$='jqs_']:first").show();
        }
        if ($(this).hasClass("bqc")) {
            $(this).closest(".sfcxs").nextAll("[class$='bqc_']:first").show();
        }
    });

    //混合 确认 取消
    $("section[class='jczqHh'] [class*='_']").find("a.zfqx").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
        $(this).parent().parent().find(".cur").removeClass("cur");
        var x = $(this).closest(".bfPop").attr("class").substring($(this).closest(".bfPop").attr("class").indexOf(" "), $(this).closest(".bfPop").attr("class").length - 1);
        var t = $(this).closest(".bfPop");
        //DeleteClass_yx_hh(x, t);
        public_hh($(this).parent().parent());

    });
    $("section[class='jczqHh'] [class*='_']").find("a.zfqr").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide();
    });

    //混合选择数据
    $("section[class='jczqHh'] .bfPop span").Touch(function () {
        if ($(this).hasClass("unsale")) return false;
        var parentsUntil_ = $(this).closest(".bfPop");
        $(this).toggleClass("cur");
        public_hh(parentsUntil_);
    });

    //半全场点击 立即投注
    $("#content_").find(".jczqBqc ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {

        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        if (c_ > 14) {
            Box.tx("最多选择15场比赛");
            return false
        }
        var c = $(window).height();
        var d = $(this).parent().parent().parent().next().next().height();
        var t = "-" + c / 2 + "px";
        if (c > d) {
            t = "-" + d / 2 + "px";
        }
        $(this).parent().parent().parent().next().next().css("marginTop", t);
        $(this).parent().parent().parent().next().next().show();
        $(".zhezhao").show();
        //my_play();
    });

    $("section[class='jczqBqc'] [class$='bqc_']").find("a.zfqx").Touch(function () {
        $(this).parent().parent().find(".cur").removeClass("cur");
        public_bf($(this).parent().parent());
        $(".zhezhao").hide();
        $(this).parent().parent().hide()
    });

    $("section[class='jczqBqc'] [class$='bqc_']").find("a.zfqr").Touch(function () {
        $(".zhezhao").hide();
        $(this).parent().parent().hide()
    });

    $(".jczqBqc .bqc_ div.competitions span").Touch(function () {
        $(this).toggleClass("cur");
        public_bqc($(this).parent().parent());
        my_play();
    });

    //总进球
    $("#content_").find(".jczqZjq ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        var n_ = 15;
        if (c_ >= n_ && !$(this).parent().parent().find(".cur").length) {
            Box.tx("最多选" + n_ + "场");
            return;
        }
        $(this).toggleClass("cur");
        if ($(this).parent().parent().find("span").hasClass("cur")) {
            var c = "";
            $(this).parent().parent().find("span.cur").each(function () {
                c += $(this).attr("v") + ",";
            });
            c = c.substring(0, c.length - 1);
            $(this).parent().parent().parent().attr("v", "y");
            $(this).parent().parent().parent().attr("c", c);
        } else {
            $(this).parent().parent().parent().removeAttr("v");
            $(this).parent().parent().parent().removeAttr("c");
        }
        my_play();
    });

};


function bindClick() {

    //显示隐藏帮助
    $(".pullDown").click(function () {
        if ($(".pullText").is(":visible")) {
            $(this).removeClass("pullHover");
            $(".pullText").hide();
        } else {
            $(this).addClass("pullHover");
            $(".pullText").show();
        }
    });
    //显示隐藏玩法
    $("#wanfa_").click(function () {
        if ($(".hmPull").is(":visible")) {
            $(this).removeClass("hmTit");
            $(".hmPull").hide();
        } else {
            $(this).addClass("hmTit");
            $(".hmPull").show();
        }
    });
    //清空
    $(".deleted").click(function () {
        if (play.toLowerCase() == "bqc" || play.toLowerCase() == "bf") {
            $("#content_ ul.sfcxs[v=y]").removeAttr("v").removeAttr("c").find(".cur").removeClass("cur").html("立即投注");
            $("#content_ div.bfPop[a=c]").removeAttr("c").find(".cur").removeClass("cur");
        } else if (play.toLowerCase() == "hh") {
            $("#content_ ul[v=y]").find("p.spfzpk span.cur").each(function () {
                var id = $(this).attr("id");
                var m = {
                    "brqspf": "胜平负",
                    "spf": "让球胜平负",
                    "jqs": "总进球",
                    "bqc": "半全场",
                    "bf": "比分"
                }[id] || "";
                $(this).html(m);
                $(this).parent().parent().parent().nextAll("div." + id + "_:first").removeAttr("a").find("span.cur").removeClass("cur");
            });
        }
        localStorage.removeItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
        $("#content_ ul.sfcxs[v=y]").removeAttr("v").removeAttr("c").find(".cur").removeClass("cur");
        $("#c_").html(0);
    });
    $("#isOk_").click(function () {
        if ($(this).hasClass("true_disabled")) return false;
        if (parseInt($("#c_").html()) > 1 || jcpage.var_.IsDg) {
            var c = "";
            //var obj = { details: [] };
            switch (play.toLowerCase()) {
                case "hh":
                    var abbr = $(this).attr("abbr");
                    if (jcpage.var_.IsDg) {
                        var h = [];
                        $("#content_ section").find("div:eq(1) ul[v=y]").each(function () {
                            var self = $(this);
                            var matchId = self.attr("t");
                            var home = self.find("li:eq(1) p:eq(0) span:eq(0)").html();
                            var guest = self.find("li:eq(1) p:eq(0) span:eq(2)").html();
                            var arr = [];
                            h[h.length] = '<div class="siof_rtz" zid="' + matchId + '_title" matchid=' + matchId + '>';
                            h[h.length] = '<h4><span>' + home + '<i>vs</i>' + guest + '</span><cite class="errorBg"><em class="error2"></em> </cite></h4>';
                            h[h.length] = '<div class="siof_rtzt" zid="' + matchId + '_tzx">';

                            self.find("span.cur").each(function () {
                                var id = $(this).attr("id");
                                var items = "";
                                var item = [];
                                $(this).find("cite").each(function () {

                                    // "zjq^5-16.00|bqc^10-4.80,30-29.00";
                                    // var id = $(this).parent().attr("id");
                                    var code = jcpage.constant_.AnteCode[id][$(this).html()];
                                    var sp = $(this).attr("sp");

                                    item.push($(this).html() + "-" + sp);
                                    var defaultmoneey = 10;
                                    var bonusmoney = (defaultmoneey * Number(sp)).toFixed(2);
                                    h[h.length] = '<dl closer=""  bonus="' + bonusmoney + '" dtype="' + id + '" value="' + $(this).html() + '" sp="' + sp + '" data="' + (matchId + "_" + (id == "jqs" ? "zjq" : id) + "_" + $(this).html()) + '">';
                                    h[h.length] = '<dt><a class="tzdelete" href="javascript:void(0)">' + code + '</a></dt>';
                                    h[h.length] = '<dd class="siof_buy">买<input class="tzm" type="text" value="10">元</dd>';
                                    h[h.length] = '<dd class="siof_je ">' + bonusmoney + '</dd>';
                                    h[h.length] = '</dl>';
                                });
                                items = (id == "jqs" ? "zjq" : id) + "^" + item.join(",");
                                arr.push(items);
                            });
                            h[h.length] = "<input type='hidden' id='hid_" + matchId + "' value='" + arr.join("|") + "' />";
                            h[h.length] = "</div></div>";
                        });
                        c = h.join("");
                    } else {
                        $("#content_ section").find("div:eq(1) ul[v=y]").each(function () {
                            var dz = $(this).find("li:eq(1) p:eq(0)").html();
                            var pl = $(this).find("li:eq(1) p:eq(1)").html();
                            var matchid = $(this).attr("t");

                            var spf = $(this).nextAll("div.spf_:eq(0)");
                            var brqspf = $(this).nextAll("div.brqspf_:eq(0)");
                            var bf = $(this).nextAll("div.bf_:eq(0)");
                            var jqs = $(this).nextAll("div.jqs_:eq(0)");
                            var bqc = $(this).nextAll("div.bqc_:eq(0)");
                            var abbr = $(this).attr("abbr");
                            c += '<li t="' + matchid + '" v="y" abbr="' + abbr + '">';
                            c += '<cite class="errorBg"><em class="error2"></em></cite>';
                            c += '<div class="spfzpkNum ">';
                            c += dz;
                            c += "</div>";
                            c += '<div class="spfzpk spfzpk2 hh">';
                            c += pl;
                            c += "</div>";
                            c += "</li>";
                            c += "<div class=\"bfPop brqspf_\" style=\"display: none;margin-top:-80px\" " + (!brqspf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += brqspf.html();
                            c += "</div>";
                            c += "<div class=\"bfPop spf_\" style=\"display: none;margin-top:-80px\" " + (!spf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += spf.html();
                            c += "</div>";
                            c += "<div class=\"bfPop bf_\" style=\"display: none;margin-top:-150px\" " + (!bf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += bf.html();
                            c += "</div>";
                            c += "<div class=\"bfPop jqs_\" style=\"display: none;margin-top:-100px\" " + (!jqs.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += jqs.html();
                            c += "</div>";
                            c += "<div class=\"bfPop bqc_\" style=\"display: none;margin-top:-140px\" " + (!bqc.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += bqc.html();
                            c += "</div>";
                        });
                    }

                    break;
                case "zjq":
                    $("#content_ section").find("div:eq(1) ul[v=y]").each(function () {

                        var dz = $(this).find("li:eq(1) p:eq(0)").html();
                        var pl = $(this).find("li:eq(1) p:eq(1)").html();
                        var th = $(this).find("li:eq(1) p:eq(2)").html();
                        var code = $(this).attr("c");
                        var matchid = $(this).attr("t");

                        c += '<li t="' + matchid + '" c="' + code + '" v="y">';
                        c += '<cite class="errorBg"><em class="error2"></em></cite>';
                        c += '<div class="spfzpkNum">';
                        c += dz;
                        c += '</div>';
                        c += '<div class="spfzpk">';
                        c += pl;
                        c += '</div>';
                        c += '<div class="spfzpk">';
                        c += th;
                        c += '</div>';
                        c += '</li>';
                    });
                    break;
                case "bqc":
                case "bf":
                    $("#content_ section").find("div:eq(1) ul[v=y]").each(function (k) {
                        var dz = $(this).find("li:eq(1) p:eq(0)").html();
                        var pl = $(this).find("li:eq(1) p:eq(1)").html();
                        var boxlayout = $(this).parent().find("div.bfPop").eq(k).html();
                        var code = $(this).attr("c");
                        var matchid = $(this).attr("t");
                        c += "<li t='" + matchid + "' c='" + code + "' v=\"y\">";
                        c += "<cite class=\"errorBg\"><em class=\"error2\"></em></cite>";
                        c += "<div class=\"spfzpkNum\">";
                        c += dz;
                        c += "</div>";
                        c += "<div class=\"spfzpk bfpk\">";
                        c += pl;
                        c += "</div>";
                        c += "</li>";
                        c += "<div class=\"bfPop bf_\" style=\"display: none;\" a=\"c\" id=" + play.toLowerCase() + ">";
                        c += boxlayout;
                        c += "</div>";
                    });
                    break; ;
                case "spf":
                case "brqspf":
                    $("#content_ section").find("div:eq(1) ul[v=y]").each(function () {
                        var dz = $(this).find("li:eq(1) p:eq(0)").html();
                        var pl = $(this).find("li:eq(1) p:eq(1)").html();
                        var code = $(this).attr("c");
                        var matchid = $(this).attr("t");
                        var abbr = $(this).attr("abbr");
                        c += '<li t="' + matchid + '" c="' + code + '" v="y" abbr="' + abbr + '">';
                        c += '<cite class="errorBg"><em class="error2"></em></cite>';
                        c += '<div class="spfzpk spfzpk2">' + dz + "</div>";
                        c += '<div class="spfpl">' + pl + "</div>";
                        c += "</li>";
                    });
                    break;
            }

            if (jcpage.var_.IsDg) {
                localStorage.setItem(gameCode + "_dgobj", c);
                window.location.href = "/buy/dggd/" + gameCode + "/?gametype=" + play.toLowerCase();
                // localStorage.setItem("dgobj", c);
            } else {
                window.location.href = "/buy/zctz/" + gameCode + "/?gametype=" + play.toLowerCase();
                localStorage.setItem(gameCode.toLowerCase() + play.toLowerCase() + "_SelectNum", c);
                localStorage.removeItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
            }

        } else {
            Box.tx("请至少选择2场比赛");
        }
    });


}

//公共混合
function public_hh(t) {
    var l = t.find("div.competitions span.cur").length;
    var parent = $(t).parent("div div");
    var k = "";
    var this_attr = t.attr("class");
    var this_attr_hou = this_attr.substring(this_attr.indexOf(" "), this_attr.length - 1);
    var spanobj = t.prevAll(".sfcxs:first").find("[id='" + this_attr_hou.trim() + "']");
    if (l) {
        t.attr("a", "c");
        t.prevAll(".sfcxs:first").attr("v", "y");
        t.find("div.competitions span.cur").each(function () {
            var sp = $(this).attr("sp");
            var v = $(this).attr("v");
            k += "<cite sp='" + sp + "' style='display:none'>" + v + "</cite>";
        });
        spanobj.html("已选" + k);
        spanobj.addClass("cur");
    } else {
        t.removeAttr("a");

        var spf = t.prevAll("ul.sfcxs").nextAll("div.spf_");
        var brqspf = t.prevAll("ul.sfcxs").nextAll("div.brqspf_");
        var bf = t.prevAll("ul.sfcxs").nextAll("div.bf_");
        var jqs = t.prevAll("ul.sfcxs").nextAll("div.jqs_");
        var bqc = t.prevAll("ul.sfcxs").nextAll("div.bqc_");
        if (!spf.attr("a") && !brqspf.attr("a") && !bf.attr("a") && !jqs.attr("a") && !bqc.attr("a")) {
            t.prevAll(".sfcxs:first").removeAttr("v");
        }
        k = {
            "spf": "让球胜平负",
            "brqspf": "胜平负",
            "bf": "比分",
            "jqs": "总进球",
            "bqc": "半全场"
        }[this_attr_hou.trim()] || k;
        spanobj.html(k);
        spanobj.removeClass("cur");
    }
    my_play();
}
//公共比分
function public_bf(t) {
    var l = t.find("div.competitions span.cur").length;
    var n = 5,
        k = "";
    if (l) {
        t.attr("a", "c");
        t.prev().prev().attr("v", "y");
        t.prev().prev().find("li:eq(1) p:eq(1) span").addClass("cur");
        var m = "";
        if (l > n) {
            m += "已选" + l + "项";
        }
        t.find("div.competitions span.cur").each(function (aa) {

            var s = $(this).find("strong").html();
            var sp = $(this).find("em").html();
            m += "<cite  " + (l > n ? 'style="display:none"' : "") + "  " + (s == "胜其它" || s == "负其它" || s == "平其它" ? 'class="sqt"' : "") + " sp='" + sp + "'>" + s + "</cite>";

        });

        t.prev().prev().find("li:eq(1) p:eq(1) span").html(m);
        t.find("div.competitions span.cur").each(function (aa) {
            var s = $(this).find("strong").html();
            s = {
                "胜其它": "X0",
                "负其它": "XX",
                "平其它": "0X"
            }[s] || s;
            k += s.replace(":", "") + ",";
        });
        k = k.substr(0, k.length - 1);
        t.prev().prev().attr("c", k);
    } else {
        t.removeAttr("a");
        t.prev().prev().removeAttr("v");
        t.prev().prev().removeAttr("c");
        t.prev().prev().find("li:eq(1) p:eq(1) span").html("立即投注");
        t.prev().prev().find("li:eq(1) p:eq(1) span").removeClass("cur");
    }
    my_play();
};

//公共半全场
function public_bqc(t) {
    var l = t.find("div.competitions span.cur").length;
    var n = 5,
            k = "";
    if (l) {
        t.attr("a", "c");
        t.prev().prev().attr("v", "y");
        t.prev().prev().find("li:eq(1) p:eq(1) span").addClass("cur");
        var m = "";
        if (l > n) {
            m += "已选" + l + "项";
        }

        t.find("div.competitions span.cur").each(function (aa) {
            var v = $(this).attr("value");
            var s = $(this).find("strong").html();
            var sp = $(this).find("em").html();
            k += v + ",";
            m += "<cite " + (l > n ? 'style="display:none"' : '') + " sp='" + sp + "' v='" + v + "'>" + s.replace(":", "") + "</cite>";

        });
        t.prev().prev().find("li:eq(1) p:eq(1) span").html(m);
        k = k.substr(0, k.length - 1);
        t.prev().prev().attr("c", k);
    } else {
        t.removeAttr("a");
        t.prev().prev().removeAttr("v");
        t.prev().prev().removeAttr("c");
        t.prev().prev().find("li:eq(1) p:eq(1) span").html("立即投注");
        t.prev().prev().find("li:eq(1) p:eq(1) span").removeClass("cur");
    }
}

//自己选择了多少场比赛
function my_play() {
    var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
    $("#c_").html(c_);
};



$(function () {

    jcpage.var_.game = gameCode;
    jcpage.var_.play = play;
    jcpage.var_.IsDg = oddsType == 1 ? true : false; //单关
    bindClick();
    jcpage.static_.loadMatches();
});