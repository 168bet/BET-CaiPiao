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

    public class zdladd : Page
    {
        protected Button ButtonCancel;
        protected Button ButtonSave;
        protected DropDownList DropDownListGd;
        protected DropDownList DropDownListIsUseAble;
        protected TextBox TextBoxMaxMem;
        protected TextBox TextBoxNewpass1;
        protected TextBox TextBoxNewpass2;
        protected TextBox TextBoxTel;
        protected TextBox TextBoxTrueName;
        protected TextBox TextBoxUseMoney;
        protected TextBox TextBoxUserName;

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
                string text6 = this.DropDownListIsUseAble.SelectedValue.Trim();
                string s = this.TextBoxUseMoney.Text.Trim();
                string text9 = this.TextBoxTel.Text.Trim().Replace("'", "").Replace("%", "").Replace(" ", "");
                string upid = this.DropDownListGd.SelectedValue.Trim();
                string text8 = this.DropDownListGd.SelectedItem.Text.Trim();
                string text10 = this.TextBoxMaxMem.Text.Trim();
                if (this.DropDownListGd.SelectedValue == "00")
                {
                    MyFunc.showmsg("请输入总代理所在的股东帐号");
                    base.Response.End();
                }
                else if ((((input == "") || (text2 == "")) || ((text3 == "") || (text4 == ""))) || (((text6 == "") || (s == "")) || (text10 == "")))
                {
                    MyFunc.showmsg("请输入总代理帐号,密码,名称,即时注单状态,信用额度,最大会员数");
                    base.Response.End();
                }
                else if (input.Length < 5)
                {
                    MyFunc.showmsg("总代理的帐号不能小于5个字符");
                    base.Response.End();
                }
                else if (text4.Length > 8)
                {
                    MyFunc.showmsg("总代理名称不能大于8个字符(4个汉字)");
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
                                    int.Parse(text10);
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
                                    MyFunc.showmsg("该总代理的帐号已存在!");
                                    base.Response.End();
                                }
                                else
                                {
                                    int num3 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(usemoney,0) FROM agence WHERE userid=" + upid).ToString());
                                    int num4 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM agence WHERE gdid=" + upid + " and classid = 3").ToString());
                                    if (int.Parse(s) > (num3 - num4))
                                    {
                                        base2.Dispose();
                                        MyFunc.showmsg("总代理信用额度不能大于股东可用信用额度");
                                        base.Response.End();
                                    }
                                    else
                                    {
                                        int num5 = int.Parse(base2.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + upid).ToString());
                                        if (num5 > 0)
                                        {
                                            int num6 = int.Parse(base2.ExecuteScalar("SELECT ISNULL(SUM(maxmem),0) FROM agence WHERE gdid=" + upid + " AND classid=3").ToString());
                                            if ((num6 + int.Parse(text10)) > num5)
                                            {
                                                base2.Dispose();
                                                object[] objArray = new object[] { "股东最大会员为 ", num5, " ,现在总代理最大会员数最大可设为 ", (num5 - num6).ToString() };
                                                MyFunc.showmsg(string.Concat(objArray));
                                                base.Response.End();
                                                return;
                                            }
                                        }
                                        if (base2.ExecuteNonQuery("INSERT INTO agence(username,userpass,truename,classid,regtime,isuseable,usemoney,gdid,gdname,tel,maxmem)VALUES('" + input + "','" + text2 + "','" + text4 + "',3,GetDate()," + this.DropDownListIsUseAble.SelectedValue + "," + s + "," + upid + ",'" + text8 + "','" + text9 + "'," + text10 + ")") > 0)
                                        {
                                            string userid = base2.ExecuteScalar("SELECT userid FROM agence WHERE username='" + input + "'").ToString();
                                            this.SetStartHs(upid, userid, "A");
                                            this.SetStartHs(upid, userid, "B");
                                            this.SetStartHs(upid, userid, "C");
                                            this.SetStartHs(upid, userid, "D");
                                            base2.ExecuteNonQuery("UPDATE agence SET memcount=memcount+1 WHERE userid=" + upid);
                                            base2.Dispose();
                                            MyFunc.JumpPage("添加总代理成功!", "zdllist.aspx");
                                        }
                                        else
                                        {
                                            base2.Dispose();
                                            MyFunc.showmsg("添加总代理失败!");
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
                int num = 0;
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                this.DropDownListGd.Items.Clear();
                this.DropDownListGd.Items.Add(new ListItem("请选择", "00"));
                SqlDataReader reader = base2.ExecuteReader("SELECT userid,username FROM agence WHERE classid=2 AND gdid = '" + this.Session["adminuserid"].ToString() + "'");
                while (reader.Read())
                {
                    num++;
                    this.DropDownListGd.Items.Add(new ListItem(reader["username"].ToString().Trim(), reader["userid"].ToString().Trim()));
                }
                reader.Close();
                this.DropDownListGd.SelectedIndex = 0;
                base2.Dispose();
                if (num == 0)
                {
                    MyFunc.showmsg("还没有股东，请先添加股东！");
                    base.Response.End();
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

