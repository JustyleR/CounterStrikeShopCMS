<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php
				$query = query("SELECT * FROM pages WHERE link_page='". core_page()[0] ."'");
				$row = fetch_assoc($query);
				echo $row['title'];
				?>
            </div>
            <div class="card-body">
				<p>
				<?php
				echo bbcode_preview($row['text']);
				?>
				</p>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>