namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;
    using System.Web.UI;

    public class BallJsFrame : Page
    {
        public int cancelcount = 0;
        public string kaisai = "";
        public string kyglContent = "";
        public string[] result = null;
        public int tatal = 0;
        public string[] total = new string[240];
        public int zdcount = 0;
        public int[] zh = new int[20];

        private string Filter(string tf)
        {
            if (tf.ToUpper() == "TRUE")
            {
                return "1";
            }
            if (tf.ToUpper() == "FALSE")
            {
                return "0";
            }
            return tf;
        }

        private void gg1(string type, string td)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT ballid,fen1,fen2,ishtcancel,iscancel FROM ball_bf WHERE datediff(day,sortballtime,'" + td + "')=0");
            string iscancel = "0";
            if (type == "7")
            {
                while (reader.Read())
                {
                    if ((this.Filter(reader["iscancel"].ToString().Trim()) == "1") || (this.Filter(reader["ishtcancel"].ToString().Trim()) == "1"))
                    {
                        iscancel = "1";
                    }
                    else
                    {
                        iscancel = "0";
                    }
                    this.UpdateOrder1(type, reader["ballid"].ToString().Trim(), reader["fen2"].ToString().Trim(), iscancel);
                }
            }
            if (type == "8")
            {
                while (reader.Read())
                {
                    if ((this.Filter(reader["iscancel"].ToString().Trim()) == "1") || (this.Filter(reader["ishtcancel"].ToString().Trim()) == "1"))
                    {
                        iscancel = "1";
                    }
                    else
                    {
                        iscancel = "0";
                    }
                    this.UpdateOrder1(type, reader["ballid"].ToString().Trim(), reader["fen2"].ToString().Trim(), iscancel);
                }
            }
            if (type == "16")
            {
                while (reader.Read())
                {
                    if ((this.Filter(reader["iscancel"].ToString().Trim()) == "1") || (this.Filter(reader["ishtcancel"].ToString().Trim()) == "1"))
                    {
                        iscancel = "1";
                    }
                    else
                    {
                        iscancel = "0";
                    }
                    this.UpdateOrder1(type, reader["ballid"].ToString().Trim(), reader["fen2"].ToString().Trim(), iscancel);
                }
            }
            if (type == "17")
            {
                while (reader.Read())
                {
                    if (this.Filter(reader["iscancel"].ToString().Trim()) == "1")
                    {
                        iscancel = "1";
                    }
                    else
                    {
                        iscancel = "0";
                    }
                    this.UpdateOrder1(type, reader["ballid"].ToString().Trim(), reader["fen1"].ToString().Trim(), iscancel);
                }
            }
            reader.Close();
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private double JsggPl(string orderid, out bool isfinish)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM ball_order1 WHERE orderid=" + orderid);
            double num = 1;
            bool flag = true;
            while (reader.Read())
            {
                num *= double.Parse(reader["winpl"].ToString().Trim());
                if (double.Parse(reader["winpl"].ToString().Trim()) == -1)
                {
                    flag = false;
                }
            }
            reader.Close();
            base2.Dispose();
            isfinish = flag;
            return num;
        }

        private void JsHmSx(string tztype)
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
                string[] textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                string text3 = this.total[230];
                string text4 = "0";
                for (int i = 0; i < 6; i++)
                {
                    if (textArray[i].ToString().Trim() == text3)
                    {
                        text4 = "1";
                        break;
                    }
                }
                if ((reader["ballid"].ToString().Trim() == "230") && (text4 == "1"))
                {
                    num = num6 * num7;
                    num3 = 1;
                }
                else if ((reader["ballid"].ToString().Trim() == "231") && (text4 == "0"))
                {
                    num = num6 * num7;
                    num3 = 1;
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
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsHmZt(string tztype)
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
                int[] numArray = new int[2];
                string[] textArray = null;
                numArray[0] = 0;
                numArray[1] = 0;
                if (text3.IndexOf(this.result[6].ToString().Trim()) != -1)
                {
                    if (text3.IndexOf("^") == -1)
                    {
                        textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                        num20 = (textArray.Length * (textArray.Length - 1)) / 2;
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
                        numArray[0] = num19;
                        if (num19 >= 2)
                        {
                            numArray[1] = (num19 * (num19 - 1)) / 2;
                        }
                    }
                    else
                    {
                        textArray = reader["tzteam"].ToString().Trim().Replace("^", ",").Split(new char[] { ',' });
                        num20 = textArray.Length - 1;
                        if (textArray[0].ToString() == this.result[6].ToString())
                        {
                            for (int k = 1; k < textArray.Length; k++)
                            {
                                for (int m = 0; m < 6; m++)
                                {
                                    if (textArray[k].ToString().Trim() == this.result[m].ToString().Trim())
                                    {
                                        num19++;
                                    }
                                }
                            }
                            numArray[0] = num19;
                        }
                        else
                        {
                            string text4 = "0";
                            for (int n = 0; n < 6; n++)
                            {
                                if (textArray[0].ToString().Trim() == this.result[n].ToString().Trim())
                                {
                                    text4 = "1";
                                    break;
                                }
                            }
                            if (text4 == "1")
                            {
                                numArray[0] = 1;
                                for (int index = 1; index < textArray.Length; index++)
                                {
                                    for (int num27 = 0; num27 < 6; num27++)
                                    {
                                        if (textArray[index].ToString().Trim() == this.result[num27].ToString().Trim())
                                        {
                                            num19++;
                                        }
                                    }
                                }
                                numArray[0] = 1;
                                numArray[1] = num19;
                            }
                        }
                    }
                }
                else if (text3.IndexOf("^") == -1)
                {
                    textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                    num20 = (textArray.Length * (textArray.Length - 1)) / 2;
                    for (int num28 = 0; num28 < textArray.Length; num28++)
                    {
                        for (int num29 = 0; num29 < 6; num29++)
                        {
                            if (textArray[num28].ToString().Trim() == this.result[num29].ToString().Trim())
                            {
                                num19++;
                                break;
                            }
                        }
                    }
                    if (num19 >= 2)
                    {
                        numArray[1] = (num19 * (num19 - 1)) / 2;
                    }
                }
                else
                {
                    textArray = reader["tzteam"].ToString().Trim().Replace("^", ",").Split(new char[] { ',' });
                    num20 = textArray.Length - 1;
                    string text5 = "0";
                    for (int num30 = 0; num30 < 6; num30++)
                    {
                        if (textArray[0].ToString().Trim() == this.result[num30].ToString().Trim())
                        {
                            text5 = "1";
                            break;
                        }
                    }
                    if (text5 == "1")
                    {
                        for (int num31 = 1; num31 < textArray.Length; num31++)
                        {
                            for (int num32 = 0; num32 < 6; num32++)
                            {
                                if (textArray[num31].ToString().Trim() == this.result[num32].ToString().Trim())
                                {
                                    numArray[1]++;
                                    break;
                                }
                            }
                        }
                    }
                }
                string text6 = string.Concat(new object[] { "中特<font color=red>", numArray[0], "</font>注<br>中二<font color=red>", numArray[1], "</font>注" });
                if ((numArray[0] > 0) || (numArray[1] > 0))
                {
                    double num33 = num7 / ((double) num20);
                    double num34 = num7 / ((double) num20);
                    num = ((num6 * int.Parse(num33.ToString())) * numArray[0]) + ((double.Parse(reader["zdbf"].ToString().Trim()) * int.Parse(num34.ToString())) * numArray[1]);
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
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + ",ds='" + text6 + "' WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsTmCh(string tztype)
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
                if (text3.IndexOf(this.result[6].ToString().Trim()) != -1)
                {
                    if (text3.IndexOf("^") == -1)
                    {
                        string[] textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                        num20 = (textArray.Length * (textArray.Length - 1)) / 2;
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
                    }
                    else
                    {
                        string[] textArray2 = reader["tzteam"].ToString().Trim().Replace("^", ",").Split(new char[] { ',' });
                        num20 = textArray2.Length - 1;
                        if (textArray2[0].ToString() == this.result[6].ToString())
                        {
                            for (int k = 1; k < textArray2.Length; k++)
                            {
                                for (int m = 0; m < 6; m++)
                                {
                                    if (textArray2[k].ToString().Trim() == this.result[m].ToString().Trim())
                                    {
                                        num19++;
                                        break;
                                    }
                                }
                            }
                        }
                        else
                        {
                            string text4 = "0";
                            for (int n = 0; n < 6; n++)
                            {
                                if (textArray2[0].ToString().Trim() == this.result[n].ToString().Trim())
                                {
                                    text4 = "1";
                                    break;
                                }
                            }
                            if (text4 == "1")
                            {
                                num19++;
                            }
                        }
                    }
                }
                string text5 = "特串<font color=red>" + num19 + "</font>注";
                if (num19 > 0)
                {
                    double num26 = num7 / ((double) num20);
                    num = (num6 * int.Parse(num26.ToString())) * num19;
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

        private void JsTmDs(string tztype)
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
                if (int.Parse(this.result[6]) != 0x31)
                {
                    if ((int.Parse(this.result[6]) % 2) == (int.Parse(reader["ballid"].ToString().Trim()) % 2))
                    {
                        num = num6 * num7;
                        num3 = 1;
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
                }
                else
                {
                    num = num7;
                    num3 = 0.5;
                }
                if ((num == 0) && (num2 == 0))
                {
                    num3 = 0;
                }
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsTmDx(string tztype)
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
                if (int.Parse(this.result[6]) != 0x31)
                {
                    if ((int.Parse(this.result[6].ToString()) >= 0x19) && (int.Parse(reader["ballid"].ToString().Trim()) == 3))
                    {
                        num = num6 * num7;
                        num3 = 1;
                    }
                    else if ((int.Parse(this.result[6].ToString()) <= 0x19) && (int.Parse(reader["ballid"].ToString().Trim()) == 4))
                    {
                        num = num6 * num7;
                        num3 = 1;
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
                }
                else
                {
                    num = num7;
                    num3 = 0.5;
                }
                if ((num == 0) && (num2 == 0))
                {
                    num3 = 0;
                }
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsTmHsDs(string tztype)
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
                if (int.Parse(this.result[6]) != 0x31)
                {
                    if (((int.Parse(this.zh[0].ToString()) % 2) == 0) && (int.Parse(reader["ballid"].ToString().Trim()) == 6))
                    {
                        num = num6 * num7;
                        num3 = 1;
                    }
                    else if (((int.Parse(this.zh[0].ToString()) % 2) == 1) && (int.Parse(reader["ballid"].ToString().Trim()) == 5))
                    {
                        num = num6 * num7;
                        num3 = 1;
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
                }
                else
                {
                    num = num7;
                    num3 = 0.5;
                }
                if ((num == 0) && (num2 == 0))
                {
                    num3 = 0;
                }
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsZhDs(string tztype)
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
                if ((((int.Parse(this.tatal.ToString()) % 2) == 0) && (int.Parse(reader["ballid"].ToString().Trim()) == 8)) || (((int.Parse(this.tatal.ToString()) % 2) == 1) && (int.Parse(reader["ballid"].ToString().Trim()) == 7)))
                {
                    num = num6 * num7;
                    num3 = 1;
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
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsZhDx(string tztype)
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
                if ((int.Parse(this.tatal.ToString()) >= 0xaf) && (int.Parse(reader["ballid"].ToString().Trim()) == 9))
                {
                    num = num6 * num7;
                    num3 = 1;
                }
                else if ((int.Parse(this.tatal.ToString()) <= 0xae) && (int.Parse(reader["ballid"].ToString().Trim()) == 10))
                {
                    num = num6 * num7;
                    num3 = 1;
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
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsZm16Ds(string tztype)
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
                if (this.total[int.Parse(reader["ballid"].ToString().Trim())] != "20")
                {
                    if (this.total[int.Parse(reader["ballid"].ToString().Trim())] == "1")
                    {
                        num = num6 * num7;
                        num3 = 1;
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
                }
                else
                {
                    num = num7;
                    num3 = 0.5;
                }
                if ((num == 0) && (num2 == 0))
                {
                    num3 = 0;
                }
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
            }
            reader.Close();
            this.cancelcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=0 ").ToString());
            this.zdcount = int.Parse(base3.ExecuteScalar("SELECT COUNT(1) FROM ball_order WHERE tztype=" + tztype + " and isjs=1 ").ToString());
            base3.Dispose();
            base2.Dispose();
        }

        private void JsZm2qz(string tztype)
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
                    num21 = (textArray.Length * (textArray.Length - 1)) / 2;
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
                }
                else
                {
                    string[] textArray2 = reader["tzteam"].ToString().Trim().Replace("^", ",").Split(new char[] { ',' });
                    num21 = textArray2.Length - 1;
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
                                    num20++;
                                    break;
                                }
                            }
                        }
                    }
                }
                string text5 = "二全中<font color=red>" + num20 + "</font>注";
                if (num20 > 0)
                {
                    double num27 = num7 / ((double) num21);
                    num = (num6 * int.Parse(num27.ToString())) * num20;
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

        private void JsZm3qz(string tztype)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT * FROM ball_order WHERE tztype=" + tztype + " AND iscancel=0";
            SqlDataReader reader = base3.ExecuteReader(sql);
            while (reader.Read())
            {
                int num21;
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
                if (text3.IndexOf("^") == -1)
                {
                    string[] textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                    num21 = ((textArray.Length * (textArray.Length - 1)) * (textArray.Length - 2)) / 6;
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
                        if (num19 >= 2)
                        {
                            num19 = (num19 * (num19 - 1)) / 2;
                        }
                    }
                }
                string text5 = "三全中<font color=red>" + num19 + "</font>注";
                if (num19 > 0)
                {
                    double num27 = num7 / ((double) num21);
                    num = (num6 * int.Parse(num27.ToString())) * num19;
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
                    num21 = ((textArray.Length * (textArray.Length - 1)) * (textArray.Length - 2)) / 6;
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
                    double num29 = num7 / ((double) num21);
                    double num30 = num7 / ((double) num21);
                    num = ((num6 * int.Parse(num29.ToString())) * num20) + ((double.Parse(reader["zdbf"].ToString().Trim()) * int.Parse(num30.ToString())) * num19);
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

        private void JsZmGg(string tztype)
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
                string[] textArray = reader["tzteam"].ToString().Trim().Split(new char[] { ',' });
                string text3 = this.total[230];
                string text4 = "0";
                for (int i = 0; i < textArray.Length; i++)
                {
                    if (this.total[int.Parse(textArray[i].ToString().Trim())] == "0")
                    {
                        text4 = "1";
                        break;
                    }
                }
                if (text4 == "0")
                {
                    num = num6 * num7;
                    num3 = 1;
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
                base2.ExecuteNonQuery("UPDATE ball_order SET win=" + num.ToString() + ",lose=" + num2.ToString() + ",isjs=1,truewin=" + num3.ToString() + ",iscancel=0,mdls=" + num16.ToString() + ",mzdl=" + num17.ToString() + ",mgd=" + num18.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
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
            MyFunc.isRefUrl();
            if ((!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1)) || !MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage();
                return;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
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
            reader = base3.ExecuteReader(sql);
            int num = 1;
            while (reader.Read())
            {
                this.total[num++] = reader["result"].ToString().Trim();
            }
            reader.Close();
            base2.Dispose();
            base3.Dispose();
            if ((((base.Request.Form["action"] == null) || (base.Request.Form["action"].ToString().Trim() != "kygl")) || ((base.Request.Form["ballid"] == null) || (base.Request.Form["ballid"].ToString().Trim() == ""))) || ((base.Request.Form["jstype"] == null) || (base.Request.Form["jstype"].ToString().Trim() == "")))
            {
                return;
            }
            if (base.Request.Form["ballid"].ToString().Trim() == "0")
            {
                string tztype = base.Request.Form["jstype"].ToString().Trim();
                switch (base.Request.Form["jstype"].ToString().Trim())
                {
                    case "1":
                        this.JsTmDs(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '特别号:单双注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('特别号:单双注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "2":
                        this.JsTmDx(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '特别号:大小注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('特别号:大小注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "3":
                        this.JsTmHsDs(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '特别号:合数单双注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('特别号:合数单双注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "4":
                        this.JsZhDs(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '总和:单双注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('总和:单双注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "5":
                        this.JsZhDx(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML =' 总和:大小注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('总和:大小注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "6":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '正码1-6:单双注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('正码1-6:单双注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "7":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '正码1-6:大小注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('正码1-6:大小注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "8":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '特别号注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('特别号注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "9":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '正码注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('正码注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "10":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '正码1-6:色波注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('正码1-6:色波注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "11":
                        this.JsZm3qz(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '三全中注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('三全中注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "12":
                        this.JsZm3z2(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '三中二注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('三中二注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "13":
                        this.JsZm2qz(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '二全中注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('二全中注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "14":
                        this.JsHmZt(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '二中特注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('二中特注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "15":
                        this.JsTmCh(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '特串注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('特串注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "16":
                        this.JsZm3qz(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '正码过关注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('正码过关注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "17":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '色波注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('色波注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "18":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '生肖注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('生肖注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "19":
                        this.JsZm16Ds(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '一肖注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('一肖注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;

                    case "20":
                        this.JsHmSx(tztype);
                        this.kyglContent = "parent.document.all['ht_rq'].innerHTML = '六肖注单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('六肖注单结算完成');parent.location.href='GameFen.aspx';";
                        goto Label_0D95;
                }
                MyFunc.showmsg("请正确选择要结算的项目");
                base.Response.End();
                return;
            }
        Label_0D95:
            this.DataBind();
        }

        private string rqnum(string str)
        {
            string rqMarker = "";
            rqMarker = str.Replace(" ", "");
            if (rqMarker.IndexOf("/") < 0)
            {
                return MyFunc.turnNum(rqMarker);
            }
            double num = (double.Parse(MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[0])) + double.Parse(MyFunc.turnNum(rqMarker.Split(new char[] { '/' })[1]))) / 2;
            return num.ToString();
        }

        private string[] UpdateBallMsg(string ballid, DataBase db2)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string[] textArray = new string[0x13];
            SqlDataReader reader = base2.ExecuteReader("SELECT ballid,balltime,matchname,team1id,team1,team2id,team2,xenial,giveup,fen1,fen2,sortballtime,bftime,isshow,isclose,iscancel,stopmark,isjs,ishtcancel FROM ball_bf WHERE ballid=" + ballid);
            if (reader.Read())
            {
                for (int i = 0; i < 0x13; i++)
                {
                    textArray[i] = this.Filter(reader[i].ToString().Trim());
                }
            }
            reader.Close();
            base2.Dispose();
            if (int.Parse(db2.ExecuteScalar("SELECT COUNT(1) FROM ball_bf1 WHERE ballid=" + ballid).ToString()) > 0)
            {
                db2.ExecuteNonQuery("UPDATE ball_bf1 SET fen1='" + textArray[9] + "',fen2='" + textArray[10] + "',bftime='" + textArray[12] + "',iscancel=" + textArray[15] + ",ishtcancel=" + textArray[0x12] + " WHERE ballid=" + ballid);
                return textArray;
            }
            string sql = "INSERT INTO ball_bf1(ballid,balltime,matchname,team1id,team1,team2id,team2,xenial,giveup,fen1,fen2,sortballtime,bftime,isshow,isclose,iscancel,stopmark,isjs,ishtcancel)";
            string text2 = sql;
            sql = text2 + "VALUES(" + textArray[0] + ",'" + textArray[1] + "','" + textArray[2] + "'," + textArray[3] + ",'" + textArray[4] + "'," + textArray[5] + ",'" + textArray[6] + "','" + textArray[7] + "','" + textArray[8] + "','" + textArray[9] + "','" + textArray[10] + "','" + textArray[11] + "','" + textArray[12] + "'," + textArray[13] + "," + textArray[14] + "," + textArray[15] + ",'" + textArray[0x10] + "'," + textArray[0x11] + "," + textArray[0x12] + ");";
            db2.ExecuteNonQuery(sql);
            return textArray;
        }

        private void UpdateOrder1(string type, string ballid, string bf, string iscancel)
        {
            if (iscancel == "1")
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("UPDATE ball_order1 SET winpl=1 WHERE ballid=" + ballid + " AND tztype=" + type);
                base2.Dispose();
            }
            else if (bf.IndexOf(":") >= 0)
            {
                int num = int.Parse(bf.Split(new char[] { ':' })[0]);
                int num2 = int.Parse(bf.Split(new char[] { ':' })[1]);
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                if (type == "7")
                {
                    if (num > num2)
                    {
                        base3.ExecuteNonQuery(string.Concat(new object[] { "UPDATE ball_order1 SET winpl=pl,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=7 AND tzteam='1';UPDATE ball_order1 SET winpl=0,fen1=", num, ",fen2=", num2, " WHERE ballid=", ballid, " AND tztype=7 AND tzteam IN ('2','x')" }));
                    }
                    if (num < num2)
                    {
                        base3.ExecuteNonQuery(string.Concat(new object[] { "UPDATE ball_order1 SET winpl=pl,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=7 AND tzteam='2';UPDATE ball_order1 SET winpl=0,fen1=", num, ",fen2=", num2, " WHERE ballid=", ballid, " AND tztype=7 AND tzteam IN ('1','x')" }));
                    }
                    if (num == num2)
                    {
                        base3.ExecuteNonQuery(string.Concat(new object[] { "UPDATE ball_order1 SET winpl=pl,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=7 AND tzteam='x';UPDATE ball_order1 SET winpl=0,fen1=", num, ",fen2=", num2, " WHERE ballid=", ballid, " AND tztype=7 AND tzteam IN ('1','2')" }));
                    }
                    base3.Dispose();
                }
                if (type == "8")
                {
                    string text = "";
                    string text2 = "";
                    string text3 = "";
                    string text9 = text;
                    string[] textArray = new string[] { text9, "UPDATE ball_order1 SET winpl=1,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=8 AND tzteam='AH_H' AND rqteam='H' AND rq=", (num - num2).ToString(), ";" };
                    string text10 = string.Concat(textArray);
                    string[] textArray2 = new string[10];
                    textArray2[0] = text10;
                    textArray2[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray2[2] = num.ToString();
                    textArray2[3] = ",fen2=";
                    textArray2[4] = num2.ToString();
                    textArray2[5] = " WHERE ballid=";
                    textArray2[6] = ballid;
                    textArray2[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='H' AND rq<=";
                    textArray2[8] = ((num - num2) - 0.5).ToString();
                    textArray2[9] = ";";
                    string text11 = string.Concat(textArray2);
                    string[] textArray3 = new string[10];
                    textArray3[0] = text11;
                    textArray3[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray3[2] = num.ToString();
                    textArray3[3] = ",fen2=";
                    textArray3[4] = num2.ToString();
                    textArray3[5] = " WHERE ballid=";
                    textArray3[6] = ballid;
                    textArray3[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='H' AND rq=";
                    textArray3[8] = ((num - num2) - 0.25).ToString();
                    textArray3[9] = ";";
                    string text12 = string.Concat(textArray3);
                    string[] textArray4 = new string[10];
                    textArray4[0] = text12;
                    textArray4[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray4[2] = num.ToString();
                    textArray4[3] = ",fen2=";
                    textArray4[4] = num2.ToString();
                    textArray4[5] = " WHERE ballid=";
                    textArray4[6] = ballid;
                    textArray4[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='H' AND rq=";
                    textArray4[8] = ((num - num2) + 0.25).ToString();
                    textArray4[9] = ";";
                    string text13 = string.Concat(textArray4);
                    string[] textArray5 = new string[10];
                    textArray5[0] = text13;
                    textArray5[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray5[2] = num.ToString();
                    textArray5[3] = ",fen2=";
                    textArray5[4] = num2.ToString();
                    textArray5[5] = " WHERE ballid=";
                    textArray5[6] = ballid;
                    textArray5[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='H' AND rq>=";
                    textArray5[8] = ((num - num2) + 0.5).ToString();
                    textArray5[9] = ";";
                    string text14 = string.Concat(textArray5);
                    string[] textArray6 = new string[10];
                    textArray6[0] = text14;
                    textArray6[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray6[2] = num.ToString();
                    textArray6[3] = ",fen2=";
                    textArray6[4] = num2.ToString();
                    textArray6[5] = " WHERE ballid=";
                    textArray6[6] = ballid;
                    textArray6[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray6[8] = (num - num2).ToString();
                    textArray6[9] = ";";
                    string text15 = string.Concat(textArray6);
                    string[] textArray7 = new string[10];
                    textArray7[0] = text15;
                    textArray7[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray7[2] = num.ToString();
                    textArray7[3] = ",fen2=";
                    textArray7[4] = num2.ToString();
                    textArray7[5] = " WHERE ballid=";
                    textArray7[6] = ballid;
                    textArray7[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='H' AND rq>=";
                    textArray7[8] = ((num - num2) + 0.5).ToString();
                    textArray7[9] = ";";
                    string text16 = string.Concat(textArray7);
                    string[] textArray8 = new string[10];
                    textArray8[0] = text16;
                    textArray8[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray8[2] = num.ToString();
                    textArray8[3] = ",fen2=";
                    textArray8[4] = num2.ToString();
                    textArray8[5] = " WHERE ballid=";
                    textArray8[6] = ballid;
                    textArray8[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray8[8] = ((num - num2) + 0.25).ToString();
                    textArray8[9] = ";";
                    string text17 = string.Concat(textArray8);
                    string[] textArray9 = new string[10];
                    textArray9[0] = text17;
                    textArray9[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray9[2] = num.ToString();
                    textArray9[3] = ",fen2=";
                    textArray9[4] = num2.ToString();
                    textArray9[5] = " WHERE ballid=";
                    textArray9[6] = ballid;
                    textArray9[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray9[8] = ((num - num2) - 0.25).ToString();
                    textArray9[9] = ";";
                    string text18 = string.Concat(textArray9);
                    string[] textArray10 = new string[10];
                    textArray10[0] = text18;
                    textArray10[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray10[2] = num.ToString();
                    textArray10[3] = ",fen2=";
                    textArray10[4] = num2.ToString();
                    textArray10[5] = " WHERE ballid=";
                    textArray10[6] = ballid;
                    textArray10[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='H' AND rq<=";
                    textArray10[8] = ((num - num2) - 0.5).ToString();
                    textArray10[9] = ";";
                    text = string.Concat(textArray10);
                    string text19 = text2;
                    string[] textArray11 = new string[10];
                    textArray11[0] = text19;
                    textArray11[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray11[2] = num.ToString();
                    textArray11[3] = ",fen2=";
                    textArray11[4] = num2.ToString();
                    textArray11[5] = " WHERE ballid=";
                    textArray11[6] = ballid;
                    textArray11[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray11[8] = (num2 - num).ToString();
                    textArray11[9] = ";";
                    string text20 = string.Concat(textArray11);
                    string[] textArray12 = new string[10];
                    textArray12[0] = text20;
                    textArray12[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray12[2] = num.ToString();
                    textArray12[3] = ",fen2=";
                    textArray12[4] = num2.ToString();
                    textArray12[5] = " WHERE ballid=";
                    textArray12[6] = ballid;
                    textArray12[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='C' AND rq>=";
                    textArray12[8] = ((num2 - num) + 0.5).ToString();
                    textArray12[9] = ";";
                    string text21 = string.Concat(textArray12);
                    string[] textArray13 = new string[10];
                    textArray13[0] = text21;
                    textArray13[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray13[2] = num.ToString();
                    textArray13[3] = ",fen2=";
                    textArray13[4] = num2.ToString();
                    textArray13[5] = " WHERE ballid=";
                    textArray13[6] = ballid;
                    textArray13[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray13[8] = ((num2 - num) + 0.25).ToString();
                    textArray13[9] = ";";
                    string text22 = string.Concat(textArray13);
                    string[] textArray14 = new string[10];
                    textArray14[0] = text22;
                    textArray14[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray14[2] = num.ToString();
                    textArray14[3] = ",fen2=";
                    textArray14[4] = num2.ToString();
                    textArray14[5] = " WHERE ballid=";
                    textArray14[6] = ballid;
                    textArray14[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray14[8] = ((num2 - num) - 0.25).ToString();
                    textArray14[9] = ";";
                    string text23 = string.Concat(textArray14);
                    string[] textArray15 = new string[10];
                    textArray15[0] = text23;
                    textArray15[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray15[2] = num.ToString();
                    textArray15[3] = ",fen2=";
                    textArray15[4] = num2.ToString();
                    textArray15[5] = " WHERE ballid=";
                    textArray15[6] = ballid;
                    textArray15[7] = " AND tztype=8 AND tzteam='AH_H' AND rqteam='C' AND rq<=";
                    textArray15[8] = ((num2 - num) - 0.5).ToString();
                    textArray15[9] = ";";
                    string text24 = string.Concat(textArray15);
                    string[] textArray16 = new string[10];
                    textArray16[0] = text24;
                    textArray16[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray16[2] = num.ToString();
                    textArray16[3] = ",fen2=";
                    textArray16[4] = num2.ToString();
                    textArray16[5] = " WHERE ballid=";
                    textArray16[6] = ballid;
                    textArray16[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray16[8] = (num2 - num).ToString();
                    textArray16[9] = ";";
                    string text25 = string.Concat(textArray16);
                    string[] textArray17 = new string[10];
                    textArray17[0] = text25;
                    textArray17[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray17[2] = num.ToString();
                    textArray17[3] = ",fen2=";
                    textArray17[4] = num2.ToString();
                    textArray17[5] = " WHERE ballid=";
                    textArray17[6] = ballid;
                    textArray17[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='C' AND rq<=";
                    textArray17[8] = ((num2 - num) - 0.5).ToString();
                    textArray17[9] = ";";
                    string text26 = string.Concat(textArray17);
                    string[] textArray18 = new string[10];
                    textArray18[0] = text26;
                    textArray18[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray18[2] = num.ToString();
                    textArray18[3] = ",fen2=";
                    textArray18[4] = num2.ToString();
                    textArray18[5] = " WHERE ballid=";
                    textArray18[6] = ballid;
                    textArray18[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray18[8] = ((num2 - num) - 0.25).ToString();
                    textArray18[9] = ";";
                    string text27 = string.Concat(textArray18);
                    string[] textArray19 = new string[10];
                    textArray19[0] = text27;
                    textArray19[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray19[2] = num.ToString();
                    textArray19[3] = ",fen2=";
                    textArray19[4] = num2.ToString();
                    textArray19[5] = " WHERE ballid=";
                    textArray19[6] = ballid;
                    textArray19[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray19[8] = ((num2 - num) + 0.25).ToString();
                    textArray19[9] = ";";
                    string text28 = string.Concat(textArray19);
                    string[] textArray20 = new string[10];
                    textArray20[0] = text28;
                    textArray20[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray20[2] = num.ToString();
                    textArray20[3] = ",fen2=";
                    textArray20[4] = num2.ToString();
                    textArray20[5] = " WHERE ballid=";
                    textArray20[6] = ballid;
                    textArray20[7] = " AND tztype=8 AND tzteam='AH_C' AND rqteam='C' AND rq>=";
                    textArray20[8] = ((num2 - num) + 0.5).ToString();
                    textArray20[9] = ";";
                    text2 = string.Concat(textArray20);
                    if (((num + num2) % 2) != 0)
                    {
                        text3 = "UPDATE ball_order1 SET winpl=pl,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=8 AND tzteam='DS_S';UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=8 AND tzteam='DS_X';";
                    }
                    if (((num + num2) % 2) == 0)
                    {
                        text3 = "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=8 AND tzteam='DS_S';UPDATE ball_order1 SET winpl=pl,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=8 AND tzteam='DS_X';";
                    }
                    string[] textArray23 = new string[0x51];
                    textArray23[0] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray23[1] = num.ToString();
                    textArray23[2] = ",fen2=";
                    textArray23[3] = num2.ToString();
                    textArray23[4] = " WHERE ballid=";
                    textArray23[5] = ballid;
                    textArray23[6] = " AND tztype=8 AND tzteam='DX_D' AND (rq>=";
                    textArray23[7] = (num + num2).ToString();
                    textArray23[8] = "+0.5);UPDATE ball_order1 SET winpl=(pl-1)*0.5+1,fen1=";
                    textArray23[9] = num.ToString();
                    textArray23[10] = ",fen2=";
                    textArray23[11] = num2.ToString();
                    textArray23[12] = " WHERE ballid=";
                    textArray23[13] = ballid;
                    textArray23[14] = " AND tztype=8 AND tzteam='DX_D' AND rq=";
                    textArray23[15] = (num + num2).ToString();
                    textArray23[0x10] = "-0.25;UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray23[0x11] = num.ToString();
                    textArray23[0x12] = ",fen2=";
                    textArray23[0x13] = num2.ToString();
                    textArray23[20] = " WHERE ballid=";
                    textArray23[0x15] = ballid;
                    textArray23[0x16] = " AND tztype=8 AND tzteam='DX_D' AND rq=";
                    textArray23[0x17] = (num + num2).ToString();
                    textArray23[0x18] = "+0.25;UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray23[0x19] = num.ToString();
                    textArray23[0x1a] = ",fen2=";
                    textArray23[0x1b] = num2.ToString();
                    textArray23[0x1c] = " WHERE ballid=";
                    textArray23[0x1d] = ballid;
                    textArray23[30] = " AND tztype=8 AND tzteam='DX_D' AND rq<=";
                    textArray23[0x1f] = (num + num2).ToString();
                    textArray23[0x20] = "-0.5;UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray23[0x21] = num.ToString();
                    textArray23[0x22] = ",fen2=";
                    textArray23[0x23] = num2.ToString();
                    textArray23[0x24] = " WHERE ballid=";
                    textArray23[0x25] = ballid;
                    textArray23[0x26] = " AND tztype=8 AND tzteam='DX_D' AND rq=";
                    textArray23[0x27] = (num + num2).ToString();
                    textArray23[40] = ";UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray23[0x29] = num.ToString();
                    textArray23[0x2a] = ",fen2=";
                    textArray23[0x2b] = num2.ToString().Trim();
                    textArray23[0x2c] = " WHERE ballid=";
                    textArray23[0x2d] = ballid;
                    textArray23[0x2e] = " AND tztype=8 AND tzteam='DX_X' AND (rq<=";
                    textArray23[0x2f] = (num + num2).ToString();
                    textArray23[0x30] = "-0.5);UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray23[0x31] = num.ToString();
                    textArray23[50] = ",fen2=";
                    textArray23[0x33] = num2.ToString().Trim();
                    textArray23[0x34] = " WHERE ballid=";
                    textArray23[0x35] = ballid;
                    textArray23[0x36] = " AND tztype=8 AND tzteam='DX_X' AND rq=";
                    textArray23[0x37] = (num + num2).ToString();
                    textArray23[0x38] = "-0.25;UPDATE ball_order1 SET winpl=(pl-1)*0.5+1,fen1=";
                    textArray23[0x39] = num.ToString();
                    textArray23[0x3a] = ",fen2=";
                    textArray23[0x3b] = num2.ToString();
                    textArray23[60] = " WHERE ballid=";
                    textArray23[0x3d] = ballid;
                    textArray23[0x3e] = " AND tztype=8 AND tzteam='DX_X' AND rq=";
                    textArray23[0x3f] = (num + num2).ToString();
                    textArray23[0x40] = "+0.25;UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray23[0x41] = num.ToString();
                    textArray23[0x42] = ",fen2=";
                    textArray23[0x43] = num2.ToString();
                    textArray23[0x44] = " WHERE ballid=";
                    textArray23[0x45] = ballid;
                    textArray23[70] = " AND tztype=8 AND tzteam='DX_X' AND rq>=";
                    textArray23[0x47] = (num + num2).ToString();
                    textArray23[0x48] = "+0.5;UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray23[0x49] = num.ToString();
                    textArray23[0x4a] = ",fen2=";
                    textArray23[0x4b] = num2.ToString();
                    textArray23[0x4c] = " WHERE ballid=";
                    textArray23[0x4d] = ballid;
                    textArray23[0x4e] = " AND tztype=8 AND tzteam='DX_X' AND rq=";
                    textArray23[0x4f] = (num + num2).ToString();
                    textArray23[80] = ";";
                    base3.ExecuteNonQuery(text + text2 + text3 + string.Concat(textArray23));
                    base3.Dispose();
                }
                if (type == "16")
                {
                    string sql = "";
                    sql = "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND (tzteam<>'up5' AND rqteam<>'up5') AND (tzteam<>'" + num.ToString() + "' OR rqteam<>'" + num2.ToString() + "');UPDATE ball_order1 SET winpl=pl,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND (tzteam<>'up5' AND rqteam<>'up5') AND (tzteam='" + num.ToString() + "' AND rqteam='" + num2.ToString() + "');";
                    if ((num - num2) >= 5)
                    {
                        string text29 = sql;
                        string text30 = text29 + "UPDATE ball_order1 SET winpl=pl,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND tzteam='up5';";
                        sql = text30 + "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND rqteam='up5';";
                    }
                    else if ((num2 - num) >= 5)
                    {
                        string text31 = sql;
                        string text32 = text31 + "UPDATE ball_order1 SET winpl=pl,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND rqteam='up5';";
                        sql = text32 + "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND tzteam='up5';";
                    }
                    else
                    {
                        string text33 = sql;
                        string text34 = text33 + "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND tzteam='up5';";
                        sql = text34 + "UPDATE ball_order1 SET winpl=0,fen1=" + num.ToString() + ",fen2=" + num2.ToString() + " WHERE ballid=" + ballid + " AND tztype=16 AND rqteam='up5';";
                    }
                    base3.ExecuteNonQuery(sql);
                    base3.Dispose();
                }
                if (type == "17")
                {
                    string text6 = "";
                    string text7 = "";
                    string text35 = text6;
                    string[] textArray31 = new string[] { text35, "UPDATE ball_order1 SET winpl=1,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=17 AND tzteam='AH_H' AND rqteam='H' AND rq=", (num - num2).ToString(), ";" };
                    string text36 = string.Concat(textArray31);
                    string[] textArray32 = new string[10];
                    textArray32[0] = text36;
                    textArray32[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray32[2] = num.ToString();
                    textArray32[3] = ",fen2=";
                    textArray32[4] = num2.ToString();
                    textArray32[5] = " WHERE ballid=";
                    textArray32[6] = ballid;
                    textArray32[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='H' AND rq<=";
                    textArray32[8] = ((num - num2) - 0.5).ToString();
                    textArray32[9] = ";";
                    string text37 = string.Concat(textArray32);
                    string[] textArray33 = new string[10];
                    textArray33[0] = text37;
                    textArray33[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray33[2] = num.ToString();
                    textArray33[3] = ",fen2=";
                    textArray33[4] = num2.ToString();
                    textArray33[5] = " WHERE ballid=";
                    textArray33[6] = ballid;
                    textArray33[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='H' AND rq=";
                    textArray33[8] = ((num - num2) - 0.25).ToString();
                    textArray33[9] = ";";
                    string text38 = string.Concat(textArray33);
                    string[] textArray34 = new string[10];
                    textArray34[0] = text38;
                    textArray34[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray34[2] = num.ToString();
                    textArray34[3] = ",fen2=";
                    textArray34[4] = num2.ToString();
                    textArray34[5] = " WHERE ballid=";
                    textArray34[6] = ballid;
                    textArray34[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='H' AND rq=";
                    textArray34[8] = ((num - num2) + 0.25).ToString();
                    textArray34[9] = ";";
                    string text39 = string.Concat(textArray34);
                    string[] textArray35 = new string[10];
                    textArray35[0] = text39;
                    textArray35[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray35[2] = num.ToString();
                    textArray35[3] = ",fen2=";
                    textArray35[4] = num2.ToString();
                    textArray35[5] = " WHERE ballid=";
                    textArray35[6] = ballid;
                    textArray35[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='H' AND rq>=";
                    textArray35[8] = ((num - num2) + 0.5).ToString();
                    textArray35[9] = ";";
                    string text40 = string.Concat(textArray35);
                    string[] textArray36 = new string[10];
                    textArray36[0] = text40;
                    textArray36[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray36[2] = num.ToString();
                    textArray36[3] = ",fen2=";
                    textArray36[4] = num2.ToString();
                    textArray36[5] = " WHERE ballid=";
                    textArray36[6] = ballid;
                    textArray36[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray36[8] = (num - num2).ToString();
                    textArray36[9] = ";";
                    string text41 = string.Concat(textArray36);
                    string[] textArray37 = new string[10];
                    textArray37[0] = text41;
                    textArray37[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray37[2] = num.ToString();
                    textArray37[3] = ",fen2=";
                    textArray37[4] = num2.ToString();
                    textArray37[5] = " WHERE ballid=";
                    textArray37[6] = ballid;
                    textArray37[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='H' AND rq>=";
                    textArray37[8] = ((num - num2) + 0.5).ToString();
                    textArray37[9] = ";";
                    string text42 = string.Concat(textArray37);
                    string[] textArray38 = new string[10];
                    textArray38[0] = text42;
                    textArray38[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray38[2] = num.ToString();
                    textArray38[3] = ",fen2=";
                    textArray38[4] = num2.ToString();
                    textArray38[5] = " WHERE ballid=";
                    textArray38[6] = ballid;
                    textArray38[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray38[8] = ((num - num2) + 0.25).ToString();
                    textArray38[9] = ";";
                    string text43 = string.Concat(textArray38);
                    string[] textArray39 = new string[10];
                    textArray39[0] = text43;
                    textArray39[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray39[2] = num.ToString();
                    textArray39[3] = ",fen2=";
                    textArray39[4] = num2.ToString();
                    textArray39[5] = " WHERE ballid=";
                    textArray39[6] = ballid;
                    textArray39[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='H' AND rq=";
                    textArray39[8] = ((num - num2) - 0.25).ToString();
                    textArray39[9] = ";";
                    string text44 = string.Concat(textArray39);
                    string[] textArray40 = new string[10];
                    textArray40[0] = text44;
                    textArray40[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray40[2] = num.ToString();
                    textArray40[3] = ",fen2=";
                    textArray40[4] = num2.ToString();
                    textArray40[5] = " WHERE ballid=";
                    textArray40[6] = ballid;
                    textArray40[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='H' AND rq<=";
                    textArray40[8] = ((num - num2) - 0.5).ToString();
                    textArray40[9] = ";";
                    text6 = string.Concat(textArray40);
                    string text45 = text7;
                    string[] textArray41 = new string[10];
                    textArray41[0] = text45;
                    textArray41[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray41[2] = num.ToString();
                    textArray41[3] = ",fen2=";
                    textArray41[4] = num2.ToString();
                    textArray41[5] = " WHERE ballid=";
                    textArray41[6] = ballid;
                    textArray41[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray41[8] = (num2 - num).ToString();
                    textArray41[9] = ";";
                    string text46 = string.Concat(textArray41);
                    string[] textArray42 = new string[10];
                    textArray42[0] = text46;
                    textArray42[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray42[2] = num.ToString();
                    textArray42[3] = ",fen2=";
                    textArray42[4] = num2.ToString();
                    textArray42[5] = " WHERE ballid=";
                    textArray42[6] = ballid;
                    textArray42[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='C' AND rq>=";
                    textArray42[8] = ((num2 - num) + 0.5).ToString();
                    textArray42[9] = ";";
                    string text47 = string.Concat(textArray42);
                    string[] textArray43 = new string[10];
                    textArray43[0] = text47;
                    textArray43[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray43[2] = num.ToString();
                    textArray43[3] = ",fen2=";
                    textArray43[4] = num2.ToString();
                    textArray43[5] = " WHERE ballid=";
                    textArray43[6] = ballid;
                    textArray43[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray43[8] = ((num2 - num) + 0.25).ToString();
                    textArray43[9] = ";";
                    string text48 = string.Concat(textArray43);
                    string[] textArray44 = new string[10];
                    textArray44[0] = text48;
                    textArray44[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray44[2] = num.ToString();
                    textArray44[3] = ",fen2=";
                    textArray44[4] = num2.ToString();
                    textArray44[5] = " WHERE ballid=";
                    textArray44[6] = ballid;
                    textArray44[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='C' AND rq=";
                    textArray44[8] = ((num2 - num) - 0.25).ToString();
                    textArray44[9] = ";";
                    string text49 = string.Concat(textArray44);
                    string[] textArray45 = new string[10];
                    textArray45[0] = text49;
                    textArray45[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray45[2] = num.ToString();
                    textArray45[3] = ",fen2=";
                    textArray45[4] = num2.ToString();
                    textArray45[5] = " WHERE ballid=";
                    textArray45[6] = ballid;
                    textArray45[7] = " AND tztype=17 AND tzteam='AH_H' AND rqteam='C' AND rq<=";
                    textArray45[8] = ((num2 - num) - 0.5).ToString();
                    textArray45[9] = ";";
                    string text50 = string.Concat(textArray45);
                    string[] textArray46 = new string[10];
                    textArray46[0] = text50;
                    textArray46[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray46[2] = num.ToString();
                    textArray46[3] = ",fen2=";
                    textArray46[4] = num2.ToString();
                    textArray46[5] = " WHERE ballid=";
                    textArray46[6] = ballid;
                    textArray46[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray46[8] = (num2 - num).ToString();
                    textArray46[9] = ";";
                    string text51 = string.Concat(textArray46);
                    string[] textArray47 = new string[10];
                    textArray47[0] = text51;
                    textArray47[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray47[2] = num.ToString();
                    textArray47[3] = ",fen2=";
                    textArray47[4] = num2.ToString();
                    textArray47[5] = " WHERE ballid=";
                    textArray47[6] = ballid;
                    textArray47[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='C' AND rq<=";
                    textArray47[8] = ((num2 - num) - 0.5).ToString();
                    textArray47[9] = ";";
                    string text52 = string.Concat(textArray47);
                    string[] textArray48 = new string[10];
                    textArray48[0] = text52;
                    textArray48[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray48[2] = num.ToString();
                    textArray48[3] = ",fen2=";
                    textArray48[4] = num2.ToString();
                    textArray48[5] = " WHERE ballid=";
                    textArray48[6] = ballid;
                    textArray48[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray48[8] = ((num2 - num) - 0.25).ToString();
                    textArray48[9] = ";";
                    string text53 = string.Concat(textArray48);
                    string[] textArray49 = new string[10];
                    textArray49[0] = text53;
                    textArray49[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray49[2] = num.ToString();
                    textArray49[3] = ",fen2=";
                    textArray49[4] = num2.ToString();
                    textArray49[5] = " WHERE ballid=";
                    textArray49[6] = ballid;
                    textArray49[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='C' AND rq=";
                    textArray49[8] = ((num2 - num) + 0.25).ToString();
                    textArray49[9] = ";";
                    string text54 = string.Concat(textArray49);
                    string[] textArray50 = new string[10];
                    textArray50[0] = text54;
                    textArray50[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray50[2] = num.ToString();
                    textArray50[3] = ",fen2=";
                    textArray50[4] = num2.ToString();
                    textArray50[5] = " WHERE ballid=";
                    textArray50[6] = ballid;
                    textArray50[7] = " AND tztype=17 AND tzteam='AH_C' AND rqteam='C' AND rq>=";
                    textArray50[8] = ((num2 - num) + 0.5).ToString();
                    textArray50[9] = ";";
                    text7 = string.Concat(textArray50);
                    string[] textArray51 = new string[0x51];
                    textArray51[0] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray51[1] = num.ToString();
                    textArray51[2] = ",fen2=";
                    textArray51[3] = num2.ToString();
                    textArray51[4] = " WHERE ballid=";
                    textArray51[5] = ballid;
                    textArray51[6] = " AND tztype=17 AND tzteam='DX_D' AND (rq>=";
                    textArray51[7] = (num + num2).ToString();
                    textArray51[8] = "+0.5);UPDATE ball_order1 SET winpl=(pl-1)*0.5+1,fen1=";
                    textArray51[9] = num.ToString();
                    textArray51[10] = ",fen2=";
                    textArray51[11] = num2.ToString();
                    textArray51[12] = " WHERE ballid=";
                    textArray51[13] = ballid;
                    textArray51[14] = " AND tztype=17 AND tzteam='DX_D' AND rq=";
                    textArray51[15] = (num + num2).ToString();
                    textArray51[0x10] = "-0.25;UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray51[0x11] = num.ToString();
                    textArray51[0x12] = ",fen2=";
                    textArray51[0x13] = num2.ToString();
                    textArray51[20] = " WHERE ballid=";
                    textArray51[0x15] = ballid;
                    textArray51[0x16] = " AND tztype=17 AND tzteam='DX_D' AND rq=";
                    textArray51[0x17] = (num + num2).ToString();
                    textArray51[0x18] = "+0.25;UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray51[0x19] = num.ToString();
                    textArray51[0x1a] = ",fen2=";
                    textArray51[0x1b] = num2.ToString();
                    textArray51[0x1c] = " WHERE ballid=";
                    textArray51[0x1d] = ballid;
                    textArray51[30] = " AND tztype=17 AND tzteam='DX_D' AND rq<=";
                    textArray51[0x1f] = (num + num2).ToString();
                    textArray51[0x20] = "-0.5;UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray51[0x21] = num.ToString();
                    textArray51[0x22] = ",fen2=";
                    textArray51[0x23] = num2.ToString();
                    textArray51[0x24] = " WHERE ballid=";
                    textArray51[0x25] = ballid;
                    textArray51[0x26] = " AND tztype=17 AND tzteam='DX_D' AND rq=";
                    textArray51[0x27] = (num + num2).ToString();
                    textArray51[40] = ";UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray51[0x29] = num.ToString();
                    textArray51[0x2a] = ",fen2=";
                    textArray51[0x2b] = num2.ToString().Trim();
                    textArray51[0x2c] = " WHERE ballid=";
                    textArray51[0x2d] = ballid;
                    textArray51[0x2e] = " AND tztype=17 AND tzteam='DX_X' AND ( rq<=";
                    textArray51[0x2f] = (num + num2).ToString();
                    textArray51[0x30] = "-0.5);UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray51[0x31] = num.ToString();
                    textArray51[50] = ",fen2=";
                    textArray51[0x33] = num2.ToString().Trim();
                    textArray51[0x34] = " WHERE ballid=";
                    textArray51[0x35] = ballid;
                    textArray51[0x36] = " AND tztype=17 AND tzteam='DX_X' AND rq=";
                    textArray51[0x37] = (num + num2).ToString();
                    textArray51[0x38] = "-0.25;UPDATE ball_order1 SET winpl=(pl-1)*0.5+1,fen1=";
                    textArray51[0x39] = num.ToString();
                    textArray51[0x3a] = ",fen2=";
                    textArray51[0x3b] = num2.ToString();
                    textArray51[60] = " WHERE ballid=";
                    textArray51[0x3d] = ballid;
                    textArray51[0x3e] = " AND tztype=17 AND tzteam='DX_X' AND rq=";
                    textArray51[0x3f] = (num + num2).ToString();
                    textArray51[0x40] = "+0.25;UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray51[0x41] = num.ToString();
                    textArray51[0x42] = ",fen2=";
                    textArray51[0x43] = num2.ToString();
                    textArray51[0x44] = " WHERE ballid=";
                    textArray51[0x45] = ballid;
                    textArray51[70] = " AND tztype=17 AND tzteam='DX_X' AND rq>=";
                    textArray51[0x47] = (num + num2).ToString();
                    textArray51[0x48] = "+0.5;UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray51[0x49] = num.ToString();
                    textArray51[0x4a] = ",fen2=";
                    textArray51[0x4b] = num2.ToString();
                    textArray51[0x4c] = " WHERE ballid=";
                    textArray51[0x4d] = ballid;
                    textArray51[0x4e] = " AND tztype=17 AND tzteam='DX_X' AND rq=";
                    textArray51[0x4f] = (num + num2).ToString();
                    textArray51[80] = ";";
                    base3.ExecuteNonQuery(text6 + text7 + string.Concat(textArray51));
                    base3.Dispose();
                }
            }
        }
    }
}

