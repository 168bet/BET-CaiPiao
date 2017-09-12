namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class useradd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected DropDownList DropDownList1;
        protected DropDownList DropDownListABC;
        protected DropDownList DropDownListDls;
        protected DropDownList DropDownListGd;
        protected DropDownList DropDownListName2;
        protected DropDownList DropDownListName3;
        protected DropDownList DropDownListPlType;
        protected DropDownList DropDownListRate;
        protected DropDownList DropDownListZdl;
        protected Label LabelUseMoney;
        protected RadioButton RadioButton1;
        protected RadioButton RadioButton2;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

        private void ButtonCancel_Click(object sender, EventArgs e)
        {
        }

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
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
                string text7 = "1";
                string text5 = this.TextBoxTel.Text.Trim().Replace("'", "").Replace("%", "");
                string s = this.TextBoxUseMoney.Text.Trim();
                string text8 = this.DropDownListGd.SelectedValue.Trim();
                string text9 = this.DropDownListGd.SelectedItem.Text.Trim();
                string selectedValue = this.DropDownListZdl.SelectedValue;
                string text = this.DropDownListZdl.SelectedItem.Text;
                string text12 = this.DropDownListDls.SelectedValue;
                string text13 = this.DropDownListDls.SelectedItem.Text;
                string text14 = this.DropDownListRate.SelectedItem.Text;
                string text15 = this.DropDownListRate.SelectedValue;
                string text16 = this.DropDownListPlType.SelectedValue;
                string text17 = this.RadioButton1.Checked ? "信用" : "现金";
                string text18 = this.DropDownListABC.SelectedValue;
                if (((((input == "") || (text2 == "")) || ((text3 == "") || (text4 == ""))) || (((text7 == "") || (s == "")) || ((selectedValue == "") || (text == "")))) || (((text12 == "") || (text13 == "")) || ((text8 == "") || (text9 == ""))))
                {
                    MyFunc.showmsg("请输入总代理,代理商,会员帐号,密码,名称,信用额度");
                    base.Response.End();
                }
                else if (input.Length < 3)
                {
                    MyFunc.showmsg("会员帐号不能小于3个字符");
                    base.Response.End();
                }
                else if (text4.Length > 8)
                {
                    MyFunc.showmsg("会员名称不能大于8个字符(4个汉字)");
                    base.Response.End();
                }
                else
                {
                    Regex regex = new Regex("[^'*%=\"<>/|]");
                    Regex regex2 = new Regex("[^'*%=\"<>/|]");
                    if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                    {
                        MyFunc.showmsg("会员帐号或名称里含有非法字符");
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
                            int num = (int) (int.Parse(s) * float.Parse(text15));
                            if (num >= 0)
                            {
                                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                int num2 = int.Parse(base2.ExecuteScalar("SELECT usemoney FROM agence WHERE userid=" + text12).ToString());
                                int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + text12).ToString());
                                int num4 = num2 - num3;
                                if (int.Parse(s) > num4)
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("信用度额不能大于总代理可用信用度额");
                                    base.Response.End();
                                }
                                else
                                {
                                    int num5 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM member WHERE username='" + input + "'");
                                    if (num5 > 0)
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("该会员帐号已存在!");
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        int num6 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text12).ToString());
                                        if (num6 > 0)
                                        {
                                            int num7 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text12 + " AND isuseable=1").ToString());
                                            if (num6 < (num7 + 1))
                                            {
                                                base2.Dispose();
                                                MyFunc.showmsg("该代理商的最大会员数为 " + num6.ToString() + ",不能再添加新会员");
                                                base.Response.End();
                                                return;
                                            }
                                        }
                                        else
                                        {
                                            int num8 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + selectedValue).ToString());
                                            if (num8 > 0)
                                            {
                                                int num9 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE zdlid=" + selectedValue + " AND isuseable=1").ToString());
                                                if (num8 < (num9 + 1))
                                                {
                                                    base2.Dispose();
                                                    MyFunc.showmsg("该总代理的最大会员数为 " + num6.ToString() + ",不能再添加新会员");
                                                    base.Response.End();
                                                    return;
                                                }
                                            }
                                            else
                                            {
                                                int num10 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text8).ToString());
                                                if (num10 > 0)
                                                {
                                                    int num11 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid=" + text8 + " AND isuseable=1").ToString());
                                                    if (num10 < (num11 + 1))
                                                    {
                                                        base2.Dispose();
                                                        MyFunc.showmsg("您的最大会员数为 " + num6.ToString() + ",不能再添加新会员");
                                                        base.Response.End();
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                        if (base2.ExecuteNonQuery("INSERT INTO member(username,userpass,truename,tel,regtime,isuseable,usemoney,moneysort,moneyrate,gdid,gdname,zdlid,zdlname,dlsid,dlsname,pltype,usertype,abc,curmoney)VALUES('" + input + "','" + text2 + "','" + text4 + "','" + text5 + "',GetDate(),1," + s + ",'" + text14 + "'," + text15 + "," + text8 + ",'" + text9 + "'," + selectedValue + ",'" + text + "'," + text12 + ",'" + text13 + "','" + text16 + "','" + text17 + "','" + text18 + "'," + s + ")") > 0)
                                        {
                                            string text19 = base2.ExecuteScalar("SELECT userid FROM member WHERE username='" + input + "'").ToString();
                                            base2.ExecuteNonQuery("insert userhs select '" + text19 + "',w1,w2,w3,w4,w5,w6,w7,w8,w9,w10,w11,w12,w13,w14,w15,l1,l2,l3,l4,l5,l6,l7,l8,l9,l10,l11,l12,l13,l14,l15,maxC1,maxC2,maxC3,maxC4,maxC5,maxC6,maxC7,maxC8,maxC9,maxC10,maxC11,maxC12,maxC13,maxC14,maxC15,maxZ1,maxZ2,maxZ3,maxZ4,maxZ5,maxZ6,maxZ7,maxZ8,maxZ9,maxZ10,maxZ11,maxZ12,maxZ13,maxZ14,maxZ15,W28,L28,maxC28,maxZ28,maxZ18,maxZ19,maxZ20,maxZ21,maxZ22,maxZ23,maxZ24,maxC18,maxC19,maxC20,maxC21,maxC22,maxC23,maxC24,w18,w19,w20,w21,w22,w23,w24,l18,l19,l20,l21,l22,l23,l24 from hs join agence on hs.userid = agence.userid where hs.userid='" + text12 + "' and hs.type='" + text18 + "'");
                                            base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount+1 WHERE userid=" + text12);
                                            base2.Dispose();
                                            MyFunc.JumpPage("添加会员成功!", "userlist.aspx");
                                        }
                                        else
                                        {
                                            base2.Dispose();
                                            MyFunc.showmsg("添加会员失败!");
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

        private void DlsUseMoney(DataBase db)
        {
            if ((this.DropDownListDls.SelectedValue != null) && (this.DropDownListDls.SelectedValue != ""))
            {
                int num = int.Parse(db.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + this.DropDownListDls.SelectedValue).ToString());
                int num2 = int.Parse(db.ExecuteScalar("SELECT ISNULL(sum(usemoney),0) FROM member WHERE dlsid=" + this.DropDownListDls.SelectedValue).ToString());
                int num3 = num - num2;
                this.LabelUseMoney.Text = MyFunc.NumBerFormat(num3.ToString(), true) + " / " + MyFunc.NumBerFormat(num.ToString(), true);
            }
        }

        public void DropDownListDls_SelectedIndexChanged(object sender, EventArgs e)
        {
            if ((this.DropDownListDls.SelectedValue != null) && (this.DropDownListDls.SelectedValue != ""))
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                this.DlsUseMoney(db);
                db.Dispose();
            }
        }

        public void DropDownListGd_SelectedIndexChanged(object sender, EventArgs e)
        {
            string text = this.DropDownListGd.SelectedValue.Trim();
            if (text != "00")
            {
                this.LabelUseMoney.Text = "";
                this.DropDownListZdl.Items.Clear();
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = db.ExecuteReader("SELECT userid,username FROM agence WHERE gdid=" + text + " and classid=3");
                while (reader.Read())
                {
                    this.DropDownListZdl.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                if (this.DropDownListZdl.Items.Count < 1)
                {
                    this.DropDownListZdl.Items.Add(new ListItem("", ""));
                    this.DropDownListDls.Items.Clear();
                    this.DropDownListDls.Items.Add(new ListItem("", ""));
                }
                else
                {
                    SqlDataReader reader2 = db.ExecuteReader("SELECT userid,username FROM agence WHERE zdlid=" + this.DropDownListZdl.SelectedValue + " AND classid=4");
                    this.DropDownListDls.Items.Clear();
                    while (reader2.Read())
                    {
                        this.DropDownListDls.Items.Add(new ListItem(reader2["username"].ToString().Trim(), reader2["userid"].ToString().Trim()));
                    }
                    reader2.Close();
                    this.DropDownListDls.SelectedIndex = 0;
                    this.DlsUseMoney(db);
                }
                this.DropDownListRate.Items.Clear();
                SqlDataReader reader3 = db.ExecuteReader("SELECT * FROM rate");
                while (reader3.Read())
                {
                    this.DropDownListRate.Items.Add(new ListItem(reader3["type"].ToString().Trim(), reader3["rate"].ToString().Trim()));
                    base.Response.Write("<span style='display:none' id='rate_" + reader3["type"].ToString().Trim() + "'>" + reader3["rate"].ToString().Trim() + "</span>");
                }
                reader3.Close();
                this.DropDownListRate.Items.FindByText("CNY").Selected = true;
                this.TextBoxUseMoney.Attributes["OnKeyUp"] = "setCurrentCreditLocal()";
                this.DropDownListRate.Attributes["OnChange"] = "setCurrentCreditLocal()";
                db.Dispose();
                this.DropDownListDls.Attributes["OnChange"] = "account();";
                this.DropDownListName2.Attributes["OnChange"] = "account();";
                this.DropDownListName3.Attributes["OnChange"] = "account();";
            }
        }

        public void DropDownListZdl_SelectedIndexChanged(object sender, EventArgs e)
        {
            if ((this.DropDownListZdl.SelectedValue != null) && (this.DropDownListZdl.SelectedValue != ""))
            {
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = db.ExecuteReader("SELECT userid,username FROM agence WHERE zdlid=" + this.DropDownListZdl.SelectedValue);
                this.DropDownListDls.Items.Clear();
                while (reader.Read())
                {
                    this.DropDownListDls.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                if (this.DropDownListDls.Items.Count > 0)
                {
                    this.DropDownListDls.SelectedIndex = 0;
                    this.DlsUseMoney(db);
                    db.Dispose();
                }
                else
                {
                    this.DropDownListDls.Items.Add(new ListItem("", ""));
                    db.Dispose();
                }
            }
        }

        private void InitializeComponent()
        {
            this.DropDownListGd.SelectedIndexChanged += new EventHandler(this.DropDownListGd_SelectedIndexChanged);
            this.DropDownListZdl.SelectedIndexChanged += new EventHandler(this.DropDownListZdl_SelectedIndexChanged);
            this.DropDownListDls.SelectedIndexChanged += new EventHandler(this.DropDownListDls_SelectedIndexChanged);
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
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,gdbl FROM agence WHERE classid=2");
                this.DropDownListGd.Items.Clear();
                this.DropDownListGd.Items.Add(new ListItem("请选择", "00"));
                while (reader.Read())
                {
                    this.DropDownListGd.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                if (this.DropDownListGd.Items.Count < 2)
                {
                    base2.Dispose();
                    MyFunc.showmsg("请先添加股东");
                    base.Response.End();
                }
                else
                {
                    this.DropDownListGd.SelectedIndex = 0;
                    base2.Dispose();
                }
            }
        }
    }
}

