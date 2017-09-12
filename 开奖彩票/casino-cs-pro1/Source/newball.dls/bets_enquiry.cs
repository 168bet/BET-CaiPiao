namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Configuration;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class bets_enquiry : Page
    {
        public string datetime = "";
        public string kyglList = "";
        public string kyglName = "";
        public string kyglTT = "";
        public string msg = "";

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
            else if (!base.IsPostBack)
            {
                DateTime now = DateTime.Now;
                this.datetime = now.Year.ToString() + "-" + now.Month.ToString() + "-" + now.Day.ToString();
                string sql = "";
                string text2 = "";
                text2 = MyFunc.GetConnStr(2).ToLower();
                text2 = text2.Substring(text2.IndexOf("catalog=", 0) + 8, (text2.IndexOf(";user", 0) - text2.IndexOf("catalog=", 0)) - 8);
                this.kyglName = this.Session.Contents["adminusername"].ToString().Trim();
                if ((base.Request.QueryString["date"] != null) && (base.Request.QueryString["date"].ToString().Trim() != ""))
                {
                    this.kyglTT = "结果";
                    try
                    {
                        DateTime.Parse(base.Request.QueryString["date"].ToString().Trim());
                    }
                    catch
                    {
                        return;
                    }
                    sql = "SELECT updatetime,tztype,orderid,content,tzmoney,(win-lose) AS result,iscancel,isdanger,zdmoney,GetDate() as thisdatetime FROM ball_order2 WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " AND datediff(day,balltime,'" + base.Request.QueryString["date"].ToString().Trim() + "')=0 AND isjs=1 ORDER BY updatetime DESC";
                }
                else
                {
                    this.kyglTT = "可嬴金额";
                    sql = "SELECT updatetime,tztype,orderid,content,tzmoney,(tzmoney*curpl) AS result,iscancel,isdanger,zdmoney,GetDate() as thisdatetime FROM ball_order2 WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " AND isjs=0 ORDER BY updatetime DESC";
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                this.msg = "<div class=hover>";
                while (reader.Read())
                {
                    this.msg = this.msg + reader["content"].ToString().Trim();
                }
                this.msg = this.msg + "</div>";
                reader.Close();
                SqlDataReader reader2 = base2.ExecuteReader(sql);
                double num = 0;
                double num2 = 0;
                for (int i = 1; reader2.Read(); i++)
                {
                    double num4 = Math.Round(double.Parse(reader2["tzmoney"].ToString().Trim()), 2);
                    double num5 = Math.Round(double.Parse(reader2["result"].ToString().Trim()), 2);
                    string kyglList = this.kyglList;
                    this.kyglList = kyglList + "<TR><td style='text-align:center'>" + reader2["updatetime"].ToString().Trim() + "</td><TD>" + reader2["orderid"].ToString().Trim() + "</TD><TD style=\"TEXT-ALIGN: center\">" + MyFunc.GettzTypeName(reader2["tztype"].ToString().Trim());
                    this.kyglList = this.kyglList + "</TD>";
                    this.kyglList = this.kyglList + "<TD class='details' noWrap style=\"TEXT-ALIGN: right\">" + reader2["content"].ToString().Trim() + "</TD>";
                    if ((reader2["isdanger"].ToString().Trim() == "2") || (num4 == 0))
                    {
                        this.kyglList = this.kyglList + "<TD class='tdR'><font color=red>-</font></TD><TD class='tdR'>";
                    }
                    else
                    {
                        this.kyglList = this.kyglList + "<TD class='tdR'>" + num4.ToString("F0") + "</TD><TD class='tdR'>";
                    }
                    if ((ConfigurationSettings.AppSettings["UserDanger"] == "1") && (reader2["isdanger"].ToString().Trim() == "2"))
                    {
                        this.kyglList = this.kyglList + "<br><font color=red>危险球<br>取消</font>";
                    }
                    else if (reader2["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                    {
                        this.kyglList = this.kyglList + "<font color=red>取消</font>";
                    }
                    else
                    {
                        this.kyglList = this.kyglList + num5;
                        num += num4;
                        num2 += num5;
                    }
                    this.kyglList = this.kyglList + "</TD></TR>";
                }
                reader2.Close();
                base2.Dispose();
                this.kyglList = this.kyglList + "<TR style='BACKGROUND-COLOR: #e9e9e9'><TD class='tdR' colSpan='4'><IMG src='../user/images/print.gif' border='0'> <A href='javascript:window.print()'> 打印</A>&nbsp;</TD>";
                object obj2 = this.kyglList;
                this.kyglList = string.Concat(new object[] { obj2, "<TD class='tdR' style='VERTICAL-ALIGN: middle' bgColor='lightyellow'><B style='FONT-SIZE: 14px; COLOR: brown'>", num, "</B>&nbsp;</TD>" });
                this.kyglList = this.kyglList + "<TD class='tdR' style='VERTICAL-ALIGN: middle' bgColor='lightyellow'><B style='FONT-SIZE: 14px; COLOR: brown'>" + num2.ToString("F2") + "</B>&nbsp;</TD></TR>";
                this.DataBind();
            }
        }
    }
}

