<?   
  class   db{   
    
  var   $linkid;   
  var   $sqlid;   
  var   $record;   
    
  function   db($host="",$username="",$password="",$database="")   
  {   
  if(!$this->linkid)     @$this->linkid   =   mysql_connect($host,   $username,   $password)   or   die("���ӷ�����ʧ��.");   
  @mysql_select_db($database,$this->linkid)   or   die("�޷������ݿ�");   
  return   $this->linkid;}   
    
  function   query($sql)   
  {if($this->sqlid=mysql_query($sql,$this->linkid))   return   $this->sqlid;   
  else   {   
  $this->err_report($sql,mysql_error);   
  return   false;}   
  }   
    
  function   nr($sql_id="")   
  {if(!$sql_id)   $sql_id=$this->sqlid;   
  return   mysql_num_rows($sql_id);}   
    
  function   nf($sql_id="")   
  {if(!$sql_id)   $sql_id=$this->sqlid;   
  return   mysql_num_fields($sql_id);}   
    
  function   nextrecord($sql_id="")   
  {if(!$sql_id)   $sql_id=$this->sqlid;   
  if($this->record=mysql_fetch_array($sql_id))     return   $this->record;   
  else   return   false;   
  }   
    
  function   f($name)   
  {   
  if($this->record[$name])   return   $this->record[$name];   
  else   return   false;   
  }   
    
  function   close()   {mysql_close($this->linkid);}   
    
  function   lock($tblname,$op="WRITE")   
  {if(mysql_query("lock   tables   ".$tblname."   ".$op))   return   true;   else   return   false;}   
    
  function   unlock()   
  {if(mysql_query("unlock   tables"))   return   true;   else   return   false;}   
    
  function   ar()   {   
          return   @mysql_affected_rows($this->linkid);   
      }   
    
  function   i_id()   {   
  return   mysql_insert_id();   
  }   
    
  function   err_report($sql,$err)   
  {   
  echo   "Mysql��ѯ����<br>";   
  echo   "��ѯ��䣺".$sql."<br>";   
  echo   "������Ϣ��".$err;   
  }   
  /****************************************�����***************************/   
  }?>
