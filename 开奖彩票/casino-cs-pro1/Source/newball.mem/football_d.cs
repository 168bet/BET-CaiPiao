namespace newball.mem
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
            else if (!this.Page.IsPostBack)
            {
                this.TopMenuProcess();
                this.ProcessContent();
            }
        }

        private void ProcessContent()
        {
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;特别号</font>\n<table id=glist_table border=0 cellspacing=1 cellpadding=0 class=ra_listbet_tab width=850>\n  <tr class=ra_listbet_title><td width=40>时间</td><td width=50>期数</td><td>号码</td>\n";
            s = (s + " <td width=70>注单</td><td>号码</td><td width=70>注单</td><td>号码</td>" + " <td width=70>注单</td><td>号码</td><td width=70>注单</td><td>号码</td>") + " <td width=70>注单</td><td>号码</td><td width=70>注单</td></tr>" + this.SumAllMember();
            base.Response.Write(s);
        }

        private string SumAllMember()
        {
            string text2 = "";
            string text3 = "";
            string text4 = "";
            int index = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = null;
            SqlDataReader reader2 = null;
            DataSet set = null;
            double num3 = 0;
            string[] textArray = "01,11,21,31,41,特单,02,12,22,32,42,特双,03,13,23,33,43,特大,04,14,24,34,44,特小,05,15,25,35,45,合单,06,16,26,36,46,合双,07,17,27,37,47,08,18,28,38,48,09,19,29,39,49,10,20,30,40".Split(new char[] { ',' });
            reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            if (reader.Read())
            {
                DateTime time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                TimeSpan span = DateTime.Now.Subtract(time);
                int num4 = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                if (num4 < 360)
                {
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
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 6]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 6]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text6 = text2;
                        text2 = text6 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text7 = text2;
                            text2 = text7 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 6]["id"].ToString().Trim() + "&tztype=8&marker=C'><span class=tznumer>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x10]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x10]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text8 = text2;
                        text2 = text8 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text9 = text2;
                            text2 = text9 + "<td align=center bgcolor=#FFFFFF><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x10]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</span></font></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x1a]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x1a]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text10 = text2;
                        text2 = text10 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text11 = text2;
                            text2 = text11 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x1a]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
                            num3 += double.Parse(reader2["summoney"].ToString());
                        }
                        else
                        {
                            text2 = text2 + "<td align=center ><font color=#CC0000>" + text3 + "</font>   <br>    <span class=tznumer><font color=#000088>0</font></span></a></td> ";
                        }
                        reader2.Close();
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x24]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x24]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text12 = text2;
                        text2 = text12 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                        if (reader2.Read())
                        {
                            string text13 = text2;
                            text2 = text13 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x24]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
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
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                            }
                            else
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                            }
                            text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 0x2e]["pl"].ToString().Trim(), this.Session.Contents["ABC1"].ToString().Trim(), set.Tables[0].Rows[i + 0x2e]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            string text14 = text2;
                            text2 = text14 + "<td align=center background=" + MyFunc.GetRGB(textArray[index]) + " class=nums><font color=" + MyFunc.GetRGB(int.Parse(textArray[index])) + " size=3><b>" + textArray[index++] + "</b></font></td>";
                            if (reader2.Read())
                            {
                                string text15 = text2;
                                text2 = text15 + "<td align=center bgcolor=#FFFFFF ><font color=#CC0000>" + text3 + "</font>   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 0x2e]["id"].ToString().Trim() + "&tztype=8&marker=C'>  <span class=tznumer><font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></span></a></td> ";
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
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                            }
                            else
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                            }
                            text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            text2 = text2 + "<td align=center>" + textArray[index++] + "</td>";
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
                }
            }
            reader.Close();
            base3.CloseConnect();
            base3.Dispose();
            base2.CloseConnect();
            base2.Dispose();
            string text16 = text2;
            string[] textArray12 = new string[8];
            textArray12[0] = text16;
            textArray12[1] = "<tr bgcolor='#ffffff' height='25' ><td colspan=14>本页总额<b><font color=blue>";
            textArray12[2] = num3.ToString();
            textArray12[3] = "</font></b>元(49粒),码均<b><font color=black>";
            textArray12[4] = (num3 / 49).ToString("F2");
            textArray12[5] = "</font></b>元;按陪率42(12水)估算：如中到<b><font color=red>";
            double num26 = (num3 * 0.88) / 42;
            textArray12[6] = double.Parse(num26.ToString()).ToString("F2");
            textArray12[7] = "</font></b>元投注额,本项目您将输彩</td></tr>";
            return (string.Concat(textArray12) + "\n</table></form></body></html>");
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

