namespace mem
{
    using MyTeam.basket;
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class basketball_d : Page
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
                basketball.TopMenuProcess("d", this.abcadd);
                this.ProcessContent("让球");
            }
        }

        private void ProcessContent(string strname)
        {
            string s = ("<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;" + strname + "</font>\n<table id='m_tab' border='0' cellspacing='1' cellpadding='0' width='800' class='tableBorder1'>\n<tr align='center' class='dlsheader' height=25 >\n") + "<td width='60'>时间</td><td width='90'>联塞</td><td width='180'>主队/客队</td><td width='170'>让球盘口/注单</td><td width='170'>大小盘口/注单</td><td width='130'>单双盘口/注单</td></tr>" + this.SumAllMember();
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
            if ((this.Session.Contents["basketball_d.aspx"] != null) && (this.Session.Contents["basketball_d.aspx"].ToString().Trim() != ""))
            {
                sql = "select ballid,balltime,matchname,bigsmall1,bigpl,smallpl,bigsmall2,team1,team2,isautoshow,sortdatetime,xenial,giveup,giveup1,giveup2,bsingle,btwin from bk_ball_pl1view where matchname in (" + MyFunc.FormatMyStr(this.Session.Contents["basketball_d.aspx"].ToString().Trim()) + ") AND (charindex('上半',bk_ball_pl1view.matchname,0) = 0)";
            }
            else
            {
                sql = "select ballid,balltime,matchname,bigsmall1,bigpl,smallpl,bigsmall2,team1,team2,isautoshow,sortdatetime,xenial,giveup,giveup1,giveup2,bsingle,btwin from bk_ball_pl1view where (charindex('上半',bk_ball_pl1view.matchname,0) = 0)";
            }
            if ((this.Session.Contents["sessionSelectZD"] != null) && (this.Session.Contents["sessionSelectZD"].ToString().Trim() == "有单"))
            {
                sql = sql + " and (select count(*) from " + connStr + "..ball_order where ballid = bk_ball_pl1view.ballid and (tztype = 18 or tztype = 19 or tztype = 20)) > 0";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                num++;
                text2 = (((((text2 + "<tr class='TableBody1'>") + "<td nowrap align = center>" + reader["balltime"].ToString()) + "</td>") + "<td align = center>" + reader["matchname"].ToString() + "</td>\n<td><table cellSpacing='0' cellPadding=\"0\" width=\"100%\" border=\"0\"><tr><td>") + reader["team1"].ToString() + "</td><td>&nbsp;</td></tr><tr><td>" + reader["team2"].ToString()) + "</td><td align=right><font color='#009900'></font></td></tr></table>\n" + "<td><table cellSpacing='0' cellPadding=\"0\" width=\"100%\" border=\"0\"><tr><td  width=\"33%\">\n";
                if (reader["xenial"].ToString().ToUpper() == "H")
                {
                    text2 = text2 + reader["giveup"].ToString().Trim() + "&nbsp;&nbsp;</td>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td>";
                }
                if (reader["giveup1"].ToString().Trim() != "")
                {
                    text2 = text2 + "<td width=\"33%\" align=center>" + ((Convert.ToDouble(reader["giveup1"]) - this.abcadd)).ToString("F3") + "</td>";
                }
                else
                {
                    text2 = text2 + "<td width=\"33%\" align=center>&nbsp;&nbsp;</td>";
                }
                string text5 = text2;
                text2 = text5 + "<td width='33%' align=right><a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString().Trim() + "&tztype=18&marker=H'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "18", "H") + "</a></td></tr><tr><td>";
                if (reader["xenial"].ToString().ToUpper() == "C")
                {
                    text2 = text2 + reader["giveup"].ToString().Trim() + "&nbsp;&nbsp;</td>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td>";
                }
                if (reader["giveup2"].ToString().Trim() != "")
                {
                    text2 = text2 + "<td width=\"33%\" align=center>" + ((Convert.ToDouble(reader["giveup2"]) - this.abcadd)).ToString("F3") + "</td>";
                }
                else
                {
                    text2 = text2 + "<td width=\"33%\" align=center>&nbsp;&nbsp;</td>";
                }
                string text6 = text2;
                text2 = (text6 + "<td width='33%' align=right><a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString().Trim() + "&tztype=18&marker=C'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "18", "C") + "</a></td></tr><tr></table></td>\n") + "<td><table cellSpacing=0 cellPadding=0 width='100%' border=0><tr><td width='33%'>";
                if (reader["bigsmall1"].ToString().Trim().IndexOf("大") > -1)
                {
                    text2 = text2 + reader["bigsmall1"].ToString().Trim().Replace("大", "") + "&nbsp;&nbsp;</td><td width='33%' align=center>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width='33%' align=center>";
                }
                if (reader["bigpl"].ToString() != "")
                {
                    text2 = text2 + ((Convert.ToDouble(reader["bigpl"]) - this.abcadd)).ToString("F3") + "</td><td width=33% align=right>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width=33% align=right>";
                }
                string text7 = text2;
                text2 = text7 + "<a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString() + "&tztype=19&marker=H'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "19", "H") + "</a></td></tr><tr><td width=33%>";
                if (reader["bigsmall2"].ToString().Trim().IndexOf("大") > -1)
                {
                    text2 = text2 + reader["bigsmall2"].ToString().Trim().Replace("大", "") + "&nbsp;&nbsp;</td><td width=33% align=center>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width=33% align=center>";
                }
                if (reader["smallpl"].ToString() != "")
                {
                    text2 = text2 + ((Convert.ToDouble(reader["smallpl"]) - this.abcadd)).ToString("F3") + "</td><td width=33% align=right>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width=33% align=right>";
                }
                string text8 = text2;
                text2 = (text8 + "<a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString() + "&tztype=19&marker=C'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "19", "C") + "</a></td></tr></table></td>") + "<td><table cellSpacing=0 cellPadding=0 width='100%' border=0><tr><td width='33%'>";
                if (reader["bsingle"].ToString() != "")
                {
                    text2 = text2 + ((Convert.ToDouble(reader["bsingle"].ToString().Replace("单", "")) - this.abcadd)).ToString("F3") + "</td><td width=33% align=right>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width=33% align=right>";
                }
                string text9 = text2;
                text2 = text9 + "<a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString() + "&tztype=20&marker=1'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "20", "1") + "</a></td></tr><tr><td width=33%>";
                if (reader["btwin"].ToString() != "")
                {
                    text2 = text2 + ((Convert.ToDouble(reader["btwin"].ToString().Replace("双", "")) - this.abcadd)).ToString("F3") + "</td><td width=33% align=right>";
                }
                else
                {
                    text2 = text2 + "&nbsp;&nbsp;</td><td width=33% align=right>";
                }
                string text10 = text2;
                text2 = (text10 + "<a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString() + "&tztype=20&marker=2'>" + this.SumStatic(reader["ballid"].ToString().Trim(), "20", "2") + "</a></td></tr></table></td>") + "</tr>";
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

