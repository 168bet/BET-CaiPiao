namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class football_ys : Page
    {
        protected double abcadd = 0;

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
            else if (!this.Page.IsPostBack)
            {
                this.TopMenuProcess();
                this.ProcessContent();
            }
        }

        private void ProcessContent()
        {
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;已开奖 </font>\n<table id=glist_table border=0 cellspacing=1 cellpadding=0 class=ra_listbet_tab width=300>\n  <tr class=ra_listbet_title>  <td width=150>时间</td><td width=50>期数</tr>\n";
            s = s + this.SumAllMember();
            base.Response.Write(s);
        }

        private string SumAllMember()
        {
            string text2 = "";
            string text4 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = null;
            string[] textArray = "01,11,21,31,41,特单,02,12,22,32,42,特双,03,13,23,33,43,特大,04,14,24,34,44,特小,05,15,25,35,45,合单,06,16,26,36,46,合双,07,17,27,37,47,08,18,28,38,48,09,19,29,39,49,10,20,30,40".Split(new char[] { ',' });
            reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            if (reader.Read())
            {
                DateTime time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                TimeSpan span = DateTime.Now.Subtract(time);
                int num3 = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                if ((num3 > 0) && (num3 < 360))
                {
                    object obj2 = text2;
                    text2 = string.Concat(new object[] { obj2, "<tr bgcolor='#FFFFFF' ><td height=40>", reader["kaisai"].ToString(), "</td><td  align=center>", reader["qishu"], "</td>" });
                    text4 = reader["kaisai"].ToString();
                }
            }
            reader.Close();
            base3.CloseConnect();
            base3.Dispose();
            base2.CloseConnect();
            base2.Dispose();
            return (text2 + "\n</table></form></body></html>");
        }

        private void TopMenuProcess()
        {
            string ltype = "C";
            string retime = "-1";
            string strMethod = "ys";
            if (base.Request.Form["selectZD"] != null)
            {
                this.Session["sessionSelectZD"] = base.Request.Form["selectZD"].ToString();
            }
            else if (this.Session["sessionSelectZD"] == null)
            {
                this.Session["sessionSelectZD"] = "无有单";
            }
            if (base.Request.Form["staticCS"] != null)
            {
                this.Session["sessionSelectStaticCS"] = base.Request.Form["staticCS"].ToString();
            }
            else if (this.Session["sessionSelectStaticCS"] == null)
            {
                this.Session["sessionSelectStaticCS"] = "全部";
            }
            if (base.Request.Form["ltype"] != null)
            {
                ltype = base.Request.Form["ltype"].ToString().Trim();
                this.Session["football_b_ltype"] = ltype;
            }
            else if (this.Session["football_b_ltype"] != null)
            {
                ltype = this.Session["football_b_ltype"].ToString().Trim();
            }
            if (base.Request.Form["retime"] != null)
            {
                retime = base.Request.Form["retime"].ToString().Trim();
                this.Session["football_b_retime"] = retime;
            }
            else if (this.Session["football_b_retime"] != null)
            {
                retime = this.Session["football_b_retime"].ToString().Trim();
            }
            if (ltype.ToUpper() == "A")
            {
                this.abcadd = 0.01;
            }
            if (ltype.ToUpper() == "B")
            {
                this.abcadd = 0.03;
            }
            if (ltype.ToUpper() == "D")
            {
                this.abcadd = -0.015;
            }
            string s = MyFunc.pintingAgenceMenu(ltype, retime, strMethod);
            base.Response.Write(s);
        }
    }
}

