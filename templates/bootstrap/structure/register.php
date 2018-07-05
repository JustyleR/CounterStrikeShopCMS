<?php template('header'); ?>

<script>
function showName(str) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.responseType = 'text';
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
            if(xmlhttp.responseText != '') {
				document.getElementById("eemail").classList.remove('is-valid');
				document.getElementById("eemail").classList.add('is-invalid');
			} else {
				document.getElementById("eemail").classList.remove('is-invalid');
				document.getElementById("eemail").classList.add('is-valid');
			}
		}
	};
	xmlhttp.open("GET", "get.php?type=user&email=" + str, true);
	xmlhttp.send();
}
</script>

 <div class="col-lg-9">
		
          <div class="card card-outline-secondary my-4">
            <div class="card-header">
				<?php
				echo language('titles', 'REGISTRATION');
				register();
				?>
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
												<input id="eemail" class="form-control" placeholder="<?php echo language('others', 'EMAIL'); ?>" name="email" type="email" onkeyup="showName(this.value)" autofocus required>
												<div id="txtHint"></div>
											</div>
											<div class="form-group">
												<input class="form-control" placeholder="<?php echo language('others', 'PASSWORD'); ?>" name="password" type="password" required>
											</div>
											<div class="form-group">
												<input class="form-control" placeholder="<?php echo language('profile', 'CONFIRM_PASSWORD'); ?>" name="cpassword" type="password" required>
											</div>
											<input type="submit" name="register" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'REGISTER'); ?>" />
										</fieldset>
										<p>
											<?php core_message('register'); ?>
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