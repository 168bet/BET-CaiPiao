namespace newball
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class select_league : Page
    {
        public string kygl = "";
        protected HtmlTable MainTable;

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

        private string FormatLeague(string str)
        {
            string[] textArray = str.Split(new char[] { ',' });
            string text = "";
            for (int i = 0; i < textArray.Length; i++)
            {
                text = "'" + textArray[i] + "',";
            }
            if (text != "")
            {
                text = text.Remove(text.Length - 1, 1);
            }
            return text;
        }

        private string GetLeague(string table, string name)
        {
            if (table == "")
            {
                return "";
            }
            string sql = "SELECT DISTINCT matchname FROM " + table + " WHERE isautoshow=1";
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
                text2 = text6 + "<tr><td style='TEXT-ALIGN: left'><input type='checkbox' name='fr_league'" + text4 + " value=\"" + reader["matchname"].ToString().Trim() + "\">" + reader["matchname"].ToString().Trim() + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text2;
        }

        private string GetSessionLeague(string name)
        {
            string text = "";
            if ((this.Session.Contents["kygl" + name] != null) && (this.Session.Contents["kygl" + name].ToString().Trim() != ""))
            {
                text = this.Session.Contents["kygl" + name].ToString().Trim();
            }
            return text;
        }

        private string GetTableName(string str)
        {
            switch (str)
            {
                case "AH":
                    return "Ball_PL1view";

                case "RAH":
                    return "Ball_PL1View_zd";

                case "EARLY":
                    return "Ball_Pl8view_early";

                case "AHHT":
                    return "Ball_PL2View";

                case "OTHER":
                    return "Ball_PL3View";

                case "CS":
                    return "Ball_PL4View";

                case "CSP":
                    return "Ball_PL4View";

                case "HT":
                    return "Ball_PL5View";

                case "1X2PARLAY":
                    return "Ball_PL6View";

                case "AHP":
                    return "Ball_PL7View";

                case "HTP":
                    return "Ball_Pl2view";
            }
            return "";
        }

        private string GetUrl(string str)
        {
            switch (str)
            {
                case "AH":
                    return "betting-matches.aspx?gt=ah";

                case "RAH":
                    return "betting-matches.aspx?gt=rah";

                case "EARLY":
                    return "betting-matches.aspx?gt=early";

                case "AHHT":
                    return "betting-matches-ahht.aspx?gt=ahht";

                case "OTHER":
                    return "betting-matches-other.aspx";

                case "CS":
                    return "betting-matches-cs.aspx";

                case "CSP":
                    return "betting-matches-csparlay.aspx";

                case "HT":
                    return "betting-matches-ht.aspx";

                case "1X2PARLAY":
                    return "betting-matches-1x2parlay.aspx";

                case "AHP":
                    return "betting-matches-ahparlay.aspx";

                case "HTP":
                    return "betting-matches-htparlay.aspx";
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
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                string table = "";
                string url = "";
                if ((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() != ""))
                {
                    this.kygl = base.Request.Form["action"].ToString().Trim();
                    if (base.Request.Form["fr_league"] != null)
                    {
                        this.SetSessionLeague(base.Request.Form["action"].ToString().Trim(), base.Request.Form["fr_league"].ToString().Trim());
                        url = this.GetUrl((base.Request.Form["action"].ToString().Trim() == "") ? "AH" : base.Request.Form["action"].ToString().Trim());
                        base.Response.Redirect(url);
                    }
                }
                if ((base.Request.QueryString["kygl"] != null) && (base.Request.QueryString["kygl"].ToString().Trim() != ""))
                {
                    this.kygl = base.Request.QueryString["kygl"].ToString().Trim().ToUpper();
                    table = this.GetTableName(this.kygl);
                    this.MainTable.Rows[1].Cells[0].InnerHtml = this.GetLeague(table, this.kygl);
                    this.DataBind();
                }
            }
        }

        private void SetSessionLeague(string name, string str)
        {
            this.Session.Contents["kygl" + name] = str;
        }
    }
}

