namespace newball.zdl
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
        protected DropDownList DropDownListAccountStatus;
        protected DropDownList DropDownListDls;
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
            string sql = "SELECT COUNT(*) FROM member WHERE zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim();
            if (this.DropDownListAccountStatus.SelectedValue != "")
            {
                sql = sql + " AND isuseable=" + this.DropDownListAccountStatus.SelectedValue;
            }
            if (this.DropDownListDls.SelectedValue != "")
            {
                sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
            }
            this.LabelCount.Text = "共有会员 " + base2.ExecuteScalar(sql).ToString() + " 个";
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
            string sql = "SELECT userid,username,xzcount,usemoney,truename,regtime,dlsname,dlsid,isuseable,moneysort,usertype,pltype,jsdatetime FROM member WHERE 1=1";
            if (flag.Trim() != "")
            {
                sql = sql + " AND isuseable=" + flag;
            }
            if ((this.DropDownListDls.SelectedValue.Trim() != "") && (this.DropDownListDls.SelectedValue != null))
            {
                sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
            }
            sql = sql + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " ORDER BY userid";
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

        public string DelItem(string str, string id, string dlsid)
        {
            if (int.Parse(str.Trim()) < 1)
            {
                return (" / <a href=userlist.aspx?action=del&id=" + id + "&did=" + dlsid + "&dlsid=" + this.DropDownListDls.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要删除该会员吗?')\">删除</a>");
            }
            return "";
        }

        public void DelUser(string id, string dlsid)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                int num = (int) base2.ExecuteScalar("SELECT xzcount FROM member WHERE userid=" + id + " AND dlsid=" + dlsid);
                if (num > 0)
                {
                    base2.Dispose();
                    MyFunc.showmsg("该会员有注单,不能删除该会员");
                    base.Response.End();
                }
                else if (base2.ExecuteNonQuery("DELETE FROM member WHERE userid=" + id + " AND dlsid=" + dlsid) > 0)
                {
                    base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount-1 WHERE dlsid=" + dlsid);
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

        private void DlsList()
        {
            string sql = "SELECT userid,username FROM agence WHERE zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " AND classid=4";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            this.DropDownListDls.Items.Clear();
            this.DropDownListDls.Items.Add(new ListItem("请选择", "0"));
            while (reader.Read())
            {
                this.DropDownListDls.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
            }
            reader.Close();
            base2.Dispose();
            this.DropDownListDls.Items.Add(new ListItem("全部", ""));
        }

        public void DropDownListAccountStatus_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.countmem();
            this.PageList(this.DropDownListAccountStatus.SelectedValue.Trim());
            this.TextBoxSortField.Text = "";
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue.Trim(), this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListDls_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.countmem();
            this.PageList(this.DropDownListAccountStatus.SelectedValue.Trim());
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListPage_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
        }

        public void DropDownListZdl_SelectedIndexChanged(object sender, EventArgs e)
        {
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        public string kygl(string userid, string username)
        {
            return ("<a href=userlist_reportlist.aspx?userid=" + userid + "&username=" + username + ">" + username + "</a>");
        }

        public string kygl(string uid, string did, string flag)
        {
            return ("<a href=userlist.aspx?action=js&id=" + uid + "&dlsid=" + this.DropDownListDls.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + ">结帐</a>/<a href=userlist.aspx?action=re&id=" + uid + "&dlsid=" + this.DropDownListDls.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + ">回复</a>/" + this.OpItem(flag, uid, did) + "/<a href=usermsg.aspx?id=" + uid + ">详情</a>/<a href=userset.aspx?id=" + uid + ">设定</a>");
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
                return ("<a href=userlist.aspx?action=Close&id=" + id + "&did=" + dlsid + "&dlsid=" + this.DropDownListDls.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要停用该会员吗?')\">停用</a>");
            }
            return ("<a href=userlist.aspx?action=Open&id=" + id + "&did=" + dlsid + "&dlsid=" + this.DropDownListDls.SelectedValue + "&flag=" + this.DropDownListAccountStatus.SelectedValue + " onClick=\"return confirm('确定要启用该会员吗?')\">启用</a>");
        }

        private void OpUser(string flag, string id, string dlsid)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
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
                    string text = reader["zdlid"].ToString().Trim();
                    string text2 = reader["gdid"].ToString().Trim();
                    reader.Close();
                    int num = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + dlsid).ToString());
                    if (num > 0)
                    {
                        int num2 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + dlsid + " AND isuseable=1").ToString());
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
                base2.ExecuteNonQuery("UPDATE member SET isuseable=" + flag + " WHERE userid=" + id + " AND dlsid=" + dlsid);
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
                this.LabelZdl.Text = this.Session.Contents["adminusername"].ToString().Trim();
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if ((((base.Request.QueryString["action"] != null) && (base.Request.QueryString["id"] != null)) && ((base.Request.QueryString["id"].ToString().Trim() != "") && (base.Request.QueryString["did"] != null))) && (base.Request.QueryString["did"].ToString().Trim() != ""))
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
                if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["id"] != null))
                {
                    if (((base.Request.QueryString["action"].ToString().Trim() == "js") && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                    {
                        base2.ExecuteNonQuery("UPDATE member SET jsdatetime=GetDate() WHERE userid=" + base.Request.QueryString["id"].ToString().Trim() + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                    }
                    if (((base.Request.QueryString["action"].ToString().Trim() == "re") && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                    {
                        base2.ExecuteNonQuery("UPDATE member SET jsdatetime=null WHERE userid=" + base.Request.QueryString["id"].ToString().Trim() + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                    }
                }
                this.DlsList();
                if ((base.Request.QueryString["dlsid"] != null) && (base.Request.QueryString["dlsid"].ToString().Trim() != ""))
                {
                    this.DropDownListDls.SelectedValue = base.Request.QueryString["dlsid"].ToString().Trim();
                }
                else
                {
                    this.DropDownListDls.SelectedIndex = 0;
                }
                if ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != ""))
                {
                    this.DropDownListAccountStatus.SelectedValue = base.Request.QueryString["flag"].ToString().Trim();
                }
                base2.Dispose();
                this.countmem();
                this.PageList(this.DropDownListAccountStatus.SelectedValue);
                this.DataGridDataBind(this.DropDownListAccountStatus.SelectedValue, this.TextBoxSortField.Text, int.Parse(this.DropDownListPage.SelectedValue));
            }
        }

        private void PageList(string flag)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT COUNT(1) FROM member WHERE zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim();
            if (flag != "")
            {
                sql = sql + " AND isuseable=" + flag;
            }
            if (this.DropDownListDls.SelectedValue != "")
            {
                sql = sql + " AND dlsid=" + this.DropDownListDls.SelectedValue;
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

