namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class delZDan1 : Page
    {
        protected Button back;
        protected TextBox endTime;
        protected DropDownList selects;
        protected TextBox starTime;
        protected Button submit;

        private void back_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("chgLists.aspx");
            base.Response.End();
        }

        private void InitializeComponent()
        {
            this.submit.Click += new EventHandler(this.submit_Click);
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
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("select userid,username from agence where classid=3 order by username");
                this.selects.DataSource = reader;
                this.selects.DataTextField = "username";
                this.selects.DataValueField = "userid";
                this.selects.DataBind();
                base2.CloseConnect();
                base2.Dispose();
                this.starTime.Text = DateTime.Today.Year.ToString() + "-01-01";
                this.endTime.Text = DateTime.Today.AddDays(-30).ToString("yyyy-MM-dd");
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
                num = base2.ExecuteNonQuery("delete ball_order where zdlid=" + this.selects.SelectedValue + " and updatetime between '" + this.starTime.Text.Trim() + "' and '" + this.endTime.Text.Trim() + "'");
                base.Response.Write("<script>alert('共删除总代理" + this.selects.SelectedItem.Text.Trim() + "注单" + num.ToString() + "个');</script>");
                base2.Dispose();
            }
        }
    }
}

