namespace newball.subuser
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
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
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = null;
                reader = db.ExecuteReader("SELECT subid,userid,classid,subname,truename,subpass,isnull((select arrgd from agence where userid = subagence.userid),'-1') as arrgd FROM subAgence WHERE subname ='" + text + "' AND subpass ='" + text2 + "' AND isuseable=1");
                if (reader.Read())
                {
                    if ((text == reader["subname"].ToString().Trim()) && (text2 == reader["subpass"].ToString().Trim()))
                    {
                        this.Session.Contents["adminuserid"] = reader["userid"].ToString().Trim();
                        this.Session.Contents["adminsubclassid"] = reader["classid"].ToString().Trim();
                        this.Session.Contents["adminsubname"] = reader["subname"].ToString().Trim();
                        this.Session.Contents["adminsubid"] = reader["subid"].ToString().Trim();
                        this.Session.Contents["adminsubpass"] = reader["subpass"].ToString().Trim();
                        this.Session.Contents["adminsubsessid"] = this.Session.SessionID.ToString().Trim();
                        this.Session.Contents["adminarrgd"] = reader["arrgd"].ToString().Trim();
                        this.Session.Contents["adminusername"] = reader["subname"].ToString().Trim();
                        reader.Close();
                        string place = "";
                        string ip = "";
                        if (base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"] != null)
                        {
                            ip = base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim();
                            place = MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim()));
                        }
                        ip = ip + "|" + base.Request.UserHostAddress.ToString().Trim();
                        MyFunc.WriteUserEvent(db, this.Session.Contents["adminsubid"].ToString(), this.Session.Contents["adminsubname"].ToString(), base.Request.UserHostAddress.ToString(), this.Session.Contents["adminsubclassid"].ToString(), "1");
                        MyTeam.OnlineList.OnlineList.NewUserLogin(this.Session.Contents["adminsubname"].ToString(), this.Session.Contents["adminsubsessid"].ToString(), DateTime.Now.ToString(), ip, this.Session.Contents["adminsubclassid"].ToString(), place + "|" + MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.UserHostAddress.ToString().Trim())));
                        db.CloseConnect();
                        db.Dispose();
                        base.Response.Redirect("frmindex.aspx");
                        base.Response.End();
                        return;
                    }
                    reader.Close();
                }
                else
                {
                    reader.Close();
                    db.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                    return;
                }
                reader = db.ExecuteReader("SELECT userid,username,userpass,classid FROM agence WHERE username='" + text + "' AND classid=4 AND isuseable = 1");
                if (!reader.Read())
                {
                    reader.Close();
                    db.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                }
                else if ((text != reader["username"].ToString().Trim()) || (text2 != reader["userpass"].ToString().Trim()))
                {
                    reader.Close();
                    db.Dispose();
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
                    reader.Close();
                    reader = db.ExecuteReader("SELECT userid,username,userpass,classid,arrgd FROM agence WHERE userid='" + this.Session.Contents["adminuserid"].ToString() + "' AND classid=0 AND isuseable=1 and userid in (" + MyFunc.GetGongSiID().ToString() + ")");
                    if (reader.Read())
                    {
                        this.Session.Contents["adminarrgd"] = reader["arrgd"].ToString().Trim();
                    }
                    else
                    {
                        MyFunc.goToLoginPage();
                        base.Response.End();
                        return;
                    }
                    reader.Close();
                    string text8 = "";
                    string text9 = "";
                    string text10 = "";
                    if (base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"] != null)
                    {
                        text10 = base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim();
                        text8 = MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim()));
                    }
                    text10 = text10 + "|" + base.Request.UserHostAddress.ToString().Trim();
                    MyFunc.WriteUserEvent(db, this.Session.Contents["adminuserid"].ToString(), this.Session.Contents["adminusername"].ToString(), base.Request.UserHostAddress.Trim(), this.Session.Contents["adminclassid"].ToString(), "1");
                    text9 = MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.UserHostAddress.ToString().Trim()));
                    db.Dispose();
                    MyTeam.OnlineList.OnlineList.NewUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.SessionID.ToString().Trim(), DateTime.Now.ToString(), text10, this.Session.Contents["adminclassid"].ToString().Trim(), text8 + "|" + text9);
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
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if ((base2.ExecuteScalar("SELECT top 1 isBehind FROM vindicate") != null) && (base2.ExecuteScalar("SELECT top 1 isBehind FROM vindicate").ToString().ToLower() == "true"))
            {
                base2.Dispose();
                base.Response.Redirect("../vindicate/behind.aspx");
                base.Response.End();
            }
            else
            {
                base2.Dispose();
            }
        }
    }
}

