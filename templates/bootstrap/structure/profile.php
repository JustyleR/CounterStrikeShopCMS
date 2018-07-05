<?php template('header'); ?>

	<div class="col-lg-9">
		
		<div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php echo language('titles', 'VIEW_PROFILE'); ?>
            </div>
            <div class="card-body">
				<div class="row">
					<?php
					$query = query("SELECT * FROM users WHERE user_id='". core_page()[1] ."'");
					$row = fetch_assoc($query);
					?>
					<div class=" col-md-9 col-lg-9 "> 
					  <table class="table table-user-information">
						<tbody>
						  <tr>
							<td><?php echo language('profile', 'NICKNAME'); ?>:</td>
							<td><?php echo $row['nickname']; ?></td>
						  </tr>
						  <tr>
							<td><?php echo language('profile', 'BALANCE'); ?>:</td>
							<td><?php echo $row['balance']; ?><small><i class="glyphicon glyphicon-usd"></i></small></td>
						  </tr>
						  <tr>
							<td><?php echo language('profile', 'REGISTER_DATE'); ?>:</td>
							<td><?php echo $row['registerDate']; ?></td>
						  </tr>

						 
						</tbody>
					  </table>
					</div>
				 </div>
			</div>
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
		
<?php template('footer'); ?>>
</div>