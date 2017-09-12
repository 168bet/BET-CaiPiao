namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class edituser : Page
    {
        protected HtmlGenericControl ABC;
        protected HtmlInputHidden act;
        protected HtmlTable BKTable;
        protected HtmlInputHidden currency;
        protected HtmlTable footballsettable;
        protected HtmlInputText ft_b4_1;
        protected HtmlInputText ft_b4_2;
        protected HtmlInputHidden id;
        protected HtmlInputHidden kind;
        protected HtmlGenericControl moneysort;
        protected HtmlTableRow operatetablerow;
        protected HtmlInputHidden pay_type;
        protected HtmlInputHidden ratio;
        protected HtmlInputHidden rtype;
        protected HtmlInputHidden sid;
        protected HtmlGenericControl truename;
        protected HtmlInputHidden useridhid;
        protected HtmlSelect userL;
        protected HtmlGenericControl username;
        protected HtmlSelect userW;
        protected HtmlSelect war_set;

        private void dealsavechg()
        {
            string sql = "";
            string text2 = "";
            string text3 = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            sql = "SELECT MaxC1,MaxC2,MaxC3,MaxC4,MaxC5,MaxC6,MaxC7,MaxC8,MaxC9,MaxC10,MaxC11,MaxC12,MaxC13,MaxC14,MaxC15,MAXC18,MAXC19,MAXC20,MAXC21,MAXC22,MAXC23,MAXC24,MaxC28,MaxZ1,MaxZ2,MaxZ3,MaxZ4,MaxZ5,MaxZ6,MaxZ7,MaxZ8,MaxZ9,MaxZ10,MaxZ11,MaxZ12,MaxZ13,MaxZ14,MaxZ15,MAXZ18,MAXZ19,MAXZ20,MAXZ21,MAXZ22,MAXZ23,MAXZ24,MaxZ28 FROM agence WHERE userid = '" + this.Session["adminuserid"].ToString().Trim() + "'";
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (double.Parse(this.ft_b4_1.Value) >= double.Parse(this.ft_b4_2.Value))
                {
                    if (this.rtype.Value == "dsrq")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC1"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ1"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W1 ='" + base.Request.Form["userW"].ToString() + "',L1 ='" + base.Request.Form["userL"].ToString() + "',MaxC1 = '" + this.ft_b4_1.Value + "',MaxZ1 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "dsdx")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC2"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ2"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W2 ='" + base.Request.Form["userW"].ToString() + "',L2 ='" + base.Request.Form["userL"].ToString() + "',MaxC2 = '" + this.ft_b4_1.Value + "',MaxZ2 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "zdrq")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC3"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ3"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W3 ='" + base.Request.Form["userW"].ToString() + "',L3 ='" + base.Request.Form["userL"].ToString() + "',MaxC3 = '" + this.ft_b4_1.Value + "',MaxZ3 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "zddx")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC4"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ4"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W4 ='" + base.Request.Form["userW"].ToString() + "',L4 ='" + base.Request.Form["userL"].ToString() + "',MaxC4 = '" + this.ft_b4_1.Value + "',MaxZ4 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "ds")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC5"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ5"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W5 ='" + base.Request.Form["userW"].ToString() + "',L5 ='" + base.Request.Form["userL"].ToString() + "',MaxC5 = '" + this.ft_b4_1.Value + "',MaxZ5 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "bz")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC6"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ6"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W6 ='" + base.Request.Form["userW"].ToString() + "',L6 ='" + base.Request.Form["userL"].ToString() + "',MaxC6 = '" + this.ft_b4_1.Value + "',MaxZ6 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "bzgg")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC7"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ7"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W7 ='" + base.Request.Form["userW"].ToString() + "',L7 ='" + base.Request.Form["userL"].ToString() + "',MaxC7 = '" + this.ft_b4_1.Value + "',MaxZ7 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "rqgg")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC8"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ8"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W8 ='" + base.Request.Form["userW"].ToString() + "',L8 ='" + base.Request.Form["userL"].ToString() + "', MaxC8 = '" + this.ft_b4_1.Value + "',MaxZ8 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "bdtz")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC9"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ9"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W9 ='" + base.Request.Form["userW"].ToString() + "',L9 ='" + base.Request.Form["userL"].ToString() + "',MaxC9 = '" + this.ft_b4_1.Value + "',MaxZ9 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "zrq")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC10"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ10"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W10 ='" + base.Request.Form["userW"].ToString() + "',L10 ='" + base.Request.Form["userL"].ToString() + "', MaxC10='" + this.ft_b4_1.Value + "',MaxZ10 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "bqc")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC11"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ11"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W11 ='" + base.Request.Form["userW"].ToString() + "',L11 ='" + base.Request.Form["userL"].ToString() + "',MaxC11 = '" + this.ft_b4_1.Value + "',MaxZ11 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "rqsbc")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC12"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ12"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W12 ='" + base.Request.Form["userW"].ToString() + "',L12 ='" + base.Request.Form["userL"].ToString() + "',MaxC12 = '" + this.ft_b4_1.Value + "',MaxZ12 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "dxsbc")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC13"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ13"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W13 ='" + base.Request.Form["userW"].ToString() + "',L13 ='" + base.Request.Form["userL"].ToString() + "',MaxC13 = '" + this.ft_b4_1.Value + "',MaxZ13 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "bdgg")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC14"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ14"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W14 ='" + base.Request.Form["userW"].ToString() + "',L14 ='" + base.Request.Form["userL"].ToString() + "',MaxC14 = '" + this.ft_b4_1.Value + "',MaxZ14 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "sbgg")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC15"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ15"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W15 ='" + base.Request.Form["userW"].ToString() + "',L15 ='" + base.Request.Form["userL"].ToString() + "',MaxC15 = '" + this.ft_b4_1.Value + "',MaxZ15 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "18")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC18"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ18"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W18 ='" + base.Request.Form["userW"].ToString() + "',L18 ='" + base.Request.Form["userL"].ToString() + "',MaxC18 = '" + this.ft_b4_1.Value + "',MaxZ18 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "19")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC19"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ19"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W19 ='" + base.Request.Form["userW"].ToString() + "',L19 ='" + base.Request.Form["userL"].ToString() + "',MaxC19 = '" + this.ft_b4_1.Value + "',MaxZ19 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "20")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC20"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ20"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W20 ='" + base.Request.Form["userW"].ToString() + "',L20 ='" + base.Request.Form["userL"].ToString() + "',MaxC20 = '" + this.ft_b4_1.Value + "',MaxZ20 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "21")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC21"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ21"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W21 ='" + base.Request.Form["userW"].ToString() + "',L21 ='" + base.Request.Form["userL"].ToString() + "',MaxC21 = '" + this.ft_b4_1.Value + "',MaxZ21 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "22")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC22"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ22"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W22 ='" + base.Request.Form["userW"].ToString() + "',L22 ='" + base.Request.Form["userL"].ToString() + "',MaxC22 = '" + this.ft_b4_1.Value + "',MaxZ22 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "23")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC23"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ23"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W23 ='" + base.Request.Form["userW"].ToString() + "',L23 ='" + base.Request.Form["userL"].ToString() + "',MaxC23 = '" + this.ft_b4_1.Value + "',MaxZ23 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "24")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC24"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ24"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W24 ='" + base.Request.Form["userW"].ToString() + "',L24 ='" + base.Request.Form["userL"].ToString() + "',MaxC24 = '" + this.ft_b4_1.Value + "',MaxZ24 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (this.rtype.Value == "28")
                    {
                        if ((double.Parse(this.ft_b4_1.Value) > double.Parse('0' + reader["MaxC28"].ToString())) || (double.Parse(this.ft_b4_2.Value) > double.Parse('0' + reader["MaxZ28"].ToString())))
                        {
                            text3 = "不能超出代理商的最大限额！";
                        }
                        else
                        {
                            text2 = "UPDATE userhs SET W28 ='" + base.Request.Form["userW"].ToString() + "',L28 ='" + base.Request.Form["userL"].ToString() + "',MaxC28 = '" + this.ft_b4_1.Value + "',MaxZ28 ='" + this.ft_b4_2.Value + "' WHERE userid ='" + this.useridhid.Value + "'";
                            text3 = "修改成功！";
                        }
                    }
                    if (text3 == "修改成功！")
                    {
                        reader.Close();
                        base2.ExecuteNonQuery(text2);
                    }
                    else
                    {
                        base.Response.Write("<script>alert('" + text3 + "');</script>");
                    }
                }
                else
                {
                    reader.Close();
                    text3 = "单注限额不能大于单场限额！";
                    base.Response.Write("<script>alert('" + text3 + "');</script>");
                }
            }
            else
            {
                reader.Close();
                text3 = "代理商的限额度不存在，请重新设置！";
                base.Response.Write("<script>alert('" + text3 + "');</script>");
            }
            base2.CloseConnect();
            base2.Dispose();
        }

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
            else
            {
                if (this.Page.IsPostBack)
                {
                    this.dealsavechg();
                }
                this.setStart();
            }
        }

        private void setfootballtableproc(SqlDataReader dr)
        {
            string text = "0";
            string text2 = "0";
            string text3 = "0";
            string text4 = "0";
            string text5 = "0";
            string text6 = "0";
            string text7 = "0";
            string text8 = "0";
            string text9 = "0";
            string text10 = "0";
            string text11 = "0";
            string text12 = "0";
            string text13 = "0";
            string text14 = "0";
            string text15 = "0";
            string text16 = "0";
            string text17 = "0";
            string text18 = "0";
            string text19 = "0";
            string text20 = "0";
            string text21 = "0";
            string text22 = "0";
            string text23 = "0";
            string text24 = "0";
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
            string text36 = "0";
            string text37 = "0";
            string text38 = "0";
            string text39 = "0";
            string text40 = "0";
            string text41 = "0";
            string text42 = "0";
            string text43 = "0";
            string text44 = "0";
            string text45 = "0";
            string text46 = "0";
            this.username.InnerHtml = dr["username"].ToString();
            this.truename.InnerHtml = dr["truename"].ToString();
            this.ABC.InnerHtml = dr["abc"].ToString();
            this.moneysort.InnerHtml = dr["moneysort"].ToString();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("select W1,W2,W3,W4,W5,W6,W7,W8,W9,W10,W11,W12,W13,W14,W15,W18,W19,W20,W21,W22,W23,W24,W28,L1,L2,L3,L4,L5,L6,L7,L8,L9,L10,L11,L12,L13,L14,L15,L18,L19,L20,L21,L22,L23,L24,L28 FROM hs WHERE userid='" + dr["dlsid"].ToString().Trim() + "' and type = '" + dr["abc"].ToString().Trim() + "'");
            if (reader.Read())
            {
                text = reader["W1"].ToString();
                text2 = reader["W2"].ToString();
                text3 = reader["W3"].ToString();
                text4 = reader["W4"].ToString();
                text5 = reader["W5"].ToString();
                text6 = reader["W6"].ToString();
                text7 = reader["W7"].ToString();
                text8 = reader["W8"].ToString();
                text9 = reader["W9"].ToString();
                text10 = reader["W10"].ToString();
                text11 = reader["W11"].ToString();
                text12 = reader["W12"].ToString();
                text13 = reader["W13"].ToString();
                text14 = reader["W14"].ToString();
                text15 = reader["W15"].ToString();
                text16 = reader["W18"].ToString();
                text17 = reader["W19"].ToString();
                text18 = reader["W20"].ToString();
                text19 = reader["W21"].ToString();
                text20 = reader["W22"].ToString();
                text21 = reader["W23"].ToString();
                text22 = reader["W24"].ToString();
                text23 = reader["W28"].ToString();
                text24 = reader["L1"].ToString();
                text25 = reader["L2"].ToString();
                text26 = reader["L3"].ToString();
                text27 = reader["L4"].ToString();
                text28 = reader["L5"].ToString();
                text29 = reader["L6"].ToString();
                text30 = reader["L7"].ToString();
                text31 = reader["L8"].ToString();
                text32 = reader["L9"].ToString();
                text33 = reader["L10"].ToString();
                text34 = reader["L11"].ToString();
                text35 = reader["L12"].ToString();
                text36 = reader["L13"].ToString();
                text37 = reader["L14"].ToString();
                text38 = reader["L15"].ToString();
                text39 = reader["L18"].ToString();
                text40 = reader["L19"].ToString();
                text41 = reader["L20"].ToString();
                text42 = reader["L21"].ToString();
                text43 = reader["L22"].ToString();
                text44 = reader["L23"].ToString();
                text45 = reader["L24"].ToString();
                text46 = reader["L28"].ToString();
            }
            reader.Close();
            SqlDataReader reader2 = base2.ExecuteReader("SELECT W1,W2,W3,W4,W5,W6,W7,W8,W9,W10,W11,W12,W13,W14,W15,W18,W19,W20,W21,W22,W23,W24,W28,L1,L2,L3,L4,L5,L6,L7,L8,L9,L10,L11,L12,L13,L14,L15,L18,L19,L20,L21,L22,L23,L24,L28,MAXC1,MAXC2,MAXC3,MAXC4,MAXC5,MAXC6,MAXC7,MAXC8,MAXC9,MAXC10,MAXC11,MAXC12,MAXC13,MAXC14,MAXC15,MAXC18,MAXC19,MAXC20,MAXC21,MAXC22,MAXC23,MAXC24,MAXC28,MAXZ1,MAXZ2,MAXZ3,MAXZ4,MAXZ5,MAXZ6,MAXZ7,MAXZ8,MAXZ9,MAXZ10,MAXZ11,MAXZ12,MAXZ13,MAXZ14,MAXZ15,MAXZ18,MAXZ19,MAXZ20,MAXZ21,MAXZ22,MAXZ23,MAXZ24,MAXZ28 FROM userhs where userid = '" + this.useridhid.Value + "'");
            if (reader2.Read())
            {
                this.footballsettable.Rows[2].Cells[1].InnerHtml = reader2["MAXC1"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[2].InnerHtml = reader2["MAXC2"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[3].InnerHtml = reader2["MAXC3"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[4].InnerHtml = reader2["MAXC4"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[5].InnerHtml = reader2["MAXC28"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[6].InnerHtml = reader2["MAXC5"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[7].InnerHtml = reader2["MAXC6"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[8].InnerHtml = reader2["MAXC7"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[9].InnerHtml = reader2["MAXC8"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[10].InnerHtml = reader2["MAXC9"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[11].InnerHtml = reader2["MAXC10"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[12].InnerHtml = reader2["MAXC11"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[13].InnerHtml = reader2["MAXC12"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[2].Cells[14].InnerHtml = reader2["MAXC13"].ToString().Trim() + "&nbsp;";
                this.BKTable.Rows[2].Cells[1].InnerText = reader2["MAXC18"].ToString().Trim();
                this.BKTable.Rows[2].Cells[2].InnerText = reader2["MAXC19"].ToString().Trim();
                this.BKTable.Rows[2].Cells[3].InnerText = reader2["MAXC20"].ToString().Trim();
                this.BKTable.Rows[2].Cells[4].InnerText = reader2["MAXC21"].ToString().Trim();
                this.BKTable.Rows[2].Cells[5].InnerText = reader2["MAXC22"].ToString().Trim();
                this.BKTable.Rows[2].Cells[6].InnerText = reader2["MAXC23"].ToString().Trim();
                this.footballsettable.Rows[3].Cells[1].InnerHtml = reader2["MAXZ1"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[2].InnerHtml = reader2["MAXZ2"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[3].InnerHtml = reader2["MAXZ3"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[4].InnerHtml = reader2["MAXZ4"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[5].InnerHtml = reader2["MAXZ28"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[6].InnerHtml = reader2["MAXZ5"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[7].InnerHtml = reader2["MAXZ6"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[8].InnerHtml = reader2["MAXZ7"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[9].InnerHtml = reader2["MAXZ8"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[10].InnerHtml = reader2["MAXZ9"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[11].InnerHtml = reader2["MAXZ10"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[12].InnerHtml = reader2["MAXZ11"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[13].InnerHtml = reader2["MAXZ12"].ToString().Trim() + "&nbsp;";
                this.footballsettable.Rows[3].Cells[14].InnerHtml = reader2["MAXZ13"].ToString().Trim() + "&nbsp;";
                this.BKTable.Rows[3].Cells[1].InnerText = reader2["MAXZ18"].ToString().Trim();
                this.BKTable.Rows[3].Cells[2].InnerText = reader2["MAXZ19"].ToString().Trim();
                this.BKTable.Rows[3].Cells[3].InnerText = reader2["MAXZ20"].ToString().Trim();
                this.BKTable.Rows[3].Cells[4].InnerText = reader2["MAXZ21"].ToString().Trim();
                this.BKTable.Rows[3].Cells[5].InnerText = reader2["MAXZ22"].ToString().Trim();
                this.BKTable.Rows[3].Cells[6].InnerText = reader2["MAXZ23"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[1].InnerHtml = MyFunc.NumBerFormat(reader2["W1"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L1"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[2].InnerHtml = MyFunc.NumBerFormat(reader2["W2"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L2"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[3].InnerHtml = MyFunc.NumBerFormat(reader2["W3"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L3"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[4].InnerHtml = MyFunc.NumBerFormat(reader2["W4"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L4"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[5].InnerHtml = MyFunc.NumBerFormat(reader2["W28"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L28"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[6].InnerHtml = MyFunc.NumBerFormat(reader2["W5"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L5"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[7].InnerHtml = reader2["W6"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L6"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[8].InnerHtml = reader2["W7"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L7"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[9].InnerHtml = reader2["W8"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L8"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[10].InnerHtml = reader2["W9"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L9"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[11].InnerHtml = reader2["W10"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L10"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[12].InnerHtml = reader2["W11"].ToString().Trim() + "&nbsp;/&nbsp;" + reader2["L11"].ToString().Trim();
                this.footballsettable.Rows[1].Cells[13].InnerHtml = MyFunc.NumBerFormat(reader2["W12"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L12"].ToString().Trim());
                this.footballsettable.Rows[1].Cells[14].InnerHtml = MyFunc.NumBerFormat(reader2["W13"].ToString().Trim()) + "&nbsp;/&nbsp;" + MyFunc.NumBerFormat(reader2["L13"].ToString().Trim());
                this.BKTable.Rows[1].Cells[1].InnerText = double.Parse(reader2["W18"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader2["L18"].ToString().Trim()).ToString("F2");
                this.BKTable.Rows[1].Cells[2].InnerText = double.Parse(reader2["W19"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader2["L19"].ToString().Trim()).ToString("F2");
                this.BKTable.Rows[1].Cells[3].InnerText = double.Parse(reader2["W20"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader2["L20"].ToString().Trim()).ToString("F2");
                this.BKTable.Rows[1].Cells[4].InnerText = reader2["W21"].ToString().Trim() + "/" + reader2["L21"].ToString().Trim();
                this.BKTable.Rows[1].Cells[5].InnerText = double.Parse(reader2["W22"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader2["L22"].ToString().Trim()).ToString("F2");
                this.BKTable.Rows[1].Cells[6].InnerText = double.Parse(reader2["W23"].ToString().Trim()).ToString("F2") + "/" + double.Parse(reader2["L23"].ToString().Trim()).ToString("F2");
                this.footballsettable.Rows[4].Cells[1].InnerHtml = "<a href=\"#\" onClick=\"show_win('特别号','dsrq','" + reader2["MAXC1"].ToString() + "','" + reader2["MAXZ1"].ToString().Trim() + "'," + reader2["W1"].ToString().Trim() + "," + reader2["L1"].ToString().Trim() + ",0.25," + text + "," + text24 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[2].InnerHtml = "<a href=\"#\" onClick=\"show_win('特别号单双','dsdx','" + reader2["MAXC2"].ToString() + "','" + reader2["MAXZ2"].ToString().Trim() + "'," + reader2["W2"].ToString().Trim() + "," + reader2["L2"].ToString().Trim() + ",0.25," + text2 + "," + text25 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[3].InnerHtml = "<a href=\"#\" onClick=\"show_win('特别号大小','zdrq','" + reader2["MAXC3"].ToString() + "','" + reader2["MAXZ3"].ToString().Trim() + "'," + reader2["W3"].ToString().Trim() + "," + reader2["L3"].ToString().Trim() + ",0.25," + text3 + "," + text26 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[4].InnerHtml = "<a href=\"#\" onClick=\"show_win('特别号合数单双','zddx','" + reader2["MAXC4"].ToString() + "','" + reader2["MAXZ4"].ToString().Trim() + "'," + reader2["W4"].ToString().Trim() + "," + reader2["L4"].ToString().Trim() + ",0.25," + text4 + "," + text27 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[5].InnerHtml = "<a href=\"#\" onClick=\"show_win('正码','28','" + reader2["MAXC28"].ToString() + "','" + reader2["MAXZ28"].ToString().Trim() + "'," + reader2["W28"].ToString().Trim() + "," + reader2["L28"].ToString().Trim() + ",0.25," + text23 + "," + text46 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[6].InnerHtml = "<a href=\"#\" onClick=\"show_win('总和单双','ds','" + reader2["MAXC5"].ToString() + "','" + reader2["MAXZ5"].ToString().Trim() + "'," + reader2["W5"].ToString().Trim() + "," + reader2["L5"].ToString().Trim() + ",0.25," + text5 + "," + text28 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[7].InnerHtml = "<a href=\"#\" onClick=\"show_win('总和大小','bz','" + reader2["MAXC6"].ToString() + "','" + reader2["MAXZ6"].ToString().Trim() + "'," + reader2["W6"].ToString().Trim() + "," + reader2["L6"].ToString().Trim() + ",0.25," + text6 + "," + text29 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[8].InnerHtml = "<a href=\"#\" onClick=\"show_win('二全中','bzgg','" + reader2["MAXC7"].ToString() + "','" + reader2["MAXZ7"].ToString().Trim() + "'," + reader2["W7"].ToString().Trim() + "," + reader2["L7"].ToString().Trim() + ",0.25," + text7 + "," + text30 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[9].InnerHtml = "<a href=\"#\" onClick=\"show_win('三全中','rqgg','" + reader2["MAXC8"].ToString() + "','" + reader2["MAXZ8"].ToString().Trim() + "'," + reader2["W8"].ToString().Trim() + "," + reader2["L8"].ToString().Trim() + ",0.25," + text8 + "," + text31 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[10].InnerHtml = "<a href=\"#\" onClick=\"show_win('三中二','bdtz','" + reader2["MAXC9"].ToString() + "','" + reader2["MAXZ9"].ToString().Trim() + "'," + reader2["W9"].ToString().Trim() + "," + reader2["L9"].ToString().Trim() + ",0.25," + text9 + "," + text32 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[11].InnerHtml = "<a href=\"#\" onClick=\"show_win('二中特','zrq','" + reader2["MAXC10"].ToString() + "','" + reader2["MAXZ10"].ToString().Trim() + "'," + reader2["W10"].ToString().Trim() + "," + reader2["L10"].ToString().Trim() + ",0.25," + text10 + "," + text33 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[12].InnerHtml = "<a href=\"#\" onClick=\"show_win('特串','bqc','" + reader2["MAXC11"].ToString() + "','" + reader2["MAXZ11"].ToString().Trim() + "'," + reader2["W11"].ToString().Trim() + "," + reader2["L11"].ToString().Trim() + ",0.25," + text11 + "," + text34 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[13].InnerHtml = "<a href=\"#\" onClick=\"show_win('正码过关','rqsbc','" + reader2["MAXC12"].ToString() + "','" + reader2["MAXZ12"].ToString().Trim() + "'," + reader2["W12"].ToString().Trim() + "," + reader2["L12"].ToString().Trim() + ",0.25," + text12 + "," + text35 + ",'FT');\">修改</a>";
                this.footballsettable.Rows[4].Cells[14].InnerHtml = "<a href=\"#\" onClick=\"show_win('色波','dxsbc','" + reader2["MAXC13"].ToString() + "','" + reader2["MAXZ13"].ToString().Trim() + "'," + reader2["W13"].ToString().Trim() + "," + reader2["L13"].ToString().Trim() + ",0.25," + text13 + "," + text36 + ",'FT');\">修改</a>";
                this.BKTable.Rows[4].Cells[1].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('生肖','18','" + reader2["MAXC18"].ToString().Trim() + "','" + reader2["MAXZ18"].ToString().Trim() + "','" + reader2["W18"].ToString().Trim() + "','" + reader2["L18"].ToString().Trim() + "',0.25," + text16 + "," + text39 + ");\">修改</span>";
                this.BKTable.Rows[4].Cells[2].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6单双','19','" + reader2["MAXC19"].ToString().Trim() + "','" + reader2["MAXZ19"].ToString().Trim() + "','" + reader2["W19"].ToString().Trim() + "','" + reader2["L19"].ToString().Trim() + "',0.25," + text17 + "," + text40 + ");\">修改</span>";
                this.BKTable.Rows[4].Cells[3].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6大小','20','" + reader2["MAXC20"].ToString().Trim() + "','" + reader2["MAXZ20"].ToString().Trim() + "','" + reader2["W20"].ToString().Trim() + "','" + reader2["L20"].ToString().Trim() + "',0.25," + text18 + "," + text41 + ");\">修改</span>";
                this.BKTable.Rows[4].Cells[4].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('正码1-6色波','21','" + reader2["MAXC21"].ToString().Trim() + "','" + reader2["MAXZ21"].ToString().Trim() + "','" + reader2["W21"].ToString().Trim() + "','" + reader2["L21"].ToString().Trim() + "',1," + text19 + "," + text42 + ");\">修改</span>";
                this.BKTable.Rows[4].Cells[5].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('一肖','22','" + reader2["MAXC22"].ToString().Trim() + "','" + reader2["MAXZ22"].ToString().Trim() + "','" + reader2["W22"].ToString().Trim() + "','" + reader2["L22"].ToString().Trim() + "',0.25," + text20 + "," + text43 + ");\">修改</span>";
                this.BKTable.Rows[4].Cells[6].InnerHtml = "<span style=\"CURSOR:hand\" onclick=\"show_win('六肖','23','" + reader2["MAXC23"].ToString().Trim() + "','" + reader2["MAXZ23"].ToString().Trim() + "','" + reader2["W23"].ToString().Trim() + "','" + reader2["L23"].ToString().Trim() + "',0.25," + text21 + "," + text44 + ");\">修改</span>";
            }
            reader2.Close();
            base2.CloseConnect();
            base2.Dispose();
        }

        private void setStart()
        {
            if (base.Request.QueryString["userid"] != null)
            {
                this.useridhid.Value = base.Request.QueryString["userid"].ToString();
            }
            string sql = "SELECT username,truename,abc,moneysort,dlsid FROM member WHERE userid = '" + this.useridhid.Value + "'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader dr = base2.ExecuteReader(sql);
            if (dr.Read())
            {
                this.setfootballtableproc(dr);
                dr.Close();
                base2.CloseConnect();
                base2.Dispose();
            }
            else
            {
                dr.Close();
                base2.CloseConnect();
                base2.Dispose();
                MyFunc.showmsg("帐号可能出错，请重新查询一篇！");
                base.Response.End();
            }
        }
    }
}

