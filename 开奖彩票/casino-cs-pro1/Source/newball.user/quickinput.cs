namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Configuration;

    public class quickinput : Page
    {
        public string curmoney = "";
        public string isclose = "1";
        public string maxc = "";
        public string maxz = "";
        public string MinBet = ConfigurationSettings.AppSettings["MinBet"];
        public string pltype = "";
        public string rtype = "";
        public string singleGame = "0,";

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
                int num = 100;
                string[] textArray = null;
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = db.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,tupdatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    DateTime time;
                    if (base.Request.QueryString["rtype"].Trim() == "SP")
                    {
                        time = Convert.ToDateTime(reader["tupdatetime"].ToString().Trim());
                    }
                    else
                    {
                        time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                    }
                    TimeSpan span = time.Subtract(DateTime.Now);
                    num = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
                    this.isclose = reader["isclose"].ToString().Trim();
                }
                reader.Close();
                if ((num <= 0) || (this.isclose != "0"))
                {
                    base.Response.Redirect("betting-entry.aspx?action=null");
                }
                else
                {
                    switch (base.Request.QueryString["rtype"].Trim())
                    {
                        case "SP":
                            textArray = MyFunc.usermsg(this.Session.Contents["userid"].ToString().Trim(), db, "8");
                            this.pltype = "特别号";
                            this.rtype = "SP";
                            for (int i = 0x23; i < 0x54; i++)
                            {
                                this.singleGame = this.singleGame + db.ExecuteScalar("SELECT sum(tzmoney) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + i.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                            }
                            break;

                        case "NA":
                            textArray = MyFunc.usermsg(this.Session.Contents["userid"].ToString().Trim(), db, "9");
                            this.pltype = "正码";
                            this.rtype = "NA";
                            for (int j = 0x54; j < 0x85; j++)
                            {
                                this.singleGame = this.singleGame + db.ExecuteScalar("SELECT sum(tzmoney) FROM ball_order WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " and ballid=" + j.ToString() + " and datediff(day,updatetime,getdate())=0").ToString() + ",";
                            }
                            break;

                        default:
                            this.ErrorContent();
                            break;
                    }
                    this.curmoney = textArray[5];
                    this.maxc = textArray[7];
                    this.maxz = textArray[8];
                }
                db.Dispose();
                this.DataBind();
            }
        }
    }
}

