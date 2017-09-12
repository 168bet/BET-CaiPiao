namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class gdset : Page
    {
        protected HtmlTable BKTable;
        protected HtmlTable FTable;
        public string kyglgsid = "";
        public string kygluserid = "";
        protected Label LabelGd;

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
                if (((base.Request.Form["action"] == null) && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    this.kygluserid = base.Request.QueryString["id"].ToString().Trim();
                    this.kyglgsid = base.Request.QueryString["gid"].ToString().Trim();
                    string[] textArray = new string[0x17];
                    string[] textArray2 = new string[0x17];
                    string[] textArray3 = new string[0x17];
                    string[] textArray4 = new string[0x17];
                    string[] textArray5 = new string[0x17];
                    string[] textArray6 = new string[0x17];
                    string[] textArray7 = new string[0x17];
                    string[] textArray8 = new string[0x17];
                    string[] textArray9 = new string[0x17];
                    string[] textArray10 = new string[0x17];
                    string[] textArray11 = new string[0x17];
                    string[] textArray12 = new string[0x17];
                    string[] textArray13 = new string[0x17];
                    string[] textArray14 = new string[0x17];
                    string[] textArray15 = new string[0x17];
                    string[] textArray16 = new string[0x17];
                    for (int i = 0; i < 0x17; i++)
                    {
                        textArray[i] = "0";
                        textArray5[i] = "0";
                        textArray2[i] = "0";
                        textArray6[i] = "0";
                        textArray3[i] = "0";
                        textArray7[i] = "0";
                        textArray4[i] = "0";
                        textArray8[i] = "0";
                        textArray9[i] = "0";
                        textArray13[i] = "0";
                        textArray10[i] = "0";
                        textArray14[i] = "0";
                        textArray11[i] = "0";
                        textArray15[i] = "0";
                        textArray12[i] = "0";
                        textArray16[i] = "0";
                    }
                    SqlDataReader rr = base2.ExecuteReader("SELECT * FROM hs WHERE userid=" + this.kyglgsid);
                    while (rr.Read())
                    {
                        if (rr["type"].ToString().Trim().ToUpper() == "A")
                        {
                            this.SetHSArray(out textArray9, out textArray13, rr);
                        }
                        if (rr["type"].ToString().Trim().ToUpper() == "B")
                        {
                            this.SetHSArray(out textArray10, out textArray14, rr);
                        }
                        if (rr["type"].ToString().Trim().ToUpper() == "C")
                        {
                            this.SetHSArray(out textArray11, out textArray15, rr);
                        }
                        if (rr["type"].ToString().Trim().ToUpper() == "D")
                        {
                            this.SetHSArray(out textArray12, out textArray16, rr);
                        }
                    }
                    rr.Close();
                    string sql = "";
                    sql = "SELECT agence.userid,agence.username,hs.W1,hs.W2,hs.W3,hs.W4,hs.W5,hs.type,hs.W6,hs.W7,hs.W8,hs.W9,hs.W10,hs.W11,hs.W12,hs.W13,hs.W14,hs.W15,hs.W18,hs.W19,hs.W20,hs.W21,hs.W22,hs.W23,hs.W24,hs.W28,";
                    sql = ((sql + "hs.L1,hs.L2,hs.L3,hs.L4,hs.L5,hs.L6,hs.L7,hs.L8,hs.L9,hs.L10,hs.L11,hs.L12,hs.L13,hs.L14,hs.L15,hs.L18,hs.L19,hs.L20,hs.L21,hs.L22,hs.L23,hs.L24,hs.L28,") + "agence.MaxC1,agence.MaxC2,agence.MaxC3,agence.MaxC4,agence.MaxC5,agence.MaxC6,agence.MaxC7,agence.MaxC8,agence.MaxC9,agence.MaxC10,agence.MaxC11,agence.MaxC12,agence.MaxC13,agence.MaxC14,agence.MaxC15,agence.MaxC18,agence.MaxC19,agence.MaxC20,agence.MaxC21,agence.MaxC22,agence.MaxC23,agence.MaxC24,agence.MaxC28," + "agence.MaxZ1,agence.MaxZ2,agence.MaxZ3,agence.MaxZ4,agence.MaxZ5,agence.MaxZ6,agence.MaxZ7,agence.MaxZ8,agence.MaxZ9,agence.MaxZ10,agence.MaxZ11,agence.MaxZ12,agence.MaxZ13,agence.MaxZ14,agence.MaxZ15,agence.MaxZ18,agence.MaxZ19,agence.MaxZ20,agence.MaxZ21,agence.MaxZ22,agence.MaxZ23,agence.MaxZ24,agence.MaxZ28 ") + " FROM agence LEFT OUTER JOIN hs ON agence.userid = hs.userid WHERE agence.userid=" + this.kygluserid;
                    SqlDataReader reader2 = base2.ExecuteReader(sql);
                    while (reader2.Read())
                    {
                        if (reader2["type"].ToString().Trim().ToUpper() == "A")
                        {
                            this.SetHSArray(out textArray, out textArray5, reader2);
                        }
                        if (reader2["type"].ToString().Trim().ToUpper() == "B")
                        {
                            this.SetHSArray(out textArray2, out textArray6, reader2);
                        }
                        if (reader2["type"].ToString().Trim().ToUpper() == "C")
                        {
                            this.SetHSArray(out textArray3, out textArray7, reader2);
                        }
                        if (reader2["type"].ToString().Trim().ToUpper() == "D")
                        {
                            this.SetHSArray(out textArray4, out textArray8, reader2);
                            this.LabelGd.Text = reader2["username"].ToString().Trim();
                            this.FTable.Rows[1].Cells[1].InnerText = MyFunc.NumBerFormat(textArray[0]) + "/" + MyFunc.NumBerFormat(textArray5[0]);
                            this.FTable.Rows[1].Cells[2].InnerText = MyFunc.NumBerFormat(textArray[1]) + "/" + MyFunc.NumBerFormat(textArray5[1]);
                            this.FTable.Rows[1].Cells[3].InnerText = MyFunc.NumBerFormat(textArray[2]) + "/" + MyFunc.NumBerFormat(textArray5[2]);
                            this.FTable.Rows[1].Cells[4].InnerText = MyFunc.NumBerFormat(textArray[3]) + "/" + MyFunc.NumBerFormat(textArray5[3]);
                            this.FTable.Rows[1].Cells[5].InnerText = MyFunc.NumBerFormat(textArray[0x16]) + "/" + MyFunc.NumBerFormat(textArray5[0x16]);
                            this.FTable.Rows[1].Cells[6].InnerText = MyFunc.NumBerFormat(textArray[4]) + "/" + MyFunc.NumBerFormat(textArray5[4]);
                            this.FTable.Rows[1].Cells[7].InnerText = textArray[5] + "/" + textArray5[5];
                            this.FTable.Rows[1].Cells[8].InnerText = textArray[6] + "/" + textArray5[6];
                            this.FTable.Rows[1].Cells[9].InnerText = textArray[7] + "/" + textArray5[7];
                            this.FTable.Rows[1].Cells[10].InnerText = textArray[8] + "/" + textArray5[8];
                            this.FTable.Rows[1].Cells[11].InnerText = textArray[9] + "/" + textArray5[9];
                            this.FTable.Rows[1].Cells[12].InnerText = textArray[10] + "/" + textArray5[10];
                            this.FTable.Rows[1].Cells[13].InnerText = MyFunc.NumBerFormat(textArray[11]) + "/" + MyFunc.NumBerFormat(textArray5[11]);
                            this.FTable.Rows[1].Cells[14].InnerText = MyFunc.NumBerFormat(textArray[12]) + "/" + MyFunc.NumBerFormat(textArray5[12]);
                            this.BKTable.Rows[1].Cells[1].InnerText = MyFunc.NumBerFormat(textArray[15]) + "/" + MyFunc.NumBerFormat(textArray5[15]);
                            this.BKTable.Rows[1].Cells[2].InnerText = MyFunc.NumBerFormat(textArray[0x10]) + "/" + MyFunc.NumBerFormat(textArray5[0x10]);
                            this.BKTable.Rows[1].Cells[3].InnerText = MyFunc.NumBerFormat(textArray[0x11]) + "/" + MyFunc.NumBerFormat(textArray5[0x11]);
                            this.BKTable.Rows[1].Cells[4].InnerText = textArray[0x12] + "/" + textArray5[0x12];
                            this.BKTable.Rows[1].Cells[5].InnerText = MyFunc.NumBerFormat(textArray[0x13]) + "/" + MyFunc.NumBerFormat(textArray5[0x13]);
                            this.BKTable.Rows[1].Cells[6].InnerText = MyFunc.NumBerFormat(textArray[20]) + "/" + MyFunc.NumBerFormat(textArray5[20]);
                            this.FTable.Rows[2].Cells[1].InnerText = MyFunc.NumBerFormat(textArray2[0]) + "/" + MyFunc.NumBerFormat(textArray6[0]);
                            this.FTable.Rows[2].Cells[2].InnerText = MyFunc.NumBerFormat(textArray2[1]) + "/" + MyFunc.NumBerFormat(textArray6[1]);
                            this.FTable.Rows[2].Cells[3].InnerText = MyFunc.NumBerFormat(textArray2[2]) + "/" + MyFunc.NumBerFormat(textArray6[2]);
                            this.FTable.Rows[2].Cells[4].InnerText = MyFunc.NumBerFormat(textArray2[3]) + "/" + MyFunc.NumBerFormat(textArray6[3]);
                            this.FTable.Rows[2].Cells[5].InnerText = MyFunc.NumBerFormat(textArray2[0x16]) + "/" + MyFunc.NumBerFormat(textArray6[0x16]);
                            this.FTable.Rows[2].Cells[6].InnerText = MyFunc.NumBerFormat(textArray2[4]) + "/" + MyFunc.NumBerFormat(textArray6[4]);
                            this.FTable.Rows[2].Cells[7].InnerText = textArray2[5] + "/" + textArray6[5];
                            this.FTable.Rows[2].Cells[8].InnerText = textArray2[6] + "/" + textArray6[6];
                            this.FTable.Rows[2].Cells[9].InnerText = textArray2[7] + "/" + textArray6[7];
                            this.FTable.Rows[2].Cells[10].InnerText = textArray2[8] + "/" + textArray6[8];
                            this.FTable.Rows[2].Cells[11].InnerText = textArray2[9] + "/" + textArray6[9];
                            this.FTable.Rows[2].Cells[12].InnerText = textArray2[10] + "/" + textArray6[10];
                            this.FTable.Rows[2].Cells[13].InnerText = MyFunc.NumBerFormat(textArray2[11]) + "/" + MyFunc.NumBerFormat(textArray6[11]);
                            this.FTable.Rows[2].Cells[14].InnerText = MyFunc.NumBerFormat(textArray2[12]) + "/" + MyFunc.NumBerFormat(textArray6[12]);
                            this.BKTable.Rows[2].Cells[1].InnerText = MyFunc.NumBerFormat(textArray2[15]) + "/" + MyFunc.NumBerFormat(textArray6[15]);
                            this.BKTable.Rows[2].Cells[2].InnerText = MyFunc.NumBerFormat(textArray2[0x10]) + "/" + MyFunc.NumBerFormat(textArray6[0x10]);
                            this.BKTable.Rows[2].Cells[3].InnerText = MyFunc.NumBerFormat(textArray2[0x11]) + "/" + MyFunc.NumBerFormat(textArray6[0x11]);
                            this.BKTable.Rows[2].Cells[4].InnerText = textArray2[0x12] + "/" + textArray6[0x12];
                            this.BKTable.Rows[2].Cells[5].InnerText = MyFunc.NumBerFormat(textArray2[0x13]) + "/" + MyFunc.NumBerFormat(textArray6[0x13]);
                            this.BKTable.Rows[2].Cells[6].InnerText = MyFunc.NumBerFormat(textArray2[20]) + "/" + MyFunc.NumBerFormat(textArray6[20]);
                            this.FTable.Rows[3].Cells[1].InnerText = MyFunc.NumBerFormat(textArray3[0]) + "/" + MyFunc.NumBerFormat(textArray7[0]);
                            this.FTable.Rows[3].Cells[2].InnerText = MyFunc.NumBerFormat(textArray3[1]) + "/" + MyFunc.NumBerFormat(textArray7[1]);
                            this.FTable.Rows[3].Cells[3].InnerText = MyFunc.NumBerFormat(textArray3[2]) + "/" + MyFunc.NumBerFormat(textArray7[2]);
                            this.FTable.Rows[3].Cells[4].InnerText = MyFunc.NumBerFormat(textArray3[3]) + "/" + MyFunc.NumBerFormat(textArray7[3]);
                            this.FTable.Rows[3].Cells[5].InnerText = MyFunc.NumBerFormat(textArray3[0x16]) + "/" + MyFunc.NumBerFormat(textArray7[0x16]);
                            this.FTable.Rows[3].Cells[6].InnerText = MyFunc.NumBerFormat(textArray3[4]) + "/" + MyFunc.NumBerFormat(textArray7[4]);
                            this.FTable.Rows[3].Cells[7].InnerText = textArray3[5] + "/" + textArray7[5];
                            this.FTable.Rows[3].Cells[8].InnerText = textArray3[6] + "/" + textArray7[6];
                            this.FTable.Rows[3].Cells[9].InnerText = textArray3[7] + "/" + textArray7[7];
                            this.FTable.Rows[3].Cells[10].InnerText = textArray3[8] + "/" + textArray7[8];
                            this.FTable.Rows[3].Cells[11].InnerText = textArray3[9] + "/" + textArray7[9];
                            this.FTable.Rows[3].Cells[12].InnerText = textArray3[10] + "/" + textArray7[10];
                            this.FTable.Rows[3].Cells[13].InnerText = MyFunc.NumBerFormat(textArray3[11]) + "/" + MyFunc.NumBerFormat(textArray7[11]);
                            this.FTable.Rows[3].Cells[14].InnerText = MyFunc.NumBerFormat(textArray3[12]) + "/" + MyFunc.NumBerFormat(textArray7[12]);
                            this.BKTable.Rows[3].Cells[1].InnerText = MyFunc.NumBerFormat(textArray3[15]) + "/" + MyFunc.NumBerFormat(textArray7[15]);
                            this.BKTable.Rows[3].Cells[2].InnerText = MyFunc.NumBerFormat(textArray3[0x10]) + "/" + MyFunc.NumBerFormat(textArray7[0x10]);
                            this.BKTable.Rows[3].Cells[3].InnerText = MyFunc.NumBerFormat(textArray3[0x11]) + "/" + MyFunc.NumBerFormat(textArray7[0x11]);
                            this.BKTable.Rows[3].Cells[4].InnerText = textArray3[0x12] + "/" + textArray7[0x12];
                            this.BKTable.Rows[3].Cells[5].InnerText = MyFunc.NumBerFormat(textArray3[0x13]) + "/" + MyFunc.NumBerFormat(textArray7[0x13]);
                            this.BKTable.Rows[3].Cells[6].InnerText = MyFunc.NumBerFormat(textArray3[20]) + "/" + MyFunc.NumBerFormat(textArray7[20]);
                            this.FTable.Rows[4].Cells[1].InnerText = MyFunc.NumBerFormat(textArray4[0]) + "/" + MyFunc.NumBerFormat(textArray8[0]);
                            this.FTable.Rows[4].Cells[2].InnerText = MyFunc.NumBerFormat(textArray4[1]) + "/" + MyFunc.NumBerFormat(textArray8[1]);
                            this.FTable.Rows[4].Cells[3].InnerText = MyFunc.NumBerFormat(textArray4[2]) + "/" + MyFunc.NumBerFormat(textArray8[2]);
                            this.FTable.Rows[4].Cells[4].InnerText = MyFunc.NumBerFormat(textArray4[3]) + "/" + MyFunc.NumBerFormat(textArray8[3]);
                            this.FTable.Rows[4].Cells[5].InnerText = MyFunc.NumBerFormat(textArray4[0x16]) + "/" + MyFunc.NumBerFormat(textArray8[0x16]);
                            this.FTable.Rows[4].Cells[6].InnerText = MyFunc.NumBerFormat(textArray4[4]) + "/" + MyFunc.NumBerFormat(textArray8[4]);
                            this.FTable.Rows[4].Cells[7].InnerText = textArray4[5] + "/" + textArray8[5];
                            this.FTable.Rows[4].Cells[8].InnerText = textArray4[6] + "/" + textArray8[6];
                            this.FTable.Rows[4].Cells[9].InnerText = textArray4[7] + "/" + textArray8[7];
                            this.FTable.Rows[4].Cells[10].InnerText = textArray4[8] + "/" + textArray8[8];
                            this.FTable.Rows[4].Cells[11].InnerText = textArray4[9] + "/" + textArray8[9];
                            this.FTable.Rows[4].Cells[12].InnerText = textArray4[10] + "/" + textArray8[10];
                            this.FTable.Rows[4].Cells[13].InnerText = MyFunc.NumBerFormat(textArray4[11]) + "/" + MyFunc.NumBerFormat(textArray8[11]);
                            this.FTable.Rows[4].Cells[14].InnerText = MyFunc.NumBerFormat(textArray4[12]) + "/" + MyFunc.NumBerFormat(textArray8[12]);
                            this.BKTable.Rows[4].Cells[1].InnerText = MyFunc.NumBerFormat(textArray4[15]) + "/" + MyFunc.NumBerFormat(textArray8[15]);
                            this.BKTable.Rows[4].Cells[2].InnerText = MyFunc.NumBerFormat(textArray4[0x10]) + "/" + MyFunc.NumBerFormat(textArray8[0x10]);
                            this.BKTable.Rows[4].Cells[3].InnerText = MyFunc.NumBerFormat(textArray4[0x11]) + "/" + MyFunc.NumBerFormat(textArray8[0x11]);
                            this.BKTable.Rows[4].Cells[4].InnerText = textArray4[0x12] + "/" + textArray8[0x12];
                            this.BKTable.Rows[4].Cells[5].InnerText = MyFunc.NumBerFormat(textArray4[0x13]) + "/" + MyFunc.NumBerFormat(textArray8[0x13]);
                            this.BKTable.Rows[4].Cells[6].InnerText = MyFunc.NumBerFormat(textArray4[20]) + "/" + MyFunc.NumBerFormat(textArray8[20]);
                            this.FTable.Rows[5].Cells[1].InnerText = reader2["MAXC1"].ToString().Trim();
                            this.FTable.Rows[5].Cells[2].InnerText = reader2["MAXC2"].ToString().Trim();
                            this.FTable.Rows[5].Cells[3].InnerText = reader2["MAXC3"].ToString().Trim();
                            this.FTable.Rows[5].Cells[4].InnerText = reader2["MAXC4"].ToString().Trim();
                            this.FTable.Rows[5].Cells[5].InnerText = reader2["MAXC28"].ToString().Trim();
                            this.FTable.Rows[5].Cells[6].InnerText = reader2["MAXC5"].ToString().Trim();
                            this.FTable.Rows[5].Cells[7].InnerText = reader2["MAXC6"].ToString().Trim();
                            this.FTable.Rows[5].Cells[8].InnerText = reader2["MAXC7"].ToString().Trim();
                            this.FTable.Rows[5].Cells[9].InnerText = reader2["MAXC8"].ToString().Trim();
                            this.FTable.Rows[5].Cells[10].InnerText = reader2["MAXC9"].ToString().Trim();
                            this.FTable.Rows[5].Cells[11].InnerText = reader2["MAXC10"].ToString().Trim();
                            this.FTable.Rows[5].Cells[12].InnerText = reader2["MAXC11"].ToString().Trim();
                            this.FTable.Rows[5].Cells[13].InnerText = reader2["MAXC12"].ToString().Trim();
                            this.FTable.Rows[5].Cells[14].InnerText = reader2["MAXC13"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[1].InnerText = reader2["MAXC18"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[2].InnerText = reader2["MAXC19"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[3].InnerText = reader2["MAXC20"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[4].InnerText = reader2["MAXC21"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[5].InnerText = reader2["MAXC22"].ToString().Trim();
                            this.BKTable.Rows[5].Cells[6].InnerText = reader2["MAXC23"].ToString().Trim();
                            this.FTable.Rows[6].Cells[1].InnerText = reader2["MAXZ1"].ToString().Trim();
                            this.FTable.Rows[6].Cells[2].InnerText = reader2["MAXZ2"].ToString().Trim();
                            this.FTable.Rows[6].Cells[3].InnerText = reader2["MAXZ3"].ToString().Trim();
                            this.FTable.Rows[6].Cells[4].InnerText = reader2["MAXZ4"].ToString().Trim();
                            this.FTable.Rows[6].Cells[5].InnerText = reader2["MAXZ28"].ToString().Trim();
                            this.FTable.Rows[6].Cells[6].InnerText = reader2["MAXZ5"].ToString().Trim();
                            this.FTable.Rows[6].Cells[7].InnerText = reader2["MAXZ6"].ToString().Trim();
                            this.FTable.Rows[6].Cells[8].InnerText = reader2["MAXZ7"].ToString().Trim();
                            this.FTable.Rows[6].Cells[9].InnerText = reader2["MAXZ8"].ToString().Trim();
                            this.FTable.Rows[6].Cells[10].InnerText = reader2["MAXZ9"].ToString().Trim();
                            this.FTable.Rows[6].Cells[11].InnerText = reader2["MAXZ10"].ToString().Trim();
                            this.FTable.Rows[6].Cells[12].InnerText = reader2["MAXZ11"].ToString().Trim();
                            this.FTable.Rows[6].Cells[13].InnerText = reader2["MAXZ12"].ToString().Trim();
                            this.FTable.Rows[6].Cells[14].InnerText = reader2["MAXZ13"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[1].InnerText = reader2["MAXZ18"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[2].InnerText = reader2["MAXZ19"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[3].InnerText = reader2["MAXZ20"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[4].InnerText = reader2["MAXZ21"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[5].InnerText = reader2["MAXZ22"].ToString().Trim();
                            this.BKTable.Rows[6].Cells[6].InnerText = reader2["MAXZ23"].ToString().Trim();
                            this.FTable.Rows[7].Cells[1].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号','1','" + reader2["MAXC1"].ToString().Trim() + "','" + reader2["MAXZ1"].ToString().Trim() + "','" + textArray[0] + "','" + textArray2[0] + "','" + textArray3[0] + "','" + textArray4[0] + "','" + textArray5[0] + "','" + textArray6[0] + "','" + textArray7[0] + "','" + textArray8[0] + "',0.25," + textArray9[0] + "," + textArray10[0] + "," + textArray11[0] + "," + textArray12[0] + "," + textArray13[0] + "," + textArray14[0] + "," + textArray15[0] + "," + textArray16[0] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[2].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号单双','2','" + reader2["MAXC2"].ToString().Trim() + "','" + reader2["MAXZ2"].ToString().Trim() + "','" + textArray[1] + "','" + textArray2[1] + "','" + textArray3[1] + "','" + textArray4[1] + "','" + textArray5[1] + "','" + textArray6[1] + "','" + textArray7[1] + "','" + textArray8[1] + "',0.25," + textArray9[1] + "," + textArray10[1] + "," + textArray11[1] + "," + textArray12[1] + "," + textArray13[1] + "," + textArray14[1] + "," + textArray15[1] + "," + textArray16[1] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[3].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号大小','3','" + reader2["MAXC3"].ToString().Trim() + "','" + reader2["MAXZ3"].ToString().Trim() + "','" + textArray[2] + "','" + textArray2[2] + "','" + textArray3[2] + "','" + textArray4[2] + "','" + textArray5[2] + "','" + textArray6[2] + "','" + textArray7[2] + "','" + textArray8[2] + "',0.25," + textArray9[2] + "," + textArray10[2] + "," + textArray11[2] + "," + textArray12[2] + "," + textArray13[2] + "," + textArray14[2] + "," + textArray15[2] + "," + textArray16[2] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[4].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特别号合数单双','4','" + reader2["MAXC4"].ToString().Trim() + "','" + reader2["MAXZ4"].ToString().Trim() + "','" + textArray[3] + "','" + textArray2[3] + "','" + textArray3[3] + "','" + textArray4[3] + "','" + textArray5[3] + "','" + textArray6[3] + "','" + textArray7[3] + "','" + textArray8[3] + "',0.25," + textArray9[3] + "," + textArray10[3] + "," + textArray11[3] + "," + textArray12[3] + "," + textArray13[3] + "," + textArray14[3] + "," + textArray15[3] + "," + textArray16[3] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[5].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码','28','" + reader2["MAXC28"].ToString().Trim() + "','" + reader2["MAXZ28"].ToString().Trim() + "','" + textArray[0x16] + "','" + textArray2[0x16] + "','" + textArray3[0x16] + "','" + textArray4[0x16] + "','" + textArray5[0x16] + "','" + textArray6[0x16] + "','" + textArray7[0x16] + "','" + textArray8[0x16] + "',0.25," + textArray9[0x16] + "," + textArray10[0x16] + "," + textArray11[0x16] + "," + textArray12[0x16] + "," + textArray13[0x16] + "," + textArray14[0x16] + "," + textArray15[0x16] + "," + textArray16[0x16] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[6].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('总和单双','5','" + reader2["MAXC5"].ToString().Trim() + "','" + reader2["MAXZ5"].ToString().Trim() + "','" + textArray[4] + "','" + textArray2[4] + "','" + textArray3[4] + "','" + textArray4[4] + "','" + textArray5[4] + "','" + textArray6[4] + "','" + textArray7[4] + "','" + textArray8[4] + "',0.25," + textArray9[4] + "," + textArray10[4] + "," + textArray11[4] + "," + textArray12[4] + "," + textArray13[4] + "," + textArray14[4] + "," + textArray15[4] + "," + textArray16[4] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[7].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('总和大小','6','" + reader2["MAXC6"].ToString().Trim() + "','" + reader2["MAXZ6"].ToString().Trim() + "','" + textArray[5] + "','" + textArray2[5] + "','" + textArray3[5] + "','" + textArray4[5] + "','" + textArray5[5] + "','" + textArray6[5] + "','" + textArray7[5] + "','" + textArray8[5] + "',0.25," + textArray9[5] + "," + textArray10[5] + "," + textArray11[5] + "," + textArray12[5] + "," + textArray13[5] + "," + textArray14[5] + "," + textArray15[5] + "," + textArray16[5] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[8].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('二全中','7','" + reader2["MAXC7"].ToString().Trim() + "','" + reader2["MAXZ7"].ToString().Trim() + "','" + textArray[6] + "','" + textArray2[6] + "','" + textArray3[6] + "','" + textArray4[6] + "','" + textArray5[6] + "','" + textArray6[6] + "','" + textArray7[6] + "','" + textArray8[6] + "',0.25," + textArray9[6] + "," + textArray10[6] + "," + textArray11[6] + "," + textArray12[6] + "," + textArray13[6] + "," + textArray14[6] + "," + textArray15[6] + "," + textArray16[6] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[9].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('三全中','8','" + reader2["MAXC8"].ToString().Trim() + "','" + reader2["MAXZ8"].ToString().Trim() + "','" + textArray[7] + "','" + textArray2[7] + "','" + textArray3[7] + "','" + textArray4[7] + "','" + textArray5[7] + "','" + textArray6[7] + "','" + textArray7[7] + "','" + textArray8[7] + "',0.25," + textArray9[7] + "," + textArray10[7] + "," + textArray11[7] + "," + textArray12[7] + "," + textArray13[7] + "," + textArray14[7] + "," + textArray15[7] + "," + textArray16[7] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[10].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('三中二','9','" + reader2["MAXC9"].ToString().Trim() + "','" + reader2["MAXZ9"].ToString().Trim() + "','" + textArray[8] + "','" + textArray2[8] + "','" + textArray3[8] + "','" + textArray4[8] + "','" + textArray5[8] + "','" + textArray6[8] + "','" + textArray7[8] + "','" + textArray8[8] + "',0.25," + textArray9[8] + "," + textArray10[8] + "," + textArray11[8] + "," + textArray12[8] + "," + textArray13[8] + "," + textArray14[8] + "," + textArray15[8] + "," + textArray16[8] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[11].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('二中特','10','" + reader2["MAXC10"].ToString().Trim() + "','" + reader2["MAXZ10"].ToString().Trim() + "','" + textArray[9] + "','" + textArray2[9] + "','" + textArray3[9] + "','" + textArray4[9] + "','" + textArray5[9] + "','" + textArray6[9] + "','" + textArray7[9] + "','" + textArray8[9] + "',0.25," + textArray9[9] + "," + textArray10[9] + "," + textArray11[9] + "," + textArray12[9] + "," + textArray13[9] + "," + textArray14[9] + "," + textArray15[9] + "," + textArray16[9] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[12].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('特串','11','" + reader2["MAXC11"].ToString().Trim() + "','" + reader2["MAXZ11"].ToString().Trim() + "','" + textArray[10] + "','" + textArray2[10] + "','" + textArray3[10] + "','" + textArray4[10] + "','" + textArray5[10] + "','" + textArray6[10] + "','" + textArray7[10] + "','" + textArray8[10] + "',0.25," + textArray9[10] + "," + textArray10[10] + "," + textArray11[10] + "," + textArray12[10] + "," + textArray13[10] + "," + textArray14[10] + "," + textArray15[10] + "," + textArray16[10] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[13].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码过关','12','" + reader2["MAXC12"].ToString().Trim() + "','" + reader2["MAXZ12"].ToString().Trim() + "','" + textArray[11] + "','" + textArray2[11] + "','" + textArray3[11] + "','" + textArray4[11] + "','" + textArray5[11] + "','" + textArray6[11] + "','" + textArray7[11] + "','" + textArray8[11] + "',0.25," + textArray9[11] + "," + textArray10[11] + "," + textArray11[11] + "," + textArray12[11] + "," + textArray13[11] + "," + textArray14[11] + "," + textArray15[11] + "," + textArray16[11] + ");\">修改</span>";
                            this.FTable.Rows[7].Cells[14].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('色波','13','" + reader2["MAXC13"].ToString().Trim() + "','" + reader2["MAXZ13"].ToString().Trim() + "','" + textArray[12] + "','" + textArray2[12] + "','" + textArray3[12] + "','" + textArray4[12] + "','" + textArray5[12] + "','" + textArray6[12] + "','" + textArray7[12] + "','" + textArray8[12] + "',0.25," + textArray9[12] + "," + textArray10[12] + "," + textArray11[12] + "," + textArray12[12] + "," + textArray13[12] + "," + textArray14[12] + "," + textArray15[12] + "," + textArray16[12] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[1].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('生肖','18','" + reader2["MAXC18"].ToString().Trim() + "','" + reader2["MAXZ18"].ToString().Trim() + "','" + textArray[15] + "','" + textArray2[15] + "','" + textArray3[15] + "','" + textArray4[15] + "','" + textArray5[15] + "','" + textArray6[15] + "','" + textArray7[15] + "','" + textArray8[15] + "',0.25," + textArray9[15] + "," + textArray10[15] + "," + textArray11[15] + "," + textArray12[15] + "," + textArray13[15] + "," + textArray14[15] + "," + textArray15[15] + "," + textArray16[15] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[2].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6单双','19','" + reader2["MAXC19"].ToString().Trim() + "','" + reader2["MAXZ19"].ToString().Trim() + "','" + textArray[0x10] + "','" + textArray2[0x10] + "','" + textArray3[0x10] + "','" + textArray4[0x10] + "','" + textArray5[0x10] + "','" + textArray6[0x10] + "','" + textArray7[0x10] + "','" + textArray8[0x10] + "',0.25," + textArray9[0x10] + "," + textArray10[0x10] + "," + textArray11[0x10] + "," + textArray12[0x10] + "," + textArray13[0x10] + "," + textArray14[0x10] + "," + textArray15[0x10] + "," + textArray16[0x10] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[3].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6大小','20','" + reader2["MAXC20"].ToString().Trim() + "','" + reader2["MAXZ20"].ToString().Trim() + "','" + textArray[0x11] + "','" + textArray2[0x11] + "','" + textArray3[0x11] + "','" + textArray4[0x11] + "','" + textArray5[0x11] + "','" + textArray6[0x11] + "','" + textArray7[0x11] + "','" + textArray8[0x11] + "',0.25," + textArray9[0x11] + "," + textArray10[0x11] + "," + textArray11[0x11] + "," + textArray12[0x11] + "," + textArray13[0x11] + "," + textArray14[0x11] + "," + textArray15[0x11] + "," + textArray16[0x11] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[4].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6色波','21','" + reader2["MAXC21"].ToString().Trim() + "','" + reader2["MAXZ21"].ToString().Trim() + "','" + textArray[0x12] + "','" + textArray2[0x12] + "','" + textArray3[0x12] + "','" + textArray4[0x12] + "','" + textArray5[0x12] + "','" + textArray6[0x12] + "','" + textArray7[0x12] + "','" + textArray8[0x12] + "',0.25," + textArray9[0x12] + "," + textArray10[0x12] + "," + textArray11[0x12] + "," + textArray12[0x12] + "," + textArray13[0x12] + "," + textArray14[0x12] + "," + textArray15[0x12] + "," + textArray16[0x12] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[5].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('一肖','22','" + reader2["MAXC22"].ToString().Trim() + "','" + reader2["MAXZ22"].ToString().Trim() + "','" + textArray[0x13] + "','" + textArray2[0x13] + "','" + textArray3[0x13] + "','" + textArray4[0x13] + "','" + textArray5[0x13] + "','" + textArray6[0x13] + "','" + textArray7[0x13] + "','" + textArray8[0x13] + "',0.25," + textArray9[0x13] + "," + textArray10[0x13] + "," + textArray11[0x13] + "," + textArray12[0x13] + "," + textArray13[0x13] + "," + textArray14[0x13] + "," + textArray15[0x13] + "," + textArray16[0x13] + ");\">修改</span>";
                            this.BKTable.Rows[7].Cells[6].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('六肖','23','" + reader2["MAXC23"].ToString().Trim() + "','" + reader2["MAXZ23"].ToString().Trim() + "','" + textArray[20] + "','" + textArray2[20] + "','" + textArray3[20] + "','" + textArray4[20] + "','" + textArray5[20] + "','" + textArray6[20] + "','" + textArray7[20] + "','" + textArray8[20] + "',0.25," + textArray9[20] + "," + textArray10[20] + "," + textArray11[20] + "," + textArray12[20] + "," + textArray13[20] + "," + textArray14[20] + "," + textArray15[20] + "," + textArray16[20] + ");\">修改</span>";
                        }
                    }
                    reader2.Close();
                    base2.Dispose();
                    this.DataBind();
                }
                else if ((((base.Request.Form["action"] != null) && (base.Request.Form["action"].ToString().Trim() == "ffpost")) && ((base.Request.Form["id"] != null) && (base.Request.Form["id"].ToString().Trim() != ""))) && ((base.Request.Form["rtype"] != null) && (base.Request.Form["rtype"].ToString().Trim() != "")))
                {
                    this.Updatekygl(base.Request.Form["rtype"].ToString().Trim());
                }
                else
                {
                    MyFunc.showmsg("出错了!");
                    base.Response.End();
                }
            }
        }

        private void SetHSArray(out string[] hsArray1, out string[] hsArray2, SqlDataReader rr)
        {
            hsArray1 = new string[0x17];
            hsArray2 = new string[0x17];
            hsArray1[0] = rr["w1"].ToString().Trim();
            hsArray1[1] = rr["w2"].ToString().Trim();
            hsArray1[2] = rr["w3"].ToString().Trim();
            hsArray1[3] = rr["w4"].ToString().Trim();
            hsArray1[4] = rr["w5"].ToString().Trim();
            hsArray1[5] = rr["w6"].ToString().Trim();
            hsArray1[6] = rr["w7"].ToString().Trim();
            hsArray1[7] = rr["w8"].ToString().Trim();
            hsArray1[8] = rr["w9"].ToString().Trim();
            hsArray1[9] = rr["w10"].ToString().Trim();
            hsArray1[10] = rr["w11"].ToString().Trim();
            hsArray1[11] = rr["w12"].ToString().Trim();
            hsArray1[12] = rr["w13"].ToString().Trim();
            hsArray1[13] = rr["w14"].ToString().Trim();
            hsArray1[14] = rr["w15"].ToString().Trim();
            hsArray1[15] = rr["w18"].ToString().Trim();
            hsArray1[0x10] = rr["w19"].ToString().Trim();
            hsArray1[0x11] = rr["w20"].ToString().Trim();
            hsArray1[0x12] = rr["w21"].ToString().Trim();
            hsArray1[0x13] = rr["w22"].ToString().Trim();
            hsArray1[20] = rr["w23"].ToString().Trim();
            hsArray1[0x15] = rr["w24"].ToString().Trim();
            hsArray1[0x16] = rr["w28"].ToString().Trim();
            hsArray2[0] = rr["l1"].ToString().Trim();
            hsArray2[1] = rr["l2"].ToString().Trim();
            hsArray2[2] = rr["l3"].ToString().Trim();
            hsArray2[3] = rr["l4"].ToString().Trim();
            hsArray2[4] = rr["l5"].ToString().Trim();
            hsArray2[5] = rr["l6"].ToString().Trim();
            hsArray2[6] = rr["l7"].ToString().Trim();
            hsArray2[7] = rr["l8"].ToString().Trim();
            hsArray2[8] = rr["l9"].ToString().Trim();
            hsArray2[9] = rr["l10"].ToString().Trim();
            hsArray2[10] = rr["l11"].ToString().Trim();
            hsArray2[11] = rr["l12"].ToString().Trim();
            hsArray2[12] = rr["l13"].ToString().Trim();
            hsArray2[13] = rr["l14"].ToString().Trim();
            hsArray2[14] = rr["l15"].ToString().Trim();
            hsArray2[15] = rr["l18"].ToString().Trim();
            hsArray2[0x10] = rr["l19"].ToString().Trim();
            hsArray2[0x11] = rr["l20"].ToString().Trim();
            hsArray2[0x12] = rr["l21"].ToString().Trim();
            hsArray2[0x13] = rr["l22"].ToString().Trim();
            hsArray2[20] = rr["l23"].ToString().Trim();
            hsArray2[0x15] = rr["l24"].ToString().Trim();
            hsArray2[0x16] = rr["l28"].ToString().Trim();
        }

        private void Updatekygl(string type)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
            }
            else if (((((base.Request.Form["war_set_w1"] != null) && (base.Request.Form["war_set_w2"] != null)) && ((base.Request.Form["war_set_w3"] != null) && (base.Request.Form["war_set_w4"] != null))) && (((base.Request.Form["war_set_l1"] != null) && (base.Request.Form["war_set_l2"] != null)) && ((base.Request.Form["war_set_l3"] != null) && (base.Request.Form["war_set_l4"] != null)))) && ((((base.Request.Form["SC"] != null) & (base.Request.Form["SO"] != null)) && (base.Request.Form["id"] != null)) && (base.Request.Form["id"].ToString().Trim() != "")))
            {
                string sql = "";
                string text2 = "";
                string text3 = MyFunc.DefaultValue(base.Request.Form["war_set_w1"].ToString().Trim(), "0");
                string text4 = MyFunc.DefaultValue(base.Request.Form["war_set_w2"].ToString().Trim(), "0");
                string text5 = MyFunc.DefaultValue(base.Request.Form["war_set_w3"].ToString().Trim(), "0");
                string text6 = MyFunc.DefaultValue(base.Request.Form["war_set_w4"].ToString().Trim(), "0");
                string text7 = MyFunc.DefaultValue(base.Request.Form["war_set_l1"].ToString().Trim(), "0");
                string text8 = MyFunc.DefaultValue(base.Request.Form["war_set_l2"].ToString().Trim(), "0");
                string text9 = MyFunc.DefaultValue(base.Request.Form["war_set_l3"].ToString().Trim(), "0");
                string text10 = MyFunc.DefaultValue(base.Request.Form["war_set_l4"].ToString().Trim(), "0");
                string s = MyFunc.DefaultValue(base.Request.Form["SC"].ToString().Trim(), "0");
                string text12 = MyFunc.DefaultValue(base.Request.Form["SO"].ToString().Trim(), "0");
                string text13 = base.Request.Form["id"].ToString().Trim();
                string text14 = base.Request.Form["gid"].ToString().Trim();
                switch (type)
                {
                    case "1":
                    {
                        string text15 = "UPDATE hs SET W1=" + text3 + ",L1=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text16 = text15 + "UPDATE hs SET W1=" + text4 + ",L1=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text17 = text16 + "UPDATE hs SET W1=" + text5 + ",L1=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text18 = text17 + "UPDATE hs SET W1=" + text6 + ",L1=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text18 + "UPDATE agence SET maxc1=" + s + ",maxz1=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc1,maxz1 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "2":
                    {
                        string text19 = "UPDATE hs SET W2=" + text3 + ",L2=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text20 = text19 + "UPDATE hs SET W2=" + text4 + ",L2=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text21 = text20 + "UPDATE hs SET W2=" + text5 + ",L2=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text22 = text21 + "UPDATE hs SET W2=" + text6 + ",L2=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text22 + "UPDATE agence SET maxc2=" + s + ",maxz2=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc2,maxz2 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "3":
                    {
                        string text23 = "UPDATE hs SET W3=" + text3 + ",L3=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text24 = text23 + "UPDATE hs SET W3=" + text4 + ",L3=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text25 = text24 + "UPDATE hs SET W3=" + text5 + ",L3=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text26 = text25 + "UPDATE hs SET W3=" + text6 + ",L3=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text26 + "UPDATE agence SET maxc3=" + s + ",maxz3=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc3,maxz3 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "4":
                    {
                        string text27 = "UPDATE hs SET W4=" + text3 + ",L4=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text28 = text27 + "UPDATE hs SET W4=" + text4 + ",L4=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text29 = text28 + "UPDATE hs SET W4=" + text5 + ",L4=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text30 = text29 + "UPDATE hs SET W4=" + text6 + ",L4=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text30 + "UPDATE agence SET maxc4=" + s + ",maxz4=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc4,maxz4 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "5":
                    {
                        string text31 = "UPDATE hs SET W5=" + text3 + ",L5=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text32 = text31 + "UPDATE hs SET W5=" + text4 + ",L5=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text33 = text32 + "UPDATE hs SET W5=" + text5 + ",L5=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text34 = text33 + "UPDATE hs SET W5=" + text6 + ",L5=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text34 + "UPDATE agence SET maxc5=" + s + ",maxz5=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc5,maxz5 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "6":
                    {
                        string text35 = "UPDATE hs SET W6=" + text3 + ",L6=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text36 = text35 + "UPDATE hs SET W6=" + text4 + ",L6=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text37 = text36 + "UPDATE hs SET W6=" + text5 + ",L6=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text38 = text37 + "UPDATE hs SET W6=" + text6 + ",L6=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text38 + "UPDATE agence SET maxc6=" + s + ",maxz6=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc6,maxz6 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "7":
                    {
                        string text39 = "UPDATE hs SET W7=" + text3 + ",L7=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text40 = text39 + "UPDATE hs SET W7=" + text4 + ",L7=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text41 = text40 + "UPDATE hs SET W7=" + text5 + ",L7=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text42 = text41 + "UPDATE hs SET W7=" + text6 + ",L7=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text42 + "UPDATE agence SET maxc7=" + s + ",maxz7=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc7,maxz7 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "8":
                    {
                        string text43 = "UPDATE hs SET W8=" + text3 + ",L8=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text44 = text43 + "UPDATE hs SET W8=" + text4 + ",L8=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text45 = text44 + "UPDATE hs SET W8=" + text5 + ",L8=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text46 = text45 + "UPDATE hs SET W8=" + text6 + ",L8=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text46 + "UPDATE agence SET maxc8=" + s + ",maxz8=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc8,maxz8 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "9":
                    {
                        string text47 = "UPDATE hs SET W9=" + text3 + ",L9=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text48 = text47 + "UPDATE hs SET W9=" + text4 + ",L9=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text49 = text48 + "UPDATE hs SET W9=" + text5 + ",L9=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text50 = text49 + "UPDATE hs SET W9=" + text6 + ",L9=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text50 + "UPDATE agence SET maxc9=" + s + ",maxz9=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc9,maxz9 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "10":
                    {
                        string text51 = "UPDATE hs SET W10=" + text3 + ",L10=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text52 = text51 + "UPDATE hs SET W10=" + text4 + ",L10=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text53 = text52 + "UPDATE hs SET W10=" + text5 + ",L10=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text54 = text53 + "UPDATE hs SET W10=" + text6 + ",L10=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text54 + "UPDATE agence SET maxc10=" + s + ",maxz10=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc10,maxz10 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "11":
                    {
                        string text55 = "UPDATE hs SET W11=" + text3 + ",L11=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text56 = text55 + "UPDATE hs SET W11=" + text4 + ",L11=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text57 = text56 + "UPDATE hs SET W11=" + text5 + ",L11=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text58 = text57 + "UPDATE hs SET W11=" + text6 + ",L11=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text58 + "UPDATE agence SET maxc11=" + s + ",maxz11=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc11,maxz11 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "12":
                    {
                        string text59 = "UPDATE hs SET W12=" + text3 + ",L12=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text60 = text59 + "UPDATE hs SET W12=" + text4 + ",L12=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text61 = text60 + "UPDATE hs SET W12=" + text5 + ",L12=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text62 = text61 + "UPDATE hs SET W12=" + text6 + ",L12=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text62 + "UPDATE agence SET maxc12=" + s + ",maxz12=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc12,maxz12 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "13":
                    {
                        string text63 = "UPDATE hs SET W13=" + text3 + ",L13=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text64 = text63 + "UPDATE hs SET W13=" + text4 + ",L13=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text65 = text64 + "UPDATE hs SET W13=" + text5 + ",L13=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text66 = text65 + "UPDATE hs SET W13=" + text6 + ",L13=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text66 + "UPDATE agence SET maxc13=" + s + ",maxz13=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc13,maxz13 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "16":
                    {
                        string text67 = "UPDATE hs SET W14=" + text3 + ",L14=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text68 = text67 + "UPDATE hs SET W14=" + text4 + ",L14=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text69 = text68 + "UPDATE hs SET W14=" + text5 + ",L14=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text70 = text69 + "UPDATE hs SET W14=" + text6 + ",L14=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text70 + "UPDATE agence SET maxc14=" + s + ",maxz14=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc14,maxz14 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "17":
                    {
                        string text71 = "UPDATE hs SET W15=" + text3 + ",L15=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text72 = text71 + "UPDATE hs SET W15=" + text4 + ",L15=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text73 = text72 + "UPDATE hs SET W15=" + text5 + ",L15=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text74 = text73 + "UPDATE hs SET W15=" + text6 + ",L15=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text74 + "UPDATE agence SET maxc15=" + s + ",maxz15=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc15,maxz15 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "18":
                    {
                        string text75 = "UPDATE hs SET W18=" + text3 + ",L18=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text76 = text75 + "UPDATE hs SET W18=" + text4 + ",L18=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text77 = text76 + "UPDATE hs SET W18=" + text5 + ",L18=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text78 = text77 + "UPDATE hs SET W18=" + text6 + ",L18=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text78 + "UPDATE agence SET maxc18=" + s + ",maxz18=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc18,maxz18 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "19":
                    {
                        string text79 = "UPDATE hs SET W19=" + text3 + ",L19=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text80 = text79 + "UPDATE hs SET W19=" + text4 + ",L19=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text81 = text80 + "UPDATE hs SET W19=" + text5 + ",L19=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text82 = text81 + "UPDATE hs SET W19=" + text6 + ",L19=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text82 + "UPDATE agence SET maxc19=" + s + ",maxz19=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc19,maxz19 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "20":
                    {
                        string text83 = "UPDATE hs SET W20=" + text3 + ",L20=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text84 = text83 + "UPDATE hs SET W20=" + text4 + ",L20=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text85 = text84 + "UPDATE hs SET W20=" + text5 + ",L20=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text86 = text85 + "UPDATE hs SET W20=" + text6 + ",L20=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text86 + "UPDATE agence SET maxc20=" + s + ",maxz20=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc20,maxz20 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "21":
                    {
                        string text87 = "UPDATE hs SET W21=" + text3 + ",L21=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text88 = text87 + "UPDATE hs SET W21=" + text4 + ",L21=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text89 = text88 + "UPDATE hs SET W21=" + text5 + ",L21=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text90 = text89 + "UPDATE hs SET W21=" + text6 + ",L21=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text90 + "UPDATE agence SET maxc21=" + s + ",maxz21=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc21,maxz21 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "22":
                    {
                        string text91 = "UPDATE hs SET W22=" + text3 + ",L22=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text92 = text91 + "UPDATE hs SET W22=" + text4 + ",L22=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text93 = text92 + "UPDATE hs SET W22=" + text5 + ",L22=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text94 = text93 + "UPDATE hs SET W22=" + text6 + ",L22=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text94 + "UPDATE agence SET maxc22=" + s + ",maxz22=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc22,maxz22 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "23":
                    {
                        string text95 = "UPDATE hs SET W23=" + text3 + ",L23=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text96 = text95 + "UPDATE hs SET W23=" + text4 + ",L23=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text97 = text96 + "UPDATE hs SET W23=" + text5 + ",L23=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text98 = text97 + "UPDATE hs SET W23=" + text6 + ",L23=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text98 + "UPDATE agence SET maxc23=" + s + ",maxz23=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc23,maxz23 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "24":
                    {
                        string text99 = "UPDATE hs SET W24=" + text3 + ",L24=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text100 = text99 + "UPDATE hs SET W24=" + text4 + ",L24=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text101 = text100 + "UPDATE hs SET W24=" + text5 + ",L24=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text102 = text101 + "UPDATE hs SET W24=" + text6 + ",L24=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text102 + "UPDATE agence SET maxc24=" + s + ",maxz24=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc24,maxz24 FROM agence WHERE userid=" + text14;
                        break;
                    }
                    case "28":
                    {
                        string text103 = "UPDATE hs SET W28=" + text3 + ",L28=" + text7 + " WHERE userid=" + text13 + " AND type='A';";
                        string text104 = text103 + "UPDATE hs SET W28=" + text4 + ",L28=" + text8 + " WHERE userid=" + text13 + " AND type='B';";
                        string text105 = text104 + "UPDATE hs SET W28=" + text5 + ",L28=" + text9 + " WHERE userid=" + text13 + " AND type='C';";
                        string text106 = text105 + "UPDATE hs SET W28=" + text6 + ",L28=" + text10 + " WHERE userid=" + text13 + " AND type='D';";
                        sql = text106 + "UPDATE agence SET maxc28=" + s + ",maxz28=" + text12 + " WHERE userid=" + text13 + ";";
                        text2 = "SELECT Maxc28,maxz28 FROM agence WHERE userid=" + text14;
                        break;
                    }
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
                    if ((num < ((int) float.Parse(s))) || (num2 < ((int) float.Parse(text12))))
                    {
                        base2.Dispose();
                        MyFunc.showmsg("单场限额或单注限额不能大于公司的单场限额或单注限额");
                        base.Response.End();
                    }
                    else
                    {
                        SqlDataReader reader2 = base2.ExecuteReader("SELECT usemoney FROM agence WHERE userid=" + text13 + " AND classid=2");
                        if (!reader2.Read())
                        {
                            reader2.Close();
                            base2.Dispose();
                            MyFunc.showmsg("没有该股东");
                            base.Response.End();
                        }
                        else
                        {
                            int num3 = (int) float.Parse(reader2["usemoney"].ToString().Trim());
                            reader2.Close();
                            int num4 = (int) float.Parse(s);
                            int num5 = (int) float.Parse(text12);
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
                                base.Response.Redirect("gdset.aspx?id=" + text13 + "&gid=" + text14);
                            }
                        }
                    }
                }
            }
        }
    }
}

