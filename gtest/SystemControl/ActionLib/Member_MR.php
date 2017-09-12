<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $Users, $LoginId;
if ($Users[0]['g_login_id'] != 89) if ($Users[0]['g_lock'] == 2)
exit(back($UserOut)); //帳號已被凍結

//子帳號
if (isset($Users[0]['g_lock_2'])){
	if ( $Users[0]['g_s_lock'] == 2 || $Users[0]['g_lock_2'] != 1)
		exit(back($UserOut)); //帳號已被凍結
}

$userModel = new UserModel();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST['name'];
	$typeida = $_POST['typeida'];
	$typeidb = $_POST['typeidb'];
	$typeidc = $_POST['typeidc'];
	$typeid="";
	
	$memberModel = $userModel->GetMemberModel($name);
	if ($memberModel)
	{
		if ($memberModel[0]['g_mumber_type'] == 2){
			$nid = mb_substr($memberModel[0]['g_nid'], 0, mb_strlen($memberModel[0]['g_nid'])-32);
		}else {
			$nid = $memberModel[0]['g_nid'];
		}
		$Lname = $userModel->GetUserName_Like($nid);
		if ($Lname[0]['g_lock'] != 1) {
			exit(back('更變權限不足！'));
		}
		$Lname = $Lname[0]['g_name'];
		if(isset($typeida)&&$typeida!=""){
		$typeidtemp = strtolower($typeida);
		$typeid = $typeid."g_{$typeidtemp}_limit";
		}
		if(isset($typeidb)&&$typeidb!=""){
		$typeidtemp = strtolower($typeidb);
		if($typeid=="") $typeid =  $typeid."g_{$typeidtemp}_limit";
		else $typeid =  $typeid.",g_{$typeidtemp}_limit";
		}
		if(isset($typeidc)&&$typeidc!=""){
		$typeidtemp = strtolower($typeidc);
		if($typeid=="") $typeid =  $typeid."g_{$typeidtemp}_limit";
		else $typeid =  $typeid.",g_{$typeidtemp}_limit";
		}
		$db = new DB();
		//讀取上級退水盤

		$LdetList = $db->query("SELECT `g_type`, `g_d_limit`, `g_e_limit`, `g_game_id`,g_a_limit,g_b_limit,g_c_limit FROM `g_send_back` WHERE g_name = '{$Lname}' and g_game_id = '1'  ORDER BY g_id DESC", 0);
		for ($i=0; $i<count($LdetList); $i++) {
			$aList = $_POST['RebateAG'.($i+1)];
			$gbList = $_POST['RebateBG'.($i+1)];
			$gcList = $_POST['RebateCG'.($i+1)];
			$bList = $_POST['RebateEG'.($i+1)];
			$cList = $_POST['RebateFG'.($i+1)];
			if($aList!=""){
			if ($aList > 100) exit(back(' 退水最高不超过：100'));}
			if($gbList!=""){
			if ($gbList > 100) exit(back(' 退水最高不超过：100'));}
			if($gcList!=""){
			if ($gcList > 100) exit(back(' 退水最高不超过：100'));}
	
			
			//修改退水
			$sql = "UPDATE `g_panbiao` SET g_id=g_id , ";
			if($aList!=""){$sql.="`g_panlu_a` = '{$aList}',";}
			if($gbList!=""){$sql.="`g_panlu_b` = '{$gbList}',";}
			if($gcList!=""){$sql.="`g_panlu_c` = '{$gcList}',";}
			$sql.="`g_danzhu` = '{$bList}', `g_danxiang` = '{$cList}' WHERE `g_nid` = '{$memberModel[0]['g_name']}' AND g_type = '{$LdetList[$i][0]}' AND g_game_id = '{$LdetList[$i][3]}' LIMIT 1";
			$db->query($sql, 2);
		}
		//重庆
		$LdetListc = $db->query("SELECT `g_type`, `g_d_limit`, `g_e_limit`, `g_game_id`,g_a_limit,g_b_limit,g_c_limit FROM `g_send_back` WHERE g_name = '{$Lname}' and g_game_id = '2'  ORDER BY g_id DESC", 0);
		for ($i=0; $i<count($LdetListc); $i++) {
			$aList = $_POST['RebateAC'.($i+1)];
			$gbList = $_POST['RebateBC'.($i+1)];
			$gcList = $_POST['RebateCC'.($i+1)];
			$bList = $_POST['RebateEC'.($i+1)];
			$cList = $_POST['RebateFC'.($i+1)];
			if($aList!=""){
			if ($aList > 100) exit(back(' 退水最高不超过：100'));}
			if($gbList!=""){
			if ($gbList > 100) exit(back(' 退水最高不超过：100'));}
			if($gcList!=""){
			if ($gcList > 100) exit(back(' 退水最高不超过：100'));}
	
			
			//修改退水
			$sql = "UPDATE `g_panbiao` SET g_id=g_id , ";
			if($aList!=""){$sql.="`g_panlu_a` = '{$aList}',";}
			if($gbList!=""){$sql.="`g_panlu_b` = '{$gbList}',";}
			if($gcList!=""){$sql.="`g_panlu_c` = '{$gcList}',";}
			$sql.="`g_danzhu` = '{$bList}', `g_danxiang` = '{$cList}' WHERE `g_nid` = '{$memberModel[0]['g_name']}' AND g_type = '{$LdetListc[$i][0]}' AND g_game_id = '{$LdetListc[$i][3]}' LIMIT 1";
			$db->query($sql, 2);
		}
		
		//农场
		$LdetListx = $db->query("SELECT `g_type`, `g_d_limit`, `g_e_limit`, `g_game_id`,g_a_limit,g_b_limit,g_c_limit FROM `g_send_back` WHERE g_name = '{$Lname}' and g_game_id = '5'  ORDER BY g_id DESC", 0);
		for ($i=0; $i<count($LdetListx); $i++) {
			$aList = $_POST['RebateAX'.($i+1)];
			$gbList = $_POST['RebateBX'.($i+1)];
			$gcList = $_POST['RebateCX'.($i+1)];
			$bList = $_POST['RebateEX'.($i+1)];
			$cList = $_POST['RebateFX'.($i+1)];
			if($aList!=""){
			if ($aList > 100) exit(back(' 退水最高不超过：100'));}
			if($gbList!=""){
			if ($gbList > 100) exit(back(' 退水最高不超过：100'));}
			if($gcList!=""){
			if ($gcList > 100) exit(back(' 退水最高不超过：100'));}
	
			
			//修改退水
			$sql = "UPDATE `g_panbiao` SET g_id=g_id , ";
			if($aList!=""){$sql.="`g_panlu_a` = '{$aList}',";}
			if($gbList!=""){$sql.="`g_panlu_b` = '{$gbList}',";}
			if($gcList!=""){$sql.="`g_panlu_c` = '{$gcList}',";}
			$sql.="`g_danzhu` = '{$bList}', `g_danxiang` = '{$cList}' WHERE `g_nid` = '{$memberModel[0]['g_name']}' AND g_type = '{$LdetListx[$i][0]}' AND g_game_id = '{$LdetListx[$i][3]}' LIMIT 1";
			$db->query($sql, 2);
		}
		
		//PK
		$LdetListb = $db->query("SELECT `g_type`, `g_d_limit`, `g_e_limit`, `g_game_id`,g_a_limit,g_b_limit,g_c_limit FROM `g_send_back` WHERE g_name = '{$Lname}' and g_game_id = '6'  ORDER BY g_id DESC", 0);
		for ($i=0; $i<count($LdetList); $i++) {
			$aList = $_POST['RebateAB'.($i+1)];
			$gbList = $_POST['RebateBB'.($i+1)];
			$gcList = $_POST['RebateCB'.($i+1)];
			$bList = $_POST['RebateEB'.($i+1)];
			$cList = $_POST['RebateFB'.($i+1)];
			if($aList!=""){
			if ($aList > 100) exit(back(' 退水最高不超过：100'));}
			if($gbList!=""){
			if ($gbList > 100) exit(back(' 退水最高不超过：100'));}
			if($gcList!=""){
			if ($gcList > 100) exit(back(' 退水最高不超过：100'));}
	
			
			//修改退水
			$sql = "UPDATE `g_panbiao` SET g_id=g_id , ";
			if($aList!=""){$sql.="`g_panlu_a` = '{$aList}',";}
			if($gbList!=""){$sql.="`g_panlu_b` = '{$gbList}',";}
			if($gcList!=""){$sql.="`g_panlu_c` = '{$gcList}',";}
			$sql.="`g_danzhu` = '{$bList}', `g_danxiang` = '{$cList}' WHERE `g_nid` = '{$memberModel[0]['g_name']}' AND g_type = '{$LdetListb[$i][0]}' AND g_game_id = '{$LdetListb[$i][3]}' LIMIT 1";
			$db->query($sql, 2);
		}
		//江苏
		$LdetListj = $db->query("SELECT `g_type`, `g_d_limit`, `g_e_limit`, `g_game_id`,g_a_limit,g_b_limit,g_c_limit FROM `g_send_back` WHERE g_name = '{$Lname}' and g_game_id = '7'  ORDER BY g_id DESC", 0);
		for ($i=0; $i<count($LdetList); $i++) {
			$aList = $_POST['RebateAJ'.($i+1)];
			$gbList = $_POST['RebateBJ'.($i+1)];
			$gcList = $_POST['RebateCJ'.($i+1)];
			$bList = $_POST['RebateEJ'.($i+1)];
			$cList = $_POST['RebateFJ'.($i+1)];
			if($aList!=""){
			if ($aList > 100) exit(back(' 退水最高不超过：100'));}
			if($gbList!=""){
			if ($gbList > 100) exit(back(' 退水最高不超过：100'));}
			if($gcList!=""){
			if ($gcList > 100) exit(back(' 退水最高不超过：100'));}
	
			
			//修改退水
			$sql = "UPDATE `g_panbiao` SET g_id=g_id , ";
			if($aList!=""){$sql.="`g_panlu_a` = '{$aList}',";}
			if($gbList!=""){$sql.="`g_panlu_b` = '{$gbList}',";}
			if($gcList!=""){$sql.="`g_panlu_c` = '{$gcList}',";}
			$sql.="`g_danzhu` = '{$bList}', `g_danxiang` = '{$cList}' WHERE `g_nid` = '{$memberModel[0]['g_name']}' AND g_type = '{$LdetListj[$i][0]}' AND g_game_id = '{$LdetListj[$i][3]}' LIMIT 1";
			$db->query($sql, 2);
		}
		
		exit(alert_href('更變成功', 'Actfor.php?cid='.$_GET['cid']));
	}
	else 
	{
		exit(alert_href('用戶不存在', 'Actfor.php?cid='.$_GET['cid']));
	}
}
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['uid']) && isset($_GET['cid']))
{
	if (!Matchs::isString($_GET['uid'], 3, 15)) exit(alert_href('用戶名不合法', 'Actfor.php?cid='.$_GET['cid']));
	$cid = $_GET['cid'];
	$uid = $_GET['uid'];
	

	//判斷當前用戶是否存在、檢查當前用戶是否已有未結算注單。
	$memberModel = $userModel->GetMemberModel($uid);
	if ($memberModel)
	{
	    if ($memberModel[0]['g_mumber_type'] == 2){
			$nid = mb_substr($memberModel[0]['g_nid'], 0, mb_strlen($memberModel[0]['g_nid'])-32);
		}else {
			$nid = $memberModel[0]['g_nid'];
		}
		$Lname = $userModel->GetUserName_Like($nid);
		$sjuid=$Lname[0]['g_name'];
		//dump($sjuid);
		$detModel = new Detailed();
		$dets = $detModel->GetDetailedsAll($uid);
		
		$memberDetList = $userModel->GetUserMR($uid, true);
		$memberDetListC = $userModel->GetUserMRC($uid, true);
		$memberDetListB = $userModel->GetUserMRP($uid, true);
		$memberDetListJ = $userModel->GetUserMRJ($uid, true);
		$memberDetListX = $userModel->GetUserMRX($uid, true);
		
		$memberDetLists = $userModel->GetUserMR($sjuid);
	    $memberDetListCs = $userModel->GetUserMRC($sjuid);
	    $memberDetListBs = $userModel->GetUserMRP($sjuid);
	    $memberDetListJs = $userModel->GetUserMRJ($sjuid);
		$memberDetListXs = $userModel->GetUserMRX($sjuid);
		
		//dump($memberDetLists);
	}
}

?>
<html>
<head><title>

</title><link href="/Css/Common.css" rel="stylesheet" type="text/css" />
<link href="/Css/Style.css" rel="stylesheet" type="text/css" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Scripts/Jquery.js"></script>
<script type="text/javascript" src="/Scripts/Common.js"></script>
<script type="text/javascript" src="/Scripts/PublicData.js"></script>
<script type="text/javascript" src="/Scripts/Forbid.js"></script>
<script type="text/javascript">
<!--
    $(function () {
        <?php $P = $memberModel[0]['g_panlus'];?>
         <?php if(strstr($P,'A')!=''){?>
        $("#TS1_A1").val($("#RebateAG1").val());
         <?php }else if(strstr($P,'B')!=''){?>
		 $("#TS1_A2").val($("#RebateBG1").val());
		  <?php }else if(strstr($P,'C')!=''){?>
		  $("#TS1_A3").val($("#RebateCG1").val());
		 <?php }?>
        $("#TS1_A4").val($("#RebateEG1").val());
        $("#TS1_A5").val($("#RebateFG1").val());

          <?php  if(strstr($P,'A')!=''){?>
        $("#TS2_A1").val($("#RebateAG9").val());
          <?php }else if(strstr($P,'B')!=''){?>
		      $("#TS2_A2").val($("#RebateBG9").val());
		    <?php }else if(strstr($P,'C')!=''){?>
			
			    $("#TS2_A3").val($("#RebateCG9").val());
		 <?php }?>	
        $("#TS2_A4").val($("#RebateEG9").val());
        $("#TS2_A5").val($("#RebateFG9").val());
  <?php  if(strstr($P,'A')!=''){?>
       
        $("#TS3_A1").val($("#RebateAG19").val());
          <?php } else if(strstr($P,'B')!=''){?>
		  $("#TS3_A2").val($("#RebateBG19").val());
		    <?php  }else if(strstr($P,'C')!=''){?>
		$("#TS3_A3").val($("#RebateCG19").val());
		 <?php }?>
        $("#TS3_A4").val($("#RebateEG19").val());
        $("#TS3_A5").val($("#RebateFG19").val());

    });
    function isCompare(obj, s, v, sint, className) {
        var sR = document.getElementById("s" + obj.id).value;
        if (!Base.patrn.Decimal.exec(obj.value) || parseFloat(obj.value) < parseFloat(sR)) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 限制退水設置：" + sR);
            obj.focus();
            return false;
        } else if (parseFloat(obj.value) > 100) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 退水設置已超出限定：100%");
            obj.focus();
            return false;
        } else {
            $(".input2").attr("disabled", "");
        }
        if (sint != undefined && className != undefined) {
            if (sint == 1) {
                $("." + className).val(obj.value);
            } 
        }
    }

    function isCompares(obj, s, v, sint, className) {
        var sR = document.getElementById("s" + obj.id).value;
        if (!Base.patrn.Decimal.exec(obj.value) || parseFloat(obj.value) > parseFloat(sR)) {
            $(".input2").attr("disabled", "disabled");
            alert(s + " " + v + " 設置最大值：" + sR);
            obj.focus();
            return false;
        } else {
            $(".input2").attr("disabled", "");
        }
        if (sint == 1) {
            $("." + className).val(obj.value);
        }
    }

    function showTD(strID, classID) {
        $("."+classID).css("display", "none");
        $("#"+strID).css("display", "");
    }

    function isMethod() {
        if (confirm("確定更改退水設置嗎？")) {
            $("#submit").attr("disabled","disabled");
            return true;
        }
        return false;
    }
    function Comparec() {
         <?php  if(strstr($P,'A')!=''){?>
        var A = parseFloat($("#TS3_A1").val());
         <?php  }else if(strstr($P,'B')!=''){?>
		  var B = parseFloat($("#TS3_A2").val());
		  <?php  }else if(strstr($P,'C')!=''){?>
		   var C = parseFloat($("#TS3_A3").val());
		  <?php }?>
        var E = parseInt($("#TS3_A4").val());
        var F = parseInt($("#TS3_A5").val());
        for (var i = 1; i <= 26; i++) {
		if (i == 3 || i == 5|| i==6 || i==7 ) {
		 <?php  if(strstr($P,'A')!=''){?>
                $("#RebateAJ"+i).val(A > parseFloat($("#sRebateAJ"+i).val()) ? A : $("#sRebateAJ"+i).val()).addClass("inp1m");
				  <?php  } else if(strstr($P,'B')!=''){?>
                $("#RebateBJ"+i).val(B > parseFloat($("#sRebateBJ"+i).val()) ? B : $("#sRebateBJ"+i).val()).addClass("inp1m");
				  <?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCJ"+i).val(C > parseFloat($("#sRebateCJ"+i).val()) ? C : $("#sRebateCJ"+i).val()).addClass("inp1m");
				  <?php }?>
                $("#RebateEJ"+i).val(E < parseFloat($("#sRebateEJ"+i).val()) ? E : $("#sRebateEJ"+i).val()).addClass("inp1m");
                $("#RebateFJ"+i).val(F < parseFloat($("#sRebateFJ"+i).val()) ? F : $("#sRebateFJ"+i).val()).addClass("inp1m");
            } else if (i >= 19) {
			 <?php  if(strstr($P,'A')!=''){?>
                $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
				
				$("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
                  <?php  } else if(strstr($P,'B')!=''){?>
				$("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
				
				$("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
                <?php  }else if(strstr($P,'C')!=''){?>
			    $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
				
				$("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
                <?php }?>
			    $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				
				$("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
            }
            
        }
    }
    function Compareb() {
	<?php  if(strstr($P,'A')!=''){?>
        var A = parseFloat($("#TS2_A1").val());
		 <?php  }else if(strstr($P,'B')!=''){?>
        var B = parseFloat($("#TS2_A2").val());
		  <?php  }else if(strstr($P,'C')!=''){?>
        var C = parseFloat($("#TS2_A3").val());

          <?php }?>
        var E = parseInt($("#TS2_A4").val());
        var F = parseInt($("#TS2_A5").val());
        for (var i = 1; i <= 31; i++) {
             if (i == 1 || i == 2) {
			 <?php  if(strstr($P,'A')!=''){?>
                $("#RebateAJ"+i).val(A > parseFloat($("#sRebateAJ"+i).val()) ? A : $("#sRebateAJ"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'B')!=''){?>
                $("#RebateBJ"+i).val(B > parseFloat($("#sRebateBJ"+i).val()) ? B : $("#sRebateBJ"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCJ"+i).val(C > parseFloat($("#sRebateCJ"+i).val()) ? C : $("#sRebateCJ"+i).val()).addClass("inp1m");
				 <?php }?>
                $("#RebateEJ"+i).val(E < parseFloat($("#sRebateEJ"+i).val()) ? E : $("#sRebateEJ"+i).val()).addClass("inp1m");
                $("#RebateFJ"+i).val(F < parseFloat($("#sRebateFJ"+i).val()) ? F : $("#sRebateFJ"+i).val()).addClass("inp1m");
            }
            if (i == 11 || i == 12 || i == 13 || i == 14 || i == 15) {
			<?php  if(strstr($P,'A')!=''){?>
                $("#RebateAB"+i).val(A > parseFloat($("#sRebateAB"+i).val()) ? A : $("#sRebateAB"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'B')!=''){?>
                $("#RebateBB"+i).val(B > parseFloat($("#sRebateBB"+i).val()) ? B : $("#sRebateBB"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCB"+i).val(C > parseFloat($("#sRebateCB"+i).val()) ? C : $("#sRebateCB"+i).val()).addClass("inp1m");
				 <?php }?>
                $("#RebateEB"+i).val(E < parseFloat($("#sRebateEB"+i).val()) ? E : $("#sRebateEB"+i).val()).addClass("inp1m");
                $("#RebateFB"+i).val(F < parseFloat($("#sRebateFB"+i).val()) ? F : $("#sRebateFB"+i).val()).addClass("inp1m");
            }
            if (i >= 6 && i <= 8) {
                 <?php  if(strstr($P,'A')!=''){?>
                $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
					 <?php  }else if(strstr($P,'B')!=''){?>
                $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
				 <?php }?>
                $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
				
            } else if (i >= 9 && i <= 12 || i >= 15 && i <= 18 || i>=27 && i<=31) {
			 <?php  if(strstr($P,'A')!=''){?>
                  $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
				  
				  $("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
				  	 <?php  }else if(strstr($P,'B')!=''){?>
                $("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
				
				    $("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
				
				$("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
				 <?php }?>
                $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				 $("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
                if ( i== 9 || i == 10) {
				 <?php  if(strstr($P,'A')!=''){?>
                    $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
						 <?php  }else if(strstr($P,'B')!=''){?>
                    $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
					 <?php  }else if(strstr($P,'C')!=''){?>
                    $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
					 <?php }?>
                    $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                    $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
                }
            }
        }
    }

    function Comparer() {
	    <?php  if(strstr($P,'A')!=''){?>
        var A = parseFloat($("#TS1_A1").val());
		 <?php  }else if(strstr($P,'B')!=''){?>
        var B = parseFloat($("#TS1_A2").val());
		 <?php  }else if(strstr($P,'C')!=''){?>
        var C = parseFloat($("#TS1_A3").val());
        <?php }?>
        var E = parseInt($("#TS1_A4").val());
        var F = parseInt($("#TS1_A5").val());
        for (var i = 1; i <= 10; i++) {
            if (i <= 8) {
                if (i <= 5) {
				<?php  if(strstr($P,'A')!=''){?>
                    $("#RebateAC"+i).val(A > parseFloat($("#sRebateAC"+i).val()) ? A : $("#sRebateAC"+i).val()).addClass("inp1m");
					 <?php  }else if(strstr($P,'B')!=''){?>
                    $("#RebateBC"+i).val(B > parseFloat($("#sRebateBC"+i).val()) ? B : $("#sRebateBC"+i).val()).addClass("inp1m");
					<?php  }else if(strstr($P,'C')!=''){?>
                    $("#RebateCC"+i).val(C > parseFloat($("#sRebateCC"+i).val()) ? C : $("#sRebateCC"+i).val()).addClass("inp1m");
					   <?php }?>
                    $("#RebateEC"+i).val(E < parseFloat($("#sRebateEC"+i).val()) ? E : $("#sRebateEC"+i).val()).addClass("inp1m");
                    $("#RebateFC"+i).val(F < parseFloat($("#sRebateFC"+i).val()) ? F : $("#sRebateFC"+i).val()).addClass("inp1m");
                }
				<?php  if(strstr($P,'A')!=''){?>
                $("#RebateAG"+i).val(A > parseFloat($("#sRebateAG"+i).val()) ? A : $("#sRebateAG"+i).val()).addClass("inp1m");
				
				$("#RebateAX"+i).val(A > parseFloat($("#sRebateAX"+i).val()) ? A : $("#sRebateAX"+i).val()).addClass("inp1m");
				 <?php  }else if(strstr($P,'B')!=''){?>
                $("#RebateBG"+i).val(B > parseFloat($("#sRebateBG"+i).val()) ? B : $("#sRebateBG"+i).val()).addClass("inp1m");
				
				$("#RebateBX"+i).val(B > parseFloat($("#sRebateBX"+i).val()) ? B : $("#sRebateBX"+i).val()).addClass("inp1m");
				<?php  }else if(strstr($P,'C')!=''){?>
                $("#RebateCG"+i).val(C > parseFloat($("#sRebateCG"+i).val()) ? C : $("#sRebateCG"+i).val()).addClass("inp1m");
				
				 $("#RebateCX"+i).val(C > parseFloat($("#sRebateCX"+i).val()) ? C : $("#sRebateCX"+i).val()).addClass("inp1m");
				   <?php }?>
                $("#RebateEG"+i).val(E < parseFloat($("#sRebateEG"+i).val()) ? E : $("#sRebateEG"+i).val()).addClass("inp1m");
                $("#RebateFG"+i).val(F < parseFloat($("#sRebateFG"+i).val()) ? F : $("#sRebateFG"+i).val()).addClass("inp1m");
				
				 $("#RebateEX"+i).val(E < parseFloat($("#sRebateEX"+i).val()) ? E : $("#sRebateEX"+i).val()).addClass("inp1m");
                $("#RebateFX"+i).val(F < parseFloat($("#sRebateFX"+i).val()) ? F : $("#sRebateFX"+i).val()).addClass("inp1m");
            }
            <?php  if(strstr($P,'A')!=''){?>
            $("#RebateAB"+i).val(A > parseFloat($("#sRebateAB"+i).val()) ? A : $("#sRebateAB"+i).val()).addClass("inp1m");
			 <?php  }else if(strstr($P,'B')!=''){?>
            $("#RebateBB"+i).val(B > parseFloat($("#sRebateBB"+i).val()) ? B : $("#sRebateBB"+i).val()).addClass("inp1m");
			<?php  }else if(strstr($P,'C')!=''){?>
            $("#RebateCB"+i).val(C > parseFloat($("#sRebateCB"+i).val()) ? C : $("#sRebateCB"+i).val()).addClass("inp1m");
			   <?php }?>
            $("#RebateEB"+i).val(E < parseFloat($("#sRebateEB"+i).val()) ? E : $("#sRebateEB"+i).val()).addClass("inp1m");
            $("#RebateFB"+i).val(F < parseFloat($("#sRebateFB"+i).val()) ? F : $("#sRebateFB"+i).val()).addClass("inp1m");
        }
    }
    function historys() {
        location.href = "Actfor.php?cid=5";
    }
//-->
</script>
</head>
<body onselectstart="return false">
<form action="" method="post" onSubmit="return isMethod()">
<input type="hidden" name="name" value="<?php echo$memberModel[0]['g_name']?>" />

<?php $P = $memberModel[0]['g_panlus'];?>
<?php if(strstr($P,'A')!=''){echo "<input type='hidden' name='typeida' value='A' />";}?>
<?php if(strstr($P,'B')!=''){echo "<input type='hidden' name='typeidb' value='B' />";}?>
<?php if(strstr($P,'C')!=''){echo "<input type='hidden' name='typeidc' value='C' />";}?>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
          <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="16"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="774">退水設定 -> 會員（ &nbsp;&nbsp;&nbsp;<span style="font-weight:normal"><?php echo$memberModel[0]['g_name']?></span> &nbsp;&nbsp;&nbsp;）</td>
									<td id="F_Name" width="128" align="right">會員名稱：<?php echo$memberModel[0]['g_f_name']?></td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" cellpadding="0" class="Man_Conter2 az">
                <tr class="Conter_top_2">
                    <th colspan="7" background="/Css/bg_g.jpg"  style="border:none">大項快速設置【注意：設置高於上級最高限制時按最高可調】</th>
                </tr>
                <tr class="Conter_top_2 Ct">
                    <td background="/Css/bg_g.jpg" >調整項目</td>
                    
                    <td background="/Css/bg_g.jpg" width="10%"> <?php $P = $memberModel[0]['g_panlus'];?>
                                                <?php if(strstr($P,'A')!=''){echo "A盤";}?>
												<?php if(strstr($P,'B')!=''){echo "B盤";}?>
												<?php if(strstr($P,'C')!=''){echo "C盤";}?></td>
                    
                    <td background="/Css/bg_g.jpg" width="17%">單註限額</td>
                    <td background="/Css/bg_g.jpg" width="17%">單期限額</td>
                    <td background="/Css/bg_g.jpg" width="80">…</td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">特碼類(第一球、第二球、冠軍 …)</td><?php $P = $memberModel[0]['g_panlus'];?>
                    <?php  if(strstr($P,'A')!=''){?>
                      <td class="TD_TS1"><input style="width:60px;" id="TS1_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                       <?php  }else if(strstr($P,'B')!=''){?>
                    <td class="TD_TS1"><input style="width:60px;" id="TS1_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    	<?php  }else if(strstr($P,'C')!=''){?>
                    <td class="TD_TS1"><input style="width:60px;" id="TS1_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    
 <? }?>
                    
                    <td><input style="width:90px;" id="TS1_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS1_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS1"><input type="button" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Comparer()" value="修改" /></td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">兩面類(單雙、大小、龍虎 …)</td><?php $P = $memberModel[0]['g_panlus'];?>
                        <?php  if(strstr($P,'A')!=''){?>
                    <td class="TD_TS2"><input style="width:60px;" id="TS2_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                      <?php  }else if(strstr($P,'B')!=''){?>
                    <td  class="TD_TS2"><input style="width:60px;" id="TS2_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <?php  }else if(strstr($P,'C')!=''){?>
                    <td  class="TD_TS2"><input style="width:60px;" id="TS2_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                     <? }?>
                    <td><input style="width:90px;" id="TS2_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS2_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS2"><input type="button" name="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Compareb()" value="修改" /></td>
                </tr>
                <tr class="Ct" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                    <td class="t_list_tr_1_g">連碼類(任選二、任選三 …)</td><?php $P = $memberModel[0]['g_panlus'];?>
                     <?php  if(strstr($P,'A')!=''){?>
                     <td class="TD_TS3"><input style="width:60px;" id="TS3_A1" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>    <?php  }else if(strstr($P,'B')!=''){?>
                    <td class="TD_TS3"><input style="width:60px;" id="TS3_A2" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <?php  }else if(strstr($P,'C')!=''){?>
                    <td class="TD_TS3"><input style="width:60px;" id="TS3_A3" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                      <? }?>
                    <td><input style="width:90px;" id="TS3_A4" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td><input style="width:90px;" id="TS3_A5" onFocus="this.className='inp1m'" onBlur="this.className='inp1'" class='inp1' /></td>
                    <td class="TD_TS3"><input type="button" name="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="Comparec()" value="修改" /></td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">廣東快樂十分</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                
                                <td> <?php $P = $memberModel[0]['g_panlus'];?>
                                                <?php if(strstr($P,'A')!=''){echo "A盤";}?>
												<?php if(strstr($P,'B')!=''){echo "B盤";}?>
												<?php if(strstr($P,'C')!=''){echo "C盤";}?></td>
                                
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                            <?php for ($i=0;$i<1;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $memberDetList[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'A盤', '1', 'ga')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'B盤', '1', 'gb')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'C盤', '1', 'gc')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單註限額', '1', 'ge')"
                                    value='<?php echo $memberDetList[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單期限額', '1', 'gf')"
                                    value='<?php echo $memberDetList[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                          <?php for ($i=1;$i<16;$i++){?> 
                                                    <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<8){echo "1";}else if($i==12 or $i==13){echo "4";}else{echo "2";}?>"><?php echo $memberDetList[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $memberDetList[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $memberDetList[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
           
                      
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                
                                <td> <?php $P = $memberModel[0]['g_panlus'];?>
                                                <?php if(strstr($P,'A')!=''){echo "A盤";}?>
												<?php if(strstr($P,'B')!=''){echo "B盤";}?>
												<?php if(strstr($P,'C')!=''){echo "C盤";}?></td>
                                
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                         <?php for ($i=16;$i<31;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i>17 && $i<26){echo "3";}else{echo "2";}?>"><?php echo $memberDetList[$i]['g_type']?><input type="hidden" name="G<?php echo $i+1;?>" id="G<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAG<?php echo $i+1;?>" id="RebateAG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAG<?php echo $i+1;?>" id="sRebateAG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBG<?php echo $i+1;?>" id="RebateBG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBG<?php echo $i+1;?>" id="sRebateBG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetList[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCG<?php echo $i+1;?>" id="RebateCG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetList[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $memberDetList[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCG<?php echo $i+1;?>" id="sRebateCG<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetLists[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEG<?php echo $i+1;?>" id="RebateEG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $memberDetList[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEG<?php echo $i+1;?>" id="sRebateEG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFG<?php echo $i+1;?>" id="RebateFG<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetList[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $memberDetList[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFG<?php echo $i+1;?>" id="sRebateFG<?php echo $i+1;?>" value="<?php echo $memberDetLists[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
           
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">重慶時時彩</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                       <?php for ($i=0;$i<1;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $memberDetListC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ca'" 
                                    onblur="this.className='inp1 ca'" 
                                    class='inp1 ca' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'A盤', '1', 'ca')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cb'" 
                                    onblur="this.className='inp1 cb'" 
                                    class='inp1 cb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'B盤', '1', 'cb')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cc'" 
                                    onblur="this.className='inp1 cc'" 
                                    class='inp1 cc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'C盤', '1', 'cc')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ce'" 
                                    onblur="this.className='inp1 ce'" class='inp1 ce' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單註限額', '1', 'ce')"
                                    value='<?php echo $memberDetListC[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cf'" 
                                    onblur="this.className='inp1 cf'" class='inp1 cf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單期限額', '1', 'cf')"
                                    value='<?php echo $memberDetListC[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                          <?php for ($i=1;$i<7;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<5){echo "1";}else{echo "2";}?>"><?php echo $memberDetListC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ca'" 
                                    onblur="this.className='inp1 ca'" 
                                    class='inp1 ca' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cb'" 
                                    onblur="this.className='inp1 cb'" 
                                    class='inp1 cb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cc'" 
                                    onblur="this.className='inp1 cc'" 
                                    class='inp1 cc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ce'" 
                                    onblur="this.className='inp1 ce'" class='inp1 ce' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單註限額', '0', 'ce')"
                                    value='<?php echo $memberDetListC[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cf'" 
                                    onblur="this.className='inp1 cf'" class='inp1 cf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $memberDetListC[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                        
                      
                            
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                          <?php for ($i=7;$i<13;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<10){echo "2";}else{echo "4";}?>"><?php echo $memberDetListC[$i]['g_type']?><input type="hidden" name="C<?php echo $i+1;?>" id="C<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAC<?php echo $i+1;?>" id="RebateAC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ca'" 
                                    onblur="this.className='inp1 ca'" 
                                    class='inp1 ca' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'A盤', '0', 'ca')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAC<?php echo $i+1;?>" id="sRebateAC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBC<?php echo $i+1;?>" id="RebateBC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cb'" 
                                    onblur="this.className='inp1 cb'" 
                                    class='inp1 cb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'B盤', '0', 'cb')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBC<?php echo $i+1;?>" id="sRebateBC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListC[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCC<?php echo $i+1;?>" id="RebateCC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cc'" 
                                    onblur="this.className='inp1 cc'" 
                                    class='inp1 cc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListC[$i]['g_type']?>', 'C盤', '0', 'cc')" 
                                    value='<?php echo $memberDetListC[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCC<?php echo $i+1;?>" id="sRebateCC<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListCs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEC<?php echo $i+1;?>" id="RebateEC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ce'" 
                                    onblur="this.className='inp1 ce'" class='inp1 ce' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單註限額', '0', 'ce')"
                                    value='<?php echo $memberDetListC[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEC<?php echo $i+1;?>" id="sRebateEC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFC<?php echo $i+1;?>" id="RebateFC<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m cf'" 
                                    onblur="this.className='inp1 cf'" class='inp1 cf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListC[$i]['g_type']?>', '單期限額', '0', 'cf')"
                                    value='<?php echo $memberDetListC[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFC<?php echo $i+1;?>" id="sRebateFC<?php echo $i+1;?>" value="<?php echo $memberDetListCs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
				
				
				
				  <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">幸运农场</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                
                                <td> <?php $P = $memberModel[0]['g_panlus'];?>
                                                <?php if(strstr($P,'A')!=''){echo "A盤";}?>
												<?php if(strstr($P,'B')!=''){echo "B盤";}?>
												<?php if(strstr($P,'C')!=''){echo "C盤";}?></td>
                                
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                            <?php for ($i=0;$i<1;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $memberDetListX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'A盤', '1', 'ga')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'B盤', '1', 'gb')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'C盤', '1', 'gc')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單註限額', '1', 'ge')"
                                    value='<?php echo $memberDetListX[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單期限額', '1', 'gf')"
                                    value='<?php echo $memberDetListX[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                          <?php for ($i=1;$i<16;$i++){?> 
                                                    <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<8){echo "1";}else if($i==12 or $i==13){echo "4";}else{echo "2";}?>"><?php echo $memberDetListX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $memberDetListX[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $memberDetListX[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
           
                      
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <td>交易類型</td>
                                
                                <td> <?php $P = $memberModel[0]['g_panlus'];?>
                                                <?php if(strstr($P,'A')!=''){echo "A盤";}?>
												<?php if(strstr($P,'B')!=''){echo "B盤";}?>
												<?php if(strstr($P,'C')!=''){echo "C盤";}?></td>
                                
                                <td>單註限額</td>
                                <td>單期限額</td>
                            </tr>
                         <?php for ($i=16;$i<31;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i>17 && $i<26){echo "3";}else{echo "2";}?>"><?php echo $memberDetListX[$i]['g_type']?><input type="hidden" name="X<?php echo $i+1;?>" id="X<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAX<?php echo $i+1;?>" id="RebateAX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ga'" 
                                    onblur="this.className='inp1 ga'" 
                                    class='inp1 ga' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'A盤', '0', 'ga')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAX<?php echo $i+1;?>" id="sRebateAX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBX<?php echo $i+1;?>" id="RebateBX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gb'" 
                                    onblur="this.className='inp1 gb'" 
                                    class='inp1 gb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'B盤', '0', 'gb')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBX<?php echo $i+1;?>" id="sRebateBX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListX[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCX<?php echo $i+1;?>" id="RebateCX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gc'" 
                                    onblur="this.className='inp1 gc'" 
                                    class='inp1 gc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListX[$i]['g_type']?>', 'C盤', '0', 'gc')" 
                                    value='<?php echo $memberDetListX[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCX<?php echo $i+1;?>" id="sRebateCX<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListXs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEX<?php echo $i+1;?>" id="RebateEX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ge'" 
                                    onblur="this.className='inp1 ge'" class='inp1 ge' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單註限額', '0', 'ge')"
                                    value='<?php echo $memberDetListX[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEX<?php echo $i+1;?>" id="sRebateEX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFX<?php echo $i+1;?>" id="RebateFX<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m gf'" 
                                    onblur="this.className='inp1 gf'" class='inp1 gf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListX[$i]['g_type']?>', '單期限額', '0', 'gf')"
                                    value='<?php echo $memberDetListX[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFX<?php echo $i+1;?>" id="sRebateFX<?php echo $i+1;?>" value="<?php echo $memberDetListXs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
           
                        </table>
                    </td>
                </tr>
				
				
				
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">北京賽車(PK10)</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                              <?php for ($i=0;$i<8;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS1"><?php echo $memberDetListB[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ba'" 
                                    onblur="this.className='inp1 ba'" 
                                    class='inp1 ba' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bb'" 
                                    onblur="this.className='inp1 bb'" 
                                    class='inp1 bb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bc'" 
                                    onblur="this.className='inp1 bc'" 
                                    class='inp1 bc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m be'" 
                                    onblur="this.className='inp1 be'" class='inp1 be' 
                                    onchange="isCompares(this, '<?php echo $memberDetListB[$i]['g_type']?>', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListB[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $memberDetListBs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bf'" 
                                    onblur="this.className='inp1 bf'" class='inp1 bf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListB[$i]['g_type']?>', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListB[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $memberDetListBs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                            
                                                     
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <?php for ($i=8;$i<16;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<10){echo "1";}else if($i==15){echo "4";}else{echo "2";}?>"><?php echo $memberDetListB[$i]['g_type']?><input type="hidden" name="B<?php echo $i+1;?>" id="B<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAB<?php echo $i+1;?>" id="RebateAB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ba'" 
                                    onblur="this.className='inp1 ba'" 
                                    class='inp1 ba' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAB<?php echo $i+1;?>" id="sRebateAB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBB<?php echo $i+1;?>" id="RebateBB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bb'" 
                                    onblur="this.className='inp1 bb'" 
                                    class='inp1 bb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBB<?php echo $i+1;?>" id="sRebateBB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListB[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCB<?php echo $i+1;?>" id="RebateCB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bc'" 
                                    onblur="this.className='inp1 bc'" 
                                    class='inp1 bc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListB[$i]['g_type']?>', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListB[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCB<?php echo $i+1;?>" id="sRebateCB<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListBs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEB<?php echo $i+1;?>" id="RebateEB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m be'" 
                                    onblur="this.className='inp1 be'" class='inp1 be' 
                                    onchange="isCompares(this, '<?php echo $memberDetListB[$i]['g_type']?>', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListB[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEB<?php echo $i+1;?>" id="sRebateEB<?php echo $i+1;?>" value="<?php echo $memberDetListBs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFB<?php echo $i+1;?>" id="RebateFB<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m bf'" 
                                    onblur="this.className='inp1 bf'" class='inp1 bf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListB[$i]['g_type']?>', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListB[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFB<?php echo $i+1;?>" id="sRebateFB<?php echo $i+1;?>" value="<?php echo $memberDetListBs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            <tr class="Conter_top">
                                <th style="border:none">江苏骰寶(快3)</th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                            <?php for ($i=0;$i<2;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS2"><?php echo $memberDetListJ[$i]['g_type']?><input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'" 
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'" 
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'" 
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'" class='inp1 je' 
                                    onchange="isCompares(this, '<?php echo $memberDetListJ[$i]['g_type']?>', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListJ[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" class='inp1 jf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListJ[$i]['g_type']?>', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListJ[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                             <?php for ($i=2;$i<3;$i++){?> 
                             <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3">圍骰<input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'" 
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja' 
                                    onchange="isCompare(this, '圍骰', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'" 
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb' 
                                    onchange="isCompare(this, '圍骰', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'" 
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc' 
                                    onchange="isCompare(this, '圍骰', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'" class='inp1 je' 
                                    onchange="isCompares(this, '圍骰', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListJ[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" class='inp1 jf' 
                                    onchange="isCompares(this, '圍骰', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListJ[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                            
                              <?php for ($i=6;$i<7;$i++){?> 
                             <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS3">全骰<input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[2]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'" 
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja' 
                                    onchange="isCompare(this, '全骰', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListJ[2]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[2]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[2]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'" 
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb' 
                                    onchange="isCompare(this, '全骰', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListJ[2]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[2]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[2]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'" 
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc' 
                                    onchange="isCompare(this, '全骰', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListJ[2]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[2]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'" class='inp1 je' 
                                    onchange="isCompares(this, '全骰', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListJ[2]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[2]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" class='inp1 jf' 
                                    onchange="isCompares(this, '全骰', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListJ[2]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[2]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                            
                        </table>
                    </td>
                    <td valign="top">
                        <table border="0" cellspacing="" cellpadding="0" class="Man_Conter az auto">
                            
                          <?php for ($i=3;$i<6;$i++){?> 
                            <tr class="Conter_Report_List" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                                <td class="t_Edit_caption ed TD_TS<?php if ($i<4){echo "4";}else{echo "3";}?>"><?php echo $memberDetListJ[$i]['g_type']?><input type="hidden" name="J<?php echo $i+1;?>" id="J<?php echo $i+1;?>" value="248015" /></td>
                                
                                <td><?php $P = $memberModel[0]['g_panlus'];?>
                                <?php if(strstr($P,'A')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_a'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateAJ<?php echo $i+1;?>" id="RebateAJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m ja'" 
                                    onblur="this.className='inp1 ja'" 
                                    class='inp1 ja' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'A盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'ba')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_a'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateAJ<?php echo $i+1;?>" id="sRebateAJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_a_limit'];?>" />
                                     <?php }else if(strstr($P,'B')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_b'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateBJ<?php echo $i+1;?>" id="RebateBJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jb'" 
                                    onblur="this.className='inp1 jb'" 
                                    class='inp1 jb' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'B盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bb')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_b'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateBJ<?php echo $i+1;?>" id="sRebateBJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_b_limit'];?>" />
                                    
                                       <?php }else if(strstr($P,'C')!=''){?>
                                    <span style="width:60px;display:<?php if ($dets == 0){echo "none";}?>"><?php echo $memberDetListJ[$i]['g_panlu_c'];?></span>
                                    <input style="width:60px;display:<?php if ($dets != 0){echo "none";}?>" name="RebateCJ<?php echo $i+1;?>" id="RebateCJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jc'" 
                                    onblur="this.className='inp1 jc'" 
                                    class='inp1 jc' 
                                    onchange="isCompare(this, '<?php echo $memberDetListJ[$i]['g_type']?>', 'C盤', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'cc')" 
                                    value='<?php echo $memberDetListJ[$i]['g_panlu_c'];?>' maxlength="6" />
                                    <input type="hidden" name="sRebateCJ<?php echo $i+1;?>" id="sRebateCJ<?php echo $i+1;?>" 
                                    value="<?php echo $memberDetListJs[$i]['g_c_limit'];?>" /> 
                                    <?php }?> 
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateEJ<?php echo $i+1;?>" id="RebateEJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m je'" 
                                    onblur="this.className='inp1 je'" class='inp1 je' 
                                    onchange="isCompares(this, '<?php echo $memberDetListJ[$i]['g_type']?>', '單註限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'be')"
                                    value='<?php echo $memberDetListJ[$i]['g_danzhu']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateEJ<?php echo $i+1;?>" id="sRebateEJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_d_limit']?>" />
                                </td>
                                <td>
                                    <input style="width:90px;" name="RebateFJ<?php echo $i+1;?>" id="RebateFJ<?php echo $i+1;?>"
                                    onfocus="this.className='inp1m jf'" 
                                    onblur="this.className='inp1 jf'" class='inp1 jf' 
                                    onchange="isCompares(this, '<?php echo $memberDetListJ[$i]['g_type']?>', '單期限額', '<?php if($i==0){echo "1";}else{echo "0";}?>', 'bf')"
                                    value='<?php echo $memberDetListJ[$i]['g_danxiang']?>' maxlength="9" />
                                    <input type="hidden" name="sRebateFJ<?php echo $i+1;?>" id="sRebateFJ<?php echo $i+1;?>" value="<?php echo $memberDetListJs[$i]['g_e_limit']?>" />
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
                
            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center">
						
						<input type="submit" name="submit" id="submit" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" value="保存" />&nbsp;&nbsp;
            <input type="button" onMouseOver="this.className='input2_2'" onMouseOut="this.className='input2'" class="input2" onClick="historys()" value="取消" />
			
						</td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
        </tr>
    </table>
</form>
</body>
</html>