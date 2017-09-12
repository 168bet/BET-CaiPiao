namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class mgrconfiglist : Page
    {
        protected Button BtnFengpan;
        protected Button BtnKaipan;
        protected Button Button1;
        protected Button Button2;
        protected Button Button3;
        protected Button Button4;
        protected DataGrid configdatagrid;
        protected DropDownList le;

        private void BtnFengpan_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET isclose='1' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已封盘");
        }

        private void BtnKaipan_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET isclose='0' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已开盘");
        }

        private void Button1_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET tmclose='0' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已开盘(特码)");
        }

        private void Button2_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET tmclose='1' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已封盘(特码)");
        }

        private void Button3_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET zmclose='0' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已开盘(正码)");
        }

        private void Button4_Click(object sender, EventArgs e)
        {
            string sql = "UPDATE affiche SET zmclose='1' ";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.showmsg("已封盘(正码)");
        }

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
            this.BtnKaipan.Click += new EventHandler(this.BtnKaipan_Click);
            this.BtnFengpan.Click += new EventHandler(this.BtnFengpan_Click);
            this.Button1.Click += new EventHandler(this.Button1_Click);
            this.Button2.Click += new EventHandler(this.Button2_Click);
            this.Button3.Click += new EventHandler(this.Button3_Click);
            this.Button4.Click += new EventHandler(this.Button4_Click);
            base.Load += new EventHandler(this.Page_Load);
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
            if ((this.Session.Contents["classid"] == null) || (this.Session.Contents["classid"].ToString().Trim() != "1"))
            {
                if (this.Session.Contents["adminclassid"] != null)
                {
                    if ((this.Session.Contents["adminclassid"].ToString().Trim() == "5") || (this.Session.Contents["adminclassid"].ToString().Trim() == "1"))
                    {
                        goto Label_00DF;
                    }
                    MyFunc.goToLoginPage();
                    base.Response.End();
                }
                else
                {
                    MyFunc.goToLoginPage();
                    base.Response.End();
                }
                return;
            }
        Label_00DF:
            if (!this.Page.IsPostBack)
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

