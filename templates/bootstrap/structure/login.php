<?php
template('header');
login();
?>

<div class="col-lg-9">
	
	  <div class="card card-outline-secondary my-4">
		<div class="card-header">
			<?php echo language('titles', 'LOGIN'); ?>
		</div>
		<div class="card-body">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-5">
						<div class="login-panel panel panel-default">
							<div class="panel-body">
								<form action="" method="POST">
									<fieldset>
										<div class="form-group">
											<input class="form-control" placeholder="<?php echo language('others', 'EMAIL'); ?>" name="email" type="email" autofocus required>
										</div>
										<div class="form-group">
											<input class="form-control" placeholder="<?php echo language('others', 'PASSWORD'); ?>" name="password" type="password" required>
										</div>
										
										<input type="submit" name="login" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'LOGIN'); ?>" />
										<br />
									</fieldset>
									<p>
									<center>&nbsp;<?php core_message('login'); ?></center>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	  <!-- /.card -->

	</div>
	<!-- /.col-lg-9 -->
<?php template('footer'); ?>