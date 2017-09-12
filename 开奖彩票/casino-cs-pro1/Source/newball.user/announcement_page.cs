namespace newball.user
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
            else if (!base.IsPostBack)
            {
                this.kyglContent = "";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    string kyglContent = this.kyglContent;
                    this.kyglContent = kyglContent + "<TR class=hover><TD width=\"11%\">" + reader["updatetime"].ToString().Trim() + "</TD><TD>" + MyFunc.ConvertStr(reader["content"].ToString().Trim()) + "</TD></TR>";
                }
                reader.Close();
                base2.Dispose();
                this.DataBind();
            }
        }
    }
}

