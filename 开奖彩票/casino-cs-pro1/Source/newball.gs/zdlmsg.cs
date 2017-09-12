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

    public class zdlmsg : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonModify;
        protected Button ButtonSave;
        protected DropDownList DropDownListIsUseAble;
        protected Label Label1;
        protected Label LabelZdl;
        public string pubshowpass = "";
        protected TextBox TextBoxGdID;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;
        protected TextBox TextBoxZdlID;

        private void Button1_Click(object sender, EventArgs e)
        {
            this.TextBoxBorder(true);
        }

        private void Button3_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("zdllist.aspx", true);
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
                string text10 = "";
                string text7 = this.TextBoxZdlID.Text.Trim();
                string text8 = this.TextBoxGdID.Text.Trim();
                string input = this.TextBoxUserName.Text.Trim();
                string text2 = this.TextBoxNewpass1.Text.Trim();
                string text3 = this.TextBoxNewpass2.Text.Trim();
                string text4 = this.TextBoxTrueName.Text.Trim();
                string s = this.TextBoxUseMoney.Text.Trim();
                string text11 = this.TextBoxMaxMem.Text.Trim();
                string text9 = this.TextBoxTel.Text.Trim().Replace("'", "").Replace(" ", "").Replace("%", "");
                string text6 = this.DropDownListIsUseAble.SelectedValue.Trim();
                if (((input == "") || (text4 == "")) || (((text6 == "") || (s == "")) || (text11 == "")))
                {
                    MyFunc.showmsg("请输入总代理帐号,密码,名称,即时注单状态,信用额度,最大会员数");
                    base.Response.End();
                }
                else
                {
                    Regex regex = new Regex("[^'*%=\"<>/|]");
                    Regex regex2 = new Regex("[^'*%=\"<>/|]");
                    if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                    {
                        MyFunc.showmsg("总代理帐号或名称里含有非法字符");
                        base.Response.End();
                    }
                    else if (text4.Length > 8)
                    {
                        MyFunc.showmsg("股东名称不能大于8个字符(4个汉字)");
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
                                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                                int num2 = (int) base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE userid=" + text7);
                                if (num2 < 1)
                                {
                                    base2.Dispose();
                                    MyFunc.showmsg("没有该总代理");
                                    base.Response.End();
                                }
                                else
                                {
                                    int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text8).ToString());
                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + text8 + " and classid = 3").ToString());
                                    int num5 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + text7).ToString());
                                    if (int.Parse(s) > ((num3 - num4) + num5))
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("总代理信用额度不能大于股东可用信用额度");
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        int num6 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text8).ToString());
                                        if (num6 > 0)
                                        {
                                            int num7 = int.Parse(base2.ExecuteScalar("SELECT COUNT(1) FROM member WHERE zdlid=" + text7).ToString());
                                            if (num7 > int.Parse(text11))
                                            {
                                                base2.Dispose();
                                                MyFunc.showmsg("该总代理已有 " + num7.ToString() + " 个会员,设置的最大会员数最小为 " + num7.ToString());
                                                base.Response.End();
                                                return;
                                            }
                                            num7 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE gdid=" + text8 + " AND classid=3 AND userid<>" + text7).ToString());
                                            if ((num7 + int.Parse(text11)) > num6)
                                            {
                                                base2.Dispose();
                                                object[] objArray = new object[] { "股东最大会员数为 ", num6, " ,现在总代理最大会员数最大可设为 ", (num6 - num7).ToString() };
                                                MyFunc.showmsg(string.Concat(objArray));
                                                base.Response.End();
                                                return;
                                            }
                                        }
                                        if (base2.ExecuteNonQuery("UPDATE agence SET truename='" + text4 + "'" + text10 + ",usemoney=" + s + ",isuseable=" + text6 + ",tel='" + text9 + "',maxmem=" + text11 + " WHERE userid=" + text7 + " AND gdid=" + text8) > 0)
                                        {
                                            base2.Dispose();
                                            MyFunc.JumpPage("修改总代理成功!", "zdllist.aspx");
                                        }
                                        else
                                        {
                                            base2.Dispose();
                                            MyFunc.showmsg("修改总代理失败!");
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
                if (((base.Request.Form["action"] != null) || (base.Request.QueryString["id"] == null)) || (base.Request.QueryString["id"].ToString().Trim() == ""))
                {
                    MyFunc.showmsg("出错了!");
                    base.Response.End();
                }
                else
                {
                    this.TextBoxBorder(true);
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    SqlDataReader reader = base2.ExecuteReader("SELECT userid,username,userpass,gdid,zdlid,zdlname,truename,tel,usemoney,isuseable,maxmem FROM agence WHERE userid=" + base.Request.QueryString["id"].ToString().Trim());
                    if (reader.Read())
                    {
                        this.TextBoxGdID.Text = reader["gdid"].ToString().Trim();
                        this.TextBoxZdlID.Text = reader["userid"].ToString().Trim();
                        this.TextBoxUserName.Text = reader["username"].ToString().Trim();
                        this.pubshowpass = reader["userpass"].ToString().Trim();
                        this.TextBoxTrueName.Text = reader["truename"].ToString().Trim();
                        this.TextBoxUseMoney.Text = reader["usemoney"].ToString().Trim();
                        this.TextBoxTel.Text = reader["tel"].ToString().Trim();
                        this.TextBoxMaxMem.Text = reader["maxmem"].ToString().Trim();
                        this.DropDownListIsUseAble.SelectedValue = (reader["isuseable"].ToString().Trim().ToUpper() == "TRUE") ? "1" : "0";
                        this.LabelZdl.Text = reader["username"].ToString().Trim();
                        reader.Close();
                        int num = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + this.TextBoxZdlID.Text + " AND isuseable=1 AND classid = 4").ToString());
                        int num2 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE zdlid=" + this.TextBoxZdlID.Text + " AND isuseable=0 AND classid = 4").ToString());
                        int num3 = (int.Parse(this.TextBoxUseMoney.Text) - num) - num2;
                        this.Label1.Text = "启用:" + num.ToString() + "　停用:" + num2.ToString() + "　可用:" + num3.ToString();
                        base2.Dispose();
                        this.DataBind();
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("没有总代理! ");
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
                this.TextBoxNewpass1.ReadOnly = true;
                this.TextBoxNewpass2.ReadOnly = true;
                this.TextBoxTrueName.ReadOnly = true;
                this.TextBoxUseMoney.ReadOnly = true;
                this.TextBoxMaxMem.ReadOnly = true;
                this.TextBoxTel.ReadOnly = true;
                this.ButtonModify.Visible = true;
                this.ButtonSave.Visible = false;
                this.ButtonCancel.Visible = false;
            }
        }
    }
}

