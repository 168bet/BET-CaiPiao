namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class football_g : Page
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
                this.topMenuProcess();
                this.ProcessContent();
            }
        }

        private void ProcessContent()
        {
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;生肖色波一肖</font>\n<table id=glist_table border=0 cellspacing=1 cellpadding=0 class=ra_listbet_tab width=780>\n   <tr class=ra_listbet_title><td width=40>时间</td><td width=40>期数</td><td width=60>生肖</td>\n";
            s = (s + "  <td width=100>号码</td><td width=90>注单</td><td width=80>色波</td><td>注单</td><td width=60>一肖</td>") + "  <td width=100>号码</td><td width=90>注单</td></tr>" + this.SumAllMember();
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
            string[] textArray = "0,红波,0,1,绿波,1,2,蓝波,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11".Split(new char[] { ',' });
            reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            if (reader.Read())
            {
                DateTime time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                TimeSpan span = DateTime.Now.Subtract(time);
                int num3 = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                if (num3 < 360)
                {
                    object obj2 = text2;
                    text2 = string.Concat(new object[] { obj2, "<tr bgcolor='#FFFFFF' ><td rowspan=12>", reader["kaisai"].ToString().Split(new char[] { ' ' })[0].ToString().Trim(), "<BR>", reader["kaisai"].ToString().Split(new char[] { ' ' })[1].ToString().Trim(), "</td><td rowspan=12 align=center>", reader["qishu"], "</td>" });
                    text4 = reader["kaisai"].ToString();
                    reader.Close();
                    set = base3.ExecuteDataSet("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "')  where (id>199 and id<230 ) order by id asc");
                    reader2 = base2.ExecuteReader("select userid  from agence where gdid=" + this.Session["adminuserid"].ToString());
                    string text5 = "";
                    while (reader2.Read())
                    {
                        text5 = text5 + reader2["userid"].ToString().Trim() + ",";
                    }
                    reader2.Close();
                    text5 = text5 + "0";
                    for (int i = 0; i < 12; i++)
                    {
                        if (i != 0)
                        {
                            text2 = text2 + "<tr bgcolor='#FFFFFF' >";
                        }
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*(1-csgd-cszdl-csdls)),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text7 = text2;
                        text2 = text7 + "<td align=center>" + MyFunc.GettwelveName(textArray[index]) + "</td><td align=center>" + MyFunc.GettwelveNum(textArray[index++]) + "</td>";
                        if (reader2.Read())
                        {
                            string text8 = text2;
                            text2 = text8 + "<td align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i]["id"].ToString().Trim() + "&tztype=18&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                        }
                        else
                        {
                            text2 = text2 + "<td align=center class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td> ";
                        }
                        reader2.Close();
                        if (i < 3)
                        {
                            if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid in (" + set.Tables[0].Rows[i + 12]["id"].ToString().Trim() + "," + set.Tables[0].Rows[i + 0x1b]["id"].ToString().Trim() + ") group by tztype order by tztype asc");
                            }
                            else
                            {
                                reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*(1-csgd-cszdl-csdls)),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid in (" + set.Tables[0].Rows[i + 12]["id"].ToString().Trim() + "," + set.Tables[0].Rows[i + 0x1b]["id"].ToString().Trim() + ") group by tztype order by tztype desc");
                            }
                            text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 12]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[i + 12]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                            text2 = text2 + "<td align=center>" + textArray[index++] + "</td>";
                            if (reader2.Read())
                            {
                                string text9 = text2;
                                text2 = text9 + "<td align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 12]["id"].ToString().Trim() + "," + set.Tables[0].Rows[i + 12]["id"].ToString().Trim() + "&tztype=17&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                            }
                            else
                            {
                                text2 = text2 + "<td align=center class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td> ";
                            }
                            reader2.Close();
                        }
                        else
                        {
                            text2 = text2 + "<td align=center ></td><td align=center ></td>";
                        }
                        if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid=" + set.Tables[0].Rows[i + 15]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                        }
                        else
                        {
                            reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney*(1-csgd-cszdl-csdls)),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0 and gdid in (" + text5 + ") and ballid=" + set.Tables[0].Rows[i + 15]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                        }
                        text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[i + 15]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[i]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                        string text10 = text2;
                        text2 = text10 + "<td align=center>" + MyFunc.GettwelveName(textArray[index]) + "</td><td align=center>" + MyFunc.GettwelveNum(textArray[index++]) + "</td>";
                        if (reader2.Read())
                        {
                            string text11 = text2;
                            text2 = text11 + "<td align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[i + 15]["id"].ToString().Trim() + "&tztype=19&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td></tr> ";
                        }
                        else
                        {
                            text2 = text2 + "<td align=center class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td></tr>";
                        }
                        reader2.Close();
                    }
                    set.Dispose();
                }
            }
            reader.Close();
            base3.CloseConnect();
            base3.Dispose();
            base2.CloseConnect();
            base2.Dispose();
            return (text2 + "\n</table></form></body></html>");
        }

        private void topMenuProcess()
        {
            string ltype = "C";
            string retime = "-1";
            string strMethod = "g";
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
            this.Session.Contents["ABC"] = "0";
            string s = MyFunc.pintingAgenceMenu(ltype, retime, strMethod);
            base.Response.Write(s);
        }
    }
}

