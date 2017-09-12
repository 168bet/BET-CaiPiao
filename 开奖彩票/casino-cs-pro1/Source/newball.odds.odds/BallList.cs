namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class BallList : Page
    {
        public string btnclassid = "";
        public string kyglcontent = "";
        public string kyglContent = "";
        public string kyglServerList = "";
        public string pageorder = "";

        public void delClick(string id)
        {
            string sql = "DELETE ball_bf1 WHERE ballid='" + id + "'";
            new DataBase(MyFunc.GetConnStr(2)).ExecuteNonQuery(sql);
            base.Response.Write("<script language=javascript>\n alert('删除成功！');\n</script>");
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
            string sql = "SELECT qishu,ballid,balltime ,isnull(num1,0) as num1,isnull(num2,0) as num2,isnull(num3,0) as num3,isnull(num4,0) as num4,isnull(num5,0) as num5,isnull(num6,0) as num6,isnull(tema,0) as tema FROM Ball_bf1 order by balltime desc";
            DataSet set = base2.ExecuteDataSet(sql, start, pagesize, "ball_pl1");
            int num7 = 0;
            num7 = start;
            for (int j = 0; j < set.Tables[0].Rows.Count; j++)
            {
                this.kyglcontent = this.kyglcontent + " <TR class=list_cen><TD align=\"center\">" + set.Tables[0].Rows[j]["qishu"].ToString().Trim() + "</TD>";
                this.kyglcontent = this.kyglcontent + "<TD nowrap bgcolor=\"#C8D1D6\" align=center>" + set.Tables[0].Rows[j]["balltime"].ToString() + "</TD>";
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
                num7 = (((((this.myInt(set.Tables[0].Rows[j]["num1"].ToString()) + this.myInt(set.Tables[0].Rows[j]["num2"].ToString())) + this.myInt(set.Tables[0].Rows[j]["num3"].ToString())) + this.myInt(set.Tables[0].Rows[j]["num4"].ToString())) + this.myInt(set.Tables[0].Rows[j]["num5"].ToString())) + this.myInt(set.Tables[0].Rows[j]["num6"].ToString())) + this.myInt(set.Tables[0].Rows[j]["tema"].ToString());
                object obj5 = this.kyglcontent;
                this.kyglcontent = string.Concat(new object[] { obj5, "<TD width=50 align=middle bgcolor=\"C1D7E5\" height=\"27\"><strong>", num7, "</strong></td><td><a href=\"ballmsg.aspx?ballid=", set.Tables[0].Rows[j]["ballid"].ToString().Trim(), "&action=mod\">修改</a>&nbsp;/&nbsp;" });
                this.kyglcontent = this.kyglcontent + "<a href=\"javascript:if(confirm('确定删除！'))window.location='balllist.aspx?ballid=" + set.Tables[0].Rows[j]["ballid"].ToString().Trim() + "&action=del';\">删除</a></td></TR>";
            }
            set.Dispose();
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        public int myInt(string str)
        {
            try
            {
                return int.Parse(str);
            }
            catch
            {
                return 0;
            }
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void OpenGame(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=1 WHERE isbk = 0 AND ballid=" + ballid);
            base2.Dispose();
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (this.Session.Contents["classid"] != null)
            {
                this.btnclassid = this.Session.Contents["classid"].ToString().Trim();
                if ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2"))
                {
                    MyFunc.goToLoginPage();
                    base.Response.End();
                    return;
                }
            }
            if (this.Session.Contents["adminclassid"] != null)
            {
                this.btnclassid = this.Session.Contents["adminclassid"].ToString().Trim();
                if (this.Session.Contents["adminclassid"].ToString().Trim() != "5")
                {
                    MyFunc.goToLoginPage();
                    base.Response.End();
                    return;
                }
            }
            if ((this.Session.Contents["classid"] == null) && (this.Session.Contents["adminclassid"] == null))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                if (!base.IsPostBack && (base.Request.QueryString["ballid"] != null))
                {
                    this.delClick(base.Request.QueryString["ballid"].ToString().Trim());
                }
                this.FootBallList();
                this.DataBind();
            }
        }

        private void StopGame(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_bf SET isshow=0 WHERE isbk = 0 AND ballid=" + ballid);
            base2.Dispose();
        }

        private string SubServerList()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM subserver");
            string text = "";
            while (reader.Read())
            {
                string text3 = text;
                text = text3 + " <tr><td width=\"20%\" align=\"center\"><input type=\"checkbox\" id=cc" + reader["serverid"].ToString().Trim() + " name=\"slist\" value=\"" + reader["serverid"].ToString().Trim() + "\"></td><td width=\"80%\">" + reader["servername"].ToString().Trim() + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private void UpdateBallMsg(string ballid)
        {
            string text = "";
            if ((base.Request.Form["slist"] != null) && (base.Request.Form["slist"].ToString().Trim() != ""))
            {
                text = base.Request.Form["slist"].ToString().Trim().Replace(" ", "");
            }
            string text2 = base.Request.Form["maxc1"].ToString().Trim();
            string text3 = base.Request.Form["maxc2"].ToString().Trim();
            string text4 = base.Request.Form["maxc3"].ToString().Trim();
            string text5 = base.Request.Form["maxc4"].ToString().Trim();
            string text6 = base.Request.Form["maxc5"].ToString().Trim();
            string text7 = base.Request.Form["maxc6"].ToString().Trim();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("UPDATE ball_bf SET maxc1=" + text2 + ",maxc2=" + text3 + ",maxc3=" + text4 + ",maxc4=" + text5 + ",maxc5=" + text6 + ",maxc6=" + text7 + ",serverlist='" + text + "' WHERE isbk = 0 AND ballid=" + ballid);
            base2.Dispose();
        }
    }
}

