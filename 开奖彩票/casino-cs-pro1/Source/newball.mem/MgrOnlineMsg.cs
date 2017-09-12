namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class MgrOnlineMsg : Page
    {
        protected HtmlTable UserEventTable;

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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (base.Request.QueryString["username"].Trim() == "")
            {
                MyFunc.showmsg("出错了!");
                base.Response.End();
            }
            else
            {
                int curPage;
                int pagesize = 10;
                try
                {
                    curPage = int.Parse(base.Request.QueryString["page"].ToString());
                }
                catch
                {
                    curPage = 1;
                }
                if (curPage < 1)
                {
                    curPage = 1;
                }
                if (!base.IsPostBack)
                {
                    int start;
                    this.UserEventTable.Rows[0].Cells[0].InnerHtml = "<font color=red>" + base.Request.QueryString["username"].Trim() + "</font>的登陆日志";
                    string sql = "SELECT * FROM event WHERE username='" + base.Request.QueryString["username"].Trim() + "' ORDER BY id DESC";
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    int totalRecord = int.Parse(base2.ExecuteScalar("SELECT COUNT(*) FROM event WHERE username='" + base.Request.QueryString["username"].Trim() + "'").ToString());
                    if (totalRecord == 0)
                    {
                        start = 0;
                    }
                    else
                    {
                        start = (curPage - 1) * pagesize;
                    }
                    DataSet set = base2.ExecuteDataSet(sql, start, pagesize, "event");
                    string text2 = "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#999999'><tr class=blueheader><td width='22%'>来源IP</td><td width='28%'>登陆时间</td><td width='30%'>离开时间</td><td width='20%'>停留时间</td></tr>";
                    for (int i = 0; i < set.Tables[0].Rows.Count; i++)
                    {
                        string text3 = text2;
                        text2 = text3 + "<tr bgcolor='#FFFFFF'><td>" + set.Tables[0].Rows[i]["ip"].ToString().Trim() + "</td><td>" + set.Tables[0].Rows[i]["logintime"].ToString().Trim() + "</td><td>";
                        if (set.Tables[0].Rows[i]["lefttime"].ToString().Trim() == "")
                        {
                            text2 = text2 + "未知</td><td>未知</td></tr>";
                        }
                        else
                        {
                            TimeSpan span = (TimeSpan) (DateTime.Parse(set.Tables[0].Rows[i]["lefttime"].ToString().Trim()) - DateTime.Parse(set.Tables[0].Rows[i]["logintime"].ToString().Trim()));
                            string text4 = text2;
                            text2 = text4 + set.Tables[0].Rows[i]["lefttime"].ToString().Trim() + "</td><td>" + span.TotalMinutes.ToString("F") + "&nbsp;分钟</td></tr>";
                        }
                    }
                    base2.Dispose();
                    text2 = text2 + "</table>";
                    this.UserEventTable.Rows[1].Cells[0].InnerHtml = text2;
                    this.UserEventTable.Rows[2].Cells[0].InnerHtml = MyFunc.MulitPager(totalRecord, pagesize, curPage, "MgrOnlineMsg.aspx?username=" + base.Request.QueryString["username"].Trim());
                    this.DataBind();
                }
            }
        }
    }
}

