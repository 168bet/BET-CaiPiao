namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class betting_matches_cs : Page
    {
        public string gTime = "";
        public string isclose = "";
        public string kaisai = "";
        public string kygltable = "";
        protected HtmlTable MainTable;
        public string msg = "";
        public string qishu = "";

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private void MainContent()
        {
            string text = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=230 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                this.kygltable = text;
                reader.Close();
                reader.Close();
                base2.Dispose();
                this.gTime = this.kaisai;
            }
            if (this.isclose == "1")
            {
                this.gTime = "";
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
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,tupdatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["tupdatetime"].ToString().Trim();
                    this.isclose = reader["isclose"].ToString();
                }
                reader.Close();
                base2.Dispose();
                this.MainContent();
                this.DataBind();
            }
        }
    }
}

