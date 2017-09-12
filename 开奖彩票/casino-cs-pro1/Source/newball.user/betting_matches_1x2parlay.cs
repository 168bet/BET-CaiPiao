namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class betting_matches_1x2parlay : Page
    {
        public string ballid = "";
        public string ballid1 = "";
        public string curmoney = "";
        public string curpl = "";
        public string curpl1 = "";
        public string gTime = "";
        public string kaisai = "";
        public string kyglcontent = "";
        public string kygltable = "";
        protected HtmlTable MainTable;
        public string maxc = "";
        public string maxz = "";
        public string msg = "";
        public string qishu = "";
        public string singlebet = "";
        public string singlegame = "";
        public string singlegames = "0,";

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private void MainContent()
        {
            string text = "";
            string text2 = "";
            string sql = "";
            int num = 0;
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num2 = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
            if (num2 > 0)
            {
                if (num2 < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num2 + "';";
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                sql = "SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>34 and id<84 ORDER BY id asc";
                DataSet set = base2.ExecuteDataSet(sql);
                for (num = 1; num < 11; num++)
                {
                    if (num != 10)
                    {
                        this.kygltable = this.kygltable + "<tr>";
                        for (int i = 0; i < 5; i++)
                        {
                            string text5 = "";
                            if (i == 0)
                            {
                                text5 = "0" + num.ToString();
                            }
                            else
                            {
                                text5 = ((i * 10) + num).ToString();
                            }
                            this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[((i * 10) + num) - 1]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[((i * 10) + num) - 1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                            this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[((i * 10) + num) - 1]["id"].ToString().Trim()).ToString() + ",";
                            text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[((i * 10) + num) - 1]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[((i * 10) + num) - 1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            text2 = double.Parse(set.Tables[0].Rows[((i * 10) + num) - 1]["id"].ToString().Trim()).ToString();
                            string kygltable = this.kygltable;
                            this.kygltable = kygltable + "<TD class=ball_td align=middle background=" + MyFunc.GetRGB(text5.ToString()) + " height=27><FONT style=\"PADDING-RIGHT: 2px; PADDING-LEFT: 2px; FILTER: glow(color=#000000,strength=1); PADDING-BOTTOM: 2px; COLOR: #000000; PADDING-TOP: 2px; HEIGHT: 10px\">" + text5 + "</FONT></TD>\n";
                            this.kygltable = this.kygltable + " <TD class=radio_set align=middle><FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #cc0000\">" + text + "</FONT></TD>\n";
                            string text8 = this.kygltable;
                            string[] textArray2 = new string[] { text8, " <TD align=middle><INPUT onkeypress=\"return CheckKey();\" onblur=\"return CountGold(this,'blur','", ((i * 10) + num).ToString(), "');\" onkeyup=\"return CountGold(this,'keyup','", ((i * 10) + num).ToString(), "');\" onfocus=\"CountGold(this,'focus','", ((i * 10) + num).ToString(), "');this.value='';\"   tabIndex=", ((i * 10) + num).ToString(), " size=4 name=", text2, "></TD>\n" };
                            this.kygltable = string.Concat(textArray2);
                        }
                        this.kygltable = this.kygltable + "</tr>";
                    }
                    else
                    {
                        this.kygltable = this.kygltable + "<tr>";
                        for (int j = 0; j < 4; j++)
                        {
                            string text6 = "";
                            text6 = ((j * 10) + num).ToString();
                            this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[((j * 10) + num) - 1]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[((j * 10) + num) - 1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                            this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[((j * 10) + num) - 1]["id"].ToString().Trim()).ToString() + ",";
                            text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[((j * 10) + num) - 1]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[((j * 10) + num) - 1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            text2 = double.Parse(set.Tables[0].Rows[((j * 10) + num) - 1]["id"].ToString().Trim()).ToString();
                            string text9 = this.kygltable;
                            this.kygltable = text9 + "<TD class=ball_td align=middle background=" + MyFunc.GetRGB(text6.ToString()) + " height=27><FONT style=\"PADDING-RIGHT: 2px; PADDING-LEFT: 2px; FILTER: glow(color=#000000,strength=1); PADDING-BOTTOM: 2px; COLOR: #000000; PADDING-TOP: 2px; HEIGHT: 10px\">" + text6 + "</FONT></TD>\n";
                            this.kygltable = this.kygltable + " <TD class=radio_set align=middle><FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #cc0000\">" + text + "</FONT></TD>\n";
                            string text10 = this.kygltable;
                            string[] textArray4 = new string[] { text10, " <TD align=middle><INPUT onkeypress=\"return CheckKey();\" onblur=\"return CountGold(this,'blur','", ((j * 10) + num).ToString(), "');\" onkeyup=\"return CountGold(this,'keyup','", ((j * 10) + num).ToString(), "');\" onfocus=\"CountGold(this,'focus','", ((j * 10) + num).ToString(), "');this.value='';\"   tabIndex=", ((j * 10) + num).ToString(), " size=4 name=", text2, "></TD>\n" };
                            this.kygltable = string.Concat(textArray4);
                        }
                        this.kygltable = this.kygltable + " <TD align=middle colSpan=3><INPUT onclick=\"return ChkSubmit();\" type=button value=确定 name=btnSubmit><INPUT onclick=\"location.href='quickinput2.aspx'\" type=reset value=重设 name=btnReset> </TD></tr>";
                    }
                }
                this.ballid = this.ballid.Substring(0, this.ballid.Length - 1);
                this.curpl = this.curpl.Substring(0, this.curpl.Length - 1);
                base2.Dispose();
                this.gTime = this.kaisai;
            }
        }

        private void MainContent1()
        {
            string text = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num2 = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
            if (num2 > 0)
            {
                if (num2 < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num2 + "';";
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>0 and id<7 ORDER BY id asc");
                for (int i = 0; i < 4; i++)
                {
                    if (reader.Read())
                    {
                        this.curpl1 = this.curpl1 + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                        this.ballid1 = this.ballid1 + double.Parse(reader["id"].ToString().Trim()).ToString() + ",";
                        text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        this.MainTable.Rows[0].Cells[(3 * i) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #cc0000\">" + text + "</font>";
                    }
                }
                for (int j = 0; j < 2; j++)
                {
                    if (reader.Read())
                    {
                        this.curpl1 = this.curpl1 + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                        this.ballid1 = this.ballid1 + double.Parse(reader["id"].ToString().Trim()).ToString() + ",";
                        text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        this.MainTable.Rows[1].Cells[(3 * j) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #cc0000\">" + text + "</font>";
                    }
                }
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id>211 and v1.id<215 ORDER BY id asc");
                for (int k = 0; k < 3; k++)
                {
                    if (reader.Read())
                    {
                        this.curpl1 = this.curpl1 + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                        this.ballid1 = this.ballid1 + double.Parse(reader["id"].ToString().Trim()).ToString() + ",";
                        text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        this.MainTable.Rows[2].Cells[(3 * k) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #cc0000\">" + text + "</font>";
                    }
                }
                reader.Close();
                this.ballid1 = this.ballid1.Substring(0, this.ballid1.Length - 1);
                this.curpl1 = this.curpl1.Substring(0, this.curpl1.Length - 1);
                base2.Dispose();
            }
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
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,tupdatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["tupdatetime"].ToString().Trim();
                }
                reader.Close();
                string sql = "SELECT member.userid,member.username,member.usemoney,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,";
                sql = (sql + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11," + "userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXC15,userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC28,userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3,userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,") + "userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,userhs.MAXZ14,userhs.MAXZ15,userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ28 FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid = " + this.Session.Contents["userid"].ToString().Trim() + " AND member.isuseable=1";
                reader = base2.ExecuteReader(sql);
                if (!reader.Read())
                {
                    this.curmoney = "0";
                    this.singlebet = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
                    this.singlegame = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
                    reader.Close();
                }
                else
                {
                    this.curmoney = reader["curmoney"].ToString().Trim();
                    this.singlebet = "0";
                    for (int i = 0; i < 0x31; i++)
                    {
                        this.singlebet = this.singlebet + "," + reader["Maxz1"].ToString().Trim();
                    }
                    for (int j = 0; j < 0x31; j++)
                    {
                        this.singlebet = this.singlebet + reader["Maxz1"].ToString().Trim();
                    }
                    string singlebet = this.singlebet;
                    this.singlebet = singlebet + reader["Maxz2"].ToString().Trim() + "," + reader["Maxz2"].ToString().Trim() + "," + reader["Maxz3"].ToString().Trim() + "," + reader["Maxz3"].ToString().Trim() + "," + reader["Maxz4"].ToString().Trim() + "," + reader["Maxz4"].ToString().Trim() + "," + reader["Maxz13"].ToString().Trim() + "," + reader["Maxz13"].ToString().Trim() + "," + reader["Maxz13"].ToString().Trim();
                    this.singlegame = "0";
                    for (int k = 0; k < 0x31; k++)
                    {
                        this.singlegame = this.singlegame + "," + reader["Maxc1"].ToString().Trim();
                    }
                    for (int m = 0; m < 0x31; m++)
                    {
                        this.singlegame = this.singlegame + reader["Maxc1"].ToString().Trim();
                    }
                    string singlegame = this.singlegame;
                    this.singlegame = singlegame + reader["Maxc2"].ToString().Trim() + "," + reader["Maxc2"].ToString().Trim() + "," + reader["Maxc3"].ToString().Trim() + "," + reader["Maxc3"].ToString().Trim() + "," + reader["Maxc4"].ToString().Trim() + "," + reader["Maxc4"].ToString().Trim() + "," + reader["Maxc13"].ToString().Trim() + "," + reader["Maxc13"].ToString().Trim() + "," + reader["Maxc13"].ToString().Trim();
                    reader.Close();
                }
                for (int n = 0x23; n < 0x54; n++)
                {
                    this.singlegames = this.singlegames + base2.ExecuteScalar("SELECT isnull(sum(tzmoney),0) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + n.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                }
                for (int num6 = 1; num6 < 7; num6++)
                {
                    this.singlegames = this.singlegames + base2.ExecuteScalar("SELECT isnull(sum(tzmoney),0) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + num6.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                }
                for (int num7 = 0xd4; num7 < 0xd7; num7++)
                {
                    this.singlegames = this.singlegames + base2.ExecuteScalar("SELECT isnull(sum(tzmoney),0) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + num7.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                }
                base2.Dispose();
                this.MainContent();
                this.MainContent1();
                this.DataBind();
            }
        }
    }
}

