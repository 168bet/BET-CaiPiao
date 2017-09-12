namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class match_result : Page
    {
        public string btndisplay = "none";
        public string DateDropContent = "";
        public string fr_type = "sc";
        public string kyglcontent = "";
        public string kyglTypeSel = "";
        public string matchetype = "";
        public string msg = "";
        public string pageorder = "";
        public string viewpage = "";

        private string DateDropList(string thisdate)
        {
            string text = "";
            string text2 = "";
            for (int i = 0; i < 7; i++)
            {
                if (thisdate == DateTime.Today.AddDays((double) -i).ToShortDateString().Trim())
                {
                    text2 = " Selected";
                }
                else
                {
                    text2 = "";
                }
                string text4 = text;
                text = text4 + "<OPTION value='" + DateTime.Today.AddDays((double) -i).ToShortDateString() + "'" + text2 + ">" + DateTime.Today.AddDays((double) -i).ToShortDateString() + "</OPTION>";
            }
            return text;
        }

        private void FootBallList()
        {
            int num2;
            int start;
            int pagesize = 10;
            try
            {
                num2 = int.Parse(base.Request.Form["page"].ToString());
            }
            catch
            {
                num2 = 1;
            }
            if (num2 < 1)
            {
                num2 = 1;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            int num4 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM Ball_bf1 ").ToString());
            if (num4 > 120)
            {
                pagesize = (num4 / 2) + 1;
            }
            if (num4 == 0)
            {
                start = 0;
            }
            else
            {
                start = (num2 - 1) * pagesize;
            }
            int num3 = num4 / pagesize;
            if ((num4 % pagesize) > 0)
            {
                num3++;
            }
            for (int i = 1; i <= num3; i++)
            {
                if (num2 == i)
                {
                    object pageorder = this.pageorder;
                    this.pageorder = string.Concat(new object[] { pageorder, "<option value=", i, " selected >", i, "</option>" });
                }
                else
                {
                    object obj3 = this.pageorder;
                    this.pageorder = string.Concat(new object[] { obj3, "<option value=", i, " >", i, "</option>" });
                }
            }
            object obj4 = this.pageorder;
            this.pageorder = string.Concat(new object[] { obj4, "/ ", num3, " 页" });
            string sql = "SELECT * FROM Ball_bf1 where tema<>'' order by balltime desc";
            DataSet set = base2.ExecuteDataSet(sql, start, pagesize, "ball_pl1");
            int num7 = 0;
            num7 = start;
            for (int j = 0; j < set.Tables[0].Rows.Count; j++)
            {
                this.kyglcontent = this.kyglcontent + " <TR class=list_cen><TD align=\"center\">" + set.Tables[0].Rows[j]["qishu"].ToString().Trim() + "</TD>";
                this.kyglcontent = this.kyglcontent + "<TD nowrap bgcolor=\"#C8D1D6\" align=center>" + set.Tables[0].Rows[j]["balltime"].ToString().Split(new char[] { ' ' })[0] + "</TD>";
                string kyglcontent = this.kyglcontent;
                this.kyglcontent = kyglcontent + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num1"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num1"].ToString() + "</font></TD>";
                string text9 = this.kyglcontent;
                this.kyglcontent = text9 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num2"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num2"].ToString() + "</font></TD>";
                string text10 = this.kyglcontent;
                this.kyglcontent = text10 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num3"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num3"].ToString() + "</font></TD>";
                string text11 = this.kyglcontent;
                this.kyglcontent = text11 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num4"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num4"].ToString() + "</font></TD>";
                string text12 = this.kyglcontent;
                this.kyglcontent = text12 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num5"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num5"].ToString() + "</font></TD>";
                string text13 = this.kyglcontent;
                this.kyglcontent = text13 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["num6"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["num6"].ToString() + "</font></TD>";
                string text14 = this.kyglcontent;
                this.kyglcontent = text14 + "<TD width=50 align=middle bgcolor=\"C1D7E5\" class=\"ball_td\" align=\"center\" background=" + MyFunc.GetRGB(set.Tables[0].Rows[j]["tema"].ToString()) + " height=\"27\"><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">" + set.Tables[0].Rows[j]["tema"].ToString() + "</font></TD>";
                num7 = (((((int.Parse(set.Tables[0].Rows[j]["num1"].ToString()) + int.Parse(set.Tables[0].Rows[j]["num2"].ToString())) + int.Parse(set.Tables[0].Rows[j]["num3"].ToString())) + int.Parse(set.Tables[0].Rows[j]["num4"].ToString())) + int.Parse(set.Tables[0].Rows[j]["num5"].ToString())) + int.Parse(set.Tables[0].Rows[j]["num6"].ToString())) + int.Parse(set.Tables[0].Rows[j]["tema"].ToString());
                object obj5 = this.kyglcontent;
                this.kyglcontent = string.Concat(new object[] { obj5, "<TD width=50 align=middle bgcolor=\"C1D7E5\" height=\"27\"><strong>", num7, "</strong></TR>" });
            }
            set.Dispose();
            base2.Dispose();
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
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                this.msg = "<div class=hover>";
                while (reader.Read())
                {
                    this.msg = this.msg + reader["content"].ToString().Trim();
                }
                this.msg = this.msg + "</div>";
                reader.Close();
                base2.Dispose();
                this.FootBallList();
                this.DataBind();
            }
        }
    }
}

