namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class Logint : Page
    {
        private void Image1_ServerClick(object sender, ImageClickEventArgs e)
        {
            this.submitdeal();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            if (!base.IsPostBack)
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                this.Session.Abandon();
                if ((base2.ExecuteScalar("SELECT top 1 isFront FROM vindicate") != null) && (base2.ExecuteScalar("SELECT top 1 isFront FROM vindicate").ToString().ToLower() == "true"))
                {
                    base2.Dispose();
                    base.Response.Redirect("../vindicate/front.aspx");
                    base.Response.End();
                }
                else
                {
                    base2.Dispose();
                }
            }
            else
            {
                this.submitdeal();
            }
        }

        private void submitdeal()
        {
            MyFunc.isRefUrl();
            string text = MyFunc.ConvertStr(base.Request["TextBoxUserName"].Trim().ToLower());
            string text2 = MyFunc.ConvertStr(base.Request["TextBoxUserPass"].Trim());
            if ((text == "") || (text2 == ""))
            {
                MyFunc.showmsg("请输入用户名或密码!");
                base.Response.End();
            }
            else
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = db.ExecuteReader("SELECT userid,username,userpass,abc,(select top 1 gdid from agence where userid = member.gdid) as gsid,(select top 1 gsbl from agence where userid = member.gdid) as gscs FROM member WHERE username='" + text + "' AND isuseable=1");
                if (!reader.Read())
                {
                    reader.Close();
                    db.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                }
                else if ((text != reader["username"].ToString().ToLower().Trim()) || (text2 != reader["userpass"].ToString().ToLower().Trim()))
                {
                    reader.Close();
                    db.Dispose();
                    MyFunc.showmsg("帐号或密码错误!");
                    base.Response.End();
                }
                else
                {
                    this.Session.Contents["userid"] = reader["userid"].ToString().Trim();
                    this.Session.Contents["username"] = reader["username"].ToString().ToLower().Trim();
                    this.Session.Contents["userpass"] = reader["userpass"].ToString().Trim();
                    this.Session.Contents["sessid"] = this.Session.SessionID;
                    this.Session.Contents["classid"] = "20";
                    this.Session.Contents["ABC"] = reader["abc"].ToString().Trim();
                    this.Session.Contents["usergsid"] = reader["gsid"].ToString().Trim();
                    this.Session.Contents["usergscs"] = reader["gscs"].ToString().Trim();
                    reader.Close();
                    string place = "";
                    string text4 = "";
                    string ip = "";
                    if ((base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"] != null) && (base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim() != ""))
                    {
                        ip = base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim();
                        place = MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.ServerVariables["HTTP_X_FORWARDED_FOR"].ToString().Trim()));
                    }
                    ip = ip + "|" + base.Request.UserHostAddress.ToString().Trim();
                    MyFunc.WriteUserEvent(db, this.Session.Contents["userid"].ToString(), this.Session.Contents["username"].ToString(), base.Request.UserHostAddress.ToString(), this.Session.Contents["classid"].ToString(), "1");
                    db.ExecuteNonQuery("UPDATE member SET curmoney=(usemoney-(select ISNULL(sum(tzmoney),0) from ball_order where userid=" + this.Session.Contents["userid"].ToString().Trim() + " AND tztype in (15,14) and datediff(day,balltime,getdate())=0)),moneyupdate=GetDate() WHERE userid=" + this.Session.Contents["userid"].ToString().Trim() + " AND DateDiff(day,moneyupdate,GetDate())<>0");
                    text4 = MyFunc.GetPlace(db, MyFunc.ChgIP(base.Request.UserHostAddress.ToString().Trim()));
                    db.Dispose();
                    MyTeam.OnlineList.OnlineList.NewUserLogin(this.Session.Contents["username"].ToString().Trim(), this.Session.SessionID.ToString().Trim(), DateTime.Now.ToString(), ip, this.Session.Contents["classid"].ToString().Trim(), place + "|" + text4);
                    base.Response.Redirect("imp_rules.aspx");
                    base.Response.End();
                }
            }
        }
    }
}

