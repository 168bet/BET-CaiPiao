<?php
/* 
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-07 09:28:32
*/
if (!defined('Copyright') && Copyright != '作者QQ:503064228')
exit('作者QQ:503064228');
if (!defined('ROOT_PATH'))
exit('invalid request');

class UserReportInfok3
{
	private $User;
	private $cid;
	private $db;
	private $UserList;
	
	/**
	 * 讀取用戶注單類
	 * @param Model $User
	 * @param Int $cid
	 */
	public function __construct($User=null, $cid=0)
	{
		$this->User = $User;
		$this->cid = $cid;
		$this->db = new DB();
		$this->UserList=null;
	}
	
	/**
	 * 讀取用戶注單信息
	 * @param Int 期數
	 * @return Array
	 */
	private function UserInfo ($number)
	{
		if ($this->User[0]['g_login_id'] !=48 && Copyright){
			$sql = "SELECT * FROM g_zhudan WHERE g_s_nid LIKE '{$this->User[0]['g_nid']}%' 
			AND g_s_nid <> '{$this->User[0]['g_nid']}' 
			AND g_qishu = '{$number}' 
			AND g_type = '江苏骰寶(快3)' 
			AND g_win is null ";
		} else {
			$sql = "SELECT * FROM g_zhudan WHERE g_s_nid LIKE '{$this->User[0]['g_nid']}%' 
			AND g_mumber_type <> 5 
			AND g_qishu = '{$number}' 
			AND g_type = '江苏骰寶(快3)' 
			AND g_win is null ";
		}
		$result = $this->db->query($sql, 1);
		if ($result && Copyright)
		{
			//判斷當前用戶級別。對應注單的佔成以及退水計算實佔。
			
			//print_r($result);exit;
			$RepList = $this->SumReport($result, $this->User[0]['g_login_id']);
			
			switch ($this->cid)
			{
				case 1: $typeString = Array(0=>'三軍',1=>'圍骰',2=>'點數',3=>'長牌',4=>'短牌'); break;
			}
			
			$countList = $this->GroupCount($RepList, $typeString, $number);
			$countList = $this->GroupCounts($RepList, $typeString, $countList);
			
			return $countList;
		}
		else 
		{
			return NULL;
		}
	}
	
	/**
	 * 分組獲取總投注額
	 * @param Array $RepList
	 * @param String $typeString
	 */
	private function GroupCount ($RepList, $typeString, $number=null)
	{
		//print_r($RepList);exit;
		$arr = array('count'=>null, 'count_c'=>null, 'count_d'=>null, 'list'=>null, 'list_s'=>null, 'list_x'=>null);
		$sArr = array();
		$sql = "SELECT * FROM g_zhudan WHERE g_qishu='{$number}' 
		AND g_s_nid = '{$this->User[0]['g_nid']}' 
		AND g_mumber_type=5 
		AND g_type = '江苏骰寶(快3)' 
		AND g_win is null ";
		$UserList = $this->db->query($sql, 1);
		$this->UserList = $UserList;
		for ($s=0; $s<21;$s++) {$countList[$s]=$arr['count_c'][$s]=$arr['count_d'][$s]=0;}
		for ($i=0; $i<count($RepList); $i++)
		{
		
			$arr['count_c'][0] += $RepList[$i]['g_jiner'];
			if ($RepList[$i]['g_mingxi_1'] == '三軍' && Copyright){
				$arr['count_c'][1] += $RepList[$i]['g_jiner'];
				$arr['count_d'][0] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '圍骰' && Copyright){
				$arr['count_c'][2] += $RepList[$i]['g_jiner'];
				$arr['count_d'][1] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '點數' && Copyright){
				$arr['count_c'][3] += $RepList[$i]['g_jiner'];
				$arr['count_d'][2] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '長牌' && Copyright){
				$arr['count_c'][4] += $RepList[$i]['g_jiner'];
				$arr['count_d'][3] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '短牌' && Copyright){
				$arr['count_c'][5] += $RepList[$i]['g_jiner'];
				$arr['count_d'][4] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '第六名' && Copyright){
				$arr['count_c'][6] += $RepList[$i]['g_jiner'];
				$arr['count_d'][5] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '第七名' && Copyright){
				$arr['count_c'][7] += $RepList[$i]['g_jiner'];
				$arr['count_d'][6] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '第八名' && Copyright){
				$arr['count_c'][8] += $RepList[$i]['g_jiner'];
				$arr['count_d'][7] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '第九名' && Copyright){
				$arr['count_c'][9] += $RepList[$i]['g_jiner'];
				$arr['count_d'][8] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '第十名' && Copyright){
				$arr['count_c'][10] += $RepList[$i]['g_jiner'];
				$arr['count_d'][9] ++;
			} else if ($RepList[$i]['g_mingxi_1'] == '冠亞和' && Copyright){
				if ($RepList[$i]['g_mingxi_2'] == '冠亞和大' || $RepList[$i]['g_mingxi_2'] == '冠亞和小'){
					$arr['count_c'][12] += $RepList[$i]['g_jiner'];
					$arr['count_d'][11] ++;
				} else if ($RepList[$i]['g_mingxi_2'] == '冠亞和單' || $RepList[$i]['g_mingxi_2'] == '冠亞和雙'){
					$arr['count_c'][13] += $RepList[$i]['g_jiner'];
					$arr['count_d'][12] ++;
				} 
			} else if ($RepList[$i]['g_mingxi_1'] == '冠、亞軍和' && Copyright){
				$arr['count_c'][11] += $RepList[$i]['g_jiner'];
				$arr['count_d'][10] ++;
			} 
			if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] ||$RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3]|| $RepList[$i]['g_mingxi_1'] == $typeString[4] && Matchs::isNumber($RepList[$i]['g_mingxi_2'])) {
				//1-20組總投注額
				$countList[0] += $RepList[$i]['g_jiner'];
				$countList[8] += $RepList[$i]['g_tueishui'];
			} else if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] ||$RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3] && ($RepList[$i]['g_mingxi_2'] =='大' || $RepList[$i]['g_mingxi_2'] == '小')) {
				//大小組總投注額
				//$countList[1] += $RepList[$i]['g_jiner'];
				$countList[9] += $RepList[$i]['g_tueishui'];
			} else if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] ||$RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3] && ($RepList[$i]['g_mingxi_2'] =='全骰' || $RepList[$i]['g_mingxi_2'] == '全骰')) {
			
				//單雙組總投注額
				//$countList[2] += $RepList[$i]['g_jiner'];
				$countList[10] += $RepList[$i]['g_tueishui'];
			}else if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] ||$RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3] && ($RepList[$i]['g_mingxi_2'] =='龍' || $RepList[$i]['g_mingxi_2'] == '虎')) {
				//龍虎總投注額
				$countList[18] += $RepList[$i]['g_tueishui'];
			}  
			
			
			if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] ||$RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3]|| $RepList[$i]['g_mingxi_1'] == $typeString[4] && Copyright) 
			{
			switch($this->cid){
				case 1:$tempnum=0;break;
				case 2:$tempnum=2;break;
				case 3:$tempnum=6;break;
			}
			if($RepList[$i]['g_mingxi_1'] == $typeString[0]){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : $sArr['t'.(1+$tempnum).'_1'] += $RepList[$i]['g_jiner']; break;
					case '2' : $sArr['t'.(1+$tempnum).'_2'] += $RepList[$i]['g_jiner']; break;
					case '3' : $sArr['t'.(1+$tempnum).'_3'] += $RepList[$i]['g_jiner']; break;
					case '4' : $sArr['t'.(1+$tempnum).'_4'] += $RepList[$i]['g_jiner']; break;
					case '5' : $sArr['t'.(1+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					case '6' : $sArr['t'.(1+$tempnum).'_6'] += $RepList[$i]['g_jiner']; break;
					case '大' : $sArr['t'.(1+$tempnum).'_7'] += $RepList[$i]['g_jiner']; break;
					case '小' : $sArr['t'.(1+$tempnum).'_8'] += $RepList[$i]['g_jiner']; break;
					
				}
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[1]){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : $sArr['t'.(2+$tempnum).'_1'] += $RepList[$i]['g_jiner']; break;
					case '2' : $sArr['t'.(2+$tempnum).'_2'] += $RepList[$i]['g_jiner']; break;
					case '3' : $sArr['t'.(2+$tempnum).'_3'] += $RepList[$i]['g_jiner']; break;
					case '4' : $sArr['t'.(2+$tempnum).'_4'] += $RepList[$i]['g_jiner']; break;
					case '5' : $sArr['t'.(2+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					case '6' : $sArr['t'.(2+$tempnum).'_6'] += $RepList[$i]['g_jiner']; break;
					case '全骰' : $sArr['t'.(2+$tempnum).'_7'] += $RepList[$i]['g_jiner']; break;
					
				}
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[2]){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '4' : $sArr['t'.(3+$tempnum).'_1'] += $RepList[$i]['g_jiner']; break;
					case '5' : $sArr['t'.(3+$tempnum).'_2'] += $RepList[$i]['g_jiner']; break;
					case '6' : $sArr['t'.(3+$tempnum).'_3'] += $RepList[$i]['g_jiner']; break;
					case '7' : $sArr['t'.(3+$tempnum).'_4'] += $RepList[$i]['g_jiner']; break;
					case '8' : $sArr['t'.(3+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					case '9' : $sArr['t'.(3+$tempnum).'_6'] += $RepList[$i]['g_jiner']; break;
					case '10' : $sArr['t'.(3+$tempnum).'_7'] += $RepList[$i]['g_jiner']; break;
					case '11' : $sArr['t'.(3+$tempnum).'_8'] += $RepList[$i]['g_jiner']; break;
					case '12' : $sArr['t'.(3+$tempnum).'_9'] += $RepList[$i]['g_jiner']; break;
					case '13' : $sArr['t'.(3+$tempnum).'_10'] += $RepList[$i]['g_jiner']; break;
					
					case '14' : $sArr['t'.(3+$tempnum).'_11'] += $RepList[$i]['g_jiner']; break;
					case '15' : $sArr['t'.(3+$tempnum).'_12'] += $RepList[$i]['g_jiner']; break;
					case '16' : $sArr['t'.(3+$tempnum).'_13'] += $RepList[$i]['g_jiner']; break;
					case '17' : $sArr['t'.(3+$tempnum).'_14'] += $RepList[$i]['g_jiner']; break;

				}
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[3]){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1,2' : $sArr['t'.(4+$tempnum).'_1'] += $RepList[$i]['g_jiner']; break;
					case '1,3' : $sArr['t'.(4+$tempnum).'_2'] += $RepList[$i]['g_jiner']; break;
					case '1,4' : $sArr['t'.(4+$tempnum).'_3'] += $RepList[$i]['g_jiner']; break;
					case '1,5' : $sArr['t'.(4+$tempnum).'_4'] += $RepList[$i]['g_jiner']; break;
					case '1,6' : $sArr['t'.(4+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					case '2,3' : $sArr['t'.(4+$tempnum).'_6'] += $RepList[$i]['g_jiner']; break;
					case '2,4' : $sArr['t'.(4+$tempnum).'_7'] += $RepList[$i]['g_jiner']; break;
					case '2,5' : $sArr['t'.(4+$tempnum).'_8'] += $RepList[$i]['g_jiner']; break;
					case '2,6' : $sArr['t'.(4+$tempnum).'_9'] += $RepList[$i]['g_jiner']; break;
					case '3,4' : $sArr['t'.(4+$tempnum).'_10'] += $RepList[$i]['g_jiner']; break;
					
					case '3,5' : $sArr['t'.(4+$tempnum).'_11'] += $RepList[$i]['g_jiner']; break;
					case '3,6' : $sArr['t'.(4+$tempnum).'_12'] += $RepList[$i]['g_jiner']; break;
					case '4,5' : $sArr['t'.(4+$tempnum).'_13'] += $RepList[$i]['g_jiner']; break;
					case '4,6' : $sArr['t'.(4+$tempnum).'_14'] += $RepList[$i]['g_jiner']; break;
					
					case '5,6' : $sArr['t'.(4+$tempnum).'_15'] += $RepList[$i]['g_jiner']; break;
				
				}
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[4]){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : $sArr['t'.(5+$tempnum).'_1'] += $RepList[$i]['g_jiner']; break;
					case '2' : $sArr['t'.(5+$tempnum).'_2'] += $RepList[$i]['g_jiner']; break;
					case '3' : $sArr['t'.(5+$tempnum).'_3'] += $RepList[$i]['g_jiner']; break;
					case '4' : $sArr['t'.(5+$tempnum).'_4'] += $RepList[$i]['g_jiner']; break;
					case '5' : $sArr['t'.(5+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					case '6' : $sArr['t'.(5+$tempnum).'_5'] += $RepList[$i]['g_jiner']; break;
					
				
				}
				}
			}
			if( $this->cid==1){
			if ($RepList[$i]['g_mingxi_1'] == "冠、亞軍和" && Copyright ) 
			{
				//$countList[0] += $RepList[$i]['g_jiner'];
				switch ($RepList[$i]['g_mingxi_2']) {
					case '3' : $sArr['t11_1'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '4' : $sArr['t11_2'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '5' : $sArr['t11_3'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '6' : $sArr['t11_4'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '7' : $sArr['t11_5'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '8' : $sArr['t11_6'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '9' : $sArr['t11_7'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '10' : $sArr['t11_8'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '11' : $sArr['t11_9'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '12' : $sArr['t11_10'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '13' : $sArr['t11_11'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '14' : $sArr['t11_12'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '15' : $sArr['t11_13'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '16' : $sArr['t11_14'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '17' : $sArr['t11_15'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '18' : $sArr['t11_16'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '19' : $sArr['t11_17'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					
				}
			}
			else  if($RepList[$i]['g_mingxi_1'] == "冠亞和" && Copyright ) 
			{
				switch ($RepList[$i]['g_mingxi_2']) {
					case '冠亞和大' : $sArr['t12_1'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '冠亞和小' : $sArr['t12_2'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '冠亞和單' : $sArr['t12_3'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
					case '冠亞和雙' : $sArr['t12_4'] += $RepList[$i]['g_jiner'];$countList[0] += $RepList[$i]['g_jiner']; break;
				
				}
			}
			}
		}
		$arr['count'] = $countList;
		$arr['list']=$sArr;
		//print_r($RepList);exit;
		if ($UserList)
			$arr = $this->GetUserCrystals($UserList, $sArr, $arr, $typeString);
		return $arr;
	}
	
	private function GetUserCrystals($UserList, $sArr, $arr, $typeString)
	{
		$n=0; $h=1;
		for ($i=0; $i<count($UserList); $i++){
			$n =$UserList[$i]['g_jiner'];
			$h = $UserList[$i]['g_mingxi_1_str'];
			$arr['count_c'][0] = $arr['count_c'][0] - $n;
			if ($UserList[$i]['g_mingxi_1'] == '三軍'){
				$arr['count_c'][1] = $arr['count_c'][1]-$n;
				//$arr['count_d'][0] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '圍骰'){
				$arr['count_c'][2] = $arr['count_c'][2]-$n;
				//$arr['count_d'][1] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '點數'){
				$arr['count_c'][3] = $arr['count_c'][3]-$n;
				//$arr['count_d'][2] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '長牌'){
				$arr['count_c'][4] = $arr['count_c'][4]-$n;
				//$arr['count_d'][3] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '短牌'){
				$arr['count_c'][5] = $arr['count_c'][5]-$n;
				//$arr['count_d'][4] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '第六名'){
				$arr['count_c'][6]  = $arr['count_c'][6]-$n;
				//$arr['count_d'][5] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '第七名'){
				$arr['count_c'][7] = $arr['count_c'][7]-$n;
				//$arr['count_d'][6] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '第八名'){
				$arr['count_c'][8] = $arr['count_c'][8]-$n;
				//$arr['count_d'][7] ++;
			} else  if ($UserList[$i]['g_mingxi_1'] == '第九名'){
				$arr['count_c'][9] = $arr['count_c'][8]-$n;
				//$arr['count_d'][7] ++;
			} else  if ($UserList[$i]['g_mingxi_1'] == '第十名'){
				$arr['count_c'][10] = $arr['count_c'][8]-$n;
				//$arr['count_d'][7] ++;
			} else if ($UserList[$i]['g_mingxi_1'] == '冠亞和'){
				if ($UserList[$i]['g_mingxi_2'] == '冠亞和大' || $UserList[$i]['g_mingxi_2'] == '冠亞和小'){
					$arr['count_c'][12] = $arr['count_c'][9]-$n;
					//$arr['count_d'][8] ++;
				} else if ($UserList[$i]['g_mingxi_2'] == '冠亞和單' || $UserList[$i]['g_mingxi_2'] == '冠亞和雙'){
					$arr['count_c'][13] = $arr['count_c'][10]-$n;
					//$arr['count_d'][9] ++;
				} 
			} else if ($UserList[$i]['g_mingxi_1'] == '冠、亞軍和' && Copyright){
				$arr['count_c'][11] = $arr['count_c'][13]-$n*$h;
				//$arr['count_d'][12] ++;
			}
			
			if ($UserList[$i]['g_mingxi_1'] == $typeString[0] || $UserList[$i]['g_mingxi_1'] || $UserList[$i]['g_mingxi_1'] == $typeString[2] || $UserList[$i]['g_mingxi_1'] == $typeString[3]|| $UserList[$i]['g_mingxi_1'] == $typeString[4] && Copyright) 
			{
			switch($this->cid){
				case 1:$tempnum=0;break;
				case 2:$tempnum=2;break;
				case 3:$tempnum=6;break;
			}
			if ($UserList[$i]['g_mingxi_1'] == $typeString[0]){
				switch ($UserList[$i]['g_mingxi_2']) {
					case '1' : 
						$arr['list']['t'.(1+$tempnum).'_1']=$arr['list']['t'.(1+$tempnum).'_1'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2' : 
						$arr['list']['t'.(1+$tempnum).'_2']=$arr['list']['t'.(1+$tempnum).'_2'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '3' : 
						$arr['list']['t'.(1+$tempnum).'_3']=$arr['list']['t'.(1+$tempnum).'_3'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '4' : 
						$arr['list']['t'.(1+$tempnum).'_4']=$arr['list']['t'.(1+$tempnum).'_4'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '5' :  
						$arr['list']['t'.(1+$tempnum).'_5']=$arr['list']['t'.(1+$tempnum).'_5'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '6' :  
						$arr['list']['t'.(1+$tempnum).'_6']=$arr['list']['t'.(1+$tempnum).'_6'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '大' :  
						$arr['list']['t'.(1+$tempnum).'_7']=$arr['list']['t'.(1+$tempnum).'_7'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '小' :  
						$arr['list']['t'.(1+$tempnum).'_8']=$arr['list']['t'.(1+$tempnum).'_8'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					
				}}
				else if ($UserList[$i]['g_mingxi_1'] == $typeString[1]){
				switch ($UserList[$i]['g_mingxi_2']) {
					case '1' : 
						$arr['list']['t'.(2+$tempnum).'_1']=$arr['list']['t'.(2+$tempnum).'_1'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2' : 
						$arr['list']['t'.(2+$tempnum).'_2']=$arr['list']['t'.(2+$tempnum).'_2'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '3' : 
						$arr['list']['t'.(2+$tempnum).'_3']=$arr['list']['t'.(2+$tempnum).'_3'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '4' : 
						$arr['list']['t'.(2+$tempnum).'_4']=$arr['list']['t'.(2+$tempnum).'_4'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '5' :  
						$arr['list']['t'.(2+$tempnum).'_5']=$arr['list']['t'.(2+$tempnum).'_5'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '6' :  
						$arr['list']['t'.(2+$tempnum).'_6']=$arr['list']['t'.(2+$tempnum).'_6'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '全骰' :  
						$arr['list']['t'.(2+$tempnum).'_7']=$arr['list']['t'.(2+$tempnum).'_7'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					
				}}else if ($UserList[$i]['g_mingxi_1'] == $typeString[2]){
				switch ($UserList[$i]['g_mingxi_2']) {
					case '4' : 
						$arr['list']['t'.(3+$tempnum).'_1']=$arr['list']['t'.(3+$tempnum).'_1'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '5' : 
						$arr['list']['t'.(3+$tempnum).'_2']=$arr['list']['t'.(3+$tempnum).'_2'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '6' : 
						$arr['list']['t'.(3+$tempnum).'_3']=$arr['list']['t'.(3+$tempnum).'_3'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '7' : 
						$arr['list']['t'.(3+$tempnum).'_4']=$arr['list']['t'.(3+$tempnum).'_4'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '8' :  
						$arr['list']['t'.(3+$tempnum).'_5']=$arr['list']['t'.(3+$tempnum).'_5'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '9' :  
						$arr['list']['t'.(3+$tempnum).'_6']=$arr['list']['t'.(3+$tempnum).'_6'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '10' :  
						$arr['list']['t'.(3+$tempnum).'_7']=$arr['list']['t'.(3+$tempnum).'_7'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '11' :  
						$arr['list']['t'.(3+$tempnum).'_8']=$arr['list']['t'.(3+$tempnum).'_8'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '12' :  
						$arr['list']['t'.(3+$tempnum).'_9']=$arr['list']['t'.(3+$tempnum).'_9'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '13' :  
						$arr['list']['t'.(3+$tempnum).'_10']=$arr['list']['t'.(3+$tempnum).'_10'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					
					case '14' :  
						$arr['list']['t'.(3+$tempnum).'_11']=$arr['list']['t'.(3+$tempnum).'_11'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '15' :  
						$arr['list']['t'.(3+$tempnum).'_12']=$arr['list']['t'.(3+$tempnum).'_12'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '16' :  
						$arr['list']['t'.(3+$tempnum).'_13']=$arr['list']['t'.(3+$tempnum).'_13'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '17' :  
						$arr['list']['t'.(3+$tempnum).'_14']=$arr['list']['t'.(3+$tempnum).'_14'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
				}}else if ($UserList[$i]['g_mingxi_1'] == $typeString[3]){
				switch ($UserList[$i]['g_mingxi_2']) {
					case '1,2' : 
						$arr['list']['t'.(4+$tempnum).'_1']=$arr['list']['t'.(4+$tempnum).'_1'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '1,3' : 
						$arr['list']['t'.(4+$tempnum).'_2']=$arr['list']['t'.(4+$tempnum).'_2'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '1,4' : 
						$arr['list']['t'.(4+$tempnum).'_3']=$arr['list']['t'.(4+$tempnum).'_3'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '1,5' : 
						$arr['list']['t'.(4+$tempnum).'_4']=$arr['list']['t'.(4+$tempnum).'_4'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '1,6' :  
						$arr['list']['t'.(4+$tempnum).'_5']=$arr['list']['t'.(4+$tempnum).'_5'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2,3' :  
						$arr['list']['t'.(4+$tempnum).'_6']=$arr['list']['t'.(4+$tempnum).'_6'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2,4' :  
						$arr['list']['t'.(4+$tempnum).'_7']=$arr['list']['t'.(4+$tempnum).'_7'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2,5' :  
						$arr['list']['t'.(4+$tempnum).'_8']=$arr['list']['t'.(4+$tempnum).'_8'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '2,6' :  
						$arr['list']['t'.(4+$tempnum).'_9']=$arr['list']['t'.(4+$tempnum).'_9'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '3,4' :  
						$arr['list']['t'.(4+$tempnum).'_10']=$arr['list']['t'.(4+$tempnum).'_10'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					
					case '3,5' :  
						$arr['list']['t'.(4+$tempnum).'_11']=$arr['list']['t'.(4+$tempnum).'_11'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '3,6' :  
						$arr['list']['t'.(4+$tempnum).'_12']=$arr['list']['t'.(4+$tempnum).'_12'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '4,5' :  
						$arr['list']['t'.(4+$tempnum).'_13']=$arr['list']['t'.(4+$tempnum).'_13'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '4,6' :  
						$arr['list']['t'.(4+$tempnum).'_14']=$arr['list']['t'.(4+$tempnum).'_14'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '5,6' :  
						$arr['list']['t'.(4+$tempnum).'_15']=$arr['list']['t'.(4+$tempnum).'_15'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
				}
				
				}else{
					switch ($UserList[$i]['g_mingxi_2']) {
						case '1' : 
							$arr['list']['t'.(5+$tempnum).'_1']=$arr['list']['t'.(5+$tempnum).'_1'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						case '2' : 
							$arr['list']['t'.(5+$tempnum).'_2']=$arr['list']['t'.(5+$tempnum).'_2'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						case '3' : 
							$arr['list']['t'.(5+$tempnum).'_3']=$arr['list']['t'.(5+$tempnum).'_3'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						case '4' : 
							$arr['list']['t'.(5+$tempnum).'_4']=$arr['list']['t'.(5+$tempnum).'_4'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						case '5' :  
							$arr['list']['t'.(5+$tempnum).'_5']=$arr['list']['t'.(5+$tempnum).'_5'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						case '6' :  
							$arr['list']['t'.(5+$tempnum).'_6']=$arr['list']['t'.(5+$tempnum).'_6'] - $n;
							$arr['count'][0] =$arr['count'][0]- $n;
							break;
						}
				
				}
			}
			if( $this->cid==1){
			if ($UserList[$i]['g_mingxi_1'] == "冠、亞軍和" && Copyright) 
			{
				switch ($UserList[$i]['g_mingxi_2']) {
					case '3' : 
						$arr['list']['t11_1']=$arr['list']['t11_1'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '4' : 
						$arr['list']['t11_2']=$arr['list']['t11_2'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '5' :  
						$arr['list']['t11_3']=$arr['list']['t11_3'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '6' :  
						$arr['list']['t11_4']=$arr['list']['t11_4'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '7' :  
						$arr['list']['t11_5']=$arr['list']['t11_5'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '8' :  
						$arr['list']['t11_6']=$arr['list']['t11_6'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '9' :  
						$arr['list']['t11_7']=$arr['list']['t11_7'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '10' :  
						$arr['list']['t11_8']=$arr['list']['t11_8'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '11' :   
						$arr['list']['t11_9']=$arr['list']['t11_9'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '12' :   
						$arr['list']['t11_10']=$arr['list']['t11_10'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '13' :   
						$arr['list']['t11_11']=$arr['list']['t11_11'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '14' :   
						$arr['list']['t11_12']=$arr['list']['t11_12'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '15' :   
						$arr['list']['t11_13']=$arr['list']['t11_13'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '16' :   
						$arr['list']['t11_14']=$arr['list']['t11_14'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '17' :   
						$arr['list']['t11_15']=$arr['list']['t11_15'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '18' :   
						$arr['list']['t11_16']=$arr['list']['t11_16'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					case '19' :   
						$arr['list']['t11_17']=$arr['list']['t11_17'] - $n;
						$arr['count'][0] =$arr['count'][0]- $n;
						break;
					
				}
			}
			
			else  if($UserList[$i]['g_mingxi_1']  == "冠亞和" && Copyright ) 
			{
				switch ($UserList[$i]['g_mingxi_2']) {
					case '冠亞和大' : $arr['list']['t12_1']=$arr['list']['t12_1'] - $n; break;
					case '冠亞和小' : $arr['list']['t12_2'] =$arr['list']['t12_2']- $n; break;
					case '冠亞和單' : $arr['list']['t12_3']=$arr['list']['t12_3'] - $n; break;
					case '冠亞和雙' : $arr['list']['t12_4']=$arr['list']['t12_4'] - $n; break;
				
				}
			}
			}
		}
		return $arr;
	}

	private function GroupCounts ($RepList, $typeString, $list)
	{		
		$lo =array(0=>null,1=>null);
		for ($i=0; $i<count($RepList); $i++)
		{
			if ($RepList[$i]['g_mingxi_1'] == $typeString[0] || $RepList[$i]['g_mingxi_1'] == $typeString[1] || $RepList[$i]['g_mingxi_1'] == $typeString[2] || $RepList[$i]['g_mingxi_1'] == $typeString[3]|| $RepList[$i]['g_mingxi_1'] == $typeString[4]  && Copyright)
			{	
			switch($this->cid){
				case 1:$tempnum=0;break;
				case 2:$tempnum=2;break;
				case 3:$tempnum=6;break;
			}
			
			if($RepList[$i]['g_mingxi_1'] == $typeString[0] ){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : 
						if ($list['list']['t'.(1+$tempnum).'_1'] >0)
							$list['list_s']['t'.(1+$tempnum).'_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_1'] = $list['count'][8];
						break;
					case '2' : 
						if ($list['list']['t'.(1+$tempnum).'_2'] >0)
							$list['list_s']['t'.(1+$tempnum).'_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_2'] = $list['count'][8];
						break;
					case '3' : 
						if ($list['list']['t'.(1+$tempnum).'_3'] >0)
							$list['list_s']['t'.(1+$tempnum).'_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_3'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t'.(1+$tempnum).'_3'] = $list['count'][8];
						break;
					case '4' : 
						if ($list['list']['t'.(1+$tempnum).'_4'] >0)
							$list['list_s']['t'.(1+$tempnum).'_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_4'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t'.(1+$tempnum).'_4'] = $list['count'][8];
						break;
					case '5' : 
						if ($list['list']['t'.(1+$tempnum).'_5'] >0)
							$list['list_s']['t'.(1+$tempnum).'_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_5'] = $list['count'][8];
						break;
					case '6' : 
						if ($list['list']['t'.(1+$tempnum).'_6'] >0)
							$list['list_s']['t'.(1+$tempnum).'_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_6'] = $list['count'][8];
						break;
					case '大' : 
						if ($list['list']['t'.(1+$tempnum).'_7'] >0)
							$list['list_s']['t'.(1+$tempnum).'_7'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_7'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_7'] = $list['count'][8];
						break;
					case '小' : 
						if ($list['list']['t'.(1+$tempnum).'_8'] >0)
							$list['list_s']['t'.(1+$tempnum).'_8'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(1+$tempnum).'_8'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(1+$tempnum).'_8'] = $list['count'][8];
						break;
					
				} 
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[1] ){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : 
						if ($list['list']['t'.(2+$tempnum).'_1'] >0)
							$list['list_s']['t'.(2+$tempnum).'_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(2+$tempnum).'_1'] = $list['count'][8];
						break;
					case '2' : 
						if ($list['list']['t'.(2+$tempnum).'_2'] >0)
							$list['list_s']['t'.(2+$tempnum).'_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(2+$tempnum).'_2'] = $list['count'][8];
						break;
					case '3' : 
						if ($list['list']['t'.(2+$tempnum).'_3'] >0)
							$list['list_s']['t'.(2+$tempnum).'_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_3'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t'.(2+$tempnum).'_3'] = $list['count'][8];
						break;
					case '4' : 
						if ($list['list']['t'.(2+$tempnum).'_4'] >0)
							$list['list_s']['t'.(2+$tempnum).'_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_4'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t'.(2+$tempnum).'_4'] = $list['count'][8];
						break;
					case '5' : 
						if ($list['list']['t'.(2+$tempnum).'_5'] >0)
							$list['list_s']['t'.(2+$tempnum).'_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(2+$tempnum).'_5'] = $list['count'][8];
						break;
					case '6' : 
						if ($list['list']['t'.(2+$tempnum).'_6'] >0)
							$list['list_s']['t'.(2+$tempnum).'_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(2+$tempnum).'_6'] = $list['count'][8];
						break;
					case '全骰' : 
						if ($list['list']['t'.(2+$tempnum).'_7'] >0)
							$list['list_s']['t'.(2+$tempnum).'_7'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(2+$tempnum).'_7'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(2+$tempnum).'_7'] = $list['count'][8];
						break;
					
				} 
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[2] ){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '4' : 
						if ($list['list']['t'.(3+$tempnum).'_1'] >0)
							$list['list_s']['t'.(3+$tempnum).'_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_1'] = $list['count'][8];
						break;
					case '5' : 
						if ($list['list']['t'.(3+$tempnum).'_2'] >0)
							$list['list_s']['t'.(3+$tempnum).'_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_2'] = $list['count'][8];
						break;
					case '6' : 
						if ($list['list']['t'.(3+$tempnum).'_3'] >0)
							$list['list_s']['t'.(3+$tempnum).'_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_3'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t'.(3+$tempnum).'_3'] = $list['count'][8];
						break;
					case '7' : 
						if ($list['list']['t'.(3+$tempnum).'_4'] >0)
							$list['list_s']['t'.(3+$tempnum).'_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_4'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t'.(3+$tempnum).'_4'] = $list['count'][8];
						break;
					case '8' : 
						if ($list['list']['t'.(3+$tempnum).'_5'] >0)
							$list['list_s']['t'.(3+$tempnum).'_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_5'] = $list['count'][8];
						break;
					case '9' : 
						if ($list['list']['t'.(3+$tempnum).'_6'] >0)
							$list['list_s']['t'.(3+$tempnum).'_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_6'] = $list['count'][8];
						break;
					case '10' : 
						if ($list['list']['t'.(3+$tempnum).'_7'] >0)
							$list['list_s']['t'.(3+$tempnum).'_7'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_7'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_7'] = $list['count'][8];
						break;
					case '11' : 
						if ($list['list']['t'.(3+$tempnum).'_8'] >0)
							$list['list_s']['t'.(3+$tempnum).'_8'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_8'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_8'] = $list['count'][8];
						break;
					case '12' : 
						if ($list['list']['t'.(3+$tempnum).'_9'] >0)
							$list['list_s']['t'.(3+$tempnum).'_9'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_9'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_9'] = $list['count'][8];
						break;
					case '13' : 
						if ($list['list']['t'.(3+$tempnum).'_10'] >0)
							$list['list_s']['t'.(3+$tempnum).'_10'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(3+$tempnum).'_10'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_10'] = $list['count'][8];
							break;
					
					case '14' : 
						if ($list['list']['t'.(3+$tempnum).'_11'] >0)
							$list['list_s']['t'.(3+$tempnum).'_11'] = $list['list']['t'.(3+$tempnum).'_11'] + $list['count'][9] - $list['list']['t'.(3+$tempnum).'_11'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_11'] = $list['count'][9];
						break;
					case '15' : 
						if ($list['list']['t'.(3+$tempnum).'_12'] >0)
							$list['list_s']['t'.(3+$tempnum).'_12'] = $list['list']['t'.(3+$tempnum).'_12'] + $list['count'][9] - $list['list']['t'.(3+$tempnum).'_12'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_12'] = $list['count'][9];
						break;
					case '16' : 
						if ($list['list']['t'.(3+$tempnum).'_13'] >0){
							$list['list_s']['t'.(3+$tempnum).'_13'] = $list['list']['t'.(3+$tempnum).'_13'] + $list['count'][10] - $list['list']['t'.(3+$tempnum).'_13'] * $RepList[$i]['g_odds']; 
						}
						else 
							$list['list_s']['t'.(3+$tempnum).'_13'] = $list['count'][10];
						break;
					case '17' : 
						if ($list['list']['t'.(3+$tempnum).'_14'] >0)
							$list['list_s']['t'.(3+$tempnum).'_14'] = $list['list']['t'.(3+$tempnum).'_14'] + $list['count'][10] - $list['list']['t'.(3+$tempnum).'_14'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(3+$tempnum).'_14'] = $list['count'][10];
						break;
					
					
				} 
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[3] ){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1,2' : 
						if ($list['list']['t'.(4+$tempnum).'_1'] >0)
							$list['list_s']['t'.(4+$tempnum).'_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_1'] = $list['count'][8];
						break;
					case '1,3' : 
						if ($list['list']['t'.(4+$tempnum).'_2'] >0)
							$list['list_s']['t'.(4+$tempnum).'_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_2'] = $list['count'][8];
						break;
					case '1,4' : 
						if ($list['list']['t'.(4+$tempnum).'_3'] >0)
							$list['list_s']['t'.(4+$tempnum).'_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_3'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t'.(4+$tempnum).'_3'] = $list['count'][8];
						break;
					case '1,5' : 
						if ($list['list']['t'.(4+$tempnum).'_4'] >0)
							$list['list_s']['t'.(4+$tempnum).'_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_4'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t'.(4+$tempnum).'_4'] = $list['count'][8];
						break;
					case '1,6' : 
						if ($list['list']['t'.(4+$tempnum).'_5'] >0)
							$list['list_s']['t'.(4+$tempnum).'_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_5'] = $list['count'][8];
						break;
					case '2,3' : 
						if ($list['list']['t'.(4+$tempnum).'_6'] >0)
							$list['list_s']['t'.(4+$tempnum).'_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_6'] = $list['count'][8];
						break;
					case '2,4' : 
						if ($list['list']['t'.(4+$tempnum).'_7'] >0)
							$list['list_s']['t'.(4+$tempnum).'_7'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_7'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_7'] = $list['count'][8];
						break;
					case '2,5' : 
						if ($list['list']['t'.(4+$tempnum).'_8'] >0)
							$list['list_s']['t'.(4+$tempnum).'_8'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_8'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_8'] = $list['count'][8];
						break;
					case '2,6' : 
						if ($list['list']['t'.(4+$tempnum).'_9'] >0)
							$list['list_s']['t'.(4+$tempnum).'_9'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_9'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_9'] = $list['count'][8];
						break;
					case '3,4' : 
						if ($list['list']['t'.(4+$tempnum).'_10'] >0)
							$list['list_s']['t'.(4+$tempnum).'_10'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_10'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_10'] = $list['count'][8];
							break;
					
					case '3,5' : 
						if ($list['list']['t'.(4+$tempnum).'_11'] >0)
							$list['list_s']['t'.(4+$tempnum).'_11'] = $list['list']['t'.(4+$tempnum).'_11'] + $list['count'][9] - $list['list']['t'.(4+$tempnum).'_11'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_11'] = $list['count'][9];
						break;
					case '3,6' : 
						if ($list['list']['t'.(4+$tempnum).'_12'] >0)
							$list['list_s']['t'.(4+$tempnum).'_12'] = $list['list']['t'.(4+$tempnum).'_12'] + $list['count'][9] - $list['list']['t'.(4+$tempnum).'_12'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_12'] = $list['count'][9];
						break;
					case '4,5' : 
						if ($list['list']['t'.(4+$tempnum).'_13'] >0){
							$list['list_s']['t'.(4+$tempnum).'_13'] = $list['list']['t'.(4+$tempnum).'_13'] + $list['count'][10] - $list['list']['t'.(4+$tempnum).'_13'] * $RepList[$i]['g_odds']; 
						}
						else 
							$list['list_s']['t'.(4+$tempnum).'_13'] = $list['count'][10];
						break;
					case '4,6' : 
						if ($list['list']['t'.(4+$tempnum).'_14'] >0)
							$list['list_s']['t'.(4+$tempnum).'_14'] = $list['list']['t'.(4+$tempnum).'_14'] + $list['count'][10] - $list['list']['t'.(4+$tempnum).'_14'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(4+$tempnum).'_14'] = $list['count'][10];
						break;
					
					case '5,6' : 
						if ($list['list']['t'.(4+$tempnum).'_15'] >0)
							$list['list_s']['t'.(4+$tempnum).'_15'] = $list['list']['t'.(4+$tempnum).'_15'] + $list['count'][18] - $list['list']['t'.(4+$tempnum).'_15'] * $RepList[$i]['g_odds'];
						else 
							$list['list_s']['t'.(4+$tempnum).'_15'] = $list['count'][18];
						 break;
					
					
				} 
				}else if($RepList[$i]['g_mingxi_1'] == $typeString[4] ){
				switch ($RepList[$i]['g_mingxi_2']) {
					case '1' : 
						if ($list['list']['t'.(5+$tempnum).'_1'] >0)
							$list['list_s']['t'.(5+$tempnum).'_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(5+$tempnum).'_1'] = $list['count'][8];
						break;
					case '2' : 
						if ($list['list']['t'.(5+$tempnum).'_2'] >0)
							$list['list_s']['t'.(5+$tempnum).'_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(5+$tempnum).'_2'] = $list['count'][8];
						break;
					case '3' : 
						if ($list['list']['t'.(5+$tempnum).'_3'] >0)
							$list['list_s']['t'.(5+$tempnum).'_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_3'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t'.(5+$tempnum).'_3'] = $list['count'][8];
						break;
					case '4' : 
						if ($list['list']['t'.(5+$tempnum).'_4'] >0)
							$list['list_s']['t'.(5+$tempnum).'_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_4'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t'.(5+$tempnum).'_4'] = $list['count'][8];
						break;
					case '5' : 
						if ($list['list']['t'.(5+$tempnum).'_5'] >0)
							$list['list_s']['t'.(5+$tempnum).'_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(5+$tempnum).'_5'] = $list['count'][8];
						break;
					case '6' : 
						if ($list['list']['t'.(5+$tempnum).'_6'] >0)
							$list['list_s']['t'.(5+$tempnum).'_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t'.(4+$tempnum).'_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t'.(5+$tempnum).'_6'] = $list['count'][8];
						break;
					
					
					
				} 
				}
				//print_r($list['list_s'] );exit;
			}
			if($this->cid==1){
			if ($RepList[$i]['g_mingxi_1'] == "冠、亞軍和" && Copyright)
			{
				switch ($RepList[$i]['g_mingxi_2']) {
					
					case '3' : 
						if ($list['list']['t11_1'] >0)
							$list['list_s']['t11_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_1'] * $RepList[$i]['g_odds'];
						 else 
							$list['list_s']['t11_1'] = $list['count'][8];
						break;
					case '4' : 
						if ($list['list']['t11_2'] >0)
							$list['list_s']['t11_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_2'] * $RepList[$i]['g_odds']; 
						 else 
							$list['list_s']['t11_2'] = $list['count'][8];
						break;
					case '5' : 
						if ($list['list']['t11_3'] >0)
							$list['list_s']['t11_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_3'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_3'] = $list['count'][8];
						break;
					case '6' : 
						if ($list['list']['t11_4'] >0)
							$list['list_s']['t11_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_4'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_4'] = $list['count'][8];
						break;
					case '7' : 
						if ($list['list']['t11_5'] >0)
							$list['list_s']['t11_5'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_5'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_5'] = $list['count'][8];
						break;
					case '8' : 
						if ($list['list']['t11_6'] >0)
							$list['list_s']['t11_6'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_6'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_6'] = $list['count'][8];
						break;
					case '9' : 
						if ($list['list']['t11_7'] >0)
							$list['list_s']['t11_7'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_7'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_7'] = $list['count'][8];
						break;
					case '10' : 
						if ($list['list']['t11_8'] >0)
							$list['list_s']['t11_8'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_8'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_8'] = $list['count'][8];
							break;
					case '11' : 
						if ($list['list']['t11_9'] >0)
							$list['list_s']['t11_9'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_9'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_9'] = $list['count'][8];
						break;
					case '12' : 
						if ($list['list']['t11_10'] >0)
							$list['list_s']['t11_10'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_10'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_10'] = $list['count'][8];
						break;
					case '13' : 
						if ($list['list']['t11_11'] >0)
							$list['list_s']['t11_11'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_11'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_11'] = $list['count'][8];
						break;
					case '14' : 
						if ($list['list']['t11_12'] >0)
							$list['list_s']['t11_12'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_12'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_12'] = $list['count'][8];
						break;
					case '15' : 
						if ($list['list']['t11_13'] >0)
							$list['list_s']['t11_13'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_13'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_13'] = $list['count'][8];
						break;
					case '16' : 
						if ($list['list']['t11_14'] >0)
							$list['list_s']['t11_14'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_14'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_14'] = $list['count'][8];
						break;
					case '17' : 
						if ($list['list']['t11_15'] >0)
							$list['list_s']['t11_15'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_15'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_15'] = $list['count'][8];
						break;
					case '18' : 
						if ($list['list']['t11_16'] >0)
							$list['list_s']['t11_16'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_16'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_16'] = $list['count'][8];
						break;
					case '19' : 
						if ($list['list']['t11_17'] >0)
							$list['list_s']['t11_17'] = $list['count'][0] + $list['count'][8] - $list['list']['t11_17'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t11_17'] = $list['count'][8];
						break;
					
				} 
				//print_r($list['list_s'] );exit;
			}
			else   if($RepList[$i]['g_mingxi_1'] == "冠亞和" && Copyright ) 
			{
				switch ($RepList[$i]['g_mingxi_2']) {
					case '冠亞和大' : 
						if ($list['list']['t12_1'] >0)
							$list['list_s']['t12_1'] = $list['count'][0] + $list['count'][8] - $list['list']['t12_1'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t12_1'] = $list['count'][8];
						break;
					case '冠亞和小' : 
						if ($list['list']['t12_2'] >0)
							$list['list_s']['t12_2'] = $list['count'][0] + $list['count'][8] - $list['list']['t12_2'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t12_2'] = $list['count'][8];
						break;
					case '冠亞和單' : 
						if ($list['list']['t12_3'] >0)
							$list['list_s']['t12_3'] = $list['count'][0] + $list['count'][8] - $list['list']['t12_3'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t12_3'] = $list['count'][8];
						break;
					case '冠亞和雙' : 
						if ($list['list']['t12_4'] >0)
							$list['list_s']['t12_4'] = $list['count'][0] + $list['count'][8] - $list['list']['t12_4'] * $RepList[$i]['g_odds']; 
						else 
							$list['list_s']['t12_4'] = $list['count'][8];
						break;
				}
			}
			}

		}
		for ($i=1; $i<21; $i++){
			$a[]=$list['list_s'][$i];
		}
		$list['count'][1] = sumMix ($a);
		return $list;
	}
	
	private function SumTM($money,$id)
	{
		$n=$money;
		if ($this->UserList)
		{
			for ($i=0; $i<count($this->UserList); $i++)
			{
				if ($this->UserList[$i]['g_t_id']==$id){
					$n = $n - ($this->UserList[$i]['g_jiner']*$this->UserList[$i]['g_mingxi_1_str']);
				}
			}
		}
		return $n;
	}
	
	
/**
	 * 復式計算
	 * Enter description here ...
	 * @param Array $strArr 數組
	 * @param int 循環
	 * @return Array
	 */
	private function subNumber ($strArr, $count)
	{
		$Number = array();
		for ($a=0; $a<count($strArr); $a++)
		{
			$_a = $a+1;
			for ($b=$_a; $b<count($strArr); $b++)
			{
				if ($count == 2 && Copyright)
				{
					$exp = $strArr[$a].'、'.$strArr[$b];
					array_push($Number, $exp);
					continue;
				}
				$_b = $b+1;
				for ($c=$_b; $c<count($strArr); $c++)
				{
					if ($count == 3)
					{
						$exp = $strArr[$a].'、'.$strArr[$b].'、'.$strArr[$c];
						array_push($Number, $exp);
						continue;
					}
				
					$_c = $c+1;
					for ($d=$_c; $d<count($strArr); $d++)
					{
						if ($count == 4)
						{
							$exp = $strArr[$a].'、'.$strArr[$b].'、'.$strArr[$c].'、'.$strArr[$d];
							array_push($Number, $exp);
							continue;
						}
					
						$_d = $d+1;
						for ($e=$_d; $e<count($strArr); $e++)
						{
							if ($count == 5)
							{
								$exp = $strArr[$a].'、'.$strArr[$b].'、'.$strArr[$c].'、'.$strArr[$d].'、'.$strArr[$e];
								array_push($Number, $exp);
								continue;
							}
						}
					}
				}
			}
		}
		return $Number;
	}
	
	/**
	 * 計算實佔注單
	 * @param Array 注單列表
	 * @param Int 用戶級別
	 * @return Array
	 */
	private function SumReport ($result, $logId)
	{
		$List = array();
		for ($i=0; $i<count($result); $i++) 
		{
			$List[$i]['g_id'] = $result[$i]['g_id'];
			$List[$i]['g_mingxi_1'] = $result[$i]['g_mingxi_1'];
			$List[$i]['g_mingxi_2'] = $result[$i]['g_mingxi_2'];
			$List[$i]['g_mingxi_1_str'] = $result[$i]['g_mingxi_1_str'];
			if ($result[$i]['g_mingxi_1_str'])
				$result[$i]['g_jiner'] = $result[$i]['g_jiner'] * $result[$i]['g_mingxi_1_str'];
				
			if ($logId == 89 ){
				//注額計算，注額*佔成
				$ts = (((100-$result[$i]['g_tueishui_4'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_4']/100);
				$List[$i]['g_jiner'] = $result[$i]['g_jiner'] * ($result[$i]['g_distribution_4']/100);
			}else if ($logId == 56){
				//注額計算，注額*佔成
				if ($result[$i]['g_tueishui_3'] >0 && Copyright){
					$ts = (((100-$result[$i]['g_tueishui_3'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_3']/100);
				} else {
					$ts = (((100-$result[$i]['g_tueishui'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_3']/100);
				}
				$List[$i]['g_jiner'] = $result[$i]['g_jiner'] * ($result[$i]['g_distribution_3']/100);
			}else if ($logId == 22){
				//注額計算，注額*佔成
				if ($result[$i]['g_tueishui_2'] >0 && Copyright){
					$ts = (((100-$result[$i]['g_tueishui_2'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_2']/100);
				} else {
					$ts = (((100-$result[$i]['g_tueishui'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_2']/100);
				}
				$List[$i]['g_jiner'] = $result[$i]['g_jiner'] * ($result[$i]['g_distribution_2']/100);
			}else if ($logId == 78){
				//注額計算，注額*佔成
				if ($result[$i]['g_tueishui_1'] >0 && Copyright){
					$ts = (((100-$result[$i]['g_tueishui_1'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_1']/100);
				} else {
					$ts = (((100-$result[$i]['g_tueishui'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution_1']/100);
				}
				$List[$i]['g_jiner'] = $result[$i]['g_jiner'] * ($result[$i]['g_distribution_1']/100);
			}else if ($logId == 48){
				//注額計算，注額*佔成
				$ts = (((100-$result[$i]['g_tueishui'])/100) * $result[$i]['g_jiner']) * ($result[$i]['g_distribution']/100);
				$List[$i]['g_jiner'] = $result[$i]['g_jiner'] * ($result[$i]['g_distribution']/100);
			}
			$List[$i]['g_odds'] = $result[$i]['g_odds'];
			$List[$i]['g_tueishui'] = $ts;
		}
		return $List;
	}
	
	/**
	 * 讀取賠率列表，開盤時間，封盤時間，開盤期數
	 */
	private function GetOddsInfo ()
	{
		$result = $this->db->query("SELECT * FROM g_kaipan7 WHERE `g_lock` = 2 ORDER BY g_qishu DESC LIMIT 1  ", 1);
		if ($result)
		{
			switch ($this->cid)
			{
				case '1': $p=15; $g_id = "Ball_th_j";
						  $oddsList1 = selectOddsk3($p, $g_id); //賠率
						  $g_id = "Ball_w_s";
						  $oddsList2 = selectOddsk3($p, $g_id); //賠率
						  $g_id = "Ball_d_s";
						  $oddsList3 = selectOddsk3($p, $g_id); //賠率
						  $g_id = "Ball_l_p";
						  $oddsList4 = selectOddsk3($p, $g_id); //賠率
						  $g_id = "Ball_d_p";
						  $oddsList5 = selectOddsk3($p, $g_id); //賠率
						  $oddsList = array_merge($oddsList1,$oddsList2,$oddsList3,$oddsList4,$oddsList5);
				 break;
				
				
				default:$p = $g_id = null;
			}
			
			//$oddsList = selectOddspk($p, $g_id); //賠率
			$endTime = strtotime($result[0]['g_feng_date']) - time();
			$openTime =  strtotime($result[0]['g_open_date']) - time();
			$Phases = $result[0]['g_qishu'];
			$InfoList = array();
			$userList = $this->UserInfo ($Phases);
			$count = array(0=>0, 1=>0, 2=>0);
			$InfoList['userList'] = $userList;
			$InfoList['oddList'] = $oddsList;
			$InfoList['endTime'] = $endTime;
			$InfoList['openTime'] = $openTime;
			$InfoList['phasesNumber'] = $Phases;
			//$InfoList['opNumber'] = $opNumber[0][0];
			//$InfoList['countLose'] = $count[1];
			//$InfoList['countWin'] = $count[2];
			return $InfoList;
		}
		else 
		{
			return null;
		}
	}
	
	/**
	 * 計算用戶輸贏結果
	 * @param Array $user
	 */
	public function SumResult($Users)
	{
		include_once ROOT_PATH.'function/Crystals.php';
		$CentetArr = array();
		$CentetArr['userList']['s_types'] = null;
		$CentetArr['userList']['s_type'] = null;
		$CentetArr['userList']['s_t_N'] = 1;
		$CentetArr['userList']['startDate'] = date("Y-m-d");
		$CentetArr['userList']['endDate'] = date("Y-m-d");
		$CentetArr['userList']['s_Report'] = 'a';
		$CentetArr['userList']['s_Balance'] = 1;
		if ($Users[0]['g_login_id']==89)
		{
			$result = $this->db->query("SELECT `g_nid`,`g_login_id`, `g_name` FROM `g_manage` WHERE g_nid = '{$Users[0]['g_nid']}' LIMIT 1", 1);
			//print_r($Users[0]['g_nid']);
			$CentetArr['userList']['s_name'] = $result[0]['g_name'];
			$CentetArr['userList']['g_login_id'] = $result[0]['g_login_id'];
			$CentetArr['userList']['s_rank'] = $Users[0]['g_Lnid'][1];
			$s_rank = $Users[0]['g_Lnid'][2];
			$CentetArr['userList']['s_nid'] = $result[0]['g_nid'].UserModel::Like();
		}
		else 
		{
			$CentetArr['userList']['s_name'] = $Users[0]['g_name'];
			if ($Users[0]['g_login_id'] == 48){
				$CentetArr['userList']['s_nid'] = $Users[0]['g_nid'];
				$param = true;
			}
			else {
				$CentetArr['userList']['s_nid'] = $Users[0]['g_nid'].UserModel::Like();
			}
			$CentetArr['userList']['g_login_id'] = $Users[0]['g_login_id'];
			$CentetArr['userList']['s_rank'] = $Users[0]['g_Lnid'][0];
			$s_rank = $Users[0]['g_Lnid'][1];
		}
		$result = ResultNid ($this->db, $CentetArr['userList']['s_nid'], true, $param);
		for ($i=0; $i<count($result); $i++) {
			$c = GetCrystals($this->db, $CentetArr['userList'], $result[$i]);
			if ($c != null) {
					$result[$i]['cry'] = $c;
					$CentetArr['cryList'][] = $result[$i];
			}
		}
		$CentetArr = SumCrystals ($CentetArr);
		$money = $CentetArr['userList']['s_rank']=='总公司' ? $CentetArr['userList']['count_s'][3] : $CentetArr['userList']['count_s'][9];
		
		return is_Number($money,1);
	}
	
	/**
	 * 補倉函數
	 * @param array $List
	 */
	public function PostCrystls($List, $param='a')
	{
		$arr = array();
		if ($List['g_typeid'] =='江苏骰寶(快3)'){
			$p =$List['s_type'];
			$s = false;
		}else{
			$p = _getStringcq($List['s_type'], $List['s_num'][0]);
			$s = true;
		}
		switch ($this->User[0]['g_login_id'])
		{
			case 56 :
				$nid = $this->User[0]['g_nid'];
				$RankUser = RankUserMa ($this->db,  $nid);
				$this->User[0]['g_panlu'] = $param;
				for ($i=0; $i<count($List['s_num']); $i++)
				{
					$floorMoneyk3 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser, $s);
					$arr[$i]['g_t_id'] = $List['s_id'];
					$arr[$i]['g_s_nid'] = $this->User[0]['g_nid'];
					$arr[$i]['g_nid'] = '分公司走飛';
					$arr[$i]['g_mumber_type'] = 5;
					$arr[$i]['g_type'] = $List['g_typeid'];
					$arr[$i]['g_qishu'] = $List['s_number'];
					$arr[$i]['g_mingxi_1'] = $List['s_type'];
					$arr[$i]['g_mingxi_1_str'] = $List['s_mingxi_1_str'];
					$arr[$i]['g_mingxi_2'] = $List['s_num'][$i];
					$arr[$i]['g_mingxi_2_str'] = null;
					$arr[$i]['g_odds'] = $List['s_odds'];
					$arr[$i]['g_jiner'] = $List['s_money'][$i];
					$arr[$i]['g_tueishui'] = $floorMoneyk3;
					$arr[$i]['g_tueishui_1'] = 0;
					$arr[$i]['g_tueishui_2'] = 0;
					$arr[$i]['g_tueishui_3'] = 0;
					$arr[$i]['g_tueishui_4'] = $floorMoneyk3;
					$arr[$i]['g_distribution'] = 0;
					$arr[$i]['g_distribution_1'] = 0;
					$arr[$i]['g_distribution_2'] = 0;
					$arr[$i]['g_distribution_3'] = 0;
					$arr[$i]['g_distribution_4'] = 100-$this->User[0]['g_distribution_limit'];
					$arr[$i]['nowjiner'] = getMoneyaaaa($this->User);//jia
					$arr[$i]['g_id'] = $this->WhileInsert ($arr[$i]);
				}
				break;
			case 22 :
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-32);
				$RankUser = RankUser ($this->db,  $nid);
				$this->User[0]['g_panlu'] = $param;
				for ($i=0; $i<count($List['s_num']); $i++)
				{
					$floorMoneyk3 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser, $s);
					$arr[$i]['g_t_id'] = $List['s_id'];
					$arr[$i]['g_s_nid'] = $this->User[0]['g_nid'];
					$arr[$i]['g_nid'] = '股東走飛';
					$arr[$i]['g_mumber_type'] = 5;
					$arr[$i]['g_type'] = $List['g_typeid'];
					$arr[$i]['g_qishu'] = $List['s_number'];
					$arr[$i]['g_mingxi_1'] = $List['s_type'];
					$arr[$i]['g_mingxi_1_str'] = $List['s_mingxi_1_str'];
					$arr[$i]['g_mingxi_2'] = $List['s_num'][$i];
					$arr[$i]['g_mingxi_2_str'] = null;
					$arr[$i]['g_odds'] = $List['s_odds'];
					$arr[$i]['g_jiner'] = $List['s_money'][$i];
					$arr[$i]['g_tueishui'] = $floorMoneyk3;
					$arr[$i]['g_tueishui_1'] = 0;
					$arr[$i]['g_tueishui_2'] = 0;
					$arr[$i]['g_tueishui_3'] = $floorMoneyk3;
					$arr[$i]['g_tueishui_4'] = $floorMoneyk3;
					$arr[$i]['g_distribution'] = 0;
					$arr[$i]['g_distribution_1'] = 0;
					$arr[$i]['g_distribution_2'] = 0;
					$arr[$i]['g_distribution_3'] = $RankUser[0]['g_distribution_limit'];
					$arr[$i]['g_distribution_4'] = 100-$RankUser[0]['g_distribution_limit'];
					$arr[$i]['nowjiner'] = getMoneyaaaa($this->User);//jia
					$arr[$i]['g_id'] = $this->WhileInsert ($arr[$i]);
				}
				break;
			case 78 :
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-32);
				$RankUser1 = RankUser ($this->db,  $nid); //股東
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-64);
				$RankUser2 = RankUser ($this->db,  $nid); //公司
				$this->User[0]['g_panlu'] = 'a';
				for ($i=0; $i<count($List['s_num']); $i++)
				{
					$floorMoneyk31 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser1, $s);
					$floorMoneyk32 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser2, $s);
					$arr[$i]['g_t_id'] = $List['s_id'];
					$arr[$i]['g_s_nid'] = $this->User[0]['g_nid'];
					$arr[$i]['g_nid'] = '總代理走飛';
					$arr[$i]['g_mumber_type'] = 5;
					$arr[$i]['g_type'] = $List['g_typeid'];
					$arr[$i]['g_qishu'] = $List['s_number'];
					$arr[$i]['g_mingxi_1'] = $List['s_type'];
					$arr[$i]['g_mingxi_1_str'] = $List['s_mingxi_1_str'];
					$arr[$i]['g_mingxi_2'] = $List['s_num'][$i];
					$arr[$i]['g_mingxi_2_str'] = null;
					$arr[$i]['g_odds'] = $List['s_odds'];
					$arr[$i]['g_jiner'] = $List['s_money'][$i];
					$arr[$i]['g_tueishui'] = $floorMoneyk31;
					$arr[$i]['g_tueishui_1'] = 0;
					$arr[$i]['g_tueishui_2'] = $floorMoneyk31;
					$arr[$i]['g_tueishui_3'] = $floorMoneyk32;
					$arr[$i]['g_tueishui_4'] = $floorMoneyk32;
					$arr[$i]['g_distribution'] = 0;
					$arr[$i]['g_distribution_1'] = 0;
					$arr[$i]['g_distribution_2'] = $this->User[0]['g_distribution_limit'];
					$arr[$i]['g_distribution_3'] = $RankUser2[0]['g_distribution_limit']  - $this->User[0]['g_distribution_limit'];
					$arr[$i]['g_distribution_4'] = 100- $RankUser2[0]['g_distribution_limit'] ;
					$arr[$i]['nowjiner'] = getMoneyaaaa($this->User);//jia
					$arr[$i]['g_id'] = $this->WhileInsert ($arr[$i]);
				}
				break;
			case 48 :
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-32);
				$RankUser1 = RankUser ($this->db,  $nid); //總代理
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-64);
				$RankUser2 = RankUser ($this->db,  $nid); //股東
				$nid = mb_substr($this->User[0]['g_nid'], 0, mb_strlen($this->User[0]['g_nid'])-96);
				$RankUser3 = RankUser ($this->db,  $nid); //公司
				$this->User[0]['g_panlu'] = 'a';
				for ($i=0; $i<count($List['s_num']); $i++)
				{
					$floorMoneyk31 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser1, $s);
					$floorMoneyk32 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser2, $s);
					$floorMoneyk33 = floorMoneyk3 ($this->User, $p, $List['s_num'][$i], $RankUser3, $s);
					$arr[$i]['g_t_id'] = $List['s_id'];
					$arr[$i]['g_s_nid'] = $this->User[0]['g_nid'];
					$arr[$i]['g_nid'] = '代理走飛';
					$arr[$i]['g_mumber_type'] = 5;
					$arr[$i]['g_type'] = $List['g_typeid'];
					$arr[$i]['g_qishu'] = $List['s_number'];
					$arr[$i]['g_mingxi_1'] = $List['s_type'];
					$arr[$i]['g_mingxi_1_str'] = $List['s_mingxi_1_str'];
					$arr[$i]['g_mingxi_2'] = $List['s_num'][$i];
					$arr[$i]['g_mingxi_2_str'] = null;
					$arr[$i]['g_odds'] = $List['s_odds'];
					$arr[$i]['g_jiner'] = $List['s_money'][$i];
					$arr[$i]['g_tueishui'] = $floorMoneyk31;
					$arr[$i]['g_tueishui_1'] = $floorMoneyk31;
					$arr[$i]['g_tueishui_2'] = $floorMoneyk32;
					$arr[$i]['g_tueishui_3'] = $floorMoneyk33;
					$arr[$i]['g_tueishui_4'] = $floorMoneyk33;
					$arr[$i]['g_distribution'] = 0;
					$arr[$i]['g_distribution_1'] = $this->User[0]['g_distribution_limit'];
					$arr[$i]['g_distribution_2'] = $RankUser1[0]['g_distribution_limit'];
					$arr[$i]['g_distribution_3'] = $RankUser3[0]['g_distribution_limit'] - ($this->User[0]['g_distribution_limit']+$RankUser1[0]['g_distribution_limit']);
					$arr[$i]['g_distribution_4']=100-$RankUser3[0]['g_distribution_limit'];
					$arr[$i]['nowjiner'] = getMoneyaaaa($this->User);//jia
					$arr[$i]['g_id'] = $this->WhileInsert ($arr[$i]);
				}

				break;
		}
		return $arr;
	}
	
	public  function WhileInsert ($list)
	{
		$sql = "INSERT INTO `g_zhudan` ( `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_distribution_4`,`g_t_id`,`g_pan`,`nowjiner`) "; 
		$sql .= "VALUES (
					'{$list['g_s_nid']}', 
					'{$list['g_mumber_type']}', 
					'{$list['g_nid']}', 
					  now(), 
					'{$list['g_type']}', 
					'{$list['g_qishu']}', 
					'{$list['g_mingxi_1']}', 
					'{$list['g_mingxi_1_str']}', 
					'{$list['g_mingxi_2']}', 
					'{$list['g_mingxi_2_str']}', 
					'{$list['g_odds']}', 
					'{$list['g_jiner']}', 
					'{$list['g_tueishui']}',
					'{$list['g_tueishui_1']}',
					'{$list['g_tueishui_2']}',
					'{$list['g_tueishui_3']}',
					'{$list['g_tueishui_4']}',
					'{$list['g_distribution']}',
					'{$list['g_distribution_1']}',
					'{$list['g_distribution_2']}',
					'{$list['g_distribution_3']}',
					'{$list['g_distribution_4']}',
					'{$list['g_t_id']}',
					'{$list['g_pan']}',
					'{$list['nowjiner']}')";
					
		$sql2 = "INSERT INTO `g_zhudan_copy` ( `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_distribution_4`,`g_t_id`,`g_pan`) "; 
		$sql2 .= "VALUES (
					'{$list['g_s_nid']}', 
					'{$list['g_mumber_type']}', 
					'{$list['g_nid']}', 
					  now(), 
					'{$list['g_type']}', 
					'{$list['g_qishu']}', 
					'{$list['g_mingxi_1']}', 
					'{$list['g_mingxi_1_str']}', 
					'{$list['g_mingxi_2']}', 
					'{$list['g_mingxi_2_str']}', 
					'{$list['g_odds']}', 
					'{$list['g_jiner']}', 
					'{$list['g_tueishui']}',
					'{$list['g_tueishui_1']}',
					'{$list['g_tueishui_2']}',
					'{$list['g_tueishui_3']}',
					'{$list['g_tueishui_4']}',
					'{$list['g_distribution']}',
					'{$list['g_distribution_1']}',
					'{$list['g_distribution_2']}',
					'{$list['g_distribution_3']}',
					'{$list['g_distribution_4']}',
					'{$list['g_t_id']}',
					'{$list['g_pan']}')";
		$this->db->query($sql2, 4);
		return $this->db->query($sql, 4);
	}
	
	/**
	 * 調用函數
	 */
	public function ResultInfo ()
	{
		return $this->GetOddsInfo();
	}
}

?>