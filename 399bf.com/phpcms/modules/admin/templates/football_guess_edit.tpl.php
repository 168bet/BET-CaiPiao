<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
    <!--
    $(function(){
        $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});

        $("#gameid").formValidator({onshow:"<?php echo L('input').L('game_id')?>",onfocus:"<?php echo L('game_id').L('exists')?>"}).ajaxValidator({
            type : "get",
            url : "",
            data :"m=admin&c=guess&a=ajax_check_game_id&type=1&id=" + <?php echo $info['id'] ?>,
            datatype : "html",
            async:'false',
            success : function(data){
                if( data == "1" ) {
                    return true;
                } else {
                    return false;
                }
            },
            buttons: $("#dosubmit"),
            onerror : "<?php echo L('gameid_not_exist').L('or').L('guess_already_exist')?>",
            onwait : "<?php echo L('connecting_please_wait')?>"
        });
    });
    //-->
</script>
<div class="pad-10">
    <div class="common-form">
        <form name="myform" action="?m=admin&c=guess&a=guess_edit" method="post" id="myform">
            <fieldset>
                <legend><?php echo L('basic_configuration')?></legend>
                <table width="100%" class="table_form">
                    <tr>
                        <td>
                            <?php echo L('guess_type') ?>
                        </td>
                        <td>
                            <input type="hidden" id="id" name="id" value="<?php echo $info['id'] ?>">
                            <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                            <span><?php echo L('football') ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="80"><?php echo L('game_id')?></td>
                        <td><input type="text" name="info[gameid]"  class="input-text" id="gameid" value="<?php echo $info['gameid'] ?>"></td>
                    </tr>
                    <tr>
                        <td><?php echo L('status')?></td>
                        <td>
                            <?php echo form::select($status_list, $info['status'], 'name="info[status]"', '');?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo L('add_time')?></td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $info['addtime'])?>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <div class="bk15"></div>
            <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
        </form>
    </div>
</div>
</body>
</html>