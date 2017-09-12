namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class imp_rules : Page
    {
        protected HtmlForm Form2;
        public string msg;
        protected HtmlInputButton Submit1;
        protected HtmlInputButton Submit2;

        private void InitializeComponent()
        {
            this.Submit1.ServerClick += new EventHandler(this.Submit1_ServerClick);
            this.Submit2.ServerClick += new EventHandler(this.Submit2_ServerClick);
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
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                }
                reader.Close();
                base2.Dispose();
                this.DataBind();
            }
        }

        private void Submit1_ServerClick(object sender, EventArgs e)
        {
            base.Response.Redirect("quit.aspx");
            base.Response.End();
        }

        private void Submit2_ServerClick(object sender, EventArgs e)
        {
            base.Response.Redirect("system.aspx");
            base.Response.End();
        }
    }
}

