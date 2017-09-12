<?php
class Time extends AdminBase{
	public $pageSize=20;
	
	public final function index($type){
		$this->type=$type;
		$this->display('time/index.php');
	}
	

	// 彩种时间相关方法
	
	public final function updateTime($type,$id){
		if($this->updateRows($this->prename .'data_time', $_POST, 'id='.$id)){
			$shortName=$this->getValue("select shortName from {$this->prename}type where id=?", $type);
			$actionNo=$this->getValue("select actionNo from {$this->prename}type where id=?", $id);
			$this->addLog(19,$this->adminLogType[19].'['.$shortName.'第'.$actionNo.'期]',$id,$shortName.'第'.$actionNo.'期');
			echo '修改时间成功';
		}else{
			throw new Exception('未知出错');
		}
	}
	
	
}