namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class myForm : Page
    {
        protected Button buttonsearch;
        protected DropDownList DropDownListDls;
        protected DropDownList DropDownListGd;
        protected DropDownList DropDownListJs;
        protected DropDownList DropDownListRR;
        protected DropDownList DropDownListTzType;
        protected DropDownList DropDownListUser;
        protected DropDownList DropDownListZdl;
        protected TextBox TextBoxBallid;
        protected TextBox TextBoxEnd_Date;
        protected TextBox TextBoxEnd_Time;
        protected TextBox TextBoxOrderid;
        protected TextBox TextBoxStart_Date;
        protected TextBox TextBoxStart_Time;
        protected TextBox TextBoxTzMoney;
        protected TextBox TextBoxUserName;

        private void buttonsearch_Click(object sender, EventArgs e)
        {
            string selectedValue = "0";
            string text2 = "";
            string text3 = "1";
            string text4 = "";
            if (this.DropDownListJs.SelectedValue != "2")
            {
                selectedValue = this.DropDownListJs.SelectedValue;
            }
            else
            {
                text2 = this.DropDownListJs.SelectedValue;
            }
            if ((this.DropDownListRR.SelectedValue != "w") && (this.DropDownListRR.SelectedValue != "s"))
            {
                text3 = this.DropDownListRR.SelectedValue;
            }
            else
            {
                text4 = this.DropDownListRR.SelectedValue;
            }
            base.Response.Redirect("orderlist.aspx?action=kygl&start=" + this.TextBoxStart_Date.Text.Trim() + "&end=" + this.TextBoxEnd_Date.Text.Trim() + "&t1=" + this.TextBoxStart_Time.Text.Trim() + "&t2=" + this.TextBoxEnd_Time.Text.Trim() + "&flag=" + selectedValue + "&bid=&type=" + this.DropDownListTzType.SelectedValue + "&gid=" + this.DropDownListGd.SelectedValue + "&zid=" + this.DropDownListZdl.SelectedValue + "&did=" + this.DropDownListDls.SelectedValue + "&uid=" + this.DropDownListUser.SelectedValue + "&uname=" + this.TextBoxUserName.Text.Trim() + "&&oid=" + this.TextBoxOrderid.Text.Trim() + "&matchname=&tzmoney=" + this.TextBoxTzMoney.Text.Trim() + "&rr=" + text3 + "&isc=" + text2 + "&isw=" + text4);
        }

        private void DlsList()
        {
            string sql = "SELECT userid,username FROM agence WHERE classid=4 ";
            if (this.DropDownListZdl.SelectedValue != "")
            {
                sql = sql + " AND zdlid=" + this.DropDownListZdl.SelectedValue;
            }
            sql = sql + " ORDER BY username";
            this.DropDownListDls.Items.Clear();
            this.DropDownListDls.Items.Add(new ListItem("全部", ""));
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                this.DropDownListDls.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            reader.Close();
            base2.Dispose();
        }

        public void DropDownListDls_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.UserList();
        }

        public void DropDownListGd_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.ZdlList();
            this.DlsList();
        }

        public void DropDownListZdl_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DlsList();
        }

        private void GdList()
        {
            this.DropDownListGd.Items.Clear();
            this.DropDownListGd.Items.Add(new ListItem("全部", ""));
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT userid,username FROM agence WHERE classid=2 ORDER BY username");
            while (reader.Read())
            {
                this.DropDownListGd.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            reader.Close();
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            this.buttonsearch.Click += new EventHandler(this.buttonsearch_Click);
            this.ID = "myForm";
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                this.TextBoxStart_Date.Text = DateTime.Now.ToString("yyyy-MM-dd");
                this.TextBoxEnd_Date.Text = DateTime.Now.ToString("yyyy-MM-dd");
                this.GdList();
                this.ZdlList();
                this.DlsList();
                this.UserList();
            }
        }

        private void UserList()
        {
            string sql = "SELECT userid,username FROM member WHERE 1=1 ";
            if (this.DropDownListDls.SelectedValue != "")
            {
                sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
            }
            sql = sql + " ORDER BY username";
            this.DropDownListUser.Items.Clear();
            this.DropDownListUser.Items.Add(new ListItem("全部", ""));
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                this.DropDownListUser.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            reader.Close();
            base2.Dispose();
        }

        private void ZdlList()
        {
            string sql = "SELECT userid,username FROM agence WHERE classid=3 ";
            if (this.DropDownListGd.SelectedValue != "")
            {
                sql = sql + " AND gdid=" + this.DropDownListGd.SelectedValue;
            }
            sql = sql + " ORDER BY username";
            this.DropDownListZdl.Items.Clear();
            this.DropDownListZdl.Items.Add(new ListItem("全部", ""));
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                this.DropDownListZdl.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            reader.Close();
            base2.Dispose();
        }
    }
}

