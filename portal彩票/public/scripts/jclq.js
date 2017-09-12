
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
        express: [
            { n: "客胜", t: "sf_0" },
            { n: "主胜", t: "sf_3" },
            { n: "让分客胜", t: "rfsf_0" },
            { n: "让分主胜", t: "rfsf_3" },
            { n: "大分", t: "dxf_3" },
            { n: "小分", t: "dxf_0" },
            { n: "客胜1-5", t: "sfc_11" },
            { n: "客胜6-10", t: "sfc_12" },
            { n: "客胜11-15", t: "sfc_13" },
            { n: "客胜16-20", t: "sfc_14" },
            { n: "客胜21-25", t: "sfc_15" },
            { n: "主胜26+", t: "sfc_16" },
            { n: "主胜1-5", t: "sfc_01" },
            { n: "主胜6-10", t: "sfc_02" },
            { n: "主胜11-15", t: "sfc_03" },
            { n: "主胜16-20", t: "sfc_04" },
            { n: "主胜21-25", t: "sfc_05" },
            { n: "主胜26+", t: "sfc_06" }
        ],
        sfccode: {
            "01": "GuestWin1_5",
            "02": "GuestWin6_10",
            "03": "GuestWin11_15",
            "04": "GuestWin16_20",
            "05": "GuestWin21_25",
            "06":"GuestWin26",
            "11":"HomeWin1_5",
            "12":"HomeWin6_10",
            "13":"HomeWin11_15",
            "14":"HomeWin16_20",
            "15":"HomeWin21_25",
            "16":"HomeWin26"
        },
          AnteCode: {
            sf: { "3": "胜", "0": "负" },
            rfsf: { "3": "让胜", "0": "让负" },
            dxf: { "3":"大分","0":"小分" },
            sfc: {
                  "01": "主胜1_5",
                  "02": "主胜6_10",
                  "03": "主胜11_15",
                  "04": "主胜16_20",
                  "05": "主胜21_25",
                  "06": "主胜26",
                  "11": "客胜1_5",
                  "12": "客胜6_10",
                  "13": "客胜11_15",
                  "14": "客胜16_20",
                  "15": "客胜21_25",
                  "16": "客胜26"
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
        data: { jclq: {} },
        extro_data: { jclq: {} },
        endTr: new Set(), //结束的比赛
        hideTr: new Set()//隐藏的比赛
    },
    static_: {
        //静态内容
        loadMatches: function () { //调取对阵函数
            try {
                ele.tbody.empty().append("<div class=\"load\" style=\"height:130px;line-height:150px;text-align:center;\"><img src=\"" + ires + "/default/loading-b.gif\"/></div>");
                var allGameInfo = dres + gameCode + "/new/match_" + (play == "hh" ? "hhdg" : play) + "_list.json";
                $.getScript(allGameInfo, function () {
                    if (data != null && typeof (data) != "undefined" && data.length > 0) {
                        var matchData = data;
                        data = null;
                        //jcpage.static_.dealMatchData(matchData);
                        //jcpage.dymanic_.startMatch(jcpage.var_.data[jcpage.var_.game]);
                        jcpage.dymanic_.startMatch(matchData);
                    }
                });
            } catch (e) {
                Box.alert(e.message);
            }
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
                //t = stringToDateTime(item.StartDateTime);
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
            minsaledate.setHours(minsaledate.getHours() + 12);
            data = $.grep(data, function (item, index) {
                return stringToDateTime(item.StartDateTime) > minsaledate;
            });
            jcpage.var_.data[jcpage.var_.game] = data;
            //组合回查下拉查询框
            //jcpage.dymanic_.callbackSelect(t);
            //组合联盟信息
            //jcpage.dymanic_.getLeagues(leagues.elements);
        },
        staticHtml: {
            header: function (date) {

                if (PollNum) {
                    var PollNum1 = PollNum.split("|")[0].split(",");
                    for (var n = 0; n < PollNum1.length; n++) {
                        ele.PollNum_t[n] = PollNum1[n].split("=")[0];
                        ele.PollNum_c[n] = PollNum1[n].split("=")[1];
                    }
                }
                var h = "", d = date.toFormatString("MM-dd"), week = jcpage.constant_.wk[date.getDay()];
                if (play != null && play == "hh" && gameCode == "jclq") {
                    h = "<section class=\"jclqHh\">";
                }
                else if (play != null && play == "sf" && gameCode == "jclq") {
                    h = "<section class=\"jclqVs\">";
                }
                else if (play != null && play == "rfsf" && gameCode == "jclq") {
                    h = "<section class=\"jclqVs\">";
                }
                else if (play != null && play == "dxf" && gameCode == "jclq") {
                    h = "<section class=\"jclqDxf\">";
                }
                else {
                    h += "<section class=\"jclqSfc\">";
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
            bf: function (id, sp) {
                return "<li id=\"" + id + "\" class=\"p\"><a class=\"bet\" href=\"javascript:\"><sup></sup><span>" + fix(sp) + "</span><em class=\"tip\"></em></a></li>";
            },
            sfc: function (id, text, sp) {
                return "<td width=\"75\" id=\"" + id + "\" class=\"p\"><a class=\"bet\" href=\"javascript:\"><b>" + text + "</b><em class=\"sp\">" + fix(sp) + "</em></a></td>";
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
            getyxo: function (fxid) {
                var href = "<td class=\"datas\">";
                if (fxid == 0) {
                    href += "<a target=\"_blank\" href=\"javascript:void(0)\">亚</a><a target=\"_blank\" href=\"javascript:void(0)\">欧</a><a target=\"_blank\" href=\"javascript:void(0)\">析</a>";
                } else {
                    href += "<a target=\"_blank\" href=\"/odds?zsurl=/match/asia/" + fxid + "\">亚</a><a target=\"_blank\" href=\"/odds?zsurl=/match/odds/" + fxid + "\">欧</a><a target=\"_blank\" href=\"/odds?zsurl=/match/analysis/" + fxid + "\">析</a>";
                }
                //                if (play == "spf") {
                //                    href += "<a target=\"_blank\" href=\"/betPointList/index?gameCode=jclq&matchId=" + matchdata + "_" + matchnumber + "\">评</a></td>";
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
            for (var i in arr) {
                if (typeof (arr[i]) == "function") break;
                if (parseFloat(arr[i]) <= 0) return true; 
            }
            return false;
        }
    },
    dymanic_: {
        //动态内容
        startMatch: function(data) {
            if (jcpage.var_.game.toLowerCase() == "jclq") {
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
                    //页面加载完成后 bind事件（针对延迟）
                    jcpagebind.bind_delay();
                    jcpagebind.my_play();
                    //$("#hideNum,#endNum").text(jcpage.var_.hideTr.size());
                }
            }
        },
        html: {
            commonHtml: function(item, endTime, sale) {
                var h = "", st = stringToDateTime(item.FSStopBettingTime);
                h += "<li class=\"li_weige\">";
                h += "<em>" + item.MatchNumber + "</em>";
                h += "<p>" + item.LeagueName + "</p>";
                h += "<cite>" + st.toFormatString("HH:mm") + " </cite></li>";
                return h;
                //                abbr = item.MatchIdName + "|" + item.HomeTeamName + "|" + item.GuestTeamName + "|" + item.LetBall + "|" + (jcpage.var_.isDg ? dsst.toFormatString("yyyy-MM-dd HH:mm:ss") : st.toFormatString("yyyy-MM-dd HH:mm:ss"));
                //                d = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate() - 1);
                //                h[h.length] = "<tr class=\"mtr" + (sale == 0 ? " hide_tr" : "") + "\" sale=\"" + sale + "\" league=\"" + item.LeagueName + "\" name=\"" + d.toFormatString("yyyyMMdd") + "\" abbr=\"" + abbr + "\" id=\"" + item.MatchId + "\">";
                //                //场
                //                h[h.length] = "<td class=\"show\"><p><span>" + item.MatchIdName + "</span><s title=\"隐藏\" class=\"del\" onclick=\"jcpage.dymanic_.ftdClick(" + item.MatchId + ",'" + item.MatchIdName + "')\"></s></p></td>";
                //                //赛事
                //                h[h.length] = "<td style=\"color:#FFFFFF;background-color:#" + item.LeagueColor + "\"><a href='" + jcpage.static_.staticHtml.getLeagueHref(item.LeagueId, item.FXId) + "' class=\"white\" title=\"" + item.LeagueName + "\">" + item.LeagueName.slice(0, 3) + "</a></td>";
                //                d = stringToDateTime(item.StartDateTime);
                //                //开赛时间
                //                h[h.length] = "<td><span title=\"开赛时间:" + d.toFormatString("yyyy-MM-dd HH:mm") + "\" class=\"b_time hide\">" + d.toFormatString("HH:mm") + "</span>";
                //                if (jcpage.var_.isDg) {
                //                    //单式上传
                //                    //截止时间
                //                    h[h.length] = "<span title=\"截止时间:" + dsst.toFormatString("yyyy-MM-dd HH:mm") + "\"" + (dsst <= servertime ? " class=e_time red" : "class=e_time") + ">" + (dsst <= servertime ? "截止" : dsst.toFormatString("HH:mm")) + "</span></td>";
                //                } else {
                //                    //截止时间
                //                    h[h.length] = "<span title=\"截止时间:" + st.toFormatString("yyyy-MM-dd HH:mm") + "\"" + (st <= servertime ? " class=e_time red" : "class=e_time") + ">" + (st <= servertime ? "截止" : st.toFormatString("HH:mm")) + "</span></td>";
                //                }
                //return h.join("");
            },
            SF: function(item, stoptime, sale, i, play) {
                var itemid = item.MatchId;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, play);
                if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                    var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                    pc = pc.split("/");
                    h += "<ul v='y'  c='" + pc + "' class=\"sfcxs\" t='" + item.MatchId + "'>";
                } else {
                    h += "<ul class=\"sfcxs\" t='" + item.MatchId + "'>";
                }

                h += str;
                h += "<li >";
                h += "<p class=\"spfzpk spfzpk2\">";
                var sf =$.parseJSON(item.SF);


                if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                    var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                    pc = pc.split("/");
                    h += "<span  v=\"0\" class='" + (pc.indexOf("0") >= 0 ? "cur" : sf == null ? "no_dg unsale" : "") + "' sp='" + (sf == null ? "0.00" : sf.LoseSP) + "'>";
                    h += "<em>" + item.GuestTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "<b>VS</b>";
                    h += "<span  v=\"3\" class='" + (pc.indexOf("3") >= 0 ? "cur" : sf == null ? "no_dg unsale" : "") + "' sp='" + (sf == null ? "0.00" : fix(sf.WinSP)) + "'>";
                    h += "<em>" + item.HomeTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p class=\"spfpl\"><span>赔率" + (sf == null ? "0.00" : fix(sf.LoseSP)) + "</span><span>赔率" +(sf == null ? "0.00" : fix(sf.WinSP)) + "</span></p>";
                } else {
                    h += "<span  v=\"0\" class='" + ( sf == null ? "no_dg unsale" : "") + "' sp='" +(sf == null ? "0.00" : sf.LoseSP) + "'>";
                    h += "<em>" + item.GuestTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "<b>VS</b>";
                    h += "<span  v=\"3\" class='" + (sf == null ? "no_dg unsale" : "") + "' sp='" + (sf == null ? "0.00" : fix(sf.WinSP)) + "'>";
                    h += "<em>" + item.HomeTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p class=\"spfpl\"><span>赔率" + (sf == null ? "0.00" : fix(sf.LoseSP)) + "</span><span>赔率" + (sf == null ? "0.00" : fix(sf.WinSP)) + "</span></p>";
                }
                h += "</li>";
                h += "</ul> ";
                return h;
            },
            RFSF: function(item, stoptime, sale) {
                var itemid = item.MatchId;
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), html = jcpage.static_.staticHtml;
                if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                    var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                    pc = pc.split("/");
                    h += "<ul v='y'  c=" + pc + " class=\"sfcxs\" t=" + item.MatchId + ">";
                } else {
                    h += "<ul class=\"sfcxs\" t=" + item.MatchId + ">";
                }
                h += str;
                h += "<li>";
                var rfsf = $.parseJSON(item.RFSF);
                console.log(rfsf);
                 if (PollNum && ele.PollNum_t.indexOf(itemid) >= 0) {
                    var pc = ele.PollNum_c[ele.PollNum_t.indexOf(itemid)];
                    pc = pc.split("/");
                    h += "<p class=\"spfzpk spfzpk2\">";
                    h += "<span  class='"+(pc.indexOf("0") >= 0 ? "cur" :rfsf==null?"no_dg unsale":"")+"' v=\"0\"  sp='" + (rfsf==null? "0.00" : fix(rfsf.LoseSP)) + "'>";
                    h += "<em>" + item.GuestTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "<b>VS</b>";
                    h += "<span  v=\"3\"  class='"+(pc.indexOf("3") >= 0 ? "cur" : rfsf==null?"no_dg unsale":"")+"' sp='" + (rfsf==null ? "0.00" : fix(rfsf.WinSP))  + "'>";
                    h += "<em>" + item.HomeTeamName + "<i class=\"" + (rfsf==null ? "" : rfsf.RF > 0 ? "red" : "blue") + "\">(" + (rfsf==null ? "0" : fix(rfsf.RF)) + ")</i></em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p class=\"spfpl\"><span>" + (rfsf==null ? "0.00" : fix(rfsf.LoseSP)) + "</span><span>" + (rfsf==null ? "0.00" : fix(rfsf.WinSP)) + "</span></p>";
                } else {
                    h += "<p class=\"spfzpk spfzpk2\">";
                    h += "<span  v=\"0\" class='"+(rfsf==null?"no_dg unsale":"")+"' sp='" + (rfsf==null ? "0.00" : fix(rfsf.LoseSP)) + "'>";
                    h += "<em>" + item.GuestTeamName + "</em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "<b>VS</b>";
                    h += "<span  v=\"3\"  class='"+(rfsf==null?"no_dg unsale":"")+"' sp='" + (rfsf==null ? "0.00" : fix(rfsf.WinSP)) + "'>";
                    h += "<em>" + item.HomeTeamName + "<i class=\"" + (rfsf==null ? "0" : rfsf.RF > 0 ? "red" : "blue") + "\">(" + (rfsf==null ? "0" : fix(rfsf.RF)) + ")</i></em>";
                    h += "<cite>胜</cite>";
                    h += "</span>";
                    h += "</p>";
                    h += "<p class=\"spfpl\"><span>" + (rfsf==null ? "0.00" : fix(rfsf.LoseSP)) + "</span><span>" + (rfsf==null ? "0.00" : fix(rfsf.WinSP)) + "</span></p>";
                }



                h += "</li>";
                h += "</ul> ";
                return h;
            },
            SFC: function(item, stoptime, sale, i, play) {
                var vari = jcpage.var_;
                var h = [], str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale, i, play), matchid = item.MatchId, html = jcpage.static_.staticHtml, p = "", code = "";
                var sfc = $.parseJSON(item.SFC);

                if (PollNum != "" && $.inArray(matchid, ele.PollNum_t) > -1) {
                    p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                    h[h.length] = "<ul class=\"sfcxs\" t='" + matchid + "' v='y' c='" + p.replace(/\//g, ",") + "'>";
                    var c = p.split('/');
                    if (c.length > 5) {
                        code += "已选" + c.length + "项";
                    }
                    $.each(c, function(k, v) {
                        var z = jcpage.constant_.sfccode[v];
                        var h = "";
                        if (v.indexOf("0") == 0)
                            h = "主胜";
                        else
                            h = "客胜";

                        code += "<cite " + (c.length > 5 ? "style='display:none'" : "") + " sp='" + sfc[z] + "' v='" + v + "'>" + h + v + "</cite>";

                    });
                } else {
                    h[h.length] = "<ul class=\"sfcxs\" t='" + matchid + "'>";
                }

                h[h.length] = str;
                h[h.length] = "<li>";
                h[h.length] = "<p class=\"spfzpkNum\">";
                h[h.length] = "<span>" + item.GuestTeamName+ "</span>";
                h[h.length] = "<span class=\"spfvs\">VS</span>";
                h[h.length] = "<span>" + item.HomeTeamName + "</span>";
                h[h.length] = "</p>";
                h[h.length] = "<p class=\"spfzpk bfpk\">";
                h[h.length] = "<span " + (code != "" ? "class='cur'" : "") + " >" + (code != "" ? code : "立即投注") + "</span>";
                h[h.length] = "</p>";
                h[h.length] = "</li>";
                h[h.length] = "</ul>";
                h[h.length] = "<div style=\"margin-top: -170px; display:none;\" class=\"bfPop sfc_\">";
                h[h.length] = "<div class=\"bfTitle clearfix\">";
                h[h.length] = "<p>" + item.GuestTeamName + "";
                h[h.length] = "<span class=\"right\">";
                h[h.length] = "<em>V</em>";
                h[h.length] = "</span>";
                h[h.length] = "</p>";
                h[h.length] = "<p>";
                h[h.length] = "<span class=\"left\">";
                h[h.length] = "<em>S</em>";
                h[h.length] = "</span>" + item.HomeTeamName + "";
                h[h.length] = "</p>";
                h[h.length] = "</div>";
                h[h.length] = "<div class=\"competitions1 bfcom\">";
                h[h.length] = "<i class=\"chazhi\" disabled='false'>差值：1-5</i>";
                h[h.length] = "<span v='11' class='" + (sfc == null ? "unsale" : "") + "' sp='" +(sfc==null?"0.00":fix(sfc.GuestWin1_5))  + "'" + (p.indexOf("11") > -1 ? "class='cur'" : "") + " ><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin1_5))+ "</em></span>";
                h[h.length] = "<span v='01' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin1_5)) + "'" + (p.indexOf("10") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin1_5)) + "</em></span>";
                h[h.length] = "<i class=\"chazhi\">差值：6-10</i>";
                h[h.length] = "<span v='12' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.GuestWin6_10)) + "'" + (p.indexOf("12") > -1 ? "class='cur'" : "") + "><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin6_10)) + "</em></span>";
                h[h.length] = "<span v='02' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin6_10)) + "'" + (p.indexOf("02") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin6_10)) + "</em></span>";
                h[h.length] = "<i class=\"chazhi\">差值：11-15</i>";
                h[h.length] = "<span v='13' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.GuestWin11_15)) + "'" + (p.indexOf("13") > -1 ? "class='cur'" : "") + "><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin11_15)) + "</em></span>";
                h[h.length] = "<span v='03' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin11_15)) + "'" + (p.indexOf("03") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin11_15)) + "</em></span>";
                h[h.length] = "<i class=\"chazhi\">差值：16-20</i>";
                h[h.length] = "<span v='14' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.GuestWin16_20)) + "'" + (p.indexOf("14") > -1 ? "class='cur'" : "") + "><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin16_20)) + "</em></span>";
                h[h.length] = "<span v='04' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin16_20)) + "'" + (p.indexOf("04") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin16_20)) + "</em></span>";
                h[h.length] = "<i class=\"chazhi\">差值：21-25</i>";
                h[h.length] = "<span v='15'  class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.GuestWin21_25)) + "'" + (p.indexOf("15") > -1 ? "class='cur'" : "") + "><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin21_25)) + "</em></span>";
                h[h.length] = "<span v='05' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin21_25)) + "'" + (p.indexOf("05") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin21_25)) + "</em></span>";
                h[h.length] = "<i class=\"chazhi\">差值：25+</i>";
                h[h.length] = "<span v='16' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.GuestWin26)) + "'" + (p.indexOf("16") > -1 ? "class='cur'" : "") + "><em>客胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.GuestWin26)) + "</em></span>";
                h[h.length] = "<span v='06' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc==null?"0.00":fix(sfc.HomeWin26)) + "'" + (p.indexOf("06") > -1 ? "class='cur'" : "") + "><em>主胜</em><em>赔率" + (sfc==null?"0.00":fix(sfc.HomeWin26))+ "</em></span>";
                h[h.length] = "<div class=\"clear\"></div>";
                h[h.length] = "</div>";
                h[h.length] = "<div class=\"zfTrue clearfix\">";
                h[h.length] = "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h[h.length] = "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h[h.length] = "</div>";
                h[h.length] = "</div>";
                //}
                return h.join("");
            },
            DXF: function(item, stoptime, sale) {
                var vari = jcpage.var_;
                var h = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId, html = jcpage.static_.staticHtml;
                var dxf = $.parseJSON(item.DXF);
                    
                    var p = "";
                    if ($.inArray(matchid, ele.PollNum_t) > -1) {
                        p = ele.PollNum_c[$.inArray(matchid, ele.PollNum_t)];
                        h += "<ul class=\"sfcxs\" t='" + matchid + "' v='y' c='" + p.replace(/\//g, "") + "'>";
                    } else {
                        h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                    }
                    h += str;
                    h += "<li>";
                    h += "<p class=\"spfzpkNum\">";
                    h += "<span>" + item.GuestTeamName + "</span>";
                    h += "<span class=\"spfvs\">VS</span>";
                    h += "<span>" + item.HomeTeamName + "</span>";
                    h += "</p>";
                    h += "<p class=\"spfzpk\">";
                    h += "<span v='3' class='" + (jcpage.static_.checkSp(dxf) ? "no_dg unsale" : "") + "' sp='" + (dxf==null?"0.00":fix(dxf.DF)) + "'" + (p.indexOf("3") > -1 ? "class='cur'" : "") + " >总分&gt;" + (dxf==null?"0.00":dxf.YSZF) + "</span>";
                    h += "<span v='0' class='" + (jcpage.static_.checkSp(dxf) ? "no_dg unsale" : "") + "' sp='" + (dxf==null?"0.00":fix(dxf.XF)) + "'" + (p.indexOf("0") > -1 ? "class='cur'" : "") + ">总分&lt;" + (dxf==null?"0.00":dxf.YSZF) + "</span>";
                    h += "</p>";
                    h += "<p class=\"spfpl\">";
                    h += "<span >赔率" + (dxf==null?"0.00":fix(dxf.DF)) + "</span>";
                    h += "<span >赔率" + (dxf==null?"0.00":fix(dxf.XF)) + "</span>";
                    h += "</p>";
                    h += "</li>";
                    h += "</ul>";
                return h;
            },
            HH: function(item, stoptime, sale, i) {
                var vari = jcpage.var_;
                var h = "", j = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId, html = jcpage.static_.staticHtml;
                var sf = JSON.parse(item.SF),
                    rfsf = JSON.parse(item.RFSF),
                    sfc = JSON.parse(item.SFC),
                    dxf = JSON.parse(item.DXF);
                h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                h += str;
                h += "<li>";
                h += "<p class=\"spfzpkNum\">";
                h += "<span>" + item.GuestTeamName + "</span>";
                h += "<span class=\"spfvs\">VS</span>";
                h += "<span>" + item.HomeTeamName + "</span>";
                h += "</p>";
                h += "<p class=\"spfzpk spfzpk2\">";
                h += "<span class=\"sf" + (sf == null ? " no_dg" : "") + "\" id='sf'>胜负</span>";
                h += "<span class=\"sfc\" id='sfc'>胜负差</span>";
                h += "<span class=\"dxf\" id='dxf'>大小分</span>";
                h += "<span class=\"rf\" id='rf'>让分胜负</span>";
                h += "</p>";
                h += "</li>";
                h += "</ul>";
                //胜负
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop sf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";

                h += "<div class=\"competitions bfcom\">";
                h += "<span v='0' class='" + (sf == null ? "unsale" : "") + "' sp='" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.LoseSP))  + "'><strong>客胜</strong><em>" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.LoseSP)) + "</em></span>";
                h += "<span v='3' class='" + (sf == null ? "unsale" : "") + "' sp='" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.WinSP)) + "'><strong>主胜</strong><em>" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.WinSP)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";

                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";


                //胜负差
                h += "<div style=\"margin-top: -170px; display:none;\" class=\"bfPop sfc_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";

                h += "<div class=\"competitions1 bfcom\">";
                h += "<i class=\"chazhi\" disabled='false'>差值：1-5</i>";
                h += "<span v='11' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin1_5)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin1_5)) + "</em></span>";
                h += "<span v='01' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin1_5)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin1_5)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：6-10</i>";
                h += "<span v='12' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin6_10)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin6_10)) + "</em></span>";
                h += "<span v='02' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin6_10)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin6_10)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：11-15</i>";
                h += "<span v='13' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin11_15)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin11_15)) + "</em></span>";
                h += "<span v='03' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin11_15)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin11_15)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：16-20</i>";
                h += "<span v='14' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin16_20)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin16_20)) + "</em></span>";
                h += "<span v='04' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin16_20)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin16_20)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：21-25</i>";
                h += "<span v='15' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin21_25)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin21_25)) + "</em></span>";
                h += "<span v='05' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin21_25)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin21_25)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：25+</i>";
                h += "<span v='16' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin26)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin26)) + "</em></span>";
                h += "<span v='06' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin26)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin26)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";

                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";

                //大小分
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop dxf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";

                h += "<div class=\"competitions bfcom\">";
                h += "<span v='3' class='" + (jcpage.static_.checkSp(dxf) ? "unsale" : "") + "' sp='" + (dxf == null ? "0.00" : fix(dxf.DF)) + "'><em>总分>" + (dxf != null ? dxf.YSZF : "0") + "</em><em>" + (dxf == null ? "0.00" : fix(dxf.DF)) + "</em></span>";
                h += "<span v='0' class='" + (jcpage.static_.checkSp(dxf) ? "unsale" : "") + "' sp='" + (dxf == null ? "0.00" : fix(dxf.XF)) + "'><em>总分<" + (dxf != null ? dxf.YSZF : "0") + "</em><em>" + (dxf == null ? "0.00" : fix(dxf.XF)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";

                //让分胜负
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop rf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>";
                h += "" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";
                h += "<div class=\"competitions bfcom\">";
                h += "<span v='0' class='" + (rfsf.LoseSP==0 ? "unsale" : "") + "'  sp='" + (rfsf.LoseSP==0 ? "0.00" : fix(rfsf.LoseSP)) + "'><em>客胜</em><em>" + (rfsf.LoseSP==0 ? "0.00" : fix(rfsf.LoseSP)) + "</em></span>";
                h += " <span v='3' class='" + (rfsf.WinSP == 0 ? "unsale" : "") + "'  sp='" + (rfsf.WinSP == 0 ? "0.00" : fix(rfsf.WinSP)) + "'><em>主胜<i class=\"red\">" +( rfsf.RF > 0 ? "(+" + rfsf.RF + ")" : "(" + rfsf.RF + ")" )+ "</i></em><em>" + (rfsf.WinSP == 0 ? "0.00" : fix(rfsf.WinSP)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";
                // }

                return h;
            },
            DGGD: function(item, stoptime, sale) {
                var vari = jcpage.var_;
                var h = "", j = "", str = jcpage.dymanic_.html.commonHtml(item, stoptime, sale), matchid = item.MatchId, html = jcpage.static_.staticHtml;
                var sf = JSON.parse(item.SF),
                    rfsf = JSON.parse(item.RFSF),
                    sfc = JSON.parse(item.SFC),
                    dxf = JSON.parse(item.DXF);
                h += "<ul class=\"sfcxs\" t='" + matchid + "'>";
                h += str;
                h += "<li>";
                h += "<p class=\"spfzpkNum\">";
                h += "<span>" + item.GuestTeamName + "</span>";
                h += "<span class=\"spfvs\">VS</span>";
                h += "<span>" + item.HomeTeamName + "</span>";
                h += "</p>";
                h += "<p class=\"spfzpk spfzpk2\">";
                h += "<span class=\"sf "+(item.State.indexOf("1")>-1?"":"no_dg")+"\" id='sf'>胜负</span>";
                h += "<span class=\"sfc "+(item.State.indexOf("3")>-1?"":"no_dg")+"\" id='sfc'>胜负差</span>";
                h += "<span class=\"dxf "+(item.State.indexOf("4")>-1?"":"no_dg")+"\" id='dxf'>大小分</span>";
                h += "<span class=\"rf "+(item.State.indexOf("2")>-1?"":"no_dg")+"\" id='rf'>让分胜负</span>";
                h += "</p>";
                h += "</li>";
                h += "</ul>";
                //胜负
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop sf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";

                h += "<div class=\"competitions bfcom\">";
                h += "<span v='0' class='" + (jcpage.static_.checkSp(sf) == null ? "unsale" : "") + "' sp='" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.LoseSP))  + "'><strong>客胜</strong><em>" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.LoseSP)) + "</em></span>";
                h += "<span v='3' class='" + (jcpage.static_.checkSp(sf) == null ? "unsale" : "") + "' sp='" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.WinSP)) + "'><strong>主胜</strong><em>" + (jcpage.static_.checkSp(sf)?"0.00":fix(sf.WinSP)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";

                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";


                //胜负差
                h += "<div style=\"margin-top: -170px; display:none;\" class=\"bfPop sfc_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";

                h += "<div class=\"competitions1 bfcom\">";
                h += "<i class=\"chazhi\" disabled='false'>差值：1-5</i>";
                h += "<span v='11' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin1_5)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin1_5)) + "</em></span>";
                h += "<span v='01' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin1_5)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin1_5)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：6-10</i>";
                h += "<span v='12' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin6_10)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin6_10)) + "</em></span>";
                h += "<span v='02' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin6_10)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin6_10)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：11-15</i>";
                h += "<span v='13' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin11_15)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin11_15)) + "</em></span>";
                h += "<span v='03' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin11_15)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin11_15)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：16-20</i>";
                h += "<span v='14' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin16_20)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin16_20)) + "</em></span>";
                h += "<span v='04' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin16_20)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin16_20)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：21-25</i>";
                h += "<span v='15' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin21_25)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin21_25)) + "</em></span>";
                h += "<span v='05' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin21_25)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin21_25)) + "</em></span>";
                h += "<i class=\"chazhi\">差值：25+</i>";
                h += "<span v='16' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.GuestWin26)) + "'><em>客胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.GuestWin26)) + "</em></span>";
                h += "<span v='06' class='" + (sfc == null ? "unsale" : "") + "' sp='" + (sfc == null ? "0.00" : fix(sfc.HomeWin26)) + "'><em>主胜</em><em>赔率" + (sfc == null ? "0.00" : fix(sfc.HomeWin26)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";

                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";

                //大小分
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop dxf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";

                h += "<div class=\"competitions bfcom\">";
                h += "<span v='3' class='" + (jcpage.static_.checkSp(dxf) ? "unsale" : "") + "' sp='" + (dxf == null ? "0.00" : fix(dxf.DF)) + "'><em>总分>" + (dxf != null ? dxf.YSZF : "0") + "</em><em>" + (dxf == null ? "0.00" : fix(dxf.DF)) + "</em></span>";
                h += "<span v='0' class='" + (jcpage.static_.checkSp(dxf) ? "unsale" : "") + "' sp='" + (dxf == null ? "0.00" : fix(dxf.XF)) + "'><em>总分<" + (dxf != null ? dxf.YSZF : "0") + "</em><em>" + (dxf == null ? "0.00" : fix(dxf.XF)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";

                //让分胜负
                h += "<div style=\"margin-top: -100px; display:none;\" class=\"bfPop rf_\">";
                h += "<div class=\"bfTitle clearfix\">";
                h += "<p>" + item.GuestTeamName + "";
                h += "<span class=\"right\">";
                h += "<em>V</em>";
                h += "</span>";
                h += "</p>";
                h += "<p>";
                h += "<span class=\"left\">";
                h += "<em>S</em>";
                h += "</span>";
                h += "" + item.HomeTeamName + "";
                h += "</p>";
                h += "</div>";
                h += "<p></p>";
                h += "<div class=\"competitions bfcom\">";
                h += "<span v='0' class='" + (rfsf.LoseSP == 0 ? "unsale" : "") + "'  sp='" + (rfsf.LoseSP == 0 ? "0.00" : fix(rfsf.LoseSP)) + "'><em>客胜</em><em>" + (rfsf.LoseSP == 0 ? "0.00" : fix(rfsf.LoseSP)) + "</em></span>";
                h += " <span v='3' class='" + (rfsf.WinSP == 0 ? "unsale" : "") + "'  sp='" + (rfsf.WinSP == 0 ? "0.00" : fix(rfsf.WinSP)) + "'><em>主胜<i class=\"red\">" + (rfsf.RF > 0 ? "(+" + rfsf.RF + ")" : "(" + rfsf.RF + ")") + "</i></em><em>" + (rfsf.WinSP == 0 ? "0.00" : fix(rfsf.WinSP)) + "</em></span>";
                h += "<div class=\"clear\"></div>";
                h += "</div>";
                h += "<div class=\"zfTrue clearfix\">";
                h += "<a class=\"zfqx\"  href=\"javascript:;\">取 消</a>";
                h += "<a class=\"zfqr\" href=\"javascript:;\">确 定</a>";
                h += "</div>";
                h += "</div>";
                // }

                return h;
            }
        },
        update: {
            updateSp: function() { //定时更新赔率
                try {
                    //请求比赛信息
                    var gameSp = dres + gameCode + "/" + (play == "hh" ? "sp" : play + "_sp") + ".json?v=" + Math.random();
                    data = null;
                    $.getScript(gameSp, function() {
                        if (data != null && typeof (data) != "undefined" && data.length > 0) {
                            jcpage.dymanic_.update.upDateSpInfo(data);
                            setTimeout("jcpage.dymanic_.update.clearArrow()", 20 * 1000);
                        }
                    });
                } catch (e) {
                    alert(e);
                }
            },
            clearArrow: function() {
                $(".tip").empty();
            },
            upDateSpInfo: function(data) {
                var id, tr, play = jcpage.var_.play.toLowerCase();
                var getSp = jcpage.dymanic_.update.getSp;
                var i, l;
                if (play == "hh") {
                    for (i = 0, l = data.length; i < l; i++) {
                        id = data[i].MatchId;
                        //更新第一行
                        tr = $("#" + id);
                        jcpage.dymanic_.update.replacesp(tr, getSp, id, i);
                        //更新第二行
                        tr = tr.next("tr");
                        jcpage.dymanic_.update.replacesp(tr, getSp, id, i);
                    }
                } else {
                    var flag = true;
                    if (play == "bf") flag = false;
                    for (i = 0, l = data.length; i < l; i++) {
                        id = data[i].MatchId;
                        tr = $("#" + id);
                        if (!flag) tr = tr.next("tr");
                        jcpage.dymanic_.update.replacesp(tr, getSp, id, i);
                    }
                }
                setTimeout("jcpage.dymanic_.update.updateSp()", 60 * 1000);
            },
            replacesp: function(tr, getSp, id, i) {
                if (tr) {
                    if (tr.attr("sale") == 1) {
                        var arr = getSp[play](data[i]);
                        for (var j in arr) {
                            if (typeof (arr[j]) == "function") break;
                            var td = $("#" + id + "_" + j);
                            if (td) {
                                var old = fix(td.find("span").html());
                                if (arr[j] > old) {
                                    td.find("em.tip").addClass("redtip").html("↑").prev('span').html(arr[j]);
                                } else if (arr[j] < old) {
                                    td.find("em.tip").addClass("bluetip").html("↓").prev('span').html(arr[j]);
                                }
                            }
                        }
                    }
                }
            },
            getSp: {
                sf: function(obj) {
                    var sf = obj;
                    var spobj = { sf_3: fix(sf.WinSP), sf_0: fix(sf.LoseSP) };
                    return spobj;
                },
                rfsf: function(obj) {
                    var rfsf = obj;
                    var spobj = { rfsf_3: fix(rfsf.WinSP), rfsf_0: fix(rfsf.LoseSP) };
                    return spobj;
                },
                sfc: function(obj) {
                    var sfc = obj, spobj;
                    spobj = {
                        sfc_01: fix(sfc.HomeWin1_5),
                        sfc_02: fix(sfc.HomeWin6_10),
                        sfc_03: fix(sfc.HomeWin11_15),
                        sfc_04: fix(sfc.HomeWin16_20),
                        sfc_05: fix(sfc.HomeWin21_25),
                        sfc_06: fix(sfc.HomeWin26),
                        sfc_11: fix(sfc.GuestWin1_5),
                        sfc_12: fix(sfc.GuestWin6_10),
                        sfc_13: fix(sfc.GuestWin11_15),
                        sfc_14: fix(sfc.GuestWin16_20),
                        sfc_15: fix(sfc.GuestWin21_25),
                        sfc_16: fix(sfc.GuestWin26)
                    };
                    return spobj;
                },
                dxf: function(obj) {
                    var dxf = obj, spobj;
                    spobj = {
                        dxf_3: fix(dxf.DF),
                        dxf_0: fix(dxf.XF)
                    };
                    return spobj;
                },
                hh: function(obj) {
                    var spobj;
                    var sf = JSON.parse(obj.SF),
                        rfsf = JSON.parse(obj.RFSF),
                        sfc = JSON.parse(obj.SFC),
                        dxf = JSON.parse(obj.DXF);
                    spobj = {
                        sf_3: fix(sf.WinSP),
                        sf_0: fix(sf.LoseSP),
                        rfsf_3: fix(rfsf.WinSP),
                        rfsf_0: fix(rfsf.LoseSP),
                        sfc_01: fix(sfc.HomeWin1_5),
                        sfc_02: fix(sfc.HomeWin6_10),
                        sfc_03: fix(sfc.HomeWin11_15),
                        sfc_04: fix(sfc.HomeWin16_20),
                        sfc_05: fix(sfc.HomeWin21_25),
                        sfc_06: fix(sfc.HomeWin26),
                        sfc_11: fix(sfc.GuestWin1_5),
                        sfc_12: fix(sfc.GuestWin6_10),
                        sfc_13: fix(sfc.GuestWin11_15),
                        sfc_14: fix(sfc.GuestWin16_20),
                        sfc_15: fix(sfc.GuestWin21_25),
                        sfc_16: fix(sfc.GuestWin26),
                        dxf_3: fix(dxf.DF),
                        dxf_0: fix(dxf.XF)
                    };
                    return spobj;
                }
            },
            updateMatchTime: function() {
                var tr, id, matchtime, flag = false;
                var endtrs = jcpage.var_.endTr;
                if (play == "hh" || play == "bf") flag = true;

                $("tr[abbr][sale=1]").each(function(index, item) {
                    tr = $(item);
                    id = tr.attr("id");
                    matchtime = tr.attr("abbr").split("|")[4];
                    if (matchtime) {
                        if (servertime >= new Date(matchtime)) {
                            tr.attr("sale", 0).addClass("hide_tr");;
                            tr.children("td:eq(2)").addClass("red").html("截止");
                            if (flag) {
                                //第一行
                                tr.find(".p,.q").unbind("click");
                                //第二行
                                tr.next("tr").find(".p,.q,.all").unbind("click");
                            } else {
                                tr.find(".p,.q").unbind("click");
                            }
                            $("#id_" + id + " dans").attr("checked", 0).attr("disabled", "disabled");
                            if (!endtrs.contain(id)) endtrs.push(id);
                        }
                    }
                });
                $("#endNum").text(endtrs.size());
                setTimeout("jcpage.dymanic_.update.updateMatchTime()", 60 * 1000);
            }
        }
    }
};

var jcpagebind = {
    bind_delay: function () {
        $(".sfcTitle").Touch(function () {
            $(this).find("em").toggleClass("down");
            $(this).next().slideToggle(300)
        });
        $("#content_").find(".jclqVs ul.sfcxs p.spfzpk span").Touch(function () {
         if ($(this).hasClass("unsale")) return false;
            var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
            var n_ = 15;
            if (c_ >= n_ && !$(this).parent().find(".cur").length) {
                Box.tx("最多选" + n_ + "场");
                return
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
            jcpagebind.my_play();
        });
        $("#content_").find(".jclqHh ul.sfcxs p.spfzpk span").not(".no_dg").Touch(function () {
            $(".zhezhao").show();
            //var this_class = $(this).attr("class");
            if ($(this).hasClass("sf")) {
                $(this).closest(".sfcxs").nextAll("[class$='sf_']:first").show();
            }
            if ($(this).hasClass("sfc")) {
                $(this).closest(".sfcxs").nextAll("[class$='sfc_']:first").show();
            }
            if ($(this).hasClass("dxf")) {
                $(this).closest(".sfcxs").nextAll("[class$='dxf_']:first").show();
            }
            if ($(this).hasClass("rf")) {
                $(this).closest(".sfcxs").nextAll("[class$='rf_']:first").show();
            }
        });
        $("#content_").find(".jclqDxf ul.sfcxs p.spfzpk span").Touch(function() {
            if ($(this).hasClass("unsale")) return false;
          var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
          var n_ = 15;
          if (c_ > n_ && !$(this).parent().find(".cur").length) {
              Box.tx("最多选" +n_+ "场");
          }
           $(this).toggleClass("cur");
           if ($(this).parent().find("span").hasClass("cur")) {
               var c = "";
               $(this).parent().find("span.cur").each(function() {
                   c += $(this).attr("v") + ","
               });
               c = c.substring(0, c.length - 1);
               $(this).parent().parent().parent().attr("v", "y");
               $(this).parent().parent().parent().attr("c", c);
           } else {
                $(this).parent().parent().parent().removeAttr("v");
                $(this).parent().parent().parent().removeAttr("c");
           }
            jcpagebind.my_play();
        });
        $("#content_").find(".jclqSfc ul.sfcxs p.spfzpk span").Touch(function() {
         $(".zhezhao").show();
            $(this).closest(".sfcxs").nextAll("div.bfPop:first").show();
        });

        $("section[class='jclqHh'] [class*='_']").find("a.zfqx").Touch(function () {
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
            $(this).parent().parent().find(".cur").removeClass("cur");
            public_hh($(this).parent().parent());

        });
        $("section[class='jclqHh'] [class*='_']").find("a.zfqr").Touch(function () {
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
        });

        $("section[class='jclqHh'] .bfPop span").Touch(function () {
            if ($(this).hasClass("unsale")) return false;
            var parentsUntil_ = $(this).closest(".bfPop");
            $(this).toggleClass("cur");
            public_hh(parentsUntil_);
        });
        //胜分差
        $("section[class='jclqSfc'] .bfPop span").Touch(function() {
            if ($(this).hasClass("unsale")) return false;
            var parentsUntil_ = $(this).closest(".bfPop");
            $(this).toggleClass("cur");
            public_sfc(parentsUntil_);
        });
         $("section[class='jclqSfc'] [class*='_']").find("a.zfqx").Touch(function () {
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
            $(this).parent().parent().find(".cur").removeClass("cur");
            public_sfc($(this).parent().parent());

        });
        $("section[class='jclqSfc'] [class*='_']").find("a.zfqr").Touch(function () {
            $(".zhezhao").hide();
            $(this).parent().parent().hide();
        });
    },
    my_play: function () {
        var c_ = $("#content_ section").find("div:eq(1) ul[v=y]").length;
        $("#c_").html(c_);
    },
    bind_: function () {
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

        $("#wanfa_").Touch(function () {
            $(this).toggleClass("hmTit");
            $(this).next().toggle()
        });

        $(".deleted").Touch(function () {
            if (play.toLowerCase()=="hh") {
                $("#content_ ul.sfcxs[v=y] span.cur").each(function() {
                      var id = $(this).attr("id");
                    var m = {
                        "sf": "胜负",
                        "rf": "让分胜负",
                        "dxf": "大小分",
                        "sfc": "胜负差"
                    }[id] || "";
                    $(this).html(m);
                    $(this).parent().parent().parent().nextAll("div." + id + "_:first").removeAttr("a").find("span.cur").removeClass("cur");
                });
            }else if (play.toLowerCase() == "sfc") {
                $("#content_ ul.sfcxs[v=y]").find("span.cur").html("立即投注");
                $("#content_ ul.sfcxs[v=y]").next().removeAttr("a").find("span.cur").removeClass("cur");
            }
            $("#content_ ul.sfcxs[v=y]").removeAttr("v").removeAttr("c").find(".cur").removeClass("cur");
            localStorage.removeItem(gameCode.toLowerCase() + play.toLowerCase() + "_PollNum");
            jcpagebind.my_play();
        });

        $("#isOk_").click(function () {
            if ($(this).hasClass("true_disabled")) return false;
            if (parseInt($("#c_").html()) > 1||jcpage.var_.IsDg) {
                var c = "";
                switch (play.toLowerCase()) {
                case "hh":
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
                                if(id=="rf"){
                                    id="rfsf";
                                }
                                var items = "";
                                var item = [];
                                $(this).find("cite").each(function () {
                                    var code = jcpage.constant_.AnteCode[id][$(this).html()];
                                    var sp = $(this).attr("sp");
                            
                                    item.push( $(this).html() + "-" + sp);
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
                        $("#content_ section").find("div:eq(1) ul[v=y]").each(function(k) {
                            var dz = $(this).find("li:eq(1) p:eq(0)").html();
                            var p = $(this).find("li:eq(1) p:eq(1)").html();
                            var sf = $(this).nextAll("div.sf_").eq(0);
                            var sfc = $(this).nextAll("div.sfc_").eq(0);
                            var dxf = $(this).nextAll("div.dxf_").eq(0);
                            var rf = $(this).nextAll("div.rf_").eq(0);
                            c += '<li t="' + $(this).attr("t") + '" v="y">';
                            c += '<cite class="errorBg"><em class="error2"></em></cite>';
                            c += '<div class=\"spfzpkNum\">';
                            c += dz;
                            c += '</div>';
                            c += "<div class=\"spfzpk jclqhh bfpk\">";
                            c += p;
                            c += "</div>";
                            c += "</li>";
                            c += "<div class=\"bfPop sf_\" style=\"display: none; margin-top:-100px\" " + (!sf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += sf.html();
                            c += "</div>";
                            c += "<div class=\"bfPop sfc_\" style=\"display: none;margin-top:-170px\" " + (!sfc.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += sfc.html();
                            c += "</div>";
                            c += "<div class=\"bfPop dxf_\" style=\"display: none;margin-top:-100px\" " + (!dxf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += dxf.html();
                            c += "</div>";
                            c += "<div class=\"bfPop rf_\" style=\"display: none;margin-top:-100px\" " + (!rf.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                            c += rf.html();
                            c += "</div>";
                        });
                    }
                    break;
                case "dxf":
                   $("#content_ section").find("div:eq(1) ul[v=y]").each(function () {
                    var dz = $(this).find("li:eq(1) p:eq(0)").html();
                    var sp = $(this).find("li:eq(1) p:eq(1)").html();
                    var code = $(this).attr("c");
                    c += '<li t="' + $(this).attr("t") + '" c="' + code + '" v="y">';
                    c += '<cite class="errorBg"><em class="error2"></em></cite>';
                    c += '<div class="spfzpkNum">' + dz + "</div>";
                    c += '<div class="spfzpk">' + sp + "</div>";
                         c += "</li>";
                     });
                break;
                case "sf":
                case "rfsf":
                    $("#content_ section").find("div:eq(1) ul[v=y]").each(function() {
                        var dz = $(this).find("li:eq(1) p:eq(0)").html();
                        var sp = $(this).find("li:eq(1) p:eq(1)").html();
                        var code = $(this).attr("c");
                        c += '<li t="' + $(this).attr("t") + '" c="' + code + '" v="y">';
                        c += '<cite class="errorBg"><em class="error2"></em></cite>';
                        c += '<div class="spfzpk spfzpk2">' + dz + "</div>";
                        c += '<div class="spfpl">' + sp + "</div>";
                        c += "</li>";
                    });
                break;
                case "sfc":
                    $("#content_ section").find("div:eq(1) ul[v=y]").each(function() {
                        var dz = $(this).find("li:eq(1) p:eq(0)").html();
                        var p = $(this).find("li:eq(1) p:eq(1)").html();
                        var sfc = $(this).nextAll("div.sfc_").eq(0);
                        var code = $(this).attr("c");
                        c += '<li t="' + $(this).attr("t") + '" v="y" c="'+code+'">';
                        c += '<cite class="errorBg"><em class="error2"></em></cite>';
                        c += '<div class=\"spfzpkNum\">';
                        c += dz;
                        c += '</div>';
                        c += "<div class=\"spfzpk bfpk\">";
                        c += p;
                        c += "</div>";
                        c += "</li>";
                        c += "<div class=\"bfPop sfc_\" style=\"display: none;margin-top:-170px\" " + (!sfc.attr("a") ? '' : 'a="c"') + " id=" + play.toLowerCase() + ">";
                        c += sfc.html();
                        c += "</div>";
                    });
                break;
                }
                //订单提交
                if (jcpage.var_.IsDg) {
                    localStorage.setItem(gameCode + "_dgobj", c);
                    window.location.href = "/buy/dggd/" + gameCode + "/?gametype=" + play.toLowerCase();
                   
                } else {
                    localStorage.setItem(gameCode + play.toLowerCase() + "_SelectNum", c);
                    localStorage.removeItem(gameCode + play.toLowerCase() + "_PollNum");
                    window.location.href = "/buy/zctz/" + gameCode + "/?gametype=" + play.toLowerCase();
                }

            } else {
                Box.tx("请至少选择2场比赛");
            }
        });
    },
};

//公共混合
function public_hh(t) {
    var idx = t.attr("class").indexOf("sfc")>-1 ? "div.competitions1 span.cur" : "div.competitions span.cur";
    var l =t.attr("class").indexOf("sfc")>-1?t.find("div.competitions1 span.cur").length:  t.find("div.competitions span.cur").length;
    var k = "",m="已选",g="";
     var this_attr = t.attr("class");
        var this_attr_hou = this_attr.substring(this_attr.indexOf(" "), this_attr.length - 1);
    if (l) {
        t.attr("a", "c");
        t.prevAll(".sfcxs:first").attr("v", "y");

        //选择效果        
        t.find(idx).each(function () {
            var s = $(this).attr("v");
            var sp = $(this).attr("sp");
            k += s + ",";
            m += "<cite v='"+s+"' sp=\" " + sp + "\" style='display:none'>" + s + "</cite> ";
        });

        //重构span>html
        t.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span#" + this_attr_hou.trim()).html(m);
        t.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span#" + this_attr_hou.trim()).addClass("cur");
        k = k.substr(0, k.length - 1);

    } else {
       
        t.removeAttr("a");
          var sf = t.prevAll("ul.sfcxs:first").nextAll("div.sf_").eq(0);
          var sfc = t.prevAll("ul.sfcxs:first").nextAll("div.sfc_").eq(0);
          var dxf = t.prevAll("ul.sfcxs:first").nextAll("div.dxf_").eq(0);
          var rf = t.prevAll("ul.sfcxs:first").nextAll("div.rf_").eq(0);
        if (!sf.attr("a")&&!sfc.attr("a")&&!dxf.attr("a")&&!rf.attr("a")) {
            t.prevAll("ul.sfcxs:first").removeAttr("v");
        }
        
        g = {
            "sf": "胜负",
            "rf": "让分胜负",
            "dxf": "大小分",
            "sfc": "胜负差"
        }[this_attr_hou.trim()] || g;
        t.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span#" + this_attr_hou.trim()).html(g);
        t.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span#" + this_attr_hou.trim()).removeClass("cur");
    }
    jcpagebind.my_play();
}
//胜分差
function public_sfc(obj) {
    var l = obj.find("span.cur").length;
    if (l) {
        var m = "",k="";
        obj.attr("a", "c");
        obj.prevAll("ul.sfcxs:first").attr("v", "y");
        if (l > 5) {
            m += "已选" + l + "项";
        }
        obj.find("span.cur").each(function() {
            var h = $(this).find("em:eq(0)").html();
            var v = $(this).attr("v");
            var sp = $(this).attr("sp");
            k += v + ",";
            m += "<cite " + (l > 5 ? "style='display:none'" : "") + " sp='" + sp + "' v='" + v + "'>" + h+v + "</cite>";
        });
        obj.prevAll("ul.sfcxs:first").attr("c", k.substring(0, k.length - 1));
        obj.prevAll("ul.sfcxs:first").find("li:eq(1) p:eq(1) span").addClass("cur").html(m);

    } else {
        obj.removeAttr("a");
        obj.prevAll("ul.sfcxs:first").removeAttr("v").find("span.cur").removeClass("cur").html("立即投注");
    }


    jcpagebind.my_play();
}
$(function () {
    jcpage.static_.loadMatches();
    jcpage.var_.game = gameCode;
    jcpage.var_.play = play;
    jcpage.var_.IsDg = oddsType == 1 ? true : false;//单关
    jcpagebind.bind_();
});