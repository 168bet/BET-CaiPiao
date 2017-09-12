namespace Xiaobao.DataBase
{
    using MyTeam.Functions;
    using System;
    using System.Data;
    using System.Data.SqlClient;
    using System.Runtime.InteropServices;

    public class ProDataBase : IDisposable
    {
        private SqlConnection con;

        public void Close()
        {
            if (this.con != null)
            {
                this.con.Close();
            }
        }

        private SqlCommand CreateCommand(string procName, SqlParameter[] prams)
        {
            this.Open();
            SqlCommand command = new SqlCommand(procName, this.con);
            command.CommandType = CommandType.StoredProcedure;
            if (prams != null)
            {
                foreach (SqlParameter parameter in prams)
                {
                    command.Parameters.Add(parameter);
                }
            }
            command.Parameters.Add(new SqlParameter("ReturnValue", SqlDbType.Int, 4, ParameterDirection.ReturnValue, false, 0, 0, string.Empty, DataRowVersion.Default, null));
            return command;
        }

        public void Dispose()
        {
            if (this.con != null)
            {
                this.con.Dispose();
                this.con = null;
            }
        }

        public SqlParameter MakeInParam(string ParamName, SqlDbType DbType, int Size, object Value)
        {
            return this.MakeParam(ParamName, DbType, Size, ParameterDirection.Input, Value);
        }

        public SqlParameter MakeOutParam(string ParamName, SqlDbType DbType, int Size)
        {
            return this.MakeParam(ParamName, DbType, Size, ParameterDirection.Output, null);
        }

        public SqlParameter MakeParam(string ParamName, SqlDbType DbType, int Size, ParameterDirection Direction, object Value)
        {
            SqlParameter parameter;
            if (Size > 0)
            {
                parameter = new SqlParameter(ParamName, DbType, Size);
            }
            else
            {
                parameter = new SqlParameter(ParamName, DbType);
            }
            parameter.Direction = Direction;
            if ((Direction != ParameterDirection.Output) || (Value != null))
            {
                parameter.Value = Value;
            }
            return parameter;
        }

        public SqlParameter MakeReturnParam(string ParamName, SqlDbType DbType, int Size)
        {
            return this.MakeParam(ParamName, DbType, Size, ParameterDirection.ReturnValue, null);
        }

        private void Open()
        {
            if (this.con == null)
            {
                this.con = new SqlConnection(MyFunc.GetConnStr(2));
            }
            if (this.con.State == ConnectionState.Closed)
            {
                this.con.Open();
            }
        }

        public int RunProc(string procName)
        {
            SqlCommand command = this.CreateCommand(procName, null);
            command.ExecuteNonQuery();
            this.Close();
            return (int) command.Parameters["ReturnValue"].Value;
        }

        public void RunProc(string procName, out SqlDataReader dataReader)
        {
            dataReader = this.CreateCommand(procName, null).ExecuteReader(CommandBehavior.CloseConnection);
        }

        public int RunProc(string procName, SqlParameter[] prams)
        {
            SqlCommand command = this.CreateCommand(procName, prams);
            command.ExecuteNonQuery();
            this.Close();
            return (int) command.Parameters["ReturnValue"].Value;
        }

        public void RunProc(string procName, SqlParameter[] prams, out SqlDataReader dataReader)
        {
            dataReader = this.CreateCommand(procName, prams).ExecuteReader(CommandBehavior.CloseConnection);
        }
    }
}

