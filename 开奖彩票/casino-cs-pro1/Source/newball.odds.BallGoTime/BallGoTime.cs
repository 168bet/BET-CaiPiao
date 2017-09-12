namespace newball.odds.BallGoTime
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class BallGoTime : Page
    {
        protected Button btnAdd;
        protected Button BtnBlue;
        protected Button BtnGreen;
        protected Button BtnHeDang;
        protected Button BtnHeShuang;
        protected Button BtnOver;
        protected Button BtnRed;
        protected Button BtnSingle;
        protected Button btnSub;
        protected Button BtnTwin;
        protected Button BtnUnder;
        public string kyglContent = "";
        protected TextBox TextBox1;
        protected TextBox TxtOdds;
        public string type = "";

        private string allggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype).ToString();
        }

        private string allorder(string ballid, DataBase db, string isbk)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + ballid).ToString();
        }

        private void btnAdd_Click(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            base2.ExecuteNonQuery("UPDATE pl SET pl = pl+0.5 WHERE id >34 and id<84");
            base2.Dispose();
            this.type = base.Request.QueryString["type"].ToString();
            this.kyglContent = this.MatchList(this.type);
            this.DataBind();
        }

        private void BtnBlue_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE id in(37,38,43,44,48,49,54,59,60,65,70,71,75,76,81,82)");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnGreen_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE id in(39,40,45,50,51,55,56,61,62,66,67,72,73,77,78,83)");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnHeDang_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE id in(35,37,39,41,43,44,46,48,50,52,55,57,59,61,63,64,66,68,70,72,75,77,79,81,83)");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnHeShuang_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE id in(36,38,40,42,45,47,49,51,53,54,56,58,60,62,64,65,67,69,71,73,74,76,78,80,82)");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnOver_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE ID >58 and id<84");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnRed_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE id in(35,36,41,42,46,47,52,53,57,58,63,64,68,69,74,79,80)");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnSingle_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE ID >34 and id<84 and id%2=1");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void btnSub_Click(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            base2.ExecuteNonQuery("UPDATE pl SET pl = pl-0.5 WHERE id >34 and id<84");
            base2.Dispose();
            this.type = base.Request.QueryString["type"].ToString();
            this.kyglContent = this.MatchList(this.type);
            this.DataBind();
        }

        private void BtnTwin_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE ID >34 and id<84 and id%2=0");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        private void BtnUnder_Click(object sender, EventArgs e)
        {
            try
            {
                double num = double.Parse(this.TxtOdds.Text.ToString());
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                base2.ExecuteNonQuery("UPDATE pl SET pl = '" + this.TxtOdds.Text.ToString() + "' WHERE ID >34 and id<59");
                base2.Dispose();
                this.type = base.Request.QueryString["type"].ToString();
                this.kyglContent = this.MatchList(this.type);
                this.DataBind();
            }
            catch
            {
                MyFunc.showmsg("陪率输入错误!!");
            }
        }

        public void delall()
        {
            string sql = "DELETE ball_order";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            base2.ExecuteNonQuery(sql);
            base.Response.Write("<script language=javascript>\n alert('删除成功！');\n</script>");
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            this.BtnSingle.Click += new EventHandler(this.BtnSingle_Click);
            this.BtnTwin.Click += new EventHandler(this.BtnTwin_Click);
            this.BtnOver.Click += new EventHandler(this.BtnOver_Click);
            this.BtnUnder.Click += new EventHandler(this.BtnUnder_Click);
            this.BtnRed.Click += new EventHandler(this.BtnRed_Click);
            this.BtnGreen.Click += new EventHandler(this.BtnGreen_Click);
            this.BtnBlue.Click += new EventHandler(this.BtnBlue_Click);
            this.BtnHeDang.Click += new EventHandler(this.BtnHeDang_Click);
            this.BtnHeShuang.Click += new EventHandler(this.BtnHeShuang_Click);
            this.btnSub.Click += new EventHandler(this.btnSub_Click);
            this.btnAdd.Click += new EventHandler(this.btnAdd_Click);
            base.Load += new EventHandler(this.Page_Load);
        }

        private string MatchList(string type)
        {
            string text = "";
            int num = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "del"))
            {
                this.delall();
            }
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM pl where tztype in (" + type + ")  ORDER BY id ");
            while (reader.Read())
            {
                if ((num % 3) == 0)
                {
                    text = text + "<tr>";
                }
                string text3 = text;
                string text4 = text3 + "<td bgcolor=#ffffff>" + reader["pltype"].ToString().Trim() + "</td><td align=center bgcolor=#ffffff>" + reader["pl"].ToString().Trim() + "</td>";
                text = text4 + "<td bgcolor=#ffffff align=center><SPAN style=\"CURSOR: hand;\" onMouseOver=\"this.className='oo'\" onMouseOut=\"this.className='oo1'\" onclick=\"javascript:show_win('" + reader["id"].ToString().Trim() + "','1','" + reader["pl"].ToString().Trim() + "')\">修改</span></td>";
                num++;
                if ((num % 3) == 0)
                {
                    text = text + "</tr>";
                }
            }
            if ((num % 3) != 0)
            {
                object obj2 = text;
                text = string.Concat(new object[] { obj2, "<td colspan=", (3 - (num % 3)) * 3, " bgcolor=#ffffff></td></tr>" });
            }
            base2.Dispose();
            return text;
        }

        private string noggorder(string tztype, DataBase db)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " AND isjs=0").ToString();
        }

        private string nojs(string ballid, DataBase db, string isbk)
        {
            return db.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + ballid + " AND isjs=0").ToString();
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            DataBase base2;
            MyFunc.isRefUrl();
            if (!base.IsPostBack)
            {
                base2 = new DataBase(MyFunc.GetConnStr(1));
                try
                {
                    if (base.Request.Form["autoID"].ToString().Trim() == "")
                    {
                        goto Label_00FB;
                    }
                    if (base.Request.Form["pl"].ToString().Trim() != "")
                    {
                        base2.ExecuteNonQuery("UPDATE pl SET pl = '" + base.Request.Form["pl"].ToString().Trim() + "' WHERE ID = '" + base.Request.Form["autoID"].ToString().Trim() + "'");
                        goto Label_00FB;
                    }
                    MyFunc.showmsg("请输入陪率!");
                }
                catch
                {
                }
            }
            return;
        Label_00FB:
            try
            {
                if (base.Request.Form["autoID1"].ToString().Trim() == "")
                {
                    goto Label_01DA;
                }
                if (base.Request.Form["pl"].ToString().Trim() != "")
                {
                    base2.ExecuteNonQuery("UPDATE pl SET pl = '" + base.Request.Form["pl"].ToString().Trim() + "' WHERE tztype in ( " + base.Request.Form["autoID1"].ToString().Trim() + ")");
                    goto Label_01DA;
                }
                MyFunc.showmsg("请输入陪率!");
            }
            catch
            {
            }
            return;
        Label_01DA:
            base2.Dispose();
            this.type = base.Request.QueryString["type"].ToString();
            if (this.type == "8")
            {
                this.TxtOdds.Visible = true;
                this.BtnSingle.Visible = true;
                this.BtnTwin.Visible = true;
                this.BtnOver.Visible = true;
                this.BtnUnder.Visible = true;
                this.BtnRed.Visible = true;
                this.BtnGreen.Visible = true;
                this.BtnBlue.Visible = true;
                this.BtnHeDang.Visible = true;
                this.BtnHeShuang.Visible = true;
                this.btnSub.Visible = true;
                this.btnAdd.Visible = true;
            }
            this.kyglContent = this.MatchList(this.type);
            this.DataBind();
        }
    }
}

