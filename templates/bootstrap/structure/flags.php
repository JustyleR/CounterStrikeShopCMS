<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'CURRENT_FLAGS'); ?>
            </div>
            <div class="card-body">
				<?php
				$user     = user_info($_SESSION['user_logged']);
				$server   = core_page()[1];
				$adminID  = csbans_getadminID($server);
				
				$getFlags = query("SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
				if (num_rows($getFlags) > 0) {
					$row = fetch_assoc($getFlags);
					if ($row['access'] != NULL) {
							?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?php echo language('others', 'FLAG'); ?></th>
									<th><?php echo language('others', 'INFORMATION'); ?></th>
									<th><?php echo language('others', 'DATE_EXPIRE'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$flags  = $row['access'];
								$strlen = strlen($flags);
								for ($i = 0; $i <= $strlen; $i++) {
									$char        = substr($flags, $i, 1);
									$getFlagInfo = query("SELECT flagDesc FROM flags WHERE flag='$char' AND server='$server'");
									if (num_rows($getFlagInfo) > 0) {
										$row           = fetch_assoc($getFlagInfo);
										$getFlagExpire = query("SELECT dateExpire FROM flag_history WHERE flag='$char' AND server='$server'");
										if (num_rows($getFlagExpire) > 0) {
											$row2 = fetch_assoc($getFlagExpire);
											echo '<tr>
											<td>' . $char . '</td>
											<td>' . $row['flagDesc'] . '</td>
											<td>' . $row2['dateExpire'] . '</td>
										</tr>';
										}
									}
								}
								?>
							</tbody>
						</table>
						<?php
					} else {
						echo language('messages', 'NO_BOUGHT_FLAGS');
					}
				} else {
					echo language('messages', 'NO_BOUGHT_FLAGS');
				}
			?>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>