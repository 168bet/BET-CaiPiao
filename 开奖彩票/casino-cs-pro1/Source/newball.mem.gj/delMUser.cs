namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class delMUser : Page
    {
        protected Button back;
        protected Button del;
        protected TextBox endTime;
        protected DropDownList selects;
        protected TextBox starTime;
        protected TextBox username;

        private void back_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("chgLists.aspx");
            base.Response.End();
        }

        private void CheckUserName(string userName)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (!base2.ExecuteReader("select userid from member where username = '" + userName + "'").Read())
            {
                MyFunc.showmsg("不存在会员：" + userName + "，请检测输入的帐号！");
                base.Response.End();
            }
        }

        private void del_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if (this.username.Text.Trim() == "")
            {
                MyFunc.showmsg("请输入要删除的用户帐号！");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (this.selects.SelectedItem.Value == "1")
                {
                    string userId = this.GetUserId(this.username.Text.Trim());
                    string dlsId = this.GetDlsId(this.username.Text.Trim());
                    base2.ExecuteNonQuery("delete userhs where userid = '" + userId + "'");
                    base2.ExecuteNonQuery("delete ball_order where username = '" + this.username.Text.Trim() + "'");
                    base2.ExecuteNonQuery("delete member where username = '" + this.username.Text.Trim() + "'");
                    base2.ExecuteNonQuery("update agence set memcount = memcount-1 where userid = '" + dlsId + "'");
                    base.Response.Write("<script>alert('成功删除会员" + this.username.Text + "和该会员的注单');</script>");
                }
                else if (this.selects.SelectedItem.Value == "2")
                {
                    int num = 0;
                    num = base2.ExecuteNonQuery("delete ball_order where username = '" + this.username.Text.Trim() + "' and updatetime between '" + this.starTime.Text.Trim() + "' and '" + this.endTime.Text.Trim() + "'");
                    base.Response.Write("<script>alert('共删除会员" + this.username.Text + "的" + num.ToString() + "个注单');</script>");
                }
                base2.CloseConnect();
                base2.Dispose();
            }
        }

        private string GetDlsId(string userName)
        {
            SqlDataReader reader = new DataBase(MyFunc.GetConnStr(2)).ExecuteReader("select dlsid from member where username = '" + userName + "'");
            if (reader.Read())
            {
                return reader["dlsid"].ToString();
            }
            MyFunc.showmsg("不存在会员：" + userName + "，请检测输入的帐号！");
            base.Response.End();
            return "";
        }

        private string GetUserId(string userName)
        {
            SqlDataReader reader = new DataBase(MyFunc.GetConnStr(2)).ExecuteReader("select userid from member where username = '" + userName + "'");
            if (reader.Read())
            {
                return reader["userid"].ToString();
            }
            MyFunc.showmsg("不存在会员：" + userName + "，请检测输入的帐号！");
            base.Response.End();
            return "";
        }

        private void InitializeComponent()
        {
            this.del.Click += new EventHandler(this.del_Click);
            this.back.Click += new EventHandler(this.back_Click);
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
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.starTime.Text = DateTime.Today.Year.ToString() + "-01-01";
                this.endTime.Text = DateTime.Today.AddDays(-30).ToString("yyyy-MM-dd");
            }
        }
    }
}

