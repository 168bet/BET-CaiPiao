namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class changeleave : Page
    {
        public string kyglContent = "";

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
                string gsid = this.Session["adminuserid"].ToString();
                if (((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ffpost")) && ((base.Request.Form["ballid"] != null) && (base.Request.Form["ballid"].ToString().Trim() != "")))
                {
                    if (base.Request.Form["ballid"].ToString().Trim() == "0")
                    {
                        this.UpdateAllBallMsg(gsid);
                    }
                    else
                    {
                        this.UpdateBallMsg(base.Request.Form["ballid"].ToString().Trim(), gsid);
                    }
                }
                string sql = "SELECT bf.id,bf.pltype,isnull(cl.giveupmoney,0) as giveupmoney,isnull(cl.giveuppl,0) as giveuppl FROM Pl as bf LEFT JOIN changeleave as cl ON (bf.id = cl.ballid AND cl.gsid ='" + gsid + "')  order by bf.id asc";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    this.kyglContent = this.kyglContent + "<tr bgcolor=\"#FFFFFF\"><td width=180>" + reader["pltype"].ToString().Trim() + "</td>";
                    this.kyglContent = this.kyglContent + "";
                    string kyglContent = this.kyglContent;
                    this.kyglContent = kyglContent + "<td><table width=\"360\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#D9D9D9\"><tr><td width=40  bgcolor=\"#31607A\"><SPAN style=\"CURSOR: hand;\" onMouseOver=\"this.className='oo'\" onMouseOut=\"this.className='oo1'\" onclick=\"javascript:show_win('" + reader["id"].ToString().Trim() + "','" + reader["giveupmoney"].ToString().Trim() + "','" + reader["giveuppl"].ToString().Trim() + "');\">详细</span></td>";
                    string text4 = this.kyglContent;
                    this.kyglContent = text4 + "<td width=60 align=\"center\" bgcolor=\"#EAEAEA\">变化限额</td><td width=60 bgcolor=\"#EAEAEA\">" + reader["giveupmoney"].ToString().Trim() + "</td><td width=60 align=\"center\">变化率</td><td width=60>" + reader["giveuppl"].ToString().Trim() + "</td></tr></table></td></tr>";
                }
                reader.Close();
                base2.Dispose();
                this.DataBind();
            }
        }

        private void UpdateAllBallMsg(string gsid)
        {
            string text = base.Request.Form["giveupmoney"].ToString().Trim();
            string text2 = base.Request.Form["giveuppl"].ToString().Trim();
            if (text == "0")
            {
                text = "1";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            string sql = "SELECT * FROM pl";
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                if (base3.ExecuteScalar("SELECT COUNT(*) FROM changeleave WHERE ballid = '" + reader["id"].ToString().Trim() + "' AND gsid = '" + gsid + "'").ToString() != "0")
                {
                    sql = "UPDATE changeleave SET giveupmoney=" + text + ",giveuppl=" + text2 + " WHERE ballid = '" + reader["id"].ToString().Trim() + "' AND gsid = '" + gsid + "'";
                }
                else
                {
                    sql = "INSERT INTO changeleave (ballid,gsid,giveupmoney,giveuppl) values (" + reader["id"].ToString().Trim() + "," + gsid + "," + text + "," + text2 + ")";
                }
                base3.ExecuteNonQuery(sql);
            }
            reader.Close();
            base2.Dispose();
            base3.Dispose();
            base.Response.Redirect("changeleave.aspx");
        }

        private void UpdateBallMsg(string ballid, string gsid)
        {
            string text = base.Request.Form["giveupmoney"].ToString().Trim();
            string text2 = base.Request.Form["giveuppl"].ToString().Trim();
            if (text == "0")
            {
                text = "1";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            string sql = "SELECT COUNT(*) FROM changeleave WHERE ballid = '" + ballid + "' AND gsid = '" + gsid + "'";
            if (base2.ExecuteScalar(sql).ToString() != "0")
            {
                sql = "UPDATE changeleave SET giveupmoney=" + text + ",giveuppl=" + text2 + " WHERE ballid = '" + ballid + "' AND gsid = '" + gsid + "'";
            }
            else
            {
                sql = "INSERT INTO changeleave (ballid,gsid,giveupmoney,giveuppl) values (" + ballid + "," + gsid + "," + text + "," + text2 + ")";
            }
            base2.ExecuteNonQuery(sql);
            base2.Dispose();
            base.Response.Redirect("changeleave.aspx");
        }
    }
}

