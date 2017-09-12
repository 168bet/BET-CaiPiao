namespace newball.dls
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
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
            else if (MyFunc.CheckUserLogin(this.Session["adminusername"].ToString(), this.Session["adminuserpass"].ToString(), this.Session["adminclassid"].ToString(), 1) && MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                if (this.Session.Contents["adminsubname"] != null)
                {
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    base2.ExecuteNonQuery("update subAgence set subpass='" + this.newPwd1.Text.Trim() + "' where userid='" + this.Session["adminuserid"].ToString() + "' and subid='" + this.Session["adminsubid"].ToString() + "'");
                    this.Session.Contents["adminsubpass"] = this.newPwd1.Text.Trim();
                    base2.CloseConnect();
                    base2.Dispose();
                    MyFunc.showmsg("密码修改成功！");
                }
                else
                {
                    DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                    base3.ExecuteNonQuery("update agence set userpass='" + this.newPwd1.Text.Trim() + "' where userid='" + this.Session["adminuserid"].ToString() + "' and username='" + this.Session["adminusername"].ToString() + "'");
                    this.Session.Contents["adminuserpass"] = this.newPwd1.Text.Trim();
                    base3.CloseConnect();
                    base3.Dispose();
                    MyFunc.showmsg("密码修改成功！");
                }
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

