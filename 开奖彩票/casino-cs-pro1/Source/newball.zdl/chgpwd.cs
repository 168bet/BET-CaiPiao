namespace newball.zdl
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class chgpwd : Page
    {
        protected TextBox newPwd1;
        protected TextBox newPwd2;
        protected Button submit;
        protected TextBox TextBoxOldPsd;

        private void InitializeComponent()
        {
            this.submit.Click += new EventHandler(this.submit_Click);
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
        }

        private void submit_Click(object sender, EventArgs e)
        {
            if (this.TextBoxOldPsd.Text.Trim() == "")
            {
                MyFunc.showmsg("请输入旧密码");
                base.Response.End();
            }
            else if ((this.newPwd1.Text.Trim() == "") || (this.newPwd2.Text.Trim() == ""))
            {
                MyFunc.showmsg("新密码不能为空！");
                base.Response.End();
            }
            else if (this.newPwd1.Text.Trim() != this.newPwd2.Text.Trim())
            {
                MyFunc.showmsg("两次输入的密码不同！");
                base.Response.End();
            }
            else if (this.Session.Contents["adminuserpass"].ToString().Trim() != this.TextBoxOldPsd.Text.Trim())
            {
                MyFunc.showmsg("密码错误");
                base.Response.End();
            }
            else if (MyFunc.CheckUserLogin(this.Session["adminusername"].ToString(), this.Session["adminuserpass"].ToString(), this.Session["adminclassid"].ToString(), 1))
            {
                string sql = "update agence set userpass='" + this.newPwd1.Text.Trim() + "' where userid='" + this.Session["adminuserid"].ToString() + "' and username='" + this.Session["adminusername"].ToString() + "'";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery(sql);
                this.Session.Contents["adminuserpass"] = this.newPwd1.Text.Trim();
                base2.CloseConnect();
                base2.Dispose();
                MyFunc.showmsg("密码修改成功！");
            }
            else
            {
                MyFunc.showmsg("可能超时或还没有登入！");
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

