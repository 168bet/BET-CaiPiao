<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_PATH?>reset.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_PATH.SYS_STYLE;?>-system.css" rel="stylesheet" type="text/css" />
        <style>
            *{margin:0;padding:0;}
            .wrap{width:100%;height:100%;padding:20px;margin:0 auto;font-size:12px;}
            .wrap h2,.wrap p{margin:10px 0;}
            .form-type{width:100%;height:40px;line-height:40px;margin:10px 0;}
            .form-type .selTitle{float:left;margin-left: 20px;}
            .form-type .nav-tabs{list-style: none;float:left;border:none;margin-top:8px;}
            .topItems{height:24px;line-height:24px;border-radius:4px;border:1px solid #ddd;
                text-align: center;margin-left:10px;background: #fff;padding:0 5px;}
            .form-type .nav-tabs li{list-style: none;}
            .form-type .nav-tabs li.active{border: 1px solid #ffa21d;}
            .form-type .nav-tabs li.active a{color:#ffa21d;}
            .form-type .nav-tabs li a{color:#555;border:none;}
            .form-type .nav-tabs li a:hover,.form-type .nav-tabs li a,.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
                border:none;
            }
            .form-type .form-select .select{display:inline-block;margin-left:20px;}
            .table{width:100%;min-width:100%;}
            .table thead tr td{text-align: center;}
            .table tbody tr td{border-top:1px solid #ddd;height:35px;line-height:35px;text-align: center;vertical-align: middle;}
            .table tr td:first-child{border:none;}
            .relate{height:40px;width:100%;}
            .relate button{height:24px;line-height: 24px;width:80px;border:1px solid #ccc;text-align: center;margin-left:30px;background: #fff;border-radius:4px;}
        </style>
    </head>
    <body>
        <div class="wrap">
            <h2><?php echo $title ?></h2>
            <?php
                if (count($content_data)) {
                    foreach ($content_data as $data) {
                        ?>
            <p>当前关联赛事：<span class="teamFir"><?php echo $data['leaguename']?>&nbsp;&nbsp;&nbsp;</span><?php echo $data['homename_s']?>vs <span class="teamSec"><?php echo $data['awayname_s']?></span><span class="completeTime"><?php echo format::date($data['date'], 1); ?></span></p>
                        <?php
                    }
                }
            ?>
           
			<div class="form-type">
				 <form  name="connect_form" id="connect_form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-select">
                            联赛名称<input type="text" value="<?php echo $_POST['competitionshortname'] ?>" name="competitionshortname" style="width:80px">
                            主队 <input type="text" value="<?php echo $_POST['homeshortname'] ?>"  name="homeshortname"style="width:80px">
                            客队 <input type="text" value="<?php echo $_POST['awayshortname'] ?>"  name="awayshortname" style="width:80px">
                            日期：
							<?php echo form::date('start_time', $_POST['start_time'], 0, 0, 'false'); ?>- &nbsp;<?php echo form::date('end_time', $_POST['end_time'], 0, 0, 'false'); ?>
<!--                                <input name="keyword" type="text" value="<?php if (isset($keyword)) echo $keyword; ?>" class="input-text" />-->
                            <input type="submit" name="search"  value="提交"  onclick="connect_form.action='?m=sportsdata&c=football_admin&a=connect_games&id=<?php echo $id;?>';connect_form.submit();">
                        </div>
                    </div>
					<input type="hidden" id="dosubmit" name="dosubmit" value="true">
					
				</form>
                    <div class="tab-content">
                        <div id="jrss" class="tab-pane active in fade">
                            <table class="table" id="start-table">
                                <tbody>
                                    <?php
                                        if (count($live_game_data)) {
                                            foreach ($live_game_data as $data) {
                                                ?>
                                                <tr>
                                                    <td><input type="checkbox" name="ids[]"  <?php if($data['gameid'] == $content_data_gameid){ echo 'checked';}?> value =<?php echo $data['gameid']?>></td>
                                                    <td><span class="team"><?php echo $data['competitionshortname'] ?>|</span><span class="time"><?php echo format::date($data['date'], 1); ?></span></td>
                                                    <td><?php echo str_cut($data['homeshortname'], 24, '...') ?><span>[<?php echo $data['homerank'] ?>]</span></td>
                                                    <td><?php echo $data['homescore'] ?>-<?php echo $data['awayscore'] ?></td>
                                                    <td><?php echo str_cut($data['awayshortname'], 24, '...') ?><span>[<?php echo $data['awayrank'] ?>]</span></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="relate">
                                <button id="sure_brn" onclick='connect("<?php echo $id;?>");'/>确定关联</button>
                                <button onclick='cancel_connect("<?php echo $id;?>");'>清除关联</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
		<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
		<script>
			function connect(e){ // 确定关联
				var str =0;
				var gamesid = tag = '';
				$("input[name='ids[]']").each(function() {
					if($(this).attr('checked')=='checked') {
						str = 1;
						gamesid += tag+$(this).val();
						tag = '|';
					}
				});
				if(str==0) {
					alert('<?php echo '请选择关联赛事'; ?>');
					return false;
				}
				

               $.post('?m=sportsdata&c=football_admin&a=insert_conect_info&gamesid='+gamesid+'&id='+e,function(a){
			
				   var obj =JSON.parse(a);
			      if(obj.result == 1){ // 插入成功
					 
				  }else {
					 
				  }
	             alert(obj.message);
	          });
			}
			// 清除全部关联
			function cancel_connect(e){
				
				 $.post('?m=sportsdata&c=football_admin&a=delete_all_conect_info&id='+e,function(a){
			       var obj =JSON.parse(a);
			      if(obj.result == 1){ // 插入成功
					 
				  }else {
					 
				  }
	             alert(obj.message);
	
	          });
			}

		</script>
    </body>
	
</html>
