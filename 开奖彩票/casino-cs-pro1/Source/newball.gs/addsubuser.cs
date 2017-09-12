namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class addsubuser : Page
    {
        protected HtmlGenericControl editsubdiv;
        protected HtmlInputText editsubpass;
        protected HtmlInputText edittruename;
        protected DropDownList showlist;
        protected HtmlInputHidden subid;
        protected HtmlInputHidden submitflag;
        protected DataGrid subuserlist;

        private void adddeal()
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "0", 1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                string sql = "SELECT subid FROM subAgence WHERE subname = '" + base.Request.Form["subname"].ToString().Trim() + "' and classid = '10' union SELECT userid FROM agence WHERE username ='" + base.Request.Form["subname"].ToString().Trim() + "'";
                SqlDataReader reader = base2.ExecuteReader(sql);
                if (reader.Read())
                {
                    reader.Close();
                    base2.CloseConnect();
                    base2.Dispose();
                    MyFunc.showmsg("此帐号已经存在！");
                }
                else
                {
                    reader.Close();
                    sql = "INSERT INTO subAgence (userid,classid,subname,truename,subpass,regtime,isuseable) VALUES ('" + this.Session["adminuserid"].ToString() + "','10','" + base.Request.Form["subname"].ToString().Trim() + "','" + base.Request.Form["truename"].ToString().Trim() + "','" + base.Request.Form["subpass"].ToString().Trim() + "','" + DateTime.Now.ToString() + "'," + base.Request.Form["isuseable"].ToString().Trim() + ")";
                    base2.ExecuteNonQuery(sql);
                    base2.CloseConnect();
                    base2.Dispose();
                }
            }
        }

        private void editdeal()
        {
            string sql = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (this.editsubpass.Value != "")
            {
                sql = "UPDATE subAgence SET subpass = '" + this.editsubpass.Value + "',truename ='" + this.edittruename.Value + "' WHERE subid = '" + this.subid.Value + "'";
            }
            else
            {
                sql = "UPDATE subAgence SET truename ='" + this.edittruename.Value + "' WHERE subid = '" + this.subid.Value + "'";
            }
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
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
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.setstartdatagrid();
            }
            else if (base.Request.Form["submitflag"].ToString() != "")
            {
                if (this.subid.Value != "")
                {
                    this.editdeal();
                }
                else
                {
                    this.adddeal();
                }
                this.submitflag.Value = "";
                this.subid.Value = "";
                this.editsubdiv.Style.Add("DISPLAY", "none");
                this.setstartdatagrid();
            }
        }

        private void setstartdatagrid()
        {
            string sql = "SELECT subid,userid,subname,truename,convert(char(19),regtime,21) as regtime,isuseable,subpass FROM subAgence WHERE userid = '" + this.Session["adminuserid"].ToString() + "'";
            if (this.showlist.SelectedValue != "")
            {
                sql = sql + " and isuseable = '" + this.showlist.SelectedValue + "'";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataSet set = base2.ExecuteDataSet(sql);
            this.subuserlist.DataSource = set;
            this.subuserlist.DataBind();
            set.Clear();
            base2.CloseConnect();
            base2.Dispose();
        }

        public void showlist_SelectIndexChanged(object sender, EventArgs e)
        {
            this.editsubdiv.Style.Add("DISPLAY", "none");
            this.setstartdatagrid();
        }

        public string showuseable(string isuseable)
        {
            if (isuseable.ToLower() == "false")
            {
                return "<font color=red>停用</font>";
            }
            return "<font color=blue>启用</font>";
        }

        public string showuseablebutton(string isuseable)
        {
            if (isuseable.ToLower() == "false")
            {
                return "启用";
            }
            return "停用";
        }

        public void subuserlist_DataGridBand(object sender, DataGridItemEventArgs e)
        {
            if (e.Item.ItemIndex >= 0)
            {
                e.Item.Attributes["onMouseOver"] = "this.bgColor = '#cccccc';";
                if (e.Item.Cells[6].Text.ToLower() == "false")
                {
                    e.Item.Attributes["bgcolor"] = "#efefef";
                    e.Item.Attributes["onMouseOut"] = "this.bgColor = '#efefef';";
                }
                else
                {
                    e.Item.Attributes["onMouseOut"] = "this.bgColor = '#ffffff';";
                }
            }
        }

        public void subuserlist_ItemCommand(object sender, DataGridCommandEventArgs e)
        {
            string sql = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (e.CommandName == "useable")
            {
                if (e.Item.Cells[6].Text.ToLower() == "true")
                {
                    sql = "UPDATE subAgence SET isuseable = 0 WHERE subid = '" + e.Item.Cells[0].Text + "'";
                }
                else
                {
                    sql = "UPDATE subAgence SET isuseable = 1 WHERE subid = '" + e.Item.Cells[0].Text + "'";
                }
                base2.ExecuteNonQuery(sql);
            }
            if (e.CommandName == "delsub")
            {
                sql = "DELETE subAgence WHERE subid = '" + e.Item.Cells[0].Text + "'";
                base2.ExecuteNonQuery(sql);
            }
            if (e.CommandName == "editsub")
            {
                this.editsubdiv.Style.Add("DISPLAY", "block");
                this.editsubpass.Value = e.Item.Cells[7].Text;
                this.edittruename.Value = e.Item.Cells[1].Text;
                this.subid.Value = e.Item.Cells[0].Text;
            }
            base2.CloseConnect();
            base2.Dispose();
            this.setstartdatagrid();
        }
    }
}

