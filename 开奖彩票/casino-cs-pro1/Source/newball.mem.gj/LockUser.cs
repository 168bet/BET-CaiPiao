namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class LockUser : Page
    {
        protected Button back;
        protected Button Button1;
        protected Button submit;
        protected TextBox userName;

        private void back_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("chgLists.aspx");
            base.Response.End();
        }

        private void Button1_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                int num = 0;
                if (int.Parse(base2.ExecuteScalar("select count(*) from agence  where username='" + this.userName.Text.Trim() + "'").ToString()) > 0)
                {
                    num = base2.ExecuteNonQuery("update agence set islock=0 where username='" + this.userName.Text + "'");
                    base.Response.Write("<script>alert('解琐成功!');</script>");
                }
                else
                {
                    base.Response.Write("<script>alert('用户不存在!');</script>");
                }
                base2.Dispose();
            }
        }

        private void InitializeComponent()
        {
            this.submit.Click += new EventHandler(this.submit_Click);
            this.Button1.Click += new EventHandler(this.Button1_Click);
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
            }
        }

        private void submit_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                int num = 0;
                if (int.Parse(base2.ExecuteScalar("select count(*) from agence  where username='" + this.userName.Text.Trim() + "'").ToString()) > 0)
                {
                    num = base2.ExecuteNonQuery("update agence set islock=1 where username='" + this.userName.Text + "'");
                    MyTeam.OnlineList.OnlineList.DelUser(this.userName.Text);
                    base.Response.Write("<script>alert('琐定成功!');</script>");
                }
                else
                {
                    base.Response.Write("<script>alert('用户不存在!');</script>");
                }
                base2.Dispose();
            }
        }
    }
}

