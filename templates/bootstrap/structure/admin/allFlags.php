<?php
template('admin/header');
$allFlags = allFlags();
?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ALL_EXISTING_FLAGS'); ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo language('others', 'FLAG'); ?></th>
                        <th><?php echo language('others', 'FLAG_PRICE'); ?></th>
                        <th class="text-right"><?php echo language('others', 'ACTION'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($allFlags != language('messages', 'NOTHING_ADDED')) {
                        foreach ($allFlags as $flag) {
                            echo '<tr>
                            <td>' . $flag['flag'] . '</td>
                            <td>' . $flag['price'] . '</td>
                            <td class="text-right">
                                <a class="btn btn-primary btn-xs" href="' . url . '!admin/editFlag/' . $flag['flag_id'] . '"><span class="glyphicon glyphicon-edit"></span> ' . language('others', 'EDIT') . '</a>
                                <a class="btn btn-danger btn-xs" href="' . url . '!admin/deleteFlag/' . $flag['flag_id'] . '"><span class="glyphicon glyphicon-remove-circle"></span> ' . language('others', 'DELETE') . '</a>
                            </td>
                        </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php template('admin/footer'); ?>