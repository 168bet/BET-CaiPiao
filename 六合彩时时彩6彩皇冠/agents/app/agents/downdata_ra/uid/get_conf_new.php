<?
class get_conf extends clsTbsSql
{
	var $tempUID=""; //��ҳ��ʱUID
	var $user="";    //��¼�ʺ�
	var $password=""; //��¼����
	var $langx="zh-tw";
	var $liveid="";
	var $uid="";
	var $config=array(); //��ȡϵͳ����
	var $msg="";
	var $LeA="LeagueA2";
	var $LeB="LeagueB2";
	var $Team_h='H_Team2';
	var $Team_c='C_Team2';
	var $outTime=10;
	function get_conf($langx,$config)
	{
		$this->config=$config;
		$this->langx=$langx;
		$this->liveid=$this->config['liveid'];
		$this->getserver=$this->config['DownUrl'];
		switch ($this->langx)
		{
			case 'zh-cn':
				$this->uid=$this->config['DownUID_cn'];
				$this->user=$this->config['DownUser_cn'];
				$this->name=$this->config['DownName_cn'];
				$this->password=$this->config['DownPass_cn'];
				$this->LeA='LeagueA1';
				$this->LeB='LeagueB1';
				$this->Team='Team1';
				$this->Team_h='H_Team1';
				$this->Team_c='C_Team1';
				$this->game_list='game_list_lang1';
				break;
			case 'en-us':
				$this->uid=$this->config['DownUID_en'];
				$this->user=$this->config['DownUser_en'];
				$this->name=$this->config['DownName_en'];
				$this->password=$this->config['DownPass_en'];
				$this->LeA='LeagueA3';
				$this->LeB='LeagueB3';
				$this->Team='Team3';
				$this->Team_h='H_Team3';
				$this->Team_c='C_Team3';
				$this->game_list='game_list_lang3';
				break;
			default:
				//print_r($this->config['DownUID_tw']);
				$this->uid=$this->config['DownUID_tw'];
				$this->user=$this->config['DownUser_tw'];
				$this->name=$this->config['DownName_tw'];
				$this->password=$this->config['DownPass_tw'];
				$this->LeA='LeagueA2';
				$this->LeB='LeagueB2';
				$this->Team='Team2';
				$this->Team_h='H_Team2';
				$this->Team_c='C_Team2';
				$this->game_list='game_list_lang2';
				break;
		}
	}
	function get_login()
	{
		$curl = &new Curl_HTTP_Client();
		$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		/*
		$curl->set_referrer("http://".$this->getserver."/");
		$html_date=$curl->fetch_url("http://".$this->getserver."/app/member/","",$this->outTime);
		if(!$html_date)
		{
			echo $curl->error_msg;
			exit;
		}else {
			preg_match('/name="uid" value="(.*?)">/si',$html_date,$homeUID);
			$this->tempUID=$homeUID[1];
		}
		*/
		//print_r($homeUID);
		//if($this->tempUID)
		//{
			$login=array();
			$login['username']=$this->name;
			$login['passwd']=$this->password;
			$login['langx']=$this->langx;
			$login['uid']=$this->tempUID;
			$html_date=$curl->send_post_data("http://".$this->getserver."/app/member/login.php",$login,"",$this->outTime);
			//print htmlspecialchars($html_date);
				
			if(!$html_date)
			{
				echo $curl->error_msg;
				exit;
			}else {
				print htmlspecialchars($html_date);
				preg_match("/top.uid = '([^']+)/si",$html_date,$uid);
				preg_match("/top.liveid = '([^']+)/si",$html_date,$liveid);
				print_r($uid);
				if($uid[1])
				{
					$this->msg="�ɹ���ȡuid:".$uid[1];
					$this->uid=$uid[1];
					$this->liveid=$liveid[1];
					switch ($this->langx)
					{
						case 'zh-cn':
							$UPDATE="UPDATE `config` SET `v`='{$this->uid}' WHERE (`k`='DownUID_cn')";
							break;
						case 'en-us':
							$UPDATE="UPDATE `config` SET `v`='{$this->uid}' WHERE (`k`='DownUID_en')";
							break;
						default:
							$UPDATE="UPDATE `config` SET `v`='{$liveid[1]}' WHERE (`k`='liveid')";
							$this->Execute($UPDATE);
							$UPDATE="UPDATE `config` SET `v`='{$this->uid}' WHERE (`k`='DownUID_tw')";
							break;
					}
					$this->Execute($UPDATE);
				}else {
					preg_match('/alert\(\'(.*?)\'\)/',$html_date,$msg);
					$this->msg='Error:'.$msg[1];
				}
			}
		//}
		return $this->msg;
	}

}
?>