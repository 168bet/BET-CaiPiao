namespace newball.odds.odds
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
            MyFunc.isRefUrl();
            if (((this.Session.Contents["classid"] != null) && (this.Session.Contents["classid"].ToString().Trim() != "1")) && ((this.Session.Contents["classid"].ToString().Trim() != "2") && (this.Session.Contents["classid"].ToString().Trim() != "3")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if ((this.Session.Contents["adminclassid"] != null) && (this.Session.Contents["adminclassid"].ToString().Trim() != "5"))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if ((this.Session.Contents["classid"] == null) && (this.Session.Contents["adminclassid"] == null))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                this.ShowDefaultMsg();
            }
        }

        private string PrintToolBar(string classid)
        {
            switch (classid)
            {
                case "1":
                    return "<a href=balllist.aspx target=body_show>六合彩</a>  <a href=BallGoTime.aspx?type=8 target=body_show>修改陪率</a>  <a href=chgpsd.aspx target=body_show>修改密码</a>  <a href=bfuser.aspx target=body_show>比分员</a>  <A href=../subadmin/GameFen.aspx target=body_show>结算</A>  <A href=../subadmin/searchorder.aspx target=body_show>定单查询</A>  <A href=../subadmin/MatchOrder.aspx target=body_show>结算状况</A>  <A href=../subadmin/mgrConfiglist.aspx target=body_show>公告</A>";

                case "3":
                    return "<a href=balllist.aspx target=body_show>六合彩</a>  <a href=BallGoTime.aspx?type=8 target=body_show>修改陪率</a>  <a href=chgpsd.aspx target=body_show>修改密码</a>";

                case "2":
                    return "<a href=balllist.aspx target=body_show>六合彩</a>  <a href=BallGoTime.aspx?type=8 target=body_show>修改陪率</a>  <a href=chgpsd.aspx target=body_show>修改密码</a>  <a href=bfuser.aspx target=body_show>比分员</a>  <A href=../subadmin/MatchOrder.aspx target=body_show>结算状况</A>  <A href=../subadmin/mgrConfiglist.aspx target=body_show>公告</A>";
            }
            return "";
        }

        private void ShowDefaultMsg()
        {
            this.LabelLoginUserName.Text = this.Session.Contents["username"].ToString().Trim();
            this.TD_ToolBar.Rows[0].Cells[0].InnerHtml = this.PrintToolBar(this.Session.Contents["classid"].ToString().Trim());
        }
    }
}

