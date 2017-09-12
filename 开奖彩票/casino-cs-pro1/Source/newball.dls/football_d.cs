namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Configuration;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class football_d : Page
    {
        protected double abcadd = 0;
        public string sql1 = "";
        public string sTime = "N";

        private string[] GetZdRqMsg(string ballid, string team, DataBase db)
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            string s = "";
            string[] textArray = new string[10];
            string[] textArray2 = team.Split(new char[] { ',' });
            string[] textArray3 = MyFunc.twelveName.Split(new char[] { ',' });
            if (ballid != "0")
            {
                if (this.IsClose(ballid.ToString()))
                {
                    return null;
                }
                sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id =" + ballid;
                SqlDataReader reader = db.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[0] = reader["id"].ToString().Trim();
                    textArray[2] = "H";
                    textArray[3] = "H";
                    text3 = reader["pltype"].ToString().Trim();
                    if (reader["tztype"].ToString().Trim() == "8")
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    else if (((reader["tztype"].ToString().Trim() == "9") || (reader["tztype"].ToString().Trim() == "10")) || (((reader["tztype"].ToString().Trim() == "18") || (reader["tztype"].ToString().Trim() == "19")) || (reader["tztype"].ToString().Trim() == "20")))
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), "0", reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    else
                    {
                        s = double.Parse(MyFunc.GetPlType(reader["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), reader["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    }
                    textArray[1] = (double.Parse(s) - 1).ToString();
                }
                reader.Close();
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
                reader = base2.ExecuteReader(sql);
                if (reader.Read())
                {
                    textArray[8] = reader["kaisai"].ToString().Trim();
                    if (textArray2.Length == 6)
                    {
                        string text5 = "";
                        for (int i = 0; i < 6; i++)
                        {
                            text5 = text5 + textArray3[int.Parse(textArray2[i].ToString())].ToString() + ",";
                        }
                        text5 = text5.Remove(text5.Length - 1, 1);
                        text2 = "第" + reader["qishu"].ToString().Trim() + "期　<FONT COLOR=#CC0000>" + text3 + "</font><br>" + text5 + "&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + s + "</B></font>";
                    }
                    else
                    {
                        text2 = "第" + reader["qishu"].ToString().Trim() + "期　<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + s + "</B></font>";
                    }
                }
                reader.Close();
                textArray[4] = text2.Replace("'", "");
                textArray[5] = "1";
                textArray[6] = "1";
                textArray[7] = "1";
                reader.Close();
                base2.Dispose();
                if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
                {
                    return null;
                }
                return textArray;
            }
            if (this.IsClose(team.Split(new char[] { ',' })[0].ToString()))
            {
                return null;
            }
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT top 1 qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            SqlDataReader reader2 = base3.ExecuteReader(sql);
            if (reader2.Read())
            {
                textArray[8] = reader2["kaisai"].ToString().Trim();
                text2 = "第" + reader2["qishu"].ToString().Trim() + "期　";
            }
            reader2.Close();
            sql = "SELECT v1.id,v1.tztype,v1.pl,v1.pltype,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 left join changeleave as cl On (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "') WHERE v1.id in (" + team + ")";
            reader2 = db.ExecuteReader(sql);
            textArray[0] = team;
            double num3 = 1;
            while (reader2.Read())
            {
                textArray[2] = "H";
                textArray[3] = "H";
                text3 = reader2["pltype"].ToString().Trim();
                num3 *= double.Parse(reader2["pl"].ToString().Trim());
                string text6 = text2;
                text2 = text6 + "<FONT COLOR=#CC0000>" + text3 + "</font>&nbsp;@&nbsp; <font color=\"#CC0000\"><B>" + double.Parse(MyFunc.GetPlType(reader2["pl"].ToString().Trim(), "0", reader2["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString() + "</B></font><br>";
            }
            textArray[1] = (num3 - 1).ToString();
            textArray[4] = text2.Replace("'", "");
            textArray[5] = "1";
            textArray[6] = "1";
            textArray[7] = "1";
            reader2.Close();
            base3.Dispose();
            if ((textArray[0] != "") && (double.Parse(textArray[0]) < 0))
            {
                return null;
            }
            return textArray;
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        private bool IsClose(string ballid)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "SELECT top 1 qishu,tupdatetime,kaisai,tmclose,zmclose FROM affiche WHERE le=1 ORDER BY updatetime DESC";
            int num = int.Parse(ballid);
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (!reader.Read())
            {
                return true;
            }
            if ((((num > 0) && (num < 7)) || ((num > 0x22) && (num < 0x54))) || (((num > 0xc7) && (num < 0xd7)) || ((num > 0xe5) && (num < 0xf4))))
            {
                if (reader["tmclose"].ToString() != "0")
                {
                    return true;
                }
                TimeSpan span = Convert.ToDateTime(reader["tupdatetime"].ToString()).Subtract(DateTime.Now);
                int num2 = ((((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds) + 20;
                if (num2 < 1)
                {
                    return true;
                }
            }
            else if (reader["zmclose"].ToString() == "0")
            {
                TimeSpan span2 = Convert.ToDateTime(reader["kaisai"].ToString()).Subtract(DateTime.Now);
                int num3 = ((((span2.Days * 0x15180) + (span2.Hours * 0xe10)) + (span2.Minutes * 60)) + span2.Seconds) + 20;
                if (num3 < 1)
                {
                    return true;
                }
            }
            else
            {
                return true;
            }
            reader.Close();
            base2.Dispose();
            return false;
        }

        private string NewOrderid(string orderid)
        {
            Random random = new Random(int.Parse(this.Session.Contents["adminuserid"].ToString().Trim()));
            string text = "";
            string text2 = random.NextDouble().ToString().Replace(".", "");
            Random random2 = new Random();
            for (int i = 0; i < 7; i++)
            {
                text = text + text2[random2.Next(text2.Length)];
            }
            return (orderid + text);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            string s;
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
                return;
            }
            if ((base.Request.Form["action"] == null) || (base.Request.Form["action"].ToString() != "save"))
            {
                goto Label_03C9;
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (int.Parse(base2.ExecuteScalar("select count(*) from ball_order2 where DATEDIFF(dd, GETDATE(), updatetime)=0 and userid=" + this.Session.Contents["adminuserid"]).ToString()) > 0)
            {
                MyFunc.showmsg("对不起,每期只能过一次单");
                goto Label_03C3;
            }
            string text = "";
            switch (this.Session.Contents["adminclassid"].ToString())
            {
                case "0":
                    text = " and gdid in (" + this.Session["adminarrgd"].ToString() + "-1) ";
                    goto Label_01DC;

                case "1":
                    text = "";
                    goto Label_01DC;

                case "2":
                    text = " and gdid = " + this.Session.Contents["adminuserid"] + " ";
                    goto Label_01DC;

                case "3":
                    text = " and zdlid = " + this.Session.Contents["adminuserid"] + " ";
                    break;

                case "4":
                    text = " and dlsid = " + this.Session.Contents["adminuserid"] + " ";
                    break;
            }
        Label_01DC:
            s = base.Request.Form["amount"].ToString();
            if (s != "")
            {
                int num2 = 0;
                SqlDataReader reader = null;
                int num3 = 0;
                reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,tmclose,qishu,kaisai,tupdatetime FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                if (reader.Read())
                {
                    if (reader["tmclose"].ToString() == "0")
                    {
                        TimeSpan span = Convert.ToDateTime(reader["tupdatetime"].ToString()).Subtract(DateTime.Now);
                        int num4 = ((((span.Days * 0x15180) + (span.Hours * 0xe10)) + (span.Minutes * 60)) + span.Seconds) + 20;
                        if (num4 < 1)
                        {
                            base.Response.Write("<script>alert('球赛已关闭');</script>");
                            num3 = 1;
                        }
                    }
                    else
                    {
                        base.Response.Write("<script>alert('球赛已关闭');</script>");
                        num3 = 1;
                    }
                }
                else
                {
                    base.Response.Write("<script>alert('还没有开赛');</script>");
                    num3 = 1;
                }
                reader.Close();
                if (num3 == 0)
                {
                    string sql = "select ballid,min(curpl) as curpl,isnull(sum(tzmoney),0) as tzmoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and tztype=8  " + text + " group by ballid";
                    reader = base2.ExecuteReader(sql);
                    while (reader.Read())
                    {
                        if (int.Parse(reader["tzmoney"].ToString()) > int.Parse(s))
                        {
                            this.saveOrder("8", reader["ballid"].ToString(), "H", (int.Parse(reader["tzmoney"].ToString()) - int.Parse(s)).ToString(), reader["curpl"].ToString());
                            num2++;
                        }
                    }
                    reader.Close();
                    if (num2 > 0)
                    {
                        base.Response.Write("<script>alert('过单成功，请在\"过单\"处查阅过单情况');</script>");
                    }
                    else
                    {
                        base.Response.Write("<script>alert('过单失败，你的过单金额太高');</script>");
                    }
                }
            }
        Label_03C3:
            base2.Dispose();
        Label_03C9:
            this.TopMenuProcess();
            this.ProcessContent();
            this.DataBind();
        }

        private void ProcessContent()
        {
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;特别号</font>\n<table id=glist_table border=0 cellspacing=1 cellpadding=0 class=ra_listbet_tab width=850>\n  <tr class=ra_listbet_title><td width=40>时间</td><td width=50>期数</td><td >号码</td>\n";
            s = (s + " <td width=80>注单</td><td>号码</td><td width=80>注单</td><td>号码</td>" + " <td width=80>注单</td><td>号码</td><td width=80>注单</td><td>号码</td>") + " <td width=80>注单</td><td>号码</td><td width=80>注单</td></tr>" + this.SumAllMember();
            base.Response.Write(s);
        }

        private void saveOrder(string type, string ballid, string team, string money, string cstype)
        {
            string[] textArray = null;
            string text = (long.Parse(this.NewOrderid(MyFunc.TimeStampe())) + long.Parse(ballid)).ToString();
            string text2 = text;
            string text3 = "FALSE";
            string text5 = "";
            string sql = "";
            string text7 = "";
            string text10 = "0";
            string text11 = "";
            string text15 = "1";
            string text17 = "";
            string text19 = "";
            string text20 = "0";
            string text21 = "0";
            string text25 = "0";
            string text26 = "0";
            string text27 = "0";
            string text28 = "0";
            string text29 = "0";
            string text30 = "0";
            string text31 = "0";
            string text32 = "0";
            string text33 = "0";
            string text34 = "0";
            string text35 = "0";
            string text36 = "";
            DataBase db = new DataBase(MyFunc.GetConnStr(1));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
            textArray = this.GetZdRqMsg(ballid, team, db);
            if (textArray == null)
            {
                base.Response.Write("<script>alert('对不起,球赛已关闭');</script>");
            }
            else
            {
                text3 = (textArray != null) ? textArray[6] : "FALSE";
                text5 = textArray[1];
                string text9 = Math.Abs(double.Parse(money)).ToString();
                text10 = this.Session.Contents["adminuserid"].ToString();
                text11 = this.Session.Contents["adminusername"].ToString();
                text36 = "SELECT w1,l1 FROM hs WHERE type='B' AND userid=" + text10;
                SqlDataReader reader = base3.ExecuteReader(text36);
                if (reader.Read())
                {
                    text29 = reader[0].ToString().Trim();
                    text30 = reader[1].ToString().Trim();
                }
                else
                {
                    text29 = "0";
                    text30 = "0";
                }
                reader.Close();
                sql = "INSERT INTO Ball_Order2(orderid,ballid,tztype,tzmoney,curpl,tzteam,rqteam,rqc,zdbf,content,userid,username,gdid,zdlid,dlsid,hszdl_w,hsdls_w,hsuser_w,hszdl_l,hsdls_l,hsuser_l,hsgd_w,hsgd_l,csgd,cszdl,csdls,tzip,updatetime,moneyrate,balltime,abc,isdanger,zdmoney,ds)VALUES(" + text + "," + ballid + "," + type + "," + text9 + "," + textArray[1] + ",'" + team + "','" + textArray[2] + "',1,'" + cstype + "','" + textArray[4] + "'," + text10 + ",'" + text11 + "'," + text20 + "," + text21 + "," + this.Session.Contents["pre_id"].ToString() + "," + text25 + "," + text27 + "," + text29 + "," + text26 + "," + text28 + "," + text30 + "," + text34 + "," + text35 + "," + text31 + "," + text32 + "," + text33 + ",'" + text19 + "',GetDate()," + text15 + ",'" + textArray[8] + "','" + text17 + "',0," + text9 + ",'" + base.Request.Form["amount"].ToString() + "');";
                text7 = textArray[4];
                base3.ExecuteNonQuery(sql);
                base3.Dispose();
                db.Dispose();
            }
        }

        private string SumAllMember()
        {
            DataBase base2;
            string text2 = "";
            string text3 = "";
            string text4 = "";
            string text5 = "";
            int index = 0;
            switch (this.Session.Contents["adminclassid"].ToString())
            {
                case "0":
                    text5 = " and gdid in (" + this.Session["adminarrgd"].ToString() + "-1) ";
                    goto Label_0149;

                case "1":
                    text5 = "";
                    goto Label_0149;

                case "2":
                    text5 = " and gdid = " + this.Session.Contents["adminuserid"] + " ";
                    goto Label_0149;

                case "3":
                    text5 = " and zdlid = " + this.Session.Contents["adminuserid"] + " ";
                    break;

                case "4":
                    text5 = " and dlsid = " + this.Session.Contents["adminuserid"] + " ";
                    break;
            }
        Label_0149:
            base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = null;
            SqlDataReader reader2 = null;
            DataSet set = null;
            double num3 = 0;
            string[] textArray = "01,11,21,31,41,特单,02,12,22,32,42,特双,03,13,23,33,43,特大,04,14,24,34,44,特小,05,15,25,35,45,合单,06,16,26,36,46,合双,07,17,27,37,47,08,18,28,38,48,09,19,29,39,49,10,20,30,40".Split(new char[] { ',' });
            reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai,tupdatetime FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            if (reader.Read())
            {
                DateTime time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                TimeSpan span = DateTime.Now.Subtract(time);
                int num4 = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                if (num4 < 360)
                {
                    TimeSpan span2 = Convert.ToDateTime(reader["tupdatetime"].ToString().Trim()).Subtract(DateTime.Now);
                    this.sTime = ((((span2.Hours * 0x5a0) + (span2.Minutes * 60)) + span2.Seconds) + 20).ToString();
                    object obj2 = text2;
                    text2 = string.Concat(new object[] { obj2, "<tr bgcolor='#FFFFFF' ><td rowspan=10>", reader["kaisai"].ToString().Split(new char[] { ' ' })[0].ToString().Trim(), "<BR>", reader["kaisai"].ToString().Split(new char[] { ' ' })[1].ToString().Trim(), "</td><td rowspan=10 align=center>", reader["qishu"], "</td>" });
                    text4 = reader["kaisai"].ToString();
                    reader.Close();
                    set = base3.ExecuteDataSet("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "')  where ((id>0 and id<7 )or (id>34 and id <84)) order by id asc");
                    for (int i = 0; i < 10; i++)
                    {
                        if (i != 0)
                        {
                            text2 = text2 + "<tr bgcolor='#FFFFFF' >";
                        }
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 6]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 6]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text8 = text2;
                        text2 = text8 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + "><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text9 = text2;
                            text2 = text9 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + "&tztype=8&marker=C'><span class=tznumer>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x10]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x10]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text10 = text2;
                        text2 = text10 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text11 = text2;
                            text2 = text11 + "<td align=center bgcolor=#FFFFFF><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</span></font></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x1a]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x1a]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text12 = text2;
                        text2 = text12 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text13 = text2;
                            text2 = text13 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center ><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x24]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x24]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text14 = text2;
                        text2 = text14 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text15 = text2;
                            text2 = text15 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center ><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (i < 9)
                        {
                            if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                            }
                            else
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                            }
                            text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x2e]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x2e]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            string text16 = text2;
                            text2 = text16 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                            if (reader2.Read())
                            {
                                string text17 = text2;
                                text2 = text17 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                                num3 += double.Parse(reader2["summoney"].ToString());
                            }
                            else
                            {
                                text2 = text2 + "<td align=center ><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                            }
                            reader2.Close();
                        }
                        else
                        {
                            text2 = text2 + "<td colspan=2>&nbsp;</td>";
                        }
                        if (i < 6)
                        {
                            if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                            }
                            else
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*csdls),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 " + text5 + "  and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                            }
                            text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            text2 = text2 + "<td align=center >" + textArray[index++] + "</td>";
                            if (reader2.Read())
                            {
                                object obj3 = text2;
                                object[] objArray2 = new object[] { obj3, "<td align=center bgcolor=#FFFFFF><font color=#CC0000>", text3, "</font>   <br>  <a href='tzinfo.aspx?gameid=", set.Tables[0].Rows[i]["id"].ToString().Trim(), "&tztype=", int.Parse(((i + 2) / 2).ToString()), "&marker=C'>  <span class=tznumer><font color=#000088>", double.Parse(reader2["summoney"].ToString()).ToString(), "</font></span></a></td> </tr>" };
                                text2 = string.Concat(objArray2);
                            }
                            else
                            {
                                text2 = text2 + "<td align=center bgcolor=#FFFFFF><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                            }
                            reader2.Close();
                        }
                        else
                        {
                            text2 = text2 + "<td colspan=2>&nbsp;</td></tr>";
                        }
                    }
                    set.Dispose();
                    string text18 = text2;
                    string[] textArray24 = new string[8];
                    textArray24[0] = text18;
                    textArray24[1] = "<tr bgcolor='#ffffff' height='25' ><td colspan=14>本页总额<b><font color=blue>";
                    textArray24[2] = num3.ToString();
                    textArray24[3] = "</font></b>元(49粒),码均<b><font color=black>";
                    textArray24[4] = (num3 / 49).ToString("F2");
                    textArray24[5] = "</font></b>元;按陪率42(12水)估算：如中到<b><font color=red>";
                    double num27 = (num3 * 0.88) / 42;
                    textArray24[6] = double.Parse(num27.ToString()).ToString("F2");
                    textArray24[7] = "</font></b>元投注额,本项目您将输彩</td></tr>";
                    text2 = string.Concat(textArray24) + "</table></tr>";
                }
                else
                {
                    text2 = text2 + "<table><tr><TD id=closeM align=right >" + "<SPAN id=close_msg>&nbsp;</SPAN></TD></tr></table>";
                }
            }
            reader.Close();
            base3.CloseConnect();
            base3.Dispose();
            base2.CloseConnect();
            base2.Dispose();
            return (text2 + "\n</table></form></body></html>");
        }

        private void TopMenuProcess()
        {
            string s;
            string ltype = "C";
            string retime = "-1";
            string strMethod = "d";
            if (base.Request.Form["selectZD"] != null)
            {
                this.Session["sessionSelectZD"] = base.Request.Form["selectZD"].ToString();
            }
            else if (this.Session["sessionSelectZD"] == null)
            {
                this.Session["sessionSelectZD"] = "无有单";
            }
            if (base.Request.Form["staticCS"] != null)
            {
                this.Session["sessionSelectStaticCS"] = base.Request.Form["staticCS"].ToString();
            }
            else if (this.Session["sessionSelectStaticCS"] == null)
            {
                this.Session["sessionSelectStaticCS"] = "全部";
            }
            if (base.Request.Form["ltype"] != null)
            {
                ltype = base.Request.Form["ltype"].ToString().Trim();
                this.Session["football_b_ltype"] = ltype;
            }
            else if (this.Session["football_b_ltype"] != null)
            {
                ltype = this.Session["football_b_ltype"].ToString().Trim();
            }
            if (base.Request.Form["retime"] != null)
            {
                retime = base.Request.Form["retime"].ToString().Trim();
                this.Session["football_b_retime"] = retime;
            }
            else if (this.Session["football_b_retime"] != null)
            {
                retime = this.Session["football_b_retime"].ToString().Trim();
            }
            if (ltype.ToUpper() == "A")
            {
                this.abcadd = 0.01;
            }
            if (ltype.ToUpper() == "B")
            {
                this.abcadd = 0.03;
            }
            if (ltype.ToUpper() == "D")
            {
                this.abcadd = -0.015;
            }
            switch (ltype.ToUpper())
            {
                case "A":
                    this.Session.Contents["ABC"] = double.Parse(ConfigurationSettings.AppSettings["UserPlA"].ToString().Trim());
                    this.Session.Contents["ABC1"] = double.Parse(ConfigurationSettings.AppSettings["UserPlA1"].ToString().Trim());
                    goto Label_0464;

                case "B":
                    this.Session.Contents["ABC"] = double.Parse(ConfigurationSettings.AppSettings["UserPlB"].ToString().Trim());
                    this.Session.Contents["ABC1"] = double.Parse(ConfigurationSettings.AppSettings["UserPlB1"].ToString().Trim());
                    goto Label_0464;

                case "C":
                    this.Session.Contents["ABC"] = double.Parse(ConfigurationSettings.AppSettings["UserPlC"].ToString().Trim());
                    this.Session.Contents["ABC1"] = double.Parse(ConfigurationSettings.AppSettings["UserPlC1"].ToString().Trim());
                    break;

                case "D":
                    this.Session.Contents["ABC"] = double.Parse(ConfigurationSettings.AppSettings["UserPlD"].ToString().Trim());
                    this.Session.Contents["ABC1"] = double.Parse(ConfigurationSettings.AppSettings["UserPlD1"].ToString().Trim());
                    break;
            }
        Label_0464:
            s = MyFunc.pintingAgenceMenu(ltype, retime, strMethod);
            base.Response.Write(s);
        }
    }
}

