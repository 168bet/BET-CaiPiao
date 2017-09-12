namespace newball.odds.odds
{
    using MyTeam.Functions;
    using System;
    using System.Web.UI;

    public class main : Page
    {
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
            if (!MyFunc.CheckUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

