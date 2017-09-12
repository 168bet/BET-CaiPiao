namespace mem
{
    using MyTeam.basket;
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class basketball_rqgg : Page
    {
        protected double abcadd = 0;

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                basketball.TopMenuProcess("rqgg", this.abcadd);
                this.ProcessContent("让球过关");
            }
        }

        private void ProcessContent(string strname)
        {
            string s = ("<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;" + strname + "</font>\n<table id='m_tab' border='0' cellspacing='1' cellpadding='0' width='510' class='tableBorder1'>\n<tr align='center' class='dlsheader' height=25 >\n") + "<td width='60'nowrap>时间</td><td width='130'nowrap>联塞</td><td width='170'>主队/客队</td><td width='150'>让球过关</td></tr>" + this.SumAllMember();
            base.Response.Write(s);
        }

        private string SumAllMember()
        {
            string sql = "";
            string text2 = "";
            int num = 0;
            string connStr = "";
            connStr = MyFunc.GetConnStr(2);
            connStr = connStr.Substring(connStr.IndexOf("catalog=", 0) + 8, (connStr.IndexOf(";user", 0) - connStr.IndexOf("catalog=", 0)) - 8);
            if ((this.Session.Contents["basketball_rqgg.aspx"] != null) && (this.Session.Contents["basketball_rqgg.aspx"].ToString().Trim() != ""))
            {
                sql = "select ballid,balltime,matchname,team1,team2,isautoshow,sortdatetime,xenial,giveup,giveup1,giveup2 from BK_Ball_PL1viewRQ where matchname in (" + MyFunc.FormatMyStr(this.Session.Contents["basketball_rqgg.aspx"].ToString().Trim()) + ")";
            }
            else
            {
                sql = "select ballid,balltime,matchname,team1,team2,isautoshow,sortdatetime,xenial,giveup,giveup1,giveup2 from BK_Ball_PL1viewRQ where 1 = 1";
            }
            if ((this.Session.Contents["sessionSelectZD"] != null) && (this.Session.Contents["sessionSelectZD"].ToString().Trim() == "有单"))
            {
                string text5 = sql;
                sql = text5 + " and (select count(*) from " + connStr + "..ball_order where orderid in (select orderid from " + connStr + "..ball_order1 where ballid = BK_Ball_PL1viewRQ.ballid and tztype = 21)) > 0";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                num++;
                string text6 = ((text2 + "<tr class='TableBody1'>") + "<td nowrap align=center>" + reader["balltime"].ToString() + "</td>") + "<td align=center>" + reader["matchname"].ToString() + "</td>\n<td><table cellSpacing='0' cellPadding=\"0\" width=\"100%\" border=\"0\"><tr><td>";
                string text7 = text6 + reader["team1"].ToString() + "</td></tr><tr><td>" + reader["team2"].ToString() + "</td></tr></table></td>\n";
                text2 = text7 + "<td align=center><a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString().Trim() + "&tztype=21&marker=none'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "21", "none") + "</a></td></tr>";
            }
            if (num == 0)
            {
                text2 = text2 + "<tr class='TableBody1'><td colspan=16 align=center height=30><marquee align=middle behavior=alternate width=200><font color=red size=2><b>没有相关注单</b></font></marquee></td></tr>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return (text2 + "\n</table></form></body></html>");
        }

        private string SumStatic(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "'";
            }
            else if (tzType == "20")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "'";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND tzteam = '" + marker + "'";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }
    }
}

