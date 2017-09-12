namespace newball.subuser
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class announcement_page : Page
    {
        public string kyglContent = "";
        public static int lang = 0;
        public static string[][] language = new string[3][];

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
            if ((!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1)) && (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2)))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                lang = int.Parse(this.Session.Contents["lang"].ToString().Trim());
                for (int i = 0; i < 3; i++)
                {
                    language[i] = new string[3];
                }
                language[0][0] = "消息";
                language[0][1] = "序";
                language[0][2] = "如何安装";
                language[1][0] = "消息";
                language[1][1] = "序";
                language[1][2] = "如何安裝";
                language[2][0] = "Announcement";
                language[2][1] = "No.";
                language[2][2] = "How To Setup?";
                this.DataBind();
                if (!base.IsPostBack)
                {
                    this.kyglContent = "";
                    int num2 = 1;
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    SqlDataReader reader = base2.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime," + this.Session.Contents["team"].ToString().Trim() + "content FROM affiche WHERE le=2 ORDER BY updatetime DESC");
                    while (reader.Read())
                    {
                        string kyglContent = this.kyglContent;
                        string[] textArray = new string[] { kyglContent, "<TR class=hover><TD width=\"5%\">", num2++.ToString(), "</TD><TD class=tdl>", reader[this.Session.Contents["team"].ToString().Trim() + "content"].ToString().Trim(), "</TD></TR>" };
                        this.kyglContent = string.Concat(textArray);
                    }
                    reader.Close();
                    base2.Dispose();
                    this.DataBind();
                }
            }
        }
    }
}

