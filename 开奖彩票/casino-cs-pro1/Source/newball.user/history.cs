namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class history : Page
    {
        public string kyglList = "";
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
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = db.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                SqlDataReader reader2 = null;
                int num = 0;
                double num2 = 0;
                string text = "";
                this.msg = "<div class=hover>";
                while (reader.Read())
                {
                    this.msg = this.msg + reader["content"].ToString().Trim();
                }
                this.msg = this.msg + "</div>";
                reader.Close();
                string text2 = db.ExecuteScalar("SELECT ISNULL(jsdatetime,'') FROM member WHERE userid=" + this.Session.Contents["userid"].ToString().Trim()).ToString().Trim();
                double num3 = 0;
                double num4 = 0;
                reader2 = db.ExecuteReader("SELECT top 1 * FROM ball_bf1  ORDER BY balltime DESC");
                if (reader2.Read())
                {
                    DateTime time = Convert.ToDateTime(reader2["balltime"].ToString().Trim());
                    TimeSpan span = DateTime.Now.Subtract(time);
                    num = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                    text = reader2["qishu"].ToString().Trim();
                }
                reader2.Close();
                string s = "";
                string text4 = "";
                string text5 = "";
                string text6 = "";
                string text7 = "";
                DataSet set = db.ExecuteDataSet("select * from ball_bf1 where ballid in (select top 3 ballid from ball_bf1 order by ballid desc) order by ballid");
                for (int i = 0; i < 3; i++)
                {
                    s = set.Tables[0].Rows[i]["balltime"].ToString().Trim().Split(new char[] { ' ' })[0].ToString();
                    text4 = s.Split(new char[] { '-' })[0].ToString();
                    text6 = s.Split(new char[] { '-' })[1].ToString();
                    text5 = s.Split(new char[] { '-' })[2].ToString();
                    text7 = MyFunc.DayToWeek(DateTime.Parse(s));
                    string sql = "SELECT COUNT(1) AS tzcount, ISNULL(SUM(tzmoney),0) AS tzmoney,ISNULL(SUM(ROUND(win-lose,2)),0) AS result FROM ball_order WHERE DateDiff(day,balltime,'" + s + "')=0 AND  isjs=1 AND userid=" + this.Session.Contents["userid"].ToString().Trim();
                    if (text2 != "")
                    {
                        sql = sql + " AND updatetime>'" + text2 + "'";
                    }
                    reader2 = db.ExecuteReader(sql);
                    reader2.Read();
                    double num6 = Math.Round(double.Parse(reader2["tzmoney"].ToString()), 2);
                    double num7 = Math.Round(double.Parse(reader2["result"].ToString()), 2);
                    this.kyglList = this.kyglList + "<TR class=\"b_rig\"><TD class=\"b_fwn\">";
                    if (int.Parse(text5) < 10)
                    {
                        text5 = "0" + text5;
                    }
                    if (int.Parse(text6) < 10)
                    {
                        text6 = "0" + text6;
                    }
                    if (int.Parse(reader2["tzcount"].ToString().Trim()) != 0)
                    {
                        string kyglList = this.kyglList;
                        this.kyglList = kyglList + "<a href=bets-enquiry.aspx?date=" + s + "><font color=#CC0000>" + text6 + "-" + text5 + "  " + text7 + "</font></a>";
                    }
                    else
                    {
                        string text10 = this.kyglList;
                        this.kyglList = text10 + "<font color=#CC0000>" + text6 + "-" + text5 + " " + text7 + "</font>";
                    }
                    reader2.Close();
                    num2 = 0;
                    num2 = double.Parse(MyFunc.usermsg(this.Session.Contents["userid"].ToString().Trim(), db, "0")[2].ToString()) - num6;
                    num3 += num6;
                    num4 += num7;
                    object obj2 = this.kyglList;
                    this.kyglList = string.Concat(new object[] { obj2, "</TD><TD class='tdR'>", set.Tables[0].Rows[i]["qishu"].ToString().Trim(), "</td><TD class='tdR'>", num6, "</TD><TD class='tdR'>", num7, "</TD><TD class='tdR'>", num2, "</TD></TR>" });
                }
                db.Dispose();
                string text11 = this.kyglList;
                this.kyglList = text11 + "<TR style='BACKGROUND-COLOR: #e9e9e9' class=\"b_rig\"><TD class=\"b_fwn\" >小计</TD><td class='list_rig'></td><TD class='list_rig' bgColor='lightyellow'><B style='FONT-SIZE: 14px; COLOR: brown'>" + num3.ToString("F2") + "</B></TD><TD class='list_rig' bgColor='lightyellow'><B style='FONT-SIZE: 14px; COLOR: brown'>" + num4.ToString("F2") + "</B></TD><td bgColor=#990000><FONT color=#ffffff></FONT></td></TR>";
                this.DataBind();
            }
        }
    }
}

