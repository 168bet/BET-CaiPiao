namespace newball.dls
{
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class frmheader : Page
    {
        protected Label LabelLoginUserName;
        protected HtmlTable TD_ToolBar;

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
            if (!MyFunc.CheckUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                this.ShowDefaultMsg();
            }
        }

        public void ShowDefaultMsg()
        {
            this.LabelLoginUserName.Text = this.Session.Contents["adminusername"].ToString().Trim();
            this.TD_ToolBar.Rows[0].Cells[0].InnerHtml = MyFunc.printHeaderToolBar(this.Session.Contents["adminclassid"].ToString().Trim());
        }
    }
}

