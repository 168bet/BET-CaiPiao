namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Text;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class tzinfo : Page
    {
        protected HtmlInputHidden ballid;
        protected HtmlInputHidden marker;
        protected HtmlTable showContent;
        protected Label sumPages;
        protected DropDownList thePages;
        protected HtmlInputHidden tzType;

        private string GetSqlStr()
        {
            if (this.tzType.Value == "20")
            {
                return ("SELECT csdls,tzmoney as csres,hsuser_w,hsuser_l,abc,updatetime,username,tzType,content,tzmoney,win-lose as result,csgd FROM ball_order WHERE tztype='" + this.tzType.Value + "' and DATEDIFF(dd, GETDATE(), updatetime)=0 ");
            }
            if (this.tzType.Value == "16")
            {
                return ("SELECT csdls,tzmoney as csres,hsuser_w,hsuser_l,abc,updatetime,username,tzType,content,tzmoney,win-lose as result,csgd FROM ball_order WHERE tzteam like '%" + this.ballid.Value + "%' and DATEDIFF(dd, GETDATE(), updatetime)=0 ");
            }
            return ("SELECT csdls,tzmoney as csres,hsuser_w,hsuser_l,abc,updatetime,username,tzType,content,tzmoney,win-lose as result,csgd FROM ball_order WHERE ballid in (" + this.ballid.Value + ") and DATEDIFF(dd, GETDATE(), updatetime)=0");
        }

        private string GetSumSqlStr()
        {
            if (this.tzType.Value == "20")
            {
                return ("SELECT count(*) FROM ball_order WHERE tztype='" + this.tzType.Value + "' and DATEDIFF(dd, GETDATE(), updatetime)=0 ");
            }
            if (this.tzType.Value == "16")
            {
                return ("SELECT count(*) FROM ball_order WHERE tzteam like '" + this.ballid.Value + "' and DATEDIFF(dd, GETDATE(), updatetime)=0 ");
            }
            return ("SELECT count(*) FROM ball_order WHERE ballid in (" + this.ballid.Value + ") and DATEDIFF(dd, GETDATE(), updatetime)=0");
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
            if ((!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1)) && (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2)))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (base.Request.QueryString["gameid"] != null)
            {
                this.ballid.Value = base.Request.QueryString["gameid"].ToString();
                this.tzType.Value = base.Request.QueryString["tzType"].ToString();
                this.marker.Value = base.Request.QueryString["marker"].ToString();
                this.setShowContent();
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
            this.thePages.Items.Clear();
            for (int i = 1; i <= num; i++)
            {
                this.thePages.Items.Add(new ListItem(i.ToString(), i.ToString()));
            }
            this.thePages.SelectedIndex = curpage - 1;
            this.sumPages.Text = num.ToString();
        }

        private void setShowContent()
        {
            int curpage;
            int start;
            string sql = this.GetSqlStr();
            string sumSqlStr = this.GetSumSqlStr();
            string tzTypeName = MyFunc.GettzTypeName(this.tzType.Value);
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            StringBuilder builder = new StringBuilder();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int pagesize = 100;
            try
            {
                curpage = int.Parse(this.thePages.SelectedValue);
            }
            catch
            {
                curpage = 1;
            }
            if (curpage < 1)
            {
                curpage = 1;
            }
            builder.Append("<table border=0 cellspacing=1 cellpadding=0 width=100% class=tableBorder1>\n");
            builder.Append("<tr class='dlsheader'><td width=10%>时间</td><td width=15%>会员(win/lose)</td><td width=10%>方式</td><td width=25%>详情</td><td width=10%>注额</td><td width=10%>成数</td><td width=10%>注额（成数）</td><td width=10%>结果</td></tr>\n");
            int totalrecord = int.Parse(base2.ExecuteScalar(sumSqlStr).ToString());
            if (totalrecord == 0)
            {
                start = 0;
            }
            else
            {
                start = (curpage - 1) * pagesize;
            }
            DataSet set = base2.ExecuteDataSet(sql, start, pagesize, "ball_order");
            int num9 = 0;
            for (int i = 1; num9 < set.Tables[0].Rows.Count; i++)
            {
                builder.Append("<tr bgcolor=#ffffff align=right>");
                builder.Append("<td align=center>");
                builder.Append(DateTime.Parse(set.Tables[0].Rows[num9]["updatetime"].ToString().Trim()).ToString("yyyy-MM-dd HH:mm:ss").ToUpper().Replace(" ", "<br>"));
                builder.Append("</td><td align=center nowrap><table border=0 cellpadding=1 cellspacing=0 width=100%><tr><td><font color=red>");
                builder.Append(set.Tables[0].Rows[num9]["abc"].ToString());
                builder.Append("</font>&nbsp;");
                builder.Append(set.Tables[0].Rows[num9]["username"].ToString());
                builder.Append("&nbsp;</td><td nowrap><font color=red>");
                builder.Append(Convert.ToDouble(set.Tables[0].Rows[num9]["hsuser_w"]).ToString("F2"));
                builder.Append("</font>/<font color=red>");
                builder.Append(Convert.ToDouble(set.Tables[0].Rows[num9]["hsuser_l"]).ToString("F2"));
                builder.Append("</font></td></tr></table></td>");
                builder.Append("<td align=center><font color=blue>");
                builder.Append(tzTypeName);
                builder.Append("</td><td>");
                builder.Append(set.Tables[0].Rows[num9]["content"].ToString());
                builder.Append("</td><td>");
                builder.Append(MyFunc.NumBerFormat(set.Tables[0].Rows[num9]["tzmoney"].ToString()));
                builder.Append("</td><td>");
                builder.Append(Convert.ToDouble(set.Tables[0].Rows[num9]["csgd"]).ToString("F1"));
                builder.Append("</td><td>");
                builder.Append(MyFunc.NumBerFormat(set.Tables[0].Rows[num9]["csres"].ToString()));
                builder.Append("</td><td>");
                builder.Append(MyFunc.NumBerFormat(set.Tables[0].Rows[num9]["result"].ToString()));
                builder.Append("</td></tr>\n");
                num++;
                num2 += double.Parse(set.Tables[0].Rows[num9]["tzmoney"].ToString());
                num3 += double.Parse(set.Tables[0].Rows[num9]["csres"].ToString());
                num4 += double.Parse(set.Tables[0].Rows[num9]["result"].ToString());
                num9++;
            }
            if (set.Tables[0].Rows.Count == 0)
            {
                builder.Append("<tr bgcolor=#ffffff><td colspan=9 align=center height=30><marquee align=middle behavior=alternate width=200><font color=red size=2><b>没有资料</b></font></marquee></td></tr>\n");
            }
            else
            {
                builder.Append("<tr bgcolor=#dfefff height=22 class=reportTotalnum><td colspan=4 align=right>");
                builder.Append(num.ToString());
                builder.Append("</td><td align=right>");
                builder.Append(num2.ToString());
                builder.Append("</td><td align=right>&nbsp;");
                builder.Append("</td><td align=right>");
                builder.Append(num3.ToString());
                builder.Append("</td><td align=right >");
                builder.Append(num4.ToString());
                builder.Append("</td></tr>");
            }
            builder.Append("</table>\n");
            set.Clear();
            base2.CloseConnect();
            base2.Dispose();
            this.showContent.Rows[0].Cells[0].InnerHtml = builder.ToString();
            this.setselectpageproc(pagesize, totalrecord, curpage);
        }
    }
}

