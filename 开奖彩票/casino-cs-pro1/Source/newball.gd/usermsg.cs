namespace newball.gd
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class usermsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected DropDownList DropDownList1;
        protected DropDownList DropDownListABC;
        protected DropDownList DropDownListPlType;
        protected DropDownList DropDownListRate;
        protected Label LabelDls;
        protected Label LabelGd;
        protected Label LabelUseMoney;
        protected Label LabelZdl;
        public string pubshowpass = "";
        protected RadioButton RadioButton1;
        protected RadioButton RadioButton2;
        protected TextBox TextBoxDlsid;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserID;
        protected TextBox TextBoxUserName;

        private void ButtonCancel_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("userlist.aspx", true);
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
                string text = "";
                string text2 = this.TextBoxUserID.Text.Trim();
                string text3 = this.TextBoxNewpass1.Text.Trim();
                string text4 = this.TextBoxNewpass2.Text.Trim();
                string input = this.TextBoxTrueName.Text.Trim();
                string text8 = "1";
                string text6 = this.TextBoxTel.Text.Trim().Replace("'", "").Replace("%", "");
                string s = this.TextBoxUseMoney.Text.Trim();
                string text10 = this.Session.Contents["adminuserid"].ToString().Trim();
                string text11 = this.Session.Contents["adminusername"].ToString().Trim();
                string text9 = this.TextBoxDlsid.Text.Trim();
                string text12 = this.DropDownListRate.SelectedItem.Text;
                string selectedValue = this.DropDownListRate.SelectedValue;
                string text14 = this.DropDownListPlType.SelectedValue;
                string text15 = this.RadioButton1.Checked ? "信用" : "现金";
                string text16 = this.DropDownListABC.SelectedValue;
                if ((((text2 == "") || (input == "")) || ((text8 == "") || (s == ""))) || ((((text10 == "") || (text11 == "")) || ((text14 == "") || (text15 == ""))) || (((text16 == "") || (text12 == "")) || (selectedValue == ""))))
                {
                    MyFunc.showmsg("请输入会员帐号,名称,信用额度");
                    base.Response.End();
                }
                else
                {
                    Regex regex = new Regex("[^'*%=\"<>/|]");
                    Regex regex2 = new Regex("[^'*%=\"<>/|]");
                    if (!regex2.IsMatch(input))
                    {
                        MyFunc.showmsg("会员名称里含有非法字符");
                        base.Response.End();
                    }
                    else
                    {
                        if ((text3 != "") && (text4 != ""))
                        {
                            if (text3 != text4)
                            {
                                MyFunc.showmsg("输入的密码不相同");
                                return;
                            }
                            text = ",userpass='" + text3 + "'";
                        }
                        if (input.Length > 8)
                        {
                            MyFunc.showmsg("会员名称不能大于8个字符(4个汉字)");
                            base.Response.End();
                        }
                        else
                        {
                            try
                            {
                                int num = (int) (int.Parse(s) * float.Parse(selectedValue));
                                if (num >= 0)
                                {
                                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                    int num2 = int.Parse(base2.ExecuteScalar("SELECT usemoney FROM agence WHERE userid=" + text9).ToString());
                                    int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + text9 + " AND userid<>" + text2).ToString());
                                    int num4 = num2 - num3;
                                    if (int.Parse(s) > num4)
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("信用度额不能大于总代理可用信用度额");
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        double num5 = double.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney-curmoney,0) FROM member WHERE userid=" + text2).ToString());
                                        text = text + ",curmoney=" + ((double.Parse(s) - num5)).ToString();
                                        int num6 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM member WHERE userid=" + text2);
                                        if (num6 < 1)
                                        {
                                            base2.Dispose();
                                            MyFunc.showmsg("没有该会员帐号!");
                                            base.Response.End();
                                        }
                                        else
                                        {
                                            if (text16.ToString().Trim().ToUpper() != base2.ExecuteScalar("select abc from member where userid ='" + text2 + "'").ToString().Trim().ToUpper())
                                            {
                                                base2.ExecuteNonQuery("DELETE FROM userhs where userid = '" + text2 + "'");
                                                base2.ExecuteNonQuery("insert userhs select  '" + text2.ToString().Trim() + "',w1,w2,w3,w4,w5,w6,w7,w8,w9,w10,w11,w12,w13,w14,w15,l1,l2,l3,l4,l5,l6,l7,l8,l9,l10,l11,l12,l13,l14,l15,maxC1,maxC2,maxC3,maxC4,maxC5,maxC6,maxC7,maxC8,maxC9,maxC10,maxC11,maxC12,maxC13,maxC14,maxC15,maxZ1,maxZ2,maxZ3,maxZ4,maxZ5,maxZ6,maxZ7,maxZ8,maxZ9,maxZ10,maxZ11,maxZ12,maxZ13,maxZ14,maxZ15,W28,L28,maxC28,maxZ28,maxZ18,maxZ19,maxZ20,maxZ21,maxZ22,maxZ23,maxZ24,maxC18,maxC19,maxC20,maxC21,maxC22,maxC23,maxC24,w18,w19,w20,w21,w22,w23,w24,l18,l19,l20,l21,l22,l23,l24 from hs join agence on hs.userid = agence.userid where hs.userid='" + text9 + "' and hs.type='" + text16 + "'");
                                            }
                                            if (base2.ExecuteNonQuery("UPDATE member SET truename='" + input + "'" + text + ",tel='" + text6 + "',usemoney=" + s + ",moneysort='" + text12 + "',moneyrate=" + selectedValue + ",pltype='" + text14 + "',usertype='" + text15 + "',abc='" + text16 + "' WHERE userid=" + text2 + " AND gdid=" + text10) > 0)
                                            {
                                                base2.Dispose();
                                                MyFunc.JumpPage("修改会员成功!", "userlist.aspx");
                                            }
                                            else
                                            {
                                                base2.Dispose();
                                                MyFunc.showmsg("修改会员失败!");
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
        }

        private void DlsUseMoney(DataBase db)
        {
            int num = int.Parse(db.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + this.TextBoxDlsid.Text.Trim()).ToString());
            int num2 = int.Parse(db.ExecuteScalar("SELECT ISNULL(sum(usemoney),0) FROM member WHERE dlsid=" + this.TextBoxDlsid.Text.Trim()).ToString());
            int num3 = num - num2;
            this.LabelUseMoney.Text = MyFunc.NumBerFormat(num3.ToString(), true) + " / " + MyFunc.NumBerFormat(num.ToString(), true);
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
                if ((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    string text = base.Request.QueryString["id"].ToString().Trim();
                    DataBase db = new DataBase(MyFunc.GetConnStr(2));
                    this.DropDownListRate.Items.Clear();
                    SqlDataReader reader = db.ExecuteReader("SELECT * FROM rate");
                    while (reader.Read())
                    {
                        this.DropDownListRate.Items.Add(new ListItem(reader["type"].ToString().Trim(), reader["rate"].ToString().Trim()));
                    }
                    reader.Close();
                    this.LabelGd.Text = this.Session.Contents["adminusername"].ToString().Trim();
                    this.LabelUseMoney.Text = "";
                    SqlDataReader reader2 = db.ExecuteReader("SELECT userid,username,userpass,zdlid,zdlname,dlsid,dlsname,usemoney,moneysort,usertype,pltype,tel,truename,abc FROM member WHERE userid=" + text);
                    if (!reader2.Read())
                    {
                        reader2.Close();
                        db.Dispose();
                        MyFunc.showmsg("没有该会员");
                        base.Response.End();
                        return;
                    }
                    this.LabelZdl.Text = reader2["zdlname"].ToString().Trim();
                    this.LabelDls.Text = reader2["dlsname"].ToString().Trim();
                    this.TextBoxDlsid.Text = reader2["dlsid"].ToString().Trim();
                    this.TextBoxUserName.Text = reader2["username"].ToString().Trim();
                    this.pubshowpass = reader2["userpass"].ToString().Trim();
                    this.TextBoxTrueName.Text = reader2["truename"].ToString().Trim();
                    this.TextBoxTel.Text = reader2["tel"].ToString().Trim();
                    this.DropDownListABC.SelectedValue = reader2["abc"].ToString().Trim().ToUpper();
                    this.DropDownListPlType.SelectedValue = reader2["pltype"].ToString().Trim();
                    if (reader2["usertype"].ToString().Trim() == "信用")
                    {
                        this.RadioButton1.Checked = true;
                    }
                    else
                    {
                        this.RadioButton2.Checked = true;
                    }
                    this.DropDownListRate.Items.FindByText(reader2["moneysort"].ToString().Trim().ToUpper()).Selected = true;
                    this.TextBoxUseMoney.Text = reader2["usemoney"].ToString().Trim();
                    this.TextBoxUserID.Text = reader2["userid"].ToString().Trim();
                    reader2.Close();
                    this.DlsUseMoney(db);
                    db.Dispose();
                }
                this.TextBoxUseMoney.Attributes["OnKeyUp"] = "setCurrentCreditLocal()";
                this.DropDownListRate.Attributes["OnChange"] = "setCurrentCreditLocal()";
            }
        }
    }
}

