namespace newball.gs
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class SelBallList : Page
    {
        protected DataGrid DataGrid1;

        private void DataGrid1_DataBinding(object sender, EventArgs e)
        {
        }

        private void DataGrid1_ItemDataBound(object sender, DataGridItemEventArgs e)
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
                e.Item.Cells[0].Attributes["OnMouseOver"] = "this.style.cursor='hand';";
            }
        }

        private void InitializeComponent()
        {
            this.DataGrid1.DataBinding += new EventHandler(this.DataGrid1_DataBinding);
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
            }
            else if (!base.IsPostBack)
            {
                string text;
                string text2;
                if (((base.Request.QueryString["date_start"] != null) && (base.Request.QueryString["date_start"].ToString().Trim() != "")) && ((base.Request.QueryString["date_end"] != null) && (base.Request.QueryString["date_end"].ToString().Trim() != "")))
                {
                    text = base.Request.QueryString["date_start"].ToString().Trim();
                    text2 = base.Request.QueryString["date_end"].ToString().Trim();
                }
                else
                {
                    text = DateTime.Now.ToShortDateString();
                    text2 = DateTime.Now.ToShortDateString();
                }
                DataSet set = new DataBase(MyFunc.GetConnStr(2)).ExecuteDataSet("SELECT ballid,matchname,team1,team2,sortballtime FROM ball_bf WHERE sortballtime between '" + text + " 00:00:00' and '" + text2 + " 23:59:59' ORDER BY sortballtime");
                this.DataGrid1.DataSource = set;
                this.DataGrid1.DataBind();
                for (int i = 0; i < set.Tables[0].Rows.Count; i++)
                {
                    ((CheckBox) this.DataGrid1.Items[i].FindControl("cbxStatus")).Attributes["OnClick"] = "AddToList(this,'" + set.Tables[0].Rows[i]["ballid"].ToString().Trim() + "');";
                }
            }
        }
    }
}

