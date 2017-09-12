namespace mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class gsmsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonModify;
        protected Button ButtonSave;
        protected Label Label1;
        public string pubshowpass = "";
        protected TextBox TextBoxGsID;
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
            base.Response.Redirect("gslist.aspx", true);
        }

        private void ButtonCancel_Click(object sender, EventArgs e)
        {
        }

        private void ButtonModify_Click(object sender, EventArgs e)
        {
        }

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            string text7 = "";
            string text6 = this.TextBoxGsID.Text.Trim();
            string input = this.TextBoxUserName.Text.Trim();
            string text2 = this.TextBoxNewpass1.Text.Trim();
            string text3 = this.TextBoxNewpass2.Text.Trim();
            string text4 = this.TextBoxTrueName.Text.Trim();
            string s = this.TextBoxUseMoney.Text.Trim();
            string text8 = this.TextBoxMaxMem.Text.Trim();
            if (((text6 == "") || (input == "")) || ((text4 == "") || (text8 == "")))
            {
                MyFunc.showmsg("请输入公司帐号,名称,成数和最大会员数");
                base.Response.End();
            }
            else
            {
                Regex regex = new Regex("[^'*%=\"<>/|]");
                Regex regex2 = new Regex("[^'*%=\"<>/|]");
                if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                {
                    MyFunc.showmsg("公司帐号或股东名里含有非法字符");
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
                        text7 = ",userpass='" + text2 + "'";
                    }
                    if (text4.Length > 8)
                    {
                        MyFunc.showmsg("公司名称不能大于8个字符(4个汉字)");
                        base.Response.End();
                    }
                    else
                    {
                        try
                        {
                            if (int.Parse(s) >= 0)
                            {
                                try
                                {
                                    int.Parse(text8);
                                }
                                catch
                                {
                                    MyFunc.showmsg("请输入正确的最大会员数");
                                    base.Response.End();
                                    return;
                                }
                                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                if (int.Parse(base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE userid=" + text6).ToString()) < 1)
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("没有该公司");
                                }
                                else
                                {
                                    string text9 = base2.ExecuteScalar("select arrgd+'-1' from agence where userid ='" + text6 + "'").ToString();
                                    int num2 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid in (" + text9 + ")").ToString());
                                    if ((num2 > int.Parse(text8)) && (int.Parse(text8) != 0))
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("该公司已有 " + num2.ToString() + " 个会员,设置的最大会员数最小为" + num2.ToString());
                                        base.Response.End();
                                    }
                                    else if (base2.ExecuteNonQuery("UPDATE agence SET truename='" + text4 + "'" + text7 + ",maxmem=" + text8 + ",usemoney=" + s + " WHERE userid=" + text6) > 0)
                                    {
                                        base2.Dispose();
                                        MyFunc.JumpPage("修改公司成功!", "gslist.aspx");
                                    }
                                    else
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("修改公司失败!");
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
            this.ButtonModify.Click += new EventHandler(this.ButtonModify_Click);
            this.ButtonSave.Click += new EventHandler(this.ButtonSave_Click);
            this.ButtonCancel.Click += new EventHandler(this.ButtonCancel_Click);
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
                else if ((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != ""))
                {
                    this.TextBoxBorder(true);
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,truename,usemoney,maxmem FROM agence WHERE userid=" + base.Request.QueryString["id"].ToString().Trim());
                    if (reader.Read())
                    {
                        this.TextBoxGsID.Text = reader["userid"].ToString().Trim();
                        this.pubshowpass = reader["userpass"].ToString().Trim();
                        this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                        this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                        this.TextBoxUseMoney.Text = reader["usemoney"].ToString().Trim();
                        this.TextBoxMaxMem.Text = reader["maxmem"].ToString().Trim();
                        reader.Close();
                        base2.Dispose();
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("没有该公司! ");
                    }
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

