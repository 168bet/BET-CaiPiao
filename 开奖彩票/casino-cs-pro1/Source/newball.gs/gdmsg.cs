namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class gdmsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonModify;
        protected Button ButtonSave;
        protected DropDownList DropDownListBL;
        protected DropDownList DropDownListGsGd;
        protected Label Label1;
        public string pubshowpass = "";
        protected TextBox TextBoxGdID;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

        private void Button1_Click(object sender, EventArgs e)
        {
            this.TextBoxBorder(true);
        }

        private void Button3_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("gdlist.aspx", true);
        }

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            string text9 = "";
            string text8 = this.TextBoxGdID.Text.Trim();
            string input = this.TextBoxUserName.Text.Trim();
            string text2 = this.TextBoxNewpass1.Text.Trim();
            string text3 = this.TextBoxNewpass2.Text.Trim();
            string text4 = this.TextBoxTrueName.Text.Trim();
            string s = this.DropDownListBL.SelectedValue.Trim();
            string text6 = MyFunc.DefaultValue(base.Request.Form["DropDownListGsGd"], "");
            string text7 = this.TextBoxUseMoney.Text.Trim();
            string text10 = this.TextBoxMaxMem.Text.Trim();
            if ((((text8 == "") || (input == "")) || ((text4 == "") || (s == ""))) || ((text10 == "") || (text6 == "")))
            {
                MyFunc.showmsg("请输入股东帐号,名称,成数和最大会员数");
                base.Response.End();
            }
            else
            {
                Regex regex = new Regex("[^'*%=\"<>/|]");
                Regex regex2 = new Regex("[^'*%=\"<>/|]");
                if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                {
                    MyFunc.showmsg("股东帐号或股东名里含有非法字符");
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
                        text9 = ",userpass='" + text2 + "'";
                    }
                    if (text4.Length > 8)
                    {
                        MyFunc.showmsg("股东名称不能大于8个字符(4个汉字)");
                        base.Response.End();
                    }
                    else
                    {
                        try
                        {
                            int num = int.Parse(s);
                            if ((num >= 0) || (num <= 100))
                            {
                                try
                                {
                                    int num2 = int.Parse(text6);
                                    if ((num2 >= int.Parse(s)) || (num2 <= 100))
                                    {
                                        try
                                        {
                                            if (int.Parse(text7) >= 0)
                                            {
                                                try
                                                {
                                                    int.Parse(text10);
                                                }
                                                catch
                                                {
                                                    MyFunc.showmsg("请输入正确的最大会员数");
                                                    base.Response.End();
                                                    return;
                                                }
                                                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                                int num9 = 100 - int.Parse(text6);
                                                if (int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM agence WHERE gdid=" + text8 + " AND bl+zdlbl>" + num9.ToString()).ToString()) > 0)
                                                {
                                                    MyFunc.showmsg("不能修改股东成数,该股东下有总代理和代理商的成数和大于" + ((100 - int.Parse(s))).ToString());
                                                    base.Response.End();
                                                }
                                                else if (int.Parse(base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE userid=" + text8).ToString()) < 1)
                                                {
                                                    base2.Dispose();
                                                    MyFunc.showmsg("没有该股东");
                                                }
                                                else
                                                {
                                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + this.TextBoxGdID.Text + " AND isuseable=1 AND classid = 3").ToString());
                                                    int num5 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + this.TextBoxGdID.Text + " AND isuseable=0 AND classid = 3").ToString());
                                                    int num6 = (int.Parse(this.TextBoxUseMoney.Text) - num4) - num5;
                                                    if (num6 < 0)
                                                    {
                                                        base2.Dispose();
                                                        MyFunc.showmsg("信用额度一定要大于已用额度：" + ((num4 + num5)).ToString());
                                                        base.Response.End();
                                                    }
                                                    else
                                                    {
                                                        int num7 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid=" + text8).ToString());
                                                        if ((num7 > int.Parse(text10)) && (int.Parse(text10) != 0))
                                                        {
                                                            base2.Dispose();
                                                            MyFunc.showmsg("该股东已有 " + num7.ToString() + " 个会员,设置的最大会员数最小为" + num7.ToString());
                                                            base.Response.End();
                                                        }
                                                        else if (base2.ExecuteNonQuery("UPDATE agence SET truename='" + text4 + "'" + text9 + ",gsbl=" + s + ",gdbl=" + text6 + ",maxmem=" + text10 + ",usemoney=" + text7 + " WHERE userid=" + text8) > 0)
                                                        {
                                                            int num8 = int.Parse(text6) - int.Parse(s);
                                                            base2.ExecuteNonQuery("UPDATE agence SET gsbl=" + s + " WHERE gdid=" + text8 + " AND classid=4");
                                                            base2.ExecuteNonQuery("UPDATE agence SET gdbl=100-bl-zdlbl-gsbl WHERE gdid=" + text8 + " AND classid=4");
                                                            base2.Dispose();
                                                            MyFunc.JumpPage("修改股东成功!", "gdlist.aspx");
                                                        }
                                                        else
                                                        {
                                                            base2.Dispose();
                                                            MyFunc.showmsg("修改股东失败!");
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
                                    else
                                    {
                                        MyFunc.showmsg("请选择正确的公司+股东成数");
                                        base.Response.End();
                                    }
                                }
                                catch
                                {
                                    MyFunc.showmsg("请选择正确的公司+股东成数");
                                    base.Response.End();
                                }
                            }
                            else
                            {
                                MyFunc.showmsg("请选择正确的公司成数");
                                base.Response.End();
                            }
                        }
                        catch
                        {
                            MyFunc.showmsg("请选择正确的公司成数");
                            base.Response.End();
                        }
                    }
                }
            }
        }

        public void GsGdList(object sender, EventArgs e)
        {
            this.DropDownListGsGd.Items.Clear();
            for (int i = int.Parse(this.DropDownListBL.SelectedValue); i < 100; i++)
            {
                this.DropDownListGsGd.Items.Add(new ListItem(i.ToString() + " %", i.ToString()));
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
            if (!base.IsPostBack)
            {
                MyFunc.isRefUrl();
                if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
                {
                    MyFunc.goToLoginPage();
                }
                else
                {
                    if ((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                    {
                        this.TextBoxBorder(true);
                        DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                        SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,truename,gsbl,gdbl,usemoney,maxmem FROM agence WHERE userid=" + base.Request.QueryString["id"].ToString().Trim());
                        if (reader.Read())
                        {
                            this.TextBoxGdID.Text = reader["userid"].ToString().Trim();
                            this.pubshowpass = reader["userpass"].ToString().Trim();
                            this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                            this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                            this.TextBoxUseMoney.Text = reader["usemoney"].ToString().Trim();
                            this.TextBoxMaxMem.Text = reader["maxmem"].ToString().Trim();
                            this.DropDownListBL.Items.Clear();
                            for (int i = 0; i <= 100; i++)
                            {
                                this.DropDownListBL.Items.Add(new ListItem(i.ToString() + " %", i.ToString()));
                            }
                            this.DropDownListBL.SelectedValue = reader["gsbl"].ToString().Trim();
                            this.DropDownListGsGd.Items.Clear();
                            for (int j = int.Parse(reader["gsbl"].ToString().Trim()); j <= 100; j++)
                            {
                                this.DropDownListGsGd.Items.Add(new ListItem(j.ToString() + " %", j.ToString()));
                            }
                            this.DropDownListGsGd.SelectedValue = reader["gdbl"].ToString().Trim();
                            reader.Close();
                            int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + this.TextBoxGdID.Text + " AND isuseable=1 AND classid = 3").ToString());
                            int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + this.TextBoxGdID.Text + " AND isuseable=0 AND classid = 3").ToString());
                            int num5 = (int.Parse(this.TextBoxUseMoney.Text) - num3) - num4;
                            this.Label1.Text = "启用:" + num3.ToString() + "　停用:" + num4.ToString() + "　可用:" + num5.ToString();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            base2.Dispose();
                            MyFunc.showmsg("没有该股东! ");
                            return;
                        }
                    }
                    this.DropDownListBL.Attributes["OnChange"] = "RefreshList()";
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
                this.DropDownListBL.Enabled = true;
                this.DropDownListGsGd.Enabled = true;
                this.TextBoxMaxMem.BorderWidth = 1;
                this.TextBoxNewpass1.ReadOnly = false;
                this.TextBoxNewpass2.ReadOnly = false;
                this.TextBoxTrueName.ReadOnly = false;
                this.TextBoxMaxMem.ReadOnly = false;
                this.ButtonSave.Visible = true;
                this.ButtonCancel.Visible = true;
                this.ButtonModify.Visible = false;
            }
            else
            {
                this.TextBoxNewpass1.BorderWidth = 0;
                this.TextBoxNewpass2.BorderWidth = 0;
                this.TextBoxTrueName.BorderWidth = 0;
                this.TextBoxMaxMem.BorderWidth = 0;
                this.DropDownListBL.Enabled = false;
                this.DropDownListGsGd.Enabled = false;
                this.TextBoxNewpass1.ReadOnly = true;
                this.TextBoxNewpass2.ReadOnly = true;
                this.TextBoxTrueName.ReadOnly = true;
                this.TextBoxMaxMem.ReadOnly = true;
                this.ButtonModify.Visible = true;
                this.ButtonSave.Visible = false;
                this.ButtonCancel.Visible = false;
            }
        }
    }
}

