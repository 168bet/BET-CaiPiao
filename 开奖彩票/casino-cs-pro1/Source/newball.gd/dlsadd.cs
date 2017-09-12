namespace newball.gd
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class dlsadd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected DropDownList DropDownListDlsBl;
        protected DropDownList DropDownListIsUseAble;
        protected DropDownList DropDownListName2;
        protected DropDownList DropDownListName3;
        protected DropDownList DropDownListZdl;
        protected DropDownList DropDownListZdlBl;
        protected Label LabelGd;
        protected HtmlInputHidden TextBoxGsGdBl;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "2", 1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                string input = this.TextBoxUserName.Text.Trim().ToLower();
                string text2 = this.TextBoxNewpass1.Text.Trim();
                string text3 = this.TextBoxNewpass2.Text.Trim();
                string text4 = this.TextBoxTrueName.Text.Trim();
                string text6 = this.DropDownListIsUseAble.SelectedValue.Trim();
                string s = this.TextBoxUseMoney.Text.Trim();
                string text15 = this.TextBoxTel.Text.Trim().Replace(" ", "").Replace("'", "").Replace("%", "");
                string text7 = this.Session.Contents["adminuserid"].ToString().Trim();
                string text8 = this.Session.Contents["adminusername"].ToString().Trim();
                string upid = this.DropDownListZdl.SelectedValue;
                string text = this.DropDownListZdl.SelectedItem.Text;
                string selectedValue = this.DropDownListZdlBl.SelectedValue;
                string text13 = this.DropDownListDlsBl.SelectedValue;
                string text16 = this.TextBoxMaxMem.Text.Trim();
                if (((((input == "") || (text2 == "")) || ((text3 == "") || (text4 == ""))) || (((text6 == "") || (s == "")) || ((text7 == "") || (text8 == "")))) || (((upid == "") || (text == "")) || (((selectedValue == "") || (text13 == "")) || (text16 == ""))))
                {
                    MyFunc.showmsg("请输入代理商帐号,密码,名称,即时注单状态,信用额度,最大会员数");
                    base.Response.End();
                }
                else if (input.Length < 3)
                {
                    MyFunc.showmsg("代理商帐号不能小于3个字符");
                    base.Response.End();
                }
                else if (text4.Length > 8)
                {
                    MyFunc.showmsg("代理商名称不能大于8个字符(4个汉字)");
                    base.Response.End();
                }
                else
                {
                    Regex regex = new Regex("[^'*%=\"<>/|]");
                    Regex regex2 = new Regex("[^'*%=\"<>/|]");
                    if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                    {
                        MyFunc.showmsg("代理商帐号或名称里含有非法字符");
                        base.Response.End();
                    }
                    else if (text2 != text3)
                    {
                        MyFunc.showmsg("输入的密码不相同");
                    }
                    else
                    {
                        try
                        {
                            if (int.Parse(s) >= 0)
                            {
                                try
                                {
                                    int.Parse(text16);
                                }
                                catch
                                {
                                    MyFunc.showmsg("请输入正确的最大会员数");
                                    base.Response.End();
                                    return;
                                }
                                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                string text11 = base2.ExecuteScalar("SELECT gdbl FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString();
                                string text14 = base2.ExecuteScalar("SELECT gsbl FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString();
                                if ((int.Parse(selectedValue) + int.Parse(text13)) > (100 - int.Parse(text11)))
                                {
                                    MyFunc.showmsg("总代理,代理商的比例相加不能大于" + ((100 - int.Parse(text11))).ToString());
                                    base.Response.End();
                                }
                                else
                                {
                                    text11 = (((100 - int.Parse(text14)) - int.Parse(selectedValue)) - int.Parse(text13)).ToString();
                                    int num2 = int.Parse(base2.ExecuteScalar("SELECT usemoney FROM agence WHERE userid=" + upid).ToString());
                                    int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + upid + " AND isuseable=1").ToString());
                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + upid + " AND isuseable=0").ToString());
                                    int num5 = (num2 - num3) - num4;
                                    if (int.Parse(s) > num5)
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("信用度额不能大于总代理可用信用度额");
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        int num6 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE username='" + input + "'");
                                        if (num6 > 0)
                                        {
                                            base2.Dispose();
                                            MyFunc.showmsg("该代理商帐号已存在!");
                                            base.Response.End();
                                        }
                                        else
                                        {
                                            int num7 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + upid).ToString());
                                            if (num7 > 0)
                                            {
                                                int num8 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE zdlid=" + upid + " AND classid=4").ToString());
                                                if ((num8 + int.Parse(text16)) > num7)
                                                {
                                                    base2.Dispose();
                                                    object[] objArray = new object[] { "该代理商的总代理最大会员为 ", num7, " ,现在代理商最大会员数最大可设为 ", (num7 - num8).ToString() };
                                                    MyFunc.showmsg(string.Concat(objArray));
                                                    base.Response.End();
                                                    return;
                                                }
                                            }
                                            else
                                            {
                                                int num9 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString());
                                                if (num9 > 0)
                                                {
                                                    int num10 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE gdid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " AND classid=4").ToString());
                                                    if ((num10 + int.Parse(text16)) > num9)
                                                    {
                                                        base2.Dispose();
                                                        object[] objArray2 = new object[] { "该代理商的股东的最大会员为 ", num9, " ,现在代理商最大会员数最大可设为 ", (num9 - num10).ToString() };
                                                        MyFunc.showmsg(string.Concat(objArray2));
                                                        base.Response.End();
                                                        return;
                                                    }
                                                }
                                            }
                                            if (base2.ExecuteNonQuery("INSERT INTO agence(username,userpass,truename,classid,regtime,isuseable,usemoney,tel,gdid,gdname,zdlid,zdlname,bl,gdbl,zdlbl,gsbl,maxmem)VALUES('" + input + "','" + text2 + "','" + text4 + "',4,GetDate()," + this.DropDownListIsUseAble.SelectedValue + "," + s + ",'" + text15 + "'," + text7 + ",'" + text8 + "'," + upid + ",'" + text + "'," + text13 + "," + text11 + "," + selectedValue + "," + text14 + "," + text16 + ")") > 0)
                                            {
                                                string userid = base2.ExecuteScalar("SELECT userid FROM agence WHERE username='" + input + "'").ToString();
                                                this.SetStartHs(upid, userid, "A");
                                                this.SetStartHs(upid, userid, "B");
                                                this.SetStartHs(upid, userid, "C");
                                                this.SetStartHs(upid, userid, "D");
                                                base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount+1 WHERE userid=" + upid);
                                                base2.Dispose();
                                                MyFunc.JumpPage("添加代理商成功!", "dlslist.aspx");
                                            }
                                            else
                                            {
                                                base2.Dispose();
                                                MyFunc.showmsg("添加代理商失败!");
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                MyFunc.showmsg("请输入正确的信用额度");
                                base.Response.End();
                            }
                        }
                        catch
                        {
                            MyFunc.showmsg("请输入正确的信用额度");
                            base.Response.End();
                        }
                    }
                }
            }
        }

        private void InitializeComponent()
        {
            this.ButtonSave.Click += new EventHandler(this.ButtonSave_Click);
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
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,gdbl FROM agence WHERE gdid=" + this.Session.Contents["adminuserid"] + " AND classid=3");
                this.DropDownListZdl.Items.Clear();
                this.LabelGd.Text = this.Session.Contents["adminusername"].ToString().Trim();
                while (reader.Read())
                {
                    this.DropDownListZdl.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                if (this.DropDownListZdl.Items.Count < 1)
                {
                    base2.Dispose();
                    MyFunc.showmsg("请先添加总代理");
                    base.Response.End();
                }
                else
                {
                    int num = int.Parse(base2.ExecuteScalar("SELECT gdbl FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString());
                    base2.Dispose();
                    this.TextBoxGsGdBl.Value = num.ToString();
                    this.DropDownListZdlBl.Items.Clear();
                    for (int i = 0; i <= (100 - num); i++)
                    {
                        this.DropDownListZdlBl.Items.Add(new ListItem(i.ToString() + " %", i.ToString()));
                    }
                    this.DropDownListZdlBl.SelectedIndex = 0;
                    this.DropDownListDlsBl.Items.Clear();
                    for (int j = 0; j <= (100 - num); j++)
                    {
                        this.DropDownListDlsBl.Items.Add(new ListItem(j.ToString() + " %", j.ToString()));
                    }
                    this.DropDownListDlsBl.SelectedIndex = 0;
                    this.DropDownListZdl.SelectedIndex = 0;
                    this.DropDownListZdl.Attributes["OnChange"] = "account();";
                    this.DropDownListName2.Attributes["OnChange"] = "account();";
                    this.DropDownListName3.Attributes["OnChange"] = "account();";
                    this.DropDownListZdlBl.Attributes["OnChange"] = "chgzdl();";
                }
            }
        }

        private void SetStartHs(string upid, string userid, string ABC)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            string sql = "insert hs select " + userid + ",type,w1,w2,w3,w4,w5,w6,w7,w8,w9,w10,w11,w12,w13,w14,w15,l1,l2,l3,l4,l5,l6,l7,l8,l9,l10,l11,l12,l13,l14,l15,W28,L28,w18,w19,w20,w21,w22,w23,w24,l18,l19,l20,l21,l22,l23,l24 FROM hs WHERE userid = '" + upid + "' AND type = '" + ABC + "'";
            base2.ExecuteNonQuery(sql);
            if (ABC.ToUpper() == "A")
            {
                sql = "SELECT maxC1,maxC2,maxC3,maxC4,maxC5,maxC6,maxC7,maxC8,maxC9,maxC10,maxC11,maxC12,maxC13,maxC14,maxC15,maxZ1,maxZ2,maxZ3,maxZ4,maxZ5,maxZ6,maxZ7,maxZ8,maxZ9,maxZ10,maxZ11,maxZ12,maxZ13,maxZ14,maxZ15,maxC28,maxZ28,maxC18,maxC19,maxC20,maxC21,maxC22,maxC23,maxC24,maxZ18,maxZ19,maxZ20,maxZ21,maxZ22,maxZ23,maxZ24 FROM agence WHERE userid = '" + upid + "'";
                SqlDataReader reader = base2.ExecuteReader(sql);
                if (reader.Read())
                {
                    string text2 = reader["maxC1"].ToString();
                    string text3 = reader["maxC2"].ToString();
                    string text4 = reader["maxC3"].ToString();
                    string text5 = reader["maxC4"].ToString();
                    string text6 = reader["maxC5"].ToString();
                    string text7 = reader["maxC6"].ToString();
                    string text8 = reader["maxC7"].ToString();
                    string text9 = reader["maxC8"].ToString();
                    string text10 = reader["maxC9"].ToString();
                    string text11 = reader["maxC10"].ToString();
                    string text12 = reader["maxC11"].ToString();
                    string text13 = reader["maxC12"].ToString();
                    string text14 = reader["maxC13"].ToString();
                    string text15 = reader["maxC14"].ToString();
                    string text16 = reader["maxC15"].ToString();
                    string text34 = reader["maxC18"].ToString();
                    string text35 = reader["maxC19"].ToString();
                    string text36 = reader["maxC20"].ToString();
                    string text37 = reader["maxC21"].ToString();
                    string text38 = reader["maxC22"].ToString();
                    string text39 = reader["maxC23"].ToString();
                    string text40 = reader["maxC24"].ToString();
                    string text32 = reader["maxC28"].ToString();
                    string text17 = reader["maxZ1"].ToString();
                    string text18 = reader["maxZ2"].ToString();
                    string text19 = reader["maxZ3"].ToString();
                    string text20 = reader["maxZ4"].ToString();
                    string text21 = reader["maxZ5"].ToString();
                    string text22 = reader["maxZ6"].ToString();
                    string text23 = reader["maxZ7"].ToString();
                    string text24 = reader["maxZ8"].ToString();
                    string text25 = reader["maxZ9"].ToString();
                    string text26 = reader["maxZ10"].ToString();
                    string text27 = reader["maxZ11"].ToString();
                    string text28 = reader["maxZ12"].ToString();
                    string text29 = reader["maxZ13"].ToString();
                    string text30 = reader["maxZ14"].ToString();
                    string text31 = reader["maxZ15"].ToString();
                    string text41 = reader["maxZ18"].ToString();
                    string text42 = reader["maxZ19"].ToString();
                    string text43 = reader["maxZ20"].ToString();
                    string text44 = reader["maxZ21"].ToString();
                    string text45 = reader["maxZ22"].ToString();
                    string text46 = reader["maxZ23"].ToString();
                    string text47 = reader["maxZ24"].ToString();
                    string text33 = reader["maxZ28"].ToString();
                    reader.Close();
                    string text48 = "UPDATE agence SET maxC1 = '" + text2 + "',maxC2 = '" + text3 + "',maxC3 = '" + text4 + "',maxC4 = '" + text5 + "',maxC5 = '" + text6 + "',maxC6 = '" + text7 + "',maxC7 = '" + text8 + "',maxC8 = '" + text9 + "',maxC9 = '" + text10 + "',maxC10 = '" + text11 + "',maxC11 = '" + text12 + "',maxC12 = '" + text13 + "',maxC13 = '" + text14 + "',maxC14 = '" + text15 + "',maxC15 = '" + text16 + "',maxZ1 = '" + text17 + "',maxZ2 = '" + text18 + "',maxZ3 = '" + text19 + "',maxZ4 = '" + text20 + "',maxZ5 = '" + text21 + "',maxZ6 = '" + text22 + "',maxZ7 = '" + text23 + "',maxZ8 = '" + text24 + "',maxZ9 = '" + text25 + "',maxZ10 = '" + text26 + "',maxZ11 = '" + text27 + "',maxZ12 = '" + text28 + "',maxZ13 = '" + text29 + "',maxZ14 = '" + text30 + "',maxZ15 = '" + text31 + "',maxC28 = '" + text32 + "',maxZ28 = '" + text33 + "',";
                    sql = text48 + "maxC18 = '" + text34 + "',maxC19 = '" + text35 + "',maxC20 = '" + text36 + "',maxC21 = '" + text37 + "',maxC22 = '" + text38 + "',maxC23 = '" + text39 + "',maxC24 = '" + text40 + "',maxZ18 = '" + text41 + "',maxZ19 = '" + text42 + "',maxZ20 = '" + text43 + "',maxZ21 = '" + text44 + "',maxZ22 = '" + text45 + "',maxZ23 = '" + text46 + "',maxZ24 = '" + text47 + "' WHERE userid = '" + userid + "'";
                    base2.ExecuteNonQuery(sql);
                }
                else
                {
                    reader.Close();
                }
            }
            base2.Dispose();
        }
    }
}

