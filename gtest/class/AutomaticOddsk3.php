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
include_once ROOT_PATH.'config/Odds.php';

class AutomaticOddsk3 
{
	private $db;
	private $Continuous;
	private $NumValue;
	private $StrValue;
	
	/**
	 *@param $Continuous 連續出次數
	 *@param $NumValue 號碼總降值
	 *@param $StrValue 雙面總降值
	 */
	public function __construct($Continuous, $NumValue, $StrValue)
	{
		$this->db = new DB();
		$this->Continuous = $Continuous;
		$this->NumValue = $NumValue;
		$this->StrValue = $StrValue;
	}
	
	/**
	 * 執行降賠率
	 * @param unknown_type $Continuous
	 * @param unknown_type $NumValue
	 * @param unknown_type $StrValue
	 */
	public function UpExecution()
	{
		$result = $this->SearchNumber($this->Continuous, $this->NumValue, $this->StrValue);
		if ($result['Num'] && Copyright)
		{
			foreach ($result['Num'] as $key=>$value)
			{
			
				$sql = "UPDATE g_odds7 SET `{$key}`={$key}-{$value} WHERE g_type <> 'Ball_l_p' AND g_type <> 'Ball_d_s'";
				$this->db->query($sql, 2);
			}
		}
		if ($result['Str'] && Copyright)
		{
			for ($i=0; $i<count($result['Str']); $i++)
			{
				$sql = "UPDATE g_odds7 SET `{$result['Str'][$i][1]}` = {$result['Str'][$i][1]}-{$result['Str'][$i][2]} WHERE g_type ='{$result['Str'][$i][0]}' LIMIT 1 ";
				$this->db->query($sql, 2);
			}
		}
	}
	
	/**
	 * 查詢連續N期不出的號碼
	 */
	private function SearchNumber($Continuous, $NumValue, $StrValue)
	{
		$ResultNumber = history_resultpk(0);
		
		//得到雙面無出期數
		global $BallStringpk,$BallString_apk;
		$NumberStrArr = sum_ball_count_1_pk ($BallStringpk, $BallString_apk, $ResultNumber, 1);
		
		//取出大於$Continuous連續出期數的雙面
		$NumberStrArr = $this->ResultStrValue($NumberStrArr, $Continuous);

		//雙面轉換
		foreach ($NumberStrArr as $key=>$value)
		{
			$values = $StrValue;
			if ($value > $Continuous && Copyright){
				$n = $value - $Continuous;
				$count = 0;
				for ($i=0; $i<$n; $i++)
					$count += $StrValue;
				$values += $count;
			}
					
			 $numArr[] = $this->NumberFormat($key, $values);
			 $values = $count= 0;
		}
		
		//得到1-20無出期數
		$NumberArr = sum_ball_count_pk ($ResultNumber, 1);
		$NumberArr = $NumberArr['row_2'];
		
		//取出大於$Continuous連續不出期數的1-20號碼
		$NumberArr = $this->ResultStrValue($NumberArr, $Continuous);
		
		//計算需要降多少次賠率
		$UpOddsArr = array();
		foreach ($NumberArr as $key=>$value)
		{
			$UpOddsArr['h'.$key] = $NumValue;
			if ($value > $Continuous && Copyright){
				$n = $value - $Continuous;
				$count = 0;
				for ($i=0; $i<$n; $i++)
					$count += $NumValue;
				$UpOddsArr['h'.$key] += $count;
			}
		}
		$result = array('Num'=>$UpOddsArr, 'Str'=>$numArr);
		return $result;
	}
	
	private function ResultStrValue($NumberArr, $Continuous)
	{
		$NumberArrs =array();
		foreach ($NumberArr as $key=>$value)
		{	
			if ($value >= $Continuous && Copyright)
				$NumberArrs[$key] = $value;
		}
		return $NumberArrs;
	}
	
	private function NumberFormat($num, $param)
	{
		$str=array();
		$p = mb_substr($num, 3,1);

		switch ($num)
		{
			case "三軍-大":  $str[0] = "Ball_th_j"; $str[1] = 'h7'; break;
			case "三軍-小" : $str[0] = "Ball_th_j"; $str[1] = 'h8'; break;
			
		}
		$str[2]=$param;
		return $str;
	}
}
?>