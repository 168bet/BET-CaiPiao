namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;

    public class GameFen : Page
    {
        public string kyglContent = "";

        private string allggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + tztype).ToString();
        }

        private string allorder(string ballid, DataBase db, string isbk)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + ballid).ToString();
        }

        public void delall()
        {
            string sql = "DELETE ball_order";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.Dispose();
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            sql = "update changeleave set giveup1sum=0";
            base3.ExecuteNonQuery(sql);
            base3.Dispose();
            base.Response.Write("<script language=javascript>\n alert('删除成功！');\n</script>");
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private string MatchList()
        {
            string text = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "del"))
            {
                this.delall();
            }
            for (int i = 1; i < 0x15; i++)
            {
                string s = this.nojs(i.ToString(), db, "false");
                string text3 = this.allorder(i.ToString(), db, "false");
                if (((base.Request.QueryString["action"] == null) || (base.Request.QueryString["action"].ToString().Trim() != "no")) || (s != "0"))
                {
                    string text5 = text;
                    string[] textArray = new string[] { text5, "<tr><td bgcolor=#ffffff>", MyFunc.GettzTypeName(i.ToString()), "</td><td align=center bgcolor=#ffffff>", text3, "</td><td align=center bgcolor=#ffffff>", (int.Parse(text3) - int.Parse(s)).ToString(), "</td>" };
                    text = string.Concat(textArray);
                    if (s != "0")
                    {
                        text = text + "<td align=center bgcolor=red>" + s + "</td>";
                    }
                    else
                    {
                        text = text + "<td align=center bgcolor=#ffffff>" + s + "</td>";
                    }
                    object obj2 = text;
                    text = string.Concat(new object[] { obj2, "<td bgcolor=#ffffff align=center><a href=BallJs.aspx?action=kygl&jstype=", i, "&ballid=0>结算</a></td></tr>" });
                }
            }
            db.Dispose();
            return text;
        }

        private string noggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + tztype + " AND isjs=0").ToString();
        }

        private string nojs(string ballid, DataBase db, string isbk)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + ballid + " AND isjs=0").ToString();
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (!base.IsPostBack)
            {
                this.kyglContent = this.MatchList();
                this.DataBind();
            }
        }
    }
}

