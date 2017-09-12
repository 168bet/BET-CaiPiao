<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<?php include $this->admin_tpl('header', 'admin'); ?>
<div class="pad-lr-10">
    <form name="searchform" action="" method="get">
        <input type="hidden" value="member" name="m">
        <input type="hidden" value="member" name="c">
        <input type="hidden" value="search" name="a">
        <input type="hidden" value="879" name="menuid">
    </form>

    <form name="myform" action="?m=admin&c=point_setting&a=delete" method="post" onsubmit="checkuid();return false;">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th align="left" width="20"><input type="checkbox" value="" id="check_box"
                                                       onclick="selectall('id[]');"></th>
                    <th align="left"><?php echo L('id') ?></th>
                    <th align="left"><?php echo L('name_cn') ?></th>
                    <th align="left"><?php echo L('name_en') ?></th>
                    <th align="left"><?php echo L('value') ?></th>
                    <th align="left"><?php echo L('note') ?></th>
                    <th align="left"><?php echo L('lastuser') ?></th>
                    <th align="left"><?php echo L('lastdate') ?></th>
                    <th align="left"><?php echo L('operation') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($list)) {
                    foreach ($list as $k => $v) {
                        ?>
                        <tr>
                            <td align="left"><input type="checkbox" value="<?php echo $v['id'] ?>" name="id[]"></td>
                            <td align="left"><?php echo $v['id'] ?></td>
                            <td align="left"><?php echo $v['name_cn'] ?></td>
                            <td align="left"><?php echo $v['name_en'] ?></td>
                            <td align="left"><?php echo $v['value'] ?></td>
                            <td align="left"><?php echo $v['note'] ?></td>
                            <td align="left"><?php echo empty($v['lastuser']) ? '' : $v['lastuser'] ?></td>
                            <td align="left"><?php if (!empty($v['lastdate'])) {
                                    echo format::date($v['lastdate'], 1);
                                } ?></td>
                            <td align="left">
                                <a href="javascript:edit(<?php echo $v['id'] ?>, '<?php echo $v['name_en'] ?>')">[<?php echo L('edit') ?>
                                    ]</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="btn">
                <label for="check_box"><?php echo L('select_all') ?>/<?php echo L('cancel') ?></label> <input
                    type="submit" class="button" name="dosubmit" value="<?php echo L('delete') ?>"
                    onclick="return confirm('<?php echo L('sure_delete') ?>')"/>
            </div>

            <div id="pages"><?php echo $pages ?></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var module = 'admin';
    var controller = 'point_setting';
    function edit(id, name) {
        window.top.art.dialog({id: 'edit'}).close();
        window.top.art.dialog({
            title: '<?php echo L('edit') . L('dict')?>《' + name + '》',
            id: 'edit',
            iframe: '?m=' + module + '&c=' + controller + '&a=edit&id=' + id,
            width: '700',
            height: '500'
        }, function () {
            var d = window.top.art.dialog({id: 'edit'}).data.iframe;
            d.document.getElementById('dosubmit').click();
            return false;
        }, function () {
            window.top.art.dialog({id: 'edit'}).close()
        });
    }

    function checkuid() {
        var ids = '';
        $("input[name='id[]']:checked").each(function (i, n) {
            ids += $(n).val() + ',';
        });
        if (ids == '') {
            window.top.art.dialog({
                content: '<?php echo L('plsease_select') . L('dict')?>',
                lock: true,
                width: '200',
                height: '50',
                time: 1.5
            }, function () {
            });
            return false;
        } else {
            myform.submit();
        }
    }

</script>