namespace newball.zdl
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class mysetting : Page
    {
        protected HtmlTable BKTable;
        protected HtmlTable myFootballTable;
        protected Label username;

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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.setTableLists();
            }
        }

        private void setTableLists()
        {
            string sql = "";
            double num = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            this.username.Text = this.Session["adminusername"].ToString();
            SqlDataReader reader = base2.ExecuteReader("select isnull(sum(usemoney),0) as usemoney from member where dlsid = '" + this.Session["adminuserid"].ToString() + "'");
            if (reader.Read())
            {
                num = Convert.ToDouble(reader["usemoney"]);
            }
            reader.Close();
            sql = "SELECT Ag.Usemoney,Ag.MaxC1,Ag.MaxC2,Ag.MaxC3,Ag.MaxC4,Ag.MaxC5,Ag.MaxC6,Ag.MaxC7,Ag.MaxC8,Ag.MaxC9,Ag.MaxC10,Ag.MaxC11,Ag.MaxC12,Ag.MaxC13,Ag.MaxC18,Ag.MaxC19,Ag.MaxC20,Ag.MaxC21,Ag.MaxC22,Ag.MaxC23,Ag.MaxC24,Ag.MaxC28,Ag.MaxZ1,Ag.MaxZ2,Ag.MaxZ3,Ag.MaxZ4,Ag.MaxZ5,Ag.MaxZ6,Ag.MaxZ7,Ag.MaxZ8,Ag.MaxZ9,Ag.MaxZ10,Ag.MaxZ11,Ag.MaxZ12,Ag.MaxZ13,Ag.MaxZ28,Ag.MaxZ18,Ag.MaxZ19,Ag.MaxZ20,Ag.MaxZ21,Ag.MaxZ22,Ag.MaxZ23,Ag.MaxZ24,";
            string text2 = sql;
            sql = text2 + "hs.W1,hs.W2,hs.W3,hs.W4,hs.W5,hs.W6,hs.W7,hs.W8,hs.W9,hs.W10,hs.W11,hs.W12,hs.W13,hs.W18,hs.W19,hs.W20,hs.W21,hs.W22,hs.W23,hs.W24,hs.W28,hs.L1,hs.L2,hs.L3,hs.L4,hs.L5,hs.L6,hs.L7,hs.L8,hs.L9,hs.L10,hs.L11,hs.L12,hs.L13,hs.L18,hs.L19,hs.L20,hs.L21,hs.L22,hs.L23,hs.L24,hs.L28,hs.type FROM Agence as Ag JOIN hs ON hs.userid = Ag.userid WHERE Ag.userid ='" + this.Session["adminuserid"].ToString() + "' AND Ag.classid = '" + this.Session["adminclassid"].ToString() + "'";
            reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                string str = reader["type"].ToString().ToUpper();
                if (str == null)
                {
                    break;
                }
                str = string.IsInterned(str);
                if (str == "A")
                {
                    HtmlTableCell cell1 = this.myFootballTable.Rows[0].Cells[0];
                    cell1.InnerHtml = cell1.InnerHtml + reader["Usemoney"].ToString();
                    HtmlTableCell cell2 = this.myFootballTable.Rows[0].Cells[0];
                    cell2.InnerHtml = cell2.InnerHtml + "&nbsp;&nbsp;已用额度：";
                    HtmlTableCell cell3 = this.myFootballTable.Rows[0].Cells[0];
                    cell3.InnerHtml = cell3.InnerHtml + num.ToString("F0");
                    HtmlTableCell cell4 = this.myFootballTable.Rows[0].Cells[0];
                    cell4.InnerHtml = cell4.InnerHtml + "&nbsp;&nbsp;剩余额度：";
                    HtmlTableCell cell5 = this.myFootballTable.Rows[0].Cells[0];
                    cell5.InnerHtml = cell5.InnerHtml + ((Convert.ToDouble(reader["Usemoney"]) - num)).ToString("F0");
                    this.myFootballTable.Rows[2].Cells[1].InnerHtml = reader["MaxZ1"].ToString();
                    this.myFootballTable.Rows[2].Cells[2].InnerHtml = reader["MaxZ2"].ToString();
                    this.myFootballTable.Rows[2].Cells[3].InnerHtml = reader["MaxZ3"].ToString();
                    this.myFootballTable.Rows[2].Cells[4].InnerHtml = reader["MaxZ4"].ToString();
                    this.myFootballTable.Rows[2].Cells[5].InnerHtml = reader["MaxZ28"].ToString();
                    this.myFootballTable.Rows[2].Cells[6].InnerHtml = reader["MaxZ5"].ToString();
                    this.myFootballTable.Rows[2].Cells[7].InnerHtml = reader["MaxZ6"].ToString();
                    this.myFootballTable.Rows[2].Cells[8].InnerHtml = reader["MaxZ7"].ToString();
                    this.myFootballTable.Rows[2].Cells[9].InnerHtml = reader["MaxZ8"].ToString();
                    this.myFootballTable.Rows[2].Cells[10].InnerHtml = reader["MaxZ9"].ToString();
                    this.myFootballTable.Rows[2].Cells[11].InnerHtml = reader["MaxZ10"].ToString();
                    this.myFootballTable.Rows[2].Cells[12].InnerHtml = reader["MaxZ11"].ToString();
                    this.myFootballTable.Rows[2].Cells[13].InnerHtml = reader["MaxZ12"].ToString();
                    this.myFootballTable.Rows[2].Cells[14].InnerHtml = reader["MaxZ13"].ToString();
                    this.BKTable.Rows[1].Cells[1].InnerHtml = reader["MaxC18"].ToString().Trim();
                    this.BKTable.Rows[1].Cells[2].InnerHtml = reader["MaxC19"].ToString().Trim();
                    this.BKTable.Rows[1].Cells[3].InnerHtml = reader["MaxC20"].ToString().Trim();
                    this.BKTable.Rows[1].Cells[4].InnerHtml = reader["MaxC21"].ToString().Trim();
                    this.BKTable.Rows[1].Cells[5].InnerHtml = reader["MaxC22"].ToString().Trim();
                    this.BKTable.Rows[1].Cells[6].InnerHtml = reader["MaxC23"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[1].InnerHtml = reader["MaxZ18"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[2].InnerHtml = reader["MaxZ19"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[3].InnerHtml = reader["MaxZ20"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[4].InnerHtml = reader["MaxZ21"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[5].InnerHtml = reader["MaxZ22"].ToString().Trim();
                    this.BKTable.Rows[2].Cells[6].InnerHtml = reader["MaxZ23"].ToString().Trim();
                    this.myFootballTable.Rows[4].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W1"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L1"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W2"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L2"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W3"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L3"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W4"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L4"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W28"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L28"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W5"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L5"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[7].InnerHtml = "<font color=#aa0000>" + reader["W6"].ToString() + "</font>/<font color=darkblue>" + reader["L6"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[8].InnerHtml = "<font color=#aa0000>" + reader["W7"].ToString() + "</font>/<font color=darkblue>" + reader["L7"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[9].InnerHtml = "<font color=#aa0000>" + reader["W8"].ToString() + "</font>/<font color=darkblue>" + reader["L8"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[10].InnerHtml = "<font color=#aa0000>" + reader["W9"].ToString() + "</font>/<font color=darkblue>" + reader["L9"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[11].InnerHtml = "<font color=#aa0000>" + reader["W10"].ToString() + "</font>/<font color=darkblue>" + reader["L10"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[12].InnerHtml = "<font color=#aa0000>" + reader["W11"].ToString() + "</font>/<font color=darkblue>" + reader["L11"].ToString() + "</font>";
                    this.myFootballTable.Rows[4].Cells[13].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W12"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L12"].ToString()) + "</font>";
                    this.myFootballTable.Rows[4].Cells[14].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W13"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L13"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W18"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L18"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W19"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L19"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W20"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L20"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W21"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L21"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W22"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L22"].ToString()) + "</font>";
                    this.BKTable.Rows[3].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W23"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L23"].ToString()) + "</font>";
                }
                else
                {
                    if (str == "B")
                    {
                        this.myFootballTable.Rows[3].Cells[1].InnerHtml = reader["MaxC1"].ToString();
                        this.myFootballTable.Rows[3].Cells[2].InnerHtml = reader["MaxC2"].ToString();
                        this.myFootballTable.Rows[3].Cells[3].InnerHtml = reader["MaxC3"].ToString();
                        this.myFootballTable.Rows[3].Cells[4].InnerHtml = reader["MaxC4"].ToString();
                        this.myFootballTable.Rows[3].Cells[5].InnerHtml = reader["MaxC28"].ToString();
                        this.myFootballTable.Rows[3].Cells[6].InnerHtml = reader["MaxC5"].ToString();
                        this.myFootballTable.Rows[3].Cells[7].InnerHtml = reader["MaxC6"].ToString();
                        this.myFootballTable.Rows[3].Cells[8].InnerHtml = reader["MaxC7"].ToString();
                        this.myFootballTable.Rows[3].Cells[9].InnerHtml = reader["MaxC8"].ToString();
                        this.myFootballTable.Rows[3].Cells[10].InnerHtml = reader["MaxC9"].ToString();
                        this.myFootballTable.Rows[3].Cells[11].InnerHtml = reader["MaxC10"].ToString();
                        this.myFootballTable.Rows[3].Cells[12].InnerHtml = reader["MaxC11"].ToString();
                        this.myFootballTable.Rows[3].Cells[13].InnerHtml = reader["MaxC12"].ToString();
                        this.myFootballTable.Rows[3].Cells[14].InnerHtml = reader["MaxC13"].ToString();
                        this.myFootballTable.Rows[5].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W1"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L1"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W2"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L2"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W3"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L3"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W4"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L4"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W28"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L28"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W5"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L5"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[7].InnerHtml = "<font color=#aa0000>" + reader["W6"].ToString() + "</font>/<font color=darkblue>" + reader["L6"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[8].InnerHtml = "<font color=#aa0000>" + reader["W7"].ToString() + "</font>/<font color=darkblue>" + reader["L7"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[9].InnerHtml = "<font color=#aa0000>" + reader["W8"].ToString() + "</font>/<font color=darkblue>" + reader["L8"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[10].InnerHtml = "<font color=#aa0000>" + reader["W9"].ToString() + "</font>/<font color=darkblue>" + reader["L9"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[11].InnerHtml = "<font color=#aa0000>" + reader["W10"].ToString() + "</font>/<font color=darkblue>" + reader["L10"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[12].InnerHtml = "<font color=#aa0000>" + reader["W11"].ToString() + "</font>/<font color=darkblue>" + reader["L11"].ToString() + "</font>";
                        this.myFootballTable.Rows[5].Cells[13].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W12"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L12"].ToString()) + "</font>";
                        this.myFootballTable.Rows[5].Cells[14].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W13"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L13"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W18"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L18"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W19"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L19"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W20"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L20"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W21"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L21"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W22"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L22"].ToString()) + "</font>";
                        this.BKTable.Rows[4].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W23"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L23"].ToString()) + "</font>";
                    }
                    else if (str == "C")
                    {
                        this.myFootballTable.Rows[6].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W1"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L1"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W2"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L2"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W3"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L3"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W4"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L4"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W28"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L28"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W5"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L5"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[7].InnerHtml = "<font color=#aa0000>" + reader["W6"].ToString() + "</font>/<font color=darkblue>" + reader["L6"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[8].InnerHtml = "<font color=#aa0000>" + reader["W7"].ToString() + "</font>/<font color=darkblue>" + reader["L7"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[9].InnerHtml = "<font color=#aa0000>" + reader["W8"].ToString() + "</font>/<font color=darkblue>" + reader["L8"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[10].InnerHtml = "<font color=#aa0000>" + reader["W9"].ToString() + "</font>/<font color=darkblue>" + reader["L9"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[11].InnerHtml = "<font color=#aa0000>" + reader["W10"].ToString() + "</font>/<font color=darkblue>" + reader["L10"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[12].InnerHtml = "<font color=#aa0000>" + reader["W11"].ToString() + "</font>/<font color=darkblue>" + reader["L11"].ToString() + "</font>";
                        this.myFootballTable.Rows[6].Cells[13].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W12"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L12"].ToString()) + "</font>";
                        this.myFootballTable.Rows[6].Cells[14].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W13"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L13"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W18"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L18"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W19"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L19"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W20"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L20"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W21"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L21"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W22"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L22"].ToString()) + "</font>";
                        this.BKTable.Rows[5].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W23"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L23"].ToString()) + "</font>";
                    }
                    else
                    {
                        if (str != "D")
                        {
                            break;
                        }
                        this.myFootballTable.Rows[7].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W1"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L1"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W2"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L2"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W3"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L3"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W4"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L4"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W28"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L28"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W5"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L5"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[7].InnerHtml = "<font color=#aa0000>" + reader["W6"].ToString() + "</font>/<font color=darkblue>" + reader["L6"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[8].InnerHtml = "<font color=#aa0000>" + reader["W7"].ToString() + "</font>/<font color=darkblue>" + reader["L7"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[9].InnerHtml = "<font color=#aa0000>" + reader["W8"].ToString() + "</font>/<font color=darkblue>" + reader["L8"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[10].InnerHtml = "<font color=#aa0000>" + reader["W9"].ToString() + "</font>/<font color=darkblue>" + reader["L9"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[11].InnerHtml = "<font color=#aa0000>" + reader["W10"].ToString() + "</font>/<font color=darkblue>" + reader["L10"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[12].InnerHtml = "<font color=#aa0000>" + reader["W11"].ToString() + "</font>/<font color=darkblue>" + reader["L11"].ToString() + "</font>";
                        this.myFootballTable.Rows[7].Cells[13].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W12"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L12"].ToString()) + "</font>";
                        this.myFootballTable.Rows[7].Cells[14].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W13"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L13"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[1].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W18"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L18"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[2].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W19"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L19"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[3].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W20"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L20"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[4].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W21"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L21"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[5].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W22"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L22"].ToString()) + "</font>";
                        this.BKTable.Rows[6].Cells[6].InnerHtml = "<font color=#aa0000>" + MyFunc.NumBerFormat(reader["W23"].ToString()) + "</font>/<font color=darkblue>" + MyFunc.NumBerFormat(reader["L23"].ToString()) + "</font>";
                    }
                    continue;
                }
            }
        }
    }
}

