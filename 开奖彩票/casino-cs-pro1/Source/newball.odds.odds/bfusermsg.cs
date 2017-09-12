namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class bfusermsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonOk;
        protected DropDownList DropDownListIsuseable;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUserid;
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
                string text7 = "";
                string text = this.TextBoxUserid.Text.Trim();
                string text2 = this.TextBoxUserName.Text.Trim();
                string text3 = this.TextBoxUserPass1.Text.Trim();
                string text4 = this.TextBoxUserPass2.Text.Trim();
                string text5 = this.TextBoxTrueName.Text.Trim();
                string text6 = this.DropDownListIsuseable.SelectedValue.Trim();
                if (text2 == "")
                {
                    MyFunc.showmsg("请输选择要修改的比分员");
                    base.Response.End();
                }
                else
                {
                    if ((text3 != "") || (text4 != ""))
                    {
                        if (text3 != text4)
                        {
                            MyFunc.showmsg("输入的密码不同");
                            base.Response.End();
                            return;
                        }
                        text7 = ",userpass='" + text3 + "'";
                    }
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    if (int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM pluser WHERE userid=" + text).ToString()) == 0)
                    {
                        base2.Dispose();
                        MyFunc.showmsg("没有该比分员");
                        base.Response.End();
                    }
                    else if (base2.ExecuteNonQuery("UPDATE pluser SET truename='" + text5 + "'" + text7 + ",isuseable=" + text6 + " WHERE userid=" + text) > 0)
                    {
                        base2.Dispose();
                        MyFunc.JumpPage("修改比分员成功", "bfuser.aspx");
                        base.Response.End();
                    }
                    else
                    {
                        base2.Dispose();
                        MyFunc.showmsg("修改比分员失败");
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
            else if ((!base.IsPostBack && (base.Request.QueryString["userid"] != null)) && (base.Request.QueryString["userid"].ToString().Trim() != ""))
            {
                string text = base.Request.QueryString["userid"].ToString().Trim().Replace(" ", "").Replace("'", "");
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT * FROM PLUSER WHERE userid=" + text);
                if (reader.Read())
                {
                    this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                    this.TextBoxUserPass1.Text = "";
                    this.TextBoxUserPass2.Text = "";
                    this.TextBoxUserid.Text = reader["userid"].ToString().Trim();
                    this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                    this.DropDownListIsuseable.SelectedValue = (reader["isuseable"].ToString().Trim().ToUpper() == "TRUE") ? "1" : "0";
                    reader.Close();
                    base2.Dispose();
                }
                else
                {
                    reader.Close();
                    base2.Dispose();
                    MyFunc.showmsg("没有该用户");
                    base.Response.End();
                }
            }
        }
    }
}

