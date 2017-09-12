namespace newball.mem.gj
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Web.UI;
    using System.Web.UI.WebControls;

    public class chgCurmoney : Page
    {
        protected Button subdel;

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
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage("../");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "odds"))
            {
                string sql = "";
                sql = "DELETE ball_order";
                DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
                base2.ExecuteNonQuery(sql);
                base2.Dispose();
                DataBase base3 = new DataBase(MyFunc.GetConnStr(1));
                sql = "update changeleave set giveup1sum=0";
                base3.ExecuteNonQuery(sql);
                base3.Dispose();
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "order1"))
            {
                DataBase base4 = new DataBase(MyFunc.GetConnStr(2));
                string text2 = "";
                text2 = "select * from ball_order1 where orderid not in (select orderid from ball_order where datediff(d,updatetime,'2005-07-11') > 6);";
                text2 = text2 + "delete from ball_bf1";
                base4.ExecuteNonQuery(text2);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "deluser"))
            {
                DataBase base5 = new DataBase(MyFunc.GetConnStr(2));
                string text3 = "";
                text3 = "delete from member where datediff(d,regtime,getdate()) > 15 and userid not in (select userid from ball_order)";
                base5.ExecuteNonQuery(text3);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "deldls"))
            {
                DataBase base6 = new DataBase(MyFunc.GetConnStr(2));
                string text4 = "";
                text4 = "delete from agence where datediff(d,regtime,getdate()) > 15 and classid = 4 and userid not in (select dlsid from ball_order)";
                base6.ExecuteNonQuery(text4);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "delzdl"))
            {
                DataBase base7 = new DataBase(MyFunc.GetConnStr(2));
                string text5 = "";
                text5 = "delete from agence where datediff(d,regtime,getdate()) > 15 and classid = 3 and userid not in (select zdlid from ball_order)";
                base7.ExecuteNonQuery(text5);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "delgd"))
            {
                DataBase base8 = new DataBase(MyFunc.GetConnStr(2));
                string text6 = "";
                text6 = "delete from agence where datediff(d,regtime,getdate()) > 15 and classid = 2 and userid not in (select gdid from ball_order)";
                base8.ExecuteNonQuery(text6);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
            else if ((base.Request["action"] != null) && (base.Request["action"].Trim() == "del45order"))
            {
                DataBase base9 = new DataBase(MyFunc.GetConnStr(2));
                string text7 = "";
                text7 = "delete from ball_order where datediff(d,updatetime,getdate()) > 45";
                base9.ExecuteNonQuery(text7);
                MyFunc.JumpPage("删除成功。", "chgLists.aspx");
                base.Response.End();
            }
        }
    }
}

