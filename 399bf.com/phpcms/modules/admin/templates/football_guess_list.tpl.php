<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
    <form name="searchform" action="" method="get" >
        <input type="hidden" value="admin" name="m">
        <input type="hidden" value="guess" name="c">
        <input type="hidden" value="football_manage" name="a">
        <input type="hidden" value="879" name="menuid">
        <table width="100%" cellspacing="0" class="search-form">
            <tbody>
            <tr>
                <td>
                    <div class="explain-col">
                        <?php echo L('game_id') ?>:
                        <input type="text" id="gameid" name="gameid" value="<?php echo $gameid ?>">
                        <?php echo L('status') ?>:
                        <?php echo form::select($status_list, $status, 'name="status"', L('select'));?>
                        <?php echo L('add_time')?>：
                        <?php echo form::date('start_time', $start_time, 1)?>-
                        <?php echo form::date('end_time', $end_time, 1)?>
                        <input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <form name="myform" action="?m=admin&c=guess&a=guess_delete" method="post" onsubmit="checkid();return false;">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
                    <th align="left"><?php echo L('game_id')?></th>
                    <th align="left"><?php echo L('status')?></th>
                    <th align="left"><?php echo L('addtime')?></th>
                    <th align="left"><?php echo L('operation')?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(is_array($guess_list)){
                    foreach($guess_list as $k=>$v) {
                        ?>
                        <tr>
                            <td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
                            <td align="left"><?php echo $v['gameid']?></td>
                            <td align="left"><?php echo $status_list[$v['status']]?></td>
                            <td align="left"><?php echo format::date($v['addtime'], 1);?></td>
                            <td align="left">
                                <a href="javascript:edit(<?php echo $v['id']?>, '<?php echo $v['gameid']?>', <?php echo $v['type'] ?>)">[<?php echo L('edit')?>]</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="btn">
                <label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
            </div>

            <div id="pages"><?php echo $pages?></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    <!--
    function edit(id, name, type) {
        window.top.art.dialog({id:'edit'}).close();
        window.top.art.dialog({title:'<?php echo L('edit').L('guess')?>'+name,id:'edit',iframe:'?m=admin&c=guess&a=guess_edit&id=' + id + '&type=' + type,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
    }

    function checkid() {
        var ids='';
        $("input[name='id[]']:checked").each(function(i, n){
            ids += $(n).val() + ',';
        });
        if(ids=='') {
            window.top.art.dialog({content:'<?php echo L('please_select').L('guess')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
            return false;
        } else {
            myform.submit();
        }
    }
    //-->
</script>
</body>
</html>