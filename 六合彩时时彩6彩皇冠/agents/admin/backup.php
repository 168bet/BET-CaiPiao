<? 
/*  
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}
*/  
  global   $mysqlhost,   $mysqluser,   $mysqlpwd,   $mysqldb;   
  $mysqlhost="localhost";   //host   name   
  $mysqluser="root";                             //login   name   
  $mysqlpwd="zkeys";                             //password   
  $mysqldb="a1016152011";                 //name   of   database   
    
  include("mydb.php");   
  $d=new   db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);   
  /*--------------����--------------*/if(!$_POST['act']){/*----------------------*/   
  $msgs[]="����������Ŀ¼Ϊbackup";   
  $msgs[]="���ڽϴ�����ݱ�ǿ�ҽ���ʹ�÷־���";   
  $msgs[]="ֻ��ѡ�񱸷ݵ�������������ʹ�÷־��ݹ���";   
  ?>  <link rel="stylesheet" href="images/xp.css" type="text/css"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr class="tbtitle">
        <td width="51%"><? require_once '2top.php';?></td>
      </tr>
      <tr >
        <td height="5"></td>
      </tr>
    </table>
  <? show_msg($msgs);?>
  <form   name="form1"   method="post"   action="backup.php">   
      <table   width="100%"   border="1"   cellpadding='0'   cellspacing='1'>   
          
          <tr   align="center"   class='header'><td   colspan="2">���ݱ���</td></tr>   
          <tr><td   colspan="2">���ݷ�ʽ</td></tr>   
          <tr><td><input   type="radio"   name="bfzl" checked="checked"   value="quanbubiao">                 ����ȫ������</td><td>����ȫ�����ݱ��е����ݵ�һ�������ļ�</td></tr>   
          <tr><td><input   type="radio"   name="bfzl"   value="danbiao">���ݵ��ű�����     
                  <select   name="tablename"><option   value="">��ѡ��</option>   
                      <?   
  $d->query("show   table   status   from   $mysqldb");   
  while($d->nextrecord()){   
  echo   "<option   value='".$d->f('Name')."'>".$d->f('Name')."</option>";}   
  ?>   
                  </select></td><td>����ѡ�����ݱ��е����ݵ������ı����ļ�</td></tr>   
          <tr><td   colspan="2">ʹ�÷־���</td></tr>   
          <tr><td   colspan="2"><input   type="checkbox"   name="fenjuan"   value="yes">   
                  �־���   <input   name="filesize"   type="text"   size="10">K</td></tr>   
          <tr><td   colspan="2">ѡ��Ŀ��λ��</td></tr>   
          <tr><td   colspan="2"><input   type="radio"   name="weizhi"   value="server"   >���ݵ�������</td></tr><tr   class="cells"><td   colspan='2'>   <input   type="radio"   name="weizhi" checked  value="localpc">   
                  ���ݵ�����</td></tr>   
          <tr><td   colspan="2"   align='center'><input   type="submit"   name="act"   value="����"></td></tr>   
      </table>
  </form>   
  <?
  /*-------------�������-------------*/}/*---------------------------------*/   
  /*----*/else{/*--------------������-----------------------------------------*/   
  if($_POST['weizhi']=="localpc"&&$_POST['fenjuan']=='yes')   
  {$msgs[]="ֻ��ѡ�񱸷ݵ�������������ʹ�÷־��ݹ���";   
  show_msg($msgs);   pageend();}   
  if($_POST['fenjuan']=="yes"&&!$_POST['filesize'])   
  {$msgs[]="��ѡ���˷־��ݹ��ܣ���δ��д�־��ļ���С";   
  show_msg($msgs);   pageend();}   
  if($_POST['weizhi']=="server"&&!writeable("./backup"))   
  {$msgs[]="�����ļ����Ŀ¼'./backup'����д�����޸�Ŀ¼����";   
  show_msg($msgs);   pageend();}   
    
  /*----------����ȫ����-------------*/if($_POST['bfzl']=="quanbubiao"){/*----*/   
  /*----���־�*/if(!$_POST['fenjuan']){/*--------------------------------*/   
  if(!$tables=$d->query("show   table   status   from   $mysqldb"))   
  {$msgs[]="�����ݿ�ṹ����";   show_msg($msgs);   pageend();}   
  $sql="";   
  while($d->nextrecord($tables))   
  {   
  $table=$d->f("Name");   
  $sql.=make_header($table);   
  $d->query("select   *   from   $table");   
  $num_fields=$d->nf();   
  while($d->nextrecord())   
  {$sql.=make_record($table,$num_fields);}   
  }   
  $filename=date("Ymd",time())."_all.sql";   
  if($_POST['weizhi']=="localpc")   down_file($sql,$filename);   
  elseif($_POST['weizhi']=="server")   
  {if(write_file($sql,$filename))   
  $msgs[]="ȫ�����ݱ����ݱ������,���ɱ����ļ�'./backup/$filename'";   
  else   $msgs[]="����ȫ�����ݱ�ʧ��";   
  show_msg($msgs);   
  pageend();   
  }   
  /*-----------------��Ҫ�����*/}/*-----------------------*/   
  /*-----------------�־�*/else{/*-------------------------*/   
  if(!$_POST['filesize'])   
  {$msgs[]="����д�����ļ��־��С";   show_msg($msgs);pageend();}   
  if(!$tables=$d->query("show   table   status   from   $mysqldb"))   
  {$msgs[]="�����ݿ�ṹ����";   show_msg($msgs);   pageend();}   
  $sql="";   $p=1;   
  $filename=date("Ymd",time())."_all";   
  while($d->nextrecord($tables))   
  {   
  $table=$d->f("Name");   
  $sql.=make_header($table);   
  $d->query("select   *   from   $table");   
  $num_fields=$d->nf();   
  while($d->nextrecord())   
  {$sql.=make_record($table,$num_fields);   
  if(strlen($sql)>=$_POST['filesize']*1000){   
  $filename.=("_v".$p.".sql");   
  if(write_file($sql,$filename))   
  $msgs[]="ȫ�����ݱ�-��-".$p."-���ݱ������,���ɱ����ļ�'./backup/$filename'";   
  else   $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";   
  $p++;   
  $filename=date("Ymd",time())."_all";   
  $sql="";}   
  }   
  }   
  if($sql!=""){$filename.=("_v".$p.".sql");   
  if(write_file($sql,$filename))   
  $msgs[]="ȫ�����ݱ�-��-".$p."-���ݱ������,���ɱ����ļ�'./backup/$filename'";}   
  show_msg($msgs);   
  /*---------------------�־����*/}/*--------------------------------------*/   
  /*--------����ȫ�������*/}/*---------------------------------------------*/   
    
  /*--------���ݵ���------*/elseif($_POST['bfzl']=="danbiao"){/*------------*/   
  if(!$_POST['tablename'])   
  {$msgs[]="��ѡ��Ҫ���ݵ����ݱ�";   show_msg($msgs);   pageend();}   
  /*--------���־�*/if(!$_POST['fenjuan']){/*-------------------------------*/   
  $sql=make_header($_POST['tablename']);   
  $d->query("select   *   from   ".$_POST['tablename']);   
  $num_fields=$d->nf();   
  while($d->nextrecord())   
  {$sql.=make_record($_POST['tablename'],$num_fields);}   
  $filename=date("Ymd",time())."_".$_POST['tablename'].".sql";   
  if($_POST['weizhi']=="localpc")   down_file($sql,$filename);   
  elseif($_POST['weizhi']=="server")   
  {if(write_file($sql,$filename))   
  $msgs[]="��-".$_POST['tablename']."-���ݱ������,���ɱ����ļ�'./backup/$filename'";   
  else   $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";   
  show_msg($msgs);   
  pageend();   
  }   
  /*----------------��Ҫ�����*/}/*------------------------------------*/   
  /*----------------�־�*/else{/*--------------------------------------*/   
  if(!$_POST['filesize'])   
  {$msgs[]="����д�����ļ��־��С";   show_msg($msgs);pageend();}   
  $sql=make_header($_POST['tablename']);   $p=1;     
  $filename=date("Ymd",time())."_".$_POST['tablename'];   
  $d->query("select   *   from   ".$_POST['tablename']);   
  $num_fields=$d->nf();   
  while   ($d->nextrecord())     
  {   
  $sql.=make_record($_POST['tablename'],$num_fields);   
        if(strlen($sql)>=$_POST['filesize']*1000){   
  $filename.=("_v".$p.".sql");   
  if(write_file($sql,$filename))   
  $msgs[]="��-".$_POST['tablename']."-��-".$p."-���ݱ������,���ɱ����ļ�'./backup/$filename'";   
  else   $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";   
  $p++;   
  $filename=date("Ymd",time())."_".$_POST['tablename'];   
  $sql="";}   
  }   
  if($sql!=""){$filename.=("_v".$p.".sql");   
  if(write_file($sql,$filename))   
  $msgs[]="��-".$_POST['tablename']."-��-".$p."-���ݱ������,���ɱ����ļ�'./backup/$filename'";}   
  show_msg($msgs);   
  /*----------�־����*/}/*--------------------------------------------------*/   
  /*----------���ݵ������*/}/*----------------------------------------------*/   
    
  /*---*/}/*-------------���������------------------------------------------*/   
    
  function   write_file($sql,$filename)   
  {   
  $re=true;   
  if(!@$fp=fopen("./backup/".$filename,"w+"))   {$re=false;   echo   "failed   to   open   target   file";}   
  if(!@fwrite($fp,$sql))   {$re=false;   echo   "failed   to   write   file";}   
  if(!@fclose($fp))   {$re=false;   echo   "failed   to   close   target   file";}   
  return   $re;   
  }   
    
  function   down_file($sql,$filename)   
  {   
  ob_end_clean();   
  header("Content-Encoding:   none");   
  header("Content-Type:   ".(strpos($_SERVER['HTTP_USER_AGENT'],   'MSIE')   ?   'application/octetstream'   :   'application/octet-stream'));   
    
  header("Content-Disposition:   ".(strpos($_SERVER['HTTP_USER_AGENT'],   'MSIE')   ?   'inline;   '   :   'attachment;   ')."filename=".$filename);   
    
  header("Content-Length:   ".strlen($sql));   
  header("Pragma:   no-cache");   
    
  header("Expires:   0");   
  echo   $sql;   
  $e=ob_get_contents();   
  ob_end_clean();   
  }   
    
  function   writeable($dir)   
  {   
    
  if(!is_dir($dir))   {   
  @mkdir($dir,   0777);   
  }   
    
  if(is_dir($dir))     
  {   
    
  if($fp   =   @fopen("$dir/test.test",   'w'))   
  {   
  @fclose($fp);   
  @unlink("$dir/test.test");   
  $writeable   =   1;   
  }     
  else   {   
  $writeable   =   0;   
  }   
    
  }   
    
  return   $writeable;   
    
  }   
    
  function   make_header($table)   
  {global   $d;   
  $sql="DROP   TABLE   IF   EXISTS   ".$table."\n";   
  $d->query("show   create   table   ".$table);   
  $d->nextrecord();   
  $tmp=preg_replace("/\n/","",$d->f("Create   Table")); 
  $sql.=$tmp."\n";   
  return   $sql;   
  }   
    
  function   make_record($table,$num_fields)   
  {global   $d;   
  $comma="";   
  $sql   .=   "INSERT   INTO   ".$table."   VALUES(";   
  for($i   =   0;   $i   <   $num_fields;   $i++)     
  {$sql   .=   ($comma."'".mysql_escape_string($d->record[$i])."'");   $comma   =   ",";}   
  $sql   .=   ")\n";   
  return   $sql;   
  }   
    
  function   show_msg($msgs)   
  {   
  $title="��ʾ��";   
  echo   "<table   width='100%'   border='1'     cellpadding='0'   cellspacing='1'>";   
  echo   "<tr><td>".$title."</td></tr>";   
  echo   "<tr><td><br><ul>";   
  while   (list($k,$v)=each($msgs))   
  {   
  echo   "<li>".$v."</li>";   
  }   
  echo   "</ul></td></tr></table>";   
  }   
    
  function   pageend()   
  {   
  exit();   
  }   
  
  
  /*
$host="localhost"; //������     
$user="root"; //MYSQL�û���     
$password="root"; //����     
$dbname="dedecmsv4"; //���ݵ����ݿ�     
   
mysql_connect($host,$user,$password);     
mysql_select_db($dbname);     
   
$q1=mysql_query("show tables");     
while($t=mysql_fetch_array($q1)){     
$table=$t[0];     
$q2=mysql_query("show create table `$table`");     
$sql=mysql_fetch_array($q2);     
$mysql.=$sql['Create Table'].";\r\n\r\n";#DDL     
   
$q3=mysql_query("select * from `$table`");     
while($data=mysql_fetch_assoc($q3))     
{     
$keys=array_keys($data);     
$keys=array_map('addslashes',$keys);     
$keys=join('`,`',$keys);     
$keys="`".$keys."`";     
$vals=array_values($data);     
$vals=array_map('addslashes',$vals);     
$vals=join("','",$vals);     
$vals="'".$vals."'";     
   
$mysql.="insert into `$table`($keys) values($vals);\r\n";     
}     
$mysql.="\r\n";     
   
}     
$filename=date('Ymd')."_".$dbname.".sql"; //�ļ���Ϊ���������     
$fp = fopen($filename,'w');     
fputs($fp,$mysql);     
fclose($fp);     
echo "���ݱ��ݳɹ�,���ɱ����ļ�".$filename;
*/
  ?> 
  
  