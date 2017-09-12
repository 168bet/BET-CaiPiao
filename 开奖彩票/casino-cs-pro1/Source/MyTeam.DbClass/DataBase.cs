namespace MyTeam.DbClass
{
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Web;

    public class DataBase
    {
        private SqlConnection CONN;

        public DataBase(string connStr)
        {
            try
            {
                if (connStr == "")
                {
                    throw new Exception("数据库没有连接字符!");
                }
                this.CONN = new SqlConnection(connStr);
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库连接出错!");
                HttpContext.Current.Response.End();
            }
        }

        public bool CheckConnected()
        {
            if (this.CONN.State != ConnectionState.Open)
            {
                try
                {
                    if (this.CONN.ConnectionString == "")
                    {
                        throw new Exception("数据库没有连接字符!");
                    }
                    this.OpenConnect();
                    return true;
                }
                catch
                {
                    HttpContext.Current.Response.Write("数据库连接出错!");
                    HttpContext.Current.Response.End();
                    return false;
                }
            }
            return true;
        }

        public void CloseConnect()
        {
            this.CONN.Close();
        }

        public void Dispose()
        {
            if (this.ConnectState == ConnectionState.Open)
            {
                this.CONN.Close();
            }
            this.CONN.Dispose();
        }

        public virtual DataSet ExecuteDataSet(string sql)
        {
            if (!this.CheckConnected())
            {
                return null;
            }
            try
            {
                DataSet dataSet = new DataSet();
                new SqlDataAdapter(sql, this.CONN).Fill(dataSet);
                return dataSet;
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库查询出错!");
                HttpContext.Current.Response.End();
                return null;
            }
        }

        public virtual DataSet ExecuteDataSet(string sql, int start, int pagesize, string table)
        {
            if (!this.CheckConnected())
            {
                return null;
            }
            try
            {
                DataSet dataSet = new DataSet();
                new SqlDataAdapter(sql, this.CONN).Fill(dataSet, start, pagesize, table);
                return dataSet;
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库查询出错!");
                HttpContext.Current.Response.End();
                return null;
            }
        }

        public virtual int ExecuteNonQuery(string sql)
        {
            if (!this.CheckConnected())
            {
                return 0;
            }
            try
            {
                SqlCommand command = new SqlCommand(sql);
                command.Connection = this.CONN;
                return command.ExecuteNonQuery();
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库查询出错!");
                HttpContext.Current.Response.End();
                return 0;
            }
        }

        public virtual SqlDataReader ExecuteReader(string sql)
        {
            if (!this.CheckConnected())
            {
                return null;
            }
            try
            {
                SqlCommand command = new SqlCommand(sql);
                command.Connection = this.CONN;
                return command.ExecuteReader();
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库查询出错!");
                HttpContext.Current.Response.End();
                return null;
            }
        }

        public virtual object ExecuteScalar(string sql)
        {
            if (!this.CheckConnected())
            {
                return null;
            }
            try
            {
                SqlCommand command = new SqlCommand(sql);
                command.Connection = this.CONN;
                return command.ExecuteScalar();
            }
            catch
            {
                HttpContext.Current.Response.Write("数据库查询出错!");
                HttpContext.Current.Response.End();
                return null;
            }
        }

        public void OpenConnect()
        {
            if (this.CONN.State != ConnectionState.Open)
            {
                this.CONN.Open();
            }
        }

        public ConnectionState ConnectState
        {
            get
            {
                return this.CONN.State;
            }
        }
    }
}

