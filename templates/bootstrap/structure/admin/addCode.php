<?php
template('admin/header');
addCode();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'CREATE_CODE'); ?>
        </div>
        <form action="" method="POST">
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" size="3" class="form-control" name="code" placeholder="<?php echo language('others', 'BALANCE'); ?>" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="add" value="<?php echo language('buttons', 'CREATE'); ?>" />
                </div>
            </div>
        </form>
        <?php
        if (core_message('addCode') != '') {
            echo '<div class="alert alert-info">
            ' . core_message('addCode') . '
        </div>';
        }
        ?>
    </div>
</div>
<?php template('admin/footer'); ?>