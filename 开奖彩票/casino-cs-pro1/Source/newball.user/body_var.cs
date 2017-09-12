namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Collections;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class body_var : Page
    {
        public string isclose = "1";
        public string kaisai = "";
        public string kyglcontent = "";
        public string msg = "";
        public string num = "";
        public string qishu = "";
        public string Reload = "";
        public string wtype = "";

        private void ErrorContent()
        {
            MyFunc.goToLoginPage();
        }

        private void fContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>199 and id<212 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.sOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.sIds = Array(" + text2 + ");\n";
                text = "";
                text2 = "";
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>211 and id<215 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.cOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.cOddsId = Array(" + text2 + ");\n";
                reader.Close();
                base2.Dispose();
            }
            this.kyglcontent = this.kyglcontent + "parent.cOddsName = Array('红波','绿波','蓝波');";
            this.num = "15";
        }

        private void futureContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('单','双','大','小','红波','绿波','蓝波');";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>10 and id<35 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>132 and id<151 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.pOddsId = Array(" + text2 + ");\n";
                reader.Close();
                base2.Dispose();
            }
            this.num = "1";
        }

        private void hfContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('单','双','大','小','红波','绿波','蓝波');\n";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE tztype=21 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.pOddsId = Array(" + text2 + ");\n";
                base2.Dispose();
            }
            this.num = "12";
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        public string MulitPager(int totalRecord, int perPage, int curPage, string url)
        {
            int num = 10;
            int num2 = 1;
            int num3 = 2;
            string text = "";
            if (totalRecord > perPage)
            {
                num2 = totalRecord / perPage;
                if ((totalRecord % perPage) > 0)
                {
                    num2++;
                }
                int num4 = curPage - num3;
                int num5 = ((curPage + num) - num3) - 1;
                if (num > num2)
                {
                    num4 = 1;
                    num5 = num2;
                }
                else if (num4 < 1)
                {
                    num5 = (curPage + 1) - num4;
                    num4 = 1;
                    if (((num5 - num4) < num) && ((num5 - num4) < num2))
                    {
                        num5 = num;
                    }
                }
                else if (num5 > num2)
                {
                    num4 = (curPage - num2) + num5;
                    num5 = num2;
                    if (((num5 - num4) < num) && ((num5 - num4) < num2))
                    {
                        num4 = (num2 - num) + 1;
                    }
                }
                text = "<a href='" + url + "&page=1' target=bettingMainFrame><font face=webdings>9</font></a>&nbsp;";
                for (int i = num4; i <= num5; i++)
                {
                    if (i != curPage)
                    {
                        string text4 = text;
                        text = text4 + "[<a href='" + url + "&page=" + i.ToString() + "' target=bettingMainFrame>" + i.ToString() + "</a>]&nbsp;";
                    }
                    else
                    {
                        text = text + "[<font color=red><u><b>" + i.ToString() + "</b></u></font>]&nbsp;";
                    }
                }
                text = text + ((num2 > num) ? ("... <a href='" + url + "&page=" + num2.ToString() + "' target=bettingMainFrame>" + num2.ToString() + "&gt;&gt;</a>") : ("<a href='" + url + "&page=" + num2.ToString() + "' target=bettingMainFrame><font face=webdings>:</font></a>"));
            }
            if (num2 < 1)
            {
                num2++;
            }
            return (("共&nbsp;" + num2.ToString() + "&nbsp;页 每页&nbsp;" + perPage.ToString() + "&nbsp;场 共&nbsp;" + totalRecord.ToString() + "&nbsp;场") + "&nbsp;&nbsp;" + text);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            if (hashtable.hash1 == null)
            {
                Hashtable hashtable1 = new Hashtable(0x18, 0.5f);
                hashtable1.Add("EVEN", 0);
                hashtable1.Add("SP", 1);
                hashtable1.Add("NA", 2);
                hashtable1.Add("NO", 3);
                hashtable1.Add("CH", 4);
                hashtable1.Add("SPA", 5);
                hashtable1.Add("SPB", 6);
                hashtable1.Add("pr", 7);
                hashtable1.Add("future", 8);
                hashtable1.Add("SX", 9);
                hashtable1.Add("HF", 10);
                hashtable.hash1 = hashtable1;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,tupdatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            while (reader.Read())
            {
                DateTime time;
                this.msg = this.msg + "<TR ><TD width=100%>" + MyFunc.ConvertStr(reader["content"].ToString().Trim()) + "</TD></TR>";
                this.qishu = reader["qishu"].ToString().Trim();
                if ((base.Request.QueryString["rtype"].Trim() == "SP") || (base.Request.QueryString["rtype"].Trim() == "SPA"))
                {
                    time = Convert.ToDateTime(reader["tupdatetime"].ToString().Trim());
                }
                else
                {
                    time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                }
                TimeSpan span = time.Subtract(DateTime.Now);
                int num = ((span.Hours * 0xe10) + (span.Minutes * 60)) + span.Seconds;
                if (num > 0)
                {
                    if ((base.Request.QueryString["rtype"].Trim() == "SP") || (base.Request.QueryString["rtype"].Trim() == "SPA"))
                    {
                        this.kaisai = reader["tupdatetime"].ToString().Trim();
                    }
                    else
                    {
                        this.kaisai = reader["kaisai"].ToString().Trim();
                    }
                    this.isclose = reader["isclose"].ToString();
                }
            }
            reader.Close();
            base2.Dispose();
            if (this.isclose == "1")
            {
                this.kaisai = "";
            }
            if (this.kaisai != "")
            {
                switch (base.Request.QueryString["rtype"].Trim())
                {
                    case "EVEN":
                        this.rContent();
                        this.wtype = "EVEN";
                        goto Label_0649;

                    case "SP":
                        this.vContent();
                        this.wtype = "SP";
                        goto Label_0649;

                    case "NA":
                        this.reContent();
                        this.wtype = "NA";
                        goto Label_0649;

                    case "NO":
                        this.pdContent();
                        this.wtype = "NO";
                        goto Label_0649;

                    case "CH":
                        this.tContent();
                        this.wtype = "CH";
                        goto Label_0649;

                    case "SPA":
                        this.fContent();
                        this.wtype = "SPA";
                        goto Label_0649;

                    case "SPB":
                        this.pContent();
                        this.wtype = "SPB";
                        goto Label_0649;

                    case "pr":
                        this.prContent();
                        this.wtype = "SPB";
                        goto Label_0649;

                    case "future":
                        this.futureContent();
                        this.wtype = "NO";
                        goto Label_0649;

                    case "SX":
                        this.sxContent();
                        this.wtype = "SX";
                        goto Label_0649;

                    case "HF":
                        this.hfContent();
                        this.wtype = "HF";
                        goto Label_0649;
                }
                this.ErrorContent();
            }
            else
            {
                object obj3;
                if (((obj3 = base.Request.QueryString["rtype"].Trim()) != null) && ((obj3 = hashtable.hash1[obj3]) != null))
                {
                    switch (((int) obj3))
                    {
                        case 0:
                            this.wtype = "EVEN";
                            goto Label_0649;

                        case 1:
                            this.wtype = "SP";
                            goto Label_0649;

                        case 2:
                            this.wtype = "NA";
                            goto Label_0649;

                        case 3:
                            this.wtype = "NO";
                            goto Label_0649;

                        case 4:
                            this.wtype = "CH";
                            goto Label_0649;

                        case 5:
                            this.wtype = "SPA";
                            goto Label_0649;

                        case 6:
                            this.wtype = "SPB";
                            goto Label_0649;

                        case 7:
                            this.wtype = "SPB";
                            goto Label_0649;

                        case 8:
                            this.wtype = "NO";
                            goto Label_0649;

                        case 9:
                            this.wtype = "SX";
                            goto Label_0649;

                        case 10:
                            this.wtype = "HF";
                            goto Label_0649;
                    }
                }
                this.ErrorContent();
            }
        Label_0649:
            this.DataBind();
        }

        private void pContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                SqlDataReader reader = new DataBase(MyFunc.GetConnStr(1)).ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>214 and id<227 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.sOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.sIds = Array(" + text2 + ");\n";
            }
            this.kyglcontent = this.kyglcontent + "parent.cOddsName = Array('红波','绿波','蓝波');";
            this.num = "1";
        }

        private void pdContent()
        {
            this.kyglcontent = "sTime = '159';";
            this.kyglcontent = this.kyglcontent + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kyglcontent = this.kyglcontent + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kyglcontent = this.kyglcontent + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kyglcontent = this.kyglcontent + "cOddsName = Array('单','双','大','小');";
            this.kyglcontent = this.kyglcontent + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kyglcontent = this.kyglcontent + "uOddsName = Array('总单','总双','总大','总小');";
            this.kyglcontent = this.kyglcontent + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void prContent()
        {
            this.kyglcontent = "sTime = '159';";
            this.kyglcontent = this.kyglcontent + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kyglcontent = this.kyglcontent + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kyglcontent = this.kyglcontent + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kyglcontent = this.kyglcontent + "cOddsName = Array('单','双','大','小');";
            this.kyglcontent = this.kyglcontent + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kyglcontent = this.kyglcontent + "uOddsName = Array('总单','总双','总大','总小');";
            this.kyglcontent = this.kyglcontent + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void rContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';\n";
                }
                SqlDataReader reader = null;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('特单','特双','特大','特小','合单','合双');\n";
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>0 and id<7 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.pOddsId = Array(" + text2 + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.cOddsName = Array('单','双','大','小');\n";
                text = "";
                text2 = "";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>10 and id<35 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.cOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.cOddsId = Array(" + text2 + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.uOddsName = Array('总单','总双','总大','总小');\n";
                text = "";
                text2 = "";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>6 and id<11 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.uOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.uOddsId = Array(" + text2 + ");\n";
                reader.Close();
                base2.Dispose();
            }
            this.num = "1";
        }

        private void reContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';\n";
                }
                this.kyglcontent = this.kyglcontent + "parent.gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>83 and id<133 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.sOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.sIds = Array(" + text2 + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('总单','总双','总大','总小');";
                text = "";
                text2 = "";
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>6 and id<11 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                text = text.Substring(0, text.Length - 1);
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array(" + text + ");\n";
                this.kyglcontent = this.kyglcontent + "parent.pOddsId = Array(" + text2 + ");\n";
                reader.Close();
                base2.Dispose();
            }
            this.num = "53";
        }

        private void sxContent()
        {
            string text = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('单','双','大','小','红波','绿波','蓝波');\n";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id=230 ORDER BY id asc");
                if (reader.Read())
                {
                    text = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                }
                reader.Close();
                reader.Close();
                base2.Dispose();
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array('" + text + "');\n";
                reader.Close();
                base2.Dispose();
            }
            this.num = "1";
        }

        private void tContent()
        {
            this.kyglcontent = "sTime = '159';";
            this.kyglcontent = this.kyglcontent + "gID = 'a8173d88803a34e294ae8c1f0517c25a13149';";
            this.kyglcontent = this.kyglcontent + "pOddsName = Array('特单','特双','特大','特小','合单','合双');";
            this.kyglcontent = this.kyglcontent + "pOdds = Array('1.87','1.89','1.88','1.88','1.89','1.87');";
            this.kyglcontent = this.kyglcontent + "cOddsName = Array('单','双','大','小');";
            this.kyglcontent = this.kyglcontent + "cOdds = Array('1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87','1.87');";
            this.kyglcontent = this.kyglcontent + "uOddsName = Array('总单','总双','总大','总小');";
            this.kyglcontent = this.kyglcontent + "uOdds = Array('1.86','1.86','1.86','1.86','0','0');";
        }

        private void vContent()
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            if (num > 0)
            {
                if (num < 600)
                {
                    this.kyglcontent = "parent.sTime = '" + num + "';";
                }
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                SqlDataReader reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>34 and id<84 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text2 = text2 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                if (text != "")
                {
                    text = text.Substring(0, text.Length - 1);
                }
                text2 = text2.Substring(0, text2.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.sOdds = Array(" + text + ");";
                this.kyglcontent = this.kyglcontent + "parent.sIds = Array(" + text2 + ");";
                this.kyglcontent = this.kyglcontent + "parent.pOddsName = Array('特单','特双','特大','特小','合单','合双','红波','绿波','蓝波');";
                text = "";
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>0 and id<7 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text3 = text3 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                reader.Close();
                reader = base2.ExecuteReader("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>211 and id<215 ORDER BY id asc");
                while (reader.Read())
                {
                    text = text + "'" + double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "',";
                    text3 = text3 + "'" + double.Parse(reader["id"].ToString().Trim()).ToString() + "',";
                }
                if (text != "")
                {
                    text = text.Substring(0, text.Length - 1);
                }
                text3 = text3.Substring(0, text3.Length - 1);
                this.kyglcontent = this.kyglcontent + "parent.pOdds = Array(" + text + ");";
                this.kyglcontent = this.kyglcontent + "parent.sPds = Array(" + text3 + ");";
                reader.Close();
                base2.Dispose();
            }
            this.num = "58";
        }
    }
}

