<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'BUY_FLAGS'); ?>
            </div>
            <div class="card-body">
				<p>
				<?php
				buyFlags();
				$user     = user_info($_SESSION['user_logged']);
				$server   = core_page()[1];
				
				$getFlags = query("SELECT * FROM flags WHERE server='$server'");
				if(num_rows($getFlags) > 0) {
					
					echo '
				<form action="" method="POST">';
				
				$adminID = csbans_getadminID($server);
				if($adminID != NULL) {
					$getAdminInfo = query("SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
					$row = fetch_assoc($getAdminInfo);
					while($row2 = fetch_assoc($getFlags)) {
						
						if (strpos($row['access'], $row2['flag']) === FALSE) {
							
							echo '
							<div class="controls-row">
								
									<input type="radio" class="form-check-input" name="flag" id="optionsRadios1" value="' . $row2['flag'] . '" />
									<label class="form-check-label"><small><strong>' . $row2['price'] . '</strong></small></label>
								  <label class="form-check-label">' . $row2['flagDesc'] . '</label>
									' . $row2['flagDesc'] . '
								
							</div>
							';
							
							$_SESSION['has_flag'] = TRUE;
							
						}
						
					}
					
					if (isset($_SESSION['has_flag'])) {
						echo '<input type = "submit" name = "buy" class = "btn btn-primary" value = "'. language('buttons', 'BUY_FLAG') .'" />';
						unset($_SESSION['has_flag']);
					} else {
						echo language('messages', 'NO_MORE_FLAGS_TO_BUY');
					}
				} else {
					csbans_createAdmin($server);
					core_header('buyFlags/' . $server, 0);
				}
				
				echo '</form>';
					
				} else {
					
					echo language('messages', 'NO_FLAGS_ADDED');
					
				}
				?>
				</p>
				<p><?php core_message('flag'); ?></p>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>