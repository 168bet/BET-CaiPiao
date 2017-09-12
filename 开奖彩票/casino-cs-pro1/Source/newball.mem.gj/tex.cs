namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;
    using System.Web.UI.HtmlControls;
    using System.Web.UI.WebControls;

    public class tex : Page
    {
        protected TextBox befindContent;
        protected TextBox frontContent;
        protected DropDownList isBehind;
        protected DropDownList isFront;
        protected Button submitbutton;
        protected HtmlTable tableconfig;
        protected HtmlTable tabletitle;

        private void InitializeComponent()
        {
            this.submitbutton.Click += new EventHandler(this.submitbutton_Click);
            this.ID = "tex";
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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!base.IsPostBack)
            {
                this.setstartvalue();
            }
        }

        private void setstartvalue()
        {
            string sql = "SELECT vindID,isFront,frontContent,isBehind,befindContent FROM vindicate";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                if (reader["frontContent"].ToString().Trim() != "")
                {
                    this.frontContent.Text = reader["frontContent"].ToString().Trim().Substring(1, reader["frontContent"].ToString().Trim().Length - 2);
                }
                if (reader["befindContent"].ToString().Trim() != "")
                {
                    this.befindContent.Text = reader["befindContent"].ToString().Trim().Substring(1, reader["befindContent"].ToString().Trim().Length - 2);
                }
                if (reader["isFront"].ToString().Trim().ToLower() == "false")
                {
                    this.isFront.SelectedValue = "0";
                }
                else
                {
                    this.isFront.SelectedValue = "1";
                }
                if (reader["isBehind"].ToString().Trim().ToLower() == "false")
                {
                    this.isBehind.SelectedValue = "0";
                }
                else
                {
                    this.isBehind.SelectedValue = "1";
                }
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
        }

        private void submitbutton_Click(object sender, EventArgs e)
        {
            string sql = "";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader("SELECT vindID,isFront,frontContent,isBehind,befindContent FROM vindicate");
            if (reader.Read())
            {
                sql = "UPDATE vindicate SET frontContent = '" + this.frontContent.Text.Trim() + "',befindContent = '" + this.befindContent.Text.Trim() + "',isFront = " + this.isFront.SelectedValue.ToString() + ",isBehind = " + this.isBehind.SelectedValue.ToString();
            }
            else
            {
                sql = "INSERT INTO vindicate (isFront,frontContent,isBehind,befindContent) VALUES (" + this.isFront.SelectedValue.ToString() + ",'" + this.frontContent.Text.Trim() + "'," + this.isBehind.SelectedValue.ToString() + ",'" + this.befindContent.Text.Trim() + "')";
            }
            if (this.isFront.SelectedValue.Trim() == "1")
            {
                MyTeam.OnlineList.OnlineList.TickClassidDown(",,20,");
            }
            if (this.isBehind.SelectedValue.Trim() == "1")
            {
                MyTeam.OnlineList.OnlineList.TickClassidDown(",,0,2,3,4,22,33,44,");
            }
            reader.Close();
            base2.ExecuteNonQuery(sql);
            base2.CloseConnect();
            base2.Dispose();
            MyFunc.JumpPage("设定成功！", "chglists.aspx");
        }
    }
}

