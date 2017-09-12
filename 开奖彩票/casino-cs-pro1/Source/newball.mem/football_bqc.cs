namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class football_bqc : Page
    {
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
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;连码</font>\n<table id=glist_table border=0 cellspacing=1 cellpadding=0 class=ra_listbet_tab width=800><tr class=ra_listbet_title>\n<td width=40>时间</td><td width=50>期数</td><td colspan='2'>三中二</td><td width=120>三全中</td>\n";
            s = s + "<td width=120>二全中</td><td colspan='2'>二中特</td><td>特串</td></tr>" + this.sumAllMember();
            base.Response.Write(s);
        }

        private string sumAllMember()
        {
            string text2 = "";
            string text3 = "";
            string text4 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
            SqlDataReader reader = null;
            SqlDataReader reader2 = null;
            DataSet set = null;
            string[] textArray = "01,11,21,31,41,特单,02,12,22,32,42,特双,03,13,23,33,43,特大,04,14,24,34,44,特小,05,15,25,35,45,合单,06,16,26,36,46,合双,07,17,27,37,47,08,18,28,38,48,09,19,29,39,49,10,20,30,40".Split(new char[] { ',' });
            reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content,qishu,kaisai FROM affiche WHERE le=1 ORDER BY updatetime DESC");
            if (reader.Read())
            {
                DateTime time = Convert.ToDateTime(reader["kaisai"].ToString().Trim());
                TimeSpan span = DateTime.Now.Subtract(time);
                int num3 = ((span.Days * 0x5a0) + (span.Hours * 60)) + span.Minutes;
                if (num3 < 360)
                {
                    object obj2 = text2;
                    text2 = string.Concat(new object[] { obj2, "<tr bgcolor='#FFFFFF' ><td rowspan=3>", reader["kaisai"].ToString().Split(new char[] { ' ' })[0], "<BR>", reader["kaisai"].ToString().Split(new char[] { ' ' })[1], "</td><td rowspan=3 align=center>", reader["qishu"], "</td>" });
                    text4 = reader["kaisai"].ToString();
                    reader.Close();
                    set = base3.ExecuteDataSet("SELECT v1.*,isnull((cl.giveup1sum-cl.giveup2sum)/cl.giveupmoney*giveuppl,0) as give FROM Pl as v1 LEFT JOIN changeleave as cl ON (v1.id = cl.ballid AND cl.gsid = '" + this.Session["usergsid"].ToString() + "')  where (id>150 and id<158 ) order by id asc");
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[1]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[1]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = text2 + "<td width=70 align=center>中二</td><td align=center>" + text3 + "</td> ";
                    if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[0]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                    }
                    else
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[0]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                    }
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[0]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[0]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    if (reader2.Read())
                    {
                        string text6 = text2;
                        text2 = text6 + "<td rowspan=3 align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[0]["id"].ToString().Trim() + "&tztype=11&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                    }
                    else
                    {
                        text2 = text2 + "<td align=center rowspan=3 class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td> ";
                    }
                    reader2.Close();
                    if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[3]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                    }
                    else
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[3]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                    }
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[3]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[3]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    if (reader2.Read())
                    {
                        string text7 = text2;
                        text2 = text7 + "<td rowspan=3 align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[3]["id"].ToString().Trim() + "&tztype=13&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                    }
                    else
                    {
                        text2 = text2 + "<td align=center rowspan=3 class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td> ";
                    }
                    reader2.Close();
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[4]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[4]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = text2 + "<td width=70 align=center>中特</td><td align=center>" + text3 + "</td> ";
                    if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[6]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                    }
                    else
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[6]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                    }
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[6]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[6]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    if (reader2.Read())
                    {
                        string text8 = text2;
                        text2 = text8 + "<td rowspan=3 align=center class=tznumer>" + text3 + "   <br>  <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[6]["id"].ToString().Trim() + "&tztype=15&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                    }
                    else
                    {
                        text2 = text2 + "<td align=center  rowspan=3 class=tznumer>" + text3 + "   <br>    <font color=#000088>0</font></a></td> ";
                    }
                    reader2.Close();
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[2]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[2]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = text2 + "<tr bgcolor='#FFFFFF'><td align=center>中三</td><td align=center>" + text3 + "</td> ";
                    text3 = double.Parse(MyFunc.GetPlType(set.Tables[0].Rows[5]["pl"].ToString().Trim(), this.Session.Contents["ABC"].ToString().Trim(), set.Tables[0].Rows[5]["give"].ToString().Trim(), "H", "0").ToString("F2")).ToString();
                    text2 = text2 + "<td width=70 align=center>中二</td><td align=center>" + text3 + "</td></tr> ";
                    if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[1]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                    }
                    else
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[1]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                    }
                    if (reader2.Read())
                    {
                        string text9 = text2;
                        text2 = text9 + "<tr bgcolor='#FFFFFF class=tznumer'><td align=center colspan='2'> <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[1]["id"].ToString().Trim() + "&tztype=12&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                    }
                    else
                    {
                        text2 = text2 + "<tr bgcolor='#FFFFFF' class=tznumer><td align=center colspan='2'>  <font color=#000088>0</font></a></td> ";
                    }
                    reader2.Close();
                    if (this.Session["sessionSelectStaticCS"].ToString() == "全部")
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[4]["id"].ToString().Trim() + " group by ballid order by ballid asc");
                    }
                    else
                    {
                        reader2 = base2.ExecuteReader("select max(tztype) as tztype,max(tzteam) as tzteam,count(1) as orderno,isnull(sum(tzmoney),0) as summoney from ball_order where DATEDIFF(dd, GETDATE(), updatetime)=0  and ballid=" + set.Tables[0].Rows[4]["id"].ToString().Trim() + " group by ballid order by ballid desc");
                    }
                    if (reader2.Read())
                    {
                        string text10 = text2;
                        text2 = text10 + "<td align=center colspan='2' class=tznumer> <a href='tzinfo.aspx?gameid=" + set.Tables[0].Rows[4]["id"].ToString().Trim() + "&tztype=14&marker=C'>  <font color=#000088>" + double.Parse(reader2["summoney"].ToString()).ToString() + "</font></a></td> ";
                    }
                    else
                    {
                        text2 = text2 + "<td align=center colspan='2' class=tznumer>  <font color=#000088>0</font></a></td></tr> ";
                    }
                    reader2.Close();
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

        private void TopMenuProcess()
        {
            string ltype = "C";
            string retime = "-1";
            string strMethod = "bqc";
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
            this.Session.Contents["ABC"] = "0";
            string s = MyFunc.pintingAgenceMenu(ltype, retime, strMethod);
            base.Response.Write(s);
        }
    }
}

