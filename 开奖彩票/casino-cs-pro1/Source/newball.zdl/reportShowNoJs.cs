namespace newball.zdl
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class reportShowNoJs : Page
    {
        protected HtmlSelect selectpage;
        protected HtmlGenericControl sumpagelabel;
        protected HtmlGenericControl sumpages;
        protected HtmlTable tableBarMenu;
        protected HtmlTable tableContent;

        private void Deal(string flag)
        {
            int curpage;
            int start;
            string text = "";
            string sql = "";
            string text3 = "";
            int num = 0;
            double num2 = 0;
            double num3 = 0;
            double num4 = 0;
            if (flag == "all")
            {
                sql = "SELECT od.cszdl,od.tzmoney*od.cszdl as csres,convert(numeric(5,2),od.hsuser_w) as hsuser_w,convert(numeric(5,2),od.hsuser_l) as hsuser_l,dbo.GettzType_Func(od.tzType) as tzTypeName,od.tzType as tzType,od.updatetime as updatetime,od.username as username,od.content as content,od.tzmoney as tzmoney,isnull((od.win-od.lose),0) as result,od.abc as abc,od.iscancel as iscancel FROM ball_order as od inner join member as mb on od.userid = mb.userid where od.isjs = 0 and od.iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',od.updatetime) = 0 and od.zdlid='" + this.Session["adminuserid"].ToString() + "'";
                text3 = "select count(*) from ball_order where isjs = 0 and iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',updatetime) = 0 and zdlid='" + this.Session["adminuserid"].ToString() + "'";
            }
            else
            {
                sql = "SELECT od.cszdl,od.tzmoney*od.cszdl as csres,convert(numeric(5,2),od.hsuser_w) as hsuser_w,convert(numeric(5,2),od.hsuser_l) as hsuser_l,dbo.GettzType_Func(od.tzType) as tzTypeName,od.tzType as tzType,od.updatetime as updatetime,od.username as username,od.content as content,od.tzmoney as tzmoney,isnull((od.win-od.lose),0) as result,od.abc as abc,od.iscancel as iscancel FROM ball_order as od inner join member as mb on od.userid = mb.userid where od.tztype='8' AND od.isjs = 0 and od.iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',od.updatetime) = 0 and od.zdlid='" + this.Session["adminuserid"].ToString() + "'";
                text3 = "select count(*) from ball_order where tztype='1' AND isjs = 0 and iscancel = 0 and datediff(day,'" + DateTime.Today.ToShortDateString() + "',updatetime) = 0 and zdlid='" + this.Session["adminuserid"].ToString() + "'";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsheader><td width=10%>时间</td><td width=15%>会员 (win/lose)</td><td width=10%>投注方式</td><td width=25%>详情</td><td width=10%>注额</td><td width=10%>成数</td><td width=10%>注额（成数）</td><td width=10%>结果</td></tr>\n";
            int pagesize = 100;
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
            int totalrecord = int.Parse(base2.ExecuteScalar(text3).ToString());
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
            DataSet set = base2.ExecuteDataSet(sql, start, pagesize, "ball_order");
            for (int i = 0; i < set.Tables[0].Rows.Count; i++)
            {
                num++;
                string text4 = (((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + DateTime.Parse(set.Tables[0].Rows[i]["updatetime"].ToString().Trim()).ToString("yyyy-MM-dd HH:mm:ss").ToUpper().Replace(" ", "<br>") + "</td>") + "<td align=center nowrap><table border=0 cellspacing=0 cellpadding=0><tr><td><font color=red>" + set.Tables[0].Rows[i]["abc"].ToString() + "</font>&nbsp;</td>") + "<td align=center nowrap>&nbsp;" + set.Tables[0].Rows[i]["username"].ToString() + "&nbsp;</td>";
                text = (((((text4 + "<td nowrap>&nbsp;<font color=red>" + set.Tables[0].Rows[i]["hsuser_w"].ToString() + "</font>/<font color=red>" + set.Tables[0].Rows[i]["hsuser_l"].ToString() + "</font></td></tr></table></td>") + "<td align=center>" + set.Tables[0].Rows[i]["tzTypeName"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["content"].ToString() + "</td>") + "<td>" + Convert.ToDouble(set.Tables[0].Rows[i]["tzmoney"]).ToString() + "</td>") + "<td>" + Convert.ToDouble(set.Tables[0].Rows[i]["cszdl"]).ToString("F1") + "</td>") + "<td>" + MyFunc.NumBerFormat(set.Tables[0].Rows[i]["csres"].ToString()) + "</td>";
                if (set.Tables[0].Rows[i]["iscancel"].ToString().ToLower() == "true")
                {
                    text = text + "<td><font color='red'>取消</font></td>";
                }
                else
                {
                    text = text + "<td>" + MyFunc.NumBerFormat(set.Tables[0].Rows[i]["result"].ToString()) + "</td>";
                }
                text = text + "</tr>\n";
                num2 += double.Parse(set.Tables[0].Rows[i]["tzmoney"].ToString());
                num3 += double.Parse(set.Tables[0].Rows[i]["csres"].ToString());
                num4 += double.Parse(set.Tables[0].Rows[i]["result"].ToString());
            }
            set.Clear();
            base2.Dispose();
            this.setselectpageproc(pagesize, totalrecord, curpage);
            text = ((((((text + "<tr align=right height=22 class=reportTotalnum><td colspan=3>&nbsp;</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td colspan=3>" + MyFunc.NumBerFormat(num4.ToString()) + "</td></tr>") + "</table>\n" + "<table border=0 cellspacing=0 cellpadding=0 width=100% bgcolor=#eeeeee>\n") + "<tr><td width=100% height=12></td></tr>\n</table>\n" + "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n") + "<tr class=dlsreport1><td width=30%>总代理</td><td width=10%>笔数</td><td width=18%>投注额</td><td width=18%>注额（成数）</td><td width=18%>结果</td></tr>\n" + "<tr class=reportTotalnum align=right height=22>";
            if ((this.Session.Contents["adminsubid"] != null) && (this.Session.Contents["adminsubid"].ToString() != ""))
            {
                text = text + "<td>" + this.Session.Contents["adminsubname"].ToString() + "</td>";
            }
            else
            {
                text = text + "<td>" + this.Session.Contents["adminusername"].ToString() + "</td>";
            }
            text = (((text + "<td>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td>" + num3.ToString() + "</td>") + "<td>" + MyFunc.NumBerFormat(num4.ToString()) + "</td></tr></table>";
            this.tableContent.Rows[0].Cells[0].InnerHtml = text;
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
            if ((this.Session.Contents["adminsubid"] != null) && (this.Session.Contents["adminsubid"].ToString() != ""))
            {
                if (!MyFunc.CheckUserLogin(2) || !MyTeam.OnlineList.OnlineList.isUserLogin(2))
                {
                    MyFunc.goToLoginPage();
                    base.Response.End();
                    return;
                }
            }
            else if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return;
            }
            string flag = "all";
            if (base.Request.QueryString["tztype"] != null)
            {
                flag = base.Request.QueryString["tztype"].ToString();
            }
            this.Deal(flag);
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
    }
}

