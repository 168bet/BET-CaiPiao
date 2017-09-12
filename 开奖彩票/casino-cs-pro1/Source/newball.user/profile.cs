namespace newball.user
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class profile : Page
    {
        public string msg = "";
        protected HtmlTable TABLE1;
        protected HtmlTable TABLE2;
        protected HtmlTable TABLE3;

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
            if (!MyFunc.CheckUserLogin(0) || !MyTeam.OnlineList.OnlineList.isUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                string sql = "SELECT member.userid,member.username,member.truename,member.ABC,member.curMoney,member.MoneySort,member.usemoney,member.usertype,";
                sql = ((((sql + "userhs.MAXC1,userhs.MAXC2,userhs.MAXC3,userhs.MAXC4,userhs.MAXC5,userhs.MAXC6,userhs.MAXC7,userhs.MAXC8,userhs.MAXC9,userhs.MAXC10,userhs.MAXC11,userhs.MAXC12,userhs.MAXC13,userhs.MAXC14,userhs.MAXZ14,userhs.MAXC15,userhs.MAXZ15,userhs.MAXZ1,userhs.MAXZ2,userhs.MAXZ3," + "userhs.MAXZ4,userhs.MAXZ5,userhs.MAXZ6,userhs.MAXZ7,userhs.MAXZ8,userhs.MAXZ9,userhs.MAXZ10,userhs.MAXZ11,userhs.MAXZ12,userhs.MAXZ13,") + "userhs.MAXZ18,userhs.MAXZ19,userhs.MAXZ20,userhs.MAXZ21,userhs.MAXZ22,userhs.MAXZ23,userhs.MAXZ24,userhs.MAXZ28," + "userhs.MAXC18,userhs.MAXC19,userhs.MAXC20,userhs.MAXC21,userhs.MAXC22,userhs.MAXC23,userhs.MAXC24,userhs.MAXC28,") + "userhs.w1,userhs.w2,userhs.w3,userhs.w4,userhs.w5,userhs.w6,userhs.w7,userhs.w8,userhs.w9,userhs.w10,userhs.w11," + "userhs.w12,userhs.w13,userhs.w18,userhs.w19,w20,w21,w22,userhs.w23,userhs.w28,") + "userhs.l1,userhs.l2,userhs.l3,userhs.l4,userhs.l5,userhs.l6,userhs.l7,userhs.l8,userhs.l9,userhs.l10,userhs.l11," + "userhs.l12,userhs.l13,userhs.l18,userhs.l19,l20,l21,l22,userhs.l23,userhs.l28") + " FROM member LEFT OUTER JOIN userhs ON member.userid = userhs.userid WHERE member.userid=" + this.Session.Contents["userid"].ToString().Trim();
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=1 ORDER BY updatetime DESC");
                this.msg = "<div class=hover>";
                while (reader.Read())
                {
                    this.msg = this.msg + reader["content"].ToString().Trim();
                }
                this.msg = this.msg + "</div>";
                reader.Close();
                SqlDataReader reader2 = base2.ExecuteReader(sql);
                if (reader2.Read())
                {
                    string text2 = reader2["moneysort"].ToString().Trim().ToUpper();
                    this.TABLE1.Rows[0].Cells[1].InnerHtml = reader2["username"].ToString().Trim();
                    this.TABLE1.Rows[1].Cells[1].InnerHtml = reader2["truename"].ToString().Trim();
                    this.TABLE1.Rows[2].Cells[1].InnerHtml = reader2["abc"].ToString().Trim();
                    this.TABLE1.Rows[3].Cells[1].InnerHtml = reader2["usertype"].ToString().Trim();
                    this.TABLE1.Rows[4].Cells[1].InnerHtml = reader2["usemoney"].ToString().Trim();
                    this.TABLE1.Rows[5].Cells[1].InnerHtml = reader2["curmoney"].ToString().Trim();
                    this.TABLE2.Rows[2].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w1"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l1"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[3].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w2"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l2"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[4].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w3"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l3"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[5].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w4"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l4"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[6].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w28"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l28"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[7].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w5"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l5"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[8].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w6"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l6"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[9].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w7"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l7"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[10].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w8"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l8"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[11].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w9"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l9"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[12].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w10"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l10"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[13].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w11"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l11"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[14].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w12"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l12"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[15].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w13"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l13"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[0x10].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w18"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l18"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[0x11].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w19"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l19"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[0x12].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w20"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l20"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[0x13].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w21"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l21"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[20].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w22"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l22"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[0x15].Cells[1].InnerHtml = text2 + " " + double.Parse(reader2["w23"].ToString()).ToString().Trim() + "/" + double.Parse(reader2["l23"].ToString()).ToString().Trim();
                    this.TABLE2.Rows[2].Cells[2].InnerHtml = text2 + " " + reader2["maxc1"].ToString().Trim();
                    this.TABLE2.Rows[3].Cells[2].InnerHtml = text2 + " " + reader2["maxc2"].ToString().Trim();
                    this.TABLE2.Rows[4].Cells[2].InnerHtml = text2 + " " + reader2["maxc3"].ToString().Trim();
                    this.TABLE2.Rows[5].Cells[2].InnerHtml = text2 + " " + reader2["maxc4"].ToString().Trim();
                    this.TABLE2.Rows[6].Cells[2].InnerHtml = text2 + " " + reader2["maxc28"].ToString().Trim();
                    this.TABLE2.Rows[7].Cells[2].InnerHtml = text2 + " " + reader2["maxc5"].ToString().Trim();
                    this.TABLE2.Rows[8].Cells[2].InnerHtml = text2 + " " + reader2["maxc6"].ToString().Trim();
                    this.TABLE2.Rows[9].Cells[2].InnerHtml = text2 + " " + reader2["maxc7"].ToString().Trim();
                    this.TABLE2.Rows[10].Cells[2].InnerHtml = text2 + " " + reader2["maxc8"].ToString().Trim();
                    this.TABLE2.Rows[11].Cells[2].InnerHtml = text2 + " " + reader2["maxc9"].ToString().Trim();
                    this.TABLE2.Rows[12].Cells[2].InnerHtml = text2 + " " + reader2["maxc10"].ToString().Trim();
                    this.TABLE2.Rows[13].Cells[2].InnerHtml = text2 + " " + reader2["maxc11"].ToString().Trim();
                    this.TABLE2.Rows[14].Cells[2].InnerHtml = text2 + " " + reader2["maxc12"].ToString().Trim();
                    this.TABLE2.Rows[15].Cells[2].InnerHtml = text2 + " " + reader2["maxc13"].ToString().Trim();
                    this.TABLE2.Rows[0x10].Cells[2].InnerHtml = text2 + " " + reader2["maxc18"].ToString().Trim();
                    this.TABLE2.Rows[0x11].Cells[2].InnerHtml = text2 + " " + reader2["maxc19"].ToString().Trim();
                    this.TABLE2.Rows[0x12].Cells[2].InnerHtml = text2 + " " + reader2["maxc20"].ToString().Trim();
                    this.TABLE2.Rows[0x13].Cells[2].InnerHtml = text2 + " " + reader2["maxc21"].ToString().Trim();
                    this.TABLE2.Rows[20].Cells[2].InnerHtml = text2 + " " + reader2["maxc22"].ToString().Trim();
                    this.TABLE2.Rows[0x15].Cells[2].InnerHtml = text2 + " " + reader2["maxc23"].ToString().Trim();
                    this.TABLE2.Rows[2].Cells[3].InnerHtml = text2 + " " + reader2["maxz1"].ToString().Trim();
                    this.TABLE2.Rows[3].Cells[3].InnerHtml = text2 + " " + reader2["maxz2"].ToString().Trim();
                    this.TABLE2.Rows[4].Cells[3].InnerHtml = text2 + " " + reader2["maxz3"].ToString().Trim();
                    this.TABLE2.Rows[5].Cells[3].InnerHtml = text2 + " " + reader2["maxz4"].ToString().Trim();
                    this.TABLE2.Rows[6].Cells[3].InnerHtml = text2 + " " + reader2["maxz28"].ToString().Trim();
                    this.TABLE2.Rows[7].Cells[3].InnerHtml = text2 + " " + reader2["maxz5"].ToString().Trim();
                    this.TABLE2.Rows[8].Cells[3].InnerHtml = text2 + " " + reader2["maxz6"].ToString().Trim();
                    this.TABLE2.Rows[9].Cells[3].InnerHtml = text2 + " " + reader2["maxz7"].ToString().Trim();
                    this.TABLE2.Rows[10].Cells[3].InnerHtml = text2 + " " + reader2["maxz8"].ToString().Trim();
                    this.TABLE2.Rows[11].Cells[3].InnerHtml = text2 + " " + reader2["maxz9"].ToString().Trim();
                    this.TABLE2.Rows[12].Cells[3].InnerHtml = text2 + " " + reader2["maxz10"].ToString().Trim();
                    this.TABLE2.Rows[13].Cells[3].InnerHtml = text2 + " " + reader2["maxz11"].ToString().Trim();
                    this.TABLE2.Rows[14].Cells[3].InnerHtml = text2 + " " + reader2["maxz12"].ToString().Trim();
                    this.TABLE2.Rows[15].Cells[3].InnerHtml = text2 + " " + reader2["maxz13"].ToString().Trim();
                    this.TABLE2.Rows[0x10].Cells[3].InnerHtml = text2 + " " + reader2["maxz18"].ToString().Trim();
                    this.TABLE2.Rows[0x11].Cells[3].InnerHtml = text2 + " " + reader2["maxz19"].ToString().Trim();
                    this.TABLE2.Rows[0x12].Cells[3].InnerHtml = text2 + " " + reader2["maxz20"].ToString().Trim();
                    this.TABLE2.Rows[0x13].Cells[3].InnerHtml = text2 + " " + reader2["maxz21"].ToString().Trim();
                    this.TABLE2.Rows[20].Cells[3].InnerHtml = text2 + " " + reader2["maxz22"].ToString().Trim();
                    this.TABLE2.Rows[0x15].Cells[3].InnerHtml = text2 + " " + reader2["maxz23"].ToString().Trim();
                    reader2.Close();
                    base2.Dispose();
                    this.DataBind();
                }
                else
                {
                    reader2.Close();
                    base2.Dispose();
                    MyFunc.goToLoginPage();
                    base.Response.End();
                }
            }
        }
    }
}

