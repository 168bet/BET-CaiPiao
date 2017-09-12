namespace newball
{
    using System;
    using System.ComponentModel;
    using System.Web;

    public class Global : HttpApplication
    {
        private IContainer components = null;
        public static int ListCount;
        public static string[][] OnlineList = new string[0x3e8][];
        

        public Global()
        {
            this.InitializeComponent();
        }

        protected void Application_AuthenticateRequest(object sender, EventArgs e)
        {
        }

        protected void Application_BeginRequest(object sender, EventArgs e)
        {
        }

        protected void Application_End(object sender, EventArgs e)
        {
        }

        protected void Application_EndRequest(object sender, EventArgs e)
        {
        }

        protected void Application_Error(object sender, EventArgs e)
        {
        }

        protected void Application_Start(object sender, EventArgs e)
        {
            for (int i = 0; i < OnlineList.Length; i++)
            {
                OnlineList[i] = new string[8];
            }
            ListCount = 0;
        }

        private void InitializeComponent()
        {
            this.components = new Container();
        }

        protected void Session_End(object sender, EventArgs e)
        {
        }

        protected void Session_Start(object sender, EventArgs e)
        {
        }
    }
}

