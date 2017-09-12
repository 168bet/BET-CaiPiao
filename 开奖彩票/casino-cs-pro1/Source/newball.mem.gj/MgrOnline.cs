namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class MgrOnline : Page
    {
        protected Button Button1;
        protected Button ButtonDelEvent;
        protected DropDownList DropDownListShowType;
        public string kyglClass = "4";
        protected HtmlTable OnlineListTable;
        protected TextBox TextBoxSelUser;

        private void Button1_Click(object sender, EventArgs e)
        {
            string[][] onlineLists = MyTeam.OnlineList.OnlineList.GetOnlineList();
            this.OnlineListTable.Rows[1].Cells[0].InnerHtml = this.printOnlineUserTable(onlineLists, "", "0", this.TextBoxSelUser.Text.Trim());
        }

        private void ButtonDelEvent_Click(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery("DELETE FROM event WHERE DateDiff(day,logintime,GetDate())>=2");
            base2.Dispose();
        }

        private string ClassName(string classid)
        {
            switch (classid)
            {
                case "1":
                    return "管理员";

                case "2":
                    return "股东";

                case "3":
                    return "总代理";

                case "4":
                    return "代理商";

                case "5":
                    return "比分员";

                case "6":
                    return "查帐员";

                case "20":
                    return "会员";

                case "22":
                    return "股东子帐户";

                case "33":
                    return "总代理子帐户";

                case "44":
                    return "代理商子帐户";
            }
            return "&nbsp;";
        }

        private void DropDownListShowType_SelectedIndexChanged(object sender, EventArgs e)
        {
            string[][] onlineLists = MyTeam.OnlineList.OnlineList.GetOnlineList();
            this.OnlineListTable.Rows[1].Cells[0].InnerHtml = this.printOnlineUserTable(onlineLists, "", this.DropDownListShowType.SelectedValue, "");
            this.kyglClass = this.DropDownListShowType.SelectedValue;
            this.DataBind();
        }

        private bool FindUser(string[] uArray, string name)
        {
            for (int i = 0; i < uArray.Length; i++)
            {
                if (uArray[i] == name)
                {
                    return true;
                }
            }
            return false;
        }

        private void InitializeComponent()
        {
            this.DropDownListShowType.SelectedIndexChanged += new EventHandler(this.DropDownListShowType_SelectedIndexChanged);
            this.Button1.Click += new EventHandler(this.Button1_Click);
            this.ButtonDelEvent.Click += new EventHandler(this.ButtonDelEvent_Click);
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
                if ((base.Request.QueryString["kygl"] != null) && (base.Request.QueryString["kygl"].ToString().Trim() != ""))
                {
                    this.DropDownListShowType.SelectedValue = base.Request.QueryString["kygl"].ToString().Trim();
                }
                this.kyglClass = this.DropDownListShowType.SelectedValue;
                string[][] onlineLists = MyTeam.OnlineList.OnlineList.GetOnlineList();
                this.OnlineListTable.Rows[1].Cells[0].InnerHtml = this.printOnlineUserTable(onlineLists, "", this.DropDownListShowType.SelectedValue, "");
                this.DropDownListShowType.AutoPostBack = true;
                this.OnlineListTable.Rows[2].Cells[0].InnerHtml = "<font color=red><div align=left>共有" + MyTeam.OnlineList.OnlineList.CountUser().ToString() + "人在线</div></font>";
                this.DataBind();
            }
        }

        private string printOnlineUserTable(string[] OnlineLists, string myclassid, string showclassid)
        {
            string text = ("<tr bgColor='#FFFFFF' height=20 onmouseover=light_bar(this,'ovr') onmouseout=light_bar(this,'out')><td align=center><a href=MgrOnlineMsg.aspx?username=" + OnlineLists[0] + ">" + OnlineLists[0] + "</a></td><td align=center>" + DateTime.Parse(OnlineLists[2]).ToString("yyyy-MM-dd HH:mm:ss") + "</td>") + "<td>" + OnlineLists[6] + "</td><td>";
            string text2 = OnlineLists[3];
            string text3 = OnlineLists[7];
            if (text2.Split(new char[] { '|' })[0].Trim() != "")
            {
                string text5 = text;
                string text6 = text5 + text2.Split(new char[] { '|' })[0].Trim() + " " + text3.Split(new char[] { '|' })[0].Trim() + "<br>";
                text = text6 + "<font color=red>" + text2.Split(new char[] { '|' })[1].Trim() + " " + text3.Split(new char[] { '|' })[1].Trim() + "</font>";
            }
            else
            {
                string text7 = text;
                text = text7 + text2.Split(new char[] { '|' })[1].Trim() + " " + text3.Split(new char[] { '|' })[1].Trim() + "</font>";
            }
            return (((text + "<td align=center>" + this.ClassName(OnlineLists[4]) + "</td><td align=center>") + "<input class=text type='button' name='' value='踢 出' onclick=\"window.location='?takeOut=" + OnlineLists[0] + "';\">") + "</td></tr>");
        }

        private string printOnlineUserTable(string[][] OnlineLists, string myclassid, string showclassid, string uname)
        {
            string text = "<table  cellSpacing='1' cellPadding='0' width='850' bgColor='#AAAAAA' align='left'>";
            text = text + "<tr bgcolor=#CACACA  height=22><td class=blueheader>帐号</td><td class=blueheader width=130>最近活动时间</td><td class=blueheader width=150>当前所在位置</td><td class=blueheader width=300>来源IP</td><td class=blueheader width=80>用户权限</td><td class=blueheader width=80>操作</td></tr>";
            if (uname != "")
            {
                if (uname.IndexOf(",") != -1)
                {
                    string[] uArray = uname.Split(new char[] { ',' });
                    for (int i = 0; i < OnlineLists.Length; i++)
                    {
                        if (this.FindUser(uArray, OnlineLists[i][0]))
                        {
                            text = text + this.printOnlineUserTable(OnlineLists[i], myclassid, showclassid);
                        }
                    }
                }
                else
                {
                    for (int j = 0; j < OnlineLists.Length; j++)
                    {
                        if (uname == OnlineLists[j][0])
                        {
                            text = text + this.printOnlineUserTable(OnlineLists[j], myclassid, showclassid);
                        }
                    }
                }
            }
            else
            {
                for (int k = 0; k < OnlineLists.Length; k++)
                {
                    if ((showclassid == OnlineLists[k][4]) || (showclassid == "0"))
                    {
                        text = text + this.printOnlineUserTable(OnlineLists[k], myclassid, showclassid);
                    }
                }
            }
            return (text + "</table>");
        }
    }
}

