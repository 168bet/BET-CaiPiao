namespace newball.zdl
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class dlslist : Page
    {
        protected DataGrid DataGrid1;
        protected DropDownList DropDownListAccountStatus;
        protected DropDownList DropDownListPage;
        protected Label LabelCount;
        protected Label LabelPage;
        protected Label LabelZdl;
        private int pagesize = 20;
        protected TextBox TextBoxSortField;

        public string AccountStatus(string flag)
        {
            if (flag.Trim().ToUpper() == "TRUE")
            {
                return "<font color='#0000ff'>有效</font>";
            }
            return "<font color='#ff0000'>停用</font>";
        }

        private void countmem()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT COUNT(*) FROM agence WHERE classid=4 AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim();
            if (this.DropDownListAccountStatus.SelectedValue != "")
            {
                sql = sql + " AND isuseable=" + this.DropDownListAccountStatus.SelectedValue;
            }
            this.LabelCount.Text = "共有代理商 " + base2.ExecuteScalar(sql).ToString() + " 个";
            base2.Dispose();
        }

        public void DataGrid1_ItemDataBound(object sender, DataGridItemEventArgs e)
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
            this.DataGrid1.CurrentPageIndex = e.NewPageIndex;
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
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
            string sql = "SELECT userid,username,memcount,usemoney,truename,regtime,isuseable FROM agence WHERE classid=4 AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim();
            if (flag != "")
            {
                sql = sql + " AND isuseable=" + flag;
            }
            sql = sql + " ORDER BY zdlid,userid";
            int start = (page - 1) * this.pagesize;
            DataSet set = new DataBase(MyFunc.GetConnStr(2)).ExecuteDataSet(sql, start, this.pagesize, "agence");
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

        public void DelDls(string id)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                int num = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM member WHERE dlsid=" + id + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                if (num > 0)
                {
                    base2.Dispose();
                    MyFunc.showmsg("该代理商下还有会员,不能删除该代理商");
                    base.Response.End();
                }
                else if (base2.ExecuteNonQuery("DELETE FROM agence WHERE userid=" + id + " AND classid=4 AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim()) > 0)
                {
                    base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount-1 WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                    base2.Dispose();
                    MyFunc.JumpPage("删除该代理商成功", "dlslist.aspx");
                    base.Response.End();
                }
                else
                {
                    base2.Dispose();
                    MyFunc.showmsg("删除代理商失败");
                    base.Response.End();
                }
            }
        }

        public string DelItem(string str, string id)
        {
            if (int.Parse(str.Trim()) < 1)
            {
                return ("/<a href=dlslist.aspx?action=del&id=" + id + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要删除该代理商吗?')\">删除</a>");
            }
            return "";
        }

        public void DropDownListAccountStatus_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DataGrid1.CurrentPageIndex = 0;
            this.TextBoxSortField.Text = "";
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue.Trim(), this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListPage_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        private void InitializeComponent()
        {
            this.DataGrid1.ItemDataBound += new DataGridItemEventHandler(this.DataGrid1_ItemDataBound);
            base.Load += new EventHandler(this.Page_Load);
        }

        public string kygl(string userid, string username)
        {
            return ("<a href=dlslist_reportlist.aspx?userid=" + userid + "&username=" + username + ">" + username + "</a>");
        }

        public string kygl(string did, string flag, string count)
        {
            return (this.OpItem(flag, did) + "/<a href=dlsmsg.aspx?id=" + did + ">详情</a>/<a href=dlsset.aspx?id=" + did + "&zid=" + this.Session.Contents["adminuserid"].ToString().Trim() + ">设定</a>" + this.DelItem(count, did));
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OpDls(string flag, string id)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE agence SET isuseable=" + flag + " WHERE userid=" + id + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                if (flag == "0")
                {
                    base2.ExecuteNonQuery("UPDATE member SET isuseable=0 WHERE dlsid=" + id);
                }
                base2.Dispose();
            }
        }

        public string OpItem(string flag, string id)
        {
            if (flag.Trim().ToUpper() == "TRUE")
            {
                return ("<a href=dlslist.aspx?action=Close&id=" + id + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要停用该代理商吗?')\">停用</a>");
            }
            return ("<a href=dlslist.aspx?action=Open&id=" + id + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要启用该代理商吗?')\">启用</a>");
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
                this.LabelZdl.Text = this.Session.Contents["adminusername"].ToString();
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "OPEN")
                    {
                        this.OpDls("1", base.Request.QueryString["id"].ToString().Trim());
                    }
                    else if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "CLOSE")
                    {
                        this.OpDls("0", base.Request.QueryString["id"].ToString().Trim());
                    }
                    else
                    {
                        if (base.Request.QueryString["action"].ToString().Trim().ToUpper() != "DEL")
                        {
                            return;
                        }
                        this.DelDls(base.Request.QueryString["id"].ToString().Trim());
                    }
                }
                if ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != ""))
                {
                    this.DropDownListAccountStatus.SelectedValue = base.Request.QueryString["flag"].ToString().Trim();
                }
                this.countmem();
                this.PageList(this.DropDownListAccountStatus.SelectedValue);
                this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
            }
        }

        private void PageList(string flag)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT COUNT(1) FROM agence WHERE classid=4 AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim();
            if (flag != "")
            {
                sql = sql + " AND isuseable=" + flag;
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

