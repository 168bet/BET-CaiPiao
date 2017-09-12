<?php

class Score extends WebLoginBase{
	public $scoretype='current';
	public $limittype='all';
	public $pageSize=3;
	public $payout=0.85;		// 取消兑换积分返还率
	/**
	 * 列表页
	 */
	public final function goods($scoretype=null,$limittype=null){
		if($scoretype) $this->scoretype=$scoretype;
		if($limittype) $this->limittype=$limittype;
		$sql="select * from {$this->prename}score_goods where enable=1 and isdelete=0 and startTime<={$this->time} and ";
		switch($this->scoretype){
			case 'current':
				// 正在进行的活动
				switch($this->limittype){
					case 'all':
						$sql.="(stopTime>{$this->time} or stopTime=0)";
					break;
					case 'time':
						$sql.="stopTime>{$this->time} and sum=0";
					break;
					case 'number':
						$sql.='sum>0 and surplus>0 and stopTime=0';
					break;
					case 'both':
						$sql.="stopTime>{$this->time} and sum>0";
					break;
					case 'none':
						$sql.='stopTime=0 and sum=0';
					break;
					default:
						throw new Exception('参数出错');
				}
			break;
			case 'old':
				switch($this->limittype){
					case 'all':
						$sql.="((stopTime<{$this->time} and stopTime<>0) or (sum>0 and surplus=0))";
					break;
					case 'time':
						$sql.="stopTime<{$this->time} and sum=0";
					break;
					case 'number':
						$sql.='sum>0 and surplus=0';
					break;
					case 'both':
						$sql.="stopTime>0 and (stopTime<{$this->time} or (sum>0 and surplus=0))";
					break;
					default:
						throw new Exception('参数出错');
				}
			break;
			case 'me':
				$sql="select s.id swapId, s.state, g.* from {$this->prename}score_swap s, {$this->prename}score_goods g where s.goodId=g.id and s.uid={$this->user['uid']} and ";
				switch($this->limittype){
					case 'current':
						$sql.='state between 1 and 2';
					break;
					case 'history':
						$sql.='state=0';
					break;
					default:
						throw new Exception('参数出错');
				}
			break;
			default:
				throw new Exception('参数出错');
			break;
		}
		$sql.=' order by id';
		$goods=$this->getPage($sql, $this->page, $this->pageSize);
		$this->display('score/list.php',0,$goods);
	}

	/**
	 * 兑换页
	 */
	public final function swap($goodId){
		$goodId=intval($goodId);
		$good=$this->getRow("select * from {$this->prename}score_goods where id=?", $goodId);
		$this->display('score/swap.php',0,$good);
	}

	/**
	 * 兑换
	 */
	public final function swapGood(){
		if(!$_POST) throw new Exception('请求出错');

		//过滤未知字段
		$para['goodId']=intval($_POST['goodId']);
		$para['number']=$_POST['number'];
		$para['coinpwd']=$_POST['coinpwd'];

		if(!$para['goodId']) throw new Exception('请求出错');
		if(!ctype_digit($para['number'])) throw new Exception('兑换数量必须为整数');
		if($para['number']<=0) throw new Exception('兑换数量需大于等于1');
		
		$this->beginTransaction();
		try{
			$sql="select * from {$this->prename}score_goods where id=?";
			if(!$good=$this->getRow($sql, $para['goodId'])) throw new Exception('兑换商品不存在');
			if($good['stopTime']>0 && $good['stopTime']<$this->time) throw new Exception('这活动已经过期了');
			if($good['sum']>0 && $good['surplus']==$good['sum']) throw new Exception('这礼品已经兑换完了');
            $good['score']=$good['score']*$para['number'];
			
			$this->freshSession();
			if($good['score']>$this->user['score']) throw new Exception('你拥有积分不足，不能兑换这礼品');
			if(md5($para['coinpwd'])!=$this->user['coinPassword']) throw new Exception('资金密码不正确');
			unset($para['coinpwd']);
			
			$para['swapTime']=$this->time;
			$para['swapIp']=$this->ip(true);
			$para['uid']=$this->user['uid'];
			$para['score']=$good['score'];
			
			if($good['price']>0){//积分直接兑奖
				$para['state']=0;
				}
			if(!$this->insertRow($this->prename .'score_swap', $para)) throw new Exception('兑换礼品出错');
			
			$sql="update {$this->prename}members set score=score-{$good['score']} where uid=?";
			if(!$this->update($sql, $this->user['uid'])) throw new Exception('兑换礼品出错');
			
			if($good['sum']>0){
				// 限量兑换的礼品
				$sql="update {$this->prename}score_goods set surplus=surplus+1,persons=persons+1 where id=?";
				if(!$this->update($sql, $good['id'])) throw new Exception('兑换礼品出错');
			}
			if($good['price']>0){//积分直接兑奖
				$rechargeAmount=$good['price']*$para['number']; //元
					
					$this->addCoin(array(
						'uid'=>$this->user['uid'],
						'coin'=>$rechargeAmount,
						'liqType'=>1,
						//'extfield0'=>$id,
						'extfield0'=>0,
						'extfield1'=>0,
						'info'=>'积分兑换'
					));	
			}//兑换积分结束
			$this->commit();
			return '兑换礼品成功';
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	
	/**
	 * 兑换礼品状态改变
	 */
	public final function setSwapState($swapId){
		if(!$swapId=intval($swapId)) throw new Exception('请求出错');
		if(!$swap=$this->getRow("select * from {$this->prename}score_swap where id=$swapId")) throw new Exception('请求出错');
		
		if($swap['uid']!=$this->user['uid']) throw new Exception('你不能代别人取消兑换或确认收货');
		if($swap['state']==0) throw new Exception('这兑换已经确认收货了');
		if($swap['state']==3) throw new Exception('这兑换已经取消。');
		
		if($swap['state']==1){
			$score=round($swap['score']*$this->payout);
			$sql="update {$this->prename}members u, {$this->prename}score_swap s set u.score=u.score+$score, s.state=3 where u.uid=s.uid and s.id=$swapId";
		}elseif($swap['state']==2){
			$sql="update {$this->prename}score_swap set state=0 where id=$swapId";
		}else{
			throw new Exception('请求出错');
		}
		
		if($this->update($sql)){
			return '操作成功';
		}else{
			throw new Exception('请求出错');
		}
	}
	
	public function formatGoodTime($startTime, $endTime){
		if($this->time < $startTime) return '等待中';
		if($endTime && $endTime < $this->time) return '已结束';
		if(!$endTime) return '';
		
		$time=$endTime-$this->time;
		if($time>24*3600){
			$return=floor($time/(24*3600)).'天';
			$time%=24*3600;
		}
		
		if($time>3600){
			$return.=floor($time/3600).'时';
			$time%=3600;
		}
		
		$return.=floor($time/60).'分';
		return $this->CsubStr($return,0,6,'');
	}
	
}