<?php
template('header');
$user    = user_info($_SESSION['user_logged']);
?>

<!--Popular-->
<div class="panel panel-default">
    <div class="panel-heading"><?php echo language('titles', 'LOG'); ?></div>
    <div class="panel-content">
        <p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo language('others', 'DATE'); ?></th>
                    <th><?php echo language('others', 'LOG'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getLogs = query("SELECT * FROM logs WHERE user='" . $_SESSION['user_logged'] . "' ORDER BY log_id DESC");
                if (num_rows($getLogs) > 0) {
                    while ($row = fetch_assoc($getLogs)) {
                        echo '<tr>
                        <td>' . $row['date'] . '</td>
                        <td>' . $row['log'] . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr>
                    <td>' . language('messages', 'NO_LOGS') . '</td>
                    <td></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        </p>
    </div>
</div>
<?php template('footer');
?>