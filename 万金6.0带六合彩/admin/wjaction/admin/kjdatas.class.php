<?php
class kjdatas extends AdminBase{
	public $pageSize=15;
	/**
	 * �������
	 */
	public final function tests(){
		$this->display('kjdatas/list.php');
	}
}