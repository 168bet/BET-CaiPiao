namespace mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class basketjs : Page
    {
        protected Button ButtonJsAHgg;
        protected DataGrid DataGrid1;
        public string RunTime;
        public string selday;
        protected HtmlSelect SelectDay;

        public string BallStatus(string iscancel, string ishtcancel, string isjs)
        {
            string text = "";
            if (iscancel.ToUpper() == "TRUE")
            {
                text = text + " <font color=red>已取消</font>";
            }
            if (isjs.ToUpper() == "TRUE")
            {
                text = text + "  <font color=blue>已结</font>";
            }
            return text;
        }

        private void ButtonJsAHgg_Click(object sender, EventArgs e)
        {
            base.Response.Redirect("basketjsshow.aspx?action=kygl&basketthisdate=" + this.selday + "&jstype=21&ballid=0");
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
            }
        }

        private void FillDataGrid(string sday)
        {
            string sql = "SELECT ballid,matchname,team1,team2,fen1,fen2,sortballtime,ishtcancel,iscancel,ishtcancel,isjs FROM Ball_BF WHERE isBK = 1 AND (charindex('上半',matchname,0) = 0) AND (charindex('下半',matchname,0) = 0) AND datediff(day,sortballtime,'" + sday + "')=0 ORDER BY sortballtime";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            DataSet set = new DataSet();
            set = base2.ExecuteDataSet(sql);
            this.DataGrid1.DataSource = set;
            base2.CloseConnect();
            base2.Dispose();
        }

        private void InitializeComponent()
        {
            this.ButtonJsAHgg.Click += new EventHandler(this.ButtonJsAHgg_Click);
            this.DataGrid1.ItemDataBound += new DataGridItemEventHandler(this.DataGrid1_ItemDataBound);
            base.Load += new EventHandler(this.Page_Load);
        }

        public string JsLink(string ballid)
        {
            return ("<a href=basketjsshow.aspx?ballid=" + ballid + " onclick=\"return confirm('确定要重新结算该赛事的订单吗?');\">结算</a>");
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
            else
            {
                if (base.Request.Params["MySelDate"] == null)
                {
                    if (this.Session.Contents["basketthisDay"] == null)
                    {
                        this.Session.Contents["basketthisDay"] = DateTime.Today.ToShortDateString();
                    }
                }
                else
                {
                    this.Session.Contents["basketthisDay"] = base.Request.Params["MySelDate"];
                }
                this.selday = this.Session.Contents["basketthisDay"].ToString();
                if (!base.IsPostBack)
                {
                    for (int i = 0; i < 7; i++)
                    {
                        this.SelectDay.Items.Add(new ListItem(DateTime.Today.AddDays((double) -i).ToShortDateString() + " " + MyFunc.DayToWeek(DateTime.Today.AddDays((double) -i)), DateTime.Today.AddDays((double) -i).ToShortDateString()));
                    }
                }
                this.FillDataGrid(this.selday);
                this.DataGrid1.DataBind();
            }
        }
    }
}

