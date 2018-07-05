<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'CHOOSE_SERVER'); ?>
            </div>
            <div class="card-body">
				<form action="" method="POST">
					<div class="form-group">
						<select class="form-control" name="server" id="sel1">
							<?php
							if(isset($_POST['choose'])) {
								$server = $_POST['server'];
								$page = core_page('')[0];
								core_header($page . '/' . $server, 0);
							}
							
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
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="choose" value="<?php echo language('buttons', 'CHOOSE'); ?>" />
					</div>
				</form>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>