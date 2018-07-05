<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'PROFILE_SETTNGS'); ?>
            </div>
            <div class="card-body">
				<?php
				settings();
				$settings = user_info($_SESSION['user_logged']);
				if($settings['nickname'] == NULL || $settings['nick_pass'] == NULL) {
					echo '<label><font color="red">' . language('messages', 'ADD_NICKNAME_AND_PASSWORD') . '</font></label>';
				}
				?>
				<form action="" method="POST">
					<div class="row">
						<div class="col">
							<label><?php echo language('profile', 'CURRENT_PASSWORD'); ?></label>
							<input type="password" name="cpassword" class="form-control" placeholder="<?php echo language('profile', 'CURRENT_PASSWORD'); ?>" maxlength="50" />
						</div>
						<div class="col">
							<label for="exampleInputEmail1"><?php echo language('profile', 'NEW_PASSWORD'); ?></label>
							<input type="text" name="npassword" class="form-control" placeholder="<?php echo language('profile', 'NEW_PASSWORD'); ?>" maxlength="40" />
						</div>
					</div>
					
						<br />
						
					<div class="row">
						<div class="col">
							<label for="exampleInputEmail1"><?php echo language('settings', 'NICKNAME'); ?></label>
							<input type="text" name="nickname" class="form-control" value="<?php echo $settings['nickname']; ?>" maxlength="40" required />
						</div>
						<div class="col">
							<label for="exampleInputEmail1"><?php echo language('settings', 'PASSWORD_INGAME'); ?></label>
							<input type="text" name="nick_password" class="form-control" value="<?php echo $settings['nick_pass']; ?>" maxlength="40" required />
						</div>
					</div>
					
					<br />
					
					<div class="form-group">
						<label for="exampleInputEmail1"><?php echo language('settings', 'LANGUAGE'); ?></label>
						<select name="lang" class="form-control">
							<?php
							$path     = 'language/';
							$results  = scandir($path);

							foreach ($results as $result) {
								if ($result === '.' or $result === '..')
									continue;

								if (is_dir($path . '/' . $result)) {
									echo '<option value="' . $result . '"';
									if ($result === $settings['language']) {
										echo 'selected';
									}
									echo '>' . $result . '</option>';
								}
							}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<input type="submit" name="save" class="btn btn-primary" value="<?php echo language('buttons', 'SAVE_CHANGES'); ?>" />
					</div>
					
					<div class="form-group">
						<?php echo core_message('settings'); ?>
					</div>					
				</form>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>