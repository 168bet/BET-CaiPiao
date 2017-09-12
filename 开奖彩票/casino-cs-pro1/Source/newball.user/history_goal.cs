namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class history_goal : Page
    {
        public string kyglList = "";
        public string kyglTeam = "";

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
            else if ((!base.IsPostBack && (base.Request.QueryString["bid"] != null)) && (base.Request.QueryString["bid"].ToString().Trim() != ""))
            {
                string text = base.Request.QueryString["bid"].ToString().Trim().Replace(" ", "").Replace("'", "");
                string text2 = "";
                string text3 = "";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT TOP 1 team1,team2 FROM ball_pl1 WHERE ballid=" + text);
                if (reader.Read())
                {
                    text2 = reader["team1"].ToString().Trim();
                    text3 = reader["team2"].ToString().Trim();
                    this.kyglTeam = text2 + " VS " + text3;
                }
                reader.Close();
                reader = base2.ExecuteReader("SELECT * FROM Ball_PL1_Fen WHERE ballid=" + text + " ORDER BY updatetime");
                while (reader.Read())
                {
                    string kyglList = this.kyglList;
                    this.kyglList = kyglList + "<tr><td width=80 align=center>" + reader["fen1"].ToString().Trim() + ":" + reader["fen2"].ToString().Trim() + "</td><td width=220>" + DateTime.Parse(reader["updatetime"].ToString().Trim()).ToString("yyyy-MM-dd HH:mm:ss") + "</td></tr>";
                }
                reader.Close();
                if (this.kyglList == "")
                {
                    this.kyglList = "<tr><td colspan=2>没有入球记录</td></tr>";
                }
                string text4 = base2.ExecuteScalar("SELECT fen2 FROM ball_bf WHERE ballid=" + text).ToString();
                this.kyglList = this.kyglList + "<tr><td align=center width=80>全场比分</td><td with=220 align=center>&nbsp;" + text4 + "&nbsp;</td></tr>";
                base2.Dispose();
                this.DataBind();
            }
        }
    }
}

