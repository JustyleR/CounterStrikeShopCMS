<?php
template('admin/header');
if (isset($_POST['choose'])) {
    $server = $_POST['server'];
    $page   = core_page('');
    core_header($page[0] . '/' . $page[1] . '/' . $server, 0);
}
?>

<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'CHOOSE_SERVER'); ?>
        </div>
        <p>
        <form action="" method="POST">
            <div class="panel-body">
                <div class="input-group">
                    <select class="form-control" name="server" id="sel1">

                        <?php
                        $get = query("SELECT * FROM servers");
                    if(num_rows($get) > 0) {
                        while($row = fetch_assoc($get)) {
                            $csbans = csbans_serverInfo($row['csbans_id']);
                            echo '<option value="'. $row['shortname'] .'">'. $csbans['hostname'] .'</option>';
                        }
                    }
                        ?>
                    </select>
                </div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="choose" value="<?php echo language('others', 'CHOOSE_SERVER'); ?>" />
                </div>
            </div>
        </form>
        </p>
        <?php
        if (core_message('addServer') != '') {
            echo '<div class="alert alert-info">
            ' . core_message('addServer') . '
        </div>';
        }
        ?>
    </div>
</div>

<?php template('admin/footer'); ?>