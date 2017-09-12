namespace newball.dls
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class subfrmIndex : Page
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
            if (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2))
            {
                MyFunc.goToLoginPage("../manager/");
                base.Response.End();
            }
        }
    }
}

