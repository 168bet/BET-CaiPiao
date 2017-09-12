namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class temp : Page
    {
        public int cancelcount = 0;
        public string kaisai = "";
        public string kyglContent = "";
        public string[] result = null;
        public int tatal = 0;
        public string[] total = new string[240];
        public int zdcount = 0;
        public int[] zh = new int[20];

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private void JsZm3z2(string tztype)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT * FROM ball_order WHERE tztype=" + tztype + " AND iscancel=0";
            SqlDataReader reader = base3.ExecuteReader(sql);
            while (reader.Read())
            {
                string text2 = reader["rqteam"].ToString().Trim();
                double num = 0;
                double num2 = 0;
                double num3 = 1;
                double num5 = double.Parse(reader["rqc"].ToString().Trim());
                double num6 = double.Parse(reader["curpl"].ToString().Trim());
                double num7 = double.Parse(reader["tzmoney"].ToString().Trim());
                double num8 = double.Parse(reader["hsuser_w"].ToString().Trim());
                double num9 = double.Parse(reader["hsuser_l"].ToString().Trim());
                double num10 = double.Parse(reader["hsdls_w"].ToString().Trim());
                double num11 = double.Parse(reader["hsdls_l"].ToString().Trim());
                double num12 = double.Parse(reader["hszdl_w"].ToString().Trim());
                double num13 = double.Parse(reader["hszdl_l"].ToString().Trim());
                double num14 = double.Parse(reader["hsgd_w"].ToString().Trim());
                double num15 = double.Parse(reader["hsgd_l"].ToString().Trim());
                double num16 = 0;
                double num17 = 0;
                double num18 = 0;
                string text3 = reader["tzteam"].ToString().Trim();
                int num19 = 0;
                int num20 = 0;
                int num21 = 0;
                if (text3.IndexOf("^") == -1)
                {
                    string[] textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                    num21 = ((textArray.Length * (textArray.Length - 1)) * (textArray.Length - 2)) / 2;
                    for (int i = 0; i < textArray.Length; i++)
                    {
                        for (int j = 0; j < 6; j++)
                        {
                            if (textArray[i].ToString().Trim() == this.result[j].ToString().Trim())
                            {
                                num19++;
                                break;
                            }
                        }
                    }
                    if (num19 >= 2)
                    {
                        num20 = (num19 * (num19 - 1)) / 2;
                    }
                    if (num19 >= 3)
                    {
                        num19 = ((num19 * (num19 - 1)) * (num19 - 2)) / 6;
                    }
                }
                else
                {
                    string[] textArray2 = reader["tzteam"].ToString().Trim().Replace("^", ",").Split(new char[] { ',' });
                    num21 = ((textArray2.Length - 1) * (textArray2.Length - 2)) / 2;
                    string text4 = "0";
                    for (int k = 0; k < 6; k++)
                    {
                        if (textArray2[0].ToString().Trim() == this.result[k].ToString().Trim())
                        {
                            text4 = "1";
                            break;
                        }
                    }
                    if (text4 == "1")
                    {
                        for (int m = 1; m < textArray2.Length; m++)
                        {
                            for (int n = 0; n < 6; n++)
                            {
                                if (textArray2[m].ToString().Trim() == this.result[n].ToString().Trim())
                                {
                                    num19++;
                                    break;
                                }
                            }
                        }
                        if (num19 >= 1)
                        {
                            num20 = num19;
                        }
                        if (num19 >= 2)
                        {
                            num19 = (num19 * (num19 - 1)) / 2;
                        }
                    }
                    else
                    {
                        for (int index = 1; index < textArray2.Length; index++)
                        {
                            for (int num28 = 0; num28 < 6; num28++)
                            {
                                if (textArray2[index].ToString().Trim() == this.result[num28].ToString().Trim())
                                {
                                    num19++;
                                    break;
                                }
                            }
                        }
                        if (num19 >= 2)
                        {
                            num20 = (num19 * (num19 - 1)) / 2;
                        }
                    }
                }
                string text5 = string.Concat(new object[] { "中二<font color=red>", num20, "</font>注<br>中三<font color=red>", num19, "</font>注" });
                if ((num20 > 0) || (num19 > 0))
                {
                    base.Response.Write(num7 + "<br>");
                    base.Response.Write(num21 + "<br>");
                    base.Response.Write(num7 / ((double) num21));
                    base.Response.End();
                    double num29 = num7 / ((double) num21);
                    num = (num6 * int.Parse(num29.ToString())) * num20;
                    num3 = 2;
                }
                else
                {
                    num2 = num7;
                    num3 = 1;
                }
                if (num > 0)
                {
                    num16 = num + (((num7 * num10) / 100) * num3);
                    num17 = num + (((num7 * num12) / 100) * num3);
                    num18 = num + (((num7 * num14) / 100) * num3);
                    num += ((num7 * num8) / 100) * num3;
                }
                if (num2 > 0)
                {
                    num16 = -num2 + (((num7 * num11) / 100) * num3);
                    num17 = -num2 + (((num7 * num13) / 100) * num3);
                    num18 = -num2 + (((num7 * num15) / 100) * num3);
                    num2 -= ((num7 * num9) / 100) * num3;
                }
                if ((num == 0) && (num2 == 0))
                {
                    num3 = 0;
                }
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + ",ds='" + text5 + "' WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT top 1 * FROM ball_bf1 order by balltime desc ";
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                this.result = (reader["num1"].ToString().Trim() + "," + reader["num2"].ToString().Trim() + "," + reader["num3"].ToString().Trim() + "," + reader["num4"].ToString().Trim() + "," + reader["num5"].ToString().Trim() + "," + reader["num6"].ToString().Trim() + "," + reader["tema"].ToString().Trim()).Split(new char[] { ',' });
                this.kaisai = reader["balltime"].ToString();
                this.tatal = (((((int.Parse(reader["num1"].ToString().Trim()) + int.Parse(reader["num2"].ToString().Trim())) + int.Parse(reader["num3"].ToString().Trim())) + int.Parse(reader["num4"].ToString().Trim())) + int.Parse(reader["num5"].ToString().Trim())) + int.Parse(reader["num6"].ToString().Trim())) + int.Parse(reader["tema"].ToString().Trim());
                this.zh[0] = int.Parse(reader["tema"].ToString().Substring(0, 1)) + int.Parse(reader["tema"].ToString().Substring(1, 1));
            }
            reader.Close();
            sql = "SELECT result FROM pl order by id asc ";
            reader = base2.ExecuteReader(sql);
            int num = 1;
            while (reader.Read())
            {
                this.total[num++] = reader["result"].ToString().Trim();
            }
            reader.Close();
            base2.Dispose();
            this.JsZm3z2("12");
            base.Response.Write("ok");
        }
    }
}

