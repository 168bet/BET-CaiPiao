namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class BfUser : Page
    {
        protected DataGrid DataGrid1;
        protected HtmlForm Form1;

        private void BfUserMod(string userid, int flag)
        {
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                if (flag == 1)
                {
                    base2.ExecuteNonQuery("UPDATE Pluser SET isuseable=1 WHERE userid=" + userid + " and classid=3");
                }
                else
                {
                    base2.ExecuteNonQuery("UPDATE Pluser SET isuseable=0 WHERE userid=" + userid + " and classid=3");
                }
                base2.Dispose();
            }
        }

        private void DataGridBind()
        {
            DataSet set = new DataBase(MyFunc.GetConnStr(2)).ExecuteDataSet("SELECT * FROM pluser WHERE classid=3");
            this.DataGrid1.DataSource = set;
            this.DataGrid1.DataBind();
        }

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
            if (!MyFunc.CheckUserLogin(0) || ((this.Session.Contents["classid"].ToString().Trim() != "1") && (this.Session.Contents["classid"].ToString().Trim() != "2")))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "stop")) && ((base.Request.QueryString["userid"] != null) && (base.Request.QueryString["userid"].ToString().Trim() != "")))
                {
                    this.BfUserMod(base.Request.QueryString["userid"].ToString().Trim(), 0);
                }
                else if (((base.Request.QueryString["action"] != null) && (base.Request.QueryString["action"].ToString().Trim() == "open")) && ((base.Request.QueryString["userid"] != null) && (base.Request.QueryString["userid"].ToString().Trim() != "")))
                {
                    this.BfUserMod(base.Request.QueryString["userid"].ToString().Trim(), 1);
                }
                this.DataGridBind();
            }
        }

        public string UserOp(string userid, string flag)
        {
            if (flag.ToUpper() == "TRUE")
            {
                return ("<a href=bfuser.aspx?action=stop&userid=" + userid + ">停用</a> / <a href=bfusermsg.aspx?userid=" + userid + ">资料</a>");
            }
            return ("<a href=bfuser.aspx?action=open&userid=" + userid + ">启用</a> / <a href=bfusermsg.aspx?userid=" + userid + ">资料</a>");
        }

        public string UserStatus(string flag)
        {
            if (flag.ToUpper() == "TRUE")
            {
                return "<font color=blue>可用</font>";
            }
            return "<font color=red>停用</font>";
        }
    }
}

