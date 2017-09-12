namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class mgrgame : Page
    {
        public string kyglContent = "";
        public string refreshtime = "-1";
        private DateTime startTime;
        public string tmpsdinfo = "";

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OpenGame(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=1 WHERE ballid=" + ballid);
            base2.Dispose();
        }

        private void Page_Load(object sender, EventArgs e)
        {
            this.startTime = DateTime.Now;
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() != ""))
                {
                    string ballid = base.Request.QueryString["ballid"].ToString().Trim().Replace(" ", "").Replace("'", "").Replace("%", "");
                    if (base.Request.QueryString["action"].ToString().Trim() == "stop")
                    {
                        this.StopGame(ballid);
                    }
                    else if (base.Request.QueryString["action"].ToString().Trim() == "open")
                    {
                        this.OpenGame(ballid);
                    }
                }
                string sql = "SELECT Ball_PL1.ballid,Ball_PL1.balltime,Ball_PL1.matchname,Ball_PL1.matchcolor,Ball_PL1.team1,Ball_PL1.team2, Ball_PL1.homeway,Ball_PL1.isautoshow,Ball_PL1.iszd,";
                sql = sql + "Ball_PL1.iscurzd,Ball_PL1.iszdclose,Ball_PL1.iszddt,Ball_BF.isshow,Ball_BF.isclose,Ball_BF.iscancel FROM Ball_BF RIGHT OUTER JOIN Ball_PL1 ON Ball_BF.ballid = Ball_PL1.ballid WHERE (Ball_PL1.isautoshow = 1)";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    string kyglContent = this.kyglContent;
                    this.kyglContent = kyglContent + "<tr bgcolor=\"#FFFFFF\"><td>" + reader["balltime"].ToString().Trim() + "</td><td><span style=\"background-color:" + reader["matchcolor"].ToString().Trim() + "; color: '#ffffff';\">" + reader["matchname"].ToString().Trim() + "</font></td><td>" + reader["team1"].ToString().Trim() + "&nbsp;<font color=red>" + reader["homeway"].ToString().Trim() + "</font><br>" + reader["team2"].ToString().Trim() + "</td><td>";
                    if (reader["iscurzd"].ToString().Trim().ToUpper() == "TRUE")
                    {
                        this.kyglContent = this.kyglContent + "当前走地";
                    }
                    else if (reader["iszd"].ToString().Trim().ToUpper() == "TRUE")
                    {
                        this.kyglContent = this.kyglContent + "走地";
                    }
                    else
                    {
                        this.kyglContent = this.kyglContent + "&nbsp;";
                    }
                    this.kyglContent = this.kyglContent + "</td><td>";
                    if (reader["isshow"].ToString().Trim().ToUpper() == "TRUE")
                    {
                        this.kyglContent = this.kyglContent + "收单";
                    }
                    else
                    {
                        this.kyglContent = this.kyglContent + "停止";
                    }
                    string text4 = this.kyglContent;
                    this.kyglContent = text4 + "</td><td><a href=mgrgame.aspx?action=stop&ballid=" + reader["ballid"].ToString().Trim() + ">停押</a> / <a href=mgrgame.aspx?action=open&ballid=" + reader["ballid"].ToString().Trim() + ">启用</a></td></tr>";
                }
                reader.Close();
                base2.Dispose();
                this.DataBind();
            }
        }

        protected override void Render(HtmlTextWriter writer)
        {
            base.Render(writer);
            DateTime now = DateTime.Now;
            base.Response.Write("done in " + ((TimeSpan) (now - this.startTime)));
        }

        private void StopGame(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=0 WHERE ballid=" + ballid);
            base2.Dispose();
        }
    }
}

