<?php
template('admin/header');
$settings = getSettings();
settings_submit();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ADMIN_SITE_SETTINGS'); ?>
        </div>
        <form action="" method="POST">
            <div class="panel-body">
                <div class="input-group">
                    <div class="form-group">
						<label for="exampleInputEmail1"><?php echo language('others', 'SITE_SETTINGS_LANGUAGE'); ?></label>
						<select name="lang" class="form-control">
							<?php
							$path     = 'language/';
							$results  = scandir($path);

							foreach($results as $result) {
								if($result === '.' or $result === '..')
									continue;

								if(is_dir($path . '/' . $result)) {
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
                </div>
            </div>
			<div class="panel-body">
                <div class="input-group">
                    <div class="form-group">
						<label for="exampleInputEmail1"><?php echo language('others', 'SITE_SETTINGS_TEMPLATE'); ?></label>
						<select name="template" class="form-control">
							<?php
							$path     = 'templates/';
							$results  = scandir($path);

							foreach($results as $result) {
								if($result === '.' or $result === '..')
									continue;

								if(is_dir($path . '/' . $result)) {
									echo '<option value="' . $result . '"';
									if ($result === $settings['template']) {
										echo 'selected';
									}
									echo '>' . $result . '</option>';
								}
							}
							?>
						</select>
					</div>
                </div>
            </div>
			<div class="panel-body">
                <div class="input-group">
                    <div class="form-group">
						<label for="exampleInputEmail1"><?php echo language('others', 'SITE_SETTINGS_MD5ENC'); ?></label>
						<select name="md5" class="form-control">
							<?php
							if($settings['md5_enc'] == 0) {
								
								echo '
									<option value="0">No</option>
									<option value="1">Yes</option>
								';
								
							} else if($settings['md5_enc'] == 1) {
								
								echo '
									<option value="1">Yes</option>
									<option value="0">No</option>
								';
							}
							?>
						</select>
					</div>
                </div>
            </div>
			<div class="panel-body">
                <div class="input-group">
                    <div class="form-group">
						<label for="exampleInputEmail1"><?php echo language('others', 'SITE_SETTINGS_RELOADADMINS'); ?></label>
						<select name="reloadadmins" class="form-control">
							<?php
							if($settings['reloadadmins'] == 0) {
								
								echo '
									<option value="0">No</option>
									<option value="1">Yes</option>
								';
								
							} else if($settings['reloadadmins'] == 1) {
								
								echo '
									<option value="1">Yes</option>
									<option value="0">No</option>
								';
							}
							?>
						</select>
					</div>
                </div>
            </div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'servID120'); ?></label>
					<input type="text" name="id120" class="form-control" value="<?php echo $settings['servID1']; ?>" placeholder="<?php echo language('mobio', 'servID120'); ?>">
				</div>
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'balance120'); ?></label>
					<input type="text" name="b120" class="form-control" value="<?php echo $settings['balance1']; ?>" placeholder="<?php echo language('mobio', 'balance120'); ?>">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'servID240'); ?></label>
					<input type="text" name="id240" class="form-control" value="<?php echo $settings['servID2']; ?>" placeholder="<?php echo language('mobio', 'servID240'); ?>">
				</div>
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'balance240'); ?></label>
					<input type="text" name="b240" class="form-control" value="<?php echo $settings['balance2']; ?>" placeholder="<?php echo language('mobio', 'balance240'); ?>">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'servID480'); ?></label>
					<input type="text" name="id480" class="form-control" value="<?php echo $settings['servID3']; ?>" placeholder="<?php echo language('mobio', 'servID480'); ?>">
				</div>
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'balance480'); ?></label>
					<input type="text" name="b480" class="form-control" value="<?php echo $settings['balance3']; ?>" placeholder="<?php echo language('mobio', 'balance480'); ?>">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'servID600'); ?></label>
					<input type="text" name="id600" class="form-control" value="<?php echo $settings['servID4']; ?>" placeholder="<?php echo language('mobio', 'servID600'); ?>">
				</div>
				<div class="form-group col-md-6">
					<label><?php echo language('mobio', 'balance600'); ?></label>
					<input type="text" name="b600" class="form-control" value="<?php echo $settings['balance4']; ?>" placeholder="<?php echo language('mobio', 'balance600'); ?>">
				</div>
			</div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="edit" value="<?php echo language('buttons', 'EDIT'); ?>" />
                </div>
            </div>
        </form>
        <?php
        if (core_message('settings') != '') {
            echo '<div class="alert alert-info">
            ' . core_message('settings') . '
        </div>';
        }
        ?>
    </div>
</div>
<?php template('admin/footer'); ?>