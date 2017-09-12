namespace newball.mem
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class BallJs : Page
    {
        public string kyglBallid = "";
        public string kyglJstype = "";
        public string kyglThisdate = "";

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
            if ((!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1)) || !MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage();
            }
            else if (!base.IsPostBack)
            {
                if ((base.Request.QueryString["ballid"] != null) && (base.Request.QueryString["ballid"].ToString().Trim() != ""))
                {
                    this.kyglBallid = base.Request.QueryString["ballid"].ToString().Trim();
                    if ((base.Request.QueryString["jstype"] != null) && (base.Request.QueryString["jstype"].ToString().Trim() != ""))
                    {
                        this.kyglJstype = base.Request.QueryString["jstype"].ToString().Trim();
                    }
                    if ((base.Request.QueryString["thisdate"] != null) && (base.Request.QueryString["thisdate"].ToString().Trim() != ""))
                    {
                        this.kyglThisdate = base.Request.QueryString["thisdate"].ToString().Trim();
                    }
                    this.DataBind();
                }
                else
                {
                    MyFunc.showmsg("请选择要结算的球赛");
                    base.Response.End();
                }
            }
        }
    }
}

