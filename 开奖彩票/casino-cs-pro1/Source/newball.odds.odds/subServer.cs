namespace newball.odds.odds
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class subServer : Page
    {
        protected Button ButtonAdd;
        protected DataGrid DataGrid1;
        protected HtmlForm Form1;

        private void ButtonAdd_Click(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataView defaultView = base2.ExecuteDataSet("SELECT * FROM subServer ORDER BY serverid").Tables[0].DefaultView;
            defaultView.AddNew();
            this.DataGrid1.DataSource = defaultView;
            this.DataGrid1.EditItemIndex = defaultView.Count - 1;
            this.DataGrid1.DataBind();
        }

        public void CancelServer(object source, DataGridCommandEventArgs e)
        {
            this.DataGrid1.EditItemIndex = -1;
            this.DataGridBind();
            this.DataGrid1.DataBind();
        }

        private void DataGrid1_ItemDataBound(object sender, DataGridItemEventArgs e)
        {
            e.Item.Cells[3].Attributes["OnClick"] = "return confirm('确定要删除该子服务器吗?')";
        }

        private void DataGridBind()
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataView defaultView = base2.ExecuteDataSet("SELECT * FROM subServer ORDER BY serverid").Tables[0].DefaultView;
            this.DataGrid1.DataSource = defaultView;
        }

        public void DelServer(object source, DataGridCommandEventArgs e)
        {
            string text = ((TextBox) e.Item.Cells[0].Controls[1]).Text.Trim();
            if (text != "")
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("DELETE FROM subServer WHERE serverid=" + text);
                base2.Dispose();
            }
            this.DataGridBind();
            this.DataGrid1.DataBind();
        }

        public void EditServer(object source, DataGridCommandEventArgs e)
        {
            this.DataGrid1.EditItemIndex = e.Item.ItemIndex;
            this.DataGridBind();
            this.DataGrid1.DataBind();
        }

        private void InitializeComponent()
        {
            this.ButtonAdd.Click += new EventHandler(this.ButtonAdd_Click);
            this.DataGrid1.ItemDataBound += new DataGridItemEventHandler(this.DataGrid1_ItemDataBound);
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
            if (!MyFunc.CheckUserLogin(0))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                this.DataGridBind();
                this.DataGrid1.DataBind();
            }
        }

        public void SaveServer(object source, DataGridCommandEventArgs e)
        {
            string text = base.Request.Form["serverid"].ToString().Trim();
            string text2 = base.Request.Form["servername"].ToString().Trim();
            if (text == "")
            {
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery("INSERT INTO subServer(servername)VALUES('" + text2 + "')");
                this.DataGrid1.EditItemIndex = -1;
                this.DataGridBind();
                this.DataGrid1.DataBind();
                base2.Dispose();
            }
            else
            {
                DataBase base3 = new DataBase(MyFunc.GetConnStr(2));
                base3.ExecuteNonQuery("UPDATE subServer SET servername='" + text2 + "' WHERE serverid=" + text);
                this.DataGrid1.EditItemIndex = -1;
                this.DataGridBind();
                this.DataGrid1.DataBind();
                base3.Dispose();
            }
        }
    }
}

