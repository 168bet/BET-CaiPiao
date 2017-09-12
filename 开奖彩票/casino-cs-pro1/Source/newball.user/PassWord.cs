namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class PassWord : Page
    {
        protected Button ButtonPost;
        protected TextBox TextBoxNewPass1;
        protected TextBox TextBoxNewPass2;
        protected TextBox TextBoxOldPass;

        private void ButtonPost_Click(object sender, EventArgs e)
        {
            string text = this.TextBoxOldPass.Text.Trim();
            string text2 = this.TextBoxNewPass1.Text.Trim();
            string text3 = this.TextBoxNewPass2.Text.Trim();
            if (((text == "") || (text2 == "")) || (text3 == ""))
            {
                MyFunc.showmsg("请输入旧密码和要修改的新密码");
                base.Response.End();
            }
            else if (text2 != text3)
            {
                MyFunc.showmsg("输入的新密码不相同");
                base.Response.End();
            }
            else if (!MyFunc.CheckUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.Contents["userpass"].ToString().Trim(), "20", 0))
            {
                MyFunc.showmsg("输入的密码错误!");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (base2.ExecuteNonQuery("UPDATE member SET userpass='" + text2 + "' WHERE userid=" + this.Session.Contents["userid"].ToString().Trim()) > 0)
                {
                    this.Session.Contents["userpass"] = text2;
                    base2.Dispose();
                    MyFunc.JumpPage("修改密码成功", "PassWord.aspx");
                    base.Response.End();
                }
                else
                {
                    base2.Dispose();
                    MyFunc.showmsg("修改密码失败");
                    base.Response.End();
                }
            }
        }

        private void InitializeComponent()
        {
            this.ButtonPost.Click += new EventHandler(this.ButtonPost_Click);
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
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

