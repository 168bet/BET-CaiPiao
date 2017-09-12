namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class gdlist : Page
    {
        protected DataGrid DataGrid1;
        protected DropDownList DropDownListAccountStatus;
        protected DropDownList DropDownListPage;
        protected Label LabelPage;
        private int pagesize = 20;
        protected TextBox TextBoxSortField;

        public string AccountStatus(string flag)
        {
            if (flag.Trim().ToUpper() == "TRUE")
            {
                return "<font color='#0000ff'>正常</font>";
            }
            return "<font color='#ff0000'>停用</font>";
        }

        private void ButtonAddNew_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("gdadd.aspx");
        }

        private void DataGrid1_ItemDataBound(object sender, DataGridItemEventArgs e)
        {
            if (e.Item.ItemIndex >= 0)
            {
                e.Item.Attributes["onMouseOver"] = "this.bgColor='#cccccc';";
                if ((e.Item.ItemIndex % 2) == 0)
                {
                    e.Item.Attributes["bgcolor"] = "white";
                    e.Item.Attributes["OnMouseOut"] = "this.bgColor='white';";
                }
                else
                {
                    e.Item.Attributes["bgcolor"] = "#EBEBEB";
                    e.Item.Attributes["onMouseOut"] = "this.bgColor='#EBEBEB';";
                }
            }
        }

        public void DataGrid1_PageIndexChanged(object source, DataGridPageChangedEventArgs e)
        {
        }

        public void DataGrid1_SortCommand(object source, DataGridSortCommandEventArgs e)
        {
            if (this.TextBoxSortField.Text == (e.SortExpression + " ASC"))
            {
                this.TextBoxSortField.Text = e.SortExpression + " DESC";
            }
            else
            {
                this.TextBoxSortField.Text = e.SortExpression + " ASC";
            }
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        private void DataGridDataBind(string flag, string field, int page)
        {
            string sql = "SELECT userid,username,memcount,truename,regtime,isuseable,usemoney,gdid FROM agence WHERE classid=2";
            if (flag != "")
            {
                sql = sql + "AND isuseable=" + flag;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int start = (page - 1) * this.pagesize;
            DataSet set = base2.ExecuteDataSet(sql, start, this.pagesize, "agence");
            if (field != "")
            {
                DataView defaultView = set.Tables[0].DefaultView;
                defaultView.Sort = field;
                this.DataGrid1.DataSource = defaultView;
            }
            else
            {
                this.DataGrid1.DataSource = set;
            }
            this.DataGrid1.DataBind();
        }

        private void DelGd(string id)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (((int) base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE gdid=" + id)) > 0)
                {
                    base2.Dispose();
                    MyFunc.showmsg("该股东下还有总代理,代理商或会员,不能删除股东");
                    base.Response.End();
                }
                else if (base2.ExecuteNonQuery("DELETE FROM agence WHERE userid=" + id + " AND classid=2") > 0)
                {
                    base2.Dispose();
                    MyFunc.JumpPage("删除股东成功!", "gdlist.aspx");
                    base.Response.End();
                }
                else
                {
                    base2.Dispose();
                    MyFunc.showmsg("删除股东失败");
                    base.Response.End();
                }
            }
        }

        public string DelItem(string num, string id)
        {
            if (int.Parse(num.Trim()) < 1)
            {
                return (" / <a href=gdlist.aspx?action=del&id=" + id + " onClick=\"return confirm('确定要删除该股东吗?')\">删除</a>");
            }
            return "";
        }

        public void DropDownListAccountStatus_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.PageList(this.DropDownListAccountStatus.SelectedValue.Trim());
            this.TextBoxSortField.Text = "";
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListPage_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        private void InitializeComponent()
        {
            this.DropDownListAccountStatus.SelectedIndexChanged += new EventHandler(this.DropDownListAccountStatus_SelectedIndexChanged);
            base.Load += new EventHandler(this.Page_Load);
        }

        public string kygl_href(string userid, string username)
        {
            return ("<a href=gdlist_reportlist.aspx?userid=" + userid + "&username=" + username + ">" + username + "</a>");
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OpGd(string flag, string id)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE agence SET isuseable=" + flag + " WHERE userid=" + id);
                if (flag == "0")
                {
                    base2.ExecuteNonQuery("UPDATE agence SET isuseable=0 WHERE gdid=" + id);
                    base2.ExecuteNonQuery("UPDATE member SET isuseable=0 WHERE gdid=" + id);
                }
                base2.Dispose();
            }
        }

        public string OpItem(string flag, string id)
        {
            if (flag.Trim().ToUpper() == "TRUE")
            {
                return ("<a href=gdlist.aspx?action=Close&id=" + id + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要停用该股东吗?')\">停用</a>");
            }
            return ("<a href=gdlist.aspx?action=Open&id=" + id + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要启用该股东吗?')\">启用</a>");
        }

        private void Page_Load(object sender, EventArgs e)
        {
            this.DropDownListAccountStatus.AutoPostBack = true;
            MyFunc.isRefUrl();
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
            }
            else if (!base.IsPostBack)
            {
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "OPEN")
                    {
                        this.OpGd("1", base.Request.QueryString["id"].ToString().Trim());
                    }
                    else if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "CLOSE")
                    {
                        this.OpGd("0", base.Request.QueryString["id"].ToString().Trim());
                    }
                    else
                    {
                        if (base.Request.QueryString["action"].ToString().Trim().ToUpper() != "DEL")
                        {
                            return;
                        }
                        this.DelGd(base.Request.QueryString["id"].ToString().Trim());
                    }
                }
                if ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != ""))
                {
                    this.DropDownListAccountStatus.SelectedValue = base.Request.QueryString["flag"].ToString().Trim();
                }
                this.PageList(this.DropDownListAccountStatus.SelectedValue);
                this.DataGrid1.PageSize = this.pagesize;
                this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
            }
        }

        private void PageList(string flag)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT COUNT(1) FROM agence WHERE classid=2";
            if (flag != "")
            {
                sql = sql + "AND isuseable=" + flag;
            }
            int num = int.Parse(base2.ExecuteScalar(sql).ToString());
            int num2 = 0;
            if (num > 0)
            {
                num2 = num / this.pagesize;
                if ((num % this.pagesize) != 0)
                {
                    num2++;
                }
            }
            else
            {
                num2 = 1;
            }
            this.DropDownListPage.Items.Clear();
            for (int i = 1; i <= num2; i++)
            {
                this.DropDownListPage.Items.Add(new ListItem(i.ToString(), i.ToString()));
            }
            this.DropDownListPage.SelectedIndex = 0;
            this.LabelPage.Text = "/" + num2.ToString() + "页";
            base2.Dispose();
        }
    }
}

