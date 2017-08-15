<?php
template('header');
buyFlags();
$user     = user_info($_SESSION['user_logged']);
$server   = core_page()[1];
?>
<!--Popular-->
<div class="panel panel-default">
    <div class="panel-heading"><?php echo language('titles', 'BUY_FLAGS'); ?></div>
    <div class="panel-content">
        <p>
            <?php
			$getFlags = query("SELECT * FROM flags WHERE server='$server'");
			if(num_rows($getFlags) > 0) {
				
				echo '<form action="" method="POST">
            <fieldset class="form-group">';
			
			$adminID = csbans_getadminID($server);
			if($adminID != NULL) {
				$getAdminInfo = query("SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
				$row = fetch_assoc($getAdminInfo);
				while($row2 = fetch_assoc($getFlags)) {
					
					if (strpos($row['access'], $row2['flag']) === FALSE) {
						
						echo '<div class="form-check">
					<label class="form-check-label">
						' . $row2['price'] . '
						<input type="radio" class="form-check-input" name="flag" id="optionsRadios1" value="' . $row2['flag'] . '" />
						' . $row2['flagDesc'] . '
						</label>
						</div>';
						
						$_SESSION['has_flag'] = TRUE;
						
					}
					
				}
				
				if (isset($_SESSION['has_flag'])) {
                    echo '<input type = "submit" name = "buy" class = "btn btn-primary" value = "Buy" />';
                    unset($_SESSION['has_flag']);
                } else {
                    echo language('messages', 'NO_MORE_FLAGS_TO_BUY');
                }
			} else {
				csbans_createAdmin($server);
				core_header('buyFlags/' . $server, 0);
			}
			
			echo '</fieldset>
                    </form>';
				
			} else {
				
				echo language('messages', 'NO_FLAGS_ADDED');
				
			}
			?>
        </p>
        <p><?php core_message('flag'); ?></p>
    </div>
</div>
<?php
template('footer');
