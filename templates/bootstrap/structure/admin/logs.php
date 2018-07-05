<?php
template('admin/header');
$getCodes = pagination("SELECT * FROM logs ORDER BY log_id DESC", 14);

?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ALL_EXISTING_LOGS'); ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo language('logs', 'DATE_CREATED'); ?></th>
                        <th><?php echo language('logs', 'CREATED_BY'); ?></th>
                        <th><?php echo language('logs', 'LOG'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($getCodes != NULL) {
							foreach ($getCodes[1] as $code) {
								echo '<tr>
								<td>' . $code['date'] . '</td>
								<td>' . $code['user'] . '</td>
								<td>' . $code['log'] . '</td>
							</tr>';
							}
						}
                    ?>
                </tbody>
            </table>
			<?php
			if($getCodes != NULL) {
				$pages = $getCodes[0];
				if($pages['prev'] != 0) {
					$prev = url . '!admin/logs/cPage/' . $pages['prev'];
				} else {
					$prev = '';
				}
				
				if($pages['next'] - 1 != $pages['max']) {
					$next = url . '!admin/logs/cPage/' . $pages['next'];
				} else {
					$next = '';
				}
			}
			?>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
				<li class="page-item"><a class="page-link" href="<?php echo $prev; ?>">Previous</a></li>
				<li class="page-item"><a class="page-link" href="<?php echo $next; ?>">Next</a></li>
				</ul>
			</nav>
        </div>
    </div>
</div>
<?php template('admin/footer'); ?>