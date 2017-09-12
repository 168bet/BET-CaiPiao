namespace newball.subuser
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class myReportForm : Page
    {
        protected HtmlInputText endTime;
        protected DropDownList reportType;
        protected Button searchButton;
        protected Label showAlready;
        protected Label showNo;
        protected Label showTime1;
        protected Label showTime2;
        protected HtmlInputText startTime;
        protected DropDownList tzCase;
        protected DropDownList tzType;

        private void InitializeComponent()
        {
            this.ID = "myReportForm";
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
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.startTime.Value = DateTime.Today.ToShortDateString();
                this.endTime.Value = DateTime.Today.ToShortDateString();
                this.showTime1.Text = DateTime.Today.ToShortDateString();
                this.showTime2.Text = DateTime.Today.ToShortDateString();
                this.showAlready.Text = "[全部比数已输入完毕]";
                this.showNo.Text = "[<font color=red>比数还没有输入完毕</font>]";
            }
            else
            {
                this.searchDeal();
            }
        }

        private void searchDeal()
        {
            string path = "reportShow.aspx?search=search";
            path = ((((path + "&startTime=" + this.startTime.Value) + "&endTime=" + this.endTime.Value) + "&reportType=" + this.reportType.SelectedValue) + "&tzCase=" + this.tzCase.SelectedValue) + "&tzType=" + this.tzType.SelectedValue;
            base.Server.Transfer(path);
        }
    }
}

