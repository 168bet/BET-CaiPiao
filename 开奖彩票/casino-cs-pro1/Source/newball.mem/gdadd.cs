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

    public class gdadd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected DropDownList DropDownListBL;
        protected DropDownList DropDownListGs;
        protected DropDownList DropDownListGsGd;
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
            string s = this.DropDownListBL.SelectedValue.Trim();
            string text6 = MyFunc.DefaultValue(base.Request.Form["DropDownListGsGd"], "");
            string text8 = this.TextBoxUseMoney.Text.Trim();
            string text9 = this.DropDownListGs.SelectedValue.Trim();
            string text10 = this.DropDownListGs.SelectedItem.Text.Trim();
            string text7 = this.TextBoxMaxMem.Text.Trim();
            if (this.DropDownListGs.SelectedValue == "00")
            {
                MyFunc.showmsg("请输入股东所在的公司帐号");
                base.Response.End();
            }
            else if ((((input == "") || (text2 == "")) || ((text3 == "") || (text4 == ""))) || ((s == "") || (text6 == "")))
            {
                MyFunc.showmsg("请输入股东帐号,密码,名称和比例");
                base.Response.End();
            }
            else if (input.Length < 3)
            {
                MyFunc.showmsg("股东帐号不能小于3个字符");
                base.Response.End();
            }
            else if (text4.Length > 8)
            {
                MyFunc.showmsg("股东名称不能大于8个字符(4个汉字)");
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
                else if (text2 != text3)
                {
                    MyFunc.showmsg("输入的密码不相同");
                }
                else
                {
                    try
                    {
                        int num = int.Parse(s);
                        if (((num % 10) == 0) && ((num >= 0) || (num <= 100)))
                        {
                            try
                            {
                                int num2 = int.Parse(text6);
                                if ((num2 >= int.Parse(s)) || (num2 <= 100))
                                {
                                    try
                                    {
                                        if (int.Parse(text8) >= 0)
                                        {
                                            try
                                            {
                                                int.Parse(text7);
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
                                                MyFunc.showmsg("该股东帐号已存在!");
                                                base.Response.End();
                                            }
                                            else if (base2.ExecuteNonQuery("INSERT INTO agence(username,userpass,truename,classid,regtime,isuseable,gsbl,gdbl,usemoney,maxmem,gdid,gdname)VALUES('" + input + "','" + text2 + "','" + text4 + "',2,GetDate(),1," + s + "," + text6 + "," + text8 + "," + text7 + ",'" + text9 + "','" + text10 + "')") > 0)
                                            {
                                                string text11 = base2.ExecuteScalar("SELECT userid FROM agence WHERE username='" + input + "'").ToString();
                                                base2.ExecuteNonQuery("UPDATE agence SET arrgd = arrgd+'" + text11.Trim() + ",' WHERE classid = 0 AND userid = '" + text9 + "'");
                                                base2.ExecuteNonQuery("INSERT INTO hs(userid,type)VALUES(" + text11 + ",'A');INSERT INTO hs(userid,type)VALUES(" + text11 + ",'B');INSERT INTO hs(userid,type)VALUES(" + text11 + ",'C');INSERT INTO hs(userid,type)VALUES(" + text11 + ",'D');");
                                                base2.Dispose();
                                                MyFunc.JumpPage("添加股东成功!", "gdlist.aspx");
                                            }
                                            else
                                            {
                                                base2.Dispose();
                                                MyFunc.showmsg("添加股东失败!");
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
                int num = 0;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                this.DropDownListGs.Items.Clear();
                this.DropDownListGs.Items.Add(new ListItem("请选择", "00"));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username FROM agence WHERE classid=0");
                while (reader.Read())
                {
                    num++;
                    this.DropDownListGs.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                this.DropDownListGs.SelectedIndex = 0;
                base2.Dispose();
                if (num == 0)
                {
                    MyFunc.showmsg("还没有公司，请先添加公司！");
                    base.Response.End();
                }
                else
                {
                    this.DropDownListBL.Items.Clear();
                    for (int i = 0; i < 100; i++)
                    {
                        this.DropDownListBL.Items.Add(new ListItem(i.ToString() + " %", i.ToString()));
                    }
                    this.DropDownListBL.Attributes["OnChange"] = "RefreshList()";
                }
            }
        }
    }
}

