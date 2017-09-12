namespace newball.dls
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

    public class mgruser : Page
    {
        protected HtmlSelect agenceid;
        protected HtmlInputButton appendbutton;
        protected HtmlSelect selectpage;
        protected HtmlSelect sortenable;
        protected HtmlSelect sortname;
        protected HtmlSelect sortorderby;
        protected HtmlGenericControl sumpages;
        protected HtmlTable userLists;

        private void getUserLists()
        {
            string sql;
            int curpage;
            int start;
            string text = "";
            string text2 = "";
            string text3 = "";
            int pagesize = 20;
            try
            {
                curpage = int.Parse(this.selectpage.Value);
            }
            catch
            {
                curpage = 1;
            }
            if (curpage < 1)
            {
                curpage = 1;
            }
            text3 = " order by " + this.sortname.Value.Trim() + " " + this.sortorderby.Value.Trim();
            if (this.sortenable.Value.Trim() != "")
            {
                text2 = "select userid,username,truename,pltype,usertype,usemoney,moneysort,regtime,dlsname,isuseable from member WHERE dlsname='" + this.Session["adminusername"].ToString().Trim() + "' and isuseable =" + this.sortenable.Value + " " + text3;
                sql = "SELECT COUNT(*) FROM member WHERE dlsname='" + this.Session["adminusername"].ToString().Trim() + "' and isuseable =" + this.sortenable.Value;
            }
            else
            {
                text2 = "select userid,username,truename,pltype,usertype,usemoney,moneysort,regtime,dlsname,isuseable from member where dlsname='" + this.Session["adminusername"].ToString().Trim() + "' " + text3;
                sql = "SELECT COUNT(*) FROM member WHERE dlsname='" + this.Session["adminusername"].ToString().Trim() + "'";
            }
            text = text + "<table width='755' cellspacing=1 cellpadding=2 border=0 class=tableNoBorder1>\n<tr class='dlsheader'>\n" + "<td>会员帐号</td><td>会员名称</td><td>代理商</td><td>赔率种类</td><td>现金/信用</td><td>使用币种</td><td>信用额度</td><td>新增时间</td><td>状态</td><td>功能</td></tr>";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int totalrecord = int.Parse(base2.ExecuteScalar(sql).ToString());
            if (totalrecord == 0)
            {
                start = 0;
            }
            else
            {
                if (((curpage - 1) * pagesize) >= totalrecord)
                {
                    curpage = 1;
                }
                start = (curpage - 1) * pagesize;
            }
            DataSet set = base2.ExecuteDataSet(text2, start, pagesize, "member");
            for (int i = 0; i < set.Tables[0].Rows.Count; i++)
            {
                if (set.Tables[0].Rows[i]["isuseable"].ToString().ToLower() == "true")
                {
                    if ((i % 2) == 0)
                    {
                        text = text + "<tr align=center bgColor='#FFFFFF' height=22 onmouseover=light_bar(this,'ovr') onmouseout=light_bar(this,'out')>";
                    }
                    else
                    {
                        text = text + "<tr align=center bgColor='#efefef' height=22 onmouseover=light_bar(this,'ovr') onmouseout=light_bar(this,'out')>";
                    }
                    string text5 = text;
                    text = ((((((((((((text5 + "<td><a href='mgruser_reportlist.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "&username=" + set.Tables[0].Rows[i]["username"].ToString().Trim() + "'>" + set.Tables[0].Rows[i]["username"].ToString() + "</a></td>") + "<td>" + set.Tables[0].Rows[i]["truename"].ToString() + "</td>") + "<td>" + this.Session["adminusername"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["pltype"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["usertype"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["moneysort"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["usemoney"].ToString() + "</td>") + "<td align=center nowrap>" + DateTime.Parse(set.Tables[0].Rows[i]["regtime"].ToString()).ToString("yyyy-MM-dd HH:mm:ss") + "</td>") + "<td><font color=blue>正常</font></td>") + "<td align=center><a href=\"javascript:if(confirm('确定停用！')){lockproc('0','" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "');}\">停用</a>&nbsp;/&nbsp;") + "<a href='adduser.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "'>详情</a>&nbsp;/&nbsp;") + "<a href='edituser.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "'>设定</a>") + "</td></tr>";
                }
                else
                {
                    if ((i % 2) == 0)
                    {
                        text = text + "<tr align=center bgColor='#FFFFFF' height=22 onmouseover=light_bar(this,'ovr') onmouseout=light_bar(this,'out')>";
                    }
                    else
                    {
                        text = text + "<tr align=center bgColor='#efefef' height=22 onmouseover=light_bar(this,'ovr') onmouseout=light_bar(this,'out')>";
                    }
                    string text6 = text;
                    text = ((((((((((((text6 + "<td style='color:#666666'><a href='mgruser_reportlist.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "&username=" + set.Tables[0].Rows[i]["username"].ToString().Trim() + "'>" + set.Tables[0].Rows[i]["username"].ToString() + "</a></td>") + "<td style='color:#666666'>" + set.Tables[0].Rows[i]["truename"].ToString() + "</td>") + "<td style='color:#666666'>" + this.Session["adminusername"].ToString() + "</td>") + "<td style='color:#666666'>" + set.Tables[0].Rows[i]["pltype"].ToString() + "</td>") + "<td style='color:#666666'>" + set.Tables[0].Rows[i]["usertype"].ToString() + "</td>") + "<td style='color:#666666'>" + set.Tables[0].Rows[i]["moneysort"].ToString() + "</td>") + "<td style='color:#666666'>" + set.Tables[0].Rows[i]["usemoney"].ToString() + "</td>") + "<td style='color:#666666' align=center nowrap>" + DateTime.Parse(set.Tables[0].Rows[i]["regtime"].ToString()).ToString("yyyy-MM-dd HH:mm:ss") + "</td>") + "<td style='color:#ff0000'>停用</td>") + "<td align=center><a href=\"javascript:if(confirm('确定启用！')){lockproc('1','" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "');}\">启用</a>&nbsp;/&nbsp;") + "<a href='adduser.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "'>详情</a>&nbsp;/&nbsp;") + "<a href='edituser.aspx?userid=" + set.Tables[0].Rows[i]["userid"].ToString().Trim() + "'>设定</a>") + "</td></tr>";
                }
            }
            this.userLists.Rows[0].Cells[0].InnerHtml = text;
            set.Clear();
            base2.CloseConnect();
            base2.Dispose();
            this.setselectpageproc(pagesize, totalrecord, curpage);
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                if (!this.Page.IsPostBack)
                {
                    this.agenceid.Items[0].Value = this.Session["adminusername"].ToString();
                    this.agenceid.Items[0].Text = this.Session["adminusername"].ToString();
                }
                else if (base.Request.QueryString["lockflag"] != null)
                {
                    this.setuserlock(base.Request.QueryString["lockflag"].ToString().Trim(), base.Request.QueryString["userid"].ToString().Trim());
                }
                this.getUserLists();
            }
        }

        private void setselectpageproc(int pagesize, int totalrecord, int curpage)
        {
            int num = 0;
            if (totalrecord > pagesize)
            {
                num = totalrecord / pagesize;
            }
            if ((totalrecord % pagesize) > 0)
            {
                num++;
            }
            this.selectpage.Items.Clear();
            for (int i = 1; i <= num; i++)
            {
                this.selectpage.Items.Add(new ListItem(i.ToString(), i.ToString()));
            }
            this.selectpage.SelectedIndex = curpage - 1;
            this.sumpages.InnerHtml = num.ToString();
        }

        private void setuserlock(string lockflag, string userid)
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            string text4 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT gdid,zdlid from agence where userid='" + this.Session["adminuserid"].ToString().Trim() + "'";
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                text2 = reader["gdid"].ToString();
                text3 = reader["zdlid"].ToString();
                text4 = this.Session["adminuserid"].ToString().Trim();
            }
            reader.Close();
            if (lockflag == "1")
            {
                int num = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text4).ToString());
                if (num > 0)
                {
                    int num2 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text4).ToString());
                    if (num < (num2 + 1))
                    {
                        base2.Dispose();
                        MyFunc.showmsg("该代理商的最大会员数为 " + num.ToString() + ",不能再添加新会员");
                        base.Response.End();
                        return;
                    }
                }
                else
                {
                    int num3 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text3).ToString());
                    if (num3 > 0)
                    {
                        int num4 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE zdlid=" + text3).ToString());
                        if (num3 < (num4 + 1))
                        {
                            base2.Dispose();
                            MyFunc.showmsg("您的最大会员数为 " + num.ToString() + ",不能再添加新会员");
                            base.Response.End();
                            return;
                        }
                    }
                    else
                    {
                        int num5 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text2).ToString());
                        if (num5 > 0)
                        {
                            int num6 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid=" + text2).ToString());
                            if (num5 < (num6 + 1))
                            {
                                base2.Dispose();
                                MyFunc.showmsg("该股东的最大会员数为 " + num.ToString() + ",不能再添加新会员");
                                base.Response.End();
                                return;
                            }
                        }
                    }
                }
            }
            base2.ExecuteNonQuery("UPDATE member set isuseable =" + lockflag + " WHERE userid = '" + userid + "'");
            base2.CloseConnect();
            base2.Dispose();
        }
    }
}

