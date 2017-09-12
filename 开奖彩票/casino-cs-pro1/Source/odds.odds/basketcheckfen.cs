namespace odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class basketcheckfen : Page
    {
        public string kyglContent = "";
        public string kyglSelDay = "";
        protected DropDownList SelectDay;

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
                    text = text + "未输入";
                }
                else
                {
                    text = text + reader["fen2"].ToString().Trim();
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
                for (int i = 0; i < 7; i++)
                {
                    this.SelectDay.Items.Add(new ListItem(DateTime.Today.AddDays((double) -i).ToShortDateString() + " " + MyFunc.DayToWeek(DateTime.Today.AddDays((double) -i)), DateTime.Today.AddDays((double) -i).ToShortDateString()));
                }
                this.kyglSelDay = this.SelectDay.Items[0].Value;
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
    }
}

