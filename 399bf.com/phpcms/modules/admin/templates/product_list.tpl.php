<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<?php include $this->admin_tpl('header', 'admin'); ?>
<div class="pad-lr-10">
    <form name="searchform" action="" method="get">
        <input type="hidden" value="admin" name="m">
        <input type="hidden" value="product" name="c">
        <input type="hidden" value="manage" name="a">
        <input type="hidden" value="879" name="menuid">
        <table width="100%" cellspacing="0" class="search-form">
            <tbody>
            <tr>
                <td>
                    <div class="explain-col">
                        <?php //echo L('addtime') ?><!--：-->
                        <?php //echo form::date('start_time', $start_time) ?><!----->
                        <?php //echo form::date('end_time', $end_time) ?>

                        <select name="type">
                            <option value='1'
                                    <?php if (isset($_GET['type']) && $_GET['type'] == 1){ ?>selected<?php } ?>><?php echo L('name') ?></option>
                        </select>

                        <input name="keyword" type="text" value="<?php if (isset($_GET['keyword'])) {
                            echo $_GET['keyword'];
                        } ?>" class="input-text"/>
                        <input type="submit" name="search" class="button" value="<?php echo L('search') ?>"/>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <form name="myform" action="?m=admin&c=product&a=delete" method="post" onsubmit="checkuid();return false;">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th align="left" width="20"><input type="checkbox" value="" id="check_box"
                                                       onclick="selectall('productid[]');"></th>
                    <th align="left"><?php echo L('productid') ?></th>
                    <th align="left"><?php echo L('name') ?></th>
                    <th align="left"><?php echo L('description') ?></th>
                    <th align="left"><?php echo L('price') ?></th>
                    <th align="left"><?php echo L('picurl') ?></th>
                    <th align="left"><?php echo L('stock') ?></th>
                    <th align="left"><?php echo L('addtime') ?></th>
                    <th align="left"><?php echo L('adduser') ?></th>
                    <th align="left"><?php echo L('uptime') ?></th>
                    <th align="left"><?php echo L('upuser') ?></th>
                    <th align="left"><?php echo L('operation') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($list)) {
                    foreach ($list as $k => $v) {
                        ?>
                        <tr>
                            <td align="left"><input type="checkbox" value="<?php echo $v['productid'] ?>" name="id[]">
                            </td>
                            <td align="left"><?php echo $v['productid'] ?></td>
                            <td align="left"><?php echo $v['name'] ?></td>
                            <td align="left"><?php echo $v['description'] ?></td>
                            <td align="left"><?php echo $v['price'] ?></td>
                            <td align="left"><img src="<?php echo $v['picurl'] ?>" height=18 width=18</td>
                            <td align="left"><?php echo $v['stock'] ?></td>
                            <td align="left"><?php if (!empty($v['addtime'])) {
                                    echo format::date($v['addtime'], 1);
                                } ?></td>
                            <td align="left"><?php echo empty($v['adduserid']) ? '' : $v['adduser'] ?></td>
                            <td align="left"><?php if (!empty($v['uptime'])) {
                                    echo format::date($v['uptime'], 1);
                                } ?></td>
                            <td align="left"><?php echo empty($v['upuserid']) ? '' : $v['upuser'] ?></td>
                            <td align="left">
                                <a href="javascript:edit(<?php echo $v['productid'] ?>, '<?php echo $v['name'] ?>')">[<?php echo L('edit').L('product') ?>
                                    ]</a>
                                <a href="javascript:edit_stock(<?php echo $v['productid'] ?>, '<?php echo $v['name'] ?>')">[<?php echo L('edit_stock') ?>
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
    var controller = 'product';
    function edit(id, name) {
        window.top.art.dialog({id: 'edit'}).close();
        window.top.art.dialog({
            title: '<?php echo L('edit') . L('product')?>《' + name + '》',
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

    function edit_stock(id, name) {
        window.top.art.dialog({id: 'edit_stock'}).close();
        window.top.art.dialog({
            title: '<?php echo L('edit') . L('stock')?>《' + name + '》',
            id: 'edit_stock',
            iframe: '?m=' + module + '&c=' + controller + '&a=stock_edit&id=' + id,
            width: '700',
            height: '500'
        }, function () {
            var d = window.top.art.dialog({id: 'edit_stock'}).data.iframe;
            d.document.getElementById('dosubmit').click();
            return false;
        }, function () {
            window.top.art.dialog({id: 'edit_stock'}).close()
        });
    }

    function checkuid() {
        var ids = '';
        $("input[name='id[]']:checked").each(function (i, n) {
            ids += $(n).val() + ',';
        });
        if (ids == '') {
            window.top.art.dialog({
                content: '<?php echo L('plsease_select') . L('member')?>',
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