<?php
template('admin/header');
if (isset($_POST['search'])) {
    core_header('!admin/searchUser/' . $_POST['email'], 0);
}
?>
<div class="col-md-4 col-md-offset-3 content">
    <form action="" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo language('titles', 'SEARCH_USER'); ?>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="email" class="form-control" name="email" placeholder="<?php echo language('others', 'EMAIL'); ?>" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="search" value="<?php echo language('buttons', 'SEARCH'); ?>" />
                </div>
            </div>
        </div>
    </form>
</div>
<?php template('admin/footer'); ?>