namespace mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;
    using System.Web.UI;

    public class basketjsdeal : Page
    {
        public int cancelcount = 0;
        public string kyglContent = "";
        public int zdcount = 0;

        private void AddCount(string iscancel)
        {
            if (iscancel == "1")
            {
                this.cancelcount++;
            }
            else
            {
                this.zdcount++;
            }
        }

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
            if (type == "21")
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
            reader.Close();
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private void JsDs(string ballid, string type)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (type == "24")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 1));
            }
            if (type == "27")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 2));
            }
            string[] textArray = this.UpdateBallMsg(ballid, base2);
            if (textArray != null)
            {
                int num = 0;
                int num2 = 0;
                string iscancel = "0";
                if (type == "24")
                {
                    if (textArray[15] == "1")
                    {
                        iscancel = "1";
                    }
                    if (textArray[9].IndexOf(":") <= 0)
                    {
                        base2.Dispose();
                        return;
                    }
                    num = int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                    num2 = int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                }
                else if (type == "27")
                {
                    if ((textArray[15] != "1") && (textArray[0x12] != "1"))
                    {
                        if ((textArray[10].IndexOf(":") <= 0) || (textArray[9].IndexOf(":") <= 0))
                        {
                            base2.Dispose();
                            return;
                        }
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]) - int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]) - int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        iscancel = "1";
                    }
                }
                else
                {
                    if (textArray[10].IndexOf(":") > 0)
                    {
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                    if ((textArray[15] == "1") || (textArray[0x12] == "1"))
                    {
                        iscancel = "1";
                    }
                }
                string sql = "SELECT * FROM ball_order WHERE ballid=" + ballid + " AND tztype=" + type + " AND iscancel=0";
                SqlDataReader reader = base2.ExecuteReader(sql);
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                while (reader.Read())
                {
                    double num3 = 0;
                    double num4 = 0;
                    double num5 = 1;
                    double num6 = num + num2;
                    string text3 = reader["ds"].ToString().Trim();
                    double num7 = double.Parse(reader["curpl"].ToString().Trim());
                    double num8 = double.Parse(reader["tzmoney"].ToString().Trim());
                    double num9 = double.Parse(reader["hsuser_w"].ToString().Trim());
                    double num10 = double.Parse(reader["hsuser_l"].ToString().Trim());
                    double num11 = double.Parse(reader["hsdls_w"].ToString().Trim());
                    double num12 = double.Parse(reader["hsdls_l"].ToString().Trim());
                    double num13 = double.Parse(reader["hszdl_w"].ToString().Trim());
                    double num14 = double.Parse(reader["hszdl_l"].ToString().Trim());
                    double num15 = double.Parse(reader["hsgd_w"].ToString().Trim());
                    double num16 = double.Parse(reader["hsgd_l"].ToString().Trim());
                    double num17 = 0;
                    double num18 = 0;
                    double num19 = 0;
                    if (iscancel != "1")
                    {
                        switch (text3)
                        {
                            case "1":
                                if ((num6 % 2) != 0)
                                {
                                    num3 = num7 * num8;
                                }
                                else
                                {
                                    num4 = num8;
                                }
                                break;

                            case "2":
                                if ((num6 % 2) == 0)
                                {
                                    num3 = num7 * num8;
                                }
                                else
                                {
                                    num4 = num8;
                                }
                                break;
                        }
                        if (num3 > 0)
                        {
                            num17 = num3 + (((num8 * num11) / 100) * num5);
                            num18 = num3 + (((num8 * num13) / 100) * num5);
                            num19 = num3 + (((num8 * num15) / 100) * num5);
                            num3 += ((num8 * num9) / 100) * num5;
                        }
                        if (num4 > 0)
                        {
                            num17 = -num4 + (((num8 * num12) / 100) * num5);
                            num18 = -num4 + (((num8 * num14) / 100) * num5);
                            num19 = -num4 + (((num8 * num16) / 100) * num5);
                            num4 -= ((num8 * num10) / 100) * num5;
                        }
                        if ((num3 == 0) && (num4 == 0))
                        {
                            num5 = 0;
                        }
                    }
                    else
                    {
                        num3 = 0;
                        num4 = 0;
                        num5 = 0;
                        num17 = 0;
                        num18 = 0;
                        num19 = 0;
                    }
                    base3.ExecuteNonQuery(string.Concat(new object[] { "UPDATE ball_order SET win=", num3.ToString(), ",lose=", num4.ToString(), ",isjs=1,truewin=", num5.ToString(), ",iscancel=", iscancel, ",mdls=", num17.ToString(), ",mzdl=", num18, ",mgd=", num19.ToString(), " WHERE orderid=", reader["orderid"].ToString().Trim() }));
                    this.AddCount(iscancel);
                }
                reader.Close();
                base2.Dispose();
                base3.Dispose();
            }
        }

        private void JsDx(string ballid, string type)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (type == "23")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 1));
            }
            if (type == "26")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 2));
            }
            string[] textArray = this.UpdateBallMsg(ballid, base2);
            if (textArray != null)
            {
                int num = 0;
                int num2 = 0;
                string iscancel = "0";
                if (type == "19")
                {
                    if ((textArray[15] == "1") || (textArray[0x12] == "1"))
                    {
                        iscancel = "1";
                    }
                    if (textArray[10].IndexOf(":") > 0)
                    {
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                if (type == "23")
                {
                    if (textArray[15] == "1")
                    {
                        iscancel = "1";
                    }
                    if (textArray[9].IndexOf(":") > 0)
                    {
                        num = int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                if (type == "26")
                {
                    if ((textArray[15] == "1") || (textArray[0x12] == "1"))
                    {
                        iscancel = "1";
                    }
                    else if ((textArray[10].IndexOf(":") > 0) && (textArray[9].IndexOf(":") > 0))
                    {
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]) - int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]) - int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                string sql = "SELECT * FROM ball_order WHERE ballid=" + ballid + " AND tztype=" + type + " AND iscancel=0";
                SqlDataReader reader = base2.ExecuteReader(sql);
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                while (reader.Read())
                {
                    double num3 = 0;
                    double num4 = 0;
                    double num5 = 1;
                    double num6 = 0;
                    double num7 = double.Parse(reader["dxc"].ToString().Trim());
                    double num8 = double.Parse(reader["curpl"].ToString().Trim());
                    double num9 = double.Parse(reader["tzmoney"].ToString().Trim());
                    double num10 = double.Parse(reader["hsuser_w"].ToString().Trim());
                    double num11 = double.Parse(reader["hsuser_l"].ToString().Trim());
                    double num12 = double.Parse(reader["hsdls_w"].ToString().Trim());
                    double num13 = double.Parse(reader["hsdls_l"].ToString().Trim());
                    double num14 = double.Parse(reader["hszdl_w"].ToString().Trim());
                    double num15 = double.Parse(reader["hszdl_l"].ToString().Trim());
                    double num16 = double.Parse(reader["hsgd_w"].ToString().Trim());
                    double num17 = double.Parse(reader["hsgd_l"].ToString().Trim());
                    double num18 = 0;
                    double num19 = 0;
                    double num20 = 0;
                    if (iscancel != "1")
                    {
                        num6 = (num + num2) - Math.Abs(num7);
                        if (num7 > 0)
                        {
                            if (num6 == 0)
                            {
                                num3 = 0;
                                num4 = 0;
                            }
                            if (num6 >= 0.5)
                            {
                                num3 = num8 * num9;
                            }
                            if (num6 == 0.25)
                            {
                                num3 = (num8 * num9) / 2;
                                num5 = 0.5;
                            }
                            if (num6 == -0.25)
                            {
                                num4 = num9 / 2;
                                num5 = 0.5;
                            }
                            if (num6 <= -0.5)
                            {
                                num4 = num9;
                            }
                        }
                        else
                        {
                            if (num6 == 0)
                            {
                                num3 = 0;
                                num4 = 0;
                            }
                            if (num6 >= 0.5)
                            {
                                num4 = num9;
                            }
                            if (num6 == 0.25)
                            {
                                num4 = num9 / 2;
                                num5 = 0.5;
                            }
                            if (num6 == -0.25)
                            {
                                num3 = (num8 * num9) / 2;
                                num5 = 0.5;
                            }
                            if (num6 <= -0.5)
                            {
                                num3 = num8 * num9;
                            }
                        }
                        if (num3 > 0)
                        {
                            num18 = num3 + (((num9 * num12) / 100) * num5);
                            num19 = num3 + (((num9 * num14) / 100) * num5);
                            num20 = num3 + (((num9 * num16) / 100) * num5);
                            num3 += ((num9 * num10) / 100) * num5;
                        }
                        if (num4 > 0)
                        {
                            num18 = -num4 + (((num9 * num13) / 100) * num5);
                            num19 = -num4 + (((num9 * num15) / 100) * num5);
                            num20 = -num4 + (((num9 * num17) / 100) * num5);
                            num4 -= ((num9 * num11) / 100) * num5;
                        }
                        if ((num3 == 0) && (num4 == 0))
                        {
                            num5 = 0;
                        }
                    }
                    else
                    {
                        num3 = 0;
                        num4 = 0;
                        num5 = 0;
                        num18 = 0;
                        num19 = 0;
                        num20 = 0;
                    }
                    base3.ExecuteNonQuery("UPDATE ball_order SET win=" + num3.ToString() + ",lose=" + num4.ToString() + ",isjs=1,truewin=" + num5.ToString() + ",iscancel=" + iscancel + ",mdls=" + num18.ToString() + ",mzdl=" + num19.ToString() + ",mgd=" + num20.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
                    this.AddCount(iscancel);
                }
                reader.Close();
                base2.Dispose();
                base3.Dispose();
            }
        }

        private void Jsgg(string type, string td)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM ball_order WHERE tztype=" + type + " AND datediff(day,updatetime,'" + td + "')=0");
            while (reader.Read())
            {
                bool isfinish = true;
                double num = this.JsggPl(reader["orderid"].ToString().Trim(), out isfinish);
                double num2 = 0;
                double num3 = 0;
                double num4 = double.Parse(reader["tzmoney"].ToString().Trim());
                double num5 = double.Parse(reader["hsuser_w"].ToString().Trim());
                double num6 = double.Parse(reader["hsuser_l"].ToString().Trim());
                double num7 = double.Parse(reader["hsdls_w"].ToString().Trim());
                double num8 = double.Parse(reader["hsdls_l"].ToString().Trim());
                double num9 = double.Parse(reader["hszdl_w"].ToString().Trim());
                double num10 = double.Parse(reader["hszdl_l"].ToString().Trim());
                double num11 = double.Parse(reader["hsgd_w"].ToString().Trim());
                double num12 = double.Parse(reader["hsgd_l"].ToString().Trim());
                double num13 = 0;
                double num14 = 0;
                double num15 = 1;
                double num16 = 0;
                if (num > 0)
                {
                    if ((num - 1) > 0)
                    {
                        num2 = num4 * (num - 1);
                        num3 = 0;
                        num13 = num2 + (((num4 * num7) / 100) * num15);
                        num14 = num2 + (((num4 * num9) / 100) * num15);
                        num16 = num2 + (((num4 * num11) / 100) * num15);
                        num2 += ((num4 * num5) / 100) * num15;
                    }
                    else if ((num - 1) == 0)
                    {
                        num2 = 0;
                        num3 = 0;
                        num13 = 0;
                        num14 = 0;
                    }
                    else
                    {
                        num2 = 0;
                        num3 = Math.Abs((double) (num4 * (num - 1)));
                        num13 = -num3 + (((num4 * num8) / 100) * num15);
                        num14 = -num3 + (((num4 * num10) / 100) * num15);
                        num16 = -num3 + (((num4 * num12) / 100) * num15);
                        num3 -= ((num4 * num6) / 100) * num15;
                    }
                }
                else if (num == 0)
                {
                    num2 = 0;
                    num3 = num4 - (((num4 * num6) / 100) * num15);
                    num13 = -num4 + (((num4 * num8) / 100) * num15);
                    num14 = -num4 + (((num4 * num10) / 100) * num15);
                    num16 = -num4 + (((num4 * num12) / 100) * num15);
                }
                if (isfinish)
                {
                    base3.ExecuteNonQuery("UPDATE ball_order SET win=" + num2.ToString() + ",lose=" + num3.ToString() + ",isjs=1,truewin=" + num15.ToString() + ",iscancel=0,mdls=" + num13.ToString() + ",mzdl=" + num14.ToString() + ",mgd=" + num16.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
                    this.AddCount("0");
                }
            }
            reader.Close();
            base2.Dispose();
            base3.Dispose();
        }

        private void JsGG(string type, string td)
        {
            this.gg1(type, td);
            this.Jsgg(type, td);
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

        private void JsRq(string ballid, string type)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (type == "22")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 1));
            }
            if (type == "25")
            {
                ballid = Convert.ToString((long) (long.Parse(ballid) + 2));
            }
            string[] textArray = this.UpdateBallMsg(ballid, base2);
            if (textArray != null)
            {
                int num = 0;
                int num2 = 0;
                string iscancel = "0";
                if (type == "18")
                {
                    if ((textArray[15] == "1") || (textArray[0x12] == "1"))
                    {
                        iscancel = "1";
                    }
                    else if (textArray[10].IndexOf(":") > 0)
                    {
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                if (type == "22")
                {
                    if (textArray[15] == "1")
                    {
                        iscancel = "1";
                    }
                    else if (textArray[9].IndexOf(":") > 0)
                    {
                        num = int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                if (type == "25")
                {
                    if ((textArray[15] == "1") || (textArray[0x12] == "1"))
                    {
                        iscancel = "1";
                    }
                    else if ((textArray[10].IndexOf(":") > 0) && (textArray[9].IndexOf(":") > 0))
                    {
                        num = int.Parse(textArray[10].Split(new char[] { ':' })[0]) - int.Parse(textArray[9].Split(new char[] { ':' })[0]);
                        num2 = int.Parse(textArray[10].Split(new char[] { ':' })[1]) - int.Parse(textArray[9].Split(new char[] { ':' })[1]);
                    }
                    else
                    {
                        base2.Dispose();
                        return;
                    }
                }
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                string sql = "SELECT * FROM ball_order WHERE ballid=" + ballid + " AND tztype=" + type + " AND iscancel=0";
                SqlDataReader reader = base2.ExecuteReader(sql);
                while (reader.Read())
                {
                    string text3 = reader["rqteam"].ToString().Trim();
                    double num3 = 0;
                    double num4 = 0;
                    double num5 = 1;
                    double num6 = 0;
                    double num7 = double.Parse(reader["rqc"].ToString().Trim());
                    double num8 = double.Parse(reader["curpl"].ToString().Trim());
                    double num9 = double.Parse(reader["tzmoney"].ToString().Trim());
                    double num10 = double.Parse(reader["hsuser_w"].ToString().Trim());
                    double num11 = double.Parse(reader["hsuser_l"].ToString().Trim());
                    double num12 = double.Parse(reader["hsdls_w"].ToString().Trim());
                    double num13 = double.Parse(reader["hsdls_l"].ToString().Trim());
                    double num14 = double.Parse(reader["hszdl_w"].ToString().Trim());
                    double num15 = double.Parse(reader["hszdl_l"].ToString().Trim());
                    double num16 = double.Parse(reader["hsgd_w"].ToString().Trim());
                    double num17 = double.Parse(reader["hsgd_l"].ToString().Trim());
                    double num18 = 0;
                    double num19 = 0;
                    double num20 = 0;
                    if (iscancel != "1")
                    {
                        if (reader["tzteam"].ToString().Trim().ToUpper() == "H")
                        {
                            if (reader["rqteam"].ToString().Trim().ToUpper() == "H")
                            {
                                num6 = (num - num2) - num7;
                            }
                            else
                            {
                                num6 = (num - num2) + num7;
                            }
                        }
                        else if (reader["rqteam"].ToString().Trim().ToUpper() == "H")
                        {
                            num6 = (num2 - num) + num7;
                        }
                        else
                        {
                            num6 = (num2 - num) - num7;
                        }
                        if (num6 == 0)
                        {
                            num3 = 0;
                            num4 = 0;
                        }
                        if (num6 >= 0.5)
                        {
                            num3 = num8 * num9;
                        }
                        if (num6 == 0.25)
                        {
                            num3 = (num8 * num9) / 2;
                            num5 = 0.5;
                        }
                        if (num6 == -0.25)
                        {
                            num4 = num9 / 2;
                            num5 = 0.5;
                        }
                        if (num6 <= -0.5)
                        {
                            num4 = num9;
                        }
                        if (num3 > 0)
                        {
                            num18 = num3 + (((num9 * num12) / 100) * num5);
                            num19 = num3 + (((num9 * num14) / 100) * num5);
                            num20 = num3 + (((num9 * num16) / 100) * num5);
                            num3 += ((num9 * num10) / 100) * num5;
                        }
                        if (num4 > 0)
                        {
                            num18 = -num4 + (((num9 * num13) / 100) * num5);
                            num19 = -num4 + (((num9 * num15) / 100) * num5);
                            num20 = -num4 + (((num9 * num17) / 100) * num5);
                            num4 -= ((num9 * num11) / 100) * num5;
                        }
                        if ((num3 == 0) && (num4 == 0))
                        {
                            num5 = 0;
                        }
                    }
                    else
                    {
                        num3 = 0;
                        num4 = 0;
                        num5 = 0;
                        num18 = 0;
                        num19 = 0;
                        num20 = 0;
                    }
                    base3.ExecuteNonQuery("UPDATE ball_order SET win=" + num3.ToString() + ",lose=" + num4.ToString() + ",isjs=1,truewin=" + num5.ToString() + ",iscancel=" + iscancel + ",mdls=" + num18.ToString() + ",mzdl=" + num19.ToString() + ",mgd=" + num20.ToString() + " WHERE orderid=" + reader["orderid"].ToString().Trim());
                    this.AddCount(iscancel);
                }
                reader.Close();
                base2.Dispose();
                base3.Dispose();
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if ((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "kygl")) && ((base.Request.Form["ballid"] != null) && (base.Request.Form["ballid"].ToString().Trim() != ""))) && ((base.Request.Form["jstype"] != null) && (base.Request.Form["jstype"].ToString().Trim() != "")))
            {
                string ballid = base.Request.Form["ballid"].ToString().Trim();
                if (ballid != "0")
                {
                    switch (base.Request.Form["jstype"].ToString().Trim())
                    {
                        case "ah_ht":
                            this.JsRq(ballid, "18");
                            this.kyglContent = "parent.document.all['ah_ht'].innerHTML = '让球订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('dx');";
                            goto Label_06A5;

                        case "dx":
                            this.JsDx(ballid, "19");
                            this.kyglContent = "parent.document.all['dx'].innerHTML = '大小订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('ds');";
                            goto Label_06A5;

                        case "ds":
                            this.JsDs(ballid, "20");
                            this.kyglContent = "parent.document.all['ds'].innerHTML = '单双订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('uah');";
                            goto Label_06A5;

                        case "uah":
                            this.JsRq(ballid, "22");
                            this.kyglContent = "parent.document.all['uah'].innerHTML = '上半场让球订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('udx');";
                            goto Label_06A5;

                        case "udx":
                            this.JsDx(ballid, "23");
                            this.kyglContent = "parent.document.all['udx'].innerHTML = '上半场大小订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('uds');";
                            goto Label_06A5;

                        case "uds":
                            this.JsDs(ballid, "24");
                            this.kyglContent = "parent.document.all['uds'].innerHTML = '上半场单双订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('dah');";
                            goto Label_06A5;

                        case "dah":
                            this.JsRq(ballid, "25");
                            this.kyglContent = "parent.document.all['dah'].innerHTML = '下半场让球订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('ddx');";
                            goto Label_06A5;

                        case "ddx":
                            this.JsDx(ballid, "26");
                            this.kyglContent = "parent.document.all['ddx'].innerHTML = '下半场大小订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';showcontent('dds');";
                            goto Label_06A5;

                        case "dds":
                            this.JsDs(ballid, "27");
                            this.kyglContent = "parent.document.all['dds'].innerHTML = '下半场单双订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('球赛" + ballid + "订单结算完成');parent.location.href='basketjslist.aspx';";
                            goto Label_06A5;
                    }
                    MyFunc.showmsg("请正确选择要结算的项目");
                    base.Response.End();
                }
                else
                {
                    string str;
                    string td = base.Request.Form["basketthisdate"].ToString().Trim();
                    if (((str = base.Request.Form["jstype"].ToString().Trim()) != null) && (string.IsInterned(str) == "21"))
                    {
                        this.JsGG("21", td);
                        this.kyglContent = "parent.document.all['ah_ht'].innerHTML = '让球过关订单结算完成.有效:" + this.zdcount.ToString() + "  无效:" + this.cancelcount.ToString() + "';alert('让球过关订单结算完成');parent.location.href='basketjslist.aspx';";
                        goto Label_06A5;
                    }
                    MyFunc.showmsg("请正确选择要结算的项目");
                    base.Response.End();
                }
            }
            return;
        Label_06A5:
            this.DataBind();
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
            else
            {
                textArray = null;
            }
            reader.Close();
            base2.Dispose();
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
                if (type == "21")
                {
                    string text = "";
                    string text2 = "";
                    string text3 = text;
                    string[] textArray = new string[] { text3, "UPDATE ball_order1 SET winpl=1,fen1=", num.ToString(), ",fen2=", num2.ToString(), " WHERE ballid=", ballid, " AND tztype=21 AND tzteam='1' AND rqteam='H' AND rq=", (num - num2).ToString(), ";" };
                    string text4 = string.Concat(textArray);
                    string[] textArray2 = new string[10];
                    textArray2[0] = text4;
                    textArray2[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray2[2] = num.ToString();
                    textArray2[3] = ",fen2=";
                    textArray2[4] = num2.ToString();
                    textArray2[5] = " WHERE ballid=";
                    textArray2[6] = ballid;
                    textArray2[7] = " AND tztype=21 AND tzteam='1' AND rqteam='H' AND rq<=";
                    textArray2[8] = ((num - num2) - 0.5).ToString();
                    textArray2[9] = ";";
                    string text5 = string.Concat(textArray2);
                    string[] textArray3 = new string[10];
                    textArray3[0] = text5;
                    textArray3[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray3[2] = num.ToString();
                    textArray3[3] = ",fen2=";
                    textArray3[4] = num2.ToString();
                    textArray3[5] = " WHERE ballid=";
                    textArray3[6] = ballid;
                    textArray3[7] = " AND tztype=21 AND tzteam='1' AND rqteam='H' AND rq=";
                    textArray3[8] = ((num - num2) - 0.25).ToString();
                    textArray3[9] = ";";
                    string text6 = string.Concat(textArray3);
                    string[] textArray4 = new string[10];
                    textArray4[0] = text6;
                    textArray4[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray4[2] = num.ToString();
                    textArray4[3] = ",fen2=";
                    textArray4[4] = num2.ToString();
                    textArray4[5] = " WHERE ballid=";
                    textArray4[6] = ballid;
                    textArray4[7] = " AND tztype=21 AND tzteam='1' AND rqteam='H' AND rq=";
                    textArray4[8] = ((num - num2) + 0.25).ToString();
                    textArray4[9] = ";";
                    string text7 = string.Concat(textArray4);
                    string[] textArray5 = new string[10];
                    textArray5[0] = text7;
                    textArray5[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray5[2] = num.ToString();
                    textArray5[3] = ",fen2=";
                    textArray5[4] = num2.ToString();
                    textArray5[5] = " WHERE ballid=";
                    textArray5[6] = ballid;
                    textArray5[7] = " AND tztype=21 AND tzteam='1' AND rqteam='H' AND rq>=";
                    textArray5[8] = ((num - num2) + 0.5).ToString();
                    textArray5[9] = ";";
                    string text8 = string.Concat(textArray5);
                    string[] textArray6 = new string[10];
                    textArray6[0] = text8;
                    textArray6[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray6[2] = num.ToString();
                    textArray6[3] = ",fen2=";
                    textArray6[4] = num2.ToString();
                    textArray6[5] = " WHERE ballid=";
                    textArray6[6] = ballid;
                    textArray6[7] = " AND tztype=21 AND tzteam='2' AND rqteam='H' AND rq=";
                    textArray6[8] = (num - num2).ToString();
                    textArray6[9] = ";";
                    string text9 = string.Concat(textArray6);
                    string[] textArray7 = new string[10];
                    textArray7[0] = text9;
                    textArray7[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray7[2] = num.ToString();
                    textArray7[3] = ",fen2=";
                    textArray7[4] = num2.ToString();
                    textArray7[5] = " WHERE ballid=";
                    textArray7[6] = ballid;
                    textArray7[7] = " AND tztype=21 AND tzteam='2' AND rqteam='H' AND rq>=";
                    textArray7[8] = ((num - num2) + 0.5).ToString();
                    textArray7[9] = ";";
                    string text10 = string.Concat(textArray7);
                    string[] textArray8 = new string[10];
                    textArray8[0] = text10;
                    textArray8[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray8[2] = num.ToString();
                    textArray8[3] = ",fen2=";
                    textArray8[4] = num2.ToString();
                    textArray8[5] = " WHERE ballid=";
                    textArray8[6] = ballid;
                    textArray8[7] = " AND tztype=21 AND tzteam='2' AND rqteam='H' AND rq=";
                    textArray8[8] = ((num - num2) + 0.25).ToString();
                    textArray8[9] = ";";
                    string text11 = string.Concat(textArray8);
                    string[] textArray9 = new string[10];
                    textArray9[0] = text11;
                    textArray9[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray9[2] = num.ToString();
                    textArray9[3] = ",fen2=";
                    textArray9[4] = num2.ToString();
                    textArray9[5] = " WHERE ballid=";
                    textArray9[6] = ballid;
                    textArray9[7] = " AND tztype=21 AND tzteam='2' AND rqteam='H' AND rq=";
                    textArray9[8] = ((num - num2) - 0.25).ToString();
                    textArray9[9] = ";";
                    string text12 = string.Concat(textArray9);
                    string[] textArray10 = new string[10];
                    textArray10[0] = text12;
                    textArray10[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray10[2] = num.ToString();
                    textArray10[3] = ",fen2=";
                    textArray10[4] = num2.ToString();
                    textArray10[5] = " WHERE ballid=";
                    textArray10[6] = ballid;
                    textArray10[7] = " AND tztype=21 AND tzteam='2' AND rqteam='H' AND rq<=";
                    textArray10[8] = ((num - num2) - 0.5).ToString();
                    textArray10[9] = ";";
                    text = string.Concat(textArray10);
                    string text13 = text2;
                    string[] textArray11 = new string[10];
                    textArray11[0] = text13;
                    textArray11[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray11[2] = num.ToString();
                    textArray11[3] = ",fen2=";
                    textArray11[4] = num2.ToString();
                    textArray11[5] = " WHERE ballid=";
                    textArray11[6] = ballid;
                    textArray11[7] = " AND tztype=21 AND tzteam='1' AND rqteam='C' AND rq=";
                    textArray11[8] = (num2 - num).ToString();
                    textArray11[9] = ";";
                    string text14 = string.Concat(textArray11);
                    string[] textArray12 = new string[10];
                    textArray12[0] = text14;
                    textArray12[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray12[2] = num.ToString();
                    textArray12[3] = ",fen2=";
                    textArray12[4] = num2.ToString();
                    textArray12[5] = " WHERE ballid=";
                    textArray12[6] = ballid;
                    textArray12[7] = " AND tztype=21 AND tzteam='1' AND rqteam='C' AND rq>=";
                    textArray12[8] = ((num2 - num) + 0.5).ToString();
                    textArray12[9] = ";";
                    string text15 = string.Concat(textArray12);
                    string[] textArray13 = new string[10];
                    textArray13[0] = text15;
                    textArray13[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray13[2] = num.ToString();
                    textArray13[3] = ",fen2=";
                    textArray13[4] = num2.ToString();
                    textArray13[5] = " WHERE ballid=";
                    textArray13[6] = ballid;
                    textArray13[7] = " AND tztype=21 AND tzteam='1' AND rqteam='C' AND rq=";
                    textArray13[8] = ((num2 - num) + 0.25).ToString();
                    textArray13[9] = ";";
                    string text16 = string.Concat(textArray13);
                    string[] textArray14 = new string[10];
                    textArray14[0] = text16;
                    textArray14[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray14[2] = num.ToString();
                    textArray14[3] = ",fen2=";
                    textArray14[4] = num2.ToString();
                    textArray14[5] = " WHERE ballid=";
                    textArray14[6] = ballid;
                    textArray14[7] = " AND tztype=21 AND tzteam='1' AND rqteam='C' AND rq=";
                    textArray14[8] = ((num2 - num) - 0.25).ToString();
                    textArray14[9] = ";";
                    string text17 = string.Concat(textArray14);
                    string[] textArray15 = new string[10];
                    textArray15[0] = text17;
                    textArray15[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray15[2] = num.ToString();
                    textArray15[3] = ",fen2=";
                    textArray15[4] = num2.ToString();
                    textArray15[5] = " WHERE ballid=";
                    textArray15[6] = ballid;
                    textArray15[7] = " AND tztype=21 AND tzteam='1' AND rqteam='C' AND rq<=";
                    textArray15[8] = ((num2 - num) - 0.5).ToString();
                    textArray15[9] = ";";
                    string text18 = string.Concat(textArray15);
                    string[] textArray16 = new string[10];
                    textArray16[0] = text18;
                    textArray16[1] = "UPDATE ball_order1 SET winpl=1,fen1=";
                    textArray16[2] = num.ToString();
                    textArray16[3] = ",fen2=";
                    textArray16[4] = num2.ToString();
                    textArray16[5] = " WHERE ballid=";
                    textArray16[6] = ballid;
                    textArray16[7] = " AND tztype=21 AND tzteam='2' AND rqteam='C' AND rq=";
                    textArray16[8] = (num2 - num).ToString();
                    textArray16[9] = ";";
                    string text19 = string.Concat(textArray16);
                    string[] textArray17 = new string[10];
                    textArray17[0] = text19;
                    textArray17[1] = "UPDATE ball_order1 SET winpl=pl,fen1=";
                    textArray17[2] = num.ToString();
                    textArray17[3] = ",fen2=";
                    textArray17[4] = num2.ToString();
                    textArray17[5] = " WHERE ballid=";
                    textArray17[6] = ballid;
                    textArray17[7] = " AND tztype=21 AND tzteam='2' AND rqteam='C' AND rq<=";
                    textArray17[8] = ((num2 - num) - 0.5).ToString();
                    textArray17[9] = ";";
                    string text20 = string.Concat(textArray17);
                    string[] textArray18 = new string[10];
                    textArray18[0] = text20;
                    textArray18[1] = "UPDATE ball_order1 SET winpl=(pl-1)/2+1,fen1=";
                    textArray18[2] = num.ToString();
                    textArray18[3] = ",fen2=";
                    textArray18[4] = num2.ToString();
                    textArray18[5] = " WHERE ballid=";
                    textArray18[6] = ballid;
                    textArray18[7] = " AND tztype=21 AND tzteam='2' AND rqteam='C' AND rq=";
                    textArray18[8] = ((num2 - num) - 0.25).ToString();
                    textArray18[9] = ";";
                    string text21 = string.Concat(textArray18);
                    string[] textArray19 = new string[10];
                    textArray19[0] = text21;
                    textArray19[1] = "UPDATE ball_order1 SET winpl=0.5,fen1=";
                    textArray19[2] = num.ToString();
                    textArray19[3] = ",fen2=";
                    textArray19[4] = num2.ToString();
                    textArray19[5] = " WHERE ballid=";
                    textArray19[6] = ballid;
                    textArray19[7] = " AND tztype=21 AND tzteam='2' AND rqteam='C' AND rq=";
                    textArray19[8] = ((num2 - num) + 0.25).ToString();
                    textArray19[9] = ";";
                    string text22 = string.Concat(textArray19);
                    string[] textArray20 = new string[10];
                    textArray20[0] = text22;
                    textArray20[1] = "UPDATE ball_order1 SET winpl=0,fen1=";
                    textArray20[2] = num.ToString();
                    textArray20[3] = ",fen2=";
                    textArray20[4] = num2.ToString();
                    textArray20[5] = " WHERE ballid=";
                    textArray20[6] = ballid;
                    textArray20[7] = " AND tztype=21 AND tzteam='2' AND rqteam='C' AND rq>=";
                    textArray20[8] = ((num2 - num) + 0.5).ToString();
                    textArray20[9] = ";";
                    base3.ExecuteNonQuery(text + string.Concat(textArray20));
                    base3.Dispose();
                }
            }
        }
    }
}

