namespace newball.mem
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class list : Page
    {
        protected HtmlInputText curpl;
        protected HtmlInputText gameid;
        protected HtmlInputButton inpuSubmit;
        protected HtmlInputText iscance;
        protected HtmlInputText isjz;
        protected HtmlInputText lose;
        protected HtmlInputText Marker;
        protected HtmlTextArea Orderbz;
        protected HtmlInputText orderid;
        protected Panel panelShow;
        protected HtmlInputText Rqteam;
        protected HtmlInputText searchorderid;
        protected HtmlInputText team;
        protected HtmlInputText teamGRP;
        protected HtmlInputText Truewin;
        protected HtmlInputText tzMoney;
        protected HtmlInputText tztype;
        protected HtmlInputText Userts;
        protected HtmlInputText win;

        private void InitializeComponent()
        {
            this.inpuSubmit.ServerClick += new EventHandler(this.inpuSubmit_ServerClick);
            base.Load += new EventHandler(this.Page_Load);
        }

        private void inpuSubmit_ServerClick(object sender, EventArgs e)
        {
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
        }
    }
}

