namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class addbfuser : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonOk;
        protected DropDownList DropDownListIsuseable;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUserName;
        protected TextBox TextBoxUserPass1;
        protected TextBox TextBoxUserPass2;

        private void ButtonOk_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                string text = this.TextBoxUserName.Text.Trim();
                string text2 = this.TextBoxUserPass1.Text.Trim();
                string text3 = this.TextBoxUserPass2.Text.Trim();
                string text4 = this.TextBoxTrueName.Text.Trim();
                string text5 = this.DropDownListIsuseable.SelectedValue.Trim();
                if (((text == "") || (text2 == "")) || (text3 == ""))
                {
                    MyFunc.showmsg("请输入比分员帐号和密码");
                    base.Response.End();
                }
                else if (text2 != text3)
                {
                    MyFunc.showmsg("输入的密码不同");
                    base.Response.End();
                }
                else
                {
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    if (int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM pluser WHERE username='" + text + "'").ToString()) != 0)
                    {
                        base2.Dispose();
                        MyFunc.showmsg("已存在该用户帐号");
                        base.Response.End();
                    }
                    else if (base2.ExecuteNonQuery("INSERT INTO pluser(username,userpass,truename,isuseable,classid) VALUES('" + text + "','" + text2 + "','" + text4 + "'," + text5 + ",3)") > 0)
                    {
                        base2.Dispose();
                        MyFunc.JumpPage("添加比分员成功", "bfuser.aspx");
                        base.Response.End();
                    }
                    else
                    {
                        base2.Dispose();
                        MyFunc.showmsg("添加比分员失败");
                        base.Response.End();
                    }
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

