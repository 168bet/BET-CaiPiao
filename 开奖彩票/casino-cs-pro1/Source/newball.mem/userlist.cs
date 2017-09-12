namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class userlist : Page
    {
        protected DataGrid DataGrid1;
        protected DropDownList DropDownList1;
        protected DropDownList DropDownListAccountStatus;
        protected DropDownList DropDownListDls;
        protected DropDownList DropDownListGd;
        protected DropDownList DropDownListPage;
        protected DropDownList DropDownListZdl;
        protected Label LabelCount;
        protected Label LabelPage;
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
            string sql = "SELECT userid,username,userpass,xzcount,usemoney,truename,regtime,dlsname,dlsid,isuseable,moneysort,usertype,pltype FROM member WHERE 1=1";
            if (flag.Trim() != "")
            {
                sql = sql + " AND isuseable=" + flag;
            }
            if (this.DropDownListGd.SelectedValue.Trim() != "")
            {
                sql = sql + " AND gdid=" + this.DropDownListGd.SelectedValue;
                if ((this.DropDownListZdl.SelectedValue.Trim() != "") && (this.DropDownListZdl.SelectedValue != "0"))
                {
                    sql = sql + " AND zdlid=" + this.DropDownListZdl.SelectedValue;
                    if ((this.DropDownListDls.SelectedValue.Trim() != "") && (this.DropDownListDls.SelectedValue != "0"))
                    {
                        sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
                    }
                }
            }
            sql = sql + " ORDER BY userid";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int start = (page - 1) * this.pagesize;
            DataSet set = base2.ExecuteDataSet(sql, start, this.pagesize, "member");
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

        public string DelItem(string str, string id, string dlsid)
        {
            if (int.Parse(str.Trim()) < 1)
            {
                return (" / <a href=userlist.aspx?action=del&id=" + id + "&did=" + this.DropDownListDls.SelectedValue + "&gdid=" + this.DropDownListGd.SelectedValue + "&zid=" + this.DropDownListZdl.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要删除该会员吗?')\">删除</a>");
            }
            return "";
        }

        public void DelUser(string id, string dlsid)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                int num = (int) base2.ExecuteScalar("SELECT xzcount FROM member WHERE userid=" + id);
                if (num > 0)
                {
                    base2.Dispose();
                    MyFunc.showmsg("该会员有注单,不能删除该会员");
                    base.Response.End();
                }
                else
                {
                    string text = base2.ExecuteScalar("SELECT dlsid FROM member WHERE userid=" + id).ToString();
                    if (base2.ExecuteNonQuery("DELETE FROM member WHERE userid=" + id) > 0)
                    {
                        base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount-1 WHERE dlsid=" + text);
                        base2.Dispose();
                        MyFunc.JumpPage("删除该会员成功", "dlslist.aspx");
                        base.Response.End();
                    }
                    else
                    {
                        base2.Dispose();
                        MyFunc.showmsg("删除会员失败");
                        base.Response.End();
                    }
                }
            }
        }

        private void DlsList()
        {
            string sql = "SELECT userid,username FROM agence WHERE classid=4";
            if (this.DropDownListGd.SelectedValue != "")
            {
                sql = sql + " AND gdid=" + this.DropDownListGd.SelectedValue;
            }
            if (this.DropDownListZdl.SelectedValue != "")
            {
                sql = sql + " AND zdlid=" + this.DropDownListZdl.SelectedValue;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            this.DropDownListDls.Items.Clear();
            this.DropDownListDls.Items.Add(new ListItem("请选择", "0"));
            while (reader.Read())
            {
                this.DropDownListDls.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            this.DropDownListDls.Items.Add(new ListItem("全部", ""));
            reader.Close();
            base2.Dispose();
        }

        public void DropDownListAccountStatus_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.PageList(this.DropDownListAccountStatus.SelectedValue);
            this.TextBoxSortField.Text = "";
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue.Trim(), this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListDls_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.PageList(this.DropDownListAccountStatus.SelectedValue);
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListGd_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.ZdlList();
            this.DlsList();
            this.PageList(this.DropDownListAccountStatus.SelectedValue);
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListPage_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DataGrid1.CurrentPageIndex = int.Parse(this.DropDownListPage.SelectedValue) - 1;
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListZdl_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DlsList();
            this.PageList(this.DropDownListAccountStatus.SelectedValue);
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        private void InitializeComponent()
        {
            this.DropDownListGd.SelectedIndexChanged += new EventHandler(this.DropDownListGd_SelectedIndexChanged);
            this.DropDownListZdl.SelectedIndexChanged += new EventHandler(this.DropDownListZdl_SelectedIndexChanged);
            base.Load += new EventHandler(this.Page_Load);
        }

        public string kygl(string userid, string username)
        {
            return ("<a href=userlist_reportlist.aspx?userid=" + userid + "&username=" + username + ">" + username + "</a>");
        }

        public string kygl(string uid, string did, string flag)
        {
            return (this.OpItem(flag, uid, did) + "/<a href=usermsg.aspx?id=" + uid + ">详情</a>/<a href=userset.aspx?id=" + uid + ">设定</a>");
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        public string OpItem(string flag, string id, string dlsid)
        {
            if (flag.Trim().ToUpper() == "TRUE")
            {
                return ("<a href=userlist.aspx?action=Close&id=" + id + "&did=" + this.DropDownListDls.SelectedValue + "&gdid=" + this.DropDownListGd.SelectedValue + "&zid=" + this.DropDownListZdl.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要停用该会员吗?')\">停用</a>");
            }
            return ("<a href=userlist.aspx?action=Open&id=" + id + "&did=" + this.DropDownListDls.SelectedValue + "&gdid=" + this.DropDownListGd.SelectedValue + "&zid=" + this.DropDownListZdl.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要启用该会员吗?')\">启用</a>");
        }

        private void OpUser(string flag, string id, string dlsid)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (flag == "1")
                {
                    SqlDataReader reader = base2.ExecuteReader("SELECT dlsid,zdlid,gdid FROM member WHERE userid=" + id);
                    reader.Read();
                    string text3 = reader["dlsid"].ToString().Trim();
                    string text = reader["zdlid"].ToString().Trim();
                    string text2 = reader["gdid"].ToString().Trim();
                    reader.Close();
                    int num = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text3).ToString());
                    if (num > 0)
                    {
                        int num2 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text3 + " AND isuseable=1").ToString());
                        if (num < (num2 + 1))
                        {
                            base2.Dispose();
                            MyFunc.showmsg("该代理商的最大会员数为 " + num.ToString() + ",不能再启用会员");
                            base.Response.End();
                            return;
                        }
                    }
                    else
                    {
                        int num3 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text).ToString());
                        if (num3 > 0)
                        {
                            int num4 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE zdlid=" + text + " AND isuseable=1").ToString());
                            if (num3 < (num4 + 1))
                            {
                                base2.Dispose();
                                MyFunc.showmsg("您的最大会员数为 " + num.ToString() + ",不能再启用会员");
                                base.Response.End();
                                return;
                            }
                        }
                        else
                        {
                            int num5 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text2).ToString());
                            if (num5 > 0)
                            {
                                int num6 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid=" + text2 + " AND isuseable=1").ToString());
                                if (num5 < (num6 + 1))
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("该股东的最大会员数为 " + num.ToString() + ",不能再启用会员");
                                    base.Response.End();
                                    return;
                                }
                            }
                        }
                    }
                }
                base2.ExecuteNonQuery("UPDATE member SET isuseable=" + flag + " WHERE userid=" + id);
                base2.Dispose();
            }
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
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "OPEN")
                    {
                        this.OpUser("1", base.Request.QueryString["id"].ToString().Trim(), base.Request.QueryString["did"].ToString().Trim());
                    }
                    else if (base.Request.QueryString["action"].ToString().Trim().ToUpper() == "CLOSE")
                    {
                        this.OpUser("0", base.Request.QueryString["id"].ToString().Trim(), base.Request.QueryString["did"].ToString().Trim());
                    }
                    else
                    {
                        if (base.Request.QueryString["action"].ToString().Trim().ToUpper() != "DEL")
                        {
                            return;
                        }
                        this.DelUser(base.Request.QueryString["id"].ToString().Trim(), base.Request.QueryString["did"].ToString().Trim());
                    }
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                this.DropDownListGd.Items.Clear();
                this.DropDownListGd.Items.Add(new ListItem("请选择", "0"));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username FROM agence WHERE classid=2");
                while (reader.Read())
                {
                    this.DropDownListGd.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                this.DropDownListGd.Items.Add(new ListItem("全部", ""));
                this.DropDownListGd.SelectedIndex = 0;
                if ((base.Request.QueryString["gdid"] != null) && (base.Request.QueryString["gdid"].ToString().Trim() != ""))
                {
                    this.DropDownListGd.SelectedValue = base.Request.QueryString["gdid"].ToString().Trim();
                }
                this.ZdlList();
                if ((base.Request.QueryString["zid"] != null) && (base.Request.QueryString["zid"].ToString().Trim() != ""))
                {
                    this.DropDownListZdl.SelectedValue = base.Request.QueryString["zid"].ToString().Trim();
                }
                this.DlsList();
                if ((base.Request.QueryString["did"] != null) && (base.Request.QueryString["did"].ToString().Trim() != ""))
                {
                    this.DropDownListDls.SelectedValue = base.Request.QueryString["did"].ToString().Trim();
                }
                if ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != ""))
                {
                    this.DropDownListAccountStatus.SelectedValue = base.Request.QueryString["flag"].ToString().Trim();
                }
                this.PageList(this.DropDownListAccountStatus.SelectedValue);
                this.DataGrid1.PageSize = this.pagesize;
                this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
                base2.Dispose();
            }
        }

        private void PageList(string flag)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT COUNT(1) FROM member WHERE 1=1 ";
            if (flag.Trim() != "")
            {
                sql = sql + " AND isuseable=" + flag;
            }
            if (this.DropDownListGd.SelectedValue.Trim() != "")
            {
                sql = sql + " AND gdid=" + this.DropDownListGd.SelectedValue;
                if ((this.DropDownListZdl.SelectedValue.Trim() != "") && (this.DropDownListZdl.SelectedValue != "0"))
                {
                    sql = sql + " AND zdlid=" + this.DropDownListZdl.SelectedValue;
                    if ((this.DropDownListDls.SelectedValue.Trim() != "") && (this.DropDownListDls.SelectedValue != "0"))
                    {
                        sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
                    }
                }
            }
            int num = int.Parse(base2.ExecuteScalar(sql).ToString());
            this.LabelCount.Text = this.LabelCount.Text = "共有会员 " + num.ToString() + " 个";
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
            this.DropDownListPage.SelectedIndex = 0;
            base2.Dispose();
        }

        private void ZdlList()
        {
            string sql = "SELECT userid,username FROM agence WHERE classid=3";
            if (this.DropDownListGd.SelectedValue != "")
            {
                sql = sql + " AND gdid=" + this.DropDownListGd.SelectedValue;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            this.DropDownListZdl.Items.Clear();
            this.DropDownListZdl.Items.Add(new ListItem("请选择", "0"));
            while (reader.Read())
            {
                this.DropDownListZdl.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            this.DropDownListZdl.Items.Add(new ListItem("全部", ""));
            reader.Close();
            base2.Dispose();
        }
    }
}

