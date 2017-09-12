<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'class/SumAmount.php';
include_once ROOT_PATH.'Manage/config/config.php';
include_once ROOT_PATH.'function/opNumberList.php';

	
	
	
	if(isset($_POST["url"]))
{
 $url=$_POST["url"];
 $fcont=file_get_contents($url);
 if(eregi('<table(.*)table>',$fcont,$re))
  echo "<script>alert(\"ok\");</script>";
 else
  echo "<script>alert(\"no\");</script>";
 echo $re[0];
}
else
{
?>
<form action="getnumber.php" method="post">
url:<input type="text" size=30 name="url">
<input type="submit" name="submit" value="Catch">
</form>
<?php
}

?>
<script>
function GetIframeInnerHtml(objIFrame) 
{ 
      var iFrameHTML = ""; 
        if (objIFrame.contentDocument)    
        { 
                // For NS6 
                iFrameHTML = objIFrame.contentDocument.innerHTML;    
        }    
        else if (objIFrame.contentWindow)    
        { 
                // For IE5.5 and IE6 
                iFrameHTML = objIFrame.contentWindow.document.body.innerHTML; 
        }    
        else if (objIFrame.document)    
        { 
                // For IE5 
                iFrameHTML = objIFrame.document.body.innerHTML; 
        } 
    
        return iFrameHTML;
} 

</script>
<input type="button" name="get" onclick="GetIframeInnerHtml(document.all.frmIn)" value="get" />
<iframe  id="frmIn" name="frmIn" src="http://www.50790.com" width="800" height="500"/>
