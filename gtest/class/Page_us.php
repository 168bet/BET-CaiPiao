<?php
if (!defined('ROOT_PATH'))
exit('invalid request');
	class Page_us {
		private $total; //数据表中总记录数
		private $listRows; //每页显示行数
		private $limit;
		private $uri;
		private $pageNum; //页数
		private $config=array('header'=>"條记录", "prev"=>"上一頁", "next"=>"下一頁", "first"=>"首 頁", "last"=>"末 頁");
		private $listNum=8;

		public function __construct($total, $listRows=10, $pa=""){
			$this->total=$total;
			$this->listRows=$listRows;
			$this->uri=$this->getUri($pa);
			$this->page=!empty($_GET["page"]) ? $_GET["page"] : 1;
			$this->pageNum=ceil($this->total/$this->listRows);
			$this->limit=$this->setLimit();
		}

		private function setLimit(){
			if($this->page>$this->pageNum)
			$this->page=$this->pageNum;
			return "Limit ".($this->page-1)*$this->listRows.", {$this->listRows}";
		}

		private function getUri($pa){
			$url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"], '?')?'':"?").$pa;
			//echo $url;
			$parse=parse_url($url);

			if(isset($parse["query"])){
				parse_str($parse['query'],$params);
				unset($params["page"]);
				$url=$parse['path'].'?'.http_build_query($params);
				
			}

			return $url;
		}

		public function __get($args){
			if($args=="limit")
				return $this->limit;
			else
				return null;
		}

		private function start(){
			if($this->total==0)
				return 0;
			else
				return ($this->page-1)*$this->listRows+1;
		}

		private function end(){
			return min($this->page*$this->listRows,$this->total);
		}

		private function first(){
			//if($this->page==1)
			//	@$html.='';
			//else
				@$html.="<a href='javascript:void(0)' rel='{$this->uri}&page=1'  id='first' class='first' title='第一页' ></a>";

			return $html;
		}

		private function prev(){
			//if($this->page==1)
			//	@$html.='';
			//else
				@$html.="<a href='javascript:void(0)' rel='{$this->uri}&page=".($this->page-1)."'  id='previous' class='previous' title='上一页'></a>";

			return $html;
		}

		private function pageList(){
			$linkPage="";
			
			$inum=floor($this->listNum/2);
		
			for($i=$inum; $i>=1; $i--){
				$page=$this->page-$i;

				if($page<1)
					continue;

				$linkPage.="<SPAN class=other>第<INPUT id=current_page class=pageindex value='{$this->page}'>页</SPAN>";

			}
		
			//$linkPage.="&nbsp;{$this->page}&nbsp;";
			
			if($this->pageNum==1){
			$linkPage.="<SPAN class=other>第<INPUT id=current_page class=pageindex value='{$this->page}'>页</SPAN>";
			}else{
			for($i=1; $i<=$inum; $i++){
				$page=$this->page+$i;
				if($page<=$this->pageNum)
					$linkPage.="<SPAN class=other>第<INPUT id=current_page class=pageindex value='{$this->page}'>页</SPAN>";
				else
					break;
			}
			}
			return $linkPage;
		}

		private function next(){
			//if($this->page==$this->pageNum)
			//	@$html.='';
			//else
				@$html.="<a id='next' class='next' title='下一页' href='javascript:void(0)' rel='{$this->uri}&page=".($this->page+1)."'></a>";

			return $html;
		}

		private function last(){
			//if($this->page==$this->pageNum)
			//	@$html.='';
			//else
				@$html.="<a  id='last' class='last' title='末页' href='javascript:void(0)'  rel='{$this->uri}&page=".($this->pageNum)."'></a>";

			return $html;
		}

		private function goPage(){
			return '&nbsp;&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'&page=\'+page+\'\'}" value="'.$this->page.'" style="width:25px"><input type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'&page=\'+page+\'\'">&nbsp;&nbsp;';
		}
		function fpage($display=array(0,1,2,3,4,5,6,7,8)){
			//$html[0]="&nbsp;&nbsp;共有<b>{$this->total}</b>{$this->config["header"]}&nbsp;&nbsp;";
			//$html[1]="&nbsp;&nbsp;每頁顯示<b>".($this->end()-$this->start()+1)."</b>條，本頁<b>{$this->start()}-{$this->end()}</b>條&nbsp;&nbsp;";
			
			
			$html[0]=$this->first();
			$html[1]=$this->prev();
			$html[2]=$this->pageList();
			$html[3]="<SPAN class=other>共<SPAN id='total_page'>{$this->pageNum}</SPAN>頁</SPAN>";
			$html[4]=$this->next();
			$html[5]=$this->last();
			//$html[8]=$this->goPage();
			$fpage='';
			foreach($display as $index){
				$fpage.=$html[$index];
			}

			return $fpage;

		}

	
	}
