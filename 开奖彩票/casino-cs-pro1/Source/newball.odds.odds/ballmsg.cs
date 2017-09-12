namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class ballmsg : Page
    {
        protected TextBox ballid;
        protected Button Button2;
        protected Button ButtonSaveBtn;
        protected CheckBox CheckBoxHomeWay;
        protected TextBox kaisai;
        public string kyglSelBallId = "";
        public string kyglSelMatch = "";
        public string kyglServerList = "";
        protected Label Label1;
        protected TextBox num1;
        protected TextBox num2;
        protected TextBox num3;
        protected TextBox num4;
        protected TextBox num5;
        protected TextBox num6;
        protected TextBox qishu;
        protected RadioButton RadioButtonXenial1;
        protected RadioButton RadioButtonXenial2;
        protected TextBox tema;
        protected TextBox TextBoxAction;
        protected TextBox TextBoxBallid;
        protected TextBox TextBoxBallTime;
        protected TextBox TextBoxMatchColor;
        protected TextBox TextBoxMaxc1;
        protected TextBox TextBoxMaxc2;

        private void ButtonSaveBtn_Click(object sender, EventArgs e)
        {
            if (this.TextBoxAction.Text.Trim().ToUpper() == "ADD")
            {
                this.SaveNew();
            }
            if (this.TextBoxAction.Text.Trim().ToUpper() == "MOD")
            {
                this.SaveModify();
            }
        }

        private bool FindServerid(string[] listArray, string id)
        {
            for (int i = 0; i < listArray.Length; i++)
            {
                if (listArray[i] == id)
                {
                    return true;
                }
            }
            return false;
        }

        private string GetBallidList()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string text = "";
            SqlDataReader reader = base2.ExecuteReader("select ballid,matchname,team1,team2 from ball_pl1view");
            while (reader.Read())
            {
                string text3 = text;
                text = text3 + "<option value=\"" + reader["ballid"].ToString().Trim() + "\">" + reader["matchname"].ToString().Trim() + "--" + reader["team1"].ToString().Trim() + " VS " + reader["team2"].ToString().Trim() + "</option>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private string GetMatchList()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string text = "";
            SqlDataReader reader = base2.ExecuteReader("select distinct matchname,matchcolor from ball_pl1 where matchcolor<>''");
            while (reader.Read())
            {
                string text3 = text;
                text = text3 + "<option value=\"" + reader["matchcolor"].ToString().Trim() + "\" style=\"BACKGROUND-COLOR: " + reader["matchcolor"].ToString().Trim() + ";Color:#ffffff\">" + reader["matchname"].ToString().Trim() + "</option>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private string GetServerList(string sellist)
        {
            string text = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM subserver");
            string text2 = "";
            string[] listArray = sellist.Split(new char[] { ',' });
            while (reader.Read())
            {
                if (this.FindServerid(listArray, reader["serverid"].ToString().Trim()))
                {
                    text2 = " checked";
                }
                else
                {
                    text2 = "";
                }
                string text4 = text;
                text = text4 + "<tr><td width=\"71\"><input type=\"checkbox\" name=\"slist\" value=\"" + reader["serverid"].ToString().Trim() + "\"" + text2 + "></td><td width=\"213\">" + reader["servername"].ToString().Trim() + "</td></tr>";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        private void InitializeComponent()
        {
            this.ButtonSaveBtn.Click += new EventHandler(this.ButtonSaveBtn_Click);
            base.Load += new EventHandler(this.Page_Load);
        }

        private bool IsValidDate(string strIn)
        {
            try
            {
                DateTime.Parse(strIn);
                return true;
            }
            catch
            {
                return false;
            }
        }

        private bool IsValidNum(string strIn)
        {
            try
            {
                int num = int.Parse(strIn);
                if (strIn.Length < 2)
                {
                    return false;
                }
                return ((num > 0) && (num < 50));
            }
            catch
            {
                return false;
            }
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            MyFunc.isRefUrl();
            if (((this.Session.Contents["classid"] != null) && (this.Session.Contents["classid"].ToString().Trim() != "1")) && (this.Session.Contents["classid"].ToString().Trim() != "2"))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if ((this.Session.Contents["adminclassid"] != null) && (this.Session.Contents["adminclassid"].ToString().Trim() != "5"))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if ((this.Session.Contents["classid"] == null) && (this.Session.Contents["adminclassid"] == null))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "add"))
                {
                    this.kaisai.Text = DateTime.Now.ToString();
                    this.Label1.Text = "添加球赛";
                    this.TextBoxAction.Text = base.Request.QueryString["action"].ToString().Trim();
                }
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "mod")) && ((base.Request.QueryString["ballid"] != null) && (base.Request.QueryString["ballid"].ToString().Trim() != "")))
                {
                    this.ShowModify();
                }
                this.DataBind();
            }
        }

        private void recalculate(string n1, string n2, string n3, string n4, string n5, string n6, string te)
        {
            string sql = "";
            string text2 = n1 + "," + n2 + "," + n3 + "," + n4 + "," + n5 + "," + n6 + "," + te;
            string[] tztype = text2.Split(new char[] { ',' });
            int num = (((((int.Parse(n1) + int.Parse(n2)) + int.Parse(n3)) + int.Parse(n4)) + int.Parse(n5)) + int.Parse(n6)) + int.Parse(te);
            DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
            if (int.Parse(tztype[6]) != 0x31)
            {
                if ((int.Parse(tztype[6]) % 2) == 0)
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=1;" + "UPDATE pl SET result=1 WHERE id=2;";
                }
                else
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=2;" + "UPDATE pl SET result=1 WHERE id=1;";
                }
            }
            else
            {
                sql = sql + "UPDATE pl SET result=20 WHERE id=2;" + "UPDATE pl SET result=20 WHERE id=1;";
            }
            if (int.Parse(tztype[6]) != 0x31)
            {
                if (int.Parse(tztype[6]) >= 0x19)
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=4;" + "UPDATE pl SET result=1 WHERE id=3;";
                }
                else
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=3;" + "UPDATE pl SET result=1 WHERE id=4;";
                }
            }
            else
            {
                sql = sql + "UPDATE pl SET result=20 WHERE id=3;" + "UPDATE pl SET result=20 WHERE id=4;";
            }
            if (int.Parse(tztype[6]) != 0x31)
            {
                if (((int.Parse(tztype[6].ToString().Substring(0, 1)) + int.Parse(tztype[6].ToString().Substring(1, 1))) % 2) == 0)
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=5;" + "UPDATE pl SET result=1 WHERE id=6;";
                }
                else
                {
                    sql = sql + "UPDATE pl SET result=0 WHERE id=6;" + "UPDATE pl SET result=1 WHERE id=5;";
                }
            }
            else
            {
                sql = sql + "UPDATE pl SET result=20 WHERE id=5;" + "UPDATE pl SET result=20 WHERE id=6;";
            }
            if ((num % 2) == 0)
            {
                sql = sql + "UPDATE pl SET result=0 WHERE id=7;" + "UPDATE pl SET result=1 WHERE id=8;";
            }
            else
            {
                sql = sql + "UPDATE pl SET result=0 WHERE id=8;" + "UPDATE pl SET result=1 WHERE id=7;";
            }
            if (num >= 0xaf)
            {
                sql = sql + "UPDATE pl SET result=0 WHERE id=10;" + "UPDATE pl SET result=1 WHERE id=9;";
            }
            else
            {
                sql = sql + "UPDATE pl SET result=1 WHERE id=10;" + "UPDATE pl SET result=0 WHERE id=9;";
            }
            for (int i = 0; i < 6; i++)
            {
                if (int.Parse(tztype[i]) != 0x31)
                {
                    if ((int.Parse(tztype[i]) % 2) == 0)
                    {
                        object obj2 = sql;
                        object obj3 = string.Concat(new object[] { obj2, "UPDATE pl SET result=0 WHERE id=", i + 11, ";" });
                        sql = string.Concat(new object[] { obj3, "UPDATE pl SET result=1 WHERE id=", i + 0x11, ";" });
                    }
                    else
                    {
                        object obj4 = sql;
                        object obj5 = string.Concat(new object[] { obj4, "UPDATE pl SET result=0 WHERE id=", i + 0x11, ";" });
                        sql = string.Concat(new object[] { obj5, "UPDATE pl SET result=1 WHERE id=", i + 11, ";" });
                    }
                }
                else
                {
                    object obj6 = sql;
                    object obj7 = string.Concat(new object[] { obj6, "UPDATE pl SET result=20 WHERE id=", i + 11, ";" });
                    sql = string.Concat(new object[] { obj7, "UPDATE pl SET result=20 WHERE id=", i + 0x11, ";" });
                }
            }
            for (int j = 0; j < 6; j++)
            {
                if (int.Parse(tztype[j]) != 0x31)
                {
                    if (int.Parse(tztype[j]) >= 0x19)
                    {
                        object obj8 = sql;
                        object obj9 = string.Concat(new object[] { obj8, "UPDATE pl SET result=0 WHERE id=", j + 0x1d, ";" });
                        sql = string.Concat(new object[] { obj9, "UPDATE pl SET result=1 WHERE id=", j + 0x17, ";" });
                    }
                    else
                    {
                        object obj10 = sql;
                        object obj11 = string.Concat(new object[] { obj10, "UPDATE pl SET result=0 WHERE id=", j + 0x17, ";" });
                        sql = string.Concat(new object[] { obj11, "UPDATE pl SET result=1 WHERE id=", j + 0x1d, ";" });
                    }
                }
                else
                {
                    object obj12 = sql;
                    object obj13 = string.Concat(new object[] { obj12, "UPDATE pl SET result=20 WHERE id=", j + 0x1d, ";" });
                    sql = string.Concat(new object[] { obj13, "UPDATE pl SET result=20 WHERE id=", j + 0x17, ";" });
                }
            }
            for (int k = 1; k < 50; k++)
            {
                if (int.Parse(tztype[6]) == k)
                {
                    object obj14 = sql;
                    sql = string.Concat(new object[] { obj14, "UPDATE pl SET result=1 WHERE id=", k + 0x22, ";" });
                }
                else
                {
                    object obj15 = sql;
                    sql = string.Concat(new object[] { obj15, "UPDATE pl SET result=0 WHERE id=", k + 0x22, ";" });
                }
            }
            for (int m = 1; m < 50; m++)
            {
                if ((((int.Parse(tztype[0]) == m) || (int.Parse(tztype[1]) == m)) || ((int.Parse(tztype[2]) == m) || (int.Parse(tztype[3]) == m))) || ((int.Parse(tztype[4]) == m) || (int.Parse(tztype[5]) == m)))
                {
                    object obj16 = sql;
                    sql = string.Concat(new object[] { obj16, "UPDATE pl SET result=1 WHERE id=", m + 0x53, ";" });
                }
                else
                {
                    object obj17 = sql;
                    sql = string.Concat(new object[] { obj17, "UPDATE pl SET result=0 WHERE id=", m + 0x53, ";" });
                }
            }
            for (int n = 0; n < 6; n++)
            {
                if (MyFunc.GetRGB(int.Parse(tztype[n])) == "red")
                {
                    object obj18 = sql;
                    object obj19 = string.Concat(new object[] { obj18, "UPDATE pl SET result=1 WHERE id=", n + 0x85, ";" });
                    object obj20 = string.Concat(new object[] { obj19, "UPDATE pl SET result=0 WHERE id=", n + 0x8b, ";" });
                    sql = string.Concat(new object[] { obj20, "UPDATE pl SET result=0 WHERE id=", n + 0x91, ";" });
                }
                else if (MyFunc.GetRGB(int.Parse(tztype[n])) == "green")
                {
                    object obj21 = sql;
                    object obj22 = string.Concat(new object[] { obj21, "UPDATE pl SET result=0 WHERE id=", n + 0x85, ";" });
                    object obj23 = string.Concat(new object[] { obj22, "UPDATE pl SET result=1 WHERE id=", n + 0x8b, ";" });
                    sql = string.Concat(new object[] { obj23, "UPDATE pl SET result=0 WHERE id=", n + 0x91, ";" });
                }
                else
                {
                    object obj24 = sql;
                    object obj25 = string.Concat(new object[] { obj24, "UPDATE pl SET result=0 WHERE id=", n + 0x85, ";" });
                    object obj26 = string.Concat(new object[] { obj25, "UPDATE pl SET result=0 WHERE id=", n + 0x8b, ";" });
                    sql = string.Concat(new object[] { obj26, "UPDATE pl SET result=1 WHERE id=", n + 0x91, ";" });
                }
            }
            for (int index = 0; index < 6; index++)
            {
                if ((int.Parse(tztype[index]) % 2) == 0)
                {
                    object obj27 = sql;
                    object obj28 = string.Concat(new object[] { obj27, "UPDATE pl SET result=0 WHERE id=", (index * 7) + 0x9e, ";" });
                    sql = string.Concat(new object[] { obj28, "UPDATE pl SET result=1 WHERE id=", (index * 7) + 0x9f, ";" });
                }
                else
                {
                    object obj29 = sql;
                    object obj30 = string.Concat(new object[] { obj29, "UPDATE pl SET result=0 WHERE id=", (index * 7) + 0x9f, ";" });
                    sql = string.Concat(new object[] { obj30, "UPDATE pl SET result=1 WHERE id=", (index * 7) + 0x9e, ";" });
                }
            }
            for (int num8 = 0; num8 < 6; num8++)
            {
                if (int.Parse(tztype[num8]) >= 0x19)
                {
                    object obj31 = sql;
                    object obj32 = string.Concat(new object[] { obj31, "UPDATE pl SET result=0 WHERE id=", (num8 * 7) + 0xa1, ";" });
                    sql = string.Concat(new object[] { obj32, "UPDATE pl SET result=1 WHERE id=", (num8 * 7) + 160, ";" });
                }
                else
                {
                    object obj33 = sql;
                    object obj34 = string.Concat(new object[] { obj33, "UPDATE pl SET result=0 WHERE id=", (num8 * 7) + 160, ";" });
                    sql = string.Concat(new object[] { obj34, "UPDATE pl SET result=1 WHERE id=", (num8 * 7) + 0xa1, ";" });
                }
            }
            for (int num9 = 0; num9 < 6; num9++)
            {
                if (MyFunc.GetRGB(int.Parse(tztype[num9])) == "red")
                {
                    object obj35 = sql;
                    object obj36 = string.Concat(new object[] { obj35, "UPDATE pl SET result=1 WHERE id=", (num9 * 7) + 0xa2, ";" });
                    object obj37 = string.Concat(new object[] { obj36, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa3, ";" });
                    sql = string.Concat(new object[] { obj37, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa4, ";" });
                }
                else if (MyFunc.GetRGB(int.Parse(tztype[num9])) == "green")
                {
                    object obj38 = sql;
                    object obj39 = string.Concat(new object[] { obj38, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa2, ";" });
                    object obj40 = string.Concat(new object[] { obj39, "UPDATE pl SET result=1 WHERE id=", (num9 * 7) + 0xa3, ";" });
                    sql = string.Concat(new object[] { obj40, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa4, ";" });
                }
                else
                {
                    object obj41 = sql;
                    object obj42 = string.Concat(new object[] { obj41, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa2, ";" });
                    object obj43 = string.Concat(new object[] { obj42, "UPDATE pl SET result=0 WHERE id=", (num9 * 7) + 0xa3, ";" });
                    sql = string.Concat(new object[] { obj43, "UPDATE pl SET result=1 WHERE id=", (num9 * 7) + 0xa4, ";" });
                }
            }
            for (int num10 = 0; num10 < 12; num10++)
            {
                if (MyFunc.GettwelveId(tztype[6]) == num10.ToString())
                {
                    object obj44 = sql;
                    sql = string.Concat(new object[] { obj44, "UPDATE pl SET result=1 WHERE id=", num10 + 200, ";" });
                }
                else
                {
                    object obj45 = sql;
                    sql = string.Concat(new object[] { obj45, "UPDATE pl SET result=0 WHERE id=", num10 + 200, ";" });
                }
            }
            if (MyFunc.GetRGB(int.Parse(tztype[6])) == "red")
            {
                sql = (sql + "UPDATE pl SET result=1 WHERE id=212;") + "UPDATE pl SET result=0 WHERE id=213;" + "UPDATE pl SET result=0 WHERE id=214;";
            }
            else if (MyFunc.GetRGB(int.Parse(tztype[6])) == "green")
            {
                sql = (sql + "UPDATE pl SET result=0 WHERE id=212;") + "UPDATE pl SET result=1 WHERE id=213;" + "UPDATE pl SET result=0 WHERE id=214;";
            }
            else
            {
                sql = (sql + "UPDATE pl SET result=0 WHERE id=212;") + "UPDATE pl SET result=0 WHERE id=213;" + "UPDATE pl SET result=1 WHERE id=214;";
            }
            for (int num11 = 0; num11 < 12; num11++)
            {
                if (text2.IndexOf("49") == -1)
                {
                    if (MyFunc.GettwelveId(tztype, num11) > 0)
                    {
                        object obj46 = sql;
                        sql = string.Concat(new object[] { obj46, "UPDATE pl SET result=1 WHERE id=", num11 + 0xd7, ";" });
                    }
                    else
                    {
                        object obj47 = sql;
                        sql = string.Concat(new object[] { obj47, "UPDATE pl SET result=0 WHERE id=", num11 + 0xd7, ";" });
                    }
                }
                else if (int.Parse(MyFunc.GettwelveId("49")) != num11)
                {
                    if (MyFunc.GettwelveId(tztype, num11) > 0)
                    {
                        object obj48 = sql;
                        sql = string.Concat(new object[] { obj48, "UPDATE pl SET result=1 WHERE id=", num11 + 0xd7, ";" });
                    }
                    else
                    {
                        object obj49 = sql;
                        sql = string.Concat(new object[] { obj49, "UPDATE pl SET result=0 WHERE id=", num11 + 0xd7, ";" });
                    }
                }
                else if (MyFunc.GettwelveId(tztype, num11) > 1)
                {
                    object obj50 = sql;
                    sql = string.Concat(new object[] { obj50, "UPDATE pl SET result=1 WHERE id=", num11 + 0xd7, ";" });
                }
                else if (MyFunc.GettwelveId(tztype, num11) == 1)
                {
                    object obj51 = sql;
                    sql = string.Concat(new object[] { obj51, "UPDATE pl SET result=20 WHERE id=", num11 + 0xd7, ";" });
                }
                else
                {
                    object obj52 = sql;
                    sql = string.Concat(new object[] { obj52, "UPDATE pl SET result=0 WHERE id=", num11 + 0xd7, ";" });
                }
            }
            if (MyFunc.GetRGB(int.Parse(tztype[6])) == "red")
            {
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if ((int.Parse(tztype[6]) % 2) == 0)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=232;" + "UPDATE pl SET result=1 WHERE id=233;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=233;" + "UPDATE pl SET result=1 WHERE id=232;";
                    }
                }
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if (int.Parse(tztype[6]) >= 0x19)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=235;" + "UPDATE pl SET result=1 WHERE id=234;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=234;" + "UPDATE pl SET result=1 WHERE id=235;";
                    }
                }
                sql = sql + "UPDATE pl SET result=0 WHERE id>235 and id<244;";
            }
            else if (MyFunc.GetRGB(int.Parse(tztype[6])) == "green")
            {
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if ((int.Parse(tztype[6]) % 2) == 0)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=236;" + "UPDATE pl SET result=1 WHERE id=237;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=237;" + "UPDATE pl SET result=1 WHERE id=236;";
                    }
                }
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if (int.Parse(tztype[6]) >= 0x19)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=239;" + "UPDATE pl SET result=1 WHERE id=238;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=238;" + "UPDATE pl SET result=1 WHERE id=239;";
                    }
                }
                sql = sql + "UPDATE pl SET result=0 WHERE (id>231 and id<236) or (id>239 and id<244);";
            }
            else
            {
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if ((int.Parse(tztype[6]) % 2) == 0)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=240;" + "UPDATE pl SET result=1 WHERE id=241;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=241;" + "UPDATE pl SET result=1 WHERE id=240;";
                    }
                }
                if (int.Parse(tztype[6]) != 0x31)
                {
                    if (int.Parse(tztype[6]) >= 0x19)
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=243;" + "UPDATE pl SET result=1 WHERE id=242;";
                    }
                    else
                    {
                        sql = sql + "UPDATE pl SET result=0 WHERE id=242;" + "UPDATE pl SET result=1 WHERE id=243;";
                    }
                }
                sql = sql + "UPDATE pl SET result=0 WHERE (id>231 and id<240);";
            }
            if (int.Parse(tztype[6]) == 0x31)
            {
                sql = sql + "UPDATE pl SET result=20 WHERE (id>231 and id<244);";
            }
            sql = sql + "UPDATE pl SET result='" + MyFunc.GettwelveId(tztype[6]) + "' WHERE id=230;";
            base2.ExecuteNonQuery(sql);
            base2.Dispose();
        }

        private void SaveModify()
        {
            string text2 = this.num1.Text.ToString().Trim();
            string text3 = this.num2.Text.ToString().Trim();
            string text4 = this.num3.Text.ToString().Trim();
            string text5 = this.num4.Text.ToString().Trim();
            string text6 = this.num5.Text.ToString().Trim();
            string text7 = this.num6.Text.ToString().Trim();
            string te = this.tema.Text.ToString().Trim();
            string strIn = this.kaisai.Text.Trim();
            string text = this.ballid.Text.Trim();
            string text10 = this.qishu.Text.Trim();
            if (!this.IsValidDate(strIn))
            {
                MyFunc.showmsg("请输入正确的日期格式！");
                base.Response.End();
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT TOP 1 * FROM BALL_bf1 where BALLID=" + text);
            if (reader.Read())
            {
                reader.Close();
                string sql = "UPDATE ball_bf1 SET num1='" + text2 + "',num2='" + text3 + "',num3='" + text4 + "',num4='" + text5 + "',num5='" + text6 + "',num6='" + text7 + "',tema='" + te + "',balltime='" + strIn + "',qishu='" + text10 + "' WHERE ballid=" + text;
                base2.ExecuteNonQuery(sql);
            }
            reader.Close();
            reader = base2.ExecuteReader("SELECT TOP 1 * FROM ball_bf1 order by balltime desc");
            if ((((reader.Read() && (reader["qishu"].ToString() == text10)) && ((text2 != "") && (text3 != ""))) && (((text4 != "") && (text5 != "")) && ((text6 != "") && (text7 != "")))) && (te != ""))
            {
                this.recalculate(text2, text3, text4, text5, text6, text7, te);
            }
            reader.Close();
            base2.Dispose();
            MyFunc.showmsg("修改成功!");
            base.Response.Redirect("balllist.aspx");
        }

        private void SaveNew()
        {
            string text2 = this.num1.Text.Trim();
            string text3 = this.num2.Text.Trim();
            string text4 = this.num3.Text.Trim();
            string text5 = this.num4.Text.Trim();
            string text6 = this.num5.Text.Trim();
            string text7 = this.num6.Text.Trim();
            string te = this.tema.Text.Trim();
            string strIn = this.kaisai.Text.Trim();
            string text10 = this.qishu.Text.Trim();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (!this.IsValidDate(strIn))
            {
                MyFunc.showmsg("请输入正确的日期格式！");
                base.Response.End();
            }
            SqlDataReader reader = base2.ExecuteReader("SELECT TOP 1 * FROM ball_bf1 where balltime='" + strIn + "'");
            if (reader.Read())
            {
                reader.Close();
                MyFunc.showmsg("已有该期开赛结果");
                base.Response.End();
            }
            reader.Close();
            string sql = "INSERT INTO ball_bf1(num1,num2,num3,num4,num5,num6,tema,balltime,qishu)";
            string text12 = sql;
            sql = text12 + "VALUES('" + text2 + "','" + text3 + "','" + text4 + "','" + text5 + "','" + text6 + "','" + text7 + "','" + te + "','" + strIn + "','" + text10 + "');";
            base2.ExecuteNonQuery(sql);
            reader = base2.ExecuteReader("SELECT TOP 1 * FROM ball_bf1 order by balltime desc");
            if ((((reader.Read() && (reader["qishu"].ToString() == text10)) && ((text2 != "") && (text3 != ""))) && (((text4 != "") && (text5 != "")) && ((text6 != "") && (text7 != "")))) && (te != ""))
            {
                this.recalculate(text2, text3, text4, text5, text6, text7, te);
            }
            reader.Close();
            base2.Dispose();
            base.Response.Redirect("balllist.aspx");
        }

        private void ShowModify()
        {
            this.TextBoxAction.Text = "MOD";
            string text = base.Request.QueryString["ballid"].ToString().Trim();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM Ball_BF1 WHERE ballid=" + text + "");
            if (reader.Read())
            {
                this.num1.Text = reader["num1"].ToString().Trim();
                this.num2.Text = reader["num2"].ToString().Trim();
                this.num3.Text = reader["num3"].ToString().Trim();
                this.num4.Text = reader["num4"].ToString().Trim();
                this.num5.Text = reader["num5"].ToString().Trim();
                this.num6.Text = reader["num6"].ToString().Trim();
                this.tema.Text = reader["tema"].ToString().Trim();
                this.kaisai.Text = reader["balltime"].ToString().Trim();
                this.ballid.Text = text;
                this.qishu.Text = reader["qishu"].ToString().Trim();
                reader.Close();
                base2.Dispose();
            }
            else
            {
                reader.Close();
                base2.Dispose();
                MyFunc.showmsg("没该开赛结果");
                base.Response.End();
            }
        }
    }
}

