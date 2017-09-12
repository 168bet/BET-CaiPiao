namespace newball.gd
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
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
            if (MyFunc.CheckUserLogin(1))
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                MyFunc.WriteUserEvent(db, this.Session.Contents["adminuserid"].ToString().Trim(), this.Session.Contents["adminusername"].ToString().Trim(), base.Request.UserHostAddress.Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), "0");
                MyTeam.OnlineList.OnlineList.DelUser(this.Session.Contents["adminusername"].ToString().Trim());
                db.Dispose();
            }
            MyFunc.goToLoginPage("../manager/");
            base.Response.End();
        }
    }
}

