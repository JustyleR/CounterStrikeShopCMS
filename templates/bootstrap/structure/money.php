<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-body">
				<p>
				<?php
				money();
				
				$query = query("SELECT * FROM sms_text");
				echo bbcode_preview(fetch_assoc($query)['text']);
				?>
				</p>
				<form action="" method="POST">
					<fieldset>
						<div class="form-group">
							<input style="width:150px;" class="form-control" placeholder="<?php echo language('others', 'CODE'); ?>" name="code" type="text" autofocus required>
						</div>
						<input style="width:150px;" type="submit" name="add" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'REDEEM_SMS_CODE'); ?>" />
					</fieldset>
					<p>
						<br />
						&nbsp;<?php core_message('money'); ?>
					</p>
				</form>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>
