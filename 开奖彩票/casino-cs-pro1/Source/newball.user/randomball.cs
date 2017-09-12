namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class randomball : Page
    {
        public string gTime = "";
        public string isclose = "";
        public string kaisai = "";
        public string kygltable = "";
        public string msg = "";
        public string qishu = "";

        private void AHHTContent()
        {
            string text = "";
            string text2 = "";
            TimeSpan span = Convert.ToDateTime(this.kaisai).Subtract(DateTime.Now);
            int num = (((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds;
            string[] textArray = "一, 二,三,四,五,六".Split(new char[] { ',' });
            if (num > 0)
            {
                int num2 = 0;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(1));
                DataSet set = base2.ExecuteDataSet("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE id>157 and id<200  ORDER BY id asc");
                for (int i = 0; i < 6; i++)
                {
                    this.kygltable = this.kygltable + " <tr> <td rowspan=\"3\" class=\"tr_title_set_cen\">正码" + textArray[i] + "</td>";
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i * 7]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[i * 7]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[i * 7]["id"].ToString().Trim();
                    object kygltable = this.kygltable;
                    this.kygltable = string.Concat(new object[] { kygltable, "  <td><input name=\"game", num2, "\" type=\"radio\" value=\"", text2, "\">单 <font color=\"#FF0000\"><b>", text, "</b></font></td>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 1]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 1]["id"].ToString().Trim();
                    object obj3 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj3, "  <td><input name=\"game", num2++, "\" type=\"radio\" value=\"", text2, "\">双 <font color=\"#FF0000\"><b>", text, "</b></font></td></tr>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 2]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 2]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 2]["id"].ToString().Trim();
                    object obj4 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj4, "  <tr class=ball_td> <td><input name=\"game", num2, "\" type=\"radio\" value=\"", text2, "\">大 <font color=\"#FF0000\"><b>", text, "</b></font></td>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 3]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 3]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 3]["id"].ToString().Trim();
                    object obj5 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj5, "  <td><input name=\"game", num2++, "\" type=\"radio\" value=\"", text2, "\">小 <font color=\"#FF0000\"><b>", text, "</b></font></td> <td>&nbsp;</td></tr>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 4]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 4]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 4]["id"].ToString().Trim();
                    object obj6 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj6, " <tr class=\"ball_td1\">  <td><input name=\"game", num2, "\" type=\"radio\" value=\"", text2, "\">红波 <font color=\"#FF0000\"><b>", text, "</b></font></td>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 5]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 5]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 5]["id"].ToString().Trim();
                    object obj7 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj7, "  <td><input name=\"game", num2, "\" type=\"radio\" value=\"", text2, "\">绿波 <font color=\"#FF0000\"><b>", text, "</b></font></td>" });
                    text = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[(i * 7) + 6]["pl"].ToString().Trim(), "0", set.Tables[0].Rows[(i * 7) + 6]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = set.Tables[0].Rows[(i * 7) + 6]["id"].ToString().Trim();
                    object obj8 = this.kygltable;
                    this.kygltable = string.Concat(new object[] { obj8, "  <td><input name=\"game", num2++, "\" type=\"radio\" value=\"", text2, "\">蓝波 <font color=\"#FF0000\"><b>", text, "</b></font></td></tr>" });
                }
                base2.Dispose();
                this.gTime = this.kaisai;
            }
            if (this.isclose == "1")
            {
                this.gTime = "";
            }
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
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai,isclose FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    this.msg = this.msg + MyFunc.ConvertStr(reader["content"].ToString().Trim());
                    this.qishu = reader["qishu"].ToString().Trim();
                    this.kaisai = reader["kaisai"].ToString().Trim();
                    this.isclose = reader["isclose"].ToString();
                }
                reader.Close();
                base2.Dispose();
                this.AHHTContent();
                this.DataBind();
            }
        }
    }
}

