namespace odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class BasketBallList : Page
    {
        public string btnclassid = "";
        public string kyglContent = "";
        public string kyglServerList = "";

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OpenGame(string ballid)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=1 WHERE ballid=" + ballid);
                base2.Dispose();
            }
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                this.btnclassid = this.Session.Contents["classid"].ToString().Trim();
                if (!base.IsPostBack)
                {
                    if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() != ""))
                    {
                        string ballid = base.Request.QueryString["ballid"].ToString().Trim().Replace(" ", "").Replace("'", "").Replace("%", "");
                        if (base.Request.QueryString["action"].ToString().Trim() == "stop")
                        {
                            this.StopGame(ballid);
                        }
                        else if (base.Request.QueryString["action"].ToString().Trim() == "open")
                        {
                            this.OpenGame(ballid);
                        }
                    }
                    if (((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ffpost")) && ((base.Request.Form["ballid"] != null) && (base.Request.Form["ballid"].ToString().Trim() != "")))
                    {
                        if (base.Request.Form["ballid"].ToString().Trim() == "0")
                        {
                            this.UpdateAllBallMsg();
                        }
                        else
                        {
                            this.UpdateBallMsg(base.Request.Form["ballid"].ToString().Trim());
                        }
                    }
                    string sql = "SELECT bk.ballid,bk.balltime,bk.matchname,bk.team1,bk.team2,bk.homeway,bk.isautoshow,bf.isshow,bf.isclose,bf.iscancel,bf.isauto,bf.serverlist,bf.maxc1,bf.maxc2 ";
                    sql = sql + "FROM Ball_BF as bf RIGHT OUTER JOIN BK_Ball_PL1 as bk ON bf.ballid = bk.ballid WHERE bf.isbk = 1 and bk.isautoshow = 1 AND DATEDIFF(d,bf.sortballtime,getdate()) = 0 ORDER BY bf.sortballtime";
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    SqlDataReader reader = base2.ExecuteReader(sql);
                    while (reader.Read())
                    {
                        string kyglContent = this.kyglContent;
                        this.kyglContent = kyglContent + "<tr bgcolor=\"#FFFFFF\"><td>" + reader["balltime"].ToString().Trim() + "</td><td>" + reader["matchname"].ToString().Trim() + "</td><td>" + reader["team1"].ToString().Trim() + "&nbsp;<font color=red>" + reader["homeway"].ToString().Trim() + "</font><br>" + reader["team2"].ToString().Trim() + "</td><td>";
                        if (reader["isshow"].ToString().Trim().ToUpper() == "TRUE")
                        {
                            this.kyglContent = this.kyglContent + "收单";
                        }
                        else
                        {
                            this.kyglContent = this.kyglContent + "<font color=red>停止</font>";
                        }
                        if (reader["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                        {
                            this.kyglContent = this.kyglContent + "取消";
                        }
                        if (reader["isauto"].ToString().Trim().ToUpper() == "TRUE")
                        {
                            this.kyglContent = this.kyglContent + " 手动";
                        }
                        this.kyglContent = this.kyglContent + "</td><td>";
                        this.kyglContent = this.kyglContent + "<table width=\"315\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#D9D9D9\">";
                        string text4 = this.kyglContent;
                        this.kyglContent = text4 + "<tr><td width=155 align=\"center\" bgcolor=\"#FFFFFF\"><a href=basketballlist.aspx?action=stop&ballid=" + reader["ballid"].ToString().Trim() + ">停押</a> / <a href=basketballlist.aspx?action=open&ballid=" + reader["ballid"].ToString().Trim() + ">启用</a> / <SPAN style=\"CURSOR: hand;\" onMouseOver=\"this.className='oo'\" onMouseOut=\"this.className='oo1'\" onclick=\"javascript:show_win('" + reader["ballid"].ToString().Trim() + "','" + reader["maxc1"].ToString().Trim() + "','" + reader["maxc2"].ToString().Trim() + "','" + reader["serverlist"].ToString().Trim() + "');\">详细</span>";
                        if (reader["isauto"].ToString().Trim().ToUpper() == "TRUE")
                        {
                            this.kyglContent = this.kyglContent + " / <a href=ballmsg.aspx?action=mod&ballid=" + reader["ballid"].ToString().Trim() + ">修改</a>";
                        }
                        this.kyglContent = this.kyglContent + "</td><td width=80 align=\"center\" bgcolor=\"#EAEAEA\">让球</td><td width=80 align=\"center\">大小</td></tr>";
                        this.kyglContent = this.kyglContent + "<tr><td width=155 bgcolor=\"#FFFFFF\">&nbsp;</td>";
                        string text5 = this.kyglContent;
                        this.kyglContent = text5 + "<td width=80 bgcolor=\"#EAEAEA\">" + reader["Maxc1"].ToString().Trim() + "</td><td width=80>" + reader["Maxc2"].ToString().Trim() + "</td></tr></table>";
                        this.kyglContent = this.kyglContent + "</td></tr>";
                    }
                    reader.Close();
                    base2.Dispose();
                    this.kyglServerList = this.SubServerList();
                    this.DataBind();
                }
            }
        }

        private void StopGame(string ballid)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=0 WHERE ballid=" + ballid);
                base2.Dispose();
            }
        }

        private string SubServerList()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM subserver");
            string text = "";
            while (reader.Read())
            {
                string text3 = text;
                text = text3 + " <tr><td width=\"20%\" align=\"center\"><input type=\"checkbox\" id=cc" + reader["serverid"].ToString().Trim() + " name=\"slist\" value=\"" + reader["serverid"].ToString().Trim() + "\"></td><td width=\"80%\">" + reader["servername"].ToString().Trim() + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private void UpdateAllBallMsg()
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                string text3 = base.Request.Form["maxc1"].ToString().Trim();
                string text4 = base.Request.Form["maxc2"].ToString().Trim();
                string text2 = base.Request.Form["plvalue"].ToString().Trim();
                string sql = "SELECT bk.ballid,bk.balltime,bk.matchname,bk.team1,bk.team2,bk.homeway,bk.isautoshow,bf.isshow,bf.isclose,bf.iscancel,bf.isauto,bf.serverlist,bf.maxc1,bf.maxc2 ";
                sql = sql + "FROM Ball_BF as bf RIGHT OUTER JOIN BK_Ball_PL1 as bk ON bf.ballid = bk.ballid WHERE bf.isbk = 1 AND " + text2 + " = convert(numeric(6,3),bk.giveup1) + convert(numeric(6,3),bk.giveup2) and bk.isautoshow = 1 AND DATEDIFF(d,bf.sortballtime,getdate()) = 0 ORDER BY bf.sortballtime";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    string text = reader["ballid"].ToString().Trim();
                    base3.ExecuteNonQuery("UPDATE ball_bf SET maxc1=" + text3 + ",maxc2=" + text4 + " WHERE isbk = 1 AND ballid=" + text);
                }
                base2.Dispose();
                base3.Dispose();
                base.Response.Redirect("basketballlist.aspx");
            }
        }

        private void UpdateBallMsg(string ballid)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                string text = "";
                if ((base.Request.Form["slist"] != null) && (base.Request.Form["slist"].ToString().Trim() != ""))
                {
                    text = base.Request.Form["slist"].ToString().Trim().Replace(" ", "");
                }
                string text2 = base.Request.Form["maxc1"].ToString().Trim();
                string text3 = base.Request.Form["maxc2"].ToString().Trim();
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE ball_bf SET maxc1=" + text2 + ",maxc2=" + text3 + ",serverlist='" + text + "' WHERE ballid=" + ballid);
                base2.Dispose();
                base.Response.Redirect("basketballlist.aspx");
            }
        }
    }
}

