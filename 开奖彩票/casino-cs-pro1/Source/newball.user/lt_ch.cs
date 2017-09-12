namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class lt_ch : Page
    {
        public string gTime = "";
        public string isclose = "";
        public string kaisai = "";
        public string kygltable = "";
        public string msg = "";
        public string qishu = "";
        public string refreshtimer = "480000";

        private void AHHTContent()
        {
            string text = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                this.kygltable = "<td>赔率</td>";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=151 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + "<td>三全中 <font color=\"FF0000\"><b>" + text + "</b></font></td>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=152 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + " <td>中二 <font color=\"FF0000\"><b>" + text + "</b></font><br>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=153 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + " 中三 <font color=\"FF0000\"><b>" + text + "</b></font></td>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=154 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + "<td>二全中 <font color=\"#FF0000\"><b>" + text + "</b></font></td>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=155 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + "<td>中特 <font color=\"#FF0000\"><b>" + text + "</b></font><br>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=156 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + "中二 <font color=\"FF0000\"><b>" + text + "</b></font></td>";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=157 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = this.kygltable + "<td>特串 <font color=\"FF0000\"><b>" + text + "</b></font></td>";
                reader.Close();
                base2.Dispose();
                this.gTime = this.kaisai;
            }
            if (this.isclose == "1")
            {
                this.gTime = "";
            }
        }

        private void ErrorContent()
        {
            MyFunc.goToLoginPage();
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
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["kaisai"].ToString().Trim();
                    this.isclose = reader["isclose"].ToString();
                }
                reader.Close();
                base2.Dispose();
                this.AHHTContent();
                this.DataBind();
            }
        }
    }
}

