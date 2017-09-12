namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class gdlist_reportlist : Page
    {
        protected HtmlTable tableHeader;
        private string userId = "";
        private string userName = "";

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
            else if (!this.Page.IsPostBack)
            {
                this.userId = base.Request.QueryString["userid"].ToString();
                this.userName = base.Request.QueryString["username"].ToString();
                HtmlTableCell cell1 = this.tableHeader.Rows[1].Cells[0];
                cell1.InnerHtml = cell1.InnerHtml + "<b></font color=gray>" + this.userName + "</font color=gray></b>";
                HtmlTableCell cell2 = this.tableHeader.Rows[1].Cells[0];
                cell2.InnerHtml = cell2.InnerHtml + "&nbsp;->->&nbsp;<A href='javascript:window.print();'>打印&nbsp;&nbsp;</A><a href='javascript:window.history.back();'>返回</a>";
                this.ShowMonthContent();
            }
        }

        private void ShowMonthContent()
        {
            string text = "";
            string sql = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            double num5 = 0;
            double num6 = 0;
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsheader><td width=15%>日期</td><td width=5% nowrap>投注数</td><td width=16%>投注额</td><td width=16%>结果</td><td width=16%>代理商</td><td width=16%>总代理</td><td width=16%>股东</td></tr>\n";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = null;
            for (int i = 0; i < 30; i++)
            {
                sql = "SELECT isnull(sum(mgd),0) as gdmoney,isnull(sum(mdls),0) as dlsmoney,isnull(sum(mzdl),0) as zdlmoney,count(*) as tzcount,isnull(sum(tzmoney),0) as tzmoney,isnull(sum(win-lose),0) as result FROM ball_order WHERE gdid ='" + this.userId + "' AND datediff(day,updatetime,'" + DateTime.Today.AddDays((double) -i).ToShortDateString() + "') = 0";
                reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    text = text + "<tr bgcolor=white align=right height=22>";
                    if (reader["tzcount"].ToString() != "0")
                    {
                        string text3 = text;
                        text = ((((((text3 + "<td align=center nowrap><a href='gdlist_reportcontent.aspx?userid=" + this.userId + "&username=" + this.userName + "&updatetime=" + DateTime.Today.AddDays((double) -i).ToString("yyyy-MM-dd") + "'><font color=blue>" + DateTime.Today.AddDays((double) -i).ToString("yyyy-MM-dd") + "-" + MyFunc.DayToWeek(DateTime.Today.AddDays((double) -i)) + "<font></a></td>") + "<td align=center>" + reader["tzcount"].ToString() + "</td>") + "<td>" + Convert.ToDouble(reader["tzmoney"]).ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["dlsmoney"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["zdlmoney"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["gdmoney"].ToString()) + "</td>";
                        num += int.Parse(reader["tzcount"].ToString());
                        num2 += double.Parse(reader["tzmoney"].ToString());
                        num3 += double.Parse(reader["dlsmoney"].ToString());
                        num4 += double.Parse(reader["zdlmoney"].ToString());
                        num5 += double.Parse(reader["gdmoney"].ToString());
                        num6 += double.Parse(reader["result"].ToString());
                    }
                    else
                    {
                        string text4 = text;
                        text = ((((((text4 + "<td align=center nowrap>" + DateTime.Today.AddDays((double) -i).ToString("yyyy-MM-dd") + "-" + MyFunc.DayToWeek(DateTime.Today.AddDays((double) -i)) + "</a></td>") + "<td align=center>" + reader["tzcount"].ToString() + "</td>") + "<td>" + Convert.ToDouble(reader["tzmoney"]).ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["result"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["dlsmoney"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["zdlmoney"].ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(reader["gdmoney"].ToString()) + "</td>";
                    }
                    text = text + "</tr>\n";
                }
                reader.Close();
            }
            text = (((((((text + "<tr class=reportTotalnum align=right height=22><td class=reportTotalchar>总 数</td>") + "<td align=center>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num6.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num3.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td>") + "<td>" + MyFunc.NumBerFormat(num5.ToString()) + "</td>") + "</tr></table>\n";
            this.tableHeader.Rows[3].Cells[0].InnerHtml = text;
        }
    }
}

