namespace newball.gd
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class dlslist_reportcontent : Page
    {
        protected HtmlSelect selectpage;
        protected HtmlGenericControl sumpages;
        protected HtmlTable tableBarMenu;
        protected HtmlTable tableContent;
        private string upDateTime = "";
        private string userId = "";
        public string userName = "";

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
                this.upDateTime = base.Request.QueryString["updatetime"].ToString();
                this.ShowBallOrderContent();
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

        private void ShowBallOrderContent()
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
            sql = "SELECT csdls,tzmoney*csdls as csres,convert(numeric(5,2),hsuser_w) as hsuser_w,convert(numeric(5,2),hsuser_l) as hsuser_l,dbo.GettzType_Func(tzType) as tzTypeName,tzType,updatetime,username,content,tzmoney,isnull((win-lose),0) as result,abc,iscancel FROM ball_order where datediff(day,'" + this.upDateTime + "',updatetime) = 0 and dlsid='" + this.userId + "'";
            text3 = "select count(*) from ball_order where datediff(day,'" + this.upDateTime + "',updatetime) = 0 and dlsid='" + this.userId + "'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsheader><td width=10%>时间</td><td width=15%>退水 (win/lose)</td><td width=10%>投注方式</td><td width=25%>详情</td><td width=10%>注额</td><td width=10%>成数</td><td width=10%>注额（成数）</td><td width=10%>结果</td></tr>\n";
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
                text = (((((text4 + "<td nowrap>&nbsp;<font color=red>" + set.Tables[0].Rows[i]["hsuser_w"].ToString() + "</font>/<font color=red>" + set.Tables[0].Rows[i]["hsuser_l"].ToString() + "</font></td></tr></table></td>") + "<td align=center>" + set.Tables[0].Rows[i]["tzTypeName"].ToString() + "</td>") + "<td>" + set.Tables[0].Rows[i]["content"].ToString() + "</td>") + "<td>" + Convert.ToDouble(set.Tables[0].Rows[i]["tzmoney"]).ToString() + "</td>") + "<td>" + Convert.ToDouble(set.Tables[0].Rows[i]["csdls"]).ToString("F1") + "</td>") + "<td>" + MyFunc.NumBerFormat(set.Tables[0].Rows[i]["csres"].ToString()) + "</td>";
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
            text = ((((((text + "<tr class=reportTotalnum align=right height=22><td colspan=3>&nbsp;</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + num2.ToString() + "</td>") + "<td colspan=3>" + MyFunc.NumBerFormat(num4.ToString()) + "</td></tr>") + "</table>\n" + "<table border=0 cellspacing=0 cellpadding=0 width=100% bgcolor=white>\n") + "<tr><td width=100% height=12></td></tr>\n</table>\n" + "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n") + "<tr class=dlsreport1><td width=30%>代理商</td><td width=10%>笔数</td><td width=18%>投注额</td><td width=18%>注额（成数）</td><td width=18%>结果</td></tr>\n" + "<tr class=reportTotalnum align=right height=22>";
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
    }
}

