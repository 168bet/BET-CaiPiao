<?php
/**
 * Curl HTTP客户端 
 * 使用例子:
 * $curl = &new Curl_HTTP_Client();
 * $useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
 * $curl->set_user_agent($useragent);
 * $curl->store_cookies("/tmp/cookies.txt");
 * $post_data = array('login' => 'pera', 'password' => 'joe');
 * $html_data = $curl->send_post_data(http://www.foo.com/login.php, $post_data);
 */
class Curl_HTTP_Client
{
	var $ch ;
	var $debug = true;
	var $error_msg;
	var $error_no="";
	function Curl_HTTP_Client($debug = false)
	{
		$this->debug = $debug;
		$this->init();
	}
	function init()
	{
		//函数的作用初始化一个curl会话，curl_init()函数唯一的一个参数是可选的，表示一个url地址。
		$this->ch = curl_init();
		//set various options
		//set error in case http return code bigger than 300
		//显示HTTP状态码，默认行为是忽略编号小于等于400的HTTP信息
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
		// 允许重新定向
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		// 如果有gzip则解压
		curl_setopt($this->ch,CURLOPT_ENCODING , 'gzip, deflate');
		// do not veryfy ssl
		// this is important for windows
		// as well for being able to access pages with non valid cert
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
	}
	//HTTP认证
	function set_credentials($username,$password)
	{
		curl_setopt($this->ch, CURLOPT_USERPWD, "$username:$password");
	}
	//来源位置
	function set_referrer($referrer_url)
	{
		//设置header中"Referer: " 部分的值
		curl_setopt($this->ch, CURLOPT_REFERER, $referrer_url);
	}
	function set_user_agent($useragent)
	{
		//在HTTP请求中包含一个”user-agent”头的字符串
		curl_setopt($this->ch, CURLOPT_USERAGENT, $useragent);
	}
	function include_response_headers($value)
	{
		//启用时会将头文件的信息作为数据流输出
		curl_setopt($this->ch, CURLOPT_HEADER, $value);
	}
	function set_proxy($proxy)
	{
		//设置通过的HTTP代理服务器
		curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
	}
	function send_post_data($url, $postdata, $ip=null, $timeout=10)
	{
		//需要获取的URL地址
		curl_setopt($this->ch, CURLOPT_URL,$url);
		//在启用CURLOPT_RETURNTRANSFER时候将获取数据返回
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,true);
		//绑定固定IP
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			curl_setopt($this->ch,CURLOPT_INTERFACE,$ip);
		}
		//设置curl允许执行的最长秒数 $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
		//启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
		curl_setopt($this->ch, CURLOPT_POST, true);
		//generate post string
		$post_array = array();
		if(is_array($postdata))
		{
			foreach($postdata as $key=>$value)
			{
				//$post_array[] = urlencode($key) . "=" . urlencode($value);
				$post_array[] = $key . "=" . $value;
			}

			$post_string = implode("&",$post_array);

			if($this->debug)
			{
				echo "Url: $url\nPost String: $post_string\n";
			}
		}
		else
		{
			$post_string = $postdata;
		}

		//在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_string);


		//执行一个curl会话
		$result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return $result;
		}
	}
	function fetch_url($url, $ip=null, $timeout=20)
	{
		//需要获取的URL地址，也可以在PHP的curl_init()函数中设置
		curl_setopt($this->ch, CURLOPT_URL,$url);

		//启用时会设置HTTP的method为GET，因为GET是默认是，所以只在被修改的情况下使用s
		curl_setopt($this->ch, CURLOPT_HTTPGET,true);

		//在启用CURLOPT_RETURNTRANSFER时候将获取数据返回
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,true);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			//在外部网络接口中使用的名称，可以是一个接口名，IP或者主机名
			curl_setopt($this->ch,CURLOPT_INTERFACE,$ip);
		}

		//设置curl允许执行的最长秒数  $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//执行一个curl会话
		$result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Fetch data from target URL
	 * and store it directly to file	 	 
	 * @param string url	 
	 * @param resource value stream resource(ie. fopen)
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 5)
	 * @return boolean true on success false othervise
	 * @access public
	 */
	function fetch_into_file($url, $fp, $ip=null, $timeout=5)
	{
		//需要获取的URL地址
		curl_setopt($this->ch, CURLOPT_URL,$url);

		//启用时会设置HTTP的method为GET，因为GET是默认是，所以只在被修改的情况下使用
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);

		//设置输出文件的位置，值是一个资源类型，默认为STDOUT (浏览器)。
		curl_setopt($this->ch, CURLOPT_FILE, $fp);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			//在外部网络接口中使用的名称，可以是一个接口名，IP或者主机名。
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}

		//设置curl允许执行的最长秒数 $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//执行一个curl会话
		$result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error number: " .curl_errno($this->ch) ."\n";
				echo "Error message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Send multipart post data to the target URL	 
	 * return data returned from url or false if error occured
	 * (contribution by vule nikolic, vule@dinke.net)
	 * @param string url
	 * @param array assoc post data array ie. $foo['post_var_name'] = $value
	 * @param array assoc $file_field_array, contains file_field name = value - path pairs
	 * @param string ip address to bind (default null)
	 * @param int timeout in sec for complete curl operation (default 30 sec)
	 * @return string data
	 * @access public
	 */
	function send_multipart_post_data($url, $postdata, $file_field_array=array(), $ip=null, $timeout=30)
	{
		//需要获取的URL地址
		curl_setopt($this->ch, CURLOPT_URL, $url);

		// 在启用CURLOPT_RETURNTRANSFER时候将获取数据返回
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		//bind to specific ip address if it is sent trough arguments
		if($ip)
		{
			if($this->debug)
			{
				echo "Binding to ip $ip\n";
			}
			//在外部网络接口中使用的名称，可以是一个接口名，IP或者主机名
			curl_setopt($this->ch,CURLOPT_INTERFACE,$ip);
		}

		//设置curl允许执行的最长秒数 $timeout
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);

		//启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
		curl_setopt($this->ch, CURLOPT_POST, true);

		// disable Expect header
		// 设置一个header中传输内容的数组
		$headers = array("Expect: ");
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);

		// initialize result post array
		$result_post = array();

		//generate post string
		$post_array = array();
		$post_string_array = array();
		if(!is_array($postdata))
		{
			return false;
		}

		foreach($postdata as $key=>$value)
		{
			$post_array[$key] = $value;
			$post_string_array[] = urlencode($key)."=".urlencode($value);
		}

		$post_string = implode("&",$post_string_array);


		if($this->debug)
		{
			echo "Post String: $post_string\n";
		}

		// set post string
		//curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_string);


		// set multipart form data - file array field-value pairs
		if(!empty($file_field_array))
		{
			foreach($file_field_array as $var_name => $var_value)
			{
				if(strpos(PHP_OS, "WIN") !== false) $var_value = str_replace("/", "\\", $var_value); // win hack
				$file_field_array[$var_name] = "@".$var_value;
			}
		}

		// 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
		$result_post = array_merge($post_array, $file_field_array);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $result_post);


		//执行一个curl会话
		$result = curl_exec($this->ch);

		if(curl_errno($this->ch))
		{
			if($this->debug)
			{
				echo "Error Occured in Curl\n";
				echo "Error: " .curl_errno($this->ch) ."\n";
				echo "Message: " .curl_error($this->ch)."\n";
			}

			return false;
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Set file location where cookie data will be stored and send on each new request
	 * @param string absolute path to cookie file (must be in writable dir)
	 * @access public
	 */
	function store_cookies($cookie_file)
	{
		//连接关闭以后，存放cookie信息的文件名称 (cookies stored in $cookie_file)
		curl_setopt ($this->ch, CURLOPT_COOKIEJAR, $cookie_file);
		//包含cookie信息的文件名称，这个cookie文件可以是Netscape格式或者HTTP风格的header信息
		curl_setopt ($this->ch, CURLOPT_COOKIEFILE, $cookie_file);
	}

	/**
	 * Set custom cookie
	 * @param string cookie
	 * @access public
	 */
	function set_cookie($cookie)
	{
		//设定HTTP请求中“Set-Cookie:”部分的内容
		curl_setopt ($this->ch, CURLOPT_COOKIE, $cookie);
	}

	/**
	 * Get last URL info 
	 * usefull when original url was redirected to other location	
	 * @access public
	 * @return string url
	 */
	function get_effective_url()
	{
		//最后一个有效的url地址
		return curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
	}

	/**
	 * Get http response code	 
	 * @access public
	 * @return int
	 */
	function get_http_response_code()
	{
		//最后一个收到的HTTP代码
		return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
	}

	/**
	 * Return last error message and error number
	 * @return string error msg
	 * @access public
	 */
	function get_error_msg()
	{
		//$this->error_no=curl_errno($this->ch);
		echo "Error: " .curl_errno($this->ch) ."\n";
		echo "Message3: " .curl_error($this->ch)."\n";

		return $err;
	}
	//高亮HTML $line_number 显示行号
	function highlightHtml($code,$line_number=false)
	{
		//$code=$this->results;
		$code = htmlspecialchars($code);
		//$code = str_replace(" ","&nbsp;",$code); //替换空格替换为&nbsp;
		//$code = nl2br($code); //将回车替换为<br>
		//htm标签
		//$code  =  preg_replace_callback('/&lt;([a-zA-Z0-9]+)(.*?)(\/?&gt;)/',array('WebLoad','__pv'), $code);

		$code  =  preg_replace('/(&lt;[a-zA-Z0-9]+)/',  '<font color="#0000FF">$1</font>',  $code);
		$code  =  preg_replace('/(&lt;\/[a-zA-Z0-9]+&gt;)/',  '<font color="#0000FF">$1</font>',  $code);
		$code  =  preg_replace('/(\/&gt;)/',  '<font color="#0000FF">${1}</font>',  $code);
		//$code = preg_replace('/(&lt;\/?[a-zA-Z]+&nbsp;.*?&gt;)/','<font color="#0000FF">${1}</font>', $code);

		$code = preg_replace('/&lt;!DOCTYPE\s+.+?&gt;/','<font color="#3300FF">${0}</font>',$code);
		//注释
		$code  =  str_replace('&lt;!--',  '<font color="#666666"><em>&lt;!--',  $code);
		$code  =  str_replace('--&gt;',  '--&gt;</em></font>',  $code);

		//--------------以下是专为visualTpl模板文件而定制的高亮代码--------
		//block : begin|end
		$code  =  preg_replace('/(&lt;!--\s*)(begin|end)(\s+)([a-z_\x7f-\xfe]+)/i','${1}<font size="" color="#0000FF"><b>${2}</b></font>${3}<b><font color="#FF0000">${4}</font></b>',  $code);
		$code  =  preg_replace('/(\$[a-z0-9_]+)\s*=\s*(per|on)\(([0-9]+),(\'.*?\'),(\'.*?\')\)/i','<font color="#009900"><b>${1}</b></font>=<font color="#0000FF">${2}</font>(${3},<font color="#FF9999">${4}</font>,<font color="#FF9999">${5}</font>)',  $code);
		//vip	: vip|endvip
		$code  =  preg_replace('/<font color="#666666"><em>&lt;!--\s*vip/i',  '<span style="display:block;border:1px dashed #696969;padding 3px" >${0}',  $code);
		$code  =  preg_replace('/&lt;!--\s*endvip\s*--&gt;<\/em><\/font>/i',  '${0}</span>',  $code);
		//ssi   : #include
		$code  =  preg_replace('/&lt;!--\s*#include\s+file.+?--&gt;/i','<span style="background-color:#FFFF66; font-weight:bold; font-style:normal;padding:3px">${0}</span>',$code);
		//无格式变量
		$code = preg_replace('/(\{\$[a-zA-Z0-9_\x7f-\xfe]+\})/','<font style="background-color:#D7FED1;padding:1px" color="#009900">${1}</font>', $code);
		//格式变量
		$code = preg_replace('/(\{\$[a-zA-Z0-9_\x7f-\xfe]+;)([a-zA-Z]+)=\'([^\']+?)\'\}/','<font style="background-color:#D7FED1;padding:1px" color="#009900">${1}<font color="#CC0000">${2}</font>=<font color="#FF33CC">\'${3}\'</font>}</font>', $code);
		//--------------定制代码结束--------------

		//$code  =  preg_replace_callback('/>[^<]+?</',array('WebLoad','__htmlspace'), $code);
		//$code = nl2br($code);
		if(! $line_number){
			return '<PRE>'.$code.'</PRE>';
		}else{
			$code = '<pre><ol><li>' . str_replace("\n",'</li><li>',$code) . '</li></ol></pre>';
			return $code;
		}
	}
	function close()
	{
		//关闭一个curl会话
		curl_close($this->ch);
	}
}
?>