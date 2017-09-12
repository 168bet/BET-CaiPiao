<?

        if (isset($_SERVER['SERVER_PORT']))
            {
                $port = ':' . $_SERVER['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
                {
                    $port = '';
                }
            }

$global_vars = array(
	"BROWSER_IP"		=>	"http://".$_SERVER['SERVER_NAME'].$port,
	"CASINO"            =>  "SI2",
);
while (list($key, $value) = each($global_vars)) {
  define($key, $value);
}
function get_ip(){

   if($_SERVER['HTTP_X_FORWARDED_FOR']){
  
    $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $c_agentip=1;
   
   }elseif($_SERVER['HTTP_CLIENT_IP']){
  
    $onlineip = $_SERVER['HTTP_CLIENT_IP'];
    $c_agentip=1;
   
   }else{
  
    $onlineip = $_SERVER['REMOTE_ADDR'];
    $c_agentip=0;
   
   }
   //$c_agentip记录是否为代理ip
   return $onlineip;
}
?>