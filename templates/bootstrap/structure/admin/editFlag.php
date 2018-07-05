<?php
template('admin/header');
$flag = editFlag();
editFlag_submit();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'EDIT_FLAG'); ?>
        </div>
        <form action="" method="POST">
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" size="40" class="form-control" name="flag" placeholder="<?php echo language('others', 'FLAG'); ?>" value="<?php echo $flag['flag']; ?>" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <textarea style="resize: none" cols="42" rows="4" class="form-control" name="flagDesc" placeholder="<?php echo language('others', 'FLAG_DESCRIPTION'); ?>" aria-describedby="basic-addon1"><?php echo $flag['flagDesc']; ?></textarea>
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" size="40" class="form-control" name="flagPrice" placeholder="<?php echo language('others', 'FLAG_PRICE'); ?>" value="<?php echo $flag['price']; ?>" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="edit" value="<?php echo language('buttons', 'EDIT'); ?>" />
                </div>
            </div>
        </form>
        <?php
        if (core_message('editFlag') != '') {
            echo '<div class="alert alert-info">
            ' . core_message('editFlag') . '
        </div>';
        }
        ?>
    </div>
</div>
<?php template('admin/footer'); ?>