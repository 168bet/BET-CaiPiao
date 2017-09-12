namespace vindicate
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class behind : Page
    {
        public string btncontent = "";

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
            string sql = "SELECT top 1 vindID,isFront,frontContent,isBehind,befindContent FROM vindicate";
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            if (reader.Read())
            {
                this.btncontent = reader["befindContent"].ToString();
            }
            reader.Close();
            base2.Dispose();
        }
    }
}

