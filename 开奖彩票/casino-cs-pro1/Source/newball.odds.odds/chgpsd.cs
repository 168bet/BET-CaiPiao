namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class chgpsd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonOk;
        protected TextBox TextBoxOldPsd;
        protected TextBox TextBoxUserPass1;
        protected TextBox TextBoxUserPass2;

        private void ButtonOk_Click(object sender, EventArgs e)
        {
            string text = this.Session.Contents["userid"].ToString().Trim();
            string text2 = this.TextBoxOldPsd.Text.Trim();
            string text3 = this.TextBoxUserPass1.Text.Trim();
            string text4 = this.TextBoxUserPass2.Text.Trim();
            if (((text2 == "") || (text3 == "")) || (text4 == ""))
            {
                MyFunc.showmsg("请输入密码和新密码");
                base.Response.End();
            }
            else if (text3 != text4)
            {
                MyFunc.showmsg("输入的密码不同");
                base.Response.End();
            }
            else if (!MyFunc.CheckUserLogin(0) || (this.Session.Contents["userpass"].ToString().Trim() != text2))
            {
                MyFunc.showmsg("输入的密码错误");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (base2.ExecuteNonQuery("UPDATE pluser SET userpass='" + text3 + "' WHERE userid=" + this.Session.Contents["userid"].ToString().Trim()) > 0)
                {
                    this.Session.Contents["userpass"] = text3;
                    MyFunc.showmsg("修改密码成功");
                    base.Response.End();
                }
                else
                {
                    MyFunc.showmsg("修改密码失败");
                    base.Response.End();
                }
            }
        }

        private void InitializeComponent()
        {
            this.ButtonOk.Click += new EventHandler(this.ButtonOk_Click);
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
            if (!MyFunc.CheckUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
        }
    }
}

