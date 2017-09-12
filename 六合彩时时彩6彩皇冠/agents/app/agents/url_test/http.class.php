<?
class cHTTP {                           //ver1.0 Last modify by lostgdi 05/1/7

		var $referer;
		var $postStr;

		var $retStr;
		var $theData;

		var $theCookies;
		var $proxy_host="";
		var $proxy_port="0";


		function clsHTTP(){

		}


		function setReferer($sRef){
			$this->referer = $sRef;
		}


		function addField($sName, $sValue){
			$this->postStr .= $sName . "=" . $this->HTMLEncode($sValue) . "&";
		}
		function clearFields(){
			$this->postStr = "";
		}

		function checkCookies(){
			$cookies = explode("Set-Cookie:", $this->theData );
			$i = 0;
			if ( count($cookies)-1 > 0 ) {
				while(list($foo, $theCookie) = each($cookies)) {
					if (! ($i == 0) ) {
						@list($theCookie, $foo) = explode(";", $theCookie);
						list($cookieName, $cookieValue) = explode("=", $theCookie);
						@list($cookieValue, $foo) = explode("\r\n", $cookieValue);
						$this->setCookies(trim($cookieName), trim($cookieValue));
					}
					$i++;
				}
			}
		}

		function setCookies($sName, $sValue){

			$total = count(explode($sName, $this->theCookies));

			if ( $total > 1 ) {
				list($foo, $cValue)  = explode($sName, $this->theCookies);
				list($cValue, $foo)  = explode(";", $cValue);

				$this->theCookies = str_replace($sName . $cValue . ";", "", $this->theCookies);
			}
			$this->theCookies .= $sName . "=" . $this->HTMLEncode($sValue) . ";";
		}

		function getCookies($sName){
			@list($foo, $cValue)  = explode($sName, $this->theCookies);
			@list($cValue, $foo)  = explode(";", $cValue);
			return substr($cValue, 1);
		}

        // Cookie format:   Name1 = Value1;<NameN = ValueN;>
		function getFirstCookieName(){
			@list($cValue, $foo)  = explode("=", $this->theCookies);
			return $cValue;
		}

		function getFirstCookieValue(){
			@list($foo, $cValue)  = explode("=", $this->theCookies);
    		@list($cValue, $foo)  = explode(";", $cValue);
			return $cValue;
		}
        //

		function clearCookies(){
			$this->theCookies = "";
		}


		function getContent(){
			@list($header, $foo)  = explode("\r\n\r\n", $this->theData);
			@list($foo, $content) = explode($header, $this->theData);
			return substr($content, 4);
		}

		function getHeaders(){
			list($header, $foo)  = explode("\r\n\r\n", $this->theData);
			list($foo, $content) = explode($header, $this->theData);
				return $header;
		}

		function getHeader($sName){
			list($foo, $part1) = explode($sName . ":", $this->theData);
			list($sVal, $foo)  = explode("\r\n", $part1);
				return trim($sVal);
		}

		function postPage($sURL){
        	$host = "";
            $port = "";
            if ( $this->proxy_host != "" )
            {
             	$request = $sURL;
                $host = $this->proxy_host;
                $port = $this->proxy_port;
            }
            else
            {
				$SI2nfo = $this->parseRequest($sURL);
				$request = $SI2nfo['request'];
				$host    = $SI2nfo['host'];
				$port    = $SI2nfo['port'];
            }

			$this->postStr = substr($this->postStr, 0, -1); //retira a ultima &

			$httpHeader  = "POST $request HTTP/1.0\r\n";
			$httpHeader .= "Host: $host\r\n";
//			$httpHeader .= "Connection: Close\r\n";
			$httpHeader .= "User-Agent: cHTTP/0.1b (incompatible; M$ sucks; Open Source Rulez)\r\n";
//			$httpHeader .= "Content-type: application/x-www-form-urlencoded\r\n";
			$httpHeader .= "Content-length: " . strlen($this->postStr) . "\r\n";
//          $httpHeader .= "Transfer-Encoding: chunked \r\n";
//          $httpHeader .= "Accept-Encoding: gzip, deflate \r\n";

			$httpHeader .= "Referer: " . $this->referer . "\r\n";
            $httpHeader .= "Cookie: " . $this->theCookies . "\r\n";

			$httpHeader .= "\r\n";
			$httpHeader .= $this->postStr;
			$httpHeader .= "\r\n\r\n";
			$this->theData = $this->downloadData($host, $port, $httpHeader); // envia os dados para o servidor

			$this->checkCookies();
            $this->dataDecode();
		}

		function getPage($sURL){
            if ( $this->proxy_host != "" )
            {
             	$request = $sURL;
                $host = $this->proxy_host;
                $port = $this->proxy_port;
            }
            else
            {
				$SI2nfo = $this->parseRequest($sURL);
				$request = $SI2nfo['request'];
				$host    = $SI2nfo['host'];
				$port    = $SI2nfo['port'];
            }

			$httpHeader  = "GET $request HTTP/1.0\r\n";
            $httpHeader .= "Referer: " . $this->referer . "\r\n";
//			$httpHeader .= "Connection: Close\r\n";
//			$httpHeader .= "User-Agent: cHTTP/0.1b (incompatible; M$ sucks; Open Source Rulez)\r\n";
            $httpHeader .= "User-Agent: Mozilla/4.0 (compatible; MSI2E 6.0; Windows NT 5.1)\r\n";
			$httpHeader .= "Cookie: " . substr($this->theCookies, 0, -1) . "\r\n";
//          $httpHeader .= "Transfer-Encoding: chunked \r\n";
//          $httpHeader .= "Accept-Encoding: gzip, deflate \r\n";
            $httpHeader .= "Host: $host\r\n";
			$httpHeader .= "\r\n\r\n";

			$this->theData = $this->downloadData($host, $port, $httpHeader);
            $this->dataDecode();
		}
        function dataDecode(){
          $kk = strstr($this->theData,'Transfer-Encoding');
          if( empty($kk) ) return;
          else $encode_method = $this->getHeader('Transfer-Encoding');
          if($encode_method=='chunked'){
            $headers = $this->getHeaders();
            $content = $this->getContent();
            $temp = $content;
            $content = $this->unchunk($content);
            if(empty($content)) $content = $temp;

            $this->theData = $headers."\r\n\r\n".$content;
          }
          return;
        }
		function parseRequest($sURL){

			list($protocol, $sURL) = explode('://', $sURL); // separa o resto
			list($host, $foo)      = explode('/',   $sURL); // pega o host
			list($foo, $request)   = explode($host, $sURL); // pega o request
			@list($host, $port)     = explode(':',   $host); // pega a porta

			if ( strlen($request) == 0 ) $request = "/";
			if ( strlen($port) == 0 )    $port = "80";

			$SI2nfo = Array();
			$SI2nfo["host"]     = $host;
			$SI2nfo["port"]     = $port;
			$SI2nfo["protocol"] = $protocol;
			$SI2nfo["request"]  = $request;

			return $SI2nfo;
		}

                /* changed 06/30/2003 */
		function HTMLEncode($sHTML){
			$sHTML = urlencode($sHTML);
				return $sHTML;
		}

		function downloadData($host, $port, $httpHeader){
//			echo "$host,$port<br/>"; // FOR TEST ONLY
			$fp = @fsockopen($host, $port,$errno,$errstr,2);
			$retStr = "";
			if ( $fp ) {
				fwrite($fp, $httpHeader);
//				echo "write!";   // FOR TEST ONLY
				while(! feof($fp)) {
//					echo "read!";   // FOR TEST ONLY
					$retStr .= fread($fp, 2048);
			    }
			}
//			else
//				echo "open sock wrong!";   // FOR TEST ONLY
			return $retStr;
		}
        function unchunk($str){
          $return_str = '';
		  $loop_count = 0;

          $become_data_lenght = 0;
          $last_data_lenght = 0;
		  while(1){
            //得到到定位字符的所有字符串
            //得到第一个最尾的字符串
            $temp = strstr($str,"\r\n");
            //得到到第一个指定字符串前的字符串
            $now_data = substr($str,0,strlen($str) - strlen($temp) );
            $str = substr($str,strlen($now_data)+2,strlen($str));
            if(!empty($now_data)) $become_data_lenght = hexdec($now_data);
            if($last_data_lenght==strlen($now_data)) $return_str .= $now_data;
            $last_data_lenght = $become_data_lenght;

            if(empty($now_data)) $loop_count++;
            else $loop_count = 0;
            if($loop_count>15) break;
		  }
          return $return_str;
		}

	} // class

    /*
    $thisHttp = new cHTTP();
	$thisHttp->getPage("http://www.ytht.net");
	$content  = $thisHttp->getContent();
	if ( $content != "" )
		echo $content;
	else
		echo "test";
*/

?>
