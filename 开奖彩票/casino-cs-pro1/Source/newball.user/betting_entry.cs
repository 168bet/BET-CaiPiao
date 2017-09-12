namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Configuration;

    public class betting_entry : Page
    {
        public string Addons = "";
        public string bettype = "";
        public string kyglContent = "";
        protected HtmlGenericControl kyglDiv;
        public string MinBet = ConfigurationSettings.AppSettings["MinBet"];

        private string agenceSql(string type)
        {
            switch (type.Trim())
            {
                case "1":
                    return ",W2,L2";

                case "2":
                    return ",W3,L3";

                case "3":
                    return ",W4,L4";

                case "4":
                    return ",W5,L5";

                case "5":
                    return ",W6,L6";

                case "6":
                    return ",W19,L19";

                case "7":
                    return ",W20,L20";

                case "8":
                    return ",W1,L1";

                case "9":
                    return ",W28,L28";

                case "10":
                    return ",W21,L21";

                case "11":
                    return ",W8,L8";

                case "12":
                    return ",W9,L9";

                case "13":
                    return ",W7,L7";

                case "14":
                    return ",W10,L10";

                case "15":
                    return ",W11,L11";

                case "16":
                    return ",W12,L12";

                case "17":
                    return ",W13,L13";

                case "18":
                    return ",W19,L19";

                case "19":
                    return ",W22,L22";

                case "20":
                    return ",W23,L23";

                case "21":
                    return ",W24,L24";
            }
            return "";
        }

        private string[] BallMsg(string ballid, DataBase db)
        {
            string sql = "";
            string text2 = "";
            int num = int.Parse(ballid);
            sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id=" + ballid;
            SqlDataReader reader = db.ExecuteReader(sql);
            if (!reader.Read())
            {
                reader.Close();
                return null;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string[] textArray = new string[reader.FieldCount + 2];
            int index = 0;
            while (index < reader.FieldCount)
            {
                textArray[index] = reader[index].ToString().Trim();
                index++;
            }
            text2 = reader["tztype"].ToString().Trim();
            reader.Close();
            if ((text2 != "16") && (text2 != "12"))
            {
                sql = "SELECT sum(tzmoney) as tzmoney FROM ball_order where (DATEDIFF(dd, GETDATE(), updatetime) =0) and userid =" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + ballid;
            }
            else
            {
                sql = "SELECT sum(tzmoney) as tzmoney FROM ball_order where (DATEDIFF(dd, GETDATE(), updatetime) =0) and userid =" + this.Session.Contents["userid"].ToString().Trim() + " and tztype=" + text2;
            }
            reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                textArray[index] = reader["tzmoney"].ToString().Trim();
            }
            reader.Close();
            sql = "SELECT top 1 qishu,tupdatetime,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            reader = base2.ExecuteReader(sql);
            if (!reader.Read())
            {
                return null;
            }
            if ((((num > 0) && (num < 7)) || ((num > 0x22) && (num < 0x54))) || (((num > 0xc7) && (num < 0xd7)) || ((num > 0xe5) && (num < 0xf4))))
            {
                TimeSpan span = Convert.ToDateTime(reader["tupdatetime"].ToString()).Subtract(DateTime.Now);
                int num3 = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
                if (num3 < 1)
                {
                    return null;
                }
            }
            else
            {
                TimeSpan span2 = Convert.ToDateTime(reader["kaisai"].ToString()).Subtract(DateTime.Now);
                int num4 = (((span2.Days * 0x15180) + (span2.Hours * 0xe10)) + (span2.Minutes * 60)) + span2.Seconds;
                if (num4 < 1)
                {
                    return null;
                }
            }
            textArray[index + 1] = reader["qishu"].ToString().Trim();
            reader.Close();
            base2.Dispose();
            return textArray;
        }

        private string CloseTime()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT username,usemoney,curmoney,moneysort FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            if (reader.Read())
            {
                string text3 = ("<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + " <TBODY><TR><TD vAlign=top height=22><IMG height=22 src=images/order_ph11.gif width=241></TD></TR>" + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩注单</TD></TR> ") + "<TR><TD vAlign=top height=30><IMG height=30   src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>";
                text = (((text3 + "<TBODY> <TR><TD>帐户名称: " + this.Session.Contents["username"].ToString().Trim() + "</TD></TR><TR><TD>信用馀额:" + reader["curmoney"].ToString().Trim() + "</TD></TR>") + " <TR><TD align=left><table bgcolor=CCCCCC cellSpacing=0 cellPadding=0><tr><td>对不起，已关闭投注！</td></tr></table></TD></TR>") + "  <TR><TD align=middle colSpan=2><INPUT class=zabutton_01 onclick=self.location='betting-entry.aspx' type=button value=离开 name=FINISH> " + " &nbsp;&nbsp; <INPUT class=zabutton_01 onclick=window.print() type=button value=列印 name=PRINT> </TD></TR></TBODY></TABLE></TD></TR>") + " <TR><TD vAlign=top height=11><IMG height=11  src=images/order_ph51.gif width=241></TD></TR>" + "<TR><TD vAlign=top align=middle><FONT  color=yellow></FONT>&nbsp;<BR></TD></TR></TBODY></TABLE>";
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
                string text3 = ("<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + " <TBODY><TR><TD vAlign=top height=22><IMG height=22 src=images/order_ph11.gif width=241></TD></TR>" + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩注单</TD></TR> ") + "<TR><TD vAlign=top height=30><IMG height=30   src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>";
                text = (((text3 + "<TBODY> <TR><TD>帐户名称: " + this.Session.Contents["username"].ToString().Trim() + "</TD></TR><TR><TD>信用馀额:" + reader["curmoney"].ToString().Trim() + "</TD></TR>") + " <TR><TD align=left><table bgcolor=CCCCCC cellSpacing=0 cellPadding=0><tr><td>" + msg + "</td></tr></table></TD></TR>") + "  <TR><TD align=middle colSpan=2><INPUT class=zabutton_01 onclick=self.location='betting-entry.aspx' type=button value=离开 name=FINISH> " + " &nbsp;&nbsp; <INPUT class=zabutton_01 onclick=window.print() type=button value=列印 name=PRINT> </TD></TR></TBODY></TABLE></TD></TR>") + " <TR><TD vAlign=top height=11><IMG height=11  src=images/order_ph51.gif width=241></TD></TR>" + "<TR><TD vAlign=top align=middle><FONT  color=yellow></FONT>&nbsp;<BR></TD></TR></TBODY></TABLE>";
                reader.Close();
                base2.Dispose();
            }
            else
            {
                reader.Close();
                base2.Dispose();
            }
            this.Addons = " onLoad=\"TimeOut()\"";
            return text;
        }

        private string CsContent(string team)
        {
            string text = "";
            if (team.IndexOf("h") != -1)
            {
                text = team.Replace("h", "");
                return (text.Split(new char[] { '_' })[0] + ":" + text.Split(new char[] { '_' })[1]);
            }
            if (team.IndexOf("c") != -1)
            {
                text = team.Replace("c", "");
                return (text.Split(new char[] { '_' })[1] + ":" + text.Split(new char[] { '_' })[0]);
            }
            text = team.Replace("d", "");
            return (text.Split(new char[] { '_' })[0] + ":" + text.Split(new char[] { '_' })[1]);
        }

        private string CsContent(string team, string cc)
        {
            if (cc.IndexOf("_") > 0)
            {
                string[] textArray = cc.Trim().Split(new char[] { '_' });
                if (team.Trim().ToUpper() == "H")
                {
                    return ("1," + textArray[0] + ":" + textArray[1]);
                }
                if (team.Trim().ToUpper() == "A")
                {
                    return ("2," + textArray[1] + ":" + textArray[0]);
                }
                return ("3," + textArray[0] + ":" + textArray[1]);
            }
            if (team.Trim().ToUpper() == "H")
            {
                return "1,up5";
            }
            return "2,up5";
        }

        private void DealGstzMoney(string ballid, string gsid, string tzTeam, string gsCs, string tzMoney, string tzType)
        {
            if (gsCs != "0")
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                string sql = "SELECT COUNT(*) FROM changeleave WHERE ballid = '" + ballid + "' AND gsid = '" + gsid + "'";
                if (base2.ExecuteScalar(sql).ToString() != "0")
                {
                    sql = "";
                    if (tzTeam == "H")
                    {
                        sql = "UPDATE changeleave SET giveup1sum = giveup1sum + " + tzMoney + "*" + gsCs + "/100 WHERE ballid = '" + ballid + "' AND gsid = '" + gsid + "'";
                    }
                    else
                    {
                        sql = "UPDATE changeleave SET giveup2sum = giveup2sum + " + tzMoney + "*" + gsCs + "/100 WHERE ballid = '" + ballid + "' AND gsid = '" + gsid + "'";
                    }
                }
                else
                {
                    sql = "";
                    if (tzTeam == "H")
                    {
                        sql = "INSERT INTO changeleave (ballid,gsid,giveup1sum) VALUES ('" + ballid + "','" + gsid + "'," + tzMoney + "*" + gsCs + "/100)";
                    }
                    else
                    {
                        sql = "INSERT INTO changeleave (ballid,gsid,giveup2sum) VALUES ('" + ballid + "','" + gsid + "'," + tzMoney + "*" + gsCs + "/100)";
                    }
                }
                if (sql != "")
                {
                    base2.ExecuteNonQuery(sql);
                }
                base2.Dispose();
            }
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

        private string FinishTime(string orderid, string username, string tzmoney, string winmoney, string moneysort, string curmoney)
        {
            string[] textArray = orderid.Split(new char[] { ',' });
            SqlDataReader reader = null;
            string text4 = ("<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + " <TBODY><TR><TD vAlign=top height=22><IMG height=22 src=images/order_ph11.gif width=241></TD></TR>" + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩注单</TD></TR> ") + "<TR><TD vAlign=top height=30><IMG height=30   src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>";
            string text = (text4 + "<TBODY> <TR><TD>帐户名称: " + username + "</TD></TR><TR><TD>信用馀额:" + moneysort + "</TD></TR>") + " <tr><td><table width=190 cellSpacing=0 cellPadding=0 bgcolor=cccccc>";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            for (int i = 0; i < textArray.Length; i++)
            {
                string sql = "SELECT content,tzmoney,(tzmoney*curpl) as summoney FROM ball_order where orderid=" + textArray[i];
                reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    text = ((((text + " <TR><TD align=center>单号: " + textArray[i] + "</TD></TR>") + " <TR><TD align=center>" + reader["content"].ToString() + "</TD></TR>") + "<TR><TD colSpan=2 align=center><FONT color=#000000 size=2>下注金额: " + reader["tzmoney"].ToString() + "</FONT></TD></TR>") + " <TR><TD colSpan=2 align=center><FONT color=#000000 size=2>可蠃金额: <FONT id=pc color=#0000ff>" + Math.Round((double) (double.Parse(reader["summoney"].ToString()) + 0.1)).ToString() + "</FONT></FONT></TD></TR>") + " <TR><TD align=center  height=10><img src=images/2.gif></TD></TR>";
                }
                reader.Close();
            }
            base2.Dispose();
            text = ((text + "</table></td></tr>  <TR><TD align=middle colSpan=2><INPUT class=zabutton_01 onclick=self.location='betting-entry.aspx' type=button value=离开 name=FINISH> ") + " &nbsp;&nbsp; <INPUT class=zabutton_01 onclick=window.print() type=button value=列印 name=PRINT> </TD></TR></TBODY></TABLE></TD></TR>" + " <TR><TD vAlign=top height=11><IMG height=11  src=images/order_ph51.gif width=241></TD></TR>") + "<TR><TD vAlign=top align=middle><FONT  color=yellow></FONT>&nbsp;<BR></TD></TR></TBODY></TABLE>" + "<SCRIPT>alert('下注成功   -  请查阅您的  \"下注状况!\"  ');parent.body.location.reload();</SCRIPT>";
            this.Addons = " onLoad=\"TimeOut()\"";
            return text;
        }

        private string FinishTime(string orderid, string username, string content, string tzmoney, string winmoney, string moneysort, string curmoney, string type)
        {
            string text3 = ("<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + " <TBODY><TR><TD vAlign=top height=22><IMG height=22 src=images/order_ph11.gif width=241></TD></TR>" + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩注单</TD></TR> ") + "<TR><TD vAlign=top height=30><IMG height=30   src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>";
            string text = (((((((text3 + "<TBODY> <TR><TD>帐户名称: " + username + "</TD></TR><TR><TD>信用馀额:" + moneysort + "</TD></TR>") + " <TR><TD align=left><FONT color=#cc0000>下注完成 单号 --  " + orderid + "</FONT></TD></TR>") + " <TR><TD align=left>" + content + "</TD></TR>") + "<TR><TD colSpan=2><FONT color=#000000 size=2>下注金额: " + tzmoney + "</FONT></TD></TR>") + " <TR><TD colSpan=2><FONT color=#000000 size=2>可蠃金额: <FONT id=pc color=#0000ff>" + Math.Round((double) (double.Parse(winmoney) + 0.1)).ToString() + "</FONT></FONT></TD></TR>") + "  <TR><TD align=middle colSpan=2><INPUT class=zabutton_01 onclick=self.location='betting-entry.aspx' type=button value=离开 name=FINISH> ") + " &nbsp;&nbsp; <INPUT class=zabutton_01 onclick=window.print() type=button value=列印 name=PRINT> </TD></TR></TBODY></TABLE></TD></TR>" + " <TR><TD vAlign=top height=11><IMG height=11  src=images/order_ph51.gif width=241></TD></TR>") + "<TR><TD vAlign=top align=middle><FONT  color=yellow></FONT>&nbsp;<BR></TD></TR></TBODY></TABLE>" + "<SCRIPT>alert('下注成功   -  请查阅您的  \"下注状况!\"  ');</SCRIPT>";
            this.Addons = " onLoad=\"TimeOut()\"";
            return text;
        }

        private string[] GetChMsg(string ballid, string team, string zhushu, DataBase db)
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string[] textArray = new string[10];
            if (this.IsClose(ballid.ToString()))
            {
                return null;
            }
            sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id =" + ballid;
            SqlDataReader reader = db.ExecuteReader(sql);
            if (reader.Read())
            {
                textArray[0] = reader["id"].ToString().Trim();
                textArray[1] = (double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                textArray[2] = "H";
                textArray[3] = "H";
                text3 = reader["pltype"].ToString().Trim();
                text4 = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
            }
            reader.Close();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                textArray[8] = reader["kaisai"].ToString().Trim();
                text2 = "第" + reader["qishu"].ToString().Trim() + "期　<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + text4 + "</B></font><br>";
            }
            if (team.IndexOf("^") != -1)
            {
                string text5 = text2;
                text2 = text5 + "共" + zhushu + "注 <FONT  color=#ff0000>正号 " + team.Split(new char[] { '^' })[0] + "</FONT> " + team.Split(new char[] { '^' })[1];
            }
            else
            {
                string text6 = text2;
                text2 = text6 + "共" + zhushu + "注   " + team;
            }
            reader.Close();
            textArray[4] = text2.Replace("'", "");
            textArray[5] = "1";
            textArray[6] = "1";
            textArray[7] = "1";
            base2.Dispose();
            if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
            {
                return null;
            }
            return textArray;
        }

        private string[] GetDxMsg(string ballid, string team, DataBase db)
        {
            if (!this.IsClose(ballid.ToString()))
            {
                string sql = "SELECT v1.ballid,v1.matchname,v1.team1,v1.team2,v1.xenial,v1.bigsmall1,v1.bigsmall2,v1.bigpl,v1.smallpl,v1.homeway,v1.isshow,v1.sortdatetime,isnull((cl.bigsum-cl.smallsum)/cl.bsmoney*bspl,0) as bspl,isnull(cl.bsfixpl,0) as bsfixpl FROM Ball_Pl1View as v1 left join changeleave as cl On (v1.ballid = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.ballid=" + ballid;
                SqlDataReader reader = db.ExecuteReader(sql);
                string[] textArray = new string[7];
                if (reader.Read())
                {
                    string text2;
                    string text3;
                    string str;
                    string text7;
                    if (DateTime.Parse(reader["sortdatetime"].ToString().Trim()) < DateTime.Now)
                    {
                        return null;
                    }
                    string text4 = reader["xenial"].ToString().Trim();
                    if (team == "1")
                    {
                        text2 = "H";
                        text7 = reader["team1"].ToString().Trim();
                        str = reader["bigsmall1"].ToString().Trim();
                        text3 = MyFunc.GetPlType(reader["bigpl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["bspl"].ToString().Trim(), "H", reader["bsfixpl"].ToString().Trim()).ToString("F3");
                    }
                    else
                    {
                        text2 = "C";
                        text7 = reader["team2"].ToString().Trim();
                        str = reader["bigsmall2"].ToString().Trim();
                        text3 = MyFunc.GetPlType(reader["smallpl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["bspl"].ToString().Trim(), "C", reader["bsfixpl"].ToString().Trim()).ToString("F3");
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
            }
            return null;
        }

        private int GetMaxTz(string ballid, string type)
        {
            DataBase base2;
            string sql = "";
            int num = 0;
            switch (type)
            {
                case "14":
                case "1":
                    sql = "SELECT ISNULL(maxc1,0) FROM ball_bf WHERE ballid=" + ballid;
                    goto Label_00E2;

                case "15":
                case "2":
                    sql = "SELECT ISNULL(maxc2,0) FROM ball_bf WHERE ballid=" + ballid;
                    goto Label_00E2;

                case "3":
                    sql = "SELECT ISNULL(maxc3,0) FROM ball_bf WHERE ballid=" + ballid;
                    goto Label_00E2;

                case "4":
                    sql = "SELECT ISNULL(maxc4,0) FROM ball_bf WHERE ballid=" + ballid;
                    goto Label_00E2;

                case "12":
                    sql = "SELECT ISNULL(maxc5,0) FROM ball_bf WHERE ballid=" + ballid;
                    break;

                case "13":
                    sql = "SELECT ISNULL(maxc6,0) FROM ball_bf WHERE ballid=" + ballid;
                    break;
            }
        Label_00E2:
            base2 = new DataBase(MyFunc.GetConnStr(2));
            if (sql != "")
            {
                num = int.Parse(base2.ExecuteScalar(sql).ToString());
            }
            base2.Dispose();
            return num;
        }

        private string[] GetRqMsg(string ballid, string team, DataBase db)
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string[] textArray = new string[10];
            if (ballid != "0")
            {
                if (this.IsClose(ballid.ToString()))
                {
                    return null;
                }
                sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id =" + ballid;
                SqlDataReader reader = db.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[0] = reader["id"].ToString().Trim();
                    if (((int.Parse(ballid) > 0) && (int.Parse(ballid) < 11)) || ((int.Parse(ballid) > 0) && (int.Parse(ballid) < 11)))
                    {
                        textArray[1] = (double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                    }
                    else
                    {
                        textArray[1] = (double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                    }
                    textArray[2] = "H";
                    textArray[3] = "H";
                    text3 = reader["pltype"].ToString().Trim();
                    text4 = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                reader.Close();
                sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
                reader = db.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[8] = reader["kaisai"].ToString().Trim();
                    text2 = "　<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + text4 + "</B></font>";
                }
                reader.Close();
                textArray[4] = text2.Replace("'", "");
                textArray[5] = "1";
                textArray[6] = "1";
                textArray[7] = "1";
                reader.Close();
                if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
                {
                    return null;
                }
                return textArray;
            }
            if (this.IsClose(team.Split(new char[] { ',' })[0].ToString()))
            {
                return null;
            }
            sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            SqlDataReader reader2 = db.ExecuteReader(sql);
            if (reader2.Read())
            {
                textArray[8] = reader2["kaisai"].ToString().Trim();
                text2 = "第" + reader2["qishu"].ToString().Trim() + "期　";
            }
            reader2.Close();
            sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id in (" + team + ")";
            reader2 = db.ExecuteReader(sql);
            textArray[0] = team;
            while (reader2.Read())
            {
                if (((int.Parse(reader2["ballid"].ToString()) > 0) && (int.Parse(reader2["ballid"].ToString()) < 11)) || ((int.Parse(reader2["ballid"].ToString()) > 0) && (int.Parse(reader2["ballid"].ToString()) < 11)))
                {
                    textArray[1] = (double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader2["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                }
                else
                {
                    textArray[1] = (double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), reader2["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                }
                textArray[2] = "H";
                textArray[3] = "H";
                text3 = reader2["pltype"].ToString().Trim();
                string text5 = text2;
                text2 = text5 + "<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader2["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "</B></font><br>";
            }
            textArray[1] = textArray[1].Substring(0, textArray[1].Length - 1);
            textArray[4] = text2.Replace("'", "");
            textArray[5] = "1";
            textArray[6] = "1";
            textArray[7] = "1";
            reader2.Close();
            if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
            {
                return null;
            }
            return textArray;
        }

        private string[] GetZdRqMsg(string ballid, string team, DataBase db)
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            string s = "";
            string[] textArray = new string[10];
            string[] textArray2 = team.Split(new char[] { ',' });
            string[] textArray3 = MyFunc.twelveName.Split(new char[] { ',' });
            if (ballid != "0")
            {
                if (this.IsClose(ballid.ToString()))
                {
                    return null;
                }
                sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id =" + ballid;
                SqlDataReader reader = db.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[0] = reader["id"].ToString().Trim();
                    textArray[2] = "H";
                    textArray[3] = "H";
                    text3 = reader["pltype"].ToString().Trim();
                    if (reader["tztype"].ToString().Trim() == "8")
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    else if (((reader["tztype"].ToString().Trim() == "9") || (reader["tztype"].ToString().Trim() == "10")) || (((reader["tztype"].ToString().Trim() == "18") || (reader["tztype"].ToString().Trim() == "19")) || (reader["tztype"].ToString().Trim() == "20")))
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    else
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    textArray[1] = (double.Parse(s) - 1).ToString();
                }
                reader.Close();
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
                reader = base2.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[8] = reader["kaisai"].ToString().Trim();
                    if (textArray2.Length == 6)
                    {
                        string text5 = "";
                        for (int i = 0; i < 6; i++)
                        {
                            text5 = text5 + textArray3[int.Parse(textArray2[i].ToString())].ToString() + ",";
                        }
                        text5 = text5.Remove(text5.Length - 1, 1);
                        text2 = "第" + reader["qishu"].ToString().Trim() + "期　<FONT COLOR=#CC0000>" + text3 + "</font><br>" + text5 + "&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + s + "</B></font>";
                    }
                    else
                    {
                        text2 = "第" + reader["qishu"].ToString().Trim() + "期　<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + s + "</B></font>";
                    }
                }
                reader.Close();
                textArray[4] = text2.Replace("'", "");
                textArray[5] = "1";
                textArray[6] = "1";
                textArray[7] = "1";
                reader.Close();
                base2.Dispose();
                if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
                {
                    return null;
                }
                return textArray;
            }
            if (this.IsClose(team.Split(new char[] { ',' })[0].ToString()))
            {
                return null;
            }
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            SqlDataReader reader2 = base3.ExecuteReader(sql);
            if (reader2.Read())
            {
                textArray[8] = reader2["kaisai"].ToString().Trim();
                text2 = "第" + reader2["qishu"].ToString().Trim() + "期　";
            }
            reader2.Close();
            sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id in (" + team + ")";
            reader2 = db.ExecuteReader(sql);
            textArray[0] = team;
            double num3 = 1;
            while (reader2.Read())
            {
                textArray[2] = "H";
                textArray[3] = "H";
                text3 = reader2["pltype"].ToString().Trim();
                num3 *= double.Parse(reader2["pl"].ToString().Trim());
                string text6 = text2;
                text2 = text6 + "<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), "0", reader2["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "</B></font><br>";
            }
            textArray[1] = (num3 - 1).ToString();
            textArray[4] = text2.Replace("'", "");
            textArray[5] = "1";
            textArray[6] = "1";
            textArray[7] = "1";
            reader2.Close();
            base3.Dispose();
            if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
            {
                return null;
            }
            return textArray;
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private bool IsClose(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT top 1 qishu,tupdatetime,kaisai,tmclose,zmclose FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            int num = int.Parse(ballid);
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (!reader.Read())
            {
                return true;
            }
            if ((((num > 0) && (num < 7)) || ((num > 0x22) && (num < 0x54))) || (((num > 0xc7) && (num < 0xd7)) || ((num > 0xe5) && (num < 0xf4))))
            {
                if (reader["tmclose"].ToString() != "0")
                {
                    return true;
                }
                TimeSpan span = Convert.ToDateTime(reader["tupdatetime"].ToString()).Subtract(DateTime.Now);
                int num2 = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
                if (num2 < 1)
                {
                    return true;
                }
            }
            else if (reader["zmclose"].ToString() == "0")
            {
                TimeSpan span2 = Convert.ToDateTime(reader["kaisai"].ToString()).Subtract(DateTime.Now);
                int num3 = (((span2.Days * 0x15180) + (span2.Hours * 0xe10)) + (span2.Minutes * 60)) + span2.Seconds;
                if (num3 < 1)
                {
                    return true;
                }
            }
            else
            {
                return true;
            }
            reader.Close();
            base2.Dispose();
            return false;
        }

        private string MatchList(string type)
        {
            string text = "";
            string sql = "";
            if (type == "7")
            {
                sql = "SELECT ballid FROM Ball_Pl6View";
            }
            if (type == "8")
            {
                sql = "SELECT ballid FROM ball_pl7View";
            }
            if (type == "16")
            {
                sql = "SELECT ballid FROM ball_pl4View";
            }
            if (type == "17")
            {
                sql = "SELECT ballid FROM ball_pl2view";
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
            switch (team)
            {
                case "7":
                case "9":
                case "11":
                case "16":
                case "17":
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
            else
            {
                int num = 100;
                int num2 = 0;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    TimeSpan span = Convert.ToDateTime(reader["kaisai"].ToString().Trim()).Subtract(DateTime.Now);
                    num = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
                    num2 = int.Parse(reader["isclose"].ToString());
                }
                reader.Close();
                base2.Dispose();
                if (((base.Request.Form["action"] == null) || (base.Request.Form["action"].ToString().Trim() == "")) && (base.Request.QueryString["action"] == null))
                {
                    string[] textArray;
                    string tzType = "";
                    string text5 = "";
                    string team = "";
                    string pmsg = "";
                    if ((base.Request.QueryString["m"] != null) && (base.Request.QueryString["m"].ToString().Trim() != ""))
                    {
                        textArray = base.Request.QueryString["m"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
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
                        if ((int.Parse(textArray[2]) < 1) && (int.Parse(textArray[2]) > 0x15))
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                            return;
                        }
                        tzType = textArray[2];
                        text5 = textArray[0].Trim();
                        team = textArray[1];
                        pmsg = "m=" + base.Request.QueryString["m"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                    }
                    else if ((base.Request.QueryString["1x2"] != null) && (base.Request.QueryString["1x2"].ToString().Trim() != ""))
                    {
                        textArray = base.Request.QueryString["1x2"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
                        if (textArray.Length != 2)
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                            return;
                        }
                        tzType = "1X2";
                        text5 = textArray[0].Trim();
                        team = textArray[1];
                        pmsg = "1x2=" + base.Request.QueryString["1x2"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                    }
                    else if ((base.Request.QueryString["cs"] != null) && (base.Request.QueryString["cs"].ToString().Trim() != ""))
                    {
                        textArray = base.Request.QueryString["cs"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
                        if (textArray.Length != 3)
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                            return;
                        }
                        tzType = "CS";
                        text5 = textArray[0].Trim();
                        team = this.CsContent(textArray[1], textArray[2]);
                        pmsg = "cs=" + base.Request.QueryString["cs"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                    }
                    else if ((base.Request.QueryString["tg"] != null) && (base.Request.QueryString["tg"].ToString().Trim() != ""))
                    {
                        textArray = base.Request.QueryString["tg"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
                        if (textArray.Length != 2)
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                            return;
                        }
                        tzType = "TG";
                        text5 = textArray[0].Trim();
                        team = textArray[1].Trim();
                        pmsg = "tg=" + base.Request.QueryString["tg"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                    }
                    else if ((base.Request.QueryString["ht"] != null) && (base.Request.QueryString["ht"].ToString().Trim() != ""))
                    {
                        textArray = base.Request.QueryString["ht"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "").Split(new char[] { ',' });
                        if (textArray.Length != 2)
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                            return;
                        }
                        tzType = "HT";
                        text5 = textArray[0].Trim();
                        team = textArray[1].ToUpper().Replace("H", "H").Replace("A", "C").Replace("D", "N");
                        pmsg = "ht=" + base.Request.QueryString["ht"].ToString().Trim().Replace(" ", "").Replace("%", "").Replace("'", "");
                    }
                    string type = MyFunc.GettzType(tzType);
                    string ballid = text5;
                    if (ballid != "")
                    {
                        DataBase db = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base4 = new DataBase(MyFunc.GetConnStr(2));
                        string[] ball = this.BallMsg(ballid, db);
                        if (ball == null)
                        {
                            this.kyglContent = this.CloseTime();
                            this.DataBind();
                        }
                        else if (num2 == 1)
                        {
                            this.kyglContent = this.CloseTime("对不起,已封盘!");
                            this.DataBind();
                        }
                        else
                        {
                            string[] user = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base4, type);
                            db.Dispose();
                            base4.Dispose();
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
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "even"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text10 = base.Request.Form["ballid"].ToString().Trim();
                        string msg = "";
                        string money = "";
                        string text15 = "H";
                        string[] textArray4 = null;
                        string[] textArray5 = null;
                        string[] textArray6 = null;
                        int index = 0;
                        string cstype = base.Request.Form["curpl"].ToString().Trim();
                        DataBase base5 = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base6 = new DataBase(MyFunc.GetConnStr(2));
                        textArray6 = text10.Split(new char[] { ',' });
                        for (index = 0; index < textArray6.Length; index++)
                        {
                            string text11 = "dsdx" + textArray6[index].ToString().Trim();
                            money = money + base.Request.Form[text11].ToString().Trim() + ",";
                            textArray4 = this.BallMsg(textArray6[index], base5);
                            if (textArray4 == null)
                            {
                                this.kyglContent = this.CloseTime("对不起,已封盘!");
                                this.DataBind();
                                return;
                            }
                            textArray5 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base6, textArray4[1]);
                            if (base.Request.Form[text11].Trim() != "")
                            {
                                if (int.Parse(base.Request.Form[text11].Trim()) < int.Parse(this.MinBet))
                                {
                                    string text70 = msg;
                                    msg = text70 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray4[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[text11].Trim() + " < 最低限额" + this.MinBet + "</font><br>";
                                }
                                else if (int.Parse(base.Request.Form[text11].Trim()) > int.Parse(textArray5[8]))
                                {
                                    string text71 = msg;
                                    msg = text71 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray4[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[text11].Trim() + " > 单注限额" + textArray5[8] + "</font><br>";
                                }
                                else if (int.Parse(base.Request.Form[text11].Trim()) > int.Parse(textArray5[7]))
                                {
                                    string text72 = msg;
                                    msg = text72 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray4[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[text11].Trim() + " > 单期(号)限额" + textArray5[7] + "</font><br>";
                                }
                            }
                        }
                        base5.Dispose();
                        base6.Dispose();
                        if (msg != "")
                        {
                            this.kyglContent = this.CloseTime(msg);
                            this.DataBind();
                        }
                        else
                        {
                            money = money.Substring(0, money.Length - 1);
                            this.kyglContent = this.saveOrder(text10, text15, money, cstype);
                            this.DataBind();
                        }
                    }
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "quickForm"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text17 = base.Request.Form["wagerstext"].ToString().Trim();
                        string text18 = "";
                        string text19 = "";
                        string text20 = base.Request.Form["rtype"].ToString().Trim();
                        string text23 = "H";
                        string text24 = "";
                        text17 = text17.Replace(":", "+");
                        string[] textArray7 = text17.Substring(0, text17.Length - 1).Split(new char[] { '-' });
                        string[] textArray8 = null;
                        for (int i = 0; i < textArray7.Length; i++)
                        {
                            textArray8 = textArray7[i].Split(new char[] { '+' });
                            text19 = text19 + MyFunc.GettzId(textArray8[0], text20) + ",";
                            text24 = text24 + textArray8[1] + ",";
                            text18 = text18 + textArray8[2] + ",";
                        }
                        text19 = text19.Substring(0, text19.Length - 1);
                        text24 = text24.Substring(0, text24.Length - 1);
                        text18 = text18.Substring(0, text18.Length - 1);
                        this.kyglContent = this.saveOrder(text19, text23, text18, text24);
                        this.DataBind();
                    }
                }
                else if ((((base.Request.QueryString["req_matchlist"] != null) && (base.Request.QueryString["req_matchlist"].ToString().Trim() != "")) && ((base.Request.QueryString["req_userbet_list"] != null) && (base.Request.QueryString["req_userbet_list"].ToString().Trim() != ""))) && ((base.Request.QueryString["remove"] != null) && (base.Request.QueryString["remove"].ToString().Trim() != "")))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text25 = "8";
                        string mlist = base.Request.QueryString["req_matchlist"].ToString().Trim();
                        string betlist = base.Request.QueryString["req_userbet_list"].ToString().Trim();
                        DataBase base7 = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base8 = new DataBase(MyFunc.GetConnStr(2));
                        string[] textArray9 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base8, text25);
                        string[] textArray10 = this.BallMsg("158", base7);
                        base8.Dispose();
                        string[] textArray11 = mlist.Split(new char[] { ',' });
                        if (textArray11.Length < 2)
                        {
                            this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                            this.DataBind();
                        }
                        else
                        {
                            string[] textArray12 = betlist.Split(new char[] { ',' });
                            mlist = "";
                            betlist = "";
                            for (int j = 0; j < textArray11.Length; j++)
                            {
                                if (base.Request.QueryString["remove"].ToString().Trim() != textArray11[j])
                                {
                                    mlist = mlist + textArray11[j] + ",";
                                    betlist = betlist + textArray12[j] + ",";
                                }
                            }
                            if (mlist != "")
                            {
                                mlist = mlist.Remove(mlist.Length - 1, 1);
                            }
                            else
                            {
                                this.kyglContent = this.PeaceTime();
                                this.DataBind();
                                return;
                            }
                            if (betlist != "")
                            {
                                betlist = betlist.Remove(betlist.Length - 1, 1);
                            }
                            else
                            {
                                this.kyglContent = this.PeaceTime();
                                this.DataBind();
                                return;
                            }
                            if (mlist.Split(new char[] { ',' }).Length < 2)
                            {
                                this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                                this.DataBind();
                            }
                            else
                            {
                                base7.Dispose();
                                base8.Dispose();
                                this.kyglContent = this.TzTime(textArray9, textArray10, mlist, betlist);
                                this.DataBind();
                            }
                        }
                    }
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "nap"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string[] textArray13;
                        string text28 = "";
                        string text30 = "";
                        string text31 = "16";
                        DataBase base9 = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base10 = new DataBase(MyFunc.GetConnStr(2));
                        for (int k = 0; k < 0x12; k++)
                        {
                            if ((base.Request.Form["game" + k] != null) && (base.Request.Form["game" + k].ToString().Trim() != ""))
                            {
                                string text29 = base.Request.Form["game" + k];
                                text28 = text28 + text29 + ",";
                                textArray13 = this.BallMsg(text29, base9);
                                text30 = text30 + textArray13[2] + ",";
                            }
                        }
                        if ((text28 != "") && (text30 != ""))
                        {
                            text28 = text28.Remove(text28.Length - 1, 1);
                            text30 = text30.Remove(text30.Length - 1, 1);
                        }
                        else
                        {
                            this.kyglContent = this.CloseTime("请选择过关的球赛");
                            this.DataBind();
                            return;
                        }
                        if (text28.Split(new char[] { ',' }).Length < 2)
                        {
                            this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                            this.DataBind();
                        }
                        else if (text28.Split(new char[] { ',' }).Length > 10)
                        {
                            this.kyglContent = this.CloseTime("对不起,过关最多选十场球赛");
                            this.DataBind();
                        }
                        else
                        {
                            string[] textArray14 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base10, text31);
                            textArray13 = this.BallMsg("158", base9);
                            base9.Dispose();
                            base10.Dispose();
                            this.kyglContent = this.TzTime(textArray14, textArray13, text28, text30);
                            this.DataBind();
                        }
                    }
                }
                else if ((base.Request.Form["tztype"] != null) && (base.Request.Form["action"].ToString().Trim() == "saveall"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text32 = base.Request.Form["ballid"].ToString().Trim();
                        string s = base.Request.Form["gold"].ToString().Trim();
                        string text34 = base.Request.Form["tztype"].ToString().Trim();
                        string text35 = "H";
                        string text36 = base.Request.Form["curpl"].ToString().Trim();
                        try
                        {
                            double num7 = Math.Abs(double.Parse(s));
                        }
                        catch
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                        }
                        this.kyglContent = this.saveOrder(text34, text32, text35, s, text36);
                        this.DataBind();
                    }
                }
                else if (((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() != "")) && (base.Request.Form["action"] == "MultiTema"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text37 = base.Request.Form["ballid"].ToString().Trim() + "," + base.Request.Form["ballid1"].ToString().Trim();
                        string text38 = "";
                        string text40 = "";
                        string text41 = "H";
                        string text42 = base.Request.Form["curpl"].ToString().Trim() + "," + base.Request.Form["curpl1"].ToString().Trim();
                        string[] textArray15 = null;
                        string[] textArray16 = null;
                        string[] textArray17 = null;
                        DataBase base11 = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base12 = new DataBase(MyFunc.GetConnStr(2));
                        try
                        {
                            textArray17 = text37.Split(new char[] { ',' });
                            for (int m = 0; m < textArray17.Length; m++)
                            {
                                text38 = text38 + base.Request.Form[textArray17[m]].ToString().Trim() + ",";
                                textArray15 = this.BallMsg(textArray17[m], base11);
                                textArray16 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base12, textArray15[1]);
                                if (base.Request.Form[textArray17[m]].Trim() != "")
                                {
                                    if (int.Parse(base.Request.Form[textArray17[m]].Trim()) < int.Parse(this.MinBet))
                                    {
                                        string text73 = text40;
                                        text40 = text73 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray15[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[textArray17[m]].Trim() + " < 最低限额" + this.MinBet + "</font><br>";
                                    }
                                    else if (int.Parse(base.Request.Form[textArray17[m]].Trim()) > int.Parse(textArray16[8]))
                                    {
                                        string text74 = text40;
                                        text40 = text74 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray15[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[textArray17[m]].Trim() + " > 单注限额" + textArray16[8] + "</font><br>";
                                    }
                                    else if (int.Parse(base.Request.Form[textArray17[m]].Trim()) > int.Parse(textArray16[7]))
                                    {
                                        string text75 = text40;
                                        text40 = text75 + "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ff0000\">" + textArray15[3] + "</font><FONT style=\" FONT-SIZE: 12px; COLOR: #ff0000\">下注金额" + base.Request.Form[textArray17[m]].Trim() + " > 单期(号)限额" + textArray16[7] + "</font><br>";
                                    }
                                }
                            }
                        }
                        catch
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                        }
                        if (text40 != "")
                        {
                            this.kyglContent = this.CloseTime(text40);
                            this.DataBind();
                        }
                        else
                        {
                            base11.Dispose();
                            base12.Dispose();
                            text38 = text38.Substring(0, text38.Length - 1);
                            this.kyglContent = this.saveOrder(text37, text41, text38, text42);
                            this.DataBind();
                        }
                    }
                }
                else if ((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() != "")) && ((base.Request.Form["req_matchlist"] != null) && (base.Request.Form["req_matchlist"].ToString().Trim() != ""))) && ((base.Request.Form["req_userbet_list"] != null) && (base.Request.Form["req_userbet_list"].ToString().Trim() != "")))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text43 = base.Request.Form["fr_betamount"].ToString().Trim();
                        string text44 = base.Request.Form["fr_bettype"].ToString().Trim();
                        string text45 = base.Request.Form["req_matchlist"].ToString().Trim();
                        if (text45.Split(new char[] { ',' }).Length < 2)
                        {
                            this.kyglContent = this.CloseTime("对不起,过关最少选两场球赛");
                            this.DataBind();
                        }
                        else if (text45.Split(new char[] { ',' }).Length > 10)
                        {
                            this.kyglContent = this.CloseTime("对不起,过关最多选十场球赛");
                            this.DataBind();
                        }
                        else
                        {
                            string text46 = base.Request.Form["req_userbet_list"].ToString().Trim();
                            try
                            {
                                double num9 = Math.Abs(double.Parse(text43));
                            }
                            catch
                            {
                                this.kyglContent = this.PeaceTime();
                                this.DataBind();
                            }
                            this.kyglContent = this.saveOrder(text45, text43, text46);
                            this.DataBind();
                        }
                    }
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ch"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text48="";
                        string text49="";
                        string text47 = base.Request.Form["rtype"].ToString().Trim();
                        string[] textArray18 = base.Request.Form["num[]"].ToString().Trim().Split(new char[] { ',' });
                        string text51 = "";
                        try
                        {
                            text51 = base.Request.Form["RS"].ToString().Trim();
                            text51 = base.Request.Form["rs_r"].ToString().Trim();
                            text49 = "";
                            for (int n = 0; n < textArray18.Length; n++)
                            {
                                if (textArray18[n].ToString().Trim() != text51)
                                {
                                    text49 = text49 + textArray18[n] + ",";
                                }
                            }
                            text49 = text49.Substring(0, text49.Length - 1);
                            if ((text47 == "151") || (text47 == "152"))
                            {
                                text48 = (((textArray18.Length - 1) * (textArray18.Length - 2)) / 2).ToString();
                            }
                            else
                            {
                                text48 = (textArray18.Length - 1).ToString();
                            }
                        }
                        catch
                        {
                            if ((text47 == "151") || (text47 == "152"))
                            {
                                text48 = (((textArray18.Length * (textArray18.Length - 1)) * (textArray18.Length - 2)) / 6).ToString();
                            }
                            else
                            {
                                text48 = ((textArray18.Length * (textArray18.Length - 1)) / 2).ToString();
                            }
                        }
                        DataBase base13 = new DataBase(MyFunc.GetConnStr(1));
                        DataBase base14 = new DataBase(MyFunc.GetConnStr(2));
                        string[] textArray19 = this.BallMsg(text47, base13);
                        string[] textArray20 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base14, textArray19[1]);
                        base13.Dispose();
                        base14.Dispose();
                        this.kyglContent = this.TzTimeCh(text48, textArray20, textArray19, text49, text51);
                        this.DataBind();
                    }
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "savech"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text52 = base.Request.Form["ballid"].ToString().Trim();
                        string text53 = base.Request.Form["gold"].ToString().Trim();
                        string text54 = base.Request.Form["tztype"].ToString().Trim();
                        string text55 = base.Request.Form["tzteam"].ToString().Trim();
                        string text56 = base.Request.Form["tzteam1"].ToString().Trim();
                        string zhushu = base.Request.Form["zhushu"].ToString().Trim();
                        string text58 = base.Request.Form["curpl"].ToString().Trim();
                        try
                        {
                            double num11 = Math.Abs(double.Parse(text53));
                        }
                        catch
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                        }
                        this.kyglContent = this.saveOrderCh(text54, text52, text55, text53, text58, text56, zhushu);
                        this.DataBind();
                    }
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "sx"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text59 = "20";
                        string text60 = base.Request.Form["rtype"].ToString().Trim();
                        string text61 = base.Request.Form["lt_sx[]"].ToString().Trim();
                        string text62 = "";
                        string text63 = MyFunc.GettzType(text59);
                        string text64 = text60;
                        if (text64 != "")
                        {
                            DataBase base15 = new DataBase(MyFunc.GetConnStr(1));
                            DataBase base16 = new DataBase(MyFunc.GetConnStr(2));
                            string[] textArray22 = this.BallMsg(text64, base15);
                            if (textArray22 == null)
                            {
                                this.kyglContent = this.CloseTime();
                                this.DataBind();
                            }
                            else
                            {
                                string[] textArray23 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base16, text63);
                                base15.Dispose();
                                base16.Dispose();
                                this.kyglContent = this.TzTimeSx(text63, textArray23, textArray22, text61, text62);
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
                }
                else if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "savesx"))
                {
                    if (num2 == 1)
                    {
                        this.kyglContent = this.CloseTime("对不起,已封盘!");
                        this.DataBind();
                    }
                    else
                    {
                        string text65 = base.Request.Form["ballid"].ToString().Trim();
                        string text66 = base.Request.Form["gold"].ToString().Trim();
                        string text67 = "20";
                        string text68 = base.Request.Form["tzteam"].ToString().Trim();
                        string text69 = base.Request.Form["curpl"].ToString().Trim();
                        try
                        {
                            double num12 = Math.Abs(double.Parse(text66));
                        }
                        catch
                        {
                            this.kyglContent = this.PeaceTime();
                            this.DataBind();
                        }
                        this.kyglContent = this.saveOrder(text67, text65, text68, text66, text69);
                        this.DataBind();
                    }
                }
                else
                {
                    this.kyglContent = this.PeaceTime();
                    this.DataBind();
                }
            }
        }

        private string PeaceTime()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT username,usemoney,curmoney,moneysort FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            if (reader.Read())
            {
                string text3 = (("<table height=100% border=0 cellpadding=0 cellspacing=0 background=images/order_bk.gif>" + "<tr><td height=22 valign=top><img src=images/order_ph11.gif width=241 height=22></td></tr>" + "<tr><td height=36 background=images/order_ph21.jpg class=m-title>请确认您的帐户</td></tr>") + " <tr><td height=30 valign=top><img src=images/order_ph31.gif width=241 height=30></td></tr>" + "<tr><td height=100 valign=top background=images/order_ph41.gif><table width=190 border=0 align=center cellpadding=0 cellspacing=0>") + "<tr>   <td>帐户名称: (" + reader["username"].ToString().Trim() + ")</td></tr>";
                string text4 = text3 + " <tr> <td>信用余额: " + reader["moneysort"].ToString().Trim() + " " + reader["curmoney"].ToString().Trim() + "</td></tr>";
                text = ((text4 + "<tr> <td>信用额度: " + reader["moneysort"].ToString().Trim() + " " + reader["usemoney"].ToString().Trim() + "</td></tr>") + " <tr> <td><font color=Red >请选择下注彩球</font></td></tr></table></td></tr>" + " <tr><td height=11 valign=top><img src=images/order_ph51.gif width=241 height=11></td></tr>") + " <tr><td valign=top align=center><font color=yellow></font>&nbsp;<br></td></tr>" + "  <tr> <td height=10 valign=top>&nbsp;</td></tr>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT top 1 * FROM ball_bf1 where num1<>''  ORDER BY balltime DESC");
                if (reader.Read())
                {
                    DateTime time = Convert.ToDateTime(reader["balltime"].ToString().Trim());
                    TimeSpan span = DateTime.Now.Subtract(time);
                    int num = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                    this.bettype = "betType = '';";
                    if (num < 360)
                    {
                        string text5 = text + " <tr><td align=center><table width=210 border=0 cellpadding=0 cellspacing=2><tr><td colspan=5>期数: " + reader["qishu"].ToString().Trim() + " 开奖结果</td><td colspan=2 align=right><a href=javascript:location.reload();>更新</a></td> </tr>";
                        string text6 = text5 + " <tr><td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num1"].ToString().Trim()) + ">" + reader["num1"].ToString().Trim() + "</td> ";
                        string text7 = text6 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num2"].ToString().Trim()) + ">" + reader["num2"].ToString().Trim() + "</td>";
                        string text8 = text7 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num3"].ToString().Trim()) + ">" + reader["num3"].ToString().Trim() + "</td>";
                        string text9 = text8 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num4"].ToString().Trim()) + ">" + reader["num4"].ToString().Trim() + "</td>";
                        string text10 = text9 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num5"].ToString().Trim()) + ">" + reader["num5"].ToString().Trim() + "</td>";
                        string text11 = text10 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["num6"].ToString().Trim()) + ">" + reader["num6"].ToString().Trim() + "</td>";
                        text = text11 + " <td width=25 height=28 align=center class=ball_td style=background-repeat:no-repeat; background=" + MyFunc.GetRGB(reader["tema"].ToString().Trim()) + ">" + reader["tema"].ToString().Trim() + "</td></tr></table></td></tr>";
                        if (reader["tema"].ToString().Trim() == "")
                        {
                            this.bettype = "betType = 'running';";
                        }
                        else
                        {
                            this.bettype = "betType = '';";
                        }
                    }
                }
                reader.Close();
                base2.Dispose();
                text = text + " </table>";
                this.Addons = " onLoad=\"TimeOut()\"";
                reader.Close();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private string rqcontent(string str)
        {
            string rqMarker = "";
            rqMarker = str.Replace(" ", "");
            if (rqMarker.IndexOf("/") < 0)
            {
                return MyFunc.turnNum(rqMarker);
            }
            return (MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[0]) + "/" + MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[1]));
        }

        private string rqnum(string str)
        {
            string rqMarker = "";
            rqMarker = str.Replace(" ", "");
            if (rqMarker.IndexOf("/") < 0)
            {
                return MyFunc.turnNum(rqMarker);
            }
            double num = (double.Parse(MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[0])) + double.Parse(MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[1]))) / 2;
            return num.ToString();
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

        private string saveOrder(string team, string money, string cstype)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return "";
            }
            string[] textArray = null;
            string text = "";
            string orderid = "";
            string text3 = text;
            string text4 = "FALSE";
            string s = "";
            string sql = "";
            string text9 = "";
            double num = 0;
            double num2 = 0;
            string text10 = "";
            string text13 = "0";
            string username = "";
            string text15 = "";
            string text16 = "0";
            string moneysort = "";
            string text18 = "1";
            string text19 = "0";
            string text20 = "";
            string text21 = "0";
            string text22 = "";
            string text23 = "0";
            string text24 = "0";
            string text25 = "0";
            string text26 = "0";
            string text27 = "0";
            string text28 = "0";
            string text29 = "0";
            string text30 = "0";
            string text31 = "0";
            string text32 = "0";
            string text33 = "0";
            string text34 = "0";
            string text35 = "0";
            string text36 = "0";
            string text37 = "0";
            string text38 = "0";
            string text39 = "";
            string[] textArray2 = cstype.Split(new char[] { ',' });
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            text = this.NewOrderid(MyFunc.TimeStampe());
            orderid = orderid + text + ",";
            string type = "16";
            string text5 = this.userSql(type);
            text39 = "SELECT member.userid,member.userpass,member.username,member.usemoney,member.gdid,member.zdlid,member.dlsid,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,member.isuseable,agence.bl,agence.gdbl,agence.zdlbl" + text5 + " FROM hs RIGHT OUTER JOIN userhs RIGHT OUTER JOIN member ON userhs.userid = member.userid LEFT OUTER JOIN agence ON member.dlsid = agence.userid ON hs.type = member.ABC AND hs.userid = member.dlsid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
            SqlDataReader reader = base3.ExecuteReader(text39);
            if (reader.Read())
            {
                text13 = reader["userid"].ToString().Trim();
                username = reader["username"].ToString().Trim();
                text15 = reader["userpass"].ToString().Trim();
                text16 = reader["usemoney"].ToString().Trim();
                moneysort = reader["moneysort"].ToString().Trim();
                text18 = reader["moneyrate"].ToString().Trim();
                text19 = reader["curmoney"].ToString().Trim();
                text20 = reader["abc"].ToString().Trim();
                text21 = reader["isuseable"].ToString().Trim();
                text22 = base.Request.UserHostAddress.Trim();
                text23 = reader["gdid"].ToString().Trim();
                text24 = reader["zdlid"].ToString().Trim();
                text25 = reader["dlsid"].ToString().Trim();
                text34 = (double.Parse(reader["gdbl"].ToString().Trim()) / 100).ToString();
                text35 = (double.Parse(reader["zdlbl"].ToString().Trim()) / 100).ToString();
                text36 = (double.Parse(reader["bl"].ToString().Trim()) / 100).ToString();
                text32 = reader[15].ToString().Trim();
                text33 = reader[0x10].ToString().Trim();
                text26 = reader[0x11].ToString().Trim();
                text27 = reader[0x12].ToString().Trim();
                text30 = reader[0x13].ToString().Trim();
                text31 = reader[20].ToString().Trim();
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
            if (text15 != this.Session.Contents["userpass"].ToString().Trim())
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
            if (double.Parse(money) > double.Parse(text19))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于信用余额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            if (double.Parse(money) > double.Parse(text27))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于单注限额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            text39 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text20.ToUpper() + "' AND userid=" + text24;
            SqlDataReader reader2 = base3.ExecuteReader(text39);
            if (reader2.Read())
            {
                text28 = reader2[1].ToString().Trim();
                text29 = reader2[2].ToString().Trim();
            }
            else
            {
                text28 = "0";
                text29 = "0";
            }
            reader2.Close();
            text39 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text20.ToUpper() + "' AND userid=" + text23;
            reader2 = base3.ExecuteReader(text39);
            if (reader2.Read())
            {
                text37 = reader2[1].ToString().Trim();
                text38 = reader2[2].ToString().Trim();
            }
            else
            {
                text37 = "0";
                text38 = "0";
            }
            reader2.Close();
            string text11 = Math.Abs(double.Parse(money)).ToString();
            num += double.Parse(text11);
            textArray = this.GetZdRqMsg("0", team, db);
            if (textArray == null)
            {
                return this.CloseTime("对不起,球赛已关闭");
            }
            text4 = (textArray != null) ? textArray[6] : "FALSE";
            s = textArray[1];
            if (double.Parse(s) == 0)
            {
                return this.CloseTime();
            }
            sql = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,zdbf,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc,isdanger,zdmoney)VALUES(" + text + ",'0'," + type + "," + text11 + "," + textArray[1] + ",'" + team + "','1','1','1','" + textArray[4] + "'," + text13 + ",'" + username + "'," + text23 + "," + text24 + "," + text25 + "," + text28 + "," + text30 + "," + text32 + "," + text29 + "," + text31 + "," + text33 + "," + text37 + "," + text38 + "," + text34 + "," + text35 + "," + text36 + ",'" + text22 + "',GetDate()," + text18 + ",'" + textArray[8] + "','" + text20 + "',0," + text11 + ");";
            text9 = text9 + textArray[4];
            text10 = textArray[1];
            num2 += double.Parse(text10) * double.Parse(text11);
            if (base3.ExecuteNonQuery(sql) > 0)
            {
                base3.ExecuteNonQuery("UPDATE member SET curmoney=curmoney-" + text11 + ",xzcount=xzcount+1,xztotal=xztotal+" + money + " WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            }
            db.Dispose();
            base3.Dispose();
            orderid = orderid.Substring(0, orderid.Length - 1);
            double num7 = num - num2;
            return this.FinishTime(orderid, username, num.ToString(), num2.ToString(), moneysort, num7.ToString());
        }

        private string saveOrder(string ballid, string team, string money, string cstype)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return "";
            }
            string[] textArray = null;
            string text = "";
            string orderid = "";
            string text3 = text;
            string text4 = "FALSE";
            string s = "";
            string sql = "";
            string text9 = "";
            double num = 0;
            double num2 = 0;
            string text10 = "";
            string text13 = "0";
            string username = "";
            string text15 = "";
            string text16 = "0";
            string moneysort = "";
            string text18 = "1";
            string text19 = "0";
            string text20 = "";
            string text21 = "0";
            string text22 = "";
            string text23 = "0";
            string text24 = "0";
            string text25 = "0";
            string text26 = "0";
            string text27 = "0";
            string text28 = "0";
            string text29 = "0";
            string text30 = "0";
            string text31 = "0";
            string text32 = "0";
            string text33 = "0";
            string text34 = "0";
            string text35 = "0";
            string text36 = "0";
            string text37 = "0";
            string text38 = "0";
            string text39 = "";
            string[] textArray2 = money.Split(new char[] { ',' });
            string[] textArray3 = cstype.Split(new char[] { ',' });
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            string[] textArray4 = ballid.Split(new char[] { ',' });
            if (this.BallMsg(textArray4[0].ToString(), db) == null)
            {
                this.kyglContent = this.CloseTime();
                this.DataBind();
                return this.kyglContent;
            }
            for (int i = 0; i < textArray4.Length; i++)
            {
                ballid = textArray4[i];
                money = textArray2[i];
                cstype = textArray3[i];
                if ((money != "") && (money != null))
                {
                    text = (long.Parse(this.NewOrderid(MyFunc.TimeStampe())) + long.Parse(ballid)).ToString();
                    orderid = orderid + text + ",";
                    string type = MyFunc.GettzType(int.Parse(ballid));
                    string text5 = this.userSql(type);
                    text39 = "SELECT member.userid,member.userpass,member.username,member.usemoney,member.gdid,member.zdlid,member.dlsid,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,member.isuseable,agence.bl,agence.gdbl,agence.zdlbl" + text5 + " FROM hs RIGHT OUTER JOIN userhs RIGHT OUTER JOIN member ON userhs.userid = member.userid LEFT OUTER JOIN agence ON member.dlsid = agence.userid ON hs.type = member.ABC AND hs.userid = member.dlsid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
                    SqlDataReader reader = base3.ExecuteReader(text39);
                    if (reader.Read())
                    {
                        text13 = reader["userid"].ToString().Trim();
                        username = reader["username"].ToString().Trim();
                        text15 = reader["userpass"].ToString().Trim();
                        text16 = reader["usemoney"].ToString().Trim();
                        moneysort = reader["moneysort"].ToString().Trim();
                        text18 = reader["moneyrate"].ToString().Trim();
                        text19 = reader["curmoney"].ToString().Trim();
                        text20 = reader["abc"].ToString().Trim();
                        text21 = reader["isuseable"].ToString().Trim();
                        text22 = base.Request.UserHostAddress.Trim();
                        text23 = reader["gdid"].ToString().Trim();
                        text24 = reader["zdlid"].ToString().Trim();
                        text25 = reader["dlsid"].ToString().Trim();
                        text34 = (double.Parse(reader["gdbl"].ToString().Trim()) / 100).ToString();
                        text35 = (double.Parse(reader["zdlbl"].ToString().Trim()) / 100).ToString();
                        text36 = (double.Parse(reader["bl"].ToString().Trim()) / 100).ToString();
                        text32 = reader[15].ToString().Trim();
                        text33 = reader[0x10].ToString().Trim();
                        text26 = reader[0x11].ToString().Trim();
                        text27 = reader[0x12].ToString().Trim();
                        text30 = reader[0x13].ToString().Trim();
                        text31 = reader[20].ToString().Trim();
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
                    if (text15 != this.Session.Contents["userpass"].ToString().Trim())
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
                    if (double.Parse(money) > double.Parse(text19))
                    {
                        base3.Dispose();
                        this.kyglContent = this.CloseTime("投注金额不能大于信用余额");
                        this.DataBind();
                        base.Response.End();
                        return "";
                    }
                    if (double.Parse(money) > double.Parse(text27))
                    {
                        base3.Dispose();
                        this.kyglContent = this.CloseTime("投注金额不能大于单注限额");
                        this.DataBind();
                        base.Response.End();
                        return "";
                    }
                    text39 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text20.ToUpper() + "' AND userid=" + text24;
                    SqlDataReader reader2 = base3.ExecuteReader(text39);
                    if (reader2.Read())
                    {
                        text28 = reader2[1].ToString().Trim();
                        text29 = reader2[2].ToString().Trim();
                    }
                    else
                    {
                        text28 = "0";
                        text29 = "0";
                    }
                    reader2.Close();
                    text39 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text20.ToUpper() + "' AND userid=" + text23;
                    reader2 = base3.ExecuteReader(text39);
                    if (reader2.Read())
                    {
                        text37 = reader2[1].ToString().Trim();
                        text38 = reader2[2].ToString().Trim();
                    }
                    else
                    {
                        text37 = "0";
                        text38 = "0";
                    }
                    reader2.Close();
                    string text11 = Math.Abs(double.Parse(money)).ToString();
                    num += double.Parse(text11);
                    textArray = this.GetZdRqMsg(ballid, team, db);
                    if (textArray == null)
                    {
                        return this.CloseTime("对不起,球赛已关闭");
                    }
                    text4 = (textArray != null) ? textArray[6] : "FALSE";
                    s = textArray[1];
                    if (double.Parse(s) == 0)
                    {
                        return this.CloseTime();
                    }
                    double num9 = double.Parse(s) + 1;
                    if (num9.ToString().Trim() != double.Parse(cstype).ToString().Trim())
                    {
                        cstype = (double.Parse(s) + 1).ToString();
                    }
                    sql = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,zdbf,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc,isdanger,zdmoney)VALUES(" + text + "," + ballid + "," + type + "," + text11 + "," + textArray[1] + "," + textArray[0] + ",'1','1'," + cstype + ",'" + textArray[4] + "'," + text13 + ",'" + username + "'," + text23 + "," + text24 + "," + text25 + "," + text28 + "," + text30 + "," + text32 + "," + text29 + "," + text31 + "," + text33 + "," + text37 + "," + text38 + "," + text34 + "," + text35 + "," + text36 + ",'" + text22 + "',GetDate()," + text18 + ",'" + textArray[8] + "','" + text20 + "',0," + text11 + ");";
                    text9 = text9 + textArray[4] + "<br>";
                    this.DealGstzMoney(ballid, this.Session["usergsid"].ToString(), "H", this.Session["usergscs"].ToString(), text11, "3");
                    text10 = textArray[1];
                    num2 += double.Parse(text10) * double.Parse(text11);
                    if (base3.ExecuteNonQuery(sql) > 0)
                    {
                        base3.ExecuteNonQuery("UPDATE member SET curmoney=curmoney-" + text11 + ",xzcount=xzcount+1,xztotal=xztotal+" + money + " WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
                    }
                }
            }
            db.Dispose();
            base3.Dispose();
            orderid = orderid.Substring(0, orderid.Length - 1);
            double num12 = num - num2;
            return this.FinishTime(orderid, username, num.ToString(), num2.ToString(), moneysort, num12.ToString());
        }

        private string saveOrder(string type, string ballid, string team, string money, string cstype)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return "";
            }
            string[] textArray = null;
            string orderid = (long.Parse(this.NewOrderid(MyFunc.TimeStampe())) + long.Parse(ballid)).ToString();
            string text2 = orderid;
            string text3 = "FALSE";
            string s = "";
            string sql = "";
            string content = "";
            string text8 = "";
            string text10 = "0";
            string username = "";
            string text12 = "";
            string text13 = "0";
            string moneysort = "";
            string text15 = "1";
            string text16 = "0";
            string text17 = "";
            string text18 = "0";
            string text19 = "";
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
            string text31 = "0";
            string text32 = "0";
            string text33 = "0";
            string text34 = "0";
            string text35 = "0";
            string text36 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            textArray = this.GetZdRqMsg(ballid, team, db);
            if (textArray == null)
            {
                return this.CloseTime("对不起,球赛已关闭");
            }
            text3 = (textArray != null) ? textArray[6] : "FALSE";
            s = textArray[1];
            if (double.Parse(s) == 0)
            {
                return this.CloseTime();
            }
            if (double.Parse(s) != double.Parse(cstype))
            {
                double num2 = double.Parse(s) + 1;
                double num3 = double.Parse(cstype) + 1;
                return this.TzTime(type, ballid, team, money, num2.ToString(), "", num3.ToString());
            }
            string text4 = this.userSql(type);
            string tzMoney = Math.Abs(double.Parse(money)).ToString();
            text36 = "SELECT member.userid,member.userpass,member.username,member.usemoney,member.gdid,member.zdlid,member.dlsid,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,member.isuseable,agence.bl,agence.gdbl,agence.zdlbl" + text4 + " FROM hs RIGHT OUTER JOIN userhs RIGHT OUTER JOIN member ON userhs.userid = member.userid LEFT OUTER JOIN agence ON member.dlsid = agence.userid ON hs.type = member.ABC AND hs.userid = member.dlsid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base3.ExecuteReader(text36);
            if (reader.Read())
            {
                text10 = reader["userid"].ToString().Trim();
                username = reader["username"].ToString().Trim();
                text12 = reader["userpass"].ToString().Trim();
                text13 = reader["usemoney"].ToString().Trim();
                moneysort = reader["moneysort"].ToString().Trim();
                text15 = reader["moneyrate"].ToString().Trim();
                text16 = reader["curmoney"].ToString().Trim();
                text17 = reader["abc"].ToString().Trim();
                text18 = reader["isuseable"].ToString().Trim();
                text19 = base.Request.UserHostAddress.Trim();
                text20 = reader["gdid"].ToString().Trim();
                text21 = reader["zdlid"].ToString().Trim();
                text22 = reader["dlsid"].ToString().Trim();
                text31 = (double.Parse(reader["gdbl"].ToString().Trim()) / 100).ToString();
                text32 = (double.Parse(reader["zdlbl"].ToString().Trim()) / 100).ToString();
                text33 = (double.Parse(reader["bl"].ToString().Trim()) / 100).ToString();
                text29 = reader[15].ToString().Trim();
                text30 = reader[0x10].ToString().Trim();
                text23 = reader[0x11].ToString().Trim();
                text24 = reader[0x12].ToString().Trim();
                text27 = reader[0x13].ToString().Trim();
                text28 = reader[20].ToString().Trim();
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
            if (text12 != this.Session.Contents["userpass"].ToString().Trim())
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
            if (double.Parse(money) > double.Parse(text16))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于信用余额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            if (double.Parse(money) > double.Parse(text24))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于单注限额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            text36 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text17.ToUpper() + "' AND userid=" + text21;
            SqlDataReader reader2 = base3.ExecuteReader(text36);
            if (reader2.Read())
            {
                text25 = reader2[1].ToString().Trim();
                text26 = reader2[2].ToString().Trim();
            }
            else
            {
                text25 = "0";
                text26 = "0";
            }
            reader2.Close();
            text36 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text17.ToUpper() + "' AND userid=" + text20;
            reader2 = base3.ExecuteReader(text36);
            if (reader2.Read())
            {
                text34 = reader2[1].ToString().Trim();
                text35 = reader2[2].ToString().Trim();
            }
            else
            {
                text34 = "0";
                text35 = "0";
            }
            reader2.Close();
            sql = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,zdbf,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc,isdanger,zdmoney)VALUES(" + orderid + "," + ballid + "," + type + "," + tzMoney + "," + textArray[1] + ",'" + team + "','" + textArray[2] + "',1,'" + cstype + "','" + textArray[4] + "'," + text10 + ",'" + username + "'," + text20 + "," + text21 + "," + text22 + "," + text25 + "," + text27 + "," + text29 + "," + text26 + "," + text28 + "," + text30 + "," + text34 + "," + text35 + "," + text31 + "," + text32 + "," + text33 + ",'" + text19 + "',GetDate()," + text15 + ",'" + textArray[8] + "','" + text17 + "',0," + tzMoney + ");";
            content = textArray[4];
            this.DealGstzMoney(ballid, this.Session["usergsid"].ToString(), "H", this.Session["usergscs"].ToString(), tzMoney, "3");
            text8 = textArray[1];
            if (base3.ExecuteNonQuery(sql) > 0)
            {
                base3.ExecuteNonQuery("UPDATE member SET curmoney=curmoney-" + tzMoney + ",xzcount=xzcount+1,xztotal=xztotal+" + money + " WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            }
            base3.Dispose();
            db.Dispose();
            double num8 = double.Parse(text8) * int.Parse(tzMoney);
            int num9 = int.Parse(text16) - int.Parse(tzMoney);
            return this.FinishTime(orderid, username, content, tzMoney, num8.ToString(), moneysort, num9.ToString(), type);
        }

        private string saveOrderCh(string type, string ballid, string team, string money, string cstype, string team1, string zhushu)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return "";
            }
            string[] textArray = null;
            string orderid = (long.Parse(this.NewOrderid(MyFunc.TimeStampe())) + long.Parse(ballid)).ToString();
            string text2 = orderid;
            string text3 = "FALSE";
            string s = "";
            string sql = "";
            string content = "";
            string text8 = "";
            string text10 = "0";
            string username = "";
            string text12 = "";
            string text13 = "0";
            string moneysort = "";
            string text15 = "1";
            string text16 = "0";
            string text17 = "";
            string text18 = "0";
            string text19 = "";
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
            string text31 = "0";
            string text32 = "0";
            string text33 = "0";
            string text34 = "0";
            string text35 = "0";
            string text36 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            if (team1 != "")
            {
                team = team1 + "^" + team;
            }
            textArray = this.GetChMsg(ballid, team, zhushu, db);
            if (textArray == null)
            {
                return this.CloseTime("对不起,球赛已关闭");
            }
            text3 = (textArray != null) ? textArray[6] : "FALSE";
            s = textArray[1];
            if (double.Parse(s) == 0)
            {
                return this.CloseTime();
            }
            if (double.Parse(s) != double.Parse(cstype))
            {
                double num2 = double.Parse(s) + 1;
                double num3 = double.Parse(cstype) + 1;
                return this.TzTime(type, ballid, team, money, num2.ToString(), "", num3.ToString());
            }
            string text4 = this.userSql(type);
            string tzMoney = Math.Abs((double) (double.Parse(money) * double.Parse(zhushu))).ToString();
            text36 = "SELECT member.userid,member.userpass,member.username,member.usemoney,member.gdid,member.zdlid,member.dlsid,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,member.isuseable,agence.bl,agence.gdbl,agence.zdlbl" + text4 + " FROM hs RIGHT OUTER JOIN userhs RIGHT OUTER JOIN member ON userhs.userid = member.userid LEFT OUTER JOIN agence ON member.dlsid = agence.userid ON hs.type = member.ABC AND hs.userid = member.dlsid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base3.ExecuteReader(text36);
            if (reader.Read())
            {
                text10 = reader["userid"].ToString().Trim();
                username = reader["username"].ToString().Trim();
                text12 = reader["userpass"].ToString().Trim();
                text13 = reader["usemoney"].ToString().Trim();
                moneysort = reader["moneysort"].ToString().Trim();
                text15 = reader["moneyrate"].ToString().Trim();
                text16 = reader["curmoney"].ToString().Trim();
                text17 = reader["abc"].ToString().Trim();
                text18 = reader["isuseable"].ToString().Trim();
                text19 = base.Request.UserHostAddress.Trim();
                text20 = reader["gdid"].ToString().Trim();
                text21 = reader["zdlid"].ToString().Trim();
                text22 = reader["dlsid"].ToString().Trim();
                text31 = (double.Parse(reader["gdbl"].ToString().Trim()) / 100).ToString();
                text32 = (double.Parse(reader["zdlbl"].ToString().Trim()) / 100).ToString();
                text33 = (double.Parse(reader["bl"].ToString().Trim()) / 100).ToString();
                text29 = reader[15].ToString().Trim();
                text30 = reader[0x10].ToString().Trim();
                text23 = reader[0x11].ToString().Trim();
                text24 = reader[0x12].ToString().Trim();
                text27 = reader[0x13].ToString().Trim();
                text28 = reader[20].ToString().Trim();
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
            if (text12 != this.Session.Contents["userpass"].ToString().Trim())
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
            if (double.Parse(money) > double.Parse(text16))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于信用余额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            if (double.Parse(money) > double.Parse(text24))
            {
                base3.Dispose();
                this.kyglContent = this.CloseTime("投注金额不能大于单注限额");
                this.DataBind();
                base.Response.End();
                return "";
            }
            text36 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text17.ToUpper() + "' AND userid=" + text21;
            SqlDataReader reader2 = base3.ExecuteReader(text36);
            if (reader2.Read())
            {
                text25 = reader2[1].ToString().Trim();
                text26 = reader2[2].ToString().Trim();
            }
            else
            {
                text25 = "0";
                text26 = "0";
            }
            reader2.Close();
            text36 = "SELECT userid" + this.agenceSql(type) + " FROM hs WHERE type='" + text17.ToUpper() + "' AND userid=" + text20;
            reader2 = base3.ExecuteReader(text36);
            if (reader2.Read())
            {
                text34 = reader2[1].ToString().Trim();
                text35 = reader2[2].ToString().Trim();
            }
            else
            {
                text34 = "0";
                text35 = "0";
            }
            reader2.Close();
            if ((ballid == "152") || (ballid == "155"))
            {
                reader2 = db.ExecuteReader(string.Concat(new object[] { "SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '", this.Session["usergsid"].ToString(), "') WHERE id='", int.Parse(ballid) + 1, "' ORDER BY id asc" }));
                if (reader2.Read())
                {
                    cstype = (double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), "0", reader2["give"].ToString().Trim(), "H", "0").ToString("F2")) - 1).ToString();
                }
                reader2.Close();
            }
            sql = "INSERT INTO Ball_Order(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,zdbf,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc,isdanger,zdmoney)VALUES(" + orderid + "," + ballid + "," + type + "," + tzMoney + "," + textArray[1] + ",'" + team + "','" + textArray[2] + "',1,'" + cstype + "','" + textArray[4] + "'," + text10 + ",'" + username + "'," + text20 + "," + text21 + "," + text22 + "," + text25 + "," + text27 + "," + text29 + "," + text26 + "," + text28 + "," + text30 + "," + text34 + "," + text35 + "," + text31 + "," + text32 + "," + text33 + ",'" + text19 + "',GetDate()," + text15 + ",'" + textArray[8] + "','" + text17 + "',0," + tzMoney + ");";
            content = textArray[4];
            this.DealGstzMoney(ballid, this.Session["usergsid"].ToString(), "H", this.Session["usergscs"].ToString(), tzMoney, "3");
            if ((ballid == "152") || (ballid == "155"))
            {
                this.DealGstzMoney((int.Parse(ballid) + 1).ToString(), this.Session["usergsid"].ToString(), "H", this.Session["usergscs"].ToString(), tzMoney, "3");
            }
            text8 = textArray[1];
            if (base3.ExecuteNonQuery(sql) > 0)
            {
                base3.ExecuteNonQuery("UPDATE member SET curmoney=curmoney-" + tzMoney + ",xzcount=xzcount+1,xztotal=xztotal+" + money + " WHERE userid=" + this.Session.Contents["userid"].ToString().Trim());
            }
            base3.Dispose();
            db.Dispose();
            double num11 = double.Parse(text8) * int.Parse(tzMoney);
            int num12 = int.Parse(text16) - int.Parse(tzMoney);
            return this.FinishTime(orderid, username, content, tzMoney, num11.ToString(), moneysort, num12.ToString(), type);
        }

        private string TzTime(string[] user, string[] ball, string mlist, string betlist)
        {
            string text = "";
            string text2 = "";
            string type = "16";
            string text4 = "";
            string ototal = "";
            string obetlist = "";
            text2 = this.ygltz(type, mlist, betlist, out obetlist, out ototal, true);
            text4 = this.ygltzInput(type, user, mlist, betlist, ototal);
            if (text2 == "")
            {
                return this.CloseTime("同一个过关里不能有相同球赛");
            }
            string text9 = (((((((((("<form name='myForm' action='betting-entry.aspx' method='post'  onKeyPress='disableEnterKey()'>" + "<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + "<TBODY><TR><TD vAlign=top height=22><IMG height=22  src=images/order_ph11.gif width=241></TD></TR>") + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩 " + MyFunc.GettzTypeName(ball[2]) + " 下注单</TD></TR>") + "<TR><TD vAlign=top height=30><IMG height=30 src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>") + "<TBODY><TR><TD>帐户名称: " + user[1] + "</TD></TR>") + "<TR><TD>信用余额: " + user[5] + "</TD></TR>") + "<TR><TD>信用额度: " + user[2] + "</TD></TR>") + "<TR align=left bgColor=#cccccc><TD align=middle colSpan=2><FONT color=#cc0000></FONT></TD></TR>") + "<TR align=left><TD align=middle colSpan=2>期数 : " + ball[6] + "<br>") + text2) + "</TD></TR><TR align=left><TD class=td_fail colSpan=2><FONT color=#ff0000>" + "<TABLE cellSpacing=0 cellPadding=0 width=97% border=0><TBODY>") + "<TR><TD>下注金额:<input name='fr_betamount' size=10 style='font-size:16px;font-weight:bold' maxlenght=12 onKeyUp=\"calculateEstPayout('hk','0')\"></td></tr>" + "<TR><TD>可蠃金额: <span class='payout' id='estPayout1'></span></td></tr>";
            text = text9 + "<TR><TD>最低限额: " + this.MinBet + "</TD></TR><TR><TD>单注限额:" + user[8] + "</TD></TR>";
            if ((ball[1] == "8") || (ball[1] == "9"))
            {
                text = text + "<TR><TD>单号限额: " + user[7] + "</TD></TR>";
            }
            else
            {
                text = text + "<TR><TD>单期限额: " + user[7] + "</TD></TR>";
            }
            text = ((((((((((((text + "<TR align=middle><TD>\n") + "<input type='Submit' class='buttsave' value='下注' > <input type='button' value='取消' class='buttcancel' onClick='cancelBet()'></TD></TR>\n" + "<TR><TD>&nbsp;</TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>") + "<TR><TD vAlign=top height=11><IMG height=11 src='images/order_ph51.gif' width=241></TD></TR>" + "<TR><TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>") + text4 + "</form>") + "<form name='myForm2' action='?' onSubmit='document.myForm.fr_confirmed.value=1;myForm.submit();disableButton();return false;' onKeyPress='disableEnterKey()'>\n") + "<table id='previewScreen' class='bet_entry' cellpading=0 cellspacing=0 background='images/frame_bg.gif' style='display:none'>" + "<tr><td colspan=2 background='images/frame_top.gif' width='225' height='32'></td></tr>") + "<tr style='background:transparent;'><th colspan=2>下注确认 (" + user[1] + ")</th></tr>") + "<tr style='background:transparent;'><td colspan=2 class='wager'>" + this.ygltz(type, mlist, betlist, out obetlist, out ototal, false)) + "</td></tr><tr style='background:transparent;'><td>货币</td><td>" + user[3] + "</td></tr>") + "<tr style='background:transparent;'><td>注额</td><td><span class='amount' id='betAmount'></span></td></tr>" + "<tr style='background:transparent;'><td>可嬴额</td><td><span class='payout' id='estPayout2'></span></td></tr>") + "<tr style='background:transparent;'><td>现时信用</td><td>" + user[2] + "</td></tr>") + "<tr style='background:transparent;'><td>信用馀额</td><td><span id='creditAfterBet'></span></td></tr>" + "<tr style='background:transparent;'><td>&nbsp;</td>") + "<td><input type='submit' name='fr_submit' id='fr_submit' value='最后确定' class='buttsave'> <input type='button' id='fr_back' value='取消' class='buttcancel' onClick='showEntryScreen()'></td></tr><td colspan=2 height=10 background='images/frame_bg.gif'></td>" + "<tr><td colspan=2 background='images/frame_bottom.gif' width='225' height=77'></tr></table><br></form>";
            this.Addons = " onLoad=\"doFormLoad()\"";
            return text;
        }

        private string TzTime(string type, string[] user, string[] ball, string team, string pmsg)
        {
            string text = "";
            string s = "";
            this.bettype = "";
            this.bettype = "var count_win=false;";
            this.bettype = this.bettype + "window.setTimeout(\"self.location='betting-entry.aspx'\", 45000);\n";
            this.bettype = this.bettype + "function CheckKey(){\tif(event.keyCode == 13) return true;";
            this.bettype = this.bettype + "if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert('下注金额仅能输入数字!!'); return false;}}\n";
            this.bettype = this.bettype + "function SubChk(){\tif(document.all.gold.value==''){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('请输入下注金额!!');return false;\t}";
            this.bettype = this.bettype + "if(isNaN(document.all.gold.value) == true){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('下注金额仅能输入数字!!');return false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) < " + this.MinBet + "){document.all.gold.focus();alert('下注金额不可小於最低下注金额!!');\treturn false;\t}";
            string bettype = this.bettype;
            this.bettype = bettype + "if(eval(document.all.gold.value) > " + MyFunc.GetMaxPayOut() + "){\tdocument.all.gold.focus();\talert('对不起,本期有下注金额最高限制 : " + MyFunc.GetMaxPayOut() + "  !!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[8] + "){\tdocument.all.gold.focus();\talert('下注金额不可大於单注限额!!');\treturn false;\t}";
            string text8 = this.bettype;
            this.bettype = text8 + "if((" + ball[5] + "+eval(document.all.gold.value)) > " + user[7] + "){document.all.gold.focus();alert('本期累计下注共:" + ball[5] + "+'+eval(document.all.gold.value)+'\\n下注金额已超过单期(号)限额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[5] + "){document.all.gold.focus();alert('下注金额不可大於信用余额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value)> 994520){\tdocument.all.gold.focus();\talert('下注金额不可大於总代理信用额度!!');return false;\t}";
            this.bettype = this.bettype + @"if(!confirm('可蠃金额:'+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+'\n\n 是否确定下注?')){return false;}";
            this.bettype = this.bettype + "document.all.btnCancel.disabled = true;\tdocument.all.btnSubmit.disabled = true;\tdocument.LAYOUTFORM.submit();}";
            this.bettype = this.bettype + "function CountWinGold(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');\t}else{\t";
            this.bettype = this.bettype + "document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);\tcount_win=true;\t}}\n";
            this.bettype = this.bettype + "function CountWinGold1(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');";
            this.bettype = this.bettype + "}else{\tdocument.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;count_win=true;\t}}\n";
            text = "<FORM name=LAYOUTFORM onsubmit='return false' action='betting-entry.aspx' method=post>";
            text = ((((((text + "<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + "<TBODY><TR><TD vAlign=top height=22><IMG height=22  src=images/order_ph11.gif width=241></TD></TR>") + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩 " + MyFunc.GettzTypeName(ball[2]) + " 下注单</TD></TR>") + "<TR><TD vAlign=top height=30><IMG height=30 src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>") + "<TBODY><TR><TD>帐户名称: " + user[1] + "</TD></TR>") + "<TR><TD>信用余额: " + user[5] + "</TD></TR>") + "<TR><TD>信用额度: " + user[2] + "</TD></TR>") + "<TR align=left bgColor=#cccccc><TD align=middle colSpan=2><FONT color=#cc0000></FONT></TD></TR>";
            if (ball[1].ToString().Trim() == "8")
            {
                s = double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), ball[4], "H", "0").ToString("F2")).ToString();
            }
            else if (((ball[1].ToString().Trim() == "9") || (ball[1].ToString().Trim() == "10")) || ((ball[1].ToString().Trim() == "18") || (ball[1].ToString().Trim() == "19")))
            {
                s = double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")).ToString();
            }
            else
            {
                s = double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), ball[4], "H", "0").ToString("F2")).ToString();
            }
            string text9 = text;
            string text10 = ((text9 + "<TR align=left><TD align=middle colSpan=2>期数 : " + ball[6] + "<P><FONT color=#cc0000>" + ball[3] + "</FONT> @ <FONT color=#ff0000><B>" + s + " </B></FONT></P></TD></TR>") + "<TR align=left><TD class=td_fail colSpan=2><FONT color=#ff0000>" + "<TABLE cellSpacing=0 cellPadding=0 width=97% border=0><TBODY>") + "<TR><TD>下注金额: <INPUT onkeypress='return CheckKey()' id='gold'  onkeyup='return CountWinGold()' maxLength=8 size=8 name='gold'></TD></TR>" + "<TR><TD>可蠃金额: <FONT id=pc color=#ff0000>0</FONT></TD></TR>";
            text = text10 + "<TR><TD>最低限额: " + this.MinBet + "</TD></TR><TR><TD>单注限额:" + user[8] + "</TD></TR>";
            if ((ball[1] == "8") || (ball[1] == "9"))
            {
                text = text + "<TR><TD>单号限额: " + user[7] + "</TD></TR>";
            }
            else
            {
                text = text + "<TR><TD>单期限额: " + user[7] + "</TD></TR>";
            }
            string text11 = ((text + "<TR align=middle><TD><INPUT class=sumbit_cen onclick=self.location='betting-entry.aspx' type=button value=取消 name=btnCancel> ") + " &nbsp;&nbsp; <INPUT class=sumbit_cen onclick='SubChk();' type=button value=确定 name=btnSubmit></TD></TR>" + "<TR><TD>&nbsp;</TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>") + "<TR><TD vAlign=top height=11><IMG height=11 src='images/order_ph51.gif' width=241></TD></TR>" + "<TR><TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>";
            string[] textArray5 = new string[] { text11, "<INPUT type=hidden value='", ball[0], "' name='ballid'><INPUT type=hidden value='saveall' name='action'><INPUT type=hidden value='", ball[1], "' name='tztype'><INPUT type=hidden value='", (double.Parse(s) * 1000).ToString(), "' name='ioradio'><INPUT type=hidden value='", (double.Parse(s) - 1).ToString(), "' name='curpl'></FORM>" };
            return (string.Concat(textArray5) + "<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>");
        }

        private string TzTime(string type, string ballid, string team, string money, string newpl, string content, string oldpl)
        {
            string text = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            string[] textArray = this.BallMsg(ballid, db);
            string[] textArray2 = this.usermsg(this.Session.Contents["userid"].ToString().Trim(), base3, type);
            this.bettype = "";
            this.bettype = "var count_win=false;";
            this.bettype = this.bettype + "window.setTimeout(\"self.location='betting-entry.aspx'\", 45000);\n";
            this.bettype = this.bettype + "function CheckKey(){\tif(event.keyCode == 13) return true;";
            this.bettype = this.bettype + "if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert('下注金额仅能输入数字!!'); return false;}}\n";
            this.bettype = this.bettype + "function SubChk(){\tif(document.all.gold.value==''){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('请输入下注金额!!');return false;\t}";
            this.bettype = this.bettype + "if(isNaN(document.all.gold.value) == true){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('下注金额仅能输入数字!!');return false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) < " + this.MinBet + "){document.all.gold.focus();alert('下注金额不可小於最低下注金额!!');\treturn false;\t}";
            string bettype = this.bettype;
            this.bettype = bettype + "if(eval(document.all.gold.value) > " + MyFunc.GetMaxPayOut() + "){\tdocument.all.gold.focus();\talert('对不起,本期有下注金额最高限制 : " + MyFunc.GetMaxPayOut() + "  !!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + textArray2[8] + "){\tdocument.all.gold.focus();\talert('下注金额不可大於单注限额!!');\treturn false;\t}";
            string text7 = this.bettype;
            this.bettype = text7 + "if((" + textArray[5] + "+eval(document.all.gold.value)) > " + textArray2[7] + "){document.all.gold.focus();alert('本期累计下注共:" + textArray[5] + "+'+eval(document.all.gold.value)+'\\n下注金额已超过单期(号)限额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + textArray2[5] + "){document.all.gold.focus();alert('下注金额不可大於信用余额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value)> 994520){\tdocument.all.gold.focus();\talert('下注金额不可大於总代理信用额度!!');return false;\t}";
            this.bettype = this.bettype + @"if(!confirm('可蠃金额:'+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+'\n\n 是否确定下注?')){return false;}";
            this.bettype = this.bettype + "document.all.btnCancel.disabled = true;\tdocument.all.btnSubmit.disabled = true;\tdocument.LAYOUTFORM.submit();}";
            this.bettype = this.bettype + "function CountWinGold(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');\t}else{\t";
            this.bettype = this.bettype + "document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);\tcount_win=true;\t}}\n";
            this.bettype = this.bettype + "function CountWinGold1(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');";
            this.bettype = this.bettype + "}else{\tdocument.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;count_win=true;\t}}\n";
            string text8 = (((((("<FORM name=LAYOUTFORM onsubmit='return false' action='betting-entry.aspx' method=post>" + "<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + "<TBODY><TR><TD vAlign=top height=22><IMG height=22  src=images/order_ph11.gif width=241></TD></TR>") + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩 " + MyFunc.GettzTypeName(textArray[2]) + " 下注单</TD></TR>") + "<TR><TD vAlign=top height=30><IMG height=30 src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>") + "<TBODY><TR><TD>帐户名称: " + textArray2[1] + "</TD></TR>") + "<TR><TD>信用余额: " + textArray2[5] + "</TD></TR>") + "<TR><TD>信用额度: " + textArray2[2] + "</TD></TR>") + "<TR align=left bgColor=#cccccc><TD align=middle colSpan=2><FONT color=#cc0000></FONT></TD></TR>";
            string text9 = ((text8 + "<TR align=left><TD align=middle colSpan=2>期数 : " + textArray[6] + "<P><FONT color=#cc0000>" + textArray[3] + "</FONT> @ <FONT color=#ff0000><B>" + double.Parse(MyFunc.GetPlType(textArray[2].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), textArray[4], "H", "0").ToString("F2")).ToString() + " </B></FONT></P></TD></TR>") + "<TR align=left><TD class=td_fail colSpan=2><FONT color=#ff0000>" + "<TABLE cellSpacing=0 cellPadding=0 width=97% border=0><TBODY>") + "<TR><TD>下注金额: <INPUT onkeypress='return CheckKey()' id='gold'  onkeyup='return CountWinGold()' maxLength=8 size=8 name='gold'></TD></TR>" + "<TR><TD>可蠃金额: <FONT id=pc color=#ff0000>0</FONT></TD></TR>";
            text = text9 + "<TR><TD>最低限额: " + this.MinBet + "</TD></TR><TR><TD>单注限额:" + textArray2[8] + "</TD></TR>";
            if ((textArray[1] == "8") || (textArray[1] == "9"))
            {
                text = text + "<TR><TD>单号限额: " + textArray2[7] + "</TD></TR>";
            }
            else
            {
                text = text + "<TR><TD>单期限额: " + textArray2[7] + "</TD></TR>";
            }
            string text10 = text;
            string text11 = (((text10 + "<tr style='background:transparent;'><td>赔率已更改<span class=payout>" + oldpl + "</span>-><span class=payout id=newpl>" + newpl + "</span></td></tr>") + "<TR align=middle><TD><INPUT class=sumbit_cen onclick=self.location='betting-entry.aspx' type=button value=取消 name=btnCancel> ") + " &nbsp;&nbsp; <INPUT class=sumbit_cen onclick='SubChk();' type=button value=确定 name=btnSubmit></TD></TR>" + "<TR><TD>&nbsp;</TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>") + "<TR><TD vAlign=top height=11><IMG height=11 src='images/order_ph51.gif' width=241></TD></TR>" + "<TR><TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>";
            string[] textArray8 = new string[] { text11, "<INPUT type=hidden value='", textArray[0], "' name='ballid'><INPUT type=hidden value='SP' name='action'><INPUT type=hidden value='", textArray[1], "' name='tztype'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(textArray[2].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), textArray[4], "H", "0").ToString("F2")) * 1000).ToString(), "' name='ioradio'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(textArray[2].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), textArray[4], "H", "0").ToString("F2")) * 1000).ToString(), "' name='ioradio'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(textArray[2].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), textArray[4], "H", "0").ToString("F2")) - 1).ToString(), "' name='curpl'></FORM>" };
            text = string.Concat(textArray8) + "<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>";
            db.Dispose();
            base3.Dispose();
            return text;
        }

        private string TzTimeCh(string type, string[] user, string[] ball, string team, string pmsg)
        {
            string text = "";
            this.bettype = "";
            this.bettype = "var count_win=false;";
            this.bettype = this.bettype + "window.setTimeout(\"self.location='betting-entry.aspx'\", 45000);\n";
            this.bettype = this.bettype + "function CheckKey(){\tif(event.keyCode == 13) return true;";
            this.bettype = this.bettype + "if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert('下注金额仅能输入数字!!'); return false;}}\n";
            this.bettype = this.bettype + "function SubChk(){\tif(document.all.gold.value==''){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('请输入下注金额!!');return false;\t}";
            this.bettype = this.bettype + "if(isNaN(document.all.gold.value) == true){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('下注金额仅能输入数字!!');return false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) < " + this.MinBet + "){document.all.gold.focus();alert('下注金额不可小於最低下注金额!!');\treturn false;\t}";
            string bettype = this.bettype;
            this.bettype = bettype + "if(eval(document.all.gold.value) > " + MyFunc.GetMaxPayOut() + "){\tdocument.all.gold.focus();\talert('对不起,本期有下注金额最高限制 : " + MyFunc.GetMaxPayOut() + "  !!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[8] + "){\tdocument.all.gold.focus();\talert('下注金额不可大於单注限额!!');\treturn false;\t}";
            string text7 = this.bettype;
            this.bettype = text7 + "if((" + ball[5] + "+eval(document.all.gold.value)) > " + user[7] + "){document.all.gold.focus();alert('本期累计下注共:" + ball[5] + "+'+eval(document.all.gold.value)+'\\n下注金额已超过单期(号)限额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[5] + "){document.all.gold.focus();alert('下注金额不可大於信用余额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value)> 994520){\tdocument.all.gold.focus();\talert('下注金额不可大於总代理信用额度!!');return false;\t}";
            this.bettype = this.bettype + "if(!confirm('可蠃金额:'+Math.round((document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)*" + type + @")+'\n\n 是否确定下注?')){return false;}";
            this.bettype = this.bettype + "document.all.btnCancel.disabled = true;\tdocument.all.btnSubmit.disabled = true;\tdocument.LAYOUTFORM.submit();}";
            this.bettype = this.bettype + "function CountWinGold(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');\t}else{\t";
            string text8 = this.bettype;
            this.bettype = text8 + "document.all.pc.innerHTML=Math.round((document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value)*" + type + ");\tdocument.all.pc1.innerHTML=Math.round(document.all.gold.value*" + type + ");count_win=true;\t}}\n";
            this.bettype = this.bettype + "function CountWinGold1(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');";
            this.bettype = this.bettype + "}else{\tdocument.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;count_win=true;\t}}\n";
            string text9 = (((((("<FORM name=LAYOUTFORM onsubmit='return false' action='betting-entry.aspx' method=post>" + "<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + "<TBODY><TR><TD vAlign=top height=22><IMG height=22  src=images/order_ph11.gif width=241></TD></TR>") + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩 " + MyFunc.GettzTypeName(ball[2]) + " 下注单</TD></TR>") + "<TR><TD vAlign=top height=30><IMG height=30 src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>") + "<TBODY><TR><TD>帐户名称: " + user[1] + "</TD></TR>") + "<TR><TD>信用余额: " + user[5] + "</TD></TR>") + "<TR><TD>信用额度: " + user[2] + "</TD></TR>") + "<TR align=left bgColor=#cccccc><TD align=middle colSpan=2><FONT color=#cc0000></FONT></TD></TR>";
            text = text9 + "<TR align=left><TD align=middle colSpan=2>期数 : " + ball[6] + "<P><FONT color=#cc0000>" + ball[3] + "</FONT> @ <FONT color=#ff0000><B>" + double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")).ToString() + " </B></FONT></P></TD></TR>";
            if (pmsg != "")
            {
                string text10 = text;
                text = text10 + "<TR><TD align=middle>共" + type + "注 <FONT  color=#ff0000>正号 " + pmsg + "</FONT> " + team + "</TD></TR>";
            }
            else
            {
                string text11 = text;
                text = text11 + "<TR><TD align=middle>共" + type + "注 <span  bgcolor=C1D7E5>  " + team + " </span></TD></TR>";
            }
            string text12 = ((text + "<TR align=left><TD class=td_fail colSpan=2><FONT color=#ff0000>") + "<TABLE cellSpacing=0 cellPadding=0 width=97% border=0><TBODY>" + "<TR><TD>单注金额: <INPUT onkeypress='return CheckKey()' id='gold'  onkeyup='return CountWinGold()' maxLength=8 size=8 name='gold'></TD></TR>") + "<TR><TD>下注金额: <FONT id=pc1 color=#ff0000>0</FONT></TD></TR>" + "<TR><TD>可蠃金额: <FONT id=pc color=#ff0000>0</FONT></TD></TR>";
            text = text12 + "<TR><TD>最低限额: " + this.MinBet + "</TD></TR><TR><TD>单注限额:" + user[8] + "</TD></TR>";
            if ((ball[1] == "8") || (ball[1] == "9"))
            {
                text = text + "<TR><TD>单号限额: " + user[7] + "</TD></TR>";
            }
            else
            {
                text = text + "<TR><TD>单期限额: " + user[7] + "</TD></TR>";
            }
            string text13 = ((text + "<TR align=middle><TD><INPUT class=sumbit_cen onclick=self.location='betting-entry.aspx' type=button value=取消 name=btnCancel> ") + " &nbsp;&nbsp; <INPUT class=sumbit_cen onclick='SubChk();' type=button value=确定 name=btnSubmit></TD></TR>" + "<TR><TD>&nbsp;</TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>") + "<TR><TD vAlign=top height=11><IMG height=11 src='images/order_ph51.gif' width=241></TD></TR>" + "<TR><TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>";
            string[] textArray8 = new string[] { text13, "<INPUT type=hidden value='", ball[0], "' name='ballid'><INPUT type=hidden value='savech' name='action'><INPUT type=hidden value='", ball[1], "' name='tztype'><INPUT type=hidden value='", team, "' name='tzteam'><INPUT type=hidden value='", pmsg, "' name='tzteam1'><INPUT type=hidden value='", type, "' name='zhushu'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")) * 1000).ToString(), "' name='ioradio'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")) - 1).ToString(), "' name='curpl'></FORM>" };
            return (string.Concat(textArray8) + "<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>");
        }

        private string TzTimeSx(string type, string[] user, string[] ball, string team, string pmsg)
        {
            string text = "";
            this.bettype = "";
            this.bettype = "var count_win=false;";
            this.bettype = this.bettype + "window.setTimeout(\"self.location='betting-entry.aspx'\", 45000);\n";
            this.bettype = this.bettype + "function CheckKey(){\tif(event.keyCode == 13) return true;";
            this.bettype = this.bettype + "if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert('下注金额仅能输入数字!!'); return false;}}\n";
            this.bettype = this.bettype + "function SubChk(){\tif(document.all.gold.value==''){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('请输入下注金额!!');return false;\t}";
            this.bettype = this.bettype + "if(isNaN(document.all.gold.value) == true){";
            this.bettype = this.bettype + "document.all.gold.focus();alert('下注金额仅能输入数字!!');return false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) < " + this.MinBet + "){document.all.gold.focus();alert('下注金额不可小於最低下注金额!!');\treturn false;\t}";
            string bettype = this.bettype;
            this.bettype = bettype + "if(eval(document.all.gold.value) > " + MyFunc.GetMaxPayOut() + "){\tdocument.all.gold.focus();\talert('对不起,本期有下注金额最高限制 : " + MyFunc.GetMaxPayOut() + "  !!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[8] + "){\tdocument.all.gold.focus();\talert('下注金额不可大於单注限额!!');\treturn false;\t}";
            string text8 = this.bettype;
            this.bettype = text8 + "if((" + ball[5] + "+eval(document.all.gold.value)) > " + user[7] + "){document.all.gold.focus();alert('本期累计下注共:" + ball[5] + "+'+eval(document.all.gold.value)+'\\n下注金额已超过单期(号)限额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value) > " + user[5] + "){document.all.gold.focus();alert('下注金额不可大於信用余额!!');\treturn false;\t}";
            this.bettype = this.bettype + "if(eval(document.all.gold.value)> 994520){\tdocument.all.gold.focus();\talert('下注金额不可大於总代理信用额度!!');return false;\t}";
            this.bettype = this.bettype + @"if(!confirm('可蠃金额:'+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+'\n\n 是否确定下注?')){return false;}";
            this.bettype = this.bettype + "document.all.btnCancel.disabled = true;\tdocument.all.btnSubmit.disabled = true;\tdocument.LAYOUTFORM.submit();}";
            this.bettype = this.bettype + "function CountWinGold(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');\t}else{\t";
            this.bettype = this.bettype + "document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);\tcount_win=true;\t}}\n";
            this.bettype = this.bettype + "function CountWinGold1(){\tif(document.all.gold.value==''){document.all.gold.focus();\talert('未输入下注金额!!!');";
            this.bettype = this.bettype + "}else{\tdocument.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;count_win=true;\t}}\n";
            string text9 = (((((("<FORM name=LAYOUTFORM onsubmit='return false' action='betting-entry.aspx' method=post>" + "<TABLE height=100% cellSpacing=0 cellPadding=0 background=images/order_bk.gif border=0>" + "<TBODY><TR><TD vAlign=top height=22><IMG height=22  src=images/order_ph11.gif width=241></TD></TR>") + "<TR><TD class=m-title background=images/order_ph21.jpg height=36>六合彩 " + MyFunc.GettzTypeName(ball[2]) + " 下注单</TD></TR>") + "<TR><TD vAlign=top height=30><IMG height=30 src=images/order_ph31.gif width=241></TD></TR>" + "<TR><TD vAlign=top background=images/order_ph41.gif height=100><TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>") + "<TBODY><TR><TD>帐户名称: " + user[1] + "</TD></TR>") + "<TR><TD>信用余额: " + user[5] + "</TD></TR>") + "<TR><TD>信用额度: " + user[2] + "</TD></TR>") + "<TR align=left bgColor=#cccccc><TD align=middle colSpan=2><FONT color=#cc0000></FONT></TD></TR>";
            text = text9 + "<TR align=left><TD align=middle colSpan=2>期数 : " + ball[6] + "<P><FONT color=#cc0000>" + ball[3] + "</FONT> @ <FONT color=#ff0000><B>" + double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")).ToString() + " </B></FONT></P></TD></TR>";
            if (team.Length > 1)
            {
                string[] textArray = team.Split(new char[] { ',' });
                string text5 = "";
                for (int i = 0; i < textArray.Length; i++)
                {
                    text5 = text5 + MyFunc.GettwelveName(textArray[i]) + ",";
                }
                text5 = text5.Substring(0, text5.Length - 1);
                string text10 = text;
                text = text10 + "<TR><TD align=center><table cellSpacing=0 cellPadding=0  align=center><tr><td bgcolor=C1D7E5><FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000\">" + text5 + "</font></td></tr></table></TD></TR><INPUT type=hidden value='" + team + "' name='tzteam'>";
            }
            string text11 = (text + "<TR align=left><TD class=td_fail colSpan=2><FONT color=#ff0000>" + "<TABLE cellSpacing=0 cellPadding=0 width=97% border=0><TBODY>") + "<TR><TD>下注金额: <INPUT onkeypress='return CheckKey()' id='gold'  onkeyup='return CountWinGold()' maxLength=8 size=8 name='gold'></TD></TR>" + "<TR><TD>可蠃金额: <FONT id=pc color=#ff0000>0</FONT></TD></TR>";
            text = text11 + "<TR><TD>最低限额: " + this.MinBet + "</TD></TR><TR><TD>单注限额:" + user[8] + "</TD></TR>";
            if ((ball[1] == "8") || (ball[1] == "9"))
            {
                text = text + "<TR><TD>单号限额: " + user[7] + "</TD></TR>";
            }
            else
            {
                text = text + "<TR><TD>单期限额: " + user[7] + "</TD></TR>";
            }
            string text12 = ((text + "<TR align=middle><TD><INPUT class=sumbit_cen onclick=self.location='betting-entry.aspx' type=button value=取消 name=btnCancel> ") + " &nbsp;&nbsp; <INPUT class=sumbit_cen onclick='SubChk();' type=button value=确定 name=btnSubmit></TD></TR>" + "<TR><TD>&nbsp;</TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>") + "<TR><TD vAlign=top height=11><IMG height=11 src='images/order_ph51.gif' width=241></TD></TR>" + "<TR><TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>";
            string[] textArray7 = new string[] { text12, "<INPUT type=hidden value='", ball[0], "' name='ballid'><INPUT type=hidden value='savesx' name='action'><INPUT type=hidden value='", ball[1], "' name='tztype'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")) * 1000).ToString(), "' name='ioradio'><INPUT type=hidden value='", (double.Parse(MyFunc.GetPlType(ball[2].ToString().Trim(), "0", ball[4], "H", "0").ToString("F2")) - 1).ToString(), "' name='curpl'></FORM>" };
            return (string.Concat(textArray7) + "<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>");
        }

        private string tztype(string str)
        {
            switch (str.Trim().ToUpper())
            {
                case "AH":
                    return "1";

                case "OU":
                    return "2";

                case "RAH":
                    this.bettype = "betType = 'running';";
                    return "3";

                case "ROU":
                    this.bettype = "betType = 'running';";
                    return "4";

                case "ROE":
                    this.bettype = "betType = 'running';";
                    return "28";

                case "OE":
                    return "5";

                case "1X2":
                    return "6";

                case "P1X2":
                    return "7";

                case "PAH":
                    return "8";

                case "CS":
                    return "9";

                case "TG":
                    return "10";

                case "HT":
                    return "11";

                case "AHHT":
                    return "12";

                case "OUHT":
                    return "13";

                case "EAH":
                    return "14";

                case "EOU":
                    return "15";

                case "PCS":
                    return "16";

                case "PHT":
                    return "17";
            }
            return "";
        }

        private string[] usermsg(string userid, DataBase db, string type)
        {
            string sql = "SELECT member.userid,member.username,member.usemoney,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,";
            sql = (sql + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11," + "userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXC15,userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC28,userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3,userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,") + "userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,userhs.MAXZ14,userhs.MAXZ15,userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ28 FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid = " + userid + " AND member.isuseable=1";
            SqlDataReader reader = db.ExecuteReader(sql);
            if (!reader.Read())
            {
                reader.Close();
                return null;
            }
            string[] textArray = new string[10];
            textArray[0] = reader["userid"].ToString().Trim();
            textArray[1] = reader["username"].ToString().Trim();
            textArray[2] = reader["usemoney"].ToString().Trim();
            textArray[3] = reader["moneysort"].ToString().Trim();
            textArray[4] = reader["moneyrate"].ToString().Trim();
            textArray[5] = reader["curmoney"].ToString().Trim();
            textArray[6] = reader["abc"].ToString().Trim();
            switch (type.Trim())
            {
                case "1":
                    textArray[7] = reader["Maxc2"].ToString().Trim();
                    textArray[8] = reader["Maxz2"].ToString().Trim();
                    break;

                case "2":
                    textArray[7] = reader["Maxc3"].ToString().Trim();
                    textArray[8] = reader["Maxz3"].ToString().Trim();
                    break;

                case "3":
                    textArray[7] = reader["Maxc4"].ToString().Trim();
                    textArray[8] = reader["Maxz4"].ToString().Trim();
                    break;

                case "4":
                    textArray[7] = reader["Maxc5"].ToString().Trim();
                    textArray[8] = reader["Maxz5"].ToString().Trim();
                    break;

                case "5":
                    textArray[7] = reader["Maxc6"].ToString().Trim();
                    textArray[8] = reader["Maxz6"].ToString().Trim();
                    break;

                case "6":
                    textArray[7] = reader["Maxc19"].ToString().Trim();
                    textArray[8] = reader["Maxz19"].ToString().Trim();
                    break;

                case "7":
                    textArray[7] = reader["Maxc20"].ToString().Trim();
                    textArray[8] = reader["Maxz20"].ToString().Trim();
                    break;

                case "8":
                    textArray[7] = reader["Maxc1"].ToString().Trim();
                    textArray[8] = reader["Maxz1"].ToString().Trim();
                    break;

                case "9":
                    textArray[7] = reader["Maxc28"].ToString().Trim();
                    textArray[8] = reader["Maxz28"].ToString().Trim();
                    break;

                case "10":
                    textArray[7] = reader["Maxc21"].ToString().Trim();
                    textArray[8] = reader["Maxz21"].ToString().Trim();
                    break;

                case "11":
                    textArray[7] = reader["Maxc8"].ToString().Trim();
                    textArray[8] = reader["Maxz8"].ToString().Trim();
                    break;

                case "12":
                    textArray[7] = reader["Maxc9"].ToString().Trim();
                    textArray[8] = reader["Maxz9"].ToString().Trim();
                    break;

                case "13":
                    textArray[7] = reader["Maxc7"].ToString().Trim();
                    textArray[8] = reader["Maxz7"].ToString().Trim();
                    break;

                case "14":
                    textArray[7] = reader["Maxc10"].ToString().Trim();
                    textArray[8] = reader["Maxz10"].ToString().Trim();
                    break;

                case "15":
                    textArray[7] = reader["Maxc11"].ToString().Trim();
                    textArray[8] = reader["Maxz11"].ToString().Trim();
                    break;

                case "16":
                    textArray[7] = reader["Maxc12"].ToString().Trim();
                    textArray[8] = reader["Maxz12"].ToString().Trim();
                    break;

                case "17":
                    textArray[7] = reader["Maxc13"].ToString().Trim();
                    textArray[8] = reader["Maxz13"].ToString().Trim();
                    break;

                case "18":
                    textArray[7] = reader["Maxc18"].ToString().Trim();
                    textArray[8] = reader["Maxz18"].ToString().Trim();
                    break;

                case "19":
                    textArray[7] = reader["Maxc22"].ToString().Trim();
                    textArray[8] = reader["Maxz22"].ToString().Trim();
                    break;

                case "20":
                    textArray[7] = reader["Maxc23"].ToString().Trim();
                    textArray[8] = reader["Maxz23"].ToString().Trim();
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
                case "1":
                    return ",userhs.W2,userhs.L2,userhs.Maxc2,userhs.Maxz2,hs.W2 AS DlsW2,hs.L2 AS DlsL2";

                case "2":
                    return ",userhs.W3,userhs.L3,userhs.Maxc3,userhs.Maxz3,hs.W3 AS DlsW3,hs.L3 AS DlsL3";

                case "3":
                    return ",userhs.W4,userhs.L4,userhs.Maxc4,userhs.Maxz4,hs.W4 AS DlsW4,hs.L4 AS DlsL4";

                case "4":
                    return ",userhs.W5,userhs.L5,userhs.Maxc5,userhs.Maxz5,hs.W5 AS DlsW1,hs.L5 AS DlsL5";

                case "5":
                    return ",userhs.W6,userhs.L6,userhs.Maxc6,userhs.Maxz6,hs.W6 AS DlsW6,hs.L6 AS DlsL6";

                case "6":
                    return ",userhs.W19,userhs.L19,userhs.Maxc19,userhs.Maxz19,hs.W19 AS DlsW19,hs.L19 AS DlsL19";

                case "7":
                    return ",userhs.W20,userhs.L20,userhs.Maxc20,userhs.Maxz20,hs.W20 AS DlsW20,hs.L20 AS DlsL20";

                case "8":
                    return ",userhs.W1,userhs.L1,userhs.Maxc1,userhs.Maxz1,hs.W1 AS DlsW1,hs.L1 AS DlsL1";

                case "9":
                    return ",userhs.W28,userhs.L28,userhs.Maxc28,userhs.Maxz28,hs.W28 AS DlsW28,hs.L28 AS DlsL28";

                case "10":
                    return ",userhs.W21,userhs.L21,userhs.Maxc21,userhs.Maxz21,hs.W21 AS DlsW21,hs.L21 AS DlsL21";

                case "11":
                    return ",userhs.W8,userhs.L8,userhs.Maxc8,userhs.Maxz8,hs.W8 AS DlsW8,hs.L8 AS DlsL8";

                case "12":
                    return ",userhs.W9,userhs.L9,userhs.Maxc9,userhs.Maxz9,hs.W9 AS DlsW9,hs.L9 AS DlsL9";

                case "13":
                    return ",userhs.W7,userhs.L7,userhs.Maxc7,userhs.Maxz7,hs.W7 AS DlsW7,hs.L7 AS DlsL7";

                case "14":
                    return ",userhs.W10,userhs.L10,userhs.Maxc10,userhs.Maxz10,hs.W10 AS DlsW10,hs.L10 AS DlsL10";

                case "15":
                    return ",userhs.W11,userhs.L11,userhs.Maxc11,userhs.Maxz11,hs.W11 AS DlsW11,hs.L11 AS DlsL11";

                case "16":
                    return ",userhs.W12,userhs.L12,userhs.Maxc12,userhs.Maxz12,hs.W12 AS DlsW12,hs.L12 AS DlsL12";

                case "17":
                    return ",userhs.W13,userhs.L13,userhs.Maxc13,userhs.Maxz13,hs.W13 AS DlsW13,hs.L13 AS DlsL13";

                case "18":
                    return ",userhs.W18,userhs.L18,userhs.Maxc18,userhs.Maxz18,hs.W18 AS DlsW18,hs.L18 AS DlsL18";

                case "19":
                    return ",userhs.W22,userhs.L22,userhs.Maxc22,userhs.Maxz22,hs.W22 AS DlsW22,hs.L22 AS DlsL22";

                case "20":
                    return ",userhs.W23,userhs.L23,userhs.Maxc23,userhs.Maxz23,hs.W23 AS DlsW23,hs.L23 AS DlsL23";

                case "21":
                    return ",userhs.W23,userhs.L23,userhs.Maxc23,userhs.Maxz23,hs.W23 AS DlsW23,hs.L23 AS DlsL23";
            }
            return "";
        }

        private string ygltz(string type, string mlist, string betlist, out string obetlist, out string ototal, bool bo)
        {
            string[] textArray = mlist.Split(new char[] { ',' });
            string[] textArray2 = betlist.Split(new char[] { ',' });
            string[] textArray3 = new string[textArray2.Length];
            string[] ball = new string[textArray2.Length];
            string text = "";
            string text2 = "";
            double num = 1;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            if (type != "22")
            {
                SqlDataReader reader = base2.ExecuteReader("SELECT * FROM pl WHERE id in(" + mlist + ")");
                while (reader.Read())
                {
                    for (int i = 0; i < textArray.Length; i++)
                    {
                        if (textArray[i] == reader["id"].ToString().Trim())
                        {
                            ball[i] = reader["pltype"].ToString().Trim();
                            text = text + reader["pl"].ToString().Trim() + ",";
                            textArray3[i] = double.Parse(reader["pl"].ToString().Trim()).ToString("F3");
                            string text9 = text2;
                            text2 = text9 + "<DIV><SPAN class=pick><FONT COLOR=#CC0000>" + ball[i] + "</font>&nbsp;@&nbsp;</SPAN><SPAN ><font color=\"#CC0000\"><B>" + reader["pl"].ToString().Trim() + "</B></font></SPAN> ";
                            if (bo)
                            {
                                text2 = text2 + "<INPUT class=buttx id=" + reader["id"].ToString().Trim() + " onclick=cancelParlayBet(this) type=button value=\"删除\">";
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
                    num *= double.Parse(textArray3[index]);
                    index++;
                }
                text2 = text2 + "<SPAN class=pick>模式 <select name=sid><option value=0 selected>单注 </option></select><select name=leixing><option value=0 selected>" + index.ToString() + "串1 </option></select><HR style=\"COLOR: gray; HEIGHT: 1px\"></SPAN>";
            }
            if (type == "22")
            {
                SqlDataReader reader2 = base2.ExecuteReader("SELECT * FROM Ball_pl7view WHERE ballid in(" + mlist + ")");
                while (reader2.Read())
                {
                    for (int j = 0; j < textArray.Length; j++)
                    {
                        string text6 = "";
                        string text7 = "VS";
                        if (textArray[j] == reader2["ballid"].ToString().Trim())
                        {
                            string text4;
                            string text5;
                            ball[j] = reader2["team1"].ToString().Trim();
                            if (textArray2[j].IndexOf("AH_") != -1)
                            {
                                text7 = reader2["giveup"].ToString().Trim();
                                if (reader2["xenial"].ToString().Trim().ToUpper() == "H")
                                {
                                    text4 = reader2["team1"].ToString().Trim();
                                    text5 = reader2["team2"].ToString().Trim();
                                    if (textArray2[j] == "AH_H")
                                    {
                                        textArray3[j] = (double.Parse(reader2["giveup1"].ToString().Trim()) - 0.025).ToString("F3");
                                        text6 = reader2["team1"].ToString().Trim();
                                    }
                                    else
                                    {
                                        textArray3[j] = (double.Parse(reader2["giveup2"].ToString().Trim()) - 0.025).ToString("F3");
                                        text6 = reader2["team2"].ToString().Trim();
                                    }
                                }
                                else
                                {
                                    text4 = reader2["team2"].ToString().Trim();
                                    text5 = reader2["team1"].ToString().Trim();
                                    if (textArray2[j] == "AH_H")
                                    {
                                        textArray3[j] = (double.Parse(reader2["giveup2"].ToString().Trim()) - 0.025).ToString("F3");
                                        text6 = reader2["team1"].ToString().Trim();
                                    }
                                    else
                                    {
                                        textArray3[j] = (double.Parse(reader2["giveup1"].ToString().Trim()) - 0.025).ToString("F3");
                                        text6 = reader2["team2"].ToString().Trim();
                                    }
                                }
                            }
                            else if (textArray2[j].IndexOf("DX_") != -1)
                            {
                                text7 = "VS";
                                text4 = reader2["team1"].ToString().Trim();
                                text5 = reader2["team2"].ToString().Trim();
                                if (textArray2[j] == "DX_D")
                                {
                                    textArray3[j] = (double.Parse(reader2["bigpl"].ToString().Trim()) - 0.03).ToString("F3");
                                    text6 = reader2["bigsmall1"].ToString().Trim();
                                }
                                else
                                {
                                    textArray3[j] = (double.Parse(reader2["smallpl"].ToString().Trim()) - 0.03).ToString("F3");
                                    text6 = reader2["bigsmall2"].ToString().Trim();
                                }
                            }
                            else if (textArray2[j].IndexOf("DS_") != -1)
                            {
                                text7 = "VS";
                                text4 = reader2["team1"].ToString().Trim();
                                text5 = reader2["team2"].ToString().Trim();
                                if (textArray2[j] == "DS_S")
                                {
                                    textArray3[j] = ((double.Parse(reader2["bsingle"].ToString().Trim()) - 1) - 0.05).ToString("F3");
                                    text6 = "单";
                                }
                                else
                                {
                                    textArray3[j] = ((double.Parse(reader2["btwin"].ToString().Trim()) - 1) - 0.05).ToString("F3");
                                    text6 = "双";
                                }
                            }
                            else
                            {
                                text4 = "";
                                text5 = "";
                                text6 = "";
                                textArray3[j] = "1";
                                text7 = "VS";
                            }
                            text = text + textArray3[j] + ",";
                            string text10 = text2;
                            text2 = text10 + "<DIV align=left>" + reader2["matchname"].ToString().Trim() + "<BR>" + text4 + " <SPAN class=hdp>" + text7 + "</span> " + text5 + "<BR><SPAN class=pick>" + text6 + "</SPAN> @ <SPAN class=odds>" + textArray3[j] + "</SPAN> ";
                            if (bo)
                            {
                                text2 = text2 + "<INPUT class=buttx id=" + reader2["ballid"].ToString().Trim() + " onclick=cancelPAHParlayBet(this) type=button value=\" x \">";
                            }
                            text2 = text2 + "<HR style=\"COLOR: gray; HEIGHT: 1px\"></DIV>";
                        }
                    }
                }
                if (text != "")
                {
                    text = text.Remove(text.Length - 1, 1);
                }
                reader2.Close();
                base2.Dispose();
                int num5 = 0;
                while (num5 < textArray3.Length)
                {
                    num *= double.Parse(textArray3[num5]) + 1;
                    num5++;
                }
                string text11 = text2;
                text2 = text11 + "<SPAN class=pick>" + num5.ToString() + " 三全中</SPAN> @ <SPAN class=odds style=\"FONT-SIZE: 18px\">" + num.ToString("F3") + "</SPAN>";
            }
            if (this.SameGame(ball))
            {
                text2 = "";
            }
            ototal = num.ToString("F3");
            obetlist = text;
            return text2;
        }

        private string ygltzInput(string type, string[] user, string mlist, string blist, string total)
        {
            string text = "";
            double num = double.Parse(total) - 1;
            double num2 = double.Parse(total) - 1;
            return (((((((((((((((((text + "<INPUT type=hidden value='" + user[5] + "' name='fr_credit'> ") + "<INPUT type=hidden value='" + this.MinBet + "' name='fr_minbet'> ") + "<INPUT type=hidden value='" + user[8] + "' name='fr_maxbet'> ") + "<INPUT type=hidden value='" + MyFunc.GetMaxPayOut() + "' name='fr_maximum_payout'> ") + "<INPUT type=hidden name='fr_estimate_payout'> ") + "<INPUT type=hidden name='fr_odds_lose' value=''> " + "<INPUT type=hidden name='fr_spread' value=''> ") + "<INPUT type=hidden name='fr_handicap' value=''> " + "<INPUT type=hidden name='fr_matchindex' value=''> ") + "<INPUT type=hidden name='fr_magnumindex' value=''> " + "<INPUT type=hidden name='fr_pick' value=''> ") + "<INPUT type=hidden name='fr_scorea' value=''> " + "<INPUT type=hidden name='fr_scoreb value='''> ") + "<INPUT type=hidden value='" + type + "' name='fr_bettype'> ") + "<INPUT type=hidden name='fr_favourite' value=''> ") + "<INPUT type=hidden name='fr_dangerstatus' value=''> " + "<INPUT type=hidden value='0' name='fr_confirmed'> ") + "<INPUT type=hidden value='" + num.ToString() + "' name='fr_odds'> ") + "<INPUT type=hidden value='" + num2.ToString() + "' name='fr_odds_cap'> ") + "<INPUT type=hidden value='" + mlist + "' name='req_matchlist'> ") + "<INPUT type=hidden value='" + blist + "' name='req_userbet_list'> ") + "<input type='hidden' name='action' value='kygl'>");
        }
    }
}

