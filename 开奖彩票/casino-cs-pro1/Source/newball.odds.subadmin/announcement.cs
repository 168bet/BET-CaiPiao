namespace newball.odds.subadmin
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class announcement : Page
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
            if (this.Session.Contents["classid"].ToString().Trim() != "1")
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                this.kyglContent = "";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                SqlDataReader reader = base2.ExecuteReader("SELECT top 1 convert(nvarchar,updatetime,11) as updatetime,content FROM affiche WHERE le=2 ORDER BY updatetime DESC");
                while (reader.Read())
                {
                    this.kyglContent = this.kyglContent + MyFunc.ConvertStr(reader["content"].ToString().Trim()) + "&nbsp;&nbsp;&nbsp;";
                }
                reader.Close();
                base2.Dispose();
                this.DataBind();
            }
        }
    }
}

