namespace newball.zdl
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class dlsmsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonModify;
        protected Button ButtonSave;
        protected DropDownList DropDownListIsUseAble;
        public string kygluserid = "";
        public string kyglzdlid = "";
        protected Label Label1;
        protected Label LabelDlsBl;
        protected Label LabelZdl;
        protected Label LabelZdlBl;
        public string pubshowpass = "";
        protected TextBox TextBoxDlsID;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

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
            string text10;
            string text11;
            DataBase base2;
            int num7;
            if (!MyFunc.CheckUserLogin(this.Session.Contents["adminusername"].ToString().Trim(), this.Session.Contents["adminuserpass"].ToString().Trim(), this.Session.Contents["adminclassid"].ToString().Trim(), 1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                text10 = "";
                text7 = this.TextBoxDlsID.Text.Trim();
                string text = this.TextBoxUserName.Text.Trim();
                string text2 = this.TextBoxNewpass1.Text.Trim();
                string text3 = this.TextBoxNewpass2.Text.Trim();
                input = this.TextBoxTrueName.Text.Trim();
                s = this.TextBoxUseMoney.Text.Trim();
                text6 = this.DropDownListIsUseAble.SelectedValue.Trim();
                text9 = this.Session.Contents["adminuserid"].ToString().Trim();
                text8 = this.TextBoxTel.Text.Trim();
                text11 = this.TextBoxMaxMem.Text.Trim();
                if (((text == "") || (input == "")) || (((text6 == "") || (s == "")) || (text11 == "")))
                {
                    MyFunc.showmsg("请输入代理商帐号,密码,名称,即时注单状态,信用额度,最大会员数");
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
                            text10 = ",userpass='" + text2 + "'";
                        }
                        try
                        {
                            if (int.Parse(s) >= 0)
                            {
                                try
                                {
                                    int.Parse(text11);
                                }
                                catch
                                {
                                    MyFunc.showmsg("请输入正确的最大会员数");
                                    base.Response.End();
                                    return;
                                }
                                base2 = new DataBase(MyFunc.GetConnStr(2));
                                int num2 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE userid=" + text7 + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                                if (num2 < 1)
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("没有该代理商");
                                    return;
                                }
                                int num3 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString());
                                if (num3 > 0)
                                {
                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text7).ToString());
                                    if (num4 > int.Parse(text11))
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("该代理商已有 " + num4.ToString() + " 个会员,设置的最大会员数最小为 " + num4.ToString());
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim() + " AND classid=4").ToString());
                                        if ((num4 + int.Parse(text11)) <= num3)
                                        {
                                            goto Label_055B;
                                        }
                                        base2.Dispose();
                                        object[] objArray = new object[] { "您的最大会员数为 ", num3, " ,现在代理商最大会员数最大可设为 ", (num3 - num4).ToString() };
                                        MyFunc.showmsg(string.Concat(objArray));
                                        base.Response.End();
                                    }
                                    return;
                                }
                                string text12 = base2.ExecuteScalar("SELECT gdid FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString();
                                int num5 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text12).ToString());
                                if (num5 > 0)
                                {
                                    int num6 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE gdid=" + text12 + " AND classid=4").ToString());
                                    if ((num6 + int.Parse(text11)) > num5)
                                    {
                                        base2.Dispose();
                                        object[] objArray2 = new object[] { "您的的最大会员数为 ", num5, " ,现在代理商最大会员数最大可设为 ", (num5 - num6).ToString() };
                                        MyFunc.showmsg(string.Concat(objArray2));
                                        base.Response.End();
                                        return;
                                    }
                                }
                                goto Label_055B;
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
        Label_055B:
            num7 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text9).ToString());
            int num8 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + text9).ToString());
            int num9 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text7).ToString());
            int num10 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + text7).ToString());
            if (int.Parse(s) > ((num7 - num8) + num9))
            {
                base2.Dispose();
                MyFunc.showmsg("代理商信用额度不能大于总代理可用信用额度");
                base.Response.End();
            }
            else if (int.Parse(s) < num10)
            {
                base2.Dispose();
                MyFunc.showmsg("信用额度不能小于已开会员的信用额度总合！");
                base.Response.End();
            }
            else if (base2.ExecuteNonQuery("UPDATE agence SET truename='" + input + "'" + text10 + ",usemoney=" + s + ",isuseable=" + text6 + ",tel='" + text8 + "',maxmem=" + text11 + " WHERE userid=" + text7 + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim()) > 0)
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
            else if (!base.IsPostBack)
            {
                this.LabelZdl.Text = this.Session.Contents["adminusername"].ToString().Trim();
                if (((base.Request.Form["action"] == null) && (base.Request.QueryString["id"] != null)) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    this.TextBoxBorder(true);
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    string text = base2.ExecuteScalar("SELECT gdid FROM agence WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim()).ToString();
                    int num = int.Parse(base2.ExecuteScalar("SELECT gdbl FROM agence WHERE userid=" + text).ToString());
                    SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,truename,usemoney,bl,gdbl,zdlbl,gsbl,isuseable,tel,zdlid,zdlname,maxmem FROM agence WHERE userid=" + base.Request.QueryString["id"].ToString().Trim() + " AND zdlid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                    if (reader.Read())
                    {
                        this.kygluserid = reader["userid"].ToString().Trim();
                        this.TextBoxDlsID.Text = reader["userid"].ToString().Trim();
                        this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                        this.pubshowpass = reader["userpass"].ToString().Trim();
                        this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                        this.TextBoxUseMoney.Text = reader["usemoney"].ToString().Trim();
                        this.TextBoxTel.Text = reader["tel"].ToString().Trim();
                        this.TextBoxMaxMem.Text = reader["maxmem"].ToString().Trim();
                        this.DropDownListIsUseAble.SelectedValue = (reader["isuseable"].ToString().Trim().ToUpper() == "TRUE") ? "1" : "0";
                        this.LabelZdlBl.Text = reader["Zdlbl"].ToString().Trim() + " %";
                        this.LabelDlsBl.Text = reader["bl"].ToString().Trim() + " %";
                    }
                    reader.Close();
                    int num2 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=1").ToString());
                    int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + this.kygluserid + " AND isuseable=0").ToString());
                    int num4 = (int.Parse(this.TextBoxUseMoney.Text) - num2) - num3;
                    this.Label1.Text = "使用状况：启用:" + num2.ToString() + "　停用:" + num3.ToString() + "　可用:" + num4.ToString();
                    base2.Dispose();
                }
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

