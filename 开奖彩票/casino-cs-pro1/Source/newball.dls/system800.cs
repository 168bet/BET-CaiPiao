namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Text;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class system800 : Page
    {
        protected HtmlInputText endTime;
        protected Button searchButton;
        protected HtmlInputText startTime;
        protected HtmlTable tableList;
        protected DropDownList thePage;
        protected DropDownList tzType;
        protected DropDownList username;

        private void AppButton_OnClick(string sysid)
        {
            string sql = "";
            EventArgs e = null;
            sql = "UPDATE sys800user SET chgusername = '" + this.Session.Contents["adminusername"].ToString() + "',chgdatetime = getdate(),remark = case charindex('现金提款',remark,1) when 0 then '按金' else '现金提款' end WHERE sysid = '" + sysid + "'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.ExecuteNonQuery("UPDATE member SET curmoney = curmoney +(case (select top 1 remark from sys800user where sysid = '" + sysid + "') when '现金提款' then -(select top 1 amount from sys800user where sysid = '" + sysid + "') else +(select top 1 amount from sys800user where sysid = '" + sysid + "') end) WHERE userid = isnull((select top 1 userid from sys800user where sysid = '" + sysid + "'),0)");
            base2.Dispose();
            this.OnClick_SearchDeal(this, e);
        }

        private string GetSqlStr()
        {
            switch (this.tzType.SelectedValue)
            {
                case "按金":
                    return ("SELECT sys8.sysid,mem.username,mem.moneysort,isnull(sys8.amount,0) as amount,sys8.adddatetime,sys8.chgusername,sys8.chgdatetime,sys8.remark,mem.curmoney FROM sys800user AS sys8 LEFT JOIN member AS mem ON sys8.userid = mem.userid WHERE (sys8.adddatetime BETWEEN '" + this.startTime.Value + "' AND '" + this.endTime.Value + "') AND sys8.userid = '" + this.username.SelectedValue + "' AND sys8.usertype = '按金'");

                case "现金提款":
                    return ("SELECT sys8.sysid,mem.username,mem.moneysort,(0-isnull(sys8.amount,0)) as amount,sys8.adddatetime,sys8.chgusername,sys8.chgdatetime,sys8.remark,mem.curmoney FROM sys800user AS sys8 LEFT JOIN member AS mem ON sys8.userid = mem.userid WHERE (sys8.adddatetime BETWEEN '" + this.startTime.Value + "' AND '" + this.endTime.Value + "') AND sys8.userid = '" + this.username.SelectedValue + "' AND sys8.usertype = '现金提款'");

                case "赢":
                    return ("select 0 as sysid,mem.username,mem.moneysort,(isnull(ball.win,0)-isnull(ball.lose,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'赢' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) > 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'");

                case "输":
                    return ("select 0 as sysid,mem.username,mem.moneysort,(isnull(ball.win,0)-isnull(ball.lose,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'输' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) < 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'");

                case "和":
                    return ("select 0 as sysid,mem.username,mem.moneysort,0 as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'和' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) = 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'");

                case "投注额":
                    return ("select 0 as sysid,mem.username,mem.moneysort,(0-isnull(ball.tzmoney,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'投注额' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'");

                case "全部":
                {
                    string text4 = "SELECT sys8.sysid,mem.username,mem.moneysort,isnull(sys8.amount,0) as amount,sys8.adddatetime,sys8.chgusername,sys8.chgdatetime,sys8.remark,mem.curmoney FROM sys800user AS sys8 LEFT JOIN member AS mem ON sys8.userid = mem.userid WHERE (sys8.adddatetime BETWEEN '" + this.startTime.Value + "' AND '" + this.endTime.Value + "') AND sys8.userid = '" + this.username.SelectedValue + "' AND sys8.usertype = '按金'";
                    string text5 = text4 + " UNION SELECT sys8.sysid,mem.username,mem.moneysort,(0-isnull(sys8.amount,0)) as amount,sys8.adddatetime,sys8.chgusername,sys8.chgdatetime,sys8.remark,mem.curmoney FROM sys800user AS sys8 LEFT JOIN member AS mem ON sys8.userid = mem.userid WHERE (sys8.adddatetime BETWEEN '" + this.startTime.Value + "' AND '" + this.endTime.Value + "') AND sys8.userid = '" + this.username.SelectedValue + "' AND sys8.usertype = '现金提款'";
                    string text6 = text5 + " UNION select 0 as sysid,mem.username,mem.moneysort,(isnull(ball.win,0)-isnull(ball.lose,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'赢' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) > 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'";
                    string text7 = text6 + " UNION select 0 as sysid,mem.username,mem.moneysort,(isnull(ball.win,0)-isnull(ball.lose,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'输' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) < 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'";
                    string text8 = text7 + " UNION select 0 as sysid,mem.username,mem.moneysort,0 as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'和' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 1 and (isnull(ball.win,0)-isnull(ball.lose,0)) = 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'";
                    return (text8 + " UNION select 0 as sysid,mem.username,mem.moneysort,(0-isnull(ball.tzmoney,0)) as amount,ball.updatetime as adddatetime,null as chgusername,null as chgdatetime,'投注额' as remark,mem.curmoney from ball_order as ball LEFT join member as mem on mem.userid = ball.userid where ball.isjs = 0 and (ball.updatetime between '" + this.startTime.Value + "' and '" + this.endTime.Value + "') and ball.userid = '" + this.username.SelectedValue + "'");
                }
            }
            MyFunc.showmsg("请选择正确的统计方式！");
            return "";
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
            this.searchButton.Click += new EventHandler(this.OnClick_SearchDeal);
        }

        private void OnClick_SearchDeal(object sender, EventArgs e)
        {
            this.SetTableHeader();
            this.SetTableMiddleDeal();
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
                this.startTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                this.endTime.Value = DateTime.Today.ToString("yyyy-MM-dd");
                this.SetUserNameList();
                this.SetTableHeader();
                this.SetTableBottomDeal();
            }
            else if ((base.Request.QueryString["sysid"] != null) && (base.Request.QueryString["sysid"].ToString() != ""))
            {
                this.AppButton_OnClick(base.Request.QueryString["sysid"].ToString());
            }
        }

        private void SetTableBottomDeal()
        {
            StringBuilder builder = new StringBuilder("");
            builder.Append("<tr class='tableBody1' align='right'><td colspan='2'>总数</td><td bgcolor='#efefef' align=right>");
            builder.Append("0.00");
            builder.Append("</td><td colspan='3'>现时信用余额</td><td bgcolor='#efefef' align=right>");
            builder.Append("0.00");
            builder.Append("</td></tr></table>\n");
            HtmlTableCell cell1 = this.tableList.Rows[0].Cells[0];
            cell1.InnerHtml = cell1.InnerHtml + builder.ToString();
        }

        private void SetTableBottomDeal(string sumamount, string curmoney)
        {
            StringBuilder builder = new StringBuilder("");
            builder.Append("<tr class='tableBody1' align='right'><td colspan='2'>总数</td><td bgcolor='#efefef' align=right>");
            builder.Append(sumamount);
            builder.Append("</td><td colspan='3'>现时信用余额</td><td bgcolor='#efefef' align=right>");
            builder.Append(curmoney);
            builder.Append("</td></tr></table>\n");
            HtmlTableCell cell1 = this.tableList.Rows[0].Cells[0];
            cell1.InnerHtml = cell1.InnerHtml + builder.ToString();
        }

        private void SetTableHeader()
        {
            StringBuilder builder = new StringBuilder("<table border=0 cellpadding=0 cellspacing=1 width=780 class=tableNoBorder1 runat=server >\n");
            builder.Append("<tr class=dlsheader><td>会员</td><td>货币代码</td><td>数额</td><td>时间</td><td>更改用户</td><td>更改时间/日期</td><td>备注</td></tr>\n");
            this.tableList.Rows[0].Cells[0].InnerHtml = builder.ToString();
        }

        private void SetTableMiddleDeal()
        {
            string sql = "";
            string curmoney = "0";
            double num = 0;
            StringBuilder builder = new StringBuilder("");
            sql = this.GetSqlStr();
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                builder.Append("<tr class='tableBody1' align=center>\n");
                builder.Append("<td>");
                builder.Append(reader["username"].ToString());
                builder.Append("</td><td>");
                builder.Append(reader["moneysort"].ToString());
                builder.Append("</td><td align=right>");
                builder.Append(reader["amount"].ToString());
                builder.Append("</td><td>");
                builder.Append(DateTime.Parse(reader["adddatetime"].ToString()).ToString("yyyy-MM-dd HH:mm:ss"));
                builder.Append("</td><td>");
                builder.Append(reader["chgusername"].ToString());
                builder.Append("</td><td>");
                if (reader["chgdatetime"] != null)
                {
                    builder.Append(DateTime.Parse(reader["chgdatetime"].ToString()).ToString("yyyy-MM-dd HH:mm:ss"));
                }
                else
                {
                    builder.Append(reader["chgdatetime"].ToString());
                }
                builder.Append("</td><td>");
                builder.Append(reader["remark"].ToString().Replace("(this)", "(this,'" + reader["sysid"].ToString() + "');"));
                builder.Append("</td></tr>\n");
                num += double.Parse(reader["amount"].ToString());
                curmoney = reader["curmoney"].ToString();
            }
            reader.Close();
            base2.Dispose();
            HtmlTableCell cell1 = this.tableList.Rows[0].Cells[0];
            cell1.InnerHtml = cell1.InnerHtml + builder.ToString();
            this.SetTableBottomDeal(num.ToString(), curmoney);
        }

        private void SetUserNameList()
        {
            string sql = "";
            sql = "SELECT userid,username FROM member WHERE dlsid = '" + this.Session.Contents["adminuserid"].ToString() + "' AND usertype = '现金'";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                this.username.Items.Add(new ListItem(reader["username"].ToString(), reader["userid"].ToString()));
            }
            reader.Close();
            base2.Dispose();
        }
    }
}

