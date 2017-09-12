namespace newball.subuser
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
        protected string endTime = "";
        protected string reportType = "";
        protected string startTime = "";
        protected HtmlTable tableBarMenu;
        protected HtmlTable tableBottom;
        protected HtmlTable tableHeader;
        protected HtmlTable tableMiddle;
        protected string tzCase = "";
        protected string tzType = "";

        private void AllDeal()
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='信用' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            text2 = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='现金' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            text3 = "SELECT count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ")";
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.ShowCreditContent(db, sql);
                    this.ShowCashContent(db, text2);
                    this.ShowZongShuContent(db, text3);
                    goto Label_02BF;

                case "breakdown":
                    this.ShowCreditContent(db, sql);
                    this.ShowCashContent(db, text2);
                    this.tableBottom.Visible = false;
                    goto Label_02BF;

                case "soccer":
                    this.ShowCreditContent(db, sql);
                    this.ShowCashContent(db, text2);
                    this.ShowZongShuContent(db, text3);
                    break;

                case "basketball":
                    this.tableHeader.Visible = false;
                    this.tableMiddle.Visible = false;
                    this.tableBottom.Visible = false;
                    break;
            }
        Label_02BF:
            db.CloseConnect();
            db.Dispose();
        }

        private void CashDeal()
        {
            string text = "";
            string sql = "";
            string text3 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            text = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='信用' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            sql = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='现金' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and  dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            text3 = "SELECT count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='现金' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ")";
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.tableHeader.Visible = false;
                    this.ShowCashContent(db, sql);
                    this.ShowZongShuContent(db, text3);
                    goto Label_02F7;

                case "breakdown":
                    this.tableHeader.Visible = false;
                    this.ShowCashContent(db, sql);
                    this.tableBottom.Visible = false;
                    goto Label_02F7;

                case "soccer":
                    this.tableHeader.Visible = false;
                    this.ShowCashContent(db, sql);
                    this.ShowZongShuContent(db, text3);
                    break;

                case "basketball":
                    this.tableHeader.Visible = false;
                    this.tableMiddle.Visible = false;
                    this.tableBottom.Visible = false;
                    break;
            }
        Label_02F7:
            db.CloseConnect();
            db.Dispose();
        }

        private void CreditDeal()
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='信用' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            text2 = "SELECT username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='现金' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and  dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ") group by username";
            text3 = "SELECT count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(tzmoney*truewin) as realtzmoney,sum(win-lose) as result,sum(mzdl) as mzdl,sum(mdls) as mdls FROM ball_order_view WHERE userid in (select userid from member where usertype='信用' and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "') and dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' and (updatetime between '" + this.startTime + "' and '" + this.endTime + "') and tzType in (" + MyFunc.GettzType(this.tzType) + ")";
            switch (this.reportType.ToLower())
            {
                case "ledger":
                    this.ShowCreditContent(db, sql);
                    this.tableMiddle.Visible = false;
                    this.ShowZongShuContent(db, text3);
                    goto Label_02F7;

                case "breakdown":
                    this.ShowCreditContent(db, sql);
                    this.tableMiddle.Visible = false;
                    this.tableBottom.Visible = false;
                    goto Label_02F7;

                case "soccer":
                    this.ShowCreditContent(db, sql);
                    this.tableMiddle.Visible = false;
                    this.ShowZongShuContent(db, text3);
                    break;

                case "basketball":
                    this.tableHeader.Visible = false;
                    this.tableMiddle.Visible = false;
                    this.tableBottom.Visible = false;
                    break;
            }
        Label_02F7:
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
            if (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2))
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
            this.tableBarMenu.Rows[0].Cells[0].InnerHtml = "&nbsp;&nbsp;子帐户:" + this.Session.Contents["adminsubname"].ToString() + "&nbsp;&nbsp;日期区间:" + this.startTime + "~~" + this.endTime + "&nbsp;--&nbsp;报表:" + this.GetReportType(this.reportType) + "&nbsp;--&nbsp;信用/现金:" + this.GettzCaseName(this.tzCase) + "&nbsp;--&nbsp;方式:" + MyFunc.GettzTypeName(this.tzType) + "&nbsp;--&nbsp;<a href='javascript:window.history.back();'>返回</a>";
        }

        private void SetShowPage()
        {
            switch (this.tzCase.ToLower())
            {
                case "all":
                    this.AllDeal();
                    return;

                case "credit":
                    this.CreditDeal();
                    break;

                case "cash":
                    this.CashDeal();
                    break;
            }
        }

        private void ShowCashContent(DataBase db, string sql)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            SqlDataReader reader = db.ExecuteReader(sql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsheader><td width=10%>会员名称</td><td width=10%>投注数</td><td width=10%>投注额</td><td width=10%>会员（外汇）</td><td width=10%>会员（本地）</td><td width=10%>结果</td><td width=10%>%</td><td width=10%>代理商结果</td><td width=10%>总代理结果</td><td width=10%>备注</td></tr>";
            while (reader.Read())
            {
                text = (((((((((((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["username"].ToString() + "(CNY)</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "<td>" + reader["result"].ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + reader["mdls"].ToString() + "</td>") + "<td>" + reader["mzdl"].ToString() + "</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num4 += double.Parse(reader["mdls"].ToString());
                num5 += double.Parse(reader["mzdl"].ToString());
                num6 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = ((((((((((text + "<tr bgcolor=#eeeeee align=right height=22><td>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + num2.ToString() + "</td>") + "<td>" + num6.ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + num4.ToString() + "</td>") + "<td>" + num5.ToString() + "</td>") + "<td>" + num2.ToString() + "</td></tr>") + "</table>";
            this.tableMiddle.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowCreditContent(DataBase db, string sql)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            SqlDataReader reader = db.ExecuteReader(sql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsheader><td width=10%>会员名称</td><td width=10%>投注数</td><td width=10%>投注额</td><td width=10%>会员（外汇）</td><td width=10%>会员（本地）</td><td width=10%>结果</td><td width=10%>%</td><td width=10%>代理商结果</td><td width=10%>总代理结果</td><td width=10%>备注</td></tr>\n";
            while (reader.Read())
            {
                text = (((((((((((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["username"].ToString() + "(CNY)</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "<td>" + reader["result"].ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + reader["mdls"].ToString() + "</td>") + "<td>" + reader["mzdl"].ToString() + "</td>") + "<td>" + reader["tzmoney"].ToString() + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num4 += double.Parse(reader["mdls"].ToString());
                num5 += double.Parse(reader["mzdl"].ToString());
                num6 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            text = ((((((((((text + "<tr bgcolor=#eeeeee align=right height=22><td>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + num2.ToString() + "</td>") + "<td>" + num6.ToString() + "</td>") + "<td>&nbsp;</td>") + "<td>" + num4.ToString() + "</td>") + "<td>" + num5.ToString() + "</td>") + "<td>" + num2.ToString() + "</td></tr>") + "</table>\n";
            this.tableHeader.Rows[1].Cells[0].InnerHtml = text;
        }

        private void ShowZongShuContent(DataBase db, string sql)
        {
            string text = "";
            SqlDataReader reader = db.ExecuteReader(sql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            if (reader.Read())
            {
                text = ((((((((((text + "<tr bgcolor=#eeeeee align=right height=22>" + "<td width=10%>总 数</td>") + "<td width=10%>" + reader["tzNumber"].ToString() + "</td>") + "<td width=10%>" + reader["tzmoney"].ToString() + "</td>") + "<td width=10%>&nbsp;</td>") + "<td width=10%>" + reader["tzmoney"].ToString() + "</td>") + "<td width=10%>" + reader["result"].ToString() + "</td>") + "<td width=10%>&nbsp;</td>") + "<td width=10%>" + reader["mdls"].ToString() + "</td>") + "<td width=10%>" + reader["mzdl"].ToString() + "</td>") + "<td width=10%>" + reader["tzmoney"].ToString() + "</td>") + "</tr>";
            }
            else
            {
                text = (((((text + "<tr bgcolor=#eeeeee align=right height=22>") + "<td width=10%>总 数</td>" + "<td width=10%>0</td>") + "<td width=10%>0.00</td>" + "<td width=10%>&nbsp;</td>") + "<td width=10%>0.00</td>" + "<td width=10%>0.00</td>") + "<td width=10%>&nbsp;</td>" + "<td width=10%>0.00</td>") + "<td width=10%>0.00</td>" + "<td width=10%>0.00</td></tr>\n";
            }
            reader.Close();
            text = text + "</table>\n";
            this.tableBottom.Rows[1].Cells[0].InnerHtml = text;
        }
    }
}

