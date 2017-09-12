namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class chgpwd : Page
    {
        protected TextBox newPwd1;
        protected TextBox newPwd2;
        protected Button submit;
        protected TextBox TextBoxOldPassWord;

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
            if (this.Session.Contents["adminclassid"].ToString().Trim() != "5")
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }

        private void submit_Click(object sender, EventArgs e)
        {
            if (((this.TextBoxOldPassWord.Text.Trim() == "") || (this.newPwd1.Text.Trim() == "")) || (this.newPwd2.Text.Trim() == ""))
            {
                MyFunc.showmsg("请输入旧密码和新密码！");
                base.Response.End();
            }
            else if (this.newPwd1.Text.Trim() != this.newPwd2.Text.Trim())
            {
                MyFunc.showmsg("两次输入的密码不同！");
                base.Response.End();
            }
            else if (this.TextBoxOldPassWord.Text.Trim() == this.Session.Contents["adminuserpass"].ToString().Trim())
            {
                string sql = "update agence set userpass='" + this.newPwd1.Text.Trim() + "' where userid='" + this.Session["adminuserid"].ToString() + "'";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery(sql);
                this.Session.Contents["adminuserpass"] = this.newPwd1.Text.Trim();
                base2.CloseConnect();
                base2.Dispose();
                MyFunc.showmsg("密码修改成功！");
            }
            else
            {
                MyFunc.showmsg("密码错误！");
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

