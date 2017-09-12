namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class reportshowdls : Page
    {
        private string ballType = "";
        private string cashSql = "";
        private string creditSql = "";
        private string endTime = "";
        private string pathStr = "";
        private string reportType = "";
        private string search = "";
        private string startTime = "";
        protected HtmlTable tableBarMenu;
        protected HtmlTable tableHeader;
        protected HtmlTable tableMiddle;
        private string tzCase = "";
        private string tzType = "";
        private string zdlid = "";

        private void Deal(string sql)
        {
            string text = "";
            int num = 0;
            int num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            double num7 = 0;
            double num8 = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsreport><td width=8%>代理商</td><td width=5%>笔数</td><td width=13%>会员投注金额</td><td width=13%>会员</td><td width=13%>代理商金额</td><td width=13%>代理商</td><td width=5%>成数</td><td width=13%>总代理金额</td><td width=13%>总代理</td><td width=5%>成数</td></tr>\n";
            while (reader.Read())
            {
                num++;
                string text2 = text + "<tr bgcolor=white align=right height=22>";
                string text3 = (text2 + "<td align=center><a href='dlslist_reportlist.aspx?userid=" + reader["dlsid"].ToString() + "&username=" + reader["dlsname"].ToString() + "'>" + reader["dlsname"].ToString() + "</a></td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = ((((((((text3 + "<td><a href='reportshowuser.aspx?" + this.pathStr + "&dlsid=" + reader["dlsid"].ToString() + "'><font color=blue>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmdls"].ToString()) + "</td>") + "<td>" + Convert.ToDouble(reader["csdls"]).ToString("F1") + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmzdl"].ToString()) + "</td>") + "<td>" + Convert.ToDouble(reader["cszdl"]).ToString("F1") + "</td>") + "</tr>\n";
                num2 += int.Parse(reader["tzNumber"].ToString());
                num3 += double.Parse(reader["tzmoney"].ToString());
                num4 += double.Parse(reader["result"].ToString());
                num7 += double.Parse(reader["csmdls"].ToString());
                num8 += double.Parse(reader["mdls"].ToString());
                num5 += double.Parse(reader["csmzdl"].ToString());
                num6 += double.Parse(reader["mzdl"].ToString());
            }
            reader.Close();
            base2.Dispose();
            text = (((((((((text + "<tr height=22 class=reportTotalnum><td class=reportTotalchar>总 数</td>") + "<td>" + num2.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num8.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num7.ToString()) + "</td>") + "<td>&nbsp;</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "<td>&nbsp;</td></tr>" + "</table>\n";
            if (this.search.ToLower() == "credit")
            {
                this.tableHeader.Rows[1].Cells[0].InnerHtml = text;
            }
            else
            {
                this.tableMiddle.Rows[1].Cells[0].InnerHtml = text;
            }
        }

        private string GetReportType(string reportTypeStr)
        {
            switch (reportTypeStr.ToLower())
            {
                case "ledger":
                    return "全部";

                case "breakdown":
                    return "分类帐";

                case "soccer":
                    return "足球";

                case "basketball":
                    return "篮球";
            }
            return "";
        }

        private string GettzCaseName(string tzCaseStr)
        {
            switch (tzCaseStr.ToLower())
            {
                case "all":
                    return "全部";

                case "credit":
                    return "信用";

                case "cash":
                    return "现金";
            }
            return "";
        }

        private void GetValue()
        {
            this.search = base.Request.QueryString["search"].ToString();
            this.startTime = base.Request.QueryString["startTime"].ToString();
            this.endTime = base.Request.QueryString["endTime"].ToString();
            this.reportType = base.Request.QueryString["reportType"].ToString();
            this.tzCase = base.Request.QueryString["tzCase"].ToString();
            this.tzType = base.Request.QueryString["tzType"].ToString();
            this.ballType = base.Request.QueryString["ballType"].ToString();
            this.zdlid = base.Request.QueryString["zdlid"].ToString();
            this.pathStr = "search=" + this.search;
            this.pathStr = this.pathStr + "&startTime=" + this.startTime;
            this.pathStr = this.pathStr + "&endTime=" + this.endTime;
            this.pathStr = this.pathStr + "&reportType=" + this.reportType;
            this.pathStr = this.pathStr + "&tzCase=" + this.tzCase;
            this.pathStr = this.pathStr + "&tzType=" + this.tzType;
            this.pathStr = this.pathStr + "&ballType=" + this.ballType;
            this.creditSql = "select dlsid,(select username from agence where userid =ball_order.dlsid) as dlsname,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mdls) as mdls,sum(mdls*csdls) as csmdls,sum(mzdl) as mzdl,sum(mzdl*cszdl) as csmzdl,isnull(sum(csdls)/count(*),0) as csdls,isnull(sum(cszdl)/count(*),0) as cszdl FROM ball_order WHERE userid in (select userid from member where usertype='信用' and zdlid = '" + this.zdlid + "') and zdlid = '" + this.zdlid + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by dlsid";
            this.cashSql = "select dlsid,(select username from agence where userid =ball_order.dlsid) as dlsname,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mdls) as mdls,sum(mdls*csdls) as csmdls,sum(mzdl) as mzdl,sum(mzdl*cszdl) as csmzdl,isnull(sum(csdls)/count(*),0) as csdls,isnull(sum(cszdl)/count(*),0) as cszdl FROM ball_order WHERE userid in (select userid from member where usertype='现金' and zdlid = '" + this.zdlid + "') and zdlid = '" + this.zdlid + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by dlsid";
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
            else if (!this.Page.IsPostBack)
            {
                if (base.Request.QueryString["search"] != null)
                {
                    if (base.Request["search"].ToString() != "")
                    {
                        this.GetValue();
                        this.PrintBarTitle();
                        this.SetShowPage();
                    }
                }
                else
                {
                    base.Response.Write("查询页面出错，请检测你的查询条件！");
                    base.Response.End();
                }
            }
        }

        private void PrintBarTitle()
        {
            if ((this.Session.Contents["adminsubid"] != null) && (this.Session.Contents["adminsubid"].ToString() != ""))
            {
                this.tableBarMenu.Rows[0].Cells[0].InnerHtml = "&nbsp;&nbsp;管理员子帐户:" + this.Session.Contents["adminsubname"].ToString() + "&nbsp;&nbsp;日期区间:" + this.startTime + "~~" + this.endTime + "&nbsp;--&nbsp;报表:" + this.GetReportType(this.reportType) + "&nbsp;--&nbsp;信用/现金:" + this.GettzCaseName(this.tzCase) + "&nbsp;--&nbsp;方式:" + MyFunc.GettzTypeName(this.tzType) + "&nbsp;--&nbsp;<a href='javascript:window.history.back();'>返回</a>";
            }
            else
            {
                this.tableBarMenu.Rows[0].Cells[0].InnerHtml = "&nbsp;&nbsp;管理员:" + this.Session.Contents["adminusername"].ToString() + "&nbsp;&nbsp;日期区间:" + this.startTime + "~~" + this.endTime + "&nbsp;--&nbsp;报表:" + this.GetReportType(this.reportType) + "&nbsp;--&nbsp;信用/现金:" + this.GettzCaseName(this.tzCase) + "&nbsp;--&nbsp;方式:" + MyFunc.GettzTypeName(this.tzType) + "&nbsp;--&nbsp;<a href='javascript:window.history.back();'>返回</a>";
            }
        }

        private void SetShowPage()
        {
            switch (this.search.ToLower())
            {
                case "credit":
                    this.tableMiddle.Visible = false;
                    this.Deal(this.creditSql);
                    break;

                case "cash":
                    this.tableHeader.Visible = false;
                    this.Deal(this.cashSql);
                    break;
            }
        }
    }
}

