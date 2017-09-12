namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class subchgpwd : Page
    {
        protected TextBox newPwd1;
        protected TextBox newPwd2;
        protected Button submit;

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
            if (!MyFunc.CheckUserLogin(2))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }

        private void submit_Click(object sender, EventArgs e)
        {
            if ((this.newPwd1.Text.Trim() == "") || (this.newPwd2.Text.Trim() == ""))
            {
                MyFunc.showmsg("密码不能为空！");
                base.Response.End();
            }
            else if (this.newPwd1.Text.Trim() != this.newPwd2.Text.Trim())
            {
                MyFunc.showmsg("两次输入的密码不同！");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE subAgence SET subpass='" + this.newPwd1.Text.Trim() + "' WHERE subid='" + this.Session["adminsubid"].ToString() + "'");
                this.Session.Contents["adminsubpass"] = this.newPwd1.Text.Trim();
                base2.CloseConnect();
                base2.Dispose();
                MyFunc.showmsg("密码修改成功！");
            }
        }
    }
}

