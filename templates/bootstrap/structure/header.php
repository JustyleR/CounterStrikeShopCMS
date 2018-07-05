<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMS CMS by JustyleR v0.1 ALPHA</title>

    <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/bootstrap.min.css'; ?>" />
   
    <!-- Custom styles for this template -->
	<link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/shop-item.css'; ?>" />
	
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/font-awesome.min.css'; ?>" />
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/style.css'; ?>" />

  </head>
  
	<body>
	
	    <!-- Navigation -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<div class="container">
				<a class="navbar-brand" href="#"><?php echo language('others', 'CPANEL'); ?></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<?php
						$query = query("SELECT * FROM pages");
						if(num_rows($query) > 0) {
							while($r = fetch_assoc($query)) {
								
								if($r['logged'] == 3) {
									if(!isset($_SESSION['user_logged'])) {
										echo '
										<li class="nav-item">
											<a class="nav-link" href="'. url . $r['link_page'] .'">'. $r['link_name'] .'</a>
										<li>
										';
									}
								} else if($r['logged'] == 1) {
									if(isset($_SESSION['user_logged'])) {
										echo '
										<li class="nav-item">
											<a class="nav-link" href="'. url . $r['link_page'] .'">'. $r['link_name'] .'</a>
										<li>
										';
									}
								} else if($r['logged'] == 2) {
									echo '
										<li class="nav-item">
											<a class="nav-link" href="'. url . $r['link_page'] .'">'. $r['link_name'] .'</a>
										<li>
										';
								}
								
							}
						}
						if(isset($_SESSION['user_logged'])) {
							$user = user_info($_SESSION['user_logged']);
							?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo url . 'profile/' . $user['id']; ?>"><?php echo $user['email']; ?> [ <?php echo $user['balance']; ?>$ ]</a>
							<li>
							<li class="nav-item">
							  <a class="nav-link" href="<?php echo url . 'settings' ?>"><?php echo language('menu', 'SETTINGS'); ?></a>
							</li>
							<li class="nav-item">
							  <a class="nav-link" href="<?php echo url . 'logout' ?>"><?php echo language('menu', 'LOGOUT'); ?></a>
							</li>
							<?php
						} else {
							?>
							<li class="nav-item">
							  <a class="nav-link" href="<?php echo url . 'login'; ?>"><?php echo language('menu', 'LOGIN'); ?></a>
							</li>
							<li class="nav-item">
							  <a class="nav-link" href="<?php echo url . 'register'; ?>"><?php echo language('menu', 'MAKE_REGISTRATION'); ?></a>
							</li>
							<li class="nav-item">
							  <a class="nav-link" href="<?php echo url . 'lostPassword/'; ?>"><?php echo language('menu', 'LOST_PASSWORD'); ?></a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
		
		 <!-- Page Content -->
    <div class="container">

      <div class="row">

        <?php
		if(isset($_SESSION['user_logged'])) {
			?>
			<div class="col-lg-3">
			  
			  <div class="list-group">
				<a href="<?php echo url . 'home' ?>" class="list-group-item"><i class="fa fa-home fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'HOME'); ?></a>
				<a href="<?php echo url . 'money' ?>" class="list-group-item"><i class="fa fa-dollar fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'ADD_BALANCE'); ?></a>
				<a href="<?php echo url . 'buyFlags/' ?>" class="list-group-item"><i class="fa fa-money fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'BUY_FLAGS'); ?></a>
				<a href="<?php echo url . 'flags/' ?>" class="list-group-item"><i class="fa fa-cloud fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'CURRENT_FLAGS'); ?></a>
				<a href="<?php echo url . 'logs/cPage/1' ?>" class="list-group-item"><i class="fa fa-history fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'LOG'); ?></a>
				<?php
				if (isset($_SESSION['admin_logged'])) {
					echo '<a href="' . url . '!admin/home" class="list-group-item"><i class="fa fa-mail-forward fa-fw" aria-hidden="true"></i> &nbsp; ' . language('menu', 'TO_ADMIN_PANEL') . '</a>';
				}
				?>       
			  </div>
			</div>
			<!-- /.col-lg-3 -->
			<?php
		}
		?>