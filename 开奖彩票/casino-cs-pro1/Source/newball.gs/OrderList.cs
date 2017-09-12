namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class OrderList : Page
    {
        public string kyglContent = "";

        private void CancelOrderList(string list)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_order SET iscancel=1,isjs=1,win=0,lose=0,mgd=0,mzdl=0,mdls=0,truewin=0 WHERE orderid in(" + list + "0)");
            base2.Dispose();
            MyFunc.JumpPage("取消注单成功", "searchOrder.aspx");
            base.Response.End();
        }

        private void DelOrder(string orderid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("DELETE FROM ball_order WHERE orderid=" + orderid);
            base2.Dispose();
        }

        private string GetOrderList(string start_date, string end_date, string t1, string t2, string isjs, string tztype, string ballid, string gdid, string zdlid, string dlsid, string userid, string username, string orderid, string matchname, string tzmoney, string rr, string iscancel, string iswin)
        {
            int curPage;
            int start;
            int pagesize = 100;
            try
            {
                curPage = int.Parse(base.Request.QueryString["page"].ToString());
            }
            catch
            {
                curPage = 1;
            }
            if (curPage < 1)
            {
                curPage = 1;
            }
            string text = "SELECT  orderid,userid,username,tzmoney,tztype,curpl,win,lose,truewin,hsuser_w,hsuser_l,content,updatetime,iscancel,balltime,isdanger,tzip FROM Ball_order ";
            string text2 = " WHERE gdid in (" + this.Session.Contents["adminarrgd"].ToString().Trim() + "-1) and updatetime BETWEEN '" + start_date + " " + t1 + "' AND '" + end_date + " " + t2 + "' ";
            string text3 = "";
            if (orderid != "")
            {
                text2 = text2 + " AND orderid=" + orderid;
            }
            if (tztype != "")
            {
                text2 = text2 + " AND tztype=" + tztype;
            }
            if (ballid != "")
            {
                text2 = text2 + " AND ballid in (" + ballid + ")";
            }
            if (gdid != "")
            {
                text2 = text2 + " AND gdid=" + gdid;
            }
            if (zdlid != "")
            {
                text2 = text2 + " AND zdlid=" + zdlid;
            }
            if (dlsid != "")
            {
                text2 = text2 + " AND dlsid=" + dlsid;
            }
            if ((userid != "") && (username == ""))
            {
                text2 = text2 + " AND userid='" + userid + "'";
            }
            if ((userid == "") && (username != ""))
            {
                text2 = text2 + " AND username='" + username + "'";
            }
            if ((isjs != "") && (iscancel == ""))
            {
                text2 = text2 + " AND isjs=" + isjs;
            }
            if ((rr != "") && (rr == "0"))
            {
                text2 = text2 + " AND win-lose=0";
            }
            if (tzmoney != "")
            {
                text2 = text2 + " AND tzmoney>=" + tzmoney;
            }
            if ((iscancel != "") && (iscancel != "0"))
            {
                text2 = text2 + " AND iscancel=" + iscancel;
            }
            if (iswin != "")
            {
                if (iswin == "w")
                {
                    text2 = text2 + " AND win>0";
                }
                if (iswin == "s")
                {
                    text2 = text2 + " AND lose > 0";
                }
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int totalRecord = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM Ball_order " + text2).ToString());
            if (totalRecord == 0)
            {
                start = 0;
            }
            else
            {
                start = (curPage - 1) * pagesize;
            }
            DataSet set = base2.ExecuteDataSet(text + text2 + " ORDER BY orderid DESC", start, pagesize, "ball_order");
            double num5 = 0;
            double num6 = 0;
            int num7 = 0;
            string text4 = "";
            for (int i = 0; i < set.Tables[0].Rows.Count; i++)
            {
                string text8 = text3;
                string text9 = text8 + "<tr bgcolor=#FFFFFF><td align=\"center\">" + set.Tables[0].Rows[i]["orderid"].ToString().Trim() + "</td><td align=\"center\">" + DateTime.Parse(set.Tables[0].Rows[i]["updatetime"].ToString().Trim()).ToString("yyyy-MM-dd HH:mm:ss").ToUpper().Replace(" ", "<br>");
                text3 = text9 + "</td><td align=\"center\">" + set.Tables[0].Rows[i]["username"].ToString().Trim() + "</td><td align=\"center\">" + MyFunc.GettzTypeName(set.Tables[0].Rows[i]["tztype"].ToString().Trim()) + "</td><td align=\"right\">" + set.Tables[0].Rows[i]["content"].ToString().Trim() + "</td><td align=\"right\" valign=\"top\">　</td><td align=\"right\" valign=\"top\">" + MyFunc.NumBerFormat(set.Tables[0].Rows[i]["tzmoney"].ToString().Trim()) + "</td>";
                string text5 = "#ffffff";
                string text6 = "&nbsp;";
                double num9 = double.Parse(set.Tables[0].Rows[i]["truewin"].ToString().Trim());
                double num10 = double.Parse(set.Tables[0].Rows[i]["win"].ToString().Trim());
                double num11 = double.Parse(set.Tables[0].Rows[i]["lose"].ToString().Trim());
                if ((num10 > 0) && (num9 == 1))
                {
                    text5 = "#FF9B9B";
                    text6 = "全赢";
                }
                else if ((num10 > 0) && (num9 == 0.5))
                {
                    text5 = "#A6D5EE";
                    text6 = "赢半";
                }
                else if ((num11 > 0) && (num9 == 1))
                {
                    text5 = "#FFFF99";
                    text6 = "全输";
                }
                else if ((num11 > 0) && (num9 == 0.5))
                {
                    text5 = "#FFD2A6";
                    text6 = "输半";
                }
                string text10 = text3;
                text3 = (text10 + "<td align=\"center\" valign=\"top\" style='background-color: " + text5 + ";'>" + text6) + "</td>" + "<td align=\"right\" valign=\"top\">";
                if (set.Tables[0].Rows[i]["isdanger"].ToString().Trim().ToUpper() == "2")
                {
                    text3 = text3 + "<font color=red>危险球取消</font>";
                }
                else if (set.Tables[0].Rows[i]["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                {
                    text3 = text3 + "<font color=red>已取消</font>";
                }
                else
                {
                    double num12 = double.Parse(set.Tables[0].Rows[i]["win"].ToString().Trim()) - double.Parse(set.Tables[0].Rows[i]["lose"].ToString().Trim());
                    text3 = text3 + MyFunc.NumBerFormat(num12.ToString());
                }
                text3 = text3 + "</td><td align=center>";
                if (set.Tables[0].Rows[i]["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                {
                    string text11 = text3;
                    text3 = text11 + "<a href=orderlist.aspx?action=resume&orderid=" + set.Tables[0].Rows[i]["orderid"].ToString().Trim() + "&start=" + start_date + "&end=" + end_date + "&flag=" + isjs + "&bid=" + ballid + "&type=" + tztype + "&gid=" + gdid + "&zid=" + zdlid + "&did=" + dlsid + "&uid=" + userid + "&uname=" + username + "&oid=" + orderid + "&t1=" + t1 + "&t2=" + t2 + "&matchname=" + matchname + "&tzmoney=" + tzmoney + "&rr=" + rr + "&isc=" + iscancel + "&isw=" + iswin + "&page=" + curPage.ToString() + " onclick=\"return confirm('确定要恢复该注单吗?')\"><font color=red>恢复</font></a>";
                }
                else
                {
                    string text12 = text3;
                    text3 = text12 + "<a href=orderlist.aspx?action=cancel&orderid=" + set.Tables[0].Rows[i]["orderid"].ToString().Trim() + "&start=" + start_date + "&end=" + end_date + "&flag=" + isjs + "&bid=" + ballid + "&type=" + tztype + "&gid=" + gdid + "&zid=" + zdlid + "&did=" + dlsid + "&uid=" + userid + "&uname=" + username + "&oid=" + orderid + "&t1=" + t1 + "&t2=" + t2 + "&matchname=" + matchname + "&tzmoney=" + tzmoney + "&rr=" + rr + "&isc=" + iscancel + "&isw=" + iswin + "&page=" + curPage.ToString() + " onclick=\"return confirm('确定要取消该注单吗?')\">取消</a>";
                    num5 += double.Parse(set.Tables[0].Rows[i]["tzmoney"].ToString().Trim());
                    num6 += double.Parse(set.Tables[0].Rows[i]["win"].ToString().Trim()) - double.Parse(set.Tables[0].Rows[i]["lose"].ToString().Trim());
                }
                text3 = text3 + "</td></tr>";
                num7++;
                text4 = text4 + set.Tables[0].Rows[i]["orderid"].ToString().Trim() + ",";
            }
            string text13 = text3;
            text3 = (text13 + "<form name='form1' method='post' action='OrderList.aspx'><input name='action' type='hidden' value='kygl'><input name='order_list' type='hidden' value='" + text4 + "'><tr class=\"sum\"><td colspan=\"4\"><input type=submit value='取消本页注单' onclick=\"return confirm('确定要取消本页所有注单吗?')\" class=text></td></form><td>当前笔数:" + num7.ToString() + "</td><td>&nbsp;</td><td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td><td>&nbsp;</td><td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td><td>&nbsp;</td></tr>") + "<tr><td colspan=10 align=right bgcolor=#ffffff>" + MyFunc.MulitPager(totalRecord, pagesize, curPage, "OrderList.aspx?start=" + start_date + "&end=" + end_date + "&flag=" + isjs + "&bid=" + ballid + "&type=" + tztype + "&gid=" + gdid + "&zid=" + zdlid + "&did=" + dlsid + "&uid=" + userid + "&oid=" + orderid + "&t1=" + t1 + "&t2=" + t2 + "&matchname=" + matchname + "&tzmoney=" + tzmoney + "&rr=" + rr + "&isc=" + iscancel + "&isw=" + iswin) + "</td></tr>";
            SqlDataReader reader = base2.ExecuteReader("SELECT ISNULL(COUNT(1),0) AS ordercount,ISNULL(sum(tzmoney),0) AS tzcount,ISNULL(sum(win-lose),0) AS wincount FROM ball_order " + text2);
            if (reader.Read())
            {
                string text14 = text3;
                text3 = text14 + "<tr class=\"sum\"><td colspan=\"4\">&nbsp;</td><td>总笔数:" + reader["ordercount"].ToString().Trim() + "</td><td>&nbsp;</td><td>" + MyFunc.NumBerFormat(reader["tzcount"].ToString()) + "</td><td>&nbsp;</td><td>" + MyFunc.NumBerFormat(reader["wincount"].ToString()) + "</td><td>&nbsp;</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text3;
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OrderOp(string flag, string orderid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (flag == "0")
            {
                base2.ExecuteNonQuery("UPDATE ball_order SET iscancel=0,isjs=0,isdanger=1,mgd=0,mzdl=0,mdls=0,win=0,lose=0,truewin=0 WHERE orderid=" + orderid);
            }
            else
            {
                base2.ExecuteNonQuery("UPDATE ball_order SET iscancel=1,isjs=1,mgd=0,mzdl=0,mdls=0,win=0,lose=0,truewin=0 WHERE orderid=" + orderid);
            }
            base2.Dispose();
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                string text;
                string text2;
                string isjs;
                string tztype;
                string ballid;
                string gdid;
                string zdlid;
                string dlsid;
                string userid;
                string orderid;
                string text11;
                string text12;
                string matchname;
                string tzmoney;
                string rr;
                string iscancel;
                string iswin;
                string username;
                if (((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "kygl")) && (base.Request.Form["order_list"] != null))
                {
                    if (base.Request.Form["order_list"].ToString().Trim() != "")
                    {
                        this.CancelOrderList(base.Request.Form["order_list"].ToString().Trim());
                    }
                    else
                    {
                        MyFunc.showmsg("本页没有注单");
                        base.Response.End();
                        return;
                    }
                }
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "cancel")) && ((base.Request.QueryString["orderid"] != null) && (base.Request.QueryString["orderid"].ToString().Trim() != "")))
                {
                    this.OrderOp("1", base.Request.QueryString["orderid"].ToString().Trim().Replace(" ", "").Replace("'", ""));
                }
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "resume")) && ((base.Request.QueryString["orderid"] != null) && (base.Request.QueryString["orderid"].ToString().Trim() != "")))
                {
                    this.OrderOp("0", base.Request.QueryString["orderid"].ToString().Trim().Replace(" ", "").Replace("'", ""));
                }
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "del")) && ((base.Request.QueryString["orderid"] != null) && (base.Request.QueryString["orderid"].ToString().Trim() != "")))
                {
                    this.DelOrder(base.Request.QueryString["orderid"].ToString().Trim().Replace(" ", "").Replace("'", ""));
                }
                if ((base.Request.QueryString["start"] != null) && (base.Request.QueryString["start"].ToString().Trim() != ""))
                {
                    text = base.Request.QueryString["start"].ToString().Trim();
                }
                else
                {
                    text = DateTime.Now.ToShortDateString();
                }
                if ((base.Request.QueryString["end"] != null) && (base.Request.QueryString["end"].ToString().Trim() != ""))
                {
                    text2 = base.Request.QueryString["end"].ToString().Trim();
                }
                else
                {
                    text2 = DateTime.Now.ToShortDateString();
                }
                if ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != ""))
                {
                    isjs = base.Request.QueryString["flag"].ToString().Trim();
                }
                else
                {
                    isjs = "";
                }
                if ((base.Request.QueryString["isc"] != null) && (base.Request.QueryString["isc"].ToString().Trim() != ""))
                {
                    iscancel = "1";
                }
                else
                {
                    iscancel = "";
                }
                if ((base.Request.QueryString["isw"] != null) && (base.Request.QueryString["isw"].ToString().Trim() != ""))
                {
                    iswin = base.Request.QueryString["isw"].ToString().Trim();
                }
                else
                {
                    iswin = "";
                }
                if ((base.Request.QueryString["bid"] != null) && (base.Request.QueryString["bid"].ToString().Trim() != ""))
                {
                    ballid = base.Request.QueryString["bid"].ToString().Trim();
                }
                else
                {
                    ballid = "";
                }
                if ((base.Request.QueryString["type"] != null) && (base.Request.QueryString["type"].ToString().Trim() != ""))
                {
                    tztype = base.Request.QueryString["type"].ToString().Trim();
                }
                else
                {
                    tztype = "";
                }
                if ((base.Request.QueryString["gid"] != null) && (base.Request.QueryString["gid"].ToString().Trim() != ""))
                {
                    gdid = base.Request.QueryString["gid"].ToString().Trim();
                }
                else
                {
                    gdid = "";
                }
                if ((base.Request.QueryString["zid"] != null) && (base.Request.QueryString["zid"].ToString().Trim() != ""))
                {
                    zdlid = base.Request.QueryString["zid"].ToString().Trim();
                }
                else
                {
                    zdlid = "";
                }
                if ((base.Request.QueryString["did"] != null) && (base.Request.QueryString["did"].ToString().Trim() != ""))
                {
                    dlsid = base.Request.QueryString["did"].ToString().Trim();
                }
                else
                {
                    dlsid = "";
                }
                if ((base.Request.QueryString["uid"] != null) && (base.Request.QueryString["uid"].ToString().Trim() != ""))
                {
                    userid = base.Request.QueryString["uid"].ToString().Trim();
                }
                else
                {
                    userid = "";
                }
                if ((base.Request.QueryString["uname"] != null) && (base.Request.QueryString["uname"].ToString().Trim() != ""))
                {
                    username = base.Request.QueryString["uname"].ToString().Trim();
                }
                else
                {
                    username = "";
                }
                if ((base.Request.QueryString["oid"] != null) && (base.Request.QueryString["oid"].ToString().Trim() != ""))
                {
                    orderid = base.Request.QueryString["oid"].ToString().Trim();
                }
                else
                {
                    orderid = "";
                }
                if ((base.Request.QueryString["t1"] != null) && (base.Request.QueryString["t1"].ToString().Trim() != ""))
                {
                    text11 = base.Request.QueryString["t1"].ToString().Trim();
                }
                else
                {
                    text11 = "00:00:00";
                }
                if ((base.Request.QueryString["t2"] != null) && (base.Request.QueryString["t2"].ToString().Trim() != ""))
                {
                    text12 = base.Request.QueryString["t2"].ToString().Trim();
                }
                else
                {
                    text12 = "23:59:59";
                }
                if ((base.Request.QueryString["matchname"] != null) && (base.Request.QueryString["matchname"].ToString().Trim() != ""))
                {
                    matchname = base.Request.QueryString["matchname"].ToString().Trim();
                }
                else
                {
                    matchname = "";
                }
                if ((base.Request.QueryString["tzmoney"] != null) && (base.Request.QueryString["tzmoney"].ToString().Trim() != ""))
                {
                    tzmoney = base.Request.QueryString["tzmoney"].ToString().Trim();
                }
                else
                {
                    tzmoney = "";
                }
                if ((base.Request.QueryString["rr"] != null) && (base.Request.QueryString["rr"].ToString().Trim() != ""))
                {
                    rr = base.Request.QueryString["rr"].ToString().Trim();
                }
                else
                {
                    rr = "";
                }
                this.kyglContent = this.GetOrderList(text, text2, text11, text12, isjs, tztype, ballid, gdid, zdlid, dlsid, userid, username, orderid, matchname, tzmoney, rr, iscancel, iswin);
                this.DataBind();
            }
        }
    }
}

