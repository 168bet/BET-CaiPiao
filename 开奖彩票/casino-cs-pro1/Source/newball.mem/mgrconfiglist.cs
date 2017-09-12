namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class mgrconfiglist : Page
    {
        protected DataGrid configdatagrid;
        protected DropDownList le;

        private void configdatagrid_ItemDataBound(object sender, DataGridItemEventArgs e)
        {
            if (e.Item.ItemIndex >= 0)
            {
                e.Item.Attributes["onMouseOver"] = "this.bgColor='#cccccc';";
                if ((e.Item.ItemIndex % 2) == 0)
                {
                    e.Item.Attributes["bgcolor"] = "white";
                    e.Item.Attributes["OnMouseOut"] = "this.bgColor='white';";
                }
                else
                {
                    e.Item.Attributes["bgcolor"] = "#EBEBEB";
                    e.Item.Attributes["onMouseOut"] = "this.bgColor='#EBEBEB';";
                }
            }
        }

        public void configdatagrid_PageIndexChanged(object source, DataGridPageChangedEventArgs e)
        {
            this.configdatagrid.CurrentPageIndex = e.NewPageIndex;
            this.showdatagrid();
        }

        public string dealcontent(string content)
        {
            if (content.Length > 40)
            {
                return MyFunc.ConvertStr(content.Substring(0, 40));
            }
            return MyFunc.ConvertStr(content);
        }

        public string dealle(string le)
        {
            if (le == "1")
            {
                return "前台";
            }
            return "后台";
        }

        public void delClick(string id)
        {
            string sql = "DELETE affiche WHERE id='" + id + "'";
            new DataBase(MyFunc.GetConnStr(2)).ExecuteNonQuery(sql);
            base.Response.Write("<script language=javascript>\n alert('删除成功！');\n</script>");
            this.showdatagrid();
        }

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
            this.configdatagrid.ItemDataBound += new DataGridItemEventHandler(this.configdatagrid_ItemDataBound);
        }

        public void le_SelectedIndexChanged(object sender, EventArgs e)
        {
            this.configdatagrid.CurrentPageIndex = 0;
            this.showdatagrid();
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
            }
            else if (!this.Page.IsPostBack)
            {
                this.configdatagrid.PageSize = 20;
                if (base.Request.QueryString["id"] != null)
                {
                    this.delClick(base.Request.QueryString["id"].ToString().Trim());
                }
                else
                {
                    this.showdatagrid();
                }
            }
        }

        private void showdatagrid()
        {
            string sql = "SELECT id,le,content,kaisai FROM affiche ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            if (this.le.SelectedValue != "")
            {
                sql = sql + " WHERE le = '" + this.le.SelectedValue + "'";
            }
            DataSet set = base2.ExecuteDataSet(sql);
            this.configdatagrid.DataSource = set;
            this.configdatagrid.DataBind();
            set.Clear();
            base2.CloseConnect();
            base2.Dispose();
        }
    }
}

