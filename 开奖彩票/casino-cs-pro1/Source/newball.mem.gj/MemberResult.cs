namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class MemberResult : Page
    {
        public string kyglContent1 = "";
        public string kyglContent2 = "";
        public string kyglContent3 = "";

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
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if (((base.Request.QueryString["userid"] != null) && (base.Request.QueryString["userid"].ToString().Trim() != "")) && ((base.Request.QueryString["flag"] != null) && (base.Request.QueryString["flag"].ToString().Trim() != "")))
                {
                    string text = base.Request.QueryString["userid"].ToString().Trim().Replace(" ", "").Replace("'", "");
                    string text2 = base.Request.QueryString["flag"].ToString().Trim().Replace(" ", "").Replace("'", "");
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    double num = double.Parse(base2.ExecuteScalar("SELECT SUM(tzmoney) FROM ball_order WHERE userid=" + text + " AND Datediff(day,balltime,GetDate())=0").ToString());
                    SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,usemoney,curmoney,(usemoney-curmoney) AS smoney FROM member WHERE userid=" + text);
                    reader.Read();
                    this.kyglContent1 = "会员 <a href=../userlist_reportlist.aspx?userid=" + reader["userid"].ToString().Trim() + "&username=" + reader["username"].ToString().Trim() + ">" + reader["username"].ToString().Trim() + "</a> &nbsp;总信用度 " + reader["usemoney"].ToString().Trim() + " &nbsp;下注 " + reader["smoney"].ToString().Trim() + " &nbsp; 余额 " + reader["curmoney"].ToString().Trim() + "&nbsp;";
                    this.kyglContent1 = this.kyglContent1 + ((text2 == "1") ? "正常" : string.Concat(new string[5]));
                    reader.Close();
                    reader = base2.ExecuteReader("SELECT orderid,updatetime,balltime,content,tztype,tzmoney,ISNULL((win-lose),0) as tzresult,iscancel FROM ball_order WHERE userid=" + text + " AND datediff(day,balltime,GetDate())=0 AND isjs=1 ORDER BY updatetime");
                    double num2 = 0;
                    double num3 = 0;
                    while (reader.Read())
                    {
                        double num4 = double.Parse(reader["tzresult"].ToString().Trim());
                        num3 += num4;
                        double num5 = double.Parse(reader["tzmoney"].ToString().Trim());
                        num2 += num5;
                        string text3 = this.kyglContent2;
                        this.kyglContent2 = text3 + "<tr bgcolor=#ffffff><td align=center>" + DateTime.Parse(reader["updatetime"].ToString()).ToString("yy-MM-dd<br>HH:mm:ss") + "</td><td align=center>" + MyFunc.GettzTypeName(reader["tztype"].ToString().Trim()) + "<br>" + reader["orderid"].ToString().Trim() + "</td><td align=right>" + reader["content"].ToString().Trim() + "</td><td align=right>" + num5.ToString("F0") + "</td>";
                        if ((reader["iscancel"].ToString().Trim().ToUpper() == "TRUE") && (num5 == 0))
                        {
                            this.kyglContent2 = this.kyglContent2 + "<td align=center><font color=red>危险球<br>取消</font></td></tr>";
                        }
                        else
                        {
                            if (reader["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                            {
                                this.kyglContent2 = this.kyglContent2 + "<td align=center><font color=red>取消</font></td></tr>";
                                continue;
                            }
                            this.kyglContent2 = this.kyglContent2 + "<td align=right>" + num4.ToString("F2") + "</td></tr>";
                        }
                    }
                    reader.Close();
                    string text4 = this.kyglContent2;
                    this.kyglContent2 = text4 + "<tr class=sum bgcolor=#ffffff><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>" + num2.ToString("F0") + "</td><td>" + num3.ToString("F2") + "</td></tr>";
                    reader = base2.ExecuteReader("SELECT orderid,updatetime,balltime,content,tztype,tzmoney,ISNULL(tzmoney*curpl,0) as tzresult,iscancel FROM ball_order WHERE userid=" + text + " AND datediff(day,balltime,GetDate())=0 AND isjs=0 ORDER BY updatetime");
                    double num6 = 0;
                    double num7 = 0;
                    while (reader.Read())
                    {
                        double num8 = double.Parse(reader["tzresult"].ToString().Trim());
                        num7 += num8;
                        double num9 = double.Parse(reader["tzmoney"].ToString().Trim());
                        num6 += num9;
                        string text5 = this.kyglContent3;
                        this.kyglContent3 = text5 + "<tr bgcolor=#ffffff><td align=center>" + DateTime.Parse(reader["updatetime"].ToString()).ToString("yy-MM-dd<br>HH:mm:ss") + "</td><td align=center>" + MyFunc.GettzTypeName(reader["tztype"].ToString().Trim()) + "<br>" + reader["orderid"].ToString().Trim() + "</td><td align=right>" + reader["content"].ToString().Trim() + "</td><td align=right>" + num9.ToString("F0") + "</td>";
                        if ((reader["iscancel"].ToString().Trim().ToUpper() == "TRUE") && (num9 == 0))
                        {
                            this.kyglContent3 = this.kyglContent3 + "<td align=center><font color=red>危险球<br>取消</font></td></tr>";
                        }
                        else
                        {
                            if (reader["iscancel"].ToString().Trim().ToUpper() == "TRUE")
                            {
                                this.kyglContent3 = this.kyglContent3 + "<td align=center><font color=red>取消</font></td></tr>";
                                continue;
                            }
                            this.kyglContent3 = this.kyglContent3 + "<td align=right>" + num8.ToString("F2") + "</td></tr>";
                        }
                    }
                    reader.Close();
                    string text6 = this.kyglContent3;
                    this.kyglContent3 = text6 + "<tr class=sum bgcolor=#ffffff><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>" + num6.ToString("F0") + "</td><td>" + num7.ToString("F2") + "</td></tr>";
                    base2.Dispose();
                }
                this.DataBind();
            }
        }
    }
}

