namespace mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Text.RegularExpressions;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class gsadd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

        private void ButtonSave_Click(object sender, EventArgs e)
        {
            string input = this.TextBoxUserName.Text.Trim().ToLower();
            string text2 = this.TextBoxNewpass1.Text.Trim();
            string text3 = this.TextBoxNewpass2.Text.Trim();
            string text4 = this.TextBoxTrueName.Text.Trim();
            string s = this.TextBoxUseMoney.Text.Trim();
            string text5 = this.TextBoxMaxMem.Text.Trim();
            if (((input == "") || (text2 == "")) || ((text3 == "") || (text4 == "")))
            {
                MyFunc.showmsg("请输入公司帐号,密码,名称和比例");
                base.Response.End();
            }
            else if (input.Length < 3)
            {
                MyFunc.showmsg("公司帐号不能小于3个字符");
                base.Response.End();
            }
            else if (text4.Length > 8)
            {
                MyFunc.showmsg("公司名称不能大于8个字符(4个汉字)");
                base.Response.End();
            }
            else
            {
                Regex regex = new Regex("[^'*%=\"<>/|]");
                Regex regex2 = new Regex("[^'*%=\"<>/|]");
                if (!regex.IsMatch(input) || !regex2.IsMatch(text4))
                {
                    MyFunc.showmsg("公司帐号或公司名里含有非法字符");
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
                                int.Parse(text5);
                            }
                            catch
                            {
                                MyFunc.showmsg("请输入正确的最大会员数");
                                base.Response.End();
                                return;
                            }
                            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                            if (int.Parse(base2.ExecuteScalar("SELECT COUNT(*) FROM agence WHERE username='" + input + "'").ToString()) > 0)
                            {
                                base2.Dispose();
                                MyFunc.showmsg("该公司帐号已存在!");
                                base.Response.End();
                            }
                            else if (base2.ExecuteNonQuery("INSERT INTO agence(username,userpass,truename,classid,regtime,isuseable,usemoney,maxmem)VALUES('" + input + "','" + text2 + "','" + text4 + "',0,GetDate(),1," + s + "," + text5 + ")") > 0)
                            {
                                string text7 = base2.ExecuteScalar("SELECT userid FROM agence WHERE username='" + input + "'").ToString();
                                base2.ExecuteNonQuery("INSERT INTO hs(userid,type)VALUES(" + text7 + ",'A');INSERT INTO hs(userid,type)VALUES(" + text7 + ",'B');INSERT INTO hs(userid,type)VALUES(" + text7 + ",'C');INSERT INTO hs(userid,type)VALUES(" + text7 + ",'D');");
                                base2.Dispose();
                                MyFunc.JumpPage("添加公司成功!", "gslist.aspx");
                            }
                            else
                            {
                                base2.Dispose();
                                MyFunc.showmsg("添加公司失败!");
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
        }
    }
}

