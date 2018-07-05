<?php
template('admin/header');
$getCodes = pagination("SELECT * FROM sms_codes", 10);

?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ALL_EXISTING_CODES'); ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo language('others', 'CODE'); ?></th>
                        <th><?php echo language('others', 'BALANCE'); ?></th>
                        <th class="text-right"><?php echo language('others', 'ACTION'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($getCodes != NULL) {
							foreach ($getCodes[1] as $code) {
								echo '<tr>
								<td>' . $code['code'] . '</td>
								<td>' . $code['balance'] . '</td>
								<td class="text-right">
									<a class="btn btn-danger btn-xs" href="' . url . '!admin/deleteCode/' . $code['sms_code_id'] . '"><span class="glyphicon glyphicon-remove-circle"></span> ' . language('others', 'DELETE') . '</a>
								</td>
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
					$prev = url . '!admin/allCodes/cPage/' . $pages['prev'];
				} else {
					$prev = '';
				}
				
				if($pages['next'] - 1 != $pages['max']) {
					$next = url . '!admin/allCodes/cPage/' . $pages['next'];
				} else {
					$next = '';
				}
				
				?>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
					<li class="page-item"><a class="page-link" href="<?php echo $prev; ?>">Previous</a></li>
					<li class="page-item"><a class="page-link" href="<?php echo $next; ?>">Next</a></li>
					</ul>
				</nav>
				<?php
			}
			?>
        </div>
    </div>
</div>
<?php template('admin/footer'); ?>