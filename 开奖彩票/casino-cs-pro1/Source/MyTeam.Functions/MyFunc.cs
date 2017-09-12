namespace MyTeam.Functions
{
    using MyTeam.DbClass;
    using System;
    using System.Configuration;
    using System.Data.SqlClient;
    using System.Globalization;
    using System.Text;
    using System.Web;
    using System.Web.Security;

    public class MyFunc
    {
        private static string Color = "1,2,12,13,,23,24,34,35,45,46,07,08,18,19,29,30,40^5,6,16,17,27,28,38,39,49,11,21,22,32,33,43,44^3,4,14,15,25,26,36,37,47,48,09,10,20,31,41,42";
        private static string MYURL = "192.168.0.200,localhost,ball.7948.com,aoe768.com,www.3starbc.com,3starbc.com,3stara.com,www.3stara.com,888.ac577.com,ac599.com,www.ac599.com,ac588.com,www.ac588.com,www.ac577.com,ac577.com,1000a.net,www.1000a.net";
        public static string twelveName = "鼠,牛,虎,兔,龙,蛇,马,羊,猴,鸡,狗,猪";
        private static string twelveNum = ConfigurationSettings.AppSettings["twelveNum"];
        public static string twelveNumUI = ("'" + ConfigurationSettings.AppSettings["twelveNum"].Replace("^", "','") + "'");

        public static string AllBallid(string tzType)
        {
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM pl WHERE tztype='" + tzType + "'");
            string text = "";
            while (reader.Read())
            {
                text = text + reader["id"].ToString().Trim() + ",";
            }
            text = text.Substring(0, text.Length - 1);
            reader.Close();
            base2.Dispose();
            return text;
        }

        public static string AllBallid(int start, int end)
        {
            string text = "";
            for (int i = start; i <= end; i++)
            {
                text = text + i.ToString() + ",";
            }
            return text.Substring(0, text.Length - 1);
        }

        public static bool CheckUserLogin(byte utype)
        {
            bool flag = false;
            if (utype == 0)
            {
                if ((((HttpContext.Current.Session.Contents["userid"] != null) && (HttpContext.Current.Session.Contents["username"] != null)) && ((HttpContext.Current.Session.Contents["userpass"] != null) && (HttpContext.Current.Session.Contents["sessid"] != null))) && (HttpContext.Current.Session.Contents["classid"] != null))
                {
                    if (((HttpContext.Current.Session.Contents["username"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["userpass"].ToString().Trim() == "")) || ((HttpContext.Current.Session.Contents["sessid"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["classid"].ToString().Trim() == "")))
                    {
                        flag = false;
                    }
                    else
                    {
                        flag = true;
                    }
                }
                else
                {
                    flag = false;
                }
            }
            if (utype == 1)
            {
                if ((((HttpContext.Current.Session.Contents["adminuserid"] != null) && (HttpContext.Current.Session.Contents["adminusername"] != null)) && ((HttpContext.Current.Session.Contents["adminuserpass"] != null) && (HttpContext.Current.Session.Contents["adminsessid"] != null))) && (HttpContext.Current.Session.Contents["adminclassid"] != null))
                {
                    if (((HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["adminusername"].ToString().Trim() == "")) || (((HttpContext.Current.Session.Contents["adminuserpass"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["adminsessid"].ToString().Trim() == "")) || (HttpContext.Current.Session.Contents["adminclassid"].ToString().Trim() == "")))
                    {
                        flag = false;
                    }
                    else
                    {
                        flag = true;
                    }
                }
                else
                {
                    flag = false;
                }
            }
            if (utype != 2)
            {
                return flag;
            }
            if ((((HttpContext.Current.Session.Contents["adminuserid"] != null) && (HttpContext.Current.Session.Contents["adminsubclassid"] != null)) && ((HttpContext.Current.Session.Contents["adminsubname"] != null) && (HttpContext.Current.Session.Contents["adminsubid"] != null))) && (HttpContext.Current.Session.Contents["adminsubpass"] != null))
            {
                if (((HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["adminsubclassid"].ToString().Trim() == "")) || (((HttpContext.Current.Session.Contents["adminsubname"].ToString().Trim() == "") || (HttpContext.Current.Session.Contents["adminsubid"].ToString().Trim() == "")) || (HttpContext.Current.Session.Contents["adminsubpass"].ToString().Trim() == "")))
                {
                    return false;
                }
                return true;
            }
            return false;
        }

        public static bool CheckUserLogin(string name, string pass, string classid, byte deep)
        {
            if (((name == "") || (pass == "")) || (classid == ""))
            {
                return false;
            }
            bool flag = false;
            DataBase base2 = new DataBase(GetConnStr(2));
            string sql = "";
            if (deep == 0)
            {
                sql = "SELECT username,userpass,classid FROM member WHERE username='" + name + "' AND isuseable=1";
            }
            if (deep == 1)
            {
                sql = "SELECT username,userpass,classid FROM agence WHERE username='" + name + "' AND isuseable=1";
            }
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (!reader.Read())
            {
                flag = false;
            }
            else if (((reader["username"].ToString().ToLower().Trim() != name.ToLower()) || (reader["userpass"].ToString().Trim() != pass)) || (reader["classid"].ToString().Trim() != classid))
            {
                flag = false;
            }
            else
            {
                flag = true;
            }
            reader.Close();
            return flag;
        }

        public static string ChgIP(string str)
        {
            string[] textArray = str.Trim().Split(new char[] { '.' });
            long num = long.Parse(textArray[0]);
            long num2 = long.Parse(textArray[1]);
            long num3 = long.Parse(textArray[2]);
            long num4 = long.Parse(textArray[3]);
            long num5 = (((((num * 0x100) * 0x100) * 0x100) + ((num2 * 0x100) * 0x100)) + (num3 * 0x100)) + num4;
            return num5.ToString();
        }

        public static string Chinese(double num)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            string[] textArray = new string[] { "仟", "佰", "拾", "亿", "仟", "佰", "拾", "万", "仟", "佰", "拾", "元", "点", "角", "分" };
            string[] textArray2 = new string[] { "零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖" };
            if (num < 0)
            {
                num *= -1;
                text = "负";
            }
            int index = num.ToString().IndexOf(".");
            if (index < 0)
            {
                index = num.ToString().Length;
            }
            int num4 = (textArray.Length - index) - 3;
            for (int i = 0; i < num.ToString().Length; i++)
            {
                if (i != index)
                {
                    string text4 = textArray[i + num4];
                    if (num.ToString().Substring(i, 1) != "0")
                    {
                        text2 = text2 + textArray2[Convert.ToInt32(num.ToString().Substring(i, 1))] + text4;
                    }
                    else
                    {
                        text3 = text2.Substring(text2.Length - 1);
                        switch (text4)
                        {
                            case "亿":
                            case "万":
                            case "元":
                            case "分":
                                if (text3 == "零")
                                {
                                    text2 = text2.Substring(0, text2.Length - 1);
                                }
                                text3 = text2.Substring(text2.Length - 1);
                                if (((text4 != "万") || (text3 != "亿")) && ((text4 != "分") || (text3 != "角")))
                                {
                                    text2 = text2 + text4;
                                }
                                break;

                            default:
                                if (text3 != "零")
                                {
                                    text2 = text2 + "零";
                                }
                                break;
                        }
                    }
                }
            }
            return (text + text2);
        }

        public static string ConvertStr(string inputString)
        {
            return inputString.Trim().Replace("&", "&amp;").Replace("\"", "&quot;").Replace("'", "").Replace("<", "&lt;").Replace(">", "&gt;").Replace(" ", "&nbsp;").Replace("  ", "&nbsp;&nbsp;").Replace("\t", "&nbsp;&nbsp;").Replace("\r", "").Replace("\n", "&nbsp;");
        }

        public static string DateTimeToTime(string dtime)
        {
            return DateTime.Parse(dtime).ToShortTimeString();
        }

        public static string DayToWeek(DateTime dtime)
        {
            switch (dtime.DayOfWeek.ToString().ToLower())
            {
                case "sunday":
                    return "星期日";

                case "monday":
                    return "星期一";

                case "tuesday":
                    return "星期二";

                case "wednesday":
                    return "星期三";

                case "thursday":
                    return "星期四";

                case "friday":
                    return "星期五";

                case "saturday":
                    return "星期六";
            }
            return "";
        }

        public static string DefaultValue(string str, string val)
        {
            if ((str != null) && (str.Trim() != ""))
            {
                return str.ToString();
            }
            return val;
        }

        public static bool FindStr(string source, string substr)
        {
            return (source.IndexOf(substr, 0, source.Length) > -1);
        }

        public static string FormatMyStr(string str)
        {
            string[] textArray = str.Split(new char[] { ',' });
            string text = "";
            for (int i = 0; i < textArray.Length; i++)
            {
                text = text + "'" + textArray[i] + "',";
            }
            if (text != "")
            {
                text = text.Remove(text.Length - 1, 1);
            }
            return text;
        }

        public static string GetConnStr(byte num)
        {
            switch (num)
            {
                case 1:
                    return ConfigurationSettings.AppSettings["MyConn1"];

                case 2:
                    return ConfigurationSettings.AppSettings["MyConn2"];

                case 3:
                    return ConfigurationSettings.AppSettings["MyConn3"];
            }
            return "";
        }

        public static string GetGongSiID()
        {
            return ConfigurationSettings.AppSettings["GongSiID"];
        }

        public static string GetMaxPayOut()
        {
            return ConfigurationSettings.AppSettings["MaxPayOut"].ToString().Trim();
        }

        private static string getMethodMenu(string strMethod)
        {
            StringBuilder builder = new StringBuilder();
            if (strMethod == "d")
            {
                builder.Append("&nbsp;<font style=background-color=#0099FF><a href=football_d.aspx?method=d target=body_show>特别号</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;<a href=football_d.aspx?method=d target=body_show>特别号</A>&nbsp;");
            }
            if (strMethod == "g")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_g.aspx?method=g target=body_show>生肖色波一肖</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_g.aspx?method=g target=body_show>生肖色波一肖</A>&nbsp;");
            }
            if (strMethod == "rqsbc")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_rqsbc.aspx?method=rqsbc target=body_show>正码</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_rqsbc.aspx?method=rqsbc target=body_show>正码</A>&nbsp;");
            }
            if (strMethod == "other")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_other.aspx?method=other target=body_show>正码1-6</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_other.aspx?method=other target=body_show>正码1-6</A>&nbsp;");
            }
            if (strMethod == "bqc")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_bqc.aspx?method=bqc target=body_show>连码</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_bqc.aspx?method=bqc target=body_show>连码</A>&nbsp;");
            }
            if (strMethod == "bd")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_bd.aspx?method=bd target=body_show>正码过关</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_bd.aspx?method=bd target=body_show>正码过关</A>&nbsp;");
            }
            if (strMethod == "bz")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_bz.aspx?method=bz target=body_show>六肖</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_bz.aspx?method=bz target=body_show>六肖</A>&nbsp;");
            }
            if (strMethod == "sbgg")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_sbgg.aspx?method=sbgg target=body_show>半波</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_sbgg.aspx?method=sbgg target=body_show>半波</A>&nbsp;");
            }
            if (strMethod == "ys")
            {
                builder.Append("&nbsp;--<font style=background-color=#0099FF><a href=football_ys.aspx?method=ys target=body_show>已开奖</a></font>&nbsp;");
            }
            else
            {
                builder.Append("&nbsp;--<a href=football_ys.aspx?method=ys target=body_show>已开奖</A>&nbsp;");
            }
            return builder.ToString();
        }

        private static string GetPath(string strMethod)
        {
            switch (strMethod)
            {
                case "d":
                    return "football_d.aspx";

                case "g":
                    return "football_g.aspx";

                case "rqsbc":
                    return "football_rqsbc.aspx";

                case "other":
                    return "football_other.aspx";

                case "bqc":
                    return "football_bqc.aspx";

                case "bd":
                    return "football_bd.aspx";

                case "bz":
                    return "football_bz.aspx";

                case "rqgg":
                    return "football_rqgg.aspx";

                case "ys":
                    return "football_ys.aspx";

                case "sbgg":
                    return "football_sbgg.aspx";

                case "bdgg":
                    return "football_bdgg.aspx";
            }
            return "";
        }

        public static string GetPlace(DataBase db, string str)
        {
            SqlDataReader reader = db.ExecuteReader("SELECT (country+' '+city) AS place FROM ipdata WHERE ip1<=" + str + " AND ip2>=" + str);
            string text = "";
            if (reader.Read())
            {
                text = reader["place"].ToString().Trim();
            }
            reader.Close();
            return text;
        }

        public static double GetPlType(string pl, string type)
        {
            double num = 0;
            try
            {
                num = double.Parse(pl);
            }
            catch
            {
                return 0;
            }
            if (num == 0)
            {
                return 0;
            }
            switch (type.ToUpper())
            {
                case "A":
                    return (num + double.Parse(ConfigurationSettings.AppSettings["UserPlA"].ToString().Trim()));

                case "B":
                    return (num + double.Parse(ConfigurationSettings.AppSettings["UserPlB"].ToString().Trim()));

                case "C":
                    return (num + double.Parse(ConfigurationSettings.AppSettings["UserPlC"].ToString().Trim()));

                case "D":
                    return (num + double.Parse(ConfigurationSettings.AppSettings["UserPlD"].ToString().Trim()));
            }
            return (num + 0);
        }

        public static double GetPlType(string pl, string type, string uppl, string whichteam, string fixpl)
        {
            double num = 0;
            double num2 = 0;
            double num3 = 0;
            try
            {
                num = double.Parse(pl);
                num2 = double.Parse(uppl);
                num3 = double.Parse(fixpl);
            }
            catch
            {
                return 0;
            }
            if ((whichteam.ToUpper() == "H") || (whichteam == "1"))
            {
                num -= num2;
            }
            else
            {
                num += num2;
            }
            if (num != 0)
            {
                return (num + double.Parse(type));
            }
            return 0;
        }

        public static string GetRGB(int num)
        {
            switch (num)
            {
                case 1:
                case 2:
                case 7:
                case 8:
                case 12:
                case 13:
                case 0x12:
                case 0x13:
                case 0x17:
                case 0x18:
                case 0x1d:
                case 30:
                case 0x22:
                case 0x23:
                case 40:
                case 0x2d:
                case 0x2e:
                    return "red";

                case 3:
                case 4:
                case 9:
                case 10:
                case 14:
                case 15:
                case 20:
                case 0x19:
                case 0x1a:
                case 0x1f:
                case 0x24:
                case 0x25:
                case 0x29:
                case 0x2a:
                case 0x2f:
                case 0x30:
                    return "blue";
            }
            return "green";
        }

        public static string GetRGB(string num)
        {
            switch (num)
            {
                case "01":
                case "02":
                case "12":
                case "13":
                case "23":
                case "24":
                case "34":
                case "35":
                case "45":
                case "46":
                case "07":
                case "08":
                case "18":
                case "19":
                case "29":
                case "30":
                case "40":
                    return "images/ball/r.gif";

                case "03":
                case "04":
                case "14":
                case "15":
                case "25":
                case "26":
                case "36":
                case "37":
                case "47":
                case "48":
                case "09":
                case "10":
                case "20":
                case "31":
                case "41":
                case "42":
                    return "images/ball/b.gif";

                case "":
                    return "";
            }
            return "images/ball/g.gif";
        }

        public static int GetRGB(string[] re, int j)
        {
            string[] textArray = Color.Split(new char[] { '^' });
            int num = 0;
            for (int i = 0; i < 7; i++)
            {
                if (textArray[j].IndexOf(re[i]) != -1)
                {
                    num++;
                }
            }
            return num;
        }

        private static string getSelectABC(string ltype, string strMethod)
        {
            string text = "&nbsp; 线上操盘:<select id='ltype' name='ltype' onChange='document.forms[0].submit()'>";
            if (ltype == "A")
            {
                text = text + "<option value='A' selected>六合彩A</option>";
            }
            else
            {
                text = text + "<option value='A'>六合彩A</option>";
            }
            if (ltype == "B")
            {
                text = text + "<option value='B' selected>六合彩B</option>";
            }
            else
            {
                text = text + "<option value='B'>六合彩B</option>";
            }
            if ((ltype == "C") || (ltype == ""))
            {
                text = text + "<option value='C' selected>六合彩C</option>";
            }
            else
            {
                text = text + "<option value='C'>六合彩C</option>";
            }
            if (ltype == "D")
            {
                text = text + "<option value='D' selected>六合彩D</option>";
            }
            else
            {
                text = text + "<option value='D'>六合彩D</option>";
            }
            return (text + "</select>");
        }

        private static string getSelectRetime(string retime)
        {
            string text = "<select id='retime' name='retime' onChange='document.forms[0].submit()'> ";
            if (retime == "-1")
            {
                text = text + "<option value='-1' selected>不更新</option>";
            }
            else
            {
                text = text + "<option value='-1'>不更新</option>";
            }
            if (retime == "180")
            {
                text = text + "<option value='180' selected>180秒</option>";
            }
            else
            {
                text = text + "<option value='180'>180秒</option>";
            }
            if (retime == "60")
            {
                text = text + "<option value='60' selected>60秒</option>";
            }
            else
            {
                text = text + "<option value='60'>60秒</option>";
            }
            if (retime == "30")
            {
                text = text + "<option value='30' selected>30秒</option>";
            }
            else
            {
                text = text + "<option value='30'>30秒</option>";
            }
            return (text + "</select>");
        }

        private static string GetSelectZD()
        {
            return "";
        }

        private static string GetStaticCS()
        {
            string text = "成数:<select id='staticCS' name='staticCS' onChange='document.forms[0].submit();'>";
            if ((HttpContext.Current.Session["sessionSelectStaticCS"] != null) && (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部"))
            {
                text = text + "<option value='全部' selected>全部</option>";
            }
            else
            {
                text = text + "<option value='全部'>全部</option>";
            }
            if ((HttpContext.Current.Session["sessionSelectStaticCS"] != null) && (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "自己成数"))
            {
                text = text + "<option value='自己成数' selected>自己成数</option>";
            }
            else
            {
                text = text + "<option value='自己成数'>自己成数</option>";
            }
            return (text + "</select>");
        }

        public static string GetSubServerNum()
        {
            return ConfigurationSettings.AppSettings["SubServerNum"].ToString().Trim();
        }

        public static string GettwelveId(string tztype)
        {
            string[] textArray = twelveNum.Split(new char[] { '^' });
            for (int i = 0; i < 12; i++)
            {
                if (textArray[i].IndexOf(tztype) != -1)
                {
                    return i.ToString();
                }
            }
            return "";
        }

        public static int GettwelveId(string[] tztype, int j)
        {
            string[] textArray = twelveNum.Split(new char[] { '^' });
            int num = 0;
            for (int i = 0; i < 7; i++)
            {
                if (textArray[j].IndexOf(tztype[i]) != -1)
                {
                    num++;
                }
            }
            return num;
        }

        public static string GettwelveName(string tzType)
        {
            return twelveName.Split(new char[] { ',' })[int.Parse(tzType)];
        }

        public static string GettwelveNum(string tzType)
        {
            return twelveNum.Split(new char[] { '^' })[int.Parse(tzType)];
        }

        public static string GettzId(string id, string tzType)
        {
            if (tzType == "SP")
            {
                int num = int.Parse(id) + 0x22;
                return num.ToString();
            }
            int num2 = int.Parse(id) + 0x53;
            return num2.ToString();
        }

        public static string GettzType(int tzType)
        {
            DataBase base2 = new DataBase(GetConnStr(1));
            SqlDataReader reader = base2.ExecuteReader("SELECT * FROM pl WHERE id=" + tzType);
            string text = "";
            if (reader.Read())
            {
                text = reader["tztype"].ToString().Trim();
            }
            else
            {
                text = "ALL";
            }
            reader.Close();
            base2.Dispose();
            return text;
        }

        public static string GettzType(string tzType)
        {
            if (tzType.ToUpper() != "ALL")
            {
                return tzType;
            }
            if (tzType.ToUpper() == "ALL")
            {
                return AllBallid(1, 300);
            }
            return "9999";
        }

        public static string GettzTypeName(string tzType)
        {
            switch (tzType.ToUpper())
            {
                case "8":
                    return "特别号";

                case "1":
                    return "特别号:单双";

                case "2":
                    return "特别号:大小";

                case "3":
                    return "特别号:合数单双";

                case "17":
                    return "色波";

                case "9":
                    return "正码";

                case "4":
                    return "总和:单双";

                case "5":
                    return "总和:大小";

                case "6":
                    return "正码1-6:单双";

                case "7":
                    return "正码1-6:大小";

                case "10":
                    return "正码1-6:色波";

                case "11":
                    return "三全中";

                case "12":
                    return "三中二";

                case "13":
                    return "二全中";

                case "14":
                    return "二中特";

                case "15":
                    return "特串";

                case "16":
                    return "正码过关";

                case "18":
                    return "生肖";

                case "19":
                    return "一肖";

                case "20":
                    return "六肖";

                case "21":
                    return "半波";

                case "22":
                    return "特码补牌";

                case "ALL":
                    return "全部";
            }
            return "";
        }

        public static void goToLoginPage()
        {
            HttpContext.Current.Session.Abandon();
            HttpContext.Current.Response.Write("<script>top.location.href='index.htm';</script>");
            HttpContext.Current.Response.End();
        }

        public static void goToLoginPage(string root)
        {
            HttpContext.Current.Session.Abandon();
            HttpContext.Current.Response.Write("<script>top.location.href='" + root + "';</script>");
            HttpContext.Current.Response.End();
        }

        public static string GuodanContent(string usertype, string startTime, string endTime, string pathStr, DataBase db)
        {
            string text = "";
            int num = 0;
            double num2 = 0;
            double num5 = 0;
            string sql = "SELECT sum(userid)/count(*) as userid,sum(csdls)/count(*) as csdls,username,count(*) as tzNumber,sum(tzmoney) as tzmoney,sum(win-lose) as result FROM ball_order2 WHERE dlsid = '" + HttpContext.Current.Session.Contents["adminuserid"].ToString() + "' and datediff(s,'" + startTime + "',balltime) > 0 and datediff(d,balltime,'" + endTime + "') >= 0 and tzType='8' group by username";
            SqlDataReader reader = db.ExecuteReader(sql);
            text = "<table border=0 cellspacing=1 cellpadding=0 class=tableNoBorder1 width=100%>\n";
            text = text + "<tr class=dlsreport><td width=10%>" + usertype + "</td><td width=10%>笔数</td><td width=10%>投注金额</td><td width=10%>结果</td></tr>\n";
            while (reader.Read())
            {
                string text4 = ((text + "<tr bgcolor=white align=right height=22>") + "<td align=center>" + reader["username"].ToString() + "</td>") + "<td>" + reader["tzNumber"].ToString() + "</td>";
                text = ((text4 + "<td><a href='../zdl/reportshowguodan.aspx?search=credit" + pathStr + "&username=" + reader["username"].ToString() + "'><font color=blue>" + NumBerFormat(reader["tzmoney"].ToString()) + "</font></a></td>") + "<td>" + NumBerFormat(reader["result"].ToString()) + "</td>") + "</tr>\n";
                num += int.Parse(reader["tzNumber"].ToString());
                num2 += double.Parse(reader["tzmoney"].ToString());
                num5 += double.Parse(reader["result"].ToString());
            }
            reader.Close();
            return (((((text + "<tr class=reportTotalnum align=right height=22><td class=reportTotalchar>总 数</td>") + "<td>" + num.ToString() + "</td>") + "<td>" + NumBerFormat(num2.ToString()) + "</td>") + "<td>" + NumBerFormat(num5.ToString()) + "</td>") + "</tr>" + "</table>");
        }

        public static void isRefUrl()
        {
            if (((MYURL != "") && (HttpContext.Current.Request.UrlReferrer != null)) && (HttpContext.Current.Request.UrlReferrer.ToString() != ""))
            {
                bool flag = false;
                string text = HttpContext.Current.Request.UrlReferrer.ToString().ToUpper().Replace("HTTP://", "");
                text = text.Remove(text.IndexOf("/"), text.Length - text.IndexOf("/"));
                if (MYURL.IndexOf(",") != -1)
                {
                    string[] textArray = MYURL.Split(new char[] { ',' });
                    for (int i = 0; i < textArray.Length; i++)
                    {
                        if (textArray[i].ToUpper().Trim() == text)
                        {
                            flag = true;
                            break;
                        }
                    }
                }
                else if (MYURL.ToUpper().Trim() == text)
                {
                    flag = true;
                }
                if (!flag)
                {
                    goToLoginPage();
                }
            }
            if ((ConfigurationSettings.AppSettings["WebSite"].ToString() != "//") && ((HttpContext.Current.Request.UrlReferrer == null) || !FindStr(HttpContext.Current.Request.UrlReferrer.ToString(), ConfigurationSettings.AppSettings["WebSite"].ToString())))
            {
                goToLoginPage();
            }
        }

        public static void JumpPage(string msg, string url)
        {
            string s = "<script>";
            s = ((s + "alert('" + msg + "');") + "self.location.href='" + url + "'") + "</script>";
            HttpContext.Current.Response.Write(s);
            HttpContext.Current.Response.End();
        }

        public static string MD5(string str)
        {
            return FormsAuthentication.HashPasswordForStoringInConfigFile(str, "MD5");
        }

        public static string MulitPager(int totalRecord, int perPage, int curPage, string url)
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
                text = "<a href='" + url + "&page=1'><font face=webdings>9</font></a>&nbsp;";
                for (int i = num4; i <= num5; i++)
                {
                    if (i != curPage)
                    {
                        string text4 = text;
                        text = text4 + "<a href='" + url + "&page=" + i.ToString() + "'>" + i.ToString() + "</a>&nbsp;";
                    }
                    else
                    {
                        text = text + "<font color=red><u><b>" + i.ToString() + "</b></u></font>&nbsp;";
                    }
                }
                text = text + ((num2 > num) ? ("... <a href='" + url + "&page=" + num2.ToString() + "'>" + num2.ToString() + "&gt;&gt;</a>") : ("<a href='" + url + "&page=" + num2.ToString() + "'><font face=webdings>:</font></a>"));
            }
            if (num2 < 1)
            {
                num2++;
            }
            return (("共&nbsp;" + num2.ToString() + "&nbsp;页 每页&nbsp;" + perPage.ToString() + "&nbsp;个 共&nbsp;" + totalRecord.ToString() + "&nbsp;个记录") + "&nbsp;&nbsp;" + text);
        }

        public static string NumBerFormat(string str)
        {
            if (str == "")
            {
                return "0.00";
            }
            NumberFormatInfo provider = new CultureInfo("en-US", false).NumberFormat;
            return Convert.ToDouble(str).ToString("N", provider);
        }

        public static string NumBerFormat(string str, bool bl)
        {
            NumberFormatInfo provider = new CultureInfo("en-US", false).NumberFormat;
            string text = Convert.ToDouble(str).ToString("N", provider);
            return text.Remove(text.IndexOf("."), text.Length - text.IndexOf("."));
        }

        public static string pintingAgenceGdMenu(string ltype, string retime, string strMethod)
        {
            string text3 = (("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN' > \n<html>\n<head>\n<meta name='GENERATOR' Content='Microsoft Visual Studio .NET 7.1'>\n<meta name='CODE_LANGUAGE' Content='C#'>\n<meta name=vs_defaultClientScript content='JavaScript'>\n<meta name=vs_targetSchema content='http://schemas.microsoft.com/intellisense/ie5'>\n" + "<meta http-equiv=refresh content='" + retime + "'>\n<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>\n<link href='css/css.css' rel='stylesheet' type='text/css'>\n<link rel=stylesheet href=css/control_main.css type=text/css>\n") + "</head>\n<body topmargin=1 leftmargin=0>\n<form name=topMenu id=topMenu method=post runat=server><table width='1000' border='0' cellspacing='0' cellpadding='0'>\n<tr>") + "<td>\n<table border='0' cellspacing='0' cellpadding='0' >\n<tr><td>" + getSelectABC(ltype, strMethod) + "</td>";
            return ((text3 + "<td> - 刷新:" + getSelectRetime(retime) + "</td><td id='dt_now'> - " + GetStaticCS() + "&nbsp;-</td>") + "<td class='tableBorder2'>" + getMethodMenu(strMethod) + "</td></tr></table></td></tr>\n</table>\n");
        }

        public static string pintingAgenceMenu(string ltype, string retime, string strMethod)
        {
            string text3 = (("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN' > \n<html>\n<head>\n<meta name='GENERATOR' Content='Microsoft Visual Studio .NET 7.1'>\n<meta name='CODE_LANGUAGE' Content='C#'>\n<meta name=vs_defaultClientScript content='JavaScript'>\n<meta name=vs_targetSchema content='http://schemas.microsoft.com/intellisense/ie5'>\n" + "<meta http-equiv=refresh content='" + retime + "'>\n<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>\n<link href='css/css.css' rel='stylesheet' type='text/css'>\n<link rel=stylesheet href=css/control_main.css type=text/css>\n") + "</head>\n<body topmargin=0 leftmargin=0 onload='javascript://closeit()'>\n<form name=topMenu id=topMenu method=post runat=server><table width='990' border='0' cellspacing='0' cellpadding='0'>\n<tr>") + "<td class='m_tline'>\n<table border='0' cellspacing='0' cellpadding='0' >\n<tr><td>" + getSelectABC(ltype, strMethod) + "</td> ";
            return ((text3 + "<td>- 刷新:" + getSelectRetime(retime) + "</td><td id='dt_now'> - " + GetStaticCS() + "</td>") + "<td class='tableBorder2'>" + getMethodMenu(strMethod) + "</td></tr></table></td>\n<td width=30><img src='images/top_04.gif' width='30' height='24'></td></tr>\n</table>\n");
        }

        public static string printHeaderToolBar(string op)
        {
            string text = "";
            switch (op)
            {
                case "0":
                    return "<td align=center><p class=title_01> <A href='football_d.aspx' target=body_show>六合彩 </A></p></td><td align=center><p class=title_01> <A href='../zdl/football_guodan.aspx' target=body_show>过单</A></p></td><td align=center><p class=title_01>  <A href=gdlist.aspx target=body_show>股东</A></p></td><td align=center><p class=title_01> <A href='zdllist.aspx' target=body_show>总代理</A></p></td><td align=center><p class=title_01> <A href='dlslist.aspx' target=body_show>代理商</A></p></td><td align=center><p class=title_01> <A href='userlist.aspx' target=body_show>会员</A></p></td><td align=center><p class=title_01> <A href='addsubuser.aspx' target=body_show>子帐号</A></p></td><td align=center><p class=title_01> <A href='report.aspx' target=body_show>报表</A></p></td><td align=center><p class=title_01> <A href=searchorder.aspx target=body_show>订单查询</A></p></td><td align=center><p class=title_01> <a href='changeleave.aspx' target=body_show>调水</A></p></td><td align=center><p class=title_01> <A href=chgpwd.aspx target=body_show>变更密码</A></p></td><td align=center><p class=title_01> <a href=mysetting.aspx target=body_show>我的设定</A></p></td><td align=center><p class=title_01> <A href=MgrOnline.aspx target=body_show>在线</A></p></td><td>";

                case "1":
                    return "<td align=center><p class=title_01> <A href='football_d.aspx' target=body_show>六合彩 </A></p></td><td align=center><p class=title_01> <A href=gslist.aspx target=body_show>公司</A></p></td><td align=center><p class=title_01> <A href=gdlist.aspx target=body_show>股东</A></p></td><td align=center><p class=title_01> <A href='zdllist.aspx' target=body_show>总代理</A></p></td><td align=center><p class=title_01> <A href='dlslist.aspx' target=body_show>代理商</A></p></td><td align=center><p class=title_01> <A href='userlist.aspx' target=body_show>会员</A></p></td><td align=center><p class=title_01> <A href='addsubuser.aspx' target=body_show>子帐户</A></p></td><td align=center><p class=title_01> <a href='report.aspx' target=body_show>报表</A></p></td><td align=center><p class=title_01> <A href='GameFen.aspx' target=body_show>结算</A></p></td><td align=center><p class=title_01><A href=searchorder.aspx target=body_show>订单查询</A></p></td><td align=center><p class=title_01> <A href=gj/chgLists.aspx target=body_show>工具</A></p></td><td align=center><p class=title_01> <A href=../odds/subadmin/mgrConfiglist.aspx target=body_show>公告</A></p></td><td align=center><p class=title_01> <A href=chgpwd.aspx target=body_show>修改密码</A></p></td><td align=center><p class=title_01> <A href=MgrOnline.aspx target=body_show>在线</A></p></td>";

                case "2":
                    text = "<td align=center><p class=title_01> <A href='football_d.aspx' target=body_show>六合彩 </A></p></td><td align=center><p class=title_01> <A href='../zdl/football_guodan.aspx' target=body_show>过单</A></p></td><td align=center><p class=title_01> <A href=chgpwd.aspx target=body_show>变更密码</A></p></td><td align=center><p class=title_01><A href='addsubuser.aspx' target=body_show>子帐号</A></p></td><td align=center><p class=title_01> <A href='zdllist.aspx' target=body_show>总代理</A> </p></td><td align=center><p class=title_01><A href='dlslist.aspx' target=body_show>代理商</A></p></td>";
                    return (text + "<td align=center><p class=title_01> <A href='userlist.aspx' target=body_show>会员</A></p></td><td align=center><p class=title_01> <A href='report.aspx' target=body_show>报表</A></p></td><td align=center><p class=title_01><A href='../dls/bets-enquiry.aspx' target=body_show>过单状况</A></p></td><td align=center><p class=title_01><A href='../dls/history.aspx' target=body_show>过单历史</A></p></td><td align=center><p class=title_01> <a href=mysetting.aspx target=body_show>我的设定</A></p></td>");

                case "3":
                    text = "<td align=center><p class=title_01><A href='football_d.aspx' target=body_show>六合彩 </A></p></td><td align=center><p class=title_01> <A href=chgpwd.aspx target=body_show>变更密码</A></p></td><td align=center><p class=title_01> <A href='AddSubUser.aspx' target=body_show>子帐号</A> </p></td><td align=center><p class=title_01><A href='dlslist.aspx' target=body_show>代理商</A></p></td><td align=center><p class=title_01> <A href='userlist.aspx' target=body_show>会员</A> </p></td>";
                    return (text + "<td align=center><p class=title_01><A href='report.aspx' target=body_show>报表</A></p></td><td align=center><p class=title_01><A href='../dls/bets-enquiry.aspx' target=body_show>过单状况</A></p></td><td align=center><p class=title_01><A href='../dls/history.aspx' target=body_show>过单历史</A></p></td><td align=center><p class=title_01> <a href=mysetting.aspx target=body_show>我的设定</A></p></td>");

                case "4":
                    text = "<td><div align=\"center\"><p class=\"title_01\"><a href='football_d.aspx' target=body_show>六合彩 </A></p></td><td align=center><p class=title_01><a href=chgpwd.aspx target=body_show>更改密码</A></p></td><td align=center><p class=title_01><a href=addsubuser.aspx target=body_show>子帐号</A></p></td><td align=center><p class=title_01><a href=mgruser.aspx target=body_show>会员</A></p></td><td align=center><p class=title_01><a href=report.aspx target=body_show>报表</A></p></td>";
                    return (text + "<td align=center><p class=title_01><a href=system800.aspx target=body_show>800系统</A></p></td><td align=center><p class=title_01><a href=mysetting.aspx target=body_show>我的设定</A></p></td>");

                case "5":
                    return " <A href='../odds/BallList.aspx' target=body_show>六合彩 </A> <A href='GameFen.aspx' target=body_show>结算</A> <A href='MatchOrder.aspx' target=body_show>结算状况</A> <A href=searchorder.aspx target=body_show>订单查询</A> <A href=mgrConfiglist.aspx target=body_show>公告</A> <A href=chgpwd.aspx target=body_show>修改密码</A>";

                case "10":
                    return " <a href=chgpwd.aspx target=body_show>更改密码</a> <a href='../gs/report.aspx' target=body_show>报表</a>";

                case "11":
                    return " <a href=chgpwd.aspx target=body_show>更改密码</a> <a href='../mem/report.aspx' target=body_show>报表</a>";

                case "22":
                    return " <a href=chgpwd.aspx target=body_show>更改密码</a> <a href='../gd/report.aspx' target=body_show>报表</a>";

                case "33":
                    return " <a href=chgpwd.aspx target=body_show>更改密码</a> <a href='../zdl/report.aspx' target=body_show>报表</a>";

                case "44":
                    return " <a href=chgpwd.aspx target=body_show>更改密码</a> <a href='../dls/report.aspx' target=body_show>报表</a>";
            }
            return "";
        }

        public static void showmsg(string msg)
        {
            HttpContext.Current.Response.Write("<script>alert('" + msg + "');history.back();</script>");
            HttpContext.Current.Response.End();
        }

        public static bool SubServerIsShow(string serverlist)
        {
            if (serverlist != "")
            {
                string text = ConfigurationSettings.AppSettings["SubServerNum"].ToString().Trim();
                string[] textArray = serverlist.Split(new char[] { ',' });
                for (int i = 0; i < textArray.Length; i++)
                {
                    if (textArray[i] == text)
                    {
                        return true;
                    }
                }
            }
            else
            {
                return true;
            }
            return false;
        }

        public static string SumStatic(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                if (tzType == "9")
                {
                    if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                    else
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csdls),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                }
                else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney*od.csdls),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (((tzType == "6") || (tzType == "5")) || ((tzType == "10") || (tzType == "11")))
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csdls),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "1")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csdls),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "2")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csdls),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csdls),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND dlsid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        public static string SumStaticAdmin(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                if (tzType == "9")
                {
                    if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "'";
                    }
                    else
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "'";
                    }
                }
                else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "'";
                }
                else
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney*(1-od.csdls-od.cszdl-od.csgd)),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "'";
                }
            }
            else if (((tzType == "6") || (tzType == "5")) || ((tzType == "10") || (tzType == "11")))
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "'";
                }
            }
            else if (tzType == "1")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "'";
                }
            }
            else if (tzType == "2")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "'";
                }
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "'";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "'";
            }
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        public static string SumStaticGd(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                if (tzType == "9")
                {
                    if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                    else
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csgd),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                }
                else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney*od.csgd),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (((tzType == "6") || (tzType == "5")) || ((tzType == "10") || (tzType == "11")))
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csgd),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "1")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csgd),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "2")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csgd),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*csgd),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND gdid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        public static string SumStaticGs(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                if (tzType == "9")
                {
                    if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                    }
                    else
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                    }
                }
                else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' and od.gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
                else
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney*(1-od.csdls-od.cszdl-od.csgd)),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' and od.gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
            }
            else if (((tzType == "6") || (tzType == "5")) || ((tzType == "10") || (tzType == "11")))
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
            }
            else if (tzType == "1")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
            }
            else if (tzType == "2")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
                }
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*(1-csdls-cszdl-csgd)),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' and gdid in (" + HttpContext.Current.Session.Contents["adminarrgd"].ToString() + "-1)";
            }
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        public static string SumStaticZdl(string ballId, string tzType, string marker)
        {
            string text = "";
            string sql = "";
            if (marker == "none")
            {
                if (tzType == "9")
                {
                    if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                    else
                    {
                        sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*cszdl),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                    }
                }
                else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "select count(od1.orderid) as orderno ,isnull(sum(od.tzmoney*od.cszdl),0) as summoney from ball_order1 od1 JOIN ball_order od ON od1.orderid = od.orderid WHERE od1.ballid='" + ballId + "' AND od1.tztype='" + tzType + "' AND od.zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (((tzType == "6") || (tzType == "5")) || ((tzType == "10") || (tzType == "11")))
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*cszdl),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype='" + tzType + "' AND ds = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "1")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*cszdl),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (1,14) AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (tzType == "2")
            {
                if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
                else
                {
                    sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*cszdl),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype in (2,15) AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
                }
            }
            else if (HttpContext.Current.Session["sessionSelectStaticCS"].ToString() == "全部")
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            else
            {
                sql = "SELECT count(orderid) as orderno ,isnull(sum(tzmoney*cszdl),0) as summoney FROM ball_order WHERE ballid='" + ballId + "' AND tztype = '" + tzType + "' AND tzteam = '" + marker + "' AND zdlid ='" + HttpContext.Current.Session.Contents["adminuserid"].ToString().Trim() + "'";
            }
            DataBase base2 = new DataBase(GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["orderno"].ToString() != "0")
                {
                    text = "<font color=gray style='font-weight: bold;'>" + reader["orderno"].ToString() + "</font>/<font color=red style='font-weight: bold;'>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
                else
                {
                    text = "<font color=gray>" + reader["orderno"].ToString() + "</font>/<font color=red>" + Convert.ToDouble(reader["summoney"]).ToString("F0") + "</font>";
                }
            }
            else
            {
                text = "<font color=gray>0</font>/<font color=red>0</font>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        public static string TimeStampe()
        {
            TimeSpan span = (TimeSpan) (DateTime.Now - DateTime.Parse("1970-1-1"));
            return span.TotalMilliseconds.ToString().Replace(".", "").PadRight(15, '0').Remove(11, 4);
        }

        public static string turnNum(string rqMarker)
        {
            rqMarker = rqMarker.Replace("平手", "0");
            rqMarker = rqMarker.Replace("1球半", "1.5");
            rqMarker = rqMarker.Replace("2球半", "2.5");
            rqMarker = rqMarker.Replace("3球半", "3.5");
            rqMarker = rqMarker.Replace("4球半", "4.5");
            rqMarker = rqMarker.Replace("一球半", "1.5");
            rqMarker = rqMarker.Replace("二球半", "2.5");
            rqMarker = rqMarker.Replace("三球半", "3.5");
            rqMarker = rqMarker.Replace("四球半", "4.5");
            rqMarker = rqMarker.Replace("五球半", "5.5");
            rqMarker = rqMarker.Replace("六球半", "6.5");
            rqMarker = rqMarker.Replace("七球半", "7.5");
            rqMarker = rqMarker.Replace("八球半", "8.5");
            rqMarker = rqMarker.Replace("球半", "1.5");
            rqMarker = rqMarker.Replace("球", "");
            rqMarker = rqMarker.Replace("半", "0.5");
            rqMarker = rqMarker.Replace("一", "1");
            rqMarker = rqMarker.Replace("二", "2");
            rqMarker = rqMarker.Replace("两", "2");
            rqMarker = rqMarker.Replace("三", "3");
            rqMarker = rqMarker.Replace("四", "4");
            rqMarker = rqMarker.Replace("五", "5");
            rqMarker = rqMarker.Replace("六", "6");
            rqMarker = rqMarker.Replace("七", "7");
            rqMarker = rqMarker.Replace("八", "8");
            rqMarker = rqMarker.Replace("九", "9");
            rqMarker = rqMarker.Replace("十", "10");
            rqMarker = rqMarker.Replace("十一", "11");
            rqMarker = rqMarker.Replace("十二", "12");
            rqMarker = rqMarker.Replace("十三", "13");
            rqMarker = rqMarker.Replace("十四", "14");
            rqMarker = rqMarker.Replace("十五", "15");
            rqMarker = rqMarker.Replace("十六", "16");
            return rqMarker;
        }

        public static string[] usermsg(string userid, DataBase db, string type)
        {
            string sql = "SELECT member.userid,member.username,member.usemoney,member.MoneySort,member.MoneyRate,member.curMoney,member.ABC,";
            sql = (sql + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11," + "userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXC15,userhs.MAXC28,userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3,userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,") + "userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,userhs.MAXZ14,userhs.MAXZ15,userhs.MAXZ28 FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid = " + userid + " AND member.isuseable=1";
            SqlDataReader reader = db.ExecuteReader(sql);
            if (!reader.Read())
            {
                reader.Close();
                return null;
            }
            string[] textArray = new string[10];
            textArray[0] = reader["userid"].ToString().Trim();
            textArray[1] = reader["username"].ToString().Trim();
            textArray[2] = reader["usemoney"].ToString().Trim();
            textArray[3] = reader["moneysort"].ToString().Trim();
            textArray[4] = reader["moneyrate"].ToString().Trim();
            textArray[5] = reader["curmoney"].ToString().Trim();
            textArray[6] = reader["abc"].ToString().Trim();
            switch (type.Trim())
            {
                case "1":
                    textArray[7] = reader["Maxc2"].ToString().Trim();
                    textArray[8] = reader["Maxz2"].ToString().Trim();
                    break;

                case "2":
                    textArray[7] = reader["Maxc3"].ToString().Trim();
                    textArray[8] = reader["Maxz3"].ToString().Trim();
                    break;

                case "3":
                    textArray[7] = reader["Maxc4"].ToString().Trim();
                    textArray[8] = reader["Maxz4"].ToString().Trim();
                    break;

                case "4":
                    textArray[7] = reader["Maxc5"].ToString().Trim();
                    textArray[8] = reader["Maxz5"].ToString().Trim();
                    break;

                case "5":
                    textArray[7] = reader["Maxc3"].ToString().Trim();
                    textArray[8] = reader["Maxz3"].ToString().Trim();
                    break;

                case "6":
                    textArray[7] = reader["Maxc19"].ToString().Trim();
                    textArray[8] = reader["Maxz19"].ToString().Trim();
                    break;

                case "7":
                    textArray[7] = reader["Maxc20"].ToString().Trim();
                    textArray[8] = reader["Maxz20"].ToString().Trim();
                    break;

                case "8":
                    textArray[7] = reader["Maxc1"].ToString().Trim();
                    textArray[8] = reader["Maxz1"].ToString().Trim();
                    break;

                case "9":
                    textArray[7] = reader["Maxc28"].ToString().Trim();
                    textArray[8] = reader["Maxz28"].ToString().Trim();
                    break;

                case "10":
                    textArray[7] = reader["Maxc21"].ToString().Trim();
                    textArray[8] = reader["Maxz21"].ToString().Trim();
                    break;

                case "11":
                    textArray[7] = reader["Maxc8"].ToString().Trim();
                    textArray[8] = reader["Maxz8"].ToString().Trim();
                    break;

                case "12":
                    textArray[7] = reader["Maxc9"].ToString().Trim();
                    textArray[8] = reader["Maxz9"].ToString().Trim();
                    break;

                case "13":
                    textArray[7] = reader["Maxc7"].ToString().Trim();
                    textArray[8] = reader["Maxz7"].ToString().Trim();
                    break;

                case "14":
                    textArray[7] = reader["Maxc10"].ToString().Trim();
                    textArray[8] = reader["Maxz10"].ToString().Trim();
                    break;

                case "15":
                    textArray[7] = reader["Maxc11"].ToString().Trim();
                    textArray[8] = reader["Maxz11"].ToString().Trim();
                    break;

                case "16":
                    textArray[7] = reader["Maxc12"].ToString().Trim();
                    textArray[8] = reader["Maxz12"].ToString().Trim();
                    break;

                case "17":
                    textArray[7] = reader["Maxc13"].ToString().Trim();
                    textArray[8] = reader["Maxz13"].ToString().Trim();
                    break;

                case "18":
                    textArray[7] = reader["Maxc18"].ToString().Trim();
                    textArray[8] = reader["Maxz18"].ToString().Trim();
                    break;

                case "19":
                    textArray[7] = reader["Maxc22"].ToString().Trim();
                    textArray[8] = reader["Maxz22"].ToString().Trim();
                    break;

                case "20":
                    textArray[7] = reader["Maxc23"].ToString().Trim();
                    textArray[8] = reader["Maxz23"].ToString().Trim();
                    break;

                default:
                    textArray[7] = "0";
                    textArray[8] = "0";
                    break;
            }
            reader.Close();
            return textArray;
        }

        public static void WriteUserEvent(DataBase db, string userid, string username, string ip, string classid, string type)
        {
            if (type == "1")
            {
                db.ExecuteNonQuery("INSERT INTO event(userid,username,logintime,ip,classid)VALUES(" + userid + ",'" + username + "',GetDate(),'" + ip + "'," + classid + ")");
            }
            else if (classid == "20")
            {
                db.ExecuteNonQuery("UPDATE event SET lefttime=getdate() WHERE id=(SELECT TOP 1 id FROM event WHERE userid=" + userid + " AND classid=20 ORDER BY id DESC)");
            }
            else
            {
                db.ExecuteNonQuery("UPDATE event SET lefttime=getdate() WHERE id=(SELECT TOP 1 id FROM event WHERE userid=" + userid + " AND classid<>20 ORDER BY id DESC)");
            }
        }
    }
}

