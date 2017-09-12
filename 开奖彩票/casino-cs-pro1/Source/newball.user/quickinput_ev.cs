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

    public class quickinput_ev : Page
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
        protected HtmlTable MainTable1;
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
                sql = "SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>0 and id<35 ORDER BY id asc";
                DataSet set = base2.ExecuteDataSet(sql);
                num = 0;
                for (int i = 0; i < 4; i++)
                {
                    this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(num * 5) + i]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(num * 5) + i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                    this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[(num * 5) + i]["id"].ToString().Trim()).ToString() + ",";
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(num * 5) + i]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(num * 5) + i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = double.Parse(set.Tables[0].Rows[(num * 5) + i]["id"].ToString().Trim()).ToString();
                    this.MainTable.Rows[num + 1].Cells[(3 * i) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000\">" + text + "</font>";
                }
                num = 1;
                for (int j = 0; j < 2; j++)
                {
                    this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(num * 4) + j]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(num * 4) + j]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                    this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[(num * 4) + j]["id"].ToString().Trim()).ToString() + ",";
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(num * 4) + j]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(num * 4) + j]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = double.Parse(set.Tables[0].Rows[(num * 4) + j]["id"].ToString().Trim()).ToString();
                    this.MainTable.Rows[num + 1].Cells[(3 * j) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000\">" + text + "</font>";
                }
                num = 2;
                for (int k = 0; k < 4; k++)
                {
                    this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[6 + k]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[6 + k]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                    this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[6 + k]["id"].ToString().Trim()).ToString() + ",";
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[6 + k]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[6 + k]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = double.Parse(set.Tables[0].Rows[6 + k]["id"].ToString().Trim()).ToString();
                    this.MainTable.Rows[num + 1].Cells[(3 * k) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000\">" + text + "</font>";
                }
                for (num = 0; num < 4; num++)
                {
                    for (int m = 0; m < 4; m++)
                    {
                        this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(10 + (num * 6)) + m]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(10 + (num * 6)) + m]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                        this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[(10 + (num * 6)) + m]["id"].ToString().Trim()).ToString() + ",";
                        text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(10 + (num * 6)) + m]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(10 + (num * 6)) + m]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        text2 = double.Parse(set.Tables[0].Rows[(10 + (num * 6)) + m]["id"].ToString().Trim()).ToString();
                        this.MainTable1.Rows[num + 2].Cells[(3 * m) + 1].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000\">" + text + "</font>";
                    }
                }
                for (num = 0; num < 4; num++)
                {
                    for (int n = 4; n < 6; n++)
                    {
                        this.curpl = this.curpl + double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(10 + (num * 6)) + n]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(10 + (num * 6)) + n]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + ",";
                        this.ballid = this.ballid + double.Parse(set.Tables[0].Rows[(10 + (num * 6)) + n]["id"].ToString().Trim()).ToString() + ",";
                        text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(10 + (num * 6)) + n]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[(10 + (num * 6)) + n]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        text2 = double.Parse(set.Tables[0].Rows[(10 + (num * 6)) + n]["id"].ToString().Trim()).ToString();
                        this.MainTable1.Rows[num + 8].Cells[((3 * n) + 2) - 13].InnerHtml = "<FONT style=\"FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000\">" + text + "</font>";
                    }
                }
                this.ballid = this.ballid.Substring(0, this.ballid.Length - 1);
                this.curpl = this.curpl.Substring(0, this.curpl.Length - 1);
                base2.Dispose();
                this.gTime = this.kaisai;
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
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["kaisai"].ToString().Trim();
                }
                reader.Close();
                string sql = "SELECT member.userid,member.username,member.usemoney,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,";
                sql = (sql + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11," + "userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXC15,userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC28,userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3,userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,") + "userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,userhs.MAXZ14,userhs.MAXZ15,userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ28 FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid = " + this.Session.Contents["userid"].ToString().Trim() + " AND member.isuseable=1";
                reader = base2.ExecuteReader(sql);
                if (!reader.Read())
                {
                    this.curmoney = "0";
                    this.singlebet = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
                    this.singlegame = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
                    reader.Close();
                }
                else
                {
                    this.curmoney = reader["curmoney"].ToString().Trim();
                    this.singlebet = "0," + reader["Maxz2"].ToString().Trim() + "," + reader["Maxz2"].ToString().Trim() + "," + reader["Maxz3"].ToString().Trim() + "," + reader["Maxz3"].ToString().Trim() + "," + reader["Maxz4"].ToString().Trim() + "," + reader["Maxz4"].ToString().Trim() + "," + reader["Maxz5"].ToString().Trim() + "," + reader["Maxz5"].ToString().Trim() + "," + reader["Maxz6"].ToString().Trim() + "," + reader["Maxz6"].ToString().Trim();
                    for (int i = 0; i < 12; i++)
                    {
                        this.singlebet = this.singlebet + "," + reader["Maxz19"].ToString().Trim();
                    }
                    for (int j = 0; j < 12; j++)
                    {
                        this.singlebet = this.singlebet + reader["Maxz20"].ToString().Trim();
                    }
                    this.singlegame = "0," + reader["Maxc2"].ToString().Trim() + "," + reader["Maxc2"].ToString().Trim() + "," + reader["Maxc3"].ToString().Trim() + "," + reader["Maxc3"].ToString().Trim() + "," + reader["Maxc4"].ToString().Trim() + "," + reader["Maxc4"].ToString().Trim() + "," + reader["Maxc5"].ToString().Trim() + "," + reader["Maxc5"].ToString().Trim() + "," + reader["Maxc6"].ToString().Trim() + "," + reader["Maxc6"].ToString().Trim();
                    for (int k = 0; k < 12; k++)
                    {
                        this.singlegame = this.singlegame + "," + reader["Maxc19"].ToString().Trim();
                    }
                    for (int m = 0; m < 12; m++)
                    {
                        this.singlegame = this.singlegame + reader["Maxc20"].ToString().Trim();
                    }
                    reader.Close();
                }
                for (int n = 1; n < 0x23; n++)
                {
                    this.singlegames = this.singlegames + base2.ExecuteScalar("SELECT isnull(sum(tzmoney),0) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + n.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                }
                base2.Dispose();
                this.MainContent();
                this.DataBind();
            }
        }
    }
}

