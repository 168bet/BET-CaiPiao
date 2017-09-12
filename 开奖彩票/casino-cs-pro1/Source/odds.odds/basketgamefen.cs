namespace odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class basketgamefen : Page
    {
        public string kyglContent = "";
        public string kyglSelDay = "";
        protected DropDownList SelectDay;

        private void BallCancel(string ballid, int flag)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (flag == 1)
                {
                    base2.ExecuteNonQuery("UPDATE Ball_BF SET iscancel=1 WHERE ballid  = " + ballid + " AND isBK = 1");
                }
                else
                {
                    base2.ExecuteNonQuery("UPDATE Ball_BF SET iscancel=0 WHERE ballid  = " + ballid + " AND isBK = 1");
                }
                base2.Dispose();
            }
        }

        private string GameList(string sday)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM Ball_BF WHERE isBK = 1 AND datediff(day,sortballtime,'" + sday + "')=0 ORDER BY sortballtime");
            string text = "";
            string text2 = "";
            string text3 = "";
            for (int i = 0; reader.Read(); i++)
            {
                if (reader["balltime"].ToString().Trim().ToLower().IndexOf("<br>") != -1)
                {
                    text3 = reader["balltime"].ToString().Trim().ToLower().Replace("<br>", " ").Split(new char[] { ' ' })[1];
                }
                else
                {
                    text3 = reader["balltime"].ToString().Trim();
                }
                if ((i % 2) == 0)
                {
                    text2 = "#FFFFFF";
                }
                else
                {
                    text2 = "#EBEBEB";
                }
                string text5 = text;
                string text6 = text5 + "<tr bgcolor=\"" + text2 + "\" OnMouseOut=\"this.bgColor='" + text2 + "';\" onMouseOver=\"this.bgColor='#cccccc';\"><td align=\"center\">" + text3 + "</td><td align=\"center\">" + reader["ballid"].ToString().Trim() + "</td><td>" + reader["matchname"].ToString().Trim() + "</td>";
                text = text6 + "<td>" + reader["team1"].ToString().Trim() + "</td><td>" + reader["team2"].ToString().Trim() + "</td><td align=\"center\">";
                if (reader["fen2"].ToString().Trim() == "")
                {
                    text = text + "<SPAN style=\"CURSOR: hand;\" onMouseOver=\"this.className='oo'\" onMouseOut=\"this.className='oo1'\" onclick=\"javascript:show_win('" + reader["ballid"].ToString().Trim() + "','2','','')\">未输入</span>";
                }
                else
                {
                    string text7 = text;
                    text = text7 + "<SPAN style=\"CURSOR: hand;\" onMouseOver=\"this.className='oo'\" onMouseOut=\"this.className='oo1'\" onclick=\"javascript:show_win('" + reader["ballid"].ToString().Trim() + "','2','" + reader["fen2"].ToString().Trim().Split(new char[] { ':' })[0] + "','" + reader["fen2"].ToString().Trim().Split(new char[] { ':' })[1] + "')\">" + reader["fen2"].ToString().Trim() + "</span>";
                }
                text = text + "</td><td align=center>";
                if (reader["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                {
                    string text8 = text;
                    text = text8 + "<a href=basketgamefen.aspx?action=open&ballid=" + reader["ballid"].ToString().Trim() + "&selday=" + sday + " onclick=\"return confirm('确定恢复赛事?将恢复本赛所有已取消的事订单!');\">恢复赛事</a>";
                }
                else
                {
                    string text9 = text;
                    text = text9 + "<a href=basketgamefen.aspx?action=close&ballid=" + reader["ballid"].ToString().Trim() + "&selday=" + sday + " onclick=\"return confirm('确定取消赛事?将取消所有本赛事订单!');\">取消赛事</a>";
                }
                text = text + "</td><td align=center>";
                if (reader["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                {
                    text = text + "<font color=red>赛事取消</font>";
                }
                else
                {
                    text = text + "&nbsp;";
                }
                text = text + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private void InitializeComponent()
        {
            this.SelectDay.SelectedIndexChanged += new EventHandler(this.SelectDay_SelectedIndexChanged);
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
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "open")) && ((base.Request.QueryString["ballid"] != null) && (base.Request.QueryString["ballid"].ToString().Trim() != "")))
                {
                    this.BallCancel(base.Request.QueryString["ballid"].ToString().Trim(), 0);
                }
                else if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "close")) && ((base.Request.QueryString["ballid"] != null) && (base.Request.QueryString["ballid"].ToString().Trim() != "")))
                {
                    this.BallCancel(base.Request.QueryString["ballid"].ToString().Trim(), 1);
                }
                else if (((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ffpost")) && ((base.Request.Form["ballid"] != null) && (base.Request.Form["ballid"].ToString().Trim() != ""))) && (((base.Request.Form["btype"] != null) && (base.Request.Form["btype"].ToString().Trim() != "")) && ((base.Request.Form["bf1"] != null) && (base.Request.Form["bf1"].ToString().Trim() != "")))) && ((base.Request.Form["bf2"] != null) && (base.Request.Form["bf2"].ToString().Trim() != "")))
                {
                    this.UpdateBf(base.Request.Form["ballid"].ToString().Trim(), base.Request.Form["btype"].ToString().Trim(), base.Request.Form["bf1"].ToString().Trim(), base.Request.Form["bf2"].ToString().Trim());
                }
                for (int i = 0; i < 7; i++)
                {
                    this.SelectDay.Items.Add(new ListItem(DateTime.Today.AddDays((double) -i).ToShortDateString() + " " + MyFunc.DayToWeek(DateTime.Today.AddDays((double) -i)), DateTime.Today.AddDays((double) -i).ToShortDateString()));
                }
                this.kyglSelDay = this.SelectDay.Items[0].Value;
                if ((base.Request.QueryString["selday"] != null) && (base.Request.QueryString["selday"].ToString().Trim() != ""))
                {
                    this.SelectDay.SelectedValue = base.Request.QueryString["selday"].ToString().Trim();
                    this.kyglSelDay = base.Request.QueryString["selday"].ToString().Trim();
                }
                if ((base.Request.Form["selday"] != null) && (base.Request.Form["selday"].ToString().Trim() != ""))
                {
                    this.SelectDay.SelectedValue = base.Request.Form["selday"].ToString().Trim();
                    this.kyglSelDay = base.Request.Form["selday"].ToString().Trim();
                }
                this.kyglContent = this.GameList(this.kyglSelDay);
                this.DataBind();
            }
        }

        private void SelectDay_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.kyglContent = this.GameList(this.SelectDay.SelectedValue);
            this.kyglSelDay = this.SelectDay.SelectedValue;
            this.DataBind();
        }

        private void UpdateBf(string ballid, string btype, string fen1, string fen2)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT fen1,fen2 FROM ball_bf WHERE ballid=" + ballid);
                string sql = "";
                if (reader.Read())
                {
                    if (btype == "2")
                    {
                        reader.Close();
                        sql = "UPDATE ball_bf SET fen2='" + fen1 + ":" + fen2 + "' WHERE ballid  = " + ballid + "  AND isBK = 1";
                        base2.ExecuteNonQuery(sql);
                        base2.Dispose();
                    }
                }
                else
                {
                    reader.Close();
                    base2.Dispose();
                }
            }
        }
    }
}

