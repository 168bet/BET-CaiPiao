namespace user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Collections;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using newball;
    using System.Configuration;

    public class betting_entry_bk : Page
    {
        public string Addons = "";
        public string kyglContent = "";
        protected HtmlGenericControl kyglDiv;
        public string MinBet = ConfigurationSettings.AppSettings["MinBet"];

        private string agenceSql(string type)
        {
            switch (type.Trim())
            {
                case "18":
                    return ",W18,L18";

                case "19":
                    return ",W19,L19";

                case "20":
                    return ",W20,L20";

                case "21":
                    return ",W21,L21";

                case "22":
                    return ",W22,L22";

                case "23":
                    return ",W23,L23";

                case "24":
                    return ",W24,L24";

                case "25":
                    return ",W18,L18";

                case "26":
                    return ",W19,L19";

                case "27":
                    return ",W20,L20";
            }
            return "";
        }

        private string AhTz(string[] kygl, string team, string type)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string text5 = "";
            string text6 = "";
            string text7 = "";
            text4 = MyFunc.GetPlType(kygl[6], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            text5 = MyFunc.GetPlType(kygl[7], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            if (kygl[4].ToUpper() == "H")
            {
                text6 = kygl[2];
                text7 = kygl[3];
            }
            else
            {
                text6 = kygl[3];
                text7 = kygl[2];
                text3 = text4;
                text4 = text5;
                text5 = text3;
            }
            if (team == "1")
            {
                text2 = kygl[2];
                text3 = text4;
            }
            else
            {
                text2 = kygl[3];
                text3 = text5;
            }
            text = kygl[1];
            string text9 = text;
            return (text9 + "<br>" + text6 + " <span class='hdp'>" + kygl[5] + "</span>  " + text7 + "<br><span class='pick'>" + text2 + "</span> @ <span class='odds' style='font-size:18px'>" + text3 + "</span>");
        }

        private string AhTzInput(string[] user, string[] ball, string team, string type)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string text5 = "";
            text4 = MyFunc.GetPlType(ball[6], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            text5 = MyFunc.GetPlType(ball[7], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            if (team == "1")
            {
                text2 = "1";
                if (ball[4].ToUpper() == "H")
                {
                    text3 = text4;
                }
                else
                {
                    text3 = text5;
                }
            }
            else
            {
                text2 = "2";
                if (ball[4].ToUpper() == "H")
                {
                    text3 = text5;
                }
                else
                {
                    text3 = text4;
                }
            }
            return ((((((((((((((((text + "<input type='hidden' name='fr_credit' value='" + user[5] + "'>") + "<input type='hidden' name='fr_minbet' value='" + this.MinBet + "'>") + "<input type='hidden' name='fr_maxbet' value='" + user[8] + "'>") + "<input type='hidden' name='fr_maximum_payout' value='" + MyFunc.GetMaxPayOut() + "'>") + "<input type='hidden' name='fr_estimate_payout' value=''>") + "<input type='hidden' name='fr_odds_lose' value=''>" + "<input type='hidden' name='fr_spread' value='0.100'>") + "<input type='hidden' name='fr_handicap' value='" + ball[5] + "'>") + "<input type='hidden' name='fr_matchindex' value='" + ball[0] + "'>") + "<input type='hidden' name='fr_magnumindex' value=''>") + "<input type='hidden' name='fr_pick' value='" + text2 + "'>") + "<input type='hidden' name='fr_bettype' value='" + type + "'>") + "<input type='hidden' name='fr_favourite' value=''>") + "<input type='hidden' name='fr_dangerstatus' value='0'>" + "<input type='hidden' name='fr_confirmed' value='0'>") + "<input type='hidden' name='fr_odds' value='" + text3 + "'>") + "<input type='hidden' name='fr_odds_cap' value='" + text3 + "'>") + "<input type='hidden' name='action' value='kygl'>");
        }

        private string[] BallMsg(string type, string ballid, DataBase db)
        {
            string sql = "";
            switch (type)
            {
                case "25":
                case "22":
                case "18":
                    sql = "SELECT ballid,matchname,team1,team2,xenial,giveup,giveup1,giveup2,homeway,sortdatetime FROM BK_Ball_Pl1View WHERE ballid=" + ballid;
                    break;

                case "26":
                case "23":
                case "19":
                    sql = "SELECT ballid,matchname,team1,team2,xenial,bigsmall1,bigsmall2,bigpl,smallpl,homeway,sortdatetime FROM BK_Ball_Pl1View WHERE ballid=" + ballid;
                    break;

                case "27":
                case "24":
                case "20":
                    sql = "SELECT ballid,matchname,team1,team2,bsingle,btwin,sortdatetime FROM BK_Ball_Pl1View WHERE ballid=" + ballid;
                    break;

                case "21":
                    sql = "SELECT ballid,matchname,team1,team2,xenial,giveup,giveup1,giveup2,homeway,sortdatetime FROM BK_Ball_Pl1ViewRQ WHERE ballid=" + ballid;
                    break;
            }
            if (sql == "")
            {
                return null;
            }
            SqlDataReader reader = db.ExecuteReader(sql);
            if (!reader.Read())
            {
                reader.Close();
                return null;
            }
            string[] textArray = new string[reader.FieldCount];
            for (int i = 0; i < reader.FieldCount; i++)
            {
                textArray[i] = reader[i].ToString().Trim();
            }
            reader.Close();
            return textArray;
        }

        private string CloseTime()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT username,usemoney,curmoney,moneysort FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            if (reader.Read())
            {
                string text3 = ("<table class='bet_entry' cellpading=0 cellspacing=0 background='images/frame_bg.gif'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr style='background:transparent;'><th colspan=2>户口 (" + reader["username"].ToString().Trim() + ")</th></tr>";
                string text4 = text3 + "<tr style='background:transparent;'><td width=50%>信用馀额</td><td>" + reader["moneysort"].ToString().Trim() + " " + reader["curmoney"].ToString().Trim() + "</td></tr>";
                text = ((text4 + "<tr style='background:transparent;'><td width=50%>信用额度</td><td>" + reader["moneysort"].ToString().Trim() + " " + reader["usemoney"].ToString().Trim() + "</td></tr>") + "<tr style='background:transparent;'><td width=50% colspan=2 class='error'>对不起，球赛暂时关闭！</td></tr>") + "<td height=10 background='images/frame_bg.gif'></td>" + "<tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table>";
                this.Addons = " onLoad=\"TimeOut()\"";
                reader.Close();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private string CloseTime(string msg)
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT username,usemoney,curmoney,moneysort FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            if (reader.Read())
            {
                string text3 = ("<table class='bet_entry' cellpading=0 cellspacing=0 background='images/frame_bg.gif'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr style='background:transparent;'><th colspan=2>户口 (" + reader["username"].ToString().Trim() + ")</th></tr>";
                string text4 = text3 + "<tr style='background:transparent;'><td width=50%>信用馀额</td><td>" + reader["moneysort"].ToString().Trim() + " " + reader["curmoney"].ToString().Trim() + "</td></tr>";
                text = ((text4 + "<tr style='background:transparent;'><td width=50%>信用额度</td><td>" + reader["moneysort"].ToString().Trim() + " " + reader["usemoney"].ToString().Trim() + "</td></tr>") + "<tr style='background:transparent;'><td width=50% colspan=2 class='error'>" + msg + "</td></tr>") + "<td height=10 background='images/frame_bg.gif'></td>" + "<tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table>";
                this.Addons = " onLoad=\"TimeOut()\"";
                reader.Close();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private string DSTz(string[] kygl, string team, string type)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string text5 = "";
            string text6 = "VS";
            text3 = kygl[2];
            text4 = kygl[3];
            if (team == "1")
            {
                text2 = "单";
                text5 = kygl[4].Replace("单", "").Trim();
            }
            else
            {
                text2 = "双";
                text5 = kygl[5].Replace("双", "").Trim();
            }
            text = kygl[1];
            string text8 = text;
            return (text8 + "<br>" + text3 + " <span class='hdp'>" + text6 + "</span>  " + text4 + "<br><span class='pick'>" + text2 + "</span> @ <span class='odds' style='font-size:18px'>" + text5 + "</span>");
        }

        private string DSTzInput(string[] user, string[] ball, string team, string type)
        {
            string text = "";
            string text2 = "";
            string s = "0";
            string text4 = "";
            text2 = team;
            if (text2 == "1")
            {
                s = ball[4].Replace("单", "").Trim();
            }
            else
            {
                s = ball[5].Replace("双", "").Trim();
            }
            double num = double.Parse(s) - 1;
            double num2 = double.Parse(s) - 1;
            return (((((((((((((((text + "<input type='hidden' name='fr_credit' value='" + user[5] + "'>") + "<input type='hidden' name='fr_minbet' value='" + this.MinBet + "'>") + "<input type='hidden' name='fr_maxbet' value='" + user[8] + "'>") + "<input type='hidden' name='fr_maximum_payout' value='" + MyFunc.GetMaxPayOut() + "'>") + "<input type='hidden' name='fr_estimate_payout' value=''>" + "<input type='hidden' name='fr_odds_lose' value=''>") + "<input type='hidden' name='fr_spread' value='0.100'>" + "<input type='hidden' name='fr_handicap' value=''>") + "<input type='hidden' name='fr_matchindex' value='" + ball[0] + "'>") + "<input type='hidden' name='fr_magnumindex' value=''>") + "<input type='hidden' name='fr_pick' value='" + text2 + "'>") + "<input type='hidden' name='fr_bettype' value='" + type + "'>") + "<input type='hidden' name='fr_favourite' value='" + text4 + "'>") + "<input type='hidden' name='fr_dangerstatus' value='0'>" + "<input type='hidden' name='fr_confirmed' value='0'>") + "<input type='hidden' name='fr_odds' value='" + num.ToString() + "'>") + "<input type='hidden' name='fr_odds_cap' value='" + num2.ToString() + "'>") + "<input type='hidden' name='action' value='kygl'>");
        }

        private string dx(string str)
        {
            string text = "";
            text = str.Replace("大", "").Replace("小", "").Replace(" ", "");
            if (text.IndexOf("/") >= 0)
            {
                text = ((double.Parse(text.Split(new char[] { '/' })[0]) + double.Parse(text.Split(new char[] { '/' })[1])) / 2).ToString();
            }
            return text;
        }

        private string FinishTime(string orderid, string username, string content, string tzmoney, string winmoney, string moneysort, string curmoney)
        {
            string text = "<TABLE class=bet_entry id=betStatus cellSpacing=0 background=images/frame_bg.gif cellpading=0><TBODY><TR><TD width=218 background=images/frame_top.gif colSpan=2 height=24></TD></TR>";
            string text3 = text;
            string text4 = text3 + "<TR style='BACKGROUND: none transparent scroll repeat 0% 0%'><TH colSpan=2>注单状况 (" + username + ")</TH></TR><TR style='BACKGROUND: none transparent scroll repeat 0% 0%'><TD class=green style='TEXT-ALIGN: center' colSpan=2><B>下注成功 </B><BR>注单编号: " + orderid + " </TD></TR><TR style='BACKGROUND: none transparent scroll repeat 0% 0%'><TD class=status style='TEXT-ALIGN: center' colSpan=2>";
            string text5 = text4 + "" + content + "<BR>注额: <SPAN class=amount>" + tzmoney + "</SPAN><BR>可嬴额: " + winmoney + " ";
            text = (text5 + "</TD></TR><TR class=green><TD>信用馀额</TD><TD>" + moneysort + " " + curmoney + "</TD></TR><TR class=green><TD>&nbsp;</TD><TD><INPUT class=buttsave style='WIDTH: 50px' onclick=\"window.location.href='betting-entry-bk.aspx'\" type=button value=完成> ") + "<INPUT class=buttcancel style='WIDTH: 50px' onclick=window.print() type=button value=打印 name=fr_print></TD></TR><TR><TD background=images/frame_bg.gif height=10></TD><TR><TD width=218 background=images/frame_bottom.gif colSpan=2 height=18></TD></TR></TBODY></TABLE>" + "<SCRIPT>alert('下注成功   -  请检阅您的  \"下注状况!\"  ');</SCRIPT>";
            this.Addons = " onLoad=\"TimeOut()\"";
            return text;
        }

        private string[] GetDsMsg(string ballid, string team, DataBase db, string type)
        {
            string sql = "SELECT ballid,matchname,team1,team2,bsingle,btwin,isshow,sortdatetime from BK_Ball_PL1View WHERE ballid=" + ballid;
            SqlDataReader reader = db.ExecuteReader(sql);
            string[] textArray = new string[5];
            if (reader.Read())
            {
                if ((DateTime.Parse(reader["sortdatetime"].ToString().Trim()) < DateTime.Now) && (reader["matchname"].ToString().Trim().IndexOf("下半") == 0))
                {
                    return null;
                }
                string s = "";
                string text3 = "";
                string text4 = "VS";
                if (team == "1")
                {
                    s = reader["bsingle"].ToString().Replace("单", "").Trim();
                    text3 = "单";
                }
                else
                {
                    s = reader["btwin"].ToString().Replace("双", "").Trim();
                    text3 = "双";
                }
                textArray[0] = (double.Parse(s) - 1).ToString();
                textArray[1] = team;
                textArray[2] = "<span style=\"text-decoration: underline\">" + reader["matchname"].ToString().Trim() + "</span><br>" + reader["team1"].ToString().Trim() + " <span class='hdp'>" + text4 + "</span>  " + reader["team2"].ToString().Trim() + "<br><span class='pick'>" + text3 + "</span> @ <span class='odds'>" + s + "</span>";
                textArray[2] = textArray[2].Replace("'", "");
                textArray[3] = reader["isshow"].ToString().Trim().ToUpper();
                textArray[4] = reader["sortdatetime"].ToString().Trim();
                reader.Close();
                return textArray;
            }
            reader.Close();
            return null;
        }

        private string[] GetDxMsg(string ballid, string team, DataBase db)
        {
            string sql = "SELECT ballid,matchname,team1,team2,xenial,bigsmall1,bigsmall2,bigpl,smallpl,homeway,isshow,sortdatetime FROM BK_Ball_Pl1View WHERE ballid=" + ballid;
            SqlDataReader reader = db.ExecuteReader(sql);
            string[] textArray = new string[7];
            if (reader.Read())
            {
                string text2;
                string text3;
                string str;
                string text7;
                if ((DateTime.Parse(reader["sortdatetime"].ToString().Trim()) < DateTime.Now) && (reader["matchname"].ToString().Trim().IndexOf("下半") == 0))
                {
                    return null;
                }
                string text4 = reader["xenial"].ToString().Trim();
                if (team == "1")
                {
                    text2 = "H";
                    text7 = reader["team1"].ToString().Trim();
                    str = reader["bigsmall1"].ToString().Trim();
                    text3 = MyFunc.GetPlType(reader["bigpl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                }
                else
                {
                    text2 = "C";
                    text7 = reader["team2"].ToString().Trim();
                    str = reader["bigsmall2"].ToString().Trim();
                    text3 = MyFunc.GetPlType(reader["smallpl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                }
                string text6 = "<span style=\"text-decoration: underline\">" + reader["matchname"].ToString().Trim() + "</span><BR>" + reader["team1"].ToString().Trim() + " <SPAN class=hdp>VS</SPAN>" + reader["team2"].ToString().Trim() + "<br><SPAN class=pick>" + str.Replace(" ", "") + " </SPAN>@ <SPAN class=odds style='FONT-SIZE: 18px'>" + text3 + " </SPAN>";
                textArray[0] = text2;
                textArray[1] = text3;
                textArray[2] = text4;
                textArray[3] = (team == "1") ? this.dx(str) : ("-" + this.dx(str));
                textArray[4] = text6.Replace("'", "");
                textArray[5] = reader["isshow"].ToString().Trim().ToUpper();
                textArray[6] = reader["sortdatetime"].ToString().Trim();
                reader.Close();
                return textArray;
            }
            reader.Close();
            return null;
        }

        private string[] GetRqggMsg(string mlist, string betmsg, DataBase db, out string ss, string orderid)
        {
            string[] textArray = mlist.Split(new char[] { ',' });
            string[] textArray2 = betmsg.Split(new char[] { ',' });
            string[] textArray3 = new string[textArray2.Length];
            string[] textArray4 = new string[textArray2.Length];
            string text = "";
            string text2 = "";
            double num = 1;
            string text3 = "";
            int num2 = 0;
            SqlDataReader reader = db.ExecuteReader("SELECT * FROM BK_Ball_Pl1ViewRQ WHERE ballid in (" + mlist + ")");
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
        Label_049D:
            while (reader.Read())
            {
                for (int i = 0; i < textArray.Length; i++)
                {
                    if (reader["ballid"].ToString().Trim() == textArray[i])
                    {
                        string text4;
                        string text5;
                        if (textArray2[i] == "")
                        {
                            goto Label_049D;
                        }
                        textArray4[i] = reader["giveup"].ToString().Trim();
                        string text6 = reader["giveup"].ToString().Trim();
                        if (reader["xenial"].ToString().Trim().ToUpper() == "H")
                        {
                            text4 = reader["team1"].ToString().Trim();
                            text5 = reader["team2"].ToString().Trim();
                            if (textArray2[i].ToLower() == "a")
                            {
                                textArray3[i] = (double.Parse(reader["giveup1"].ToString().Trim()) + 1).ToString("F3");
                                text = reader["team1"].ToString().Trim();
                                textArray2[i] = "1";
                            }
                            else
                            {
                                textArray3[i] = (double.Parse(reader["giveup2"].ToString().Trim()) + 1).ToString("F3");
                                text = reader["team2"].ToString().Trim();
                                textArray2[i] = "2";
                            }
                        }
                        else
                        {
                            text4 = reader["team2"].ToString().Trim();
                            text5 = reader["team1"].ToString().Trim();
                            if (textArray2[i].ToLower() == "a")
                            {
                                textArray3[i] = (double.Parse(reader["giveup2"].ToString().Trim()) + 1).ToString("F3");
                                text = reader["team2"].ToString().Trim();
                                textArray2[i] = "2";
                            }
                            else
                            {
                                textArray3[i] = (double.Parse(reader["giveup1"].ToString().Trim()) + 1).ToString("F3");
                                text = reader["team1"].ToString().Trim();
                                textArray2[i] = "1";
                            }
                        }
                        string text7 = text2;
                        string[] textArray7 = new string[] { text7, "<DIV><span style=\"text-decoration: underline\">", reader["matchname"].ToString().Trim(), "</span><BR>", text4, " <SPAN class=hdp>", text6, "</span> ", text5, "<BR><SPAN class=pick>", text, "</SPAN> @ <SPAN class=odds>", (double.Parse(textArray3[i]) - 1).ToString("F3"), "</SPAN></DIV>" };
                        text2 = string.Concat(textArray7);
                        num *= double.Parse(textArray3[i]);
                        base2.ExecuteNonQuery("INSERT INTO ball_order1(orderid,ballid,tztype,tzteam,rqteam,pl,rq)VALUES(" + orderid + "," + textArray[i] + ",21,'" + textArray2[i] + "','" + reader["xenial"].ToString().Trim().ToUpper() + "'," + textArray3[i] + "," + textArray4[i] + ")");
                        num2++;
                    }
                }
            }
            reader.Close();
            base2.Dispose();
            string[] textArray5 = new string[] { (num - 1).ToString("F3"), text2 };
            ss = text3;
            if (num2 < 2)
            {
                return null;
            }
            return textArray5;
        }

        private string[] GetRqMsg(string ballid, string team, DataBase db)
        {
            string sql = "SELECT ballid,matchname,team1,team2,xenial,giveup,giveup1,giveup2,homeway,isshow,sortdatetime FROM BK_Ball_Pl1View WHERE ballid=" + ballid;
            SqlDataReader reader = db.ExecuteReader(sql);
            string[] textArray = new string[7];
            if (reader.Read())
            {
                string text2;
                string text3;
                string text7;
                string text8;
                string text9;
                if ((DateTime.Parse(reader["sortdatetime"].ToString().Trim()) < DateTime.Now) && (reader["matchname"].ToString().Trim().IndexOf("下半") == 0))
                {
                    return null;
                }
                string text5 = reader["giveup"].ToString().Trim();
                string text4 = reader["xenial"].ToString().Trim().ToUpper();
                if (team == "1")
                {
                    text2 = "H";
                    text7 = reader["team1"].ToString().Trim();
                    if (text4 == "H")
                    {
                        text3 = MyFunc.GetPlType(reader["giveup1"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                        text8 = reader["team1"].ToString().Trim();
                        text9 = reader["team2"].ToString().Trim();
                    }
                    else
                    {
                        text3 = MyFunc.GetPlType(reader["giveup2"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                        text8 = reader["team2"].ToString().Trim();
                        text9 = reader["team1"].ToString().Trim();
                    }
                }
                else
                {
                    text2 = "C";
                    text7 = reader["team2"].ToString().Trim();
                    if (text4 == "H")
                    {
                        text3 = MyFunc.GetPlType(reader["giveup2"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                        text8 = reader["team1"].ToString().Trim();
                        text9 = reader["team2"].ToString().Trim();
                    }
                    else
                    {
                        text3 = MyFunc.GetPlType(reader["giveup1"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                        text8 = reader["team2"].ToString().Trim();
                        text9 = reader["team1"].ToString().Trim();
                    }
                }
                string text6 = "<span style=\"text-decoration: underline\">" + reader["matchname"].ToString().Trim() + "</span><br>" + text8 + " <span class='hdp'>" + reader["giveup"].ToString().Trim() + "</span>  " + text9 + "<br><span class='pick'>" + text7 + "</span> @ <span class='odds'>" + text3 + "</span>";
                textArray[0] = text2;
                textArray[1] = text3;
                textArray[2] = text4;
                textArray[3] = text5;
                textArray[4] = text6.Replace("'", "");
                textArray[5] = reader["isshow"].ToString().Trim().ToUpper();
                textArray[6] = reader["sortdatetime"].ToString().Trim();
                reader.Close();
                return textArray;
            }
            reader.Close();
            return null;
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private string MatchList(string type)
        {
            string text = "";
            string sql = "";
            if (type == "21")
            {
                sql = "SELECT ballid FROM BK_Ball_PL1viewRQ WHERE isshow=1";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                text = text + reader["ballid"].ToString().Trim() + ",";
            }
            reader.Close();
            base2.Dispose();
            if (text != "")
            {
                text = text.Remove(text.Length - 1, 1);
            }
            return text;
        }

        private string MaxPayOut(string team)
        {
            string str;
            if (((str = team) != null) && (string.IsInterned(str) == "21"))
            {
                return ("<TR><TD bgcolor=#ffff99>最高派彩</TD><TD id=max_payout_caption bgcolor=#ffff99>CNY " + MyFunc.NumBerFormat(MyFunc.GetMaxPayOut(), true) + "</TD></TR>");
            }
            return "";
        }

        private string NewOrderid(string orderid)
        {
            Random random = new Random(int.Parse(this.Session.Contents["userid"].ToString().Trim()));
            string text = "";
            string text2 = random.NextDouble().ToString().Replace(".", "");
            Random random2 = new Random();
            for (int i = 0; i < 7; i++)
            {
                text = text + text2[random2.Next(text2.Length)];
            }
            return (orderid + text);
        }

        private string OeTz(string[] kygl, string team, string type)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            if (team == "1")
            {
                text2 = MyFunc.GetPlType(kygl[7], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                text3 = kygl[5];
            }
            else
            {
                text2 = MyFunc.GetPlType(kygl[8], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
                text3 = kygl[6];
            }
            text = kygl[1];
            if (type == "4")
            {
                string text5 = text;
                text = text5 + " <font color=red>" + kygl[10] + ":" + kygl[11] + "</font>";
            }
            string text6 = text;
            return (text6 + "<BR>" + kygl[2] + " <SPAN class=hdp>VS</SPAN>" + kygl[3] + "<br><SPAN class=pick><B>" + text3 + "</B> </SPAN>@ <SPAN class=odds style='FONT-SIZE: 18px'>" + text2 + " </SPAN>");
        }

        private string OeTzInput(string[] user, string[] ball, string team, string type)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string text5 = "";
            string text6 = "";
            text5 = MyFunc.GetPlType(ball[7], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            text6 = MyFunc.GetPlType(ball[8], this.Session.Contents["ABC"].ToString().Trim()).ToString("F3");
            if (team == "1")
            {
                text2 = "1";
                text4 = text5;
                text3 = this.dx(ball[5]);
            }
            else
            {
                text2 = "2";
                text4 = text6;
                text3 = "-" + this.dx(ball[5]);
            }
            return ((((((((((((((((text + "<input type='hidden' name='fr_credit' value='" + user[5] + "'>") + "<input type='hidden' name='fr_minbet' value='" + this.MinBet + "'>") + "<input type='hidden' name='fr_maxbet' value='" + user[8] + "'>") + "<input type='hidden' name='fr_maximum_payout' value='" + MyFunc.GetMaxPayOut() + "'>") + "<input type='hidden' name='fr_estimate_payout' value=''>") + "<input type='hidden' name='fr_odds_lose' value=''>" + "<input type='hidden' name='fr_spread' value='0.100'>") + "<input type='hidden' name='fr_handicap' value='" + text3 + "'>") + "<input type='hidden' name='fr_matchindex' value='" + ball[0] + "'>") + "<input type='hidden' name='fr_magnumindex' value=''>") + "<input type='hidden' name='fr_pick' value='" + text2 + "'>") + "<input type='hidden' name='fr_bettype' value='" + type + "'>") + "<input type='hidden' name='fr_favourite' value=''>") + "<input type='hidden' name='fr_dangerstatus' value='0'>" + "<input type='hidden' name='fr_confirmed' value='0'>") + "<input type='hidden' name='fr_odds' value='" + text4 + "'>") + "<input type='hidden' name='fr_odds_cap' value='" + text4 + "'>") + "<input type='hidden' name='action' value='kygl'>");
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (((base.Request.Form["action"] == null) || (base.Request.Form["action"].ToString().Trim() == "")) && (base.Request.QueryString["action"] == null))
            {
                string str = "";
                string text2 = "";
                string team = "";
                string pmsg = "";
                if ((base.Request.QueryString["m"] != null) && (base.Request.QueryString["m"].ToString().Trim() != ""))
                {
                    string[] textArray = base.Request.QueryString["m"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
                    if (textArray.Length != 3)
                    {
                        return;
                    }
                    try
                    {
                        int.Parse(textArray[0]);
                    }
                    catch
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                        return;
                    }
                    if ((textArray[1] != "1") && (textArray[1] != "2"))
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                        return;
                    }
                    if (((((textArray[2].ToUpper() != "BKAH") && (textArray[2].ToUpper() != "BKOE")) && ((textArray[2].ToUpper() != "BKDS") && (textArray[2].ToUpper() != "UBKAH"))) && (((textArray[2].ToUpper() != "UBKOE") && (textArray[2].ToUpper() != "UBKDS")) && ((textArray[2].ToUpper() != "DBKAH") && (textArray[2].ToUpper() != "DBKOE")))) && (textArray[2].ToUpper() != "DBKDS"))
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                        return;
                    }
                    str = textArray[2].ToUpper();
                    text2 = textArray[0].Trim();
                    team = textArray[1];
                    pmsg = "m=" + base.Request.QueryString["m"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                }
                string type = this.tztype(str);
                string ballid = text2;
                if (ballid != "")
                {
                    DataBase db = new DataBase(MyFunc.GetConnStr(2));
                    string[] ball = this.BallMsg(type, ballid, db);
                    db.Dispose();
                    if (ball == null)
                    {
                        this.kyglContent = this.CloseTime();
                        this.DataBind();
                    }
                    else
                    {
                        DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                        string[] user = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base3, type);
                        base3.Dispose();
                        this.kyglContent = this.TzTime(type, user, ball, team, pmsg);
                        if (this.kyglContent.IndexOf("0.000") > 0)
                        {
                            this.kyglContent = this.CloseTime();
                        }
                        this.DataBind();
                    }
                }
                else
                {
                    this.kyglContent = this.PeaceTime();
                    this.DataBind();
                }
            }
            else if (((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "kygl")) && ((base.Request.Form["fr_matchindex"] != null) && (base.Request.Form["fr_matchindex"].ToString().Trim() != ""))) && (((base.Request.Form["fr_betamount"] != null) && (base.Request.Form["fr_betamount"].ToString().Trim() != "")) && ((base.Request.Form["fr_bettype"] != null) && (base.Request.Form["fr_bettype"].ToString().Trim() != "")))) && ((base.Request.Form["fr_pick"] != null) && (base.Request.Form["fr_pick"].ToString().Trim() != "")))
            {
                string text7 = base.Request.Form["fr_matchindex"].ToString().Trim();
                string s = base.Request.Form["fr_betamount"].ToString().Trim();
                string text9 = base.Request.Form["fr_bettype"].ToString().Trim();
                string text10 = base.Request.Form["fr_pick"].ToString().Trim();
                string cstype = base.Request.Form["fr_favourite"].ToString().Trim();
                try
                {
                    double num = Math.Abs(double.Parse(s));
                }
                catch
                {
                    this.kyglContent = this.PeaceTime();
                    this.DataBind();
                }
                this.kyglContent = this.saveOrder(text9, text7, text10, s, cstype);
                this.DataBind();
            }
            else if (((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "kyglahparlay")) && ((base.Request.Form["req_ahmatchlist"] != null) && (base.Request.Form["req_ahmatchlist"].ToString().Trim() != "")))
            {
                string[] textArray4 = this.MatchList("21").Split(new char[] { ',' });
                string mlist = "";
                string betlist = "";
                string text15 = "21";
                for (int i = 0; i < textArray4.Length; i++)
                {
                    if ((base.Request.Form["fr_" + textArray4[i]] != null) && (base.Request.Form["fr_" + textArray4[i]].ToString().Trim() != ""))
                    {
                        mlist = mlist + textArray4[i] + ",";
                        betlist = betlist + base.Request.Form["fr_" + textArray4[i]].ToString().Trim() + ",";
                    }
                }
                if ((mlist != "") && (betlist != ""))
                {
                    mlist = mlist.Remove(mlist.Length - 1, 1);
                    betlist = betlist.Remove(betlist.Length - 1, 1);
                }
                else
                {
                    this.kyglContent = this.CloseTime("请选择过关的球赛");
                    this.DataBind();
                    return;
                }
                if (mlist.Split(new char[] { ',' }).Length < 2)
                {
                    this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                    this.DataBind();
                }
                else if (mlist.Split(new char[] { ',' }).Length > 5)
                {
                    this.kyglContent = this.CloseTime("对不起,过关最多选五场球赛");
                    this.DataBind();
                }
                else
                {
                    DataBase base4 = new DataBase(MyFunc.GetConnStr(2));
                    string[] textArray5 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base4, text15);
                    base4.Dispose();
                    this.kyglContent = this.TzTime(text15, textArray5, mlist, betlist);
                    this.DataBind();
                }
            }
            else if ((((base.Request.QueryString["req_ahmatchlist"] != null) && (base.Request.QueryString["req_ahmatchlist"].ToString().Trim() != "")) && ((base.Request.QueryString["req_userbet_list"] != null) && (base.Request.QueryString["req_userbet_list"].ToString().Trim() != ""))) && ((base.Request.QueryString["remove"] != null) && (base.Request.QueryString["remove"].ToString().Trim() != "")))
            {
                string text16 = "21";
                string text17 = base.Request.QueryString["req_ahmatchlist"].ToString().Trim();
                string text18 = base.Request.QueryString["req_userbet_list"].ToString().Trim();
                DataBase base5 = new DataBase(MyFunc.GetConnStr(2));
                string[] textArray6 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base5, text16);
                base5.Dispose();
                string[] textArray7 = text17.Split(new char[] { ',' });
                if (textArray7.Length < 2)
                {
                    this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                    this.DataBind();
                }
                else
                {
                    string[] textArray8 = text18.Split(new char[] { ',' });
                    text17 = "";
                    text18 = "";
                    for (int j = 0; j < textArray7.Length; j++)
                    {
                        if (base.Request.QueryString["remove"].ToString().Trim() != textArray7[j])
                        {
                            text17 = text17 + textArray7[j] + ",";
                            text18 = text18 + textArray8[j] + ",";
                        }
                    }
                    if (text17 != "")
                    {
                        text17 = text17.Remove(text17.Length - 1, 1);
                    }
                    else
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                        return;
                    }
                    if (text18 != "")
                    {
                        text18 = text18.Remove(text18.Length - 1, 1);
                    }
                    else
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                        return;
                    }
                    if (text17.Split(new char[] { ',' }).Length < 2)
                    {
                        this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                        this.DataBind();
                    }
                    else
                    {
                        this.kyglContent = this.TzTime(text16, textArray6, text17, text18);
                        this.DataBind();
                    }
                }
            }
            else if ((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() != "")) && ((base.Request.Form["req_ahmatchlist"] != null) && (base.Request.Form["req_ahmatchlist"].ToString().Trim() != ""))) && ((base.Request.Form["req_userbet_list"] != null) && (base.Request.Form["req_userbet_list"].ToString().Trim() != "")))
            {
                string text19 = base.Request.Form["fr_betamount"].ToString().Trim();
                string text20 = base.Request.Form["fr_bettype"].ToString().Trim();
                string text21 = base.Request.Form["req_ahmatchlist"].ToString().Trim();
                if (text21.Split(new char[] { ',' }).Length < 2)
                {
                    this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                    this.DataBind();
                }
                else if (text21.Split(new char[] { ',' }).Length > 5)
                {
                    this.kyglContent = this.CloseTime("对不起,过关最多选五场球赛");
                    this.DataBind();
                }
                else
                {
                    string text22 = base.Request.Form["req_userbet_list"].ToString().Trim();
                    try
                    {
                        double num4 = Math.Abs(double.Parse(text19));
                    }
                    catch
                    {
                        this.kyglContent = this.PeaceTime();
                        this.DataBind();
                    }
                    this.kyglContent = this.saveOrder(text20, "0", text21, text19, text22);
                    this.DataBind();
                }
            }
            else
            {
                this.kyglContent = this.PeaceTime();
                this.DataBind();
            }
        }

        private string PeaceTime()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT username,usemoney,curmoney,moneysort FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            if (reader.Read())
            {
                string text3 = (("<TABLE height='100' cellSpacing='0' cellPadding='0' width='100' border='0' ms_1d_layout='TRUE'>" + "<TR><TD><TABLE class='bet_entry' cellSpacing='0' cellpading='0' width='218'><TBODY>" + "<TR><TD width='218' background='images/frame_top.gif' colSpan='2' height='24'></TD></TR>") + "<TR><TH background='images/frame_bg.gif' colSpan='2'>户口 (" + reader["username"].ToString().Trim() + ")</TH></TR>") + "<TR><TD background='images/frame_bg.gif' colSpan='2'><TABLE cellSpacing='5' cellPadding='0' width='212' border='0' height='53'><TBODY>";
                string text4 = text3 + "<TR style='background:transparent;'><TD width='50%'>信用馀额</TD><TD>" + reader["moneysort"].ToString().Trim() + " " + reader["curmoney"].ToString().Trim() + "</TD></TR>";
                text = ((text4 + "<TR style='background:transparent;'><TD width='50%'>信用额度</TD><TD>" + reader["moneysort"].ToString().Trim() + " " + reader["usemoney"].ToString().Trim() + "</TD></TR>") + "</TBODY></TABLE></TD></TR><TR><TD background='images/frame_bg.gif' height='10'></TD><TR>") + "<TD width='218' background='images/frame_bottom.gif' colSpan='2' height='18'></TD>" + "</TR></TBODY></TABLE></TD></TR></TABLE>";
                this.Addons = "";
                reader.Close();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private bool SameGame(string[] ball)
        {
            bool flag = false;
            for (int i = 0; i < ball.Length; i++)
            {
                for (int j = i + 1; j < ball.Length; j++)
                {
                    if (ball[i] == ball[j])
                    {
                        flag = true;
                        break;
                    }
                }
                if (flag)
                {
                    return flag;
                }
            }
            return flag;
        }

        private string saveOrder(string type, string ballid, string team, string money, string cstype)
        {
            if (hashtable.hash2 == null)
            {
                Hashtable hashtable1 = new Hashtable(20, 0.5f);
                hashtable1.Add("25", 0);
                hashtable1.Add("22", 1);
                hashtable1.Add("18", 2);
                hashtable1.Add("26", 3);
                hashtable1.Add("23", 4);
                hashtable1.Add("19", 5);
                hashtable1.Add("27", 6);
                hashtable1.Add("24", 7);
                hashtable1.Add("20", 8);
                hashtable1.Add("21", 9);
                hashtable.hash2 = hashtable1;
            }
            if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return "";
            }
            try
            {
                object obj2;
                object obj3;
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                string[] textArray = null;
                string orderid = this.NewOrderid(MyFunc.TimeStampe());
                string ss = orderid;
                string text3 = "FALSE";
                string s = "";
                if (((obj2 = type.Trim()) != null) && ((obj2 = hashtable.hash3[obj2]) != null))
                {
                    switch (((int) obj2))
                    {
                        case 0:
                        case 1:
                        case 2:
                            textArray = this.GetRqMsg(ballid, team, db);
                            text3 = (textArray != null) ? textArray[5] : "FALSE";
                            s = textArray[1];
                            goto Label_02FA;

                        case 3:
                        case 4:
                        case 5:
                            textArray = this.GetDxMsg(ballid, team, db);
                            text3 = (textArray != null) ? textArray[5] : "FALSE";
                            s = textArray[1];
                            goto Label_02FA;

                        case 6:
                        case 7:
                        case 8:
                            textArray = this.GetDsMsg(ballid, team, db, type.Trim());
                            text3 = (textArray != null) ? textArray[3] : "FALSE";
                            s = textArray[0];
                            goto Label_02FA;

                        case 9:
                            textArray = this.GetRqggMsg(team, cstype, db, out ss, orderid);
                            goto Label_02FA;
                    }
                }
                textArray = null;
            Label_02FA:
                db.Dispose();
                if (textArray == null)
                {
                    return this.CloseTime("对不起,球赛已关闭");
                }
                if (type != "21")
                {
                    if (double.Parse(s) == 0)
                    {
                        return this.CloseTime();
                    }
                    if (double.Parse(s) != double.Parse(base.Request.Form["fr_odds"].ToString().Trim()))
                    {
                        return this.CloseTime("赔率变化，暂停下注。");
                    }
                }
                string text5 = "0";
                string username = "";
                string text7 = "";
                string text8 = "0";
                string moneysort = "";
                string text10 = "1";
                string text11 = "0";
                string text12 = "";
                string text13 = "0";
                string text14 = "";
                string text15 = "0";
                string text16 = "0";
                string text17 = "0";
                string text18 = "0";
                string text19 = "0";
                string text20 = "0";
                string text21 = "0";
                string text22 = "0";
                string text23 = "0";
                string text24 = "0";
                string text25 = "0";
                string text26 = "0";
                string text27 = "0";
                string text28 = "0";
                string text29 = "0";
                string text30 = "0";
                string sql = "";
                string text32 = this.userSql(type);
                string text33 = Math.Abs(double.Parse(money)).ToString();
                sql = "SELECT member.userid,member.userpass,member.username,member.usemoney,member.gdid,member.zdlid,member.dlsid,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,member.isuseable,agence.bl,agence.gdbl,agence.zdlbl" + text32 + " FROM hs RIGHT OUTER JOIN userhs RIGHT OUTER JOIN member ON userhs.userid = member.userid LEFT OUTER JOIN agence ON member.dlsid = agence.userid ON hs.type = member.ABC AND hs.userid = member.dlsid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base3.ExecuteReader(sql);
                if (reader.Read())
                {
                    text5 = reader["userid"].ToString().Trim();
                    username = reader["username"].ToString().Trim();
                    text7 = reader["userpass"].ToString().Trim();
                    text8 = reader["usemoney"].ToString().Trim();
                    moneysort = reader["moneysort"].ToString().Trim();
                    text10 = reader["moneyrate"].ToString().Trim();
                    text11 = reader["curmoney"].ToString().Trim();
                    text12 = reader["abc"].ToString().Trim();
                    text13 = reader["isuseable"].ToString().Trim();
                    text14 = base.Request.UserHostAddress.Trim();
                    text15 = reader["gdid"].ToString().Trim();
                    text16 = reader["zdlid"].ToString().Trim();
                    text17 = reader["dlsid"].ToString().Trim();
                    text26 = (double.Parse(reader["gdbl"].ToString().Trim()) / 100).ToString();
                    text27 = (double.Parse(reader["zdlbl"].ToString().Trim()) / 100).ToString();
                    text28 = (double.Parse(reader["bl"].ToString().Trim()) / 100).ToString();
                    text24 = reader[15].ToString().Trim();
                    text25 = reader[0x10].ToString().Trim();
                    text18 = reader[0x11].ToString().Trim();
                    text19 = reader[0x12].ToString().Trim();
                    text22 = reader[0x13].ToString().Trim();
                    text23 = reader[20].ToString().Trim();
                    reader.Close();
                }
                else
                {
                    reader.Close();
                    base3.Dispose();
                    MyFunc.goToLoginPage();
                    base.Response.End();
                    return "";
                }
                if (text7 != this.Session.Contents["userpass"].ToString().Trim())
                {
                    base3.Dispose();
                    MyFunc.goToLoginPage();
                    base.Response.End();
                    return "";
                }
                if (double.Parse(money) < double.Parse(this.MinBet))
                {
                    base3.Dispose();
                    this.kyglContent = this.CloseTime("投注金额不能小于" + this.MinBet);
                    this.DataBind();
                    base.Response.End();
                    return "";
                }
                if (double.Parse(money) > double.Parse(text11))
                {
                    base3.Dispose();
                    this.kyglContent = this.CloseTime("投注金额不能大于信用余额");
                    this.DataBind();
                    base.Response.End();
                    return "";
                }
                if (double.Parse(money) > double.Parse(text19))
                {
                    base3.Dispose();
                    this.kyglContent = this.CloseTime("投注金额不能大于单注限额");
                    this.DataBind();
                    base.Response.End();
                    return "";
                }
                if ((type != "21") && ((int.Parse(base3.ExecuteScalar("SELECT ISNULL(CONVERT(int,SUM(tzmoney)),0) FROM ball_order WHERE tzteam = '" + textArray[0] + "' AND userid=" + this.Session.Contents["userid"].ToString().Trim() + " AND  isjs=0 AND  ballid=" + ballid + " AND tztype=" + type + " AND datediff(day,balltime,getdate())=0").ToString()) + int.Parse(text33)) > int.Parse(text18)))
                {
                    base3.Dispose();
                    return this.CloseTime("单场投注额不能超过 " + text18);
                }
                sql = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text12.ToUpper() + "' AND userid=" + text16;
                SqlDataReader reader2 = base3.ExecuteReader(sql);
                if (reader2.Read())
                {
                    text20 = reader2[1].ToString().Trim();
                    text21 = reader2[2].ToString().Trim();
                }
                else
                {
                    text20 = "0";
                    text21 = "0";
                }
                reader2.Close();
                sql = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text12.ToUpper() + "' AND userid=" + text15;
                reader2 = base3.ExecuteReader(sql);
                if (reader2.Read())
                {
                    text29 = reader2[1].ToString().Trim();
                    text30 = reader2[2].ToString().Trim();
                }
                else
                {
                    text29 = "0";
                    text30 = "0";
                }
                reader2.Close();
                string text34 = "";
                string content = "";
                string text36 = "";
                if (((obj3 = type) != null) && ((obj3 = hashtable.hash2[obj3]) != null))
                {
                    switch (((int) obj3))
                    {
                        case 0:
                        case 1:
                        case 2:
                            text34 = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc)VALUES(" + orderid + "," + ballid + "," + type + "," + text33 + "," + textArray[1] + ",'" + textArray[0] + "','" + textArray[2] + "'," + textArray[3] + ",'" + textArray[4] + "'," + text5 + ",'" + username + "'," + text15 + "," + text16 + "," + text17 + "," + text20 + "," + text22 + "," + text24 + "," + text21 + "," + text23 + "," + text25 + "," + text29 + "," + text30 + "," + text26 + "," + text27 + "," + text28 + ",'" + text14 + "',GetDate()," + text10 + ",'" + textArray[6] + "','" + text12 + "');";
                            content = textArray[4];
                            text36 = textArray[1];
                            break;

                        case 3:
                        case 4:
                        case 5:
                            text34 = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,dxc,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc)VALUES(" + orderid + "," + ballid + "," + type + "," + text33 + "," + textArray[1] + ",'" + textArray[0] + "','" + textArray[2] + "'," + textArray[3] + ",'" + textArray[4] + "'," + text5 + ",'" + username + "'," + text15 + "," + text16 + "," + text17 + "," + text20 + "," + text22 + "," + text24 + "," + text21 + "," + text23 + "," + text25 + "," + text29 + "," + text30 + "," + text26 + "," + text27 + "," + text28 + ",'" + text14 + "',GetDate()," + text10 + ",'" + textArray[6] + "','" + text12 + "');";
                            content = textArray[4];
                            text36 = textArray[1];
                            break;

                        case 6:
                        case 7:
                        case 8:
                            text34 = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,ds,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc)VALUES(" + orderid + "," + ballid + "," + type + "," + text33 + "," + textArray[0] + ",'" + textArray[1] + "','" + textArray[2] + "'," + text5 + ",'" + username + "'," + text15 + "," + text16 + "," + text17 + "," + text20 + "," + text22 + "," + text24 + "," + text21 + "," + text23 + "," + text25 + "," + text29 + "," + text30 + "," + text26 + "," + text27 + "," + text28 + ",'" + text14 + "',GetDate()," + text10 + ",'" + textArray[4] + "','" + text12 + "');";
                            content = textArray[4];
                            text36 = textArray[1];
                            break;

                        case 9:
                            text34 = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc)VALUES(" + orderid + "," + ballid + "," + type + "," + text33 + "," + textArray[0] + ",'" + textArray[1] + "'," + text5 + ",'" + username + "'," + text15 + "," + text16 + "," + text17 + "," + text20 + "," + text22 + "," + text24 + "," + text21 + "," + text23 + "," + text25 + "," + text29 + "," + text30 + "," + text26 + "," + text27 + "," + text28 + ",'" + text14 + "',GetDate()," + text10 + ",GetDate(),'" + text12 + "');";
                            content = textArray[1];
                            text36 = textArray[0];
                            break;
                    }
                }
                if (base3.ExecuteNonQuery(text34) > 0)
                {
                    base3.ExecuteNonQuery("UPDATE member SET curmoney=curmoney-" + text33 + ",xzcount=xzcount+1,xztotal=xztotal+" + money + " WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
                }
                base3.Dispose();
                double num6 = double.Parse(text36) * int.Parse(text33);
                int num7 = int.Parse(text11) - int.Parse(text33);
                return this.FinishTime(orderid, username, content, text33, num6.ToString(), moneysort, num7.ToString());
            }
            catch
            {
                return this.CloseTime();
            }
        }

        private string TzTime(string type, string[] user, string mlist, string betlist)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string ototal = "";
            string obetlist = "";
            text2 = this.ygltz(type, mlist, betlist, out obetlist, out ototal, true);
            text3 = this.ygltzInput(type, user, mlist, betlist, ototal);
            text4 = this.MaxPayOut(type);
            if (text2 == "")
            {
                return this.CloseTime("同一个过关里不能有相同球赛");
            }
            text = "<form name='myForm' action='betting-entry-bk.aspx' method='post' onSubmit='return showPreviewScreen()' onKeyPress='disableEnterKey()'>";
            text = (((((((((((((((((((((text + "<table class='bet_entry' cellpading=0 cellspacing=0 id='entryScreen' background='images/frame_bg.gif'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr><th colspan=2 colspan=2 background='images/frame_bg.gif'>下注 (" + user[1] + ")</th></tr>") + "<tr style='background:transparent;'><td>信用余额</td><td>" + user[5] + "</td></tr>") + "<tr style='background:transparent;'><td>信用额度</td><td>" + user[2] + "</td></tr>") + "<tr style='background:transparent;'><td>货币</td><td>" + user[3] + "</td></tr>") + "<tr style='background:transparent;'><td colspan=2 class='wager'>" + text2) + "</td></tr>" + text4 + "<tr style='background:transparent;'><td>注额</td><td><input name='fr_betamount' size=10 style='font-size:16px;font-weight:bold' maxlenght=12 onKeyUp=\"calculateEstPayout('hk','0')\"></td></tr>") + "<tr style='background:transparent;'><td>可嬴额</td><td><span class='payout' id='estPayout1'></span></td></tr>") + "<tr style='background:transparent;'><td>下注限额</td><td>" + MyFunc.NumBerFormat(user[8], true) + "</td></tr>") + "<tr style='background:transparent;'><td>最低注额</td><td>" + this.MinBet + "</td></tr>") + "<tr id='errorScreen' style='display:none'><td class='error' colspan=2><span id='errorMsg'>&nbsp;</span></td></tr>" + "<tr style='background:transparent;'><td>&nbsp;</td><td style='padding:2px'>\n") + "<input type='button' class='buttsave' value='下注' onClick='showPreviewScreen()'> <input type='button' value='取消' class='buttcancel' onClick='cancelBet()'></td>\n" + "</tr><td height=10 background='images/frame_bg.gif'></td><tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table>\n") + text3 + "</form>") + "<form name='myForm2' action='?' onSubmit='document.myForm.fr_confirmed.value=1;myForm.submit();disableButton();return false;' onKeyPress='disableEnterKey()'>\n") + "<table id='previewScreen' class='bet_entry' cellpading=0 cellspacing=0 background='images/frame_bg.gif' style='display:none'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr style='background:transparent;'><th colspan=2>下注确认 (" + user[1] + ")</th></tr>") + "<tr style='background:transparent;'><td colspan=2 class='wager'>" + this.ygltz(type, mlist, betlist, out obetlist, out ototal, false)) + "</td></tr><tr style='background:transparent;'><td>货币</td><td>" + user[3] + "</td></tr>") + "<tr style='background:transparent;'><td>注额</td><td><span class='amount' id='betAmount'></span></td></tr>" + "<tr style='background:transparent;'><td>可嬴额</td><td><span class='payout' id='estPayout2'></span></td></tr>") + "<tr style='background:transparent;'><td>现时信用</td><td>" + user[2] + "</td></tr>") + "<tr style='background:transparent;'><td>信用馀额</td><td><span id='creditAfterBet'></span></td></tr>" + "<tr style='background:transparent;'><td>&nbsp;</td>") + "<td><input type='submit' name='fr_submit' id='fr_submit' value='最后确定' class='buttsave'> <input type='button' id='fr_back' value='取消' class='buttcancel' onClick='showEntryScreen()'></td></tr><td colspan=2 height=10 background='images/frame_bg.gif'></td>" + "<tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table><br></form>";
            this.Addons = " onLoad=\"doFormLoad()\"";
            return text;
        }

        private string TzTime(string type, string[] user, string[] ball, string team, string pmsg)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            switch (type)
            {
                case "25":
                case "18":
                    text2 = this.AhTz(ball, team, type);
                    text3 = this.AhTzInput(user, ball, team, type);
                    goto Label_0148;

                case "26":
                case "19":
                    text2 = this.OeTz(ball, team, type);
                    text3 = this.OeTzInput(user, ball, team, type);
                    goto Label_0148;

                case "27":
                case "20":
                    text2 = this.DSTz(ball, team, type);
                    text3 = this.DSTzInput(user, ball, team, type);
                    goto Label_0148;

                case "22":
                    text2 = this.AhTz(ball, team, type);
                    text3 = this.AhTzInput(user, ball, team, type);
                    goto Label_0148;

                case "23":
                    text2 = this.OeTz(ball, team, type);
                    text3 = this.OeTzInput(user, ball, team, type);
                    break;

                case "24":
                    text2 = this.DSTz(ball, team, type);
                    text3 = this.DSTzInput(user, ball, team, type);
                    break;
            }
        Label_0148:
            text = "<form name='myForm' action='betting-entry-bk.aspx' method='post' onSubmit='return showPreviewScreen()' onKeyPress='disableEnterKey()'>";
            text = ((((((((((((((((((((((text + "<input name='kyglpost' value='" + pmsg + "' type='hidden'>") + "<table class='bet_entry' cellpading=0 cellspacing=0 id='entryScreen' background='images/frame_bg.gif'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr><th colspan=2 colspan=2 background='images/frame_bg.gif'>下注 (" + user[1] + ")</th></tr>") + "<tr style='background:transparent;'><td>信用余额</td><td>" + user[5] + "</td></tr>") + "<tr style='background:transparent;'><td>信用额度</td><td>" + user[2] + "</td></tr>") + "<tr style='background:transparent;'><td>货币</td><td>" + user[3] + "</td></tr>") + "<tr style='background:transparent;'><td colspan=2 class='wager'>" + text2) + "</td></tr>" + text4 + "<tr style='background:transparent;'><td>注额</td><td><input name='fr_betamount' size=10 style='font-size:16px;font-weight:bold' maxlenght=12 onKeyUp=\"calculateEstPayout('hk','0')\"></td></tr>") + "<tr style='background:transparent;'><td>可嬴额</td><td><span class='payout' id='estPayout1'></span></td></tr>") + "<tr style='background:transparent;'><td>下注限额</td><td>" + MyFunc.NumBerFormat(user[8], true) + "</td></tr>") + "<tr style='background:transparent;'><td>最低注额</td><td>" + this.MinBet + "</td></tr>") + "<tr id='errorScreen' style='display:none'><td class='error' colspan=2><span id='errorMsg'>&nbsp;</span></td></tr>" + "<tr style='background:transparent;'><td>&nbsp;</td><td style='padding:2px'>\n") + "<input type='button' class='buttsave' value='下注' onClick='showPreviewScreen()'> <input type='button' value='取消' class='buttcancel' onClick='cancelBet()'></td>\n" + "</tr><td height=10 background='images/frame_bg.gif'></td><tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table>\n") + text3 + "</form>") + "<form name='myForm2' action='?' onSubmit='document.myForm.fr_confirmed.value=1;myForm.submit();disableButton();return false;' onKeyPress='disableEnterKey()'>\n") + "<table id='previewScreen' class='bet_entry' cellpading=0 cellspacing=0 background='images/frame_bg.gif' style='display:none'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='218' height='24'></td></tr>") + "<tr style='background:transparent;'><th colspan=2>下注确认 (" + user[1] + ")</th></tr>") + "<tr style='background:transparent;'><td colspan=2 class='wager'>" + text2) + "</td></tr><tr style='background:transparent;'><td>货币</td><td>" + user[3] + "</td></tr>") + "<tr style='background:transparent;'><td>注额</td><td><span class='amount' id='betAmount'></span></td></tr>" + "<tr style='background:transparent;'><td>可嬴额</td><td><span class='payout' id='estPayout2'></span></td></tr>") + "<tr style='background:transparent;'><td>现时信用</td><td>" + user[5] + "</td></tr>") + "<tr style='background:transparent;'><td>信用馀额</td><td><span id='creditAfterBet'></span></td></tr>" + "<tr style='background:transparent;'><td>&nbsp;</td>") + "<td><input type='submit' name='fr_submit' id='fr_submit' value='最后确定' class='buttsave'> <input type='button' id='fr_back' value='取消' class='buttcancel' onClick='showEntryScreen()'></td></tr><td colspan=2 height=10 background='images/frame_bg.gif'></td>" + "<tr><td colspan=2 background='images/frame_bottom.gif' width='218' height='18'></tr></table><br></form>";
            this.Addons = " onLoad=\"doFormLoad()\"";
            return text;
        }

        private string tztype(string str)
        {
            switch (str.Trim().ToUpper())
            {
                case "BKAH":
                    return "18";

                case "BKOE":
                    return "19";

                case "BKDS":
                    return "20";

                case "UBKAH":
                    return "22";

                case "UBKOE":
                    return "23";

                case "UBKDS":
                    return "24";

                case "DBKAH":
                    return "25";

                case "DBKOE":
                    return "26";

                case "DBKDS":
                    return "27";
            }
            return "";
        }

        private string[] usermsg(string userid, DataBase db, string type)
        {
            string sql = "SELECT member.userid,member.username,member.usemoney,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,";
            sql = (sql + "userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC24,userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ24") + " FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid = " + userid + " AND member.isuseable=1";
            SqlDataReader reader = db.ExecuteReader(sql);
            if (!reader.Read())
            {
                reader.Close();
                return null;
            }
            string[] textArray = new string[9];
            textArray[0] = reader["userid"].ToString().Trim();
            textArray[1] = reader["username"].ToString().Trim();
            textArray[2] = reader["usemoney"].ToString().Trim();
            textArray[3] = reader["moneysort"].ToString().Trim();
            textArray[4] = reader["moneyrate"].ToString().Trim();
            textArray[5] = reader["curmoney"].ToString().Trim();
            textArray[6] = reader["abc"].ToString().Trim();
            switch (type.Trim())
            {
                case "25":
                case "18":
                    textArray[7] = reader["Maxc18"].ToString().Trim();
                    textArray[8] = reader["Maxz18"].ToString().Trim();
                    break;

                case "26":
                case "19":
                    textArray[7] = reader["Maxc19"].ToString().Trim();
                    textArray[8] = reader["Maxz19"].ToString().Trim();
                    break;

                case "27":
                case "20":
                    textArray[7] = reader["Maxc20"].ToString().Trim();
                    textArray[8] = reader["Maxz20"].ToString().Trim();
                    break;

                case "21":
                    textArray[7] = reader["Maxc21"].ToString().Trim();
                    textArray[8] = reader["Maxz21"].ToString().Trim();
                    break;

                case "22":
                    textArray[7] = reader["Maxc22"].ToString().Trim();
                    textArray[8] = reader["Maxz22"].ToString().Trim();
                    break;

                case "23":
                    textArray[7] = reader["Maxc23"].ToString().Trim();
                    textArray[8] = reader["Maxz23"].ToString().Trim();
                    break;

                case "24":
                    textArray[7] = reader["Maxc24"].ToString().Trim();
                    textArray[8] = reader["Maxz24"].ToString().Trim();
                    break;

                default:
                    textArray[7] = "0";
                    textArray[8] = "0";
                    break;
            }
            reader.Close();
            return textArray;
        }

        private string userSql(string type)
        {
            switch (type.Trim())
            {
                case "18":
                    return ",userhs.W18,userhs.L18,userhs.Maxc18,userhs.Maxz18,hs.W18 AS DlsW18,hs.L18 AS DlsL18";

                case "19":
                    return ",userhs.W19,userhs.L19,userhs.Maxc19,userhs.Maxz19,hs.W19 AS DlsW19,hs.L19 AS DlsL19";

                case "20":
                    return ",userhs.W20,userhs.L20,userhs.Maxc20,userhs.Maxz20,hs.W20 AS DlsW20,hs.L20 AS DlsL20";

                case "21":
                    return ",userhs.W21,userhs.L21,userhs.Maxc21,userhs.Maxz21,hs.W21 AS DlsW21,hs.L21 AS DlsL21";

                case "22":
                    return ",userhs.W22,userhs.L22,userhs.Maxc22,userhs.Maxz22,hs.W22 AS DlsW22,hs.L22 AS DlsL22";

                case "23":
                    return ",userhs.W23,userhs.L23,userhs.Maxc23,userhs.Maxz23,hs.W23 AS DlsW23,hs.L23 AS DlsL23";

                case "24":
                    return ",userhs.W24,userhs.L24,userhs.Maxc24,userhs.Maxz24,hs.W24 AS DlsW24,hs.L24 AS DlsL24";

                case "25":
                    return ",userhs.W18,userhs.L18,userhs.Maxc18,userhs.Maxz18,hs.W18 AS DlsW18,hs.L18 AS DlsL18";

                case "26":
                    return ",userhs.W19,userhs.L19,userhs.Maxc19,userhs.Maxz19,hs.W19 AS DlsW19,hs.L19 AS DlsL19";

                case "27":
                    return ",userhs.W20,userhs.L20,userhs.Maxc20,userhs.Maxz20,hs.W20 AS DlsW20,hs.L20 AS DlsL20";
            }
            return "";
        }

        private string ygltz(string type, string mlist, string betlist, out string obetlist, out string ototal, bool bo)
        {
            string[] textArray = mlist.Split(new char[] { ',' });
            string[] textArray2 = betlist.Split(new char[] { ',' });
            string[] textArray3 = new string[textArray2.Length];
            string[] textArray4 = new string[textArray2.Length];
            string text = "";
            string text2 = "";
            double num = 1;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (type == "21")
            {
                SqlDataReader reader = base2.ExecuteReader("SELECT * FROM BK_Ball_PL1viewRQ WHERE ballid in(" + mlist + ")");
                while (reader.Read())
                {
                    for (int i = 0; i < textArray.Length; i++)
                    {
                        string text5 = "";
                        string text6 = "VS";
                        if (textArray[i] == reader["ballid"].ToString().Trim())
                        {
                            string text3;
                            string text4;
                            text6 = reader["giveup"].ToString().Trim();
                            if (reader["xenial"].ToString().Trim().ToUpper() == "H")
                            {
                                text3 = reader["team1"].ToString().Trim();
                                text4 = reader["team2"].ToString().Trim();
                                if (textArray2[i].Trim().ToLower() == "a")
                                {
                                    textArray3[i] = double.Parse(reader["giveup1"].ToString().Trim()).ToString("F3");
                                    text5 = reader["team1"].ToString().Trim();
                                }
                                else
                                {
                                    textArray3[i] = double.Parse(reader["giveup2"].ToString().Trim()).ToString("F3");
                                    text5 = reader["team2"].ToString().Trim();
                                }
                            }
                            else
                            {
                                text3 = reader["team2"].ToString().Trim();
                                text4 = reader["team1"].ToString().Trim();
                                if (textArray2[i].Trim().ToLower() == "a")
                                {
                                    textArray3[i] = double.Parse(reader["giveup2"].ToString().Trim()).ToString("F3");
                                    text5 = reader["team2"].ToString().Trim();
                                }
                                else
                                {
                                    textArray3[i] = double.Parse(reader["giveup1"].ToString().Trim()).ToString("F3");
                                    text5 = reader["team1"].ToString().Trim();
                                }
                            }
                            text = text + textArray3[i] + ",";
                            string text8 = text2;
                            text2 = text8 + "<DIV>" + reader["matchname"].ToString().Trim() + "<BR>" + text3 + " <SPAN class=hdp>" + text6 + "</span> " + text4 + "<BR><SPAN class=pick>" + text5 + "</SPAN> @ <SPAN class=odds>" + textArray3[i] + "</SPAN> ";
                            if (bo)
                            {
                                text2 = text2 + "<INPUT class=buttx id=" + reader["ballid"].ToString().Trim() + " onclick=cancelParlayBet(this) type=button value=\" x \">";
                            }
                            text2 = text2 + "<HR style=\"COLOR: gray; HEIGHT: 1px\"></DIV>";
                        }
                    }
                }
                if (text != "")
                {
                    text = text.Remove(text.Length - 1, 1);
                }
                reader.Close();
                base2.Dispose();
                int index = 0;
                while (index < textArray3.Length)
                {
                    num *= double.Parse(textArray3[index]) + 1;
                    index++;
                }
                string text9 = text2;
                text2 = text9 + "<SPAN class=pick>" + index.ToString() + " 让球过关</SPAN> @ <SPAN class=odds style=\"FONT-SIZE: 18px\">" + num.ToString("F3") + "</SPAN>";
            }
            ototal = num.ToString("F3");
            obetlist = text;
            return text2;
        }

        private string ygltzInput(string type, string[] user, string mlist, string blist, string total)
        {
            string text = "";
            text = (((((((((((((text + "<INPUT type=hidden value='" + user[5] + "' name='fr_credit'> ") + "<INPUT type=hidden value='" + this.MinBet + "' name='fr_minbet'> ") + "<INPUT type=hidden value='" + user[8] + "' name='fr_maxbet'> ") + "<INPUT type=hidden value='" + MyFunc.GetMaxPayOut() + "' name='fr_maximum_payout'> ") + "<INPUT type=hidden name='fr_estimate_payout'> ") + "<INPUT type=hidden name='fr_odds_lose' value=''> " + "<INPUT type=hidden name='fr_spread' value=''> ") + "<INPUT type=hidden name='fr_handicap' value=''> " + "<INPUT type=hidden name='fr_matchindex' value=''> ") + "<INPUT type=hidden name='fr_magnumindex' value=''> " + "<INPUT type=hidden name='fr_pick' value=''> ") + "<INPUT type=hidden name='fr_scorea' value=''> " + "<INPUT type=hidden name='fr_scoreb value='''> ") + "<INPUT type=hidden value='" + type + "' name='fr_bettype'> ") + "<INPUT type=hidden name='fr_favourite' value=''> ") + "<INPUT type=hidden name='fr_dangerstatus' value=''> " + "<INPUT type=hidden value='0' name='fr_confirmed'> ") + "<INPUT type=hidden value='" + ((double.Parse(total) - 1)).ToString() + "' name='fr_odds'> ") + "<INPUT type=hidden value='" + ((double.Parse(total) - 1)).ToString() + "' name='fr_odds_cap'> ";
            if (type == "21")
            {
                text = (text + "<INPUT type=hidden value='" + mlist + "' name='req_ahmatchlist'> ") + "<INPUT type=hidden value='" + blist + "' name='req_userbet_list'> ";
            }
            return (text + "<input type='hidden' name='action' value='kygl'>");
        }
    }
}

