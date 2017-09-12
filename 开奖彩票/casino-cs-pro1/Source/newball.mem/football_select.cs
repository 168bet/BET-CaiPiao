namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class football_select : Page
    {
        public string pathStr = "";
        protected HtmlTable tableSelect;

        private bool Findleague(string str, string name)
        {
            if (str != "")
            {
                string[] textArray = str.Split(new char[] { ',' });
                for (int i = 0; i < textArray.Length; i++)
                {
                    if (textArray[i].Trim() == name)
                    {
                        return true;
                    }
                }
                return false;
            }
            return true;
        }

        private string GetSessionLeague(string name)
        {
            string text = "";
            if ((this.Session.Contents[name] != null) && (this.Session.Contents[name].ToString().Trim() != ""))
            {
                text = this.Session.Contents[name].ToString().Trim();
            }
            return text;
        }

        private string GetTableName(string pathStr)
        {
            switch (pathStr)
            {
                case "football_d.aspx":
                    return "Ball_PL1view";

                case "football_g.aspx":
                    return "Ball_PL1view_zd";

                case "football_rqsbc.aspx":
                    return "Ball_PL2view";

                case "football_other.aspx":
                    return "Ball_PL3view";

                case "football_bqc.aspx":
                    return "Ball_PL5view";

                case "football_bd.aspx":
                    return "Ball_PL4view";

                case "football_bz.aspx":
                    return "Ball_PL6view";

                case "football_rqgg.aspx":
                    return "Ball_PL7view";

                case "football_ys.aspx":
                    return "Ball_PLYSview";

                case "football_sbgg.aspx":
                    return "ball_pl2view_gg";

                case "football_bdgg.aspx":
                    return "Ball_PL4view";
            }
            return "";
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
            string table = "";
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                if ((base.Request.QueryString["path"] != null) && (base.Request.QueryString["path"].ToString().Trim() != ""))
                {
                    this.pathStr = base.Request.QueryString["path"].ToString().Trim();
                    table = this.GetTableName(this.pathStr);
                    this.tableSelect.Rows[1].Cells[0].InnerHtml = this.SetBallList(table, this.pathStr);
                }
            }
            else
            {
                this.pathStr = base.Request.QueryString["path"].ToString().Trim();
                if (base.Request.Form["fr_league"] != null)
                {
                    this.SetSessionLeague(this.pathStr, base.Request.Form["fr_league"].ToString().Trim());
                }
                else
                {
                    this.Session.Contents[this.pathStr] = "";
                }
                base.Response.Redirect(this.pathStr);
            }
        }

        private string SetBallList(string table, string name)
        {
            if (table == "")
            {
                return "";
            }
            string sql = "SELECT DISTINCT matchname FROM " + table;
            string text2 = "";
            string str = this.GetSessionLeague(name);
            string text4 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                if (this.Findleague(str, reader["matchname"].ToString().Trim()))
                {
                    text4 = " checked";
                }
                else
                {
                    text4 = "";
                }
                string text6 = text2;
                text2 = text6 + "<tr bgcolor=#ffffff><td style='TEXT-ALIGN: left'><input type='checkbox' name='fr_league'" + text4 + " value=\"" + reader["matchname"].ToString().Trim() + "\">" + reader["matchname"].ToString().Trim() + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text2;
        }

        private void SetSessionLeague(string name, string str)
        {
            this.Session.Contents[name] = str;
        }
    }
}

