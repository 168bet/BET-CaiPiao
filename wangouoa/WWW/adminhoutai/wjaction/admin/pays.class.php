<?php
class pays extends AdminBase{
	/**
	 * ֧���ӿ��б�
	 */
	public final function index(){
		$this->display('pay/list.php');
	}

	public final function addpayModal(){
		$this->display('pay/pay-add-modal.php');
	}

	public final function addpay(){
		$para=$_POST;
		if(!$para) throw new Exception('�ύ���ݳ��������²���');

		$update['name']=wjStrFilter($para['name']);
		$update['number']=wjStrFilter($para['number']);
		$update['mkey']=wjStrFilter($para['mkey']);
		$update['sortname']=wjStrFilter($para['sortname']);

		$sql="select name from ssc_pay where name=?";
		if($this->getvalue($sql,$update['name'])) throw new Exception('�����ظ����ͬһ�̼���');

		if($this->insertRow($this->prename .'pay', $update)){
			$id=$this->lastInsertId();
			$this->addLog(20,$this->adminLogType[20].'['.$this->user['username'].']',$this->lastInsertId(),$this->user['username']);
			return '��ӽӿڳɹ�';
		}else{
			throw new Exception('δ֪����');
		}
	}

	public final function deletepay($sid){
		$sid=intval($sid);
		$sql="delete from ssc_pay where sid=?";
		if($this->delete($sql, $sid)){
			return '�ӿ��Ѿ�ɾ��';
		}else{
			throw new Exception('δ֪����');
		}
	}
}