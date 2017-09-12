<?php
class pays extends WebBase{	
	/**
	 * 易宝
	 */

	public final function yeepay(){

		if(!$para=$_POST) throw new Exception('参数出错');

		if($para['p3_Amt']<=0) throw new Exception('充值金额错误，请重新操作');

		$this->display('yeepay/pays.php',0,$para);
    }

	public final function yeepaycallback(){

		if(!$para=$_POST) throw new Exception('接收参数出错');
		$this->display('yeepay/callback.php',0,$para);
    }
}