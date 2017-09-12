 <?php
	$lastNo=$this->getGameLastNo($this->type);
	$kjHao=$this->getValue("select data from {$this->prename}data where type={$this->type} and number='{$lastNo['actionNo']}'");
	if($kjHao) $kjHao=explode(',', $kjHao);
	
	$actionNo=$this->getGameNo($this->type);
	$types=$this->getTypes();
	$kjdTime=$types[$this->type]['data_ftime'];
	$diffTime=strtotime($actionNo['actionTime'])-$this->time-$kjdTime;
	$kjDiffTime=strtotime($lastNo['actionTime'])-$this->time;
?>
    <div class="content01" id="kaijiang" type="<?=$this->type?>" ctype="<?=$types[$this->type]['type']?>">
              <div class="qi kj-title">第<span class="thisno"><?=$actionNo['actionNo']?></span>期&nbsp;<em class="wjtips">正在销售中</em></div>
              <div class="jie">截止时间<span id="current_endtime"><?=$actionNo['actionTime']?></span></div>
	          <div class="shi" id="sur-times"><b><img src="/skin/images/time/0.png" alt="" /><img src="/skin/images/time/0.png" alt="" /><img src="/skin/images/mao.png" alt="" /><img src="/skin/images/time/0.png" alt="" /><img src="/skin/images/time/0.png" alt="" /></b><span><img src="/skin/images/mao.png" alt="" /><img src="/skin/images/time/0.png" alt="" /><img src="/skin/images/time/0.png" alt="" /></span></div>
	</div>

       <?php if($types[$this->type]['type']==40) { //快乐十分?>
       <div class="content06">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay"  class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on"  title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>
          <div class="wjkjData">
          	 <div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
				<ul class="kj-hao" ctype="pk10">
                <li id="span_lot_0" class="gr_s gr_s020"> <?=$kjHao[0]?> </li>
                <li id="span_lot_1" class="gr_s gr_s020"> <?=$kjHao[1]?> </li>
                <li id="span_lot_2" class="gr_s gr_s020"> <?=$kjHao[2]?> </li>
                <li id="span_lot_3" class="gr_s gr_s020"> <?=$kjHao[3]?> </li>
                <li id="span_lot_4" class="gr_s gr_s020"> <?=$kjHao[4]?> </li>
                <li id="span_lot_5" class="gr_s gr_s020"> <?=$kjHao[5]?> </li>
                <li id="span_lot_6" class="gr_s gr_s020"> <?=$kjHao[6]?> </li>
                <li id="span_lot_7" class="gr_s gr_s020"> <?=$kjHao[7]?> </li>

              </ul>
              <div class="clear"></div>
          </div>   
	  </td>
      <div class="content07" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
        </div>
	  </td>
     
	 <?php }else if($types[$this->type]['type']==4) { //快乐十分?>
      <div class="content06">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay"  class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on"  title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>
          <div class="wjkjData">
          	 <div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
				<ul class="kj-hao" ctype="kl10">
				<li class="ball2 ball_0444"> <?=$kjHao[777]?> </li>
                <li class="ball2 ball_01"> <?=$kjHao[0]?> </li>
                <li class="ball2 ball_02"> <?=$kjHao[1]?> </li>
                <li class="ball2 ball_03"> <?=$kjHao[2]?> </li>
                <li class="ball2 ball_04"> <?=$kjHao[3]?> </li>
                <li class="ball2 ball_01"> <?=$kjHao[4]?> </li>
                <li class="ball2 ball_02"> <?=$kjHao[5]?> </li>
                <li class="ball2 ball_03"> <?=$kjHao[6]?> </li>
                <li class="ball2 ball_04"> <?=$kjHao[7]?> </li>
             </ul>
              <div class="clear"></div>
          </div>  
		  
	  </div>
      <div class="content07" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
      </div>


 <?php }else if($types[$this->type]['type']==6) { //PK10?>
      <div class="content06">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay"  class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on"  title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>
          <div class="wjkjData">
          	 <div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
				<ul class="kj-hao" ctype="pk10">
                <li class="ball2 ball_01"> <?=$kjHao[0]?> </li>
                <li class="ball2 ball_02"> <?=$kjHao[1]?> </li>
                <li class="ball2 ball_03"> <?=$kjHao[2]?> </li>
                <li class="ball2 ball_04"> <?=$kjHao[3]?> </li>
                <li class="ball2 ball_01"> <?=$kjHao[4]?> </li>
                <li class="ball2 ball_02"> <?=$kjHao[5]?> </li>
                <li class="ball2 ball_03"> <?=$kjHao[6]?> </li>
                <li class="ball2 ball_04"> <?=$kjHao[7]?> </li>
                <li class="ball2 ball_01"> <?=$kjHao[8]?> </li>
                <li class="ball2 ball_02"> <?=$kjHao[9]?> </li>
             </ul>
              <div class="clear"></div>
          </div>  
		  
	  </div>
      <div class="content07" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
      </div>

	  <?php }else if($types[$this->type]['type']==8) { //快8
	 	  $kjHaoS=explode("|",$kjHao[19]);
	 	  $kjHao[19]=$kjHaoS[0];
		  $feipan=$kjHaoS[1];
	    ?>
       <td width="480" class="game_top_aright"> 
	    <div class="kj-bottom"><span class="tit"><span class='gamename'><?=$types[$this->type]['title']?></span> &nbsp;&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay">开奖倒计时：<em class="kjtips">00:00</em></span> <span class="feipan">快乐飞盘：<em><?=$feipan?></em></span></span><img id="voice" class="voice-on"  title="声音开启，点击关闭" onclick="voiceKJ()"><span id="lockgame"></span><div class="clear"></div></div>
          <div class="grid_code_tl wjkjData" >
          	  <p class="hide"><img src="/images/common/kjts.png" /></p>
              <ul class="kj-hao" ctype="g1" cnum="80" style="margin-left:20px;">
                    <li id="span_lot_0" class="gr_s gr_s020"> <?=$kjHao[0]?> </li>
                    <li id="span_lot_1" class="gr_s gr_s020"> <?=$kjHao[1]?> </li>
                    <li id="span_lot_2" class="gr_s gr_s020"> <?=$kjHao[2]?> </li>
                    <li id="span_lot_3" class="gr_s gr_s020"> <?=$kjHao[3]?> </li>
                    <li id="span_lot_4" class="gr_s gr_s020"> <?=$kjHao[4]?> </li>
                    <li id="span_lot_5" class="gr_s gr_s020"> <?=$kjHao[5]?> </li>
                    <li id="span_lot_6" class="gr_s gr_s020"> <?=$kjHao[6]?> </li>
                    <li id="span_lot_7" class="gr_s gr_s020"> <?=$kjHao[7]?> </li>
                    <li id="span_lot_8" class="gr_s gr_s020"> <?=$kjHao[8]?> </li>
                    <li id="span_lot_9" class="gr_s gr_s020"> <?=$kjHao[9]?> </li>
                    <li id="span_lot_10" class="gr_s gr_s020"> <?=$kjHao[10]?> </li>
                    <li id="span_lot_11" class="gr_s gr_s020"> <?=$kjHao[11]?> </li>
                    <li id="span_lot_12" class="gr_s gr_s020"> <?=$kjHao[12]?> </li>
                    <li id="span_lot_13" class="gr_s gr_s020"> <?=$kjHao[13]?> </li>
                    <li id="span_lot_14" class="gr_s gr_s020"> <?=$kjHao[14]?> </li>
                    <li id="span_lot_15" class="gr_s gr_s020"> <?=$kjHao[15]?> </li>
                    <li id="span_lot_16" class="gr_s gr_s020"> <?=$kjHao[16]?> </li>
                    <li id="span_lot_17" class="gr_s gr_s020"> <?=$kjHao[17]?> </li>
                    <li id="span_lot_18" class="gr_s gr_s020"> <?=$kjHao[18]?> </li>
                    <li id="span_lot_19" class="gr_s gr_s020"> <?=$kjHao[19]?> </li>
                  </ul>
              <div class="clear"></div>
           </div> 
             
	  </td>
     <?php }else if($types[$this->type]['type']==9) { //快3?>
	<div class="content05">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay" class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on" title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>  
            <div class="wjkjData" >
              	<div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
              	<ul class="kj-hao" ctype="k3">
                    <li class="ball ball_0"><?=intval($kjHao[0])?> </li>
                    <li class="ball ball_1"><?=intval($kjHao[1])?> </li>
                    <li class="ball ball_2"><?=intval($kjHao[2])?> </li>
                 </ul>
              <div class="clear"></div>
           </div>
	</div>	   
	   <div class="content03" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
       </div>

	   </td>
     <?php }else if($types[$this->type]['type']==10) { //lhc?>
	<div class="content04">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay" class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on" title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>  
            <div class="wjkjData" >
              	<div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
              	<ul class="kj-hao" ctype="lhc">
				    <li class="ball2 ball_0000"> <?=$kjHao[0]?> </li>
				    <li class="ball2 ball_04"> <?=$kjHao[0]?> </li>
                    <li class="ball2 ball_04"> <?=$kjHao[1]?> </li>
                    <li class="ball2 ball_04"> <?=$kjHao[2]?> </li>
                    <li class="ball2 ball_04"> <?=$kjHao[3]?> </li>
				    <li class="ball2 ball_04"> <?=$kjHao[4]?> </li>
                    <li class="ball2 ball_04"> <?=$kjHao[5]?> </li>
					<li class="ball2 ball_02"> <?=$kjHao[6]?> </li>
                 </ul>
              <div class="clear"></div>
          </div>  
		  
	  </div>
      <div class="content07" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
      </div>

	   <?php }else if($types[$this->type]['type']==3) { //3D?>
      <div class="content05">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay" class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on" title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>  
            <div class="wjkjData" >
              	<div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
              	<ul class="kj-hao" ctype="3d">
                    <li class="ball ball_0"><?=intval($kjHao[0])?> </li>
                    <li class="ball ball_1"><?=intval($kjHao[1])?> </li>
                    <li class="ball ball_2"><?=intval($kjHao[2])?> </li>
                  </ul>
              <div class="clear"></div>
           </div>
       
	   </div>
	   <div class="content03" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
       </div>

      <?php }else if($types[$this->type]['type']==2) { //11选5?>
      <div class="content04">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?>&nbsp;第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay" class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on" title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>  
            <div class="wjkjData" >
              	<div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
              	<ul class="kj-hao" ctype="11x5">
                    <li class="ball ball_0"><?=intval($kjHao[0])?> </li>
                    <li class="ball ball_1"><?=intval($kjHao[1])?> </li>
                    <li class="ball ball_2"><?=intval($kjHao[2])?> </li>
                    <li class="ball ball_3"><?=intval($kjHao[3])?> </li>
                    <li class="ball ball_4"><?=intval($kjHao[4])?> </li>
                  </ul>
              <div class="clear"></div>
          </div>  
		  
	  </div>
      <div class="content07" id="historylot">
        <?php  $this->display('index/inc_data_history.php'); ?>
      </div>

      
 	<?php }else{  ?>
       
        <div class="content04">
	    <p class="kj-bottom"><?=$types[$this->type]['title']?> 第 <span class="last_issues"><?=$lastNo['actionNo']?></span> 期  <span id="kjsay" class="hide">开奖倒计时：<em class="kjtips">00:00</em></span><span id="voice" class="voice-on"  title="声音开启，点击关闭" onclick="voiceKJ()"></span></p>  
            <div class="wjkjData" >
              	  <div class="kjing hide"><img src="/skin/images/chengxin.png" alt="" /></div>
                  <ul class="kj-hao" ctype="ssc">
                    <li class="ball ball_0"><?=intval($kjHao[0])?> </li>
                    <li class="ball ball_1"><?=intval($kjHao[1])?> </li>
                    <li class="ball ball_2"><?=intval($kjHao[2])?> </li>
                    <li class="ball ball_3"><?=intval($kjHao[3])?> </li>
                    <li class="ball ball_4"><?=intval($kjHao[4])?> </li>
                  </ul>
                  <div class="clear"></div>
            </div>   
          </div>
		<div class="content03" id="historylot">		  
        <?php  $this->display('index/inc_data_history.php'); ?>
        </div>
      
    <?php }?>

    <?php if($types[$this->type]['type']==8) {?>
	<div style="padding:3px 5px;border:1px solid #cccccc; margin-top:10px;" id="historylot" class="game_top_period">
        <?php  $this->display('index/inc_data_history.php'); ?>
    </div>
   <?php }?>
<script type="text/javascript">
$(function(){
	window.S=<?=json_encode($diffTime>0)?>;
	window.KS=<?=json_encode($kjDiffTime>0)?>;
	window.kjTime=parseInt(<?=json_encode($kjdTime)?>);
	
	if($.browser.msie){
		window.diffTime=<?=$diffTime?>;
		setTimeout(function(){
			gameKanJiangDataC(<?=$diffTime?>);
		}, 1000);
	}else{
		setTimeout(gameKanJiangDataC, 1000, <?=$diffTime?>);
	}
	<?php if($kjDiffTime>0){ ?> 
		if($.browser.msie){
		setTimeout(function(){
			setKJWaiting(<?=$kjDiffTime?>);
		}, 1000);
		}else{
			setTimeout(setKJWaiting, 1000, <?=$kjDiffTime?>);
		}
	<?php } ?> 
	
	<?php if(!$kjHao){ ?> 
		loadKjData();
	<?php } ?> 
});
</script>