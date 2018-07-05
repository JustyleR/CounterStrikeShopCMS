<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
			<div class="card-header">
				<?php echo language('titles', 'LOGS'); ?>
            </div>
			<div class="card-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo language('others', 'DATE'); ?></th>
							<th><?php echo language('others', 'LOG'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$user    = user_info($_SESSION['user_logged']);
						$getLogs = pagination("SELECT * FROM logs WHERE user='" . $_SESSION['user_logged'] . "' ORDER BY log_id DESC", 10);
						if($getLogs != NULL) {
							foreach($getLogs[1] as $log) {
								echo '<tr>
								<td>' . $log['date'] . '</td>
								<td>' . $log['log'] . '</td>
								</tr>';
							}
						}
						
						?>
					</tbody>
				</table>
				<?php
				if($getLogs != NULL) {
					$pages = $getLogs[0];
					if($pages['prev'] != 0) {
						$prev = url . 'logs/cPage/' . $pages['prev'];
					} else {
						$prev = '';
					}
					
					if($pages['next'] - 1 != $pages['max']) {
						$next = url . 'logs/cPage/' . $pages['next'];
					} else {
						$next = '';
					}
				}
				?>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
					<li class="page-item"><a class="page-link" href="<?php echo $prev; ?>"><?php echo language('others', 'PAGINATION_PREVIOUS'); ?></a></li>
					<li class="page-item"><a class="page-link" href="<?php echo $next; ?>"><?php echo language('others', 'PAGINATION_NEXT'); ?></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>