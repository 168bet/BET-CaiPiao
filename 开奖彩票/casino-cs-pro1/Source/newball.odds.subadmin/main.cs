namespace newball.odds.subadmin
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
            if (this.Session.Contents["adminclassid"].ToString().Trim() != "5")
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

