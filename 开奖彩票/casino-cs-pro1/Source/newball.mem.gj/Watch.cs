namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class Watch : Page
    {
        public string kyglContent = "";

        private void InitializeComponent()
        {
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
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if ((base.Request.QueryString["kygl"] != null) && (base.Request.QueryString["kygl"].ToString().Trim() == "up"))
                {
                    this.updateuser();
                }
                this.kyglContent = this.TableList();
                this.DataBind();
            }
        }

        private string TableList()
        {
            string text = "";
            string sql = "SELECT Max(Ball_Order.Username) AS username,MAX(member.userpass) AS userpass,Ball_order.userid,isnull(SUM(Ball_Order.tzMoney),0) AS tzmoney,COUNT(1) AS tzcount,isnull(MAX(member.curMoney),0) AS curmoney,isnull(MAX(member.UseMoney),0) AS usemoney FROM Ball_Order LEFT OUTER JOIN member ON Ball_Order.userid = member.userid WHERE (DATEDIFF(day,ball_order.updatetime,getdate())=0 OR DATEDIFF([day],Ball_Order.balltime,GETDATE()) = 0)  GROUP BY Ball_Order.userid order by ball_order.userid";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            int num = 0;
            string text3 = "";
            if ((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() != ""))
            {
                text3 = base.Request.QueryString["action"].ToString().Trim();
            }
            text = text + "<tr bgcolor=#FFFFcc>";
            while (reader.Read())
            {
                double num2 = double.Parse(reader["usemoney"].ToString().Trim());
                double num3 = double.Parse(reader["curmoney"].ToString().Trim());
                double num4 = double.Parse(reader["tzmoney"].ToString().Trim());
                string text4 = "1";
                bool flag = true;
                if (num2 != (num3 + num4))
                {
                    flag = false;
                    text4 = "0";
                }
                if (((text3 != "1") || flag) && ((text3 != "2") || !flag))
                {
                    num++;
                    string text6 = text;
                    text = text6 + "<td><a href=MemberResult.aspx?userid=" + reader["userid"].ToString().Trim() + "&flag=" + text4 + ">" + reader["username"].ToString().Trim() + "</a></td><td>" + reader["userpass"].ToString().Trim() + "</td><td>" + reader["tzcount"].ToString().Trim() + "</td><td>" + reader["usemoney"].ToString().Trim() + "</td><td>" + double.Parse(reader["tzmoney"].ToString().Trim()).ToString("F0") + "</td><td>" + reader["curmoney"].ToString().Trim() + "</td><td>";
                    if (flag)
                    {
                        text = text + "正常";
                    }
                    else
                    {
                        string text7 = text;
                        string[] textArray2 = new string[] { text7, "<a href=watch.aspx?kygl=up&id=", reader["userid"].ToString().Trim(), "&money=", (num2 - num4).ToString(), "><font color=red>不正常</font></a>" };
                        text = string.Concat(textArray2);
                    }
                    text = text + "</td>";
                    if ((num % 2) == 0)
                    {
                        text = text + "</tr>  <tr bgcolor=#FFFFcc>";
                    }
                    else
                    {
                        text = text + "<td>&nbsp;</td>";
                    }
                }
            }
            if ((num % 2) != 0)
            {
                text = text + "<td colspan=7>&nbsp;</td></tr>";
            }
            text = text + "<tr bgcolor=#ffffff align=right><td colspan=15><b>总下注人数:" + num.ToString() + "</b></td></tr>";
            reader.Close();
            base2.Dispose();
            return text;
        }

        private void updateuser()
        {
            if (!MyFunc.CheckUserLogin(this.Session["adminusername"].ToString(), this.Session["adminuserpass"].ToString(), this.Session["adminclassid"].ToString(), 1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else
            {
                string text = "0";
                if (((base.Request.QueryString["id"] != null) && (base.Request.QueryString["id"].ToString().Trim() != "")) && ((base.Request.QueryString["money"] != null) && (base.Request.QueryString["money"].ToString().Trim() != "")))
                {
                    text = base.Request.QueryString["money"].ToString().Trim();
                    DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                    base2.ExecuteNonQuery("UPDATE member SET curmoney=" + text + " WHERE userid=" + base.Request.QueryString["id"].ToString().Trim());
                    base2.Dispose();
                }
            }
        }
    }
}

