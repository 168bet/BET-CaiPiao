namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;

    public class subquit : Page
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
            if (MyFunc.CheckUserLogin(2))
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                MyFunc.WriteUserEvent(db, this.Session.Contents["adminsubid"].ToString(), this.Session.Contents["adminsubname"].ToString(), base.Request.UserHostAddress.ToString(), this.Session.Contents["adminsubclassid"].ToString(), "0");
                MyTeam.OnlineList.OnlineList.DelUser(this.Session.Contents["adminsubname"].ToString().Trim());
                db.CloseConnect();
                db.Dispose();
            }
            MyFunc.goToLoginPage("../manager/");
            base.Response.End();
        }
    }
}

