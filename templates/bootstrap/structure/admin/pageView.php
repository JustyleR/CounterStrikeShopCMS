<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo $_SESSION['preview_title']; ?>
            </div>
            <div class="card-body">
				<p>
				<?php
				echo bbcode_preview($_SESSION['preview_text']);
				?>
				</p>
			</div>
		</div>
		<a href="<?php echo url . $_SESSION['preview_link']; ?>"><?php echo language('others', 'GO_BACK'); ?></a>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>