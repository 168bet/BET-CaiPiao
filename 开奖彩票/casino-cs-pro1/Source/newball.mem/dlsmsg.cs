namespace newball.mem
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

    public class dlsmsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonModify;
        protected Button ButtonSave;
        protected DropDownList DropDownListDlsBl;
        protected DropDownList DropDownListIsUseAble;
        protected DropDownList DropDownListZdlBl;
        public string kygluserid = "";
        public string kyglzdlid = "";
        protected Label Label1;
        protected Label LabelGd;
        public string pubshowpass = "";
        protected TextBox TextBoxDlsID;
        protected TextBox TextBoxGd;
        protected TextBox TextBoxGdId;
        protected HtmlInputHidden TextBoxGsGdBl;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;
        protected TextBox TextBoxZdl;
        protected TextBox TextBoxZdlID;

        private void Button1_Click(object sender, EventArgs e)
        {
            this.TextBoxBorder(true);
        }

        private void Button3_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("dlslist.aspx", true);
        }

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            string input;
            string s;
            string text6;
            string text7;
            string text8;
            string text9;
            string text11;
            string text12;
            string text13;
            string text14;
            string text15;
            string text16;
            DataBase base2;
            int num7;
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), "1", 1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                text11 = "";
                text12 = "";
                text13 = "";
                text14 = "";
                text15 = "";
                text7 = this.TextBoxDlsID.Text.Trim();
                string text = this.TextBoxUserName.Text.Trim();
                string text2 = this.TextBoxNewpass1.Text.Trim();
                string text3 = this.TextBoxNewpass2.Text.Trim();
                input = this.TextBoxTrueName.Text.Trim();
                s = this.TextBoxUseMoney.Text.Trim();
                text6 = this.DropDownListIsUseAble.SelectedValue.Trim();
                text9 = this.TextBoxZdlID.Text.Trim();
                string text10 = this.TextBoxGdId.Text.Trim();
                text8 = this.TextBoxTel.Text.Trim();
                text14 = this.DropDownListZdlBl.SelectedValue.Trim();
                text15 = this.DropDownListDlsBl.SelectedValue.Trim();
                text16 = this.TextBoxMaxMem.Text.Trim();
                if ((((text == "") || (input == "")) || ((text6 == "") || (s == ""))) || (((text14 == "") || (text15 == "")) || (text16 == "")))
                {
                    MyFunc.showmsg("请输入代理商帐号,密码,名称,即时注单状态,信用额度");
                    base.Response.End();
                }
                else
                {
                    Regex regex = new Regex("[^'*%=\"<>/|]");
                    Regex regex2 = new Regex("[^'*%=\"<>/|]");
                    if (!regex.IsMatch(text) || !regex2.IsMatch(input))
                    {
                        MyFunc.showmsg("代理商帐号或名称里含有非法字符");
                        base.Response.End();
                    }
                    else if (input.Length > 8)
                    {
                        MyFunc.showmsg("代理商名称不能大于8个字符(4个汉字)");
                        base.Response.End();
                    }
                    else
                    {
                        if ((text2 != "") && (text3 != ""))
                        {
                            if (text2 != text3)
                            {
                                MyFunc.showmsg("输入的密码不相同");
                                return;
                            }
                            text11 = ",userpass='" + text2 + "'";
                        }
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
                                base2 = new DataBase(MyFunc.GetConnStr(2));
                                text12 = base2.ExecuteScalar("SELECT gdbl FROM agence WHERE userid=" + text10).ToString();
                                text13 = base2.ExecuteScalar("SELECT gsbl FROM agence WHERE userid=" + text10).ToString();
                                if ((int.Parse(text14) + int.Parse(text15)) > (100 - int.Parse(text12)))
                                {
                                    MyFunc.showmsg("总代理,代理商的比例相加不能大于" + ((100 - int.Parse(text12))).ToString());
                                    base.Response.End();
                                    return;
                                }
                                text12 = (((100 - int.Parse(text15)) - int.Parse(text14)) - int.Parse(text13)).ToString();
                                int num2 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE userid=" + text7);
                                if (num2 < 1)
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("没有该代理商");
                                    return;
                                }
                                int num3 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text9).ToString());
                                if (num3 > 0)
                                {
                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text7).ToString());
                                    if (num4 > int.Parse(text16))
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("该代理商已有 " + num4.ToString() + " 个会员,设置的最大会员数最小为 " + num4.ToString());
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE zdlid=" + text9 + " AND classid=4 AND userid<>" + text7).ToString());
                                        if ((num4 + int.Parse(text16)) <= num3)
                                        {
                                            goto Label_05B5;
                                        }
                                        base2.Dispose();
                                        object[] objArray = new object[] { "该代理商的总代理最大会员数为 ", num3, " ,现在代理商最大会员数最大可设为 ", (num3 - num4).ToString() };
                                        MyFunc.showmsg(string.Concat(objArray));
                                        base.Response.End();
                                    }
                                    return;
                                }
                                int num5 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text10).ToString());
                                if (num5 > 0)
                                {
                                    int num6 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE gdid=" + text10 + " AND classid=4 AND userid<>" + text7).ToString());
                                    if ((num6 + int.Parse(text16)) > num5)
                                    {
                                        base2.Dispose();
                                        object[] objArray2 = new object[] { "该代理商的股东的最大会员数为 ", num5, " ,现在代理商最大会员数最大可设为 ", (num5 - num6).ToString() };
                                        MyFunc.showmsg(string.Concat(objArray2));
                                        base.Response.End();
                                        return;
                                    }
                                }
                                goto Label_05B5;
                            }
                            MyFunc.showmsg("请输入正确的信用额度");
                            base.Response.End();
                        }
                        catch
                        {
                            MyFunc.showmsg("请输入正确的信用额度");
                            base.Response.End();
                        }
                    }
                }
            }
            return;
        Label_05B5:
            num7 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text9).ToString());
            int num8 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + text9).ToString());
            int num9 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text7).ToString());
            if (int.Parse(s) > ((num7 - num8) + num9))
            {
                base2.Dispose();
                MyFunc.showmsg("代理商信用额度不能大于总代理可用信用额度");
                base.Response.End();
            }
            else if (base2.ExecuteNonQuery("UPDATE agence SET truename='" + input + "'" + text11 + ",usemoney=" + s + ",isuseable=" + text6 + ",tel='" + text8 + "',bl=" + text15 + ",gsbl=" + text13 + ",gdbl=" + text12 + ",zdlbl=" + text14 + ",maxmem=" + text16 + " WHERE userid=" + text7) > 0)
            {
                base2.Dispose();
                MyFunc.JumpPage("修改代理商成功!", "dlslist.aspx");
            }
            else
            {
                base2.Dispose();
                MyFunc.showmsg("修改代理商失败!");
            }
        }

        private int GetGdBl(string id)
        {
            int num = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            num = int.Parse(base2.ExecuteScalar("SELECT gdbl FROM agence WHERE userid=" + id).ToString());
            base2.Dispose();
            return num;
        }

        private void InitializeComponent()
        {
            this.ButtonModify.Click += new EventHandler(this.Button1_Click);
            this.ButtonSave.Click += new EventHandler(this.ButtonSave_Click);
            this.ButtonCancel.Click += new EventHandler(this.Button3_Click);
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
            else if ((!base.IsPostBack && (base.Request.Form["action"] == null)) && ((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != "")))
            {
                this.TextBoxBorder(true);
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,truename,usemoney,bl,gdbl,zdlbl,gsbl,isuseable,tel,zdlid,zdlname,gdid,gdname,maxmem FROM agence WHERE userid=" + base.Request.QueryString["id"].ToString().Trim());
                if (reader.Read())
                {
                    this.kygluserid = reader["userid"].ToString().Trim();
                    this.TextBoxDlsID.Text = reader["userid"].ToString().Trim();
                    this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                    this.pubshowpass = reader["userpass"].ToString().Trim();
                    this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                    this.TextBoxUseMoney.Text = reader["usemoney"].ToString().Trim();
                    this.TextBoxZdlID.Text = reader["zdlid"].ToString().Trim();
                    this.TextBoxZdl.Text = reader["zdlname"].ToString().Trim();
                    this.TextBoxGdId.Text = reader["gdid"].ToString().Trim();
                    this.TextBoxGd.Text = reader["gdname"].ToString().Trim();
                    this.TextBoxTel.Text = reader["tel"].ToString().Trim();
                    this.TextBoxMaxMem.Text = reader["maxmem"].ToString().Trim();
                    this.DropDownListIsUseAble.SelectedValue = (reader["isuseable"].ToString().Trim().ToUpper() == "TRUE") ? "1" : "0";
                    int gdBl = this.GetGdBl(reader["gdid"].ToString().Trim());
                    this.TextBoxGsGdBl.Value = gdBl.ToString();
                    this.DropDownListZdlBl.Items.Clear();
                    for (int i = 0; i <= (100 - gdBl); i++)
                    {
                        this.DropDownListZdlBl.Items.Add(new ListItem(i.ToString() + "%", i.ToString()));
                    }
                    this.DropDownListZdlBl.SelectedValue = reader["zdlbl"].ToString().Trim();
                    this.DropDownListDlsBl.Items.Clear();
                    for (int j = 0; j <= (100 - gdBl); j++)
                    {
                        this.DropDownListDlsBl.Items.Add(new ListItem(j.ToString() + "%", j.ToString()));
                    }
                    this.DropDownListDlsBl.SelectedValue = reader["bl"].ToString().Trim();
                }
                reader.Close();
                int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=1").ToString());
                int num5 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=0").ToString());
                int num6 = (int.Parse(this.TextBoxUseMoney.Text) - num4) - num5;
                this.Label1.Text = "启用:" + num4.ToString() + "　停用:" + num5.ToString() + "　可用:" + num6.ToString();
                base2.Dispose();
                this.DropDownListZdlBl.Attributes["OnChange"] = "chgzdl();";
            }
        }

        private void TextBoxBorder(bool show)
        {
            if (show)
            {
                this.TextBoxNewpass1.BorderWidth = 1;
                this.TextBoxNewpass2.BorderWidth = 1;
                this.TextBoxTrueName.BorderWidth = 1;
                this.TextBoxUseMoney.BorderWidth = 1;
                this.TextBoxTel.BorderWidth = 1;
                this.TextBoxMaxMem.BorderWidth = 1;
                this.DropDownListIsUseAble.Enabled = true;
                this.DropDownListZdlBl.Enabled = true;
                this.DropDownListDlsBl.Enabled = true;
                this.TextBoxNewpass1.ReadOnly = false;
                this.TextBoxNewpass2.ReadOnly = false;
                this.TextBoxTrueName.ReadOnly = false;
                this.TextBoxUseMoney.ReadOnly = false;
                this.TextBoxMaxMem.ReadOnly = false;
                this.TextBoxTel.ReadOnly = false;
                this.ButtonSave.Visible = true;
                this.ButtonCancel.Visible = true;
                this.ButtonModify.Visible = false;
            }
            else
            {
                this.TextBoxNewpass1.BorderWidth = 0;
                this.TextBoxNewpass2.BorderWidth = 0;
                this.TextBoxTrueName.BorderWidth = 0;
                this.TextBoxUseMoney.BorderWidth = 0;
                this.TextBoxMaxMem.BorderWidth = 0;
                this.TextBoxTel.BorderWidth = 0;
                this.DropDownListIsUseAble.Enabled = false;
                this.DropDownListZdlBl.Enabled = false;
                this.DropDownListDlsBl.Enabled = false;
                this.TextBoxTel.ReadOnly = true;
                this.TextBoxNewpass1.ReadOnly = true;
                this.TextBoxNewpass2.ReadOnly = true;
                this.TextBoxTrueName.ReadOnly = true;
                this.TextBoxUseMoney.ReadOnly = true;
                this.TextBoxMaxMem.ReadOnly = true;
                this.ButtonModify.Visible = true;
                this.ButtonSave.Visible = false;
                this.ButtonCancel.Visible = false;
            }
        }
    }
}

