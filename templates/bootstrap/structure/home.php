<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'TEXT_HOME_TITLE'); ?>
            </div>
            <div class="card-body">
				<p>
				<?php
				$query = query("SELECT * FROM sms_text");
				echo bbcode_preview(fetch_assoc($query)['home']);
				?>
				</p>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>