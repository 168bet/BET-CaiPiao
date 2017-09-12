namespace newball.odds.odds
{
    using MyTeam.Functions;
    using System;
    using System.Web.UI;

    public class quit : Page
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
            MyFunc.goToLoginPage("../index.htm");
            base.Response.End();
        }
    }
}

