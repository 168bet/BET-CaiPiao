namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;

    public class adduserform : Page
    {
        protected HtmlSelect ABC;
        protected HtmlInputButton addbutton;
        protected HtmlGenericControl cash;
        protected HtmlGenericControl credit;
        protected HtmlSelect dls;
        protected HtmlGenericControl headtitle;
        protected HtmlTableRow leftMoneyTr;
        protected HtmlInputText leftMoneyValue;
        protected HtmlSelect moneysort;
        protected HtmlGenericControl moneysortview;
        protected HtmlSelect num_2;
        protected HtmlSelect num_3;
        protected HtmlGenericControl passchangeview;
        protected HtmlSelect pltype;
        public string pubpass = "";
        protected HtmlInputText reuserpass;
        protected HtmlInputText tel;
        protected HtmlInputText truename;
        protected HtmlInputText usemoney;
        protected HtmlInputHidden userid;
        protected HtmlGenericControl username;
        protected HtmlInputHidden usernamehid;
        protected HtmlInputText userpass;
        protected HtmlInputRadioButton usertype;
        protected HtmlInputRadioButton usertype1;

        private void CheckOverBigLimit(string userid)
        {
            string text = "";
            string text2 = "";
            string text3 = "";
            int memcount = 0;
            int num2 = 0;
            int num3 = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT gdid,zdlid,userid as dlsid FROM agence WHERE userid = '" + userid + "'");
            if (reader.Read())
            {
                text = reader["dlsid"].ToString();
                text2 = reader["zdlid"].ToString();
                text3 = reader["gdid"].ToString();
            }
            reader.Close();
            memcount = this.GetMemcount(text);
            num2 = this.GetMemcount(text2);
            num3 = this.GetMemcount(text3);
            if (((memcount != 0) || (num2 != 0)) || (num3 != 0))
            {
                if (((memcount == 0) && (num2 == 0)) && (num3 != 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE gdid = '" + text3 + "'");
                    if (reader.Read())
                    {
                        if (num3 > Convert.ToInt32(reader["memcount"]))
                        {
                            reader.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount == 0) && (num2 != 0)) && (num3 == 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE zdlid = '" + text2 + "'");
                    if (reader.Read())
                    {
                        if (num2 > Convert.ToInt32(reader["memcount"]))
                        {
                            reader.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount == 0) && (num2 != 0)) && (num3 != 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE zdlid = '" + text2 + "'");
                    SqlDataReader reader2 = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE gdid = '" + text3 + "'");
                    if (reader.Read() && reader2.Read())
                    {
                        if ((num2 > Convert.ToInt32(reader["memcount"])) && (num3 > Convert.ToInt32(reader2["memcount"])))
                        {
                            reader.Close();
                            reader2.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            reader2.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        reader2.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount != 0) && (num2 == 0)) && (num3 == 0))
                {
                    reader = base2.ExecuteReader("SELECT memcount,maxmem FROM agence WHERE userid = '" + text + "' and memcount < maxmem");
                    if (reader.Read())
                    {
                        reader.Close();
                        base2.Dispose();
                    }
                    else
                    {
                        reader.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount != 0) && (num2 == 0)) && (num3 != 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE dlsid = '" + text + "'");
                    SqlDataReader reader3 = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE gdid = '" + text3 + "'");
                    if (reader.Read() && reader3.Read())
                    {
                        if ((memcount > Convert.ToInt32(reader["memcount"])) && (num3 > Convert.ToInt32(reader3["memcount"])))
                        {
                            reader.Close();
                            reader3.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            reader3.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        reader3.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount != 0) && (num2 != 0)) && (num3 == 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE dlsid = '" + text + "'");
                    SqlDataReader reader4 = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE zdlid = '" + text2 + "'");
                    if (reader.Read() && reader4.Read())
                    {
                        if ((memcount > Convert.ToInt32(reader["memcount"])) && (num2 > Convert.ToInt32(reader4["memcount"])))
                        {
                            reader.Close();
                            reader4.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            reader4.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        reader4.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
                else if (((memcount != 0) && (num2 != 0)) && (num3 != 0))
                {
                    reader = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE dlsid = '" + text + "'");
                    SqlDataReader reader5 = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE zdlid = '" + text2 + "'");
                    SqlDataReader reader6 = base2.ExecuteReader("SELECT count(*) as memcount FROM member WHERE gdid = '" + text3 + "'");
                    if ((reader.Read() && reader5.Read()) && reader6.Read())
                    {
                        if (((memcount > Convert.ToInt32(reader["memcount"])) && (num2 > Convert.ToInt32(reader5["memcount"]))) && (num3 > Convert.ToInt32(reader6["memcount"])))
                        {
                            reader.Close();
                            reader5.Close();
                            reader6.Close();
                            base2.Dispose();
                        }
                        else
                        {
                            reader.Close();
                            reader5.Close();
                            reader6.Close();
                            base2.Dispose();
                            MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                            base.Response.End();
                        }
                    }
                    else
                    {
                        reader.Close();
                        reader5.Close();
                        reader6.Close();
                        base2.Dispose();
                        MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                        base.Response.End();
                    }
                }
            }
        }

        private void checkuserexists(DataBase db, SqlDataReader dr, string sql)
        {
            dr = db.ExecuteReader(sql);
            if (dr.Read())
            {
                dr.Close();
                db.CloseConnect();
                db.Dispose();
                MyFunc.showmsg("帐号已经存在,请选择别的帐号！");
                base.Response.End();
            }
            else
            {
                dr.Close();
            }
        }

        private string gethsuserid()
        {
            string text = "0";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT userid FROM userhs WHERE userid = '" + this.getuserid() + "'");
            if (reader.Read())
            {
                text = reader["userid"].ToString().Trim();
                reader.Close();
                base2.CloseConnect();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        private int GetMemcount(string userid)
        {
            int num = 0;
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT memcount,maxmem FROM agence WHERE userid = '" + userid + "'");
            if (reader.Read())
            {
                if ((Convert.ToInt32(reader["memcount"]) > Convert.ToInt32(reader["maxmem"])) && (Convert.ToInt32(reader["maxmem"]) != 0))
                {
                    reader.Close();
                    base2.Dispose();
                    MyFunc.showmsg("已超过用户的最大限制，请与管理员联系！");
                    base.Response.End();
                    return 0;
                }
                num = Convert.ToInt32(reader["maxmem"]);
                reader.Close();
                base2.Dispose();
                return num;
            }
            reader.Close();
            base2.Dispose();
            MyFunc.showmsg("用户ID出错，请与管理员联系！");
            base.Response.End();
            return 0;
        }

        private string getuserid()
        {
            string text = "0";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT userid FROM member WHERE username = '" + this.usernamehid.Value + "'");
            if (reader.Read())
            {
                text = reader["userid"].ToString().Trim();
                reader.Close();
                base2.CloseConnect();
                base2.Dispose();
                return text;
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return text;
        }

        private void InitializeComponent()
        {
            this.ID = "adduserform";
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.dls.Items[0].Value = this.Session["adminusername"].ToString().Trim();
                this.dls.Items[0].Text = this.Session["adminusername"].ToString().Trim();
                this.setmoneysortlist();
                if (base.Request.QueryString["userid"] == null)
                {
                    this.headtitle.InnerHtml = "&nbsp;&nbsp;新增会员&nbsp;：&nbsp;&nbsp; <a href=\"javascript:window.location = 'mgruser.aspx';\">回上一页</a>";
                    this.username.InnerText = this.Session["adminusername"].ToString().Trim().Substring(0, 5) + "00";
                    this.usernamehid.Value = this.username.InnerText;
                    this.usertype.Checked = true;
                }
                else
                {
                    this.headtitle.InnerHtml = "&nbsp;&nbsp;修改会员&nbsp;：&nbsp;&nbsp; <a href=\"javascript:window.location = 'mgruser.aspx';\">回上一页</a>";
                    this.userid.Value = base.Request.QueryString["userid"].ToString().Trim();
                    this.passchangeview.InnerHtml = "";
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    string sql = "SELECT userid,userpass,username,truename,dlsname,ABC,usemoney,moneysort,tel,usertype,moneyrate,curmoney FROM member WHERE userid='" + base.Request.QueryString["userid"].ToString().Trim() + "'";
                    SqlDataReader reader = base2.ExecuteReader(sql);
                    if (reader.Read())
                    {
                        this.userpass.Value = reader["userpass"].ToString().Trim();
                        this.tel.Value = reader["tel"].ToString().Trim();
                        this.reuserpass.Value = reader["userpass"].ToString().Trim();
                        this.pubpass = reader["userpass"].ToString().Trim();
                        this.truename.Value = reader["truename"].ToString().Trim();
                        this.ABC.Value = reader["ABC"].ToString().Trim();
                        this.moneysort.Value = reader["moneyrate"].ToString().Trim();
                        this.moneysortview.InnerHtml = reader["moneyrate"].ToString().Trim();
                        this.usemoney.Value = reader["usemoney"].ToString().Trim();
                        this.setusernamelist(reader["username"].ToString().Trim());
                        if (reader["usertype"].ToString().Trim() == "信用")
                        {
                            this.cash.Visible = false;
                            this.num_2.Visible = false;
                            this.num_3.Visible = false;
                            this.usertype.Visible = false;
                            this.leftMoneyValue.Value = reader["curmoney"].ToString();
                        }
                        else
                        {
                            this.credit.Visible = false;
                            this.usertype1.Visible = false;
                            this.leftMoneyTr.Style.Remove("DISPLAY");
                            this.leftMoneyValue.Value = reader["curmoney"].ToString();
                            this.leftMoneyValue.Disabled = true;
                        }
                    }
                    else
                    {
                        reader.Close();
                        base2.CloseConnect();
                        base2.Dispose();
                        MyFunc.showmsg("查询是出错，请刷新后重新修改！");
                        base.Response.End();
                        return;
                    }
                    reader.Close();
                    base2.CloseConnect();
                    base2.Dispose();
                }
            }
            else
            {
                string text2 = "";
                string text3 = "";
                string text4 = "";
                string text5 = "";
                string text6 = "";
                string text7 = "";
                DataBase db = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader dr = null;
                text7 = this.Session["adminuserid"].ToString();
                if (base.Request.Form["userid"].ToString().Trim() != "")
                {
                    text2 = "SELECT username FROM member WHERE username = '" + this.usernamehid.Value + "' AND userid <> '" + base.Request.Form["userid"].ToString().Trim() + "'";
                    this.checkuserexists(db, dr, text2);
                    int num10 = int.Parse(db.ExecuteScalar("SELECT usemoney FROM agence WHERE userid=" + text7).ToString());
                    int num11 = int.Parse(db.ExecuteScalar("SELECT usemoney FROM member WHERE userid=" + base.Request.Form["userid"].ToString().Trim()).ToString());
                    int num12 = int.Parse(db.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + text7).ToString());
                    int num13 = (num10 - num12) + num11;
                    if (int.Parse(this.usemoney.Value) > num13)
                    {
                        db.Dispose();
                        MyFunc.showmsg("信用度额不能大于代理商可用信用度额");
                        base.Response.End();
                    }
                    else
                    {
                        if (this.ABC.Value.Trim().ToUpper() != db.ExecuteScalar("select abc from member where userid ='" + base.Request.Form["userid"].ToString().Trim() + "'").ToString().Trim().ToUpper())
                        {
                            db.ExecuteNonQuery("DELETE FROM userhs where userid = '" + base.Request.Form["userid"].ToString().Trim() + "'");
                            db.ExecuteNonQuery("insert userhs select  '" + base.Request.Form["userid"].ToString().Trim() + "',w1,w2,w3,w4,w5,w6,w7,w8,w9,w10,w11,w12,w13,w14,w15,l1,l2,l3,l4,l5,l6,l7,l8,l9,l10,l11,l12,l13,l14,l15,maxC1,maxC2,maxC3,maxC4,maxC5,maxC6,maxC7,maxC8,maxC9,maxC10,maxC11,maxC12,maxC13,maxC14,maxC15,maxZ1,maxZ2,maxZ3,maxZ4,maxZ5,maxZ6,maxZ7,maxZ8,maxZ9,maxZ10,maxZ11,maxZ12,maxZ13,maxZ14,maxZ15,W28,L28,maxC28,maxZ28,maxZ18,maxZ19,maxZ20,maxZ21,maxZ22,maxZ23,maxZ24,maxC18,maxC19,maxC20,maxC21,maxC22,maxC23,maxC24,w18,w19,w20,w21,w22,w23,w24,l18,l19,l20,l21,l22,l23,l24 from hs join agence on hs.userid = agence.userid where hs.userid='" + this.Session["adminuserid"].ToString().Trim() + "' and hs.type='" + this.ABC.Value + "'");
                        }
                        double num14 = double.Parse(db.ExecuteScalar("SELECT isnull(sum(tzmoney),0) as tzsummoney FROM ball_order WHERE datediff(day,getdate(),updatetime) = 0 and userid=" + base.Request.Form["userid"].ToString().Trim()).ToString());
                        num14 = double.Parse(this.usemoney.Value) - num14;
                        text2 = "UPDATE member SET username = '" + this.usernamehid.Value + "',usemoney='" + this.usemoney.Value + "',curmoney='" + num14.ToString() + "',truename= '" + this.truename.Value + "',";
                        if (this.userpass.Value != "")
                        {
                            text2 = text2 + "userpass='" + this.userpass.Value + "',";
                        }
                        string text10 = text2;
                        text2 = text10 + "pltype='" + this.pltype.Value + "',tel='" + this.tel.Value + "',moneyrate='" + this.moneysort.Value + "',moneysort='" + this.moneysort.Items[this.moneysort.SelectedIndex].Text + "',abc='" + this.ABC.Value + "',updatetime='" + DateTime.Now.ToString() + "' WHERE userid ='" + base.Request.Form["userid"].ToString().Trim() + "'";
                        db.ExecuteNonQuery(text2);
                        if (this.gethsuserid() == "0")
                        {
                            db.ExecuteNonQuery("INSERT INTO userhs (userid) values ('" + this.getuserid() + "')");
                        }
                        base.Response.Write("<script language='javascript'>\n alert('会员修改成功！');\n window.location = 'mgruser.aspx';\n</script>");
                        db.CloseConnect();
                        db.Dispose();
                    }
                }
                else
                {
                    text2 = "SELECT username FROM member where username = '" + this.usernamehid.Value + "'";
                    this.checkuserexists(db, dr, text2);
                    text2 = "SELECT gdid,gdname,zdlid,zdlname from agence where userid='" + this.Session["adminuserid"].ToString().Trim() + "'";
                    dr = db.ExecuteReader(text2);
                    if (dr.Read())
                    {
                        text3 = dr["gdid"].ToString();
                        text4 = dr["gdname"].ToString();
                        text5 = dr["zdlid"].ToString();
                        text6 = dr["zdlname"].ToString();
                    }
                    dr.Close();
                    int num = int.Parse(db.ExecuteScalar("SELECT usemoney FROM agence WHERE userid=" + text7).ToString());
                    int num2 = int.Parse(db.ExecuteScalar("SELECT ISNULL(SUM(usemoney),0) FROM member WHERE dlsid=" + text7).ToString());
                    int num3 = num - num2;
                    if (int.Parse(this.usemoney.Value) > num3)
                    {
                        db.Dispose();
                        MyFunc.showmsg("信用度额不能大于代理商可用信用度额");
                        base.Response.End();
                    }
                    else
                    {
                        int num4 = int.Parse(db.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text7).ToString());
                        if (num4 > 0)
                        {
                            int num5 = int.Parse(db.ExecuteScalar("SELECT COUNT(1) FROM member WHERE dlsid=" + text7).ToString());
                            if (num4 < (num5 + 1))
                            {
                                db.Dispose();
                                MyFunc.showmsg("该代理商的最大会员数为 " + num4.ToString() + ",不能再添加新会员");
                                base.Response.End();
                                return;
                            }
                        }
                        else
                        {
                            int num6 = int.Parse(db.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text5).ToString());
                            if (num6 > 0)
                            {
                                int num7 = int.Parse(db.ExecuteScalar("SELECT COUNT(1) FROM member WHERE zdlid=" + text5).ToString());
                                if (num6 < (num7 + 1))
                                {
                                    db.Dispose();
                                    MyFunc.showmsg("您的最大会员数为 " + num4.ToString() + ",不能再添加新会员");
                                    base.Response.End();
                                    return;
                                }
                            }
                            else
                            {
                                int num8 = int.Parse(db.ExecuteScalar("SELECT maxmem FROM agence WHERE userid=" + text3).ToString());
                                if (num8 > 0)
                                {
                                    int num9 = int.Parse(db.ExecuteScalar("SELECT COUNT(1) FROM member WHERE gdid=" + text3).ToString());
                                    if (num8 < (num9 + 1))
                                    {
                                        db.Dispose();
                                        MyFunc.showmsg("该股东的最大会员数为 " + num4.ToString() + ",不能再添加新会员");
                                        base.Response.End();
                                        return;
                                    }
                                }
                            }
                        }
                        text2 = "INSERT INTO member ";
                        text2 = text2 + "(username,userpass,usemoney,gdid,gdname,zdlid,zdlname,dlsid,dlsname,truename,tel,usertype,moneyrate,pltype,regtime,moneysort,curmoney,abc,updatetime,isuseable) VALUES ";
                        if (base.Request.Form["usertype"].ToString() == "信用")
                        {
                            string text8 = text2;
                            text2 = text8 + "('" + this.usernamehid.Value + "','" + this.userpass.Value + "','" + this.usemoney.Value + "','" + text3 + "','" + text4 + "','" + text5 + "','" + text6 + "','" + this.Session["adminuserid"].ToString().Trim() + "','" + this.Session["adminusername"].ToString().Trim() + "','" + this.truename.Value + "','" + this.tel.Value + "','" + base.Request.Form["usertype"].ToString() + "','" + this.moneysort.Value + "','" + this.pltype.Value + "','" + DateTime.Now.ToString() + "','" + this.moneysort.Items[this.moneysort.SelectedIndex].Text + "','" + this.usemoney.Value + "','" + this.ABC.Value + "','" + DateTime.Now.ToString() + "',1)";
                        }
                        else
                        {
                            string text9 = text2;
                            text2 = text9 + "('" + this.usernamehid.Value + "','" + this.userpass.Value + "','" + this.usemoney.Value + "','" + text3 + "','" + text4 + "','" + text5 + "','" + text6 + "','" + this.Session["adminuserid"].ToString().Trim() + "','" + this.Session["adminusername"].ToString().Trim() + "','" + this.truename.Value + "','" + this.tel.Value + "','" + base.Request.Form["usertype"].ToString() + "','" + this.moneysort.Value + "','" + this.pltype.Value + "','" + DateTime.Now.ToString() + "','" + this.moneysort.Items[this.moneysort.SelectedIndex].Text + "','0','" + this.ABC.Value + "','" + DateTime.Now.ToString() + "',1)";
                        }
                        db.ExecuteNonQuery(text2);
                        db.ExecuteNonQuery("UPDATE agence SET memcount=memcount+1 WHERE userid=" + this.Session.Contents["adminuserid"].ToString().Trim());
                        db.ExecuteNonQuery("insert userhs select '" + this.getuserid() + "',w1,w2,w3,w4,w5,w6,w7,w8,w9,w10,w11,w12,w13,w14,w15,l1,l2,l3,l4,l5,l6,l7,l8,l9,l10,l11,l12,l13,l14,l15,maxC1,maxC2,maxC3,maxC4,maxC5,maxC6,maxC7,maxC8,maxC9,maxC10,maxC11,maxC12,maxC13,maxC14,maxC15,maxZ1,maxZ2,maxZ3,maxZ4,maxZ5,maxZ6,maxZ7,maxZ8,maxZ9,maxZ10,maxZ11,maxZ12,maxZ13,maxZ14,maxZ15,W28,L28,maxC28,maxZ28,maxZ18,maxZ19,maxZ20,maxZ21,maxZ22,maxZ23,maxZ24,maxC18,maxC19,maxC20,maxC21,maxC22,maxC23,maxC24,w18,w19,w20,w21,w22,w23,w24,l18,l19,l20,l21,l22,l23,l24 from hs join agence on hs.userid = agence.userid where hs.userid='" + this.Session["adminuserid"].ToString().Trim() + "' and hs.type='" + this.ABC.Value + "'");
                        base.Response.Write("<script language='javascript'>alert('会员新增成功！');window.location.href='mgruser.aspx';</script>");
                        db.CloseConnect();
                        db.Dispose();
                    }
                }
            }
        }

        private void setmoneysortlist()
        {
            string sql = "SELECT type,rate FROM rate";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            this.moneysort.DataSource = reader;
            this.moneysort.DataTextField = "type";
            this.moneysort.DataValueField = "rate";
            this.moneysort.DataBind();
            this.moneysort.SelectedIndex = 2;
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
        }

        private void setusernamelist(string username_proc)
        {
            this.username.InnerText = username_proc;
            this.usernamehid.Value = username_proc;
            int length = username_proc.Length;
            this.num_2.Value = username_proc.Substring(length - 3, 1);
            this.num_3.Value = username_proc.Substring(length - 2, 1);
        }
    }
}

