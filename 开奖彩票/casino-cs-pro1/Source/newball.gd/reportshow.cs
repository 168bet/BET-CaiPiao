namespace newball.gd
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class reportshow : Page
    {
        private string allPartSql = "";
        private string allSql = "";
        private string ballType = "";
        private string cashPartSql = "";
        private string cashSql = "";
        private string creditPartSql = "";
        private string creditSql = "";
        private string endTime = "";
        private string pathPartStr = "";
        private string pathStr = "";
        private string reportType = "";
        private string startTime = "";
        protected HtmlTable tableBarMenu;
        protected HtmlTable tableBottom;
        protected HtmlTable tableHeader;
        protected HtmlTable tableMiddle;
        private string tzCase = "";
        private string tzType = "";

        private void AllDeal()
        {
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.ShowCreditContent(db);
                    this.ShowCashContent(db);
                    this.ShowZongShuContent(db);
                    break;

                case "breakdown":
                    this.ShowCreditPartContent(db);
                    this.ShowCashPartContent(db);
                    this.ShowZongShuPartContent(db);
                    break;
            }
            db.CloseConnect();
            db.Dispose();
        }

        private void CashDeal()
        {
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.tableHeader.Visible = false;
                    this.ShowCashContent(db);
                    this.tableBottom.Visible = false;
                    break;

                case "breakdown":
                    this.tableHeader.Visible = false;
                    this.ShowCashPartContent(db);
                    this.tableBottom.Visible = false;
                    break;
            }
            db.CloseConnect();
            db.Dispose();
        }

        private void CreditDeal()
        {
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.ShowCreditContent(db);
                    this.tableMiddle.Rows[1].Cells[0].InnerHtml = MyFunc.GuodanContent("总代理", this.startTime, this.endTime, this.pathStr, db);
                    this.tableBottom.Visible = false;
                    break;

                case "breakdown":
                    this.ShowCreditPartContent(db);
                    this.tableMiddle.Visible = false;
                    this.tableBottom.Visible = false;
                    break;
            }
            db.CloseConnect();
            db.Dispose();
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
            this.startTime = base.Request.QueryString["startTime"].ToString();
            this.endTime = base.Request.QueryString["endTime"].ToString();
            this.reportType = base.Request.QueryString["reportType"].ToString();
            this.tzCase = base.Request.QueryString["tzCase"].ToString();
            this.tzType = base.Request.QueryString["tzType"].ToString();
            this.pathStr = "";
            this.pathStr = this.pathStr + "&startTime=" + this.startTime;
            this.pathStr = this.pathStr + "&endTime=" + this.endTime;
            this.pathStr = this.pathStr + "&reportType=" + this.reportType;
            this.pathStr = this.pathStr + "&tzCase=" + this.tzCase;
            this.pathStr = this.pathStr + "&tzType=" + this.tzType;
            this.pathStr = this.pathStr + "&ballType=" + this.ballType;
            this.pathPartStr = "";
            this.pathPartStr = this.pathPartStr + "&startTime=" + this.startTime;
            this.pathPartStr = this.pathPartStr + "&endTime=" + this.endTime;
            this.pathPartStr = this.pathPartStr + "&reportType=" + this.reportType;
            this.pathStr = this.pathStr + "&tzCase=" + this.tzCase;
            this.pathPartStr = this.pathPartStr + "&ballType=" + this.ballType;
            this.creditSql = "select sum(mgd*csgd) as csmgd,sum(mzdl*cszdl) as csmzdl,sum(mdls*csdls) as csmdls,isnull(sum(csdls*tzmoney),0) as dlsmoney,isnull(sum(cszdl*tzmoney),0) as zdlmoney,isnull(sum(csgd*tzmoney),0) as gdmoney,zdlid,(select username from agence where userid =ball_order.zdlid) as zdlname,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mgd) as mgd,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order WHERE userid in (select userid from member where usertype='信用' and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "') and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by zdlid";
            this.cashSql = "select sum(mgd*csgd) as csmgd,sum(mzdl*cszdl) as csmzdl,sum(mdls*csdls) as csmdls,isnull(sum(csdls*tzmoney),0) as dlsmoney,isnull(sum(cszdl*tzmoney),0) as zdlmoney,isnull(sum(csgd*tzmoney),0) as gdmoney,zdlid,(select username from agence where userid =ball_order.zdlid) as zdlname,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mgd) as mgd,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order WHERE userid in (select userid from member where usertype='现金' and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "') and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by zdlid";
            this.allSql = "SELECT count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order WHERE gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ")";
            this.creditPartSql = "SELECT sum(mgd*csgd) as csmgd,sum(mzdl*cszdl) as csmzdl,sum(mdls*csdls) as csmdls,dbo.GettzType_Func(tzType) as tzTypeName,tzType,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls,sum(mgd) as mgd FROM ball_order WHERE userid in (select userid from member where usertype='信用' and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "') and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by tzType";
            this.cashPartSql = "SELECT sum(mgd*csgd) as csmgd,sum(mzdl*cszdl) as csmzdl,sum(mdls*csdls) as csmdls,dbo.GettzType_Func(tzType) as tzTypeName,tzType,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls,sum(mgd) as mgd FROM ball_order WHERE userid in (select userid from member where usertype='现金' and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "') and gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by tzType";
            this.allPartSql = "SELECT count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls,sum(mgd) as mgd FROM ball_order WHERE gdid = '" + this.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + this.startTime + "',balltime) > 0 and datediff(d,balltime,'" + this.endTime + "') >= 0 and tzType in (" + MyFunc.GettzType(this.tzType) + ")";
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
            else if ((!this.Page.IsPostBack && (base.Request.QueryString["search"] != null)) && (base.Request["search"].ToString() == "search"))
            {
                this.GetValue();
                this.PrintBarTitle();
                this.SetShowPage();
            }
        }

        private void PrintBarTitle()
        {
            if ((this.Session.Contents["adminsubid"] != null) && (this.Session.Contents["adminsubid"].ToString() != ""))
            {
                this.tableBarMenu.Rows[0].Cells[0].InnerHtml = "&nbsp;&nbsp;股东子帐户:" + this.Session.Contents["adminsubname"].ToString() + "&nbsp;&nbsp;日期区间:" + this.startTime + "~~" + this.endTime + "&nbsp;--&nbsp;报表:" + this.GetReportType(this.reportType) + "&nbsp;--&nbsp;信用/现金:" + this.GettzCaseName(this.tzCase) + "&nbsp;--&nbsp;方式:" + MyFunc.GettzTypeName(this.tzType) + "&nbsp;--&nbsp;<a href='javascript:window.history.back();'>返回</a>";
            }
            else
            {
                this.tableBarMenu.Rows[0].Cells[0].InnerHtml = "&nbsp;&nbsp;股东:" + this.Session.Contents["adminusername"].ToString() + "&nbsp;&nbsp;日期区间:" + this.startTime + "~~" + this.endTime + "&nbsp;--&nbsp;报表:" + this.GetReportType(this.reportType) + "&nbsp;--&nbsp;信用/现金:" + this.GettzCaseName(this.tzCase) + "&nbsp;--&nbsp;方式:" + MyFunc.GettzTypeName(this.tzType) + "&nbsp;--&nbsp;<a href='javascript:window.history.back();'>返回</a>";
            }
        }

        private void SetShowPage()
        {
            if (this.ballType.ToString().ToLower() != "basketball")
            {
                switch (this.tzCase.ToLower())
                {
                    case "all":
                        this.CreditDeal();
                        return;

                    case "credit":
                        this.CreditDeal();
                        break;

                    case "cash":
                        this.CashDeal();
                        break;
                }
            }
            else
            {
                this.tableHeader.Visible = false;
                this.tableMiddle.Visible = false;
                this.tableBottom.Visible = false;
            }
        }

        private void ShowCashContent(DataBase db)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            double num7 = 0;
            double num8 = 0;
            double num9 = 0;
            SqlDataReader reader = db.ExecuteReader(this.cashSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableborder1 width=100%>\n";
            text = text + "<tr class=pinkheader><td width=8%>总代理</td><td width=5%>投注数</td><td width=15%>投注额</td><td width=12%>会员</td><td width=10%>代理商金额</td><td width=10%>代理商</td><td width=10%>总代理金额</td><td width=10%>总代理</td></tr>\n";
            while (reader.Read())
            {
                string text2 = ((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["zdlname"].ToString() + "</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = ((((((((text2 + "<td><a href='reportshowdls.aspx?search=cash" + this.pathStr + "&zdlid=" + reader["zdlid"].ToString() + "'><font color=blue>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mgd"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmgd"].ToString()) + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num3 += double.Parse(reader["mdls"].ToString());
                num4 += double.Parse(reader["csmdls"].ToString());
                num5 += double.Parse(reader["mzdl"].ToString());
                num6 += double.Parse(reader["csmzdl"].ToString());
                num7 += double.Parse(reader["mgd"].ToString());
                num8 += double.Parse(reader["csmgd"].ToString());
                num9 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = ((((((((((text + "<tr class=reportTotalnum align=right height=22><td class=reportTotalchar>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num2.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num9.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num7.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num8.ToString()) + "</td>") + "</tr></table>\n";
            this.tableMiddle.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowCashPartContent(DataBase db)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            SqlDataReader reader = db.ExecuteReader(this.cashPartSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableborder1 width=100%>\n";
            text = text + "<tr class=pinkheader><td width=8%>投注方式</td><td width=5%>投注数</td><td width=15%>投注额</td><td width=12%>会员</td><td width=10%>代理商</td><td width=10%>总代理</td><td width=10%>股东</td><td width=10%>备注</td></tr>\n";
            while (reader.Read())
            {
                string text2 = ((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["tzTypeName"].ToString() + "</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = (((((text2 + "<td><a href='reportpartshownext.aspx?search=cash" + this.pathPartStr + "&tzType=" + reader["tzType"].ToString() + "'><font color=blue>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mgd"].ToString()) + "</td>") + "<td>&nbsp;</td>" + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num3 += double.Parse(reader["mdls"].ToString());
                num4 += double.Parse(reader["mzdl"].ToString());
                num5 += double.Parse(reader["mgd"].ToString());
                num6 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = (((((((text + "<tr class=reportTotalnum align=right height=22><td class=reportTotalchar>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num2.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "<td>&nbsp;</td></tr>" + "</table>\n";
            this.tableMiddle.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowCreditContent(DataBase db)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            double num7 = 0;
            double num8 = 0;
            double num9 = 0;
            SqlDataReader reader = db.ExecuteReader(this.creditSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoborder1 width=100%>\n";
            text = text + "<tr class=dlsreport><td width=8%>总代理</td><td width=5% nowrap>笔数</td><td width=15%>会员投注金额</td><td width=12%>会员</td><td width=10%>代理商金额</td><td width=10%>代理商</td><td width=10%>总代理金额</td><td width=10%>总代理</td><td width=10%>股东金额</td><td width=10%>股东</td></tr>\n";
            while (reader.Read())
            {
                string text2 = text + "<tr bgcolor=white align=right height=22>";
                string text3 = (text2 + "<td align=center><a href='zdllist_reportlist.aspx?userid=" + reader["zdlid"].ToString() + "&username=" + reader["zdlname"].ToString() + "'>" + reader["zdlname"].ToString() + "</a></td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = ((((((((text3 + "<td><a href='reportshowdls.aspx?search=credit" + this.pathStr + "&zdlid=" + reader["zdlid"].ToString() + "'><font color=blue>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mgd"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmgd"].ToString()) + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num3 += double.Parse(reader["mdls"].ToString());
                num4 += double.Parse(reader["csmdls"].ToString());
                num5 += double.Parse(reader["mzdl"].ToString());
                num6 += double.Parse(reader["csmzdl"].ToString());
                num7 += double.Parse(reader["mgd"].ToString());
                num8 += double.Parse(reader["csmgd"].ToString());
                num9 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = ((((((((((text + "<tr height=22 class=reportTotalnum><td class=reportTotalchar>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num2.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num9.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num7.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num8.ToString()) + "</td>") + "</tr></table>\n";
            this.tableHeader.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowCreditPartContent(DataBase db)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            double num7 = 0;
            double num8 = 0;
            double num9 = 0;
            SqlDataReader reader = db.ExecuteReader(this.creditPartSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoborder1 width=100%>\n";
            text = text + "<tr class=dlsreport><td width=8%>投注方式</td><td width=5% nowrap>笔数</td><td width=15%>会员投注金额</td><td width=12%>会员</td><td width=10%>代理商金额</td><td width=10%>代理商</td><td width=10%>总代理金额</td><td width=10%>总代理</td><td width=10%>股东金额</td><td width=10%>股东</td></tr>\n";
            while (reader.Read())
            {
                string text2 = ((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["tzTypeName"].ToString() + "</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = ((((((((text2 + "<td><a href='reportpartshownext.aspx?search=credit" + this.pathPartStr + "&tzType=" + reader["tzType"].ToString() + "'><font color=blue>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmdls"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmzdl"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["mgd"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["csmgd"].ToString()) + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num3 += double.Parse(reader["mdls"].ToString());
                num4 += double.Parse(reader["csmdls"].ToString());
                num5 += double.Parse(reader["mzdl"].ToString());
                num6 += double.Parse(reader["csmzdl"].ToString());
                num7 += double.Parse(reader["mgd"].ToString());
                num8 += double.Parse(reader["csmgd"].ToString());
                num9 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = ((((((((((text + "<tr class=reportTotalnum align=right height=22><td class=reportTotalchar>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num2.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num9.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num7.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num8.ToString()) + "</td>") + "</tr></table>\n";
            this.tableHeader.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowZongShuContent(DataBase db)
        {
            string text = "";
            SqlDataReader reader = db.ExecuteReader(this.allSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableborder1 width=100%>\n";
            if (reader.Read())
            {
                text = ((((((((text + "<tr class=reportTotalchar align=right height=22>" + "<td width=10% class=reportTotalchar>总 数</td>") + "<td width=10% align=right>" + reader["tzNumber"].ToString() + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td width=10% align=right>&nbsp;</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td width=10% align=right>&nbsp;</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td></tr>") + "</tr>";
            }
            else
            {
                text = ((((text + "<tr class=reportTotalchar align=right height=22>") + "<td width=10% class=reportTotalchar>总 数</td>" + "<td width=10% align=right>0</td>") + "<td width=10% align=right>0.00</td>" + "<td width=10% align=right>0.00</td>") + "<td width=10% align=right>&nbsp;</td>" + "<td width=10% align=right>0.00</td>") + "<td width=10% align=right>&nbsp;</td>" + "<td width=10% align=right>0.00</td></tr>\n";
            }
            reader.Close();
            text = text + "</table>\n";
            this.tableBottom.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowZongShuPartContent(DataBase db)
        {
            string text = "";
            SqlDataReader reader = db.ExecuteReader(this.allPartSql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableborder1 width=100%>\n";
            if (reader.Read())
            {
                text = (((((((text + "<tr class=reportTotalchar align=right height=22>" + "<td width=10% class=reportTotalchar>总 数</td>") + "<td width=10% align=right>" + reader["tzNumber"].ToString() + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["tzmoney"].ToString()) + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["mdls"].ToString()) + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["mzdl"].ToString()) + "</td>") + "<td width=10% align=right>" + MyFunc.NumBerFormat(reader["mgd"].ToString()) + "</td>") + "<td width=10% align=right>&nbsp;</td></tr>";
            }
            else
            {
                text = (((text + "<tr class=reportTotalchar align=right height=22>" + "<td width=10% class=reportTotalchar>总 数</td>") + "<td width=10% align=right>0</td>" + "<td width=10% align=right>0.00</td>") + "<td width=10% align=right>0.00</td>" + "<td width=10% align=right>0.00</td>") + "<td width=10% align=right>0.00</td>" + "<td width=10% align=right>&nbsp;</td></tr>\n";
            }
            reader.Close();
            text = text + "</table>\n";
            this.tableBottom.Rows[1].Cells[0].InnerHtml = text;
        }
    }
}

