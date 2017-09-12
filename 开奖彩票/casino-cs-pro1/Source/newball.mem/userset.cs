namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class userset : Page
    {
        protected HtmlTable BKTable;
        protected HtmlTable FTable;
        public string kygldlsid = "";
        public string kygluserid = "";
        protected Label LabelAdmin;
        protected Label LabelUser;

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
            else if (!base.IsPostBack)
            {
                this.LabelAdmin.Text = this.Session.Contents["adminusername"].ToString().Trim();
                if (((base.Request.Form["action"] != null) || (base.Request.QueryString["id"] == null)) || (base.Request.QueryString["id"].ToString().Trim() == ""))
                {
                    if ((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ffpost")) && ((base.Request.Form["id"] != null) && (base.Request.Form["id"].ToString().Trim() != ""))) && (((base.Request.Form["rtype"] != null) && (base.Request.Form["rtype"].ToString().Trim() != "")) && ((base.Request.Form["did"] != null) && (base.Request.Form["did"].ToString().Trim() != ""))))
                    {
                        this.Updatekygl(base.Request.Form["rtype"].ToString().Trim());
                    }
                    else
                    {
                        MyFunc.showmsg("出错了!");
                        base.Response.End();
                    }
                }
                else
                {
                    string text = "";
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    string sql = "";
                    sql = (((((sql + "SELECT member.ABC,member.userid,member.username,member.dlsid,") + "userhs.W1,userhs.W2,userhs.W3,userhs.W4,userhs.W5,userhs.W6,userhs.W7,userhs.W8,userhs.W9,userhs.W10,userhs.W11,userhs.W12,userhs.W13,userhs.W14,userhs.W15,userhs.W18,userhs.W19,userhs.W20,userhs.W21,userhs.W22,userhs.W23,userhs.W24,userhs.W28," + "userhs.L1,userhs.L2,userhs.L3,userhs.L4,userhs.L5,userhs.L6,userhs.L7,userhs.L8,userhs.L9,userhs.L10,userhs.L11,userhs.L12,userhs.L13,userhs.L14,userhs.L15,userhs.L18,userhs.L19,userhs.L20,userhs.L21,userhs.L22,userhs.L23,userhs.L24,userhs.L28,") + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11,userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXC15,userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC24,userhs.MAXC28," + "userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3,userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,userhs.MAXZ14,userhs.MAXZ15,userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ24,userhs.MAXZ28,") + "hs.W1 AS dlsw1,hs.W2 AS dlsw2,hs.W3 AS dlsw3,hs.W4 AS dlsw4,hs.W5 AS dlsw5,hs.W6 AS dlsw6,hs.W7 AS dlsw7,hs.W8 AS dlsw8,hs.W9 AS dlsw9,hs.W10 AS dlsw10,hs.W11 AS dlsw11,hs.W12 AS dlsw12,hs.W13 AS dlsw13,hs.W14 as dlsw14,hs.w15 as dlsw15,hs.w18 as dlsw18,hs.w19 as dlsw19,hs.w20 as dlsw20,hs.w21 as dlsw21,hs.w22 as dlsw22,hs.w23 as dlsw23,hs.w24 as dlsw24,hs.w28 as dlsw28," + "hs.L1 AS dlsl1,hs.L2 AS dlsl2,hs.L3 AS dlsl3,hs.L4 AS dlsl4,hs.L5 AS dlsl5,hs.L6 AS dlsl6,hs.L7 AS dlsl7,hs.L8 AS dlsl8,hs.L9 AS dlsl9,hs.L10 AS dlsl10,hs.L11 AS dlsl11,hs.L12 AS dlsl12,hs.L13 AS dlsl13,hs.l14 as dlsl14,hs.l15 as dlsl15,hs.l18 as dlsl18,hs.l19 as dlsl19,hs.l20 as dlsl20,hs.l21 as dlsl21,hs.l22 as dlsl22,hs.l23 as dlsl23,hs.l24 as dlsl24,hs.l28 as dlsl28 ") + " FROM userhs RIGHT OUTER JOIN " + "member LEFT OUTER JOIN hs ON member.dlsid = hs.userid AND member.ABC = hs.type ON ") + "userhs.userid = member.userid WHERE userhs.userid = " + base.Request.QueryString["id"].ToString().Trim();
                    SqlDataReader reader = base2.ExecuteReader(sql);
                    if (reader.Read())
                    {
                        this.LabelUser.Text = reader["username"].ToString().Trim();
                        this.kygluserid = reader["userid"].ToString().Trim();
                        this.kygldlsid = reader["dlsid"].ToString().Trim();
                        text = reader["abc"].ToString().Trim().ToUpper();
                        this.FTable.Rows[1].Cells[0].InnerHtml = text + "盘 W/L";
                        this.BKTable.Rows[1].Cells[0].InnerHtml = text + "盘 W/L";
                        this.FTable.Rows[1].Cells[1].InnerText = double.Parse(reader["W1"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L1"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[2].InnerText = double.Parse(reader["W2"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L2"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[3].InnerText = double.Parse(reader["W3"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L3"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[4].InnerText = double.Parse(reader["W4"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L4"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[5].InnerText = double.Parse(reader["W28"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L28"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[6].InnerText = double.Parse(reader["W5"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L5"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[7].InnerText = reader["W6"].ToString().Trim() + "/" + reader["L6"].ToString().Trim();
                        this.FTable.Rows[1].Cells[8].InnerText = reader["W7"].ToString().Trim() + "/" + reader["L7"].ToString().Trim();
                        this.FTable.Rows[1].Cells[9].InnerText = reader["W8"].ToString().Trim() + "/" + reader["L8"].ToString().Trim();
                        this.FTable.Rows[1].Cells[10].InnerText = reader["W9"].ToString().Trim() + "/" + reader["L9"].ToString().Trim();
                        this.FTable.Rows[1].Cells[11].InnerText = reader["W10"].ToString().Trim() + "/" + reader["L10"].ToString().Trim();
                        this.FTable.Rows[1].Cells[12].InnerText = reader["W11"].ToString().Trim() + "/" + reader["L11"].ToString().Trim();
                        this.FTable.Rows[1].Cells[13].InnerText = double.Parse(reader["W12"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L12"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[1].Cells[14].InnerText = double.Parse(reader["W13"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L13"].ToString().Trim()).ToString("F2");
                        this.BKTable.Rows[1].Cells[1].InnerText = double.Parse(reader["W18"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L18"].ToString().Trim()).ToString("F2");
                        this.BKTable.Rows[1].Cells[2].InnerText = double.Parse(reader["W19"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L19"].ToString().Trim()).ToString("F2");
                        this.BKTable.Rows[1].Cells[3].InnerText = double.Parse(reader["W20"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L20"].ToString().Trim()).ToString("F2");
                        this.BKTable.Rows[1].Cells[4].InnerText = reader["W21"].ToString().Trim() + "/" + reader["L21"].ToString().Trim();
                        this.BKTable.Rows[1].Cells[5].InnerText = double.Parse(reader["W22"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L22"].ToString().Trim()).ToString("F2");
                        this.BKTable.Rows[1].Cells[6].InnerText = double.Parse(reader["W23"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader["L23"].ToString().Trim()).ToString("F2");
                        this.FTable.Rows[2].Cells[1].InnerText = reader["MAXC1"].ToString().Trim();
                        this.FTable.Rows[2].Cells[2].InnerText = reader["MAXC2"].ToString().Trim();
                        this.FTable.Rows[2].Cells[3].InnerText = reader["MAXC3"].ToString().Trim();
                        this.FTable.Rows[2].Cells[4].InnerText = reader["MAXC4"].ToString().Trim();
                        this.FTable.Rows[2].Cells[5].InnerText = reader["MAXC28"].ToString().Trim();
                        this.FTable.Rows[2].Cells[6].InnerText = reader["MAXC5"].ToString().Trim();
                        this.FTable.Rows[2].Cells[7].InnerText = reader["MAXC6"].ToString().Trim();
                        this.FTable.Rows[2].Cells[8].InnerText = reader["MAXC7"].ToString().Trim();
                        this.FTable.Rows[2].Cells[9].InnerText = reader["MAXC8"].ToString().Trim();
                        this.FTable.Rows[2].Cells[10].InnerText = reader["MAXC9"].ToString().Trim();
                        this.FTable.Rows[2].Cells[11].InnerText = reader["MAXC10"].ToString().Trim();
                        this.FTable.Rows[2].Cells[12].InnerText = reader["MAXC11"].ToString().Trim();
                        this.FTable.Rows[2].Cells[13].InnerText = reader["MAXC12"].ToString().Trim();
                        this.FTable.Rows[2].Cells[14].InnerText = reader["MAXC13"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[1].InnerText = reader["MAXC18"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[2].InnerText = reader["MAXC19"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[3].InnerText = reader["MAXC20"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[4].InnerText = reader["MAXC21"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[5].InnerText = reader["MAXC22"].ToString().Trim();
                        this.BKTable.Rows[2].Cells[6].InnerText = reader["MAXC23"].ToString().Trim();
                        this.FTable.Rows[3].Cells[1].InnerText = reader["MAXZ1"].ToString().Trim();
                        this.FTable.Rows[3].Cells[2].InnerText = reader["MAXZ2"].ToString().Trim();
                        this.FTable.Rows[3].Cells[3].InnerText = reader["MAXZ3"].ToString().Trim();
                        this.FTable.Rows[3].Cells[4].InnerText = reader["MAXZ4"].ToString().Trim();
                        this.FTable.Rows[3].Cells[5].InnerText = reader["MAXZ28"].ToString().Trim();
                        this.FTable.Rows[3].Cells[6].InnerText = reader["MAXZ5"].ToString().Trim();
                        this.FTable.Rows[3].Cells[7].InnerText = reader["MAXZ6"].ToString().Trim();
                        this.FTable.Rows[3].Cells[8].InnerText = reader["MAXZ7"].ToString().Trim();
                        this.FTable.Rows[3].Cells[9].InnerText = reader["MAXZ8"].ToString().Trim();
                        this.FTable.Rows[3].Cells[10].InnerText = reader["MAXZ9"].ToString().Trim();
                        this.FTable.Rows[3].Cells[11].InnerText = reader["MAXZ10"].ToString().Trim();
                        this.FTable.Rows[3].Cells[12].InnerText = reader["MAXZ11"].ToString().Trim();
                        this.FTable.Rows[3].Cells[13].InnerText = reader["MAXZ12"].ToString().Trim();
                        this.FTable.Rows[3].Cells[14].InnerText = reader["MAXZ13"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[1].InnerText = reader["MAXZ18"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[2].InnerText = reader["MAXZ19"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[3].InnerText = reader["MAXZ20"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[4].InnerText = reader["MAXZ21"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[5].InnerText = reader["MAXZ22"].ToString().Trim();
                        this.BKTable.Rows[3].Cells[6].InnerText = reader["MAXZ23"].ToString().Trim();
                        this.FTable.Rows[4].Cells[1].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号','1','" + reader["MAXC1"].ToString().Trim() + "','" + reader["MAXZ1"].ToString().Trim() + "','" + reader["W1"].ToString().Trim() + "','" + reader["L1"].ToString().Trim() + "',0.25," + reader["dlsW1"].ToString().Trim() + "," + reader["dlsL1"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[2].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号单双','2','" + reader["MAXC2"].ToString().Trim() + "','" + reader["MAXZ2"].ToString().Trim() + "','" + reader["W2"].ToString().Trim() + "','" + reader["L2"].ToString().Trim() + "',0.25," + reader["dlsW2"].ToString().Trim() + "," + reader["dlsL2"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[3].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号大小','3','" + reader["MAXC3"].ToString().Trim() + "','" + reader["MAXZ3"].ToString().Trim() + "','" + reader["W3"].ToString().Trim() + "','" + reader["L3"].ToString().Trim() + "',0.25," + reader["dlsW3"].ToString().Trim() + "," + reader["dlsL3"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[4].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号合数单双','4','" + reader["MAXC4"].ToString().Trim() + "','" + reader["MAXZ4"].ToString().Trim() + "','" + reader["W4"].ToString().Trim() + "','" + reader["L4"].ToString().Trim() + "',0.25," + reader["dlsW4"].ToString().Trim() + "," + reader["dlsL4"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[5].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码','28','" + reader["MAXC28"].ToString().Trim() + "','" + reader["MAXZ28"].ToString().Trim() + "','" + reader["W28"].ToString().Trim() + "','" + reader["L28"].ToString().Trim() + "',0.25," + reader["dlsW28"].ToString().Trim() + "," + reader["dlsL28"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[6].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('总和单双','5','" + reader["MAXC5"].ToString().Trim() + "','" + reader["MAXZ5"].ToString().Trim() + "','" + reader["W5"].ToString().Trim() + "','" + reader["L5"].ToString().Trim() + "',0.25," + reader["dlsW5"].ToString().Trim() + "," + reader["dlsL5"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[7].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('总和大小','6','" + reader["MAXC6"].ToString().Trim() + "','" + reader["MAXZ6"].ToString().Trim() + "','" + reader["W6"].ToString().Trim() + "','" + reader["L6"].ToString().Trim() + "',0.25," + reader["dlsW6"].ToString().Trim() + "," + reader["dlsL6"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[8].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('二全中','7','" + reader["MAXC7"].ToString().Trim() + "','" + reader["MAXZ7"].ToString().Trim() + "','" + reader["W7"].ToString().Trim() + "','" + reader["L7"].ToString().Trim() + "',0.25," + reader["dlsW7"].ToString().Trim() + "," + reader["dlsL7"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[9].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('三全中','8','" + reader["MAXC8"].ToString().Trim() + "','" + reader["MAXZ8"].ToString().Trim() + "','" + reader["W8"].ToString().Trim() + "','" + reader["L8"].ToString().Trim() + "',0.25," + reader["dlsW8"].ToString().Trim() + "," + reader["dlsL8"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[10].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('三中二','9','" + reader["MAXC9"].ToString().Trim() + "','" + reader["MAXZ9"].ToString().Trim() + "','" + reader["W9"].ToString().Trim() + "','" + reader["L9"].ToString().Trim() + "',0.25," + reader["dlsW9"].ToString().Trim() + "," + reader["dlsL9"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[11].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('二中特','10','" + reader["MAXC10"].ToString().Trim() + "','" + reader["MAXZ10"].ToString().Trim() + "','" + reader["W10"].ToString().Trim() + "','" + reader["L10"].ToString().Trim() + "',0.25," + reader["dlsW10"].ToString().Trim() + "," + reader["dlsL10"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[12].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特串','11','" + reader["MAXC11"].ToString().Trim() + "','" + reader["MAXZ11"].ToString().Trim() + "','" + reader["W11"].ToString().Trim() + "','" + reader["L11"].ToString().Trim() + "',0.25," + reader["dlsW11"].ToString().Trim() + "," + reader["dlsL11"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[13].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码过关','12','" + reader["MAXC12"].ToString().Trim() + "','" + reader["MAXZ12"].ToString().Trim() + "','" + reader["W12"].ToString().Trim() + "','" + reader["L12"].ToString().Trim() + "',0.25," + reader["dlsW12"].ToString().Trim() + "," + reader["dlsL12"].ToString().Trim() + ");\">修改</span>";
                        this.FTable.Rows[4].Cells[14].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('色波','13','" + reader["MAXC13"].ToString().Trim() + "','" + reader["MAXZ13"].ToString().Trim() + "','" + reader["W13"].ToString().Trim() + "','" + reader["L13"].ToString().Trim() + "',0.25," + reader["dlsW13"].ToString().Trim() + "," + reader["dlsL13"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[1].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('生肖','18','" + reader["MAXC18"].ToString().Trim() + "','" + reader["MAXZ18"].ToString().Trim() + "','" + reader["W18"].ToString().Trim() + "','" + reader["L18"].ToString().Trim() + "',0.25," + reader["dlsW18"].ToString().Trim() + "," + reader["dlsL18"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[2].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6单双','19','" + reader["MAXC19"].ToString().Trim() + "','" + reader["MAXZ19"].ToString().Trim() + "','" + reader["W19"].ToString().Trim() + "','" + reader["L19"].ToString().Trim() + "',0.25," + reader["dlsW19"].ToString().Trim() + "," + reader["dlsL19"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[3].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6大小','20','" + reader["MAXC20"].ToString().Trim() + "','" + reader["MAXZ20"].ToString().Trim() + "','" + reader["W20"].ToString().Trim() + "','" + reader["L20"].ToString().Trim() + "',0.25," + reader["dlsW20"].ToString().Trim() + "," + reader["dlsL20"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[4].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6色波','21','" + reader["MAXC21"].ToString().Trim() + "','" + reader["MAXZ21"].ToString().Trim() + "','" + reader["W21"].ToString().Trim() + "','" + reader["L21"].ToString().Trim() + "',0.25," + reader["dlsW21"].ToString().Trim() + "," + reader["dlsL21"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[5].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('一肖','22','" + reader["MAXC22"].ToString().Trim() + "','" + reader["MAXZ22"].ToString().Trim() + "','" + reader["W22"].ToString().Trim() + "','" + reader["L22"].ToString().Trim() + "',0.25," + reader["dlsW22"].ToString().Trim() + "," + reader["dlsL22"].ToString().Trim() + ");\">修改</span>";
                        this.BKTable.Rows[4].Cells[6].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('六肖','23','" + reader["MAXC23"].ToString().Trim() + "','" + reader["MAXZ23"].ToString().Trim() + "','" + reader["W23"].ToString().Trim() + "','" + reader["L23"].ToString().Trim() + "',0.25," + reader["dlsW23"].ToString().Trim() + "," + reader["dlsL23"].ToString().Trim() + ");\">修改</span>";
                        reader.Close();
                        int num = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=1").ToString());
                        int num2 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=0").ToString());
                        base2.Dispose();
                        this.DataBind();
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("没有该会员! ");
                    }
                }
            }
        }

        private void Updatekygl(string type)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else if ((((base.Request.Form["war_set_w"] != null) && (base.Request.Form["war_set_l"] != null)) && (((base.Request.Form["SC"] != null) & (base.Request.Form["SO"] != null)) && (base.Request.Form["id"] != null))) && (((base.Request.Form["id"].ToString().Trim() != "") && (base.Request.Form["did"] != null)) && (base.Request.Form["did"].ToString().Trim() != "")))
            {
                string sql = "";
                string text2 = "";
                string text3 = MyFunc.DefaultValue(base.Request.Form["war_set_w"].ToString().Trim(), "0");
                string text4 = MyFunc.DefaultValue(base.Request.Form["war_set_l"].ToString().Trim(), "0");
                string s = MyFunc.DefaultValue(base.Request.Form["SC"].ToString().Trim(), "0");
                string text6 = MyFunc.DefaultValue(base.Request.Form["SO"].ToString().Trim(), "0");
                string text7 = base.Request.Form["id"].ToString().Trim();
                string text8 = base.Request.Form["did"].ToString().Trim();
                switch (type)
                {
                    case "1":
                        sql = "UPDATE userhs SET W1=" + text3 + ",L1=" + text4 + ",MAXC1=" + s + ",MAXZ1=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc1,maxz1 FROM agence WHERE userid=" + text8;
                        break;

                    case "2":
                        sql = "UPDATE userhs SET W2=" + text3 + ",L2=" + text4 + ",MAXC2=" + s + ",MAXZ2=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc2,maxz2 FROM agence WHERE userid=" + text8;
                        break;

                    case "3":
                        sql = "UPDATE userhs SET W3=" + text3 + ",L3=" + text4 + ",MAXC3=" + s + ",MAXZ3=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc3,maxz3 FROM agence WHERE userid=" + text8;
                        break;

                    case "4":
                        sql = "UPDATE userhs SET W4=" + text3 + ",L4=" + text4 + ",MAXC4=" + s + ",MAXZ4=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc4,maxz4 FROM agence WHERE userid=" + text8;
                        break;

                    case "5":
                        sql = "UPDATE userhs SET W5=" + text3 + ",L5=" + text4 + ",MAXC5=" + s + ",MAXZ5=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc5,maxz5 FROM agence WHERE userid=" + text8;
                        break;

                    case "6":
                        sql = "UPDATE userhs SET W6=" + text3 + ",L6=" + text4 + ",MAXC6=" + s + ",MAXZ6=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc6,maxz6 FROM agence WHERE userid=" + text8;
                        break;

                    case "7":
                        sql = "UPDATE userhs SET W7=" + text3 + ",L7=" + text4 + ",MAXC7=" + s + ",MAXZ7=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc7,maxz7 FROM agence WHERE userid=" + text8;
                        break;

                    case "8":
                        sql = "UPDATE userhs SET W8=" + text3 + ",L8=" + text4 + ",MAXC8=" + s + ",MAXZ8=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc8,maxz8 FROM agence WHERE userid=" + text8;
                        break;

                    case "9":
                        sql = "UPDATE userhs SET W9=" + text3 + ",L9=" + text4 + ",MAXC9=" + s + ",MAXZ9=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc9,maxz9 FROM agence WHERE userid=" + text8;
                        break;

                    case "10":
                        sql = "UPDATE userhs SET W10=" + text3 + ",L10=" + text4 + ",MAXC10=" + s + ",MAXZ10=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc10,maxz10 FROM agence WHERE userid=" + text8;
                        break;

                    case "11":
                        sql = "UPDATE userhs SET W11=" + text3 + ",L11=" + text4 + ",MAXC11=" + s + ",MAXZ11=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc11,maxz11 FROM agence WHERE userid=" + text8;
                        break;

                    case "12":
                        sql = "UPDATE userhs SET W12=" + text3 + ",L12=" + text4 + ",MAXC12=" + s + ",MAXZ12=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc12,maxz12 FROM agence WHERE userid=" + text8;
                        break;

                    case "13":
                        sql = "UPDATE userhs SET W13=" + text3 + ",L13=" + text4 + ",MAXC13=" + s + ",MAXZ13=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc13,maxz13 FROM agence WHERE userid=" + text8;
                        break;

                    case "16":
                        sql = "UPDATE userhs SET W14=" + text3 + ",L14=" + text4 + ",MAXC14=" + s + ",MAXZ14=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc14,maxz14 FROM agence WHERE userid=" + text8;
                        break;

                    case "17":
                        sql = "UPDATE userhs SET W15=" + text3 + ",L15=" + text4 + ",MAXC15=" + s + ",MAXZ15=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc15,maxz15 FROM agence WHERE userid=" + text8;
                        break;

                    case "18":
                        sql = "UPDATE userhs SET W18=" + text3 + ",L18=" + text4 + ",MAXC18=" + s + ",MAXZ18=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc18,maxz18 FROM agence WHERE userid=" + text8;
                        break;

                    case "19":
                        sql = "UPDATE userhs SET W19=" + text3 + ",L19=" + text4 + ",MAXC19=" + s + ",MAXZ19=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc19,maxz19 FROM agence WHERE userid=" + text8;
                        break;

                    case "20":
                        sql = "UPDATE userhs SET W20=" + text3 + ",L20=" + text4 + ",MAXC20=" + s + ",MAXZ20=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc20,maxz20 FROM agence WHERE userid=" + text8;
                        break;

                    case "21":
                        sql = "UPDATE userhs SET W21=" + text3 + ",L21=" + text4 + ",MAXC21=" + s + ",MAXZ21=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc21,maxz21 FROM agence WHERE userid=" + text8;
                        break;

                    case "22":
                        sql = "UPDATE userhs SET W22=" + text3 + ",L22=" + text4 + ",MAXC22=" + s + ",MAXZ22=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc22,maxz22 FROM agence WHERE userid=" + text8;
                        break;

                    case "23":
                        sql = "UPDATE userhs SET W23=" + text3 + ",L23=" + text4 + ",MAXC23=" + s + ",MAXZ23=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc23,maxz23 FROM agence WHERE userid=" + text8;
                        break;

                    case "24":
                        sql = "UPDATE userhs SET W24=" + text3 + ",L24=" + text4 + ",MAXC24=" + s + ",MAXZ24=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc24,maxz24 FROM agence WHERE userid=" + text8;
                        break;

                    case "28":
                        sql = "UPDATE userhs SET W28=" + text3 + ",L28=" + text4 + ",MAXC28=" + s + ",MAXZ28=" + text6 + " WHERE userid=" + text7;
                        text2 = "SELECT Maxc28,maxz28 FROM agence WHERE userid=" + text8;
                        break;
                }
                if (sql != "")
                {
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    int num = 0;
                    int num2 = 0;
                    SqlDataReader reader = base2.ExecuteReader(text2);
                    if (reader.Read())
                    {
                        num = int.Parse(reader[0].ToString().Trim());
                        num2 = int.Parse(reader[1].ToString().Trim());
                    }
                    reader.Close();
                    if ((num < ((int) float.Parse(s))) || (num2 < ((int) float.Parse(text6))))
                    {
                        base2.Dispose();
                        MyFunc.showmsg("单场限额或单注限额不能大于代理商的单场限额或单注限额");
                        base.Response.End();
                    }
                    else
                    {
                        SqlDataReader reader2 = base2.ExecuteReader("SELECT usemoney FROM member WHERE userid=" + text7);
                        if (!reader2.Read())
                        {
                            reader2.Close();
                            base2.Dispose();
                            MyFunc.showmsg("没有该会员");
                            base.Response.End();
                        }
                        else
                        {
                            int num3 = (int) float.Parse(reader2["usemoney"].ToString().Trim());
                            reader2.Close();
                            int num4 = (int) float.Parse(s);
                            int num5 = (int) float.Parse(text6);
                            if (num4 > num3)
                            {
                                base2.Dispose();
                                MyFunc.showmsg("单场限额不能大于信用额");
                                base.Response.End();
                            }
                            else if (num5 > num4)
                            {
                                base2.Dispose();
                                MyFunc.showmsg("单注限额不能大于单场限额");
                                base.Response.End();
                            }
                            else
                            {
                                base2.ExecuteNonQuery(sql);
                                base2.Dispose();
                                base.Response.Redirect("userset.aspx?id=" + text7 + "&did=" + text8);
                            }
                        }
                    }
                }
            }
        }
    }
}

