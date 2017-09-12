namespace newball.user
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class header : Page
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
                this.DataBind();
            }
        }
    }
}

