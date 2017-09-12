namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class system800add : Page
    {
        protected Button addsys800;
        protected TextBox amount;
        protected HtmlGenericControl amounthiden;
        protected Button clearsys800;
        protected DropDownList paytype;
        protected TextBox paytypeno;
        protected DropDownList username;
        protected HtmlInputRadioButton usertype1;
        protected HtmlInputRadioButton usertype2;

        private void addsys800_Click(object sender, EventArgs e)
        {
            string sql = "";
            string text2 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            text2 = "SELECT count(*) FROM member WHERE userid = '" + this.username.SelectedValue + "' AND ";
            if (base.Request.Form["usertype"].ToString() == "按金")
            {
                string text3 = text2;
                string text4 = text3 + "usemoney < curmoney + " + this.amount.Text.Trim() + " + isnull((select sum(amount) from sys800user where userid = '" + this.username.SelectedValue + "' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and remark ='<input type=button name=appbutton  value=\"存储\" class=Text onclick=\"appbutton_click(this)\"  runat=server>' ),0) - ";
                text2 = text4 + "isnull((select sum(amount) from sys800user where userid = '" + this.username.SelectedValue + "' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and remark = '<input type=button name=appbutton  value=\"现金提款\" class=Text onclick=\"appbutton_click(this)\">'),0)";
            }
            else
            {
                string text5 = text2;
                string text6 = text5 + this.amount.Text.Trim() + " - curmoney - isnull((select sum(amount) from sys800user where userid = '" + this.username.SelectedValue + "' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and remark ='<input type=button name=appbutton  value=\"存储\" class=Text onclick=\"appbutton_click(this)\"  runat=server>' ),0) + ";
                text2 = text6 + "isnull((select sum(amount) from sys800user where userid = '" + this.username.SelectedValue + "' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and remark = '<input type=button name=appbutton  value=\"现金提款\" class=Text onclick=\"appbutton_click(this)\">'),0) > 0";
            }
            if (int.Parse(base2.ExecuteScalar(text2).ToString()) > 0)
            {
                MyFunc.showmsg("数额不能超过信用额度！");
            }
            else
            {
                sql = "INSERT INTO sys800user (userid,dlsid,amount,paytype,paytypeno,usertype,remark) VALUES ";
                if (base.Request.Form["usertype"].ToString() == "现金提款")
                {
                    string text7 = sql;
                    sql = text7 + "('" + this.username.SelectedValue + "','" + this.Session.Contents["adminuserid"].ToString() + "','" + this.amount.Text + "','" + this.paytype.SelectedValue + "','" + this.paytypeno.Text + "','现金提款','<input type=button name=appbutton  value=\"现金提款\" class=Text onclick=\"appbutton_click(this)\">')";
                }
                else
                {
                    string text8 = sql;
                    sql = text8 + "('" + this.username.SelectedValue + "','" + this.Session.Contents["adminuserid"].ToString() + "','" + this.amount.Text + "','" + this.paytype.SelectedValue + "','" + this.paytypeno.Text + "','按金','<input type=button name=appbutton  value=\"存储\" class=Text onclick=\"appbutton_click(this)\"  runat=server>')";
                }
                base2.ExecuteNonQuery(sql);
                base2.Dispose();
                MyFunc.showmsg("新增存储成功！");
            }
        }

        private void InitializeComponent()
        {
            this.addsys800.Click += new EventHandler(this.addsys800_Click);
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
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.SetUserNameList();
            }
        }

        private void SetUserNameList()
        {
            string sql = "";
            sql = "SELECT userid,username FROM member WHERE dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' AND usertype = '现金'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                this.username.Items.Add(new ListItem(reader["username"].ToString(), reader["userid"].ToString()));
            }
            reader.Close();
            base2.Dispose();
        }
    }
}

