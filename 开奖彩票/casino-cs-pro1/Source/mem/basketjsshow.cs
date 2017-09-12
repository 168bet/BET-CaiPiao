namespace mem
{
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class basketjsshow : Page
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
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
                    if ((base.Request.QueryString["basketthisdate"] != null) && (base.Request.QueryString["basketthisdate"].ToString().Trim() != ""))
                    {
                        this.kyglThisdate = base.Request.QueryString["basketthisdate"].ToString().Trim();
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

