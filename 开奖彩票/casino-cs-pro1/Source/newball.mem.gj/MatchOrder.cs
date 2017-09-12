namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class MatchOrder : Page
    {
        public string kyglContent = "";

        private string allggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + tztype).ToString();
        }

        private string allorder(string ballid, DataBase db, string isbk)
        {
            if (isbk.ToUpper() == "TRUE")
            {
                return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and ballid in (" + ballid + "," + ballid + " + 1," + ballid + " + 2)").ToString();
            }
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and ballid=" + ballid).ToString();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private string MatchList()
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            DataBase db = new DataBase(MyFunc.GetConnStr(2));
            text = text + "<tr bgcolor=#ffffff><td colspan=5>";
            string s = this.allggorder("16", db);
            string text3 = this.noggorder("16", db);
            string text7 = text;
            string[] textArray = new string[] { text7, "正码过关  总:", s, "  已结:", (int.Parse(s) - int.Parse(text3)).ToString(), "未结:", text3, "<br>" };
            text = string.Concat(textArray);
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM pl where id<158 or id>199 ORDER BY id");
            while (reader.Read())
            {
                string text4 = this.nojs(reader["id"].ToString().Trim(), db, "false");
                string text5 = this.allorder(reader["id"].ToString().Trim(), db, "false");
                if (((base.Request.QueryString["action"] == null) || (base.Request.QueryString["action"].ToString().Trim() != "no")) || (text4 != "0"))
                {
                    string text8 = text;
                    string[] textArray2 = new string[] { text8, "<tr><td bgcolor=#ffffff>", reader["id"].ToString().Trim(), "</td><td bgcolor=#ffffff>", reader["pltype"].ToString().Trim(), "</td><td align=center bgcolor=#ffffff>", text5, "</td><td align=center bgcolor=#ffffff>", (int.Parse(text5) - int.Parse(text4)).ToString(), "</td>" };
                    text = string.Concat(textArray2);
                    if (text4 != "0")
                    {
                        text = text + "<td align=center bgcolor=red>" + text4 + "</td></tr>";
                    }
                    else
                    {
                        text = text + "<td align=center bgcolor=#ffffff>" + text4 + "</td></tr>";
                    }
                }
            }
            reader.Close();
            base2.Dispose();
            db.Dispose();
            return text;
        }

        private string noggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and tztype=" + tztype + " AND isjs=0").ToString();
        }

        private string nojs(string ballid, DataBase db, string isbk)
        {
            if (isbk.ToUpper() == "TRUE")
            {
                return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and ballid in (" + ballid + "," + ballid + " + 1," + ballid + " + 2) AND isjs=0").ToString();
            }
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE datediff(hh,balltime,getdate())<12 and ballid=" + ballid + " AND isjs=0").ToString();
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

