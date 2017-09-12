namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class index : Page
    {
        protected Button ButtonLogin;
        protected TextBox TextBoxUserName;
        protected TextBox TextBoxUserPass;

        private void ButtonLogin_Click(object sender, EventArgs e)
        {
            string text = this.TextBoxUserName.Text.Trim().ToLower();
            string text2 = this.TextBoxUserPass.Text.Trim();
            string text3 = base.Request.UserHostAddress.Trim();
            string text4 = DateTime.Now.ToString().Trim();
            if ((text == "") || (text2 == ""))
            {
                MyFunc.showmsg("请输入帐号和密码!");
                base.Response.End();
            }
            else if ((text.Length > 15) || (text2.Length > 15))
            {
                MyFunc.showmsg("用户名或密码的长度不能超过15!");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,classid,gdid FROM agence WHERE username='" + text + "' AND classid=5 AND isuseable=1");
                if (!reader.Read())
                {
                    reader.Close();
                    base2.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                }
                else if ((text != reader["username"].ToString().Trim()) || (text2 != reader["userpass"].ToString().Trim()))
                {
                    reader.Close();
                    base2.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                }
                else
                {
                    this.Session.Contents["adminuserid"] = reader["userid"].ToString().Trim();
                    this.Session.Contents["adminusername"] = reader["username"].ToString().Trim();
                    this.Session.Contents["adminuserpass"] = reader["userpass"].ToString().Trim();
                    this.Session.Contents["adminsessid"] = this.Session.SessionID.ToString().Trim();
                    this.Session.Contents["adminclassid"] = reader["classid"].ToString().Trim();
                    string text5 = reader["gdid"].ToString().Trim();
                    reader.Close();
                    reader = base2.ExecuteReader("SELECT gdid FROM agence WHERE userid=" + text5);
                    if (reader.Read())
                    {
                        this.Session.Contents["usergsid"] = reader["gdid"].ToString().Trim();
                        reader.Close();
                    }
                    base2.Dispose();
                    base.Response.Redirect("frmindex.aspx");
                    base.Response.End();
                }
            }
        }

        private void InitializeComponent()
        {
            this.ButtonLogin.Click += new EventHandler(this.ButtonLogin_Click);
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
        }
    }
}

