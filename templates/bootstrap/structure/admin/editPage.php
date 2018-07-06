<?php
template('admin/header');
editPage();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
		<div class="panel-body">
			<?php
			$page = core_page();
			$check = query("SELECT * FROM pages WHERE page_id='". $page[2] ."'");
			if(num_rows($check) == 0) { core_header('home'); }
			
			$row = fetch_assoc($check);
			
			echo '[b]<b> '. language('bbcodes', 'BOLD') .'</b>[b] , 
			[i]<i> '. language('bbcodes', 'ITALIC') .'</i>[i] , [small]<small> '. language('bbcodes', 'SMALL') .'</small>[small] , <br />
			[font=color]<font color="green"> '. language('bbcodes', 'FONT_COLOR') .'</font>[font], [url=LINK]NAME[/url]';
			?>
		</div>
		
        <form action="" method="POST">
			<div class="panel-body">
				<input class="form-control" type="text" name="pageTitle" value="<?php echo $row['title']; ?>" placeholder="<?php echo language('others', 'PAGE_TITLE'); ?>" />
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <textarea cols="55" rows="10" class="form-control" name="pageText" placeholder="<?php echo language('others', 'PAGE_TEXT'); ?>" style="resize: none;"><?php
					if(isset($_SESSION['preview_text'])) { $text = str_replace("<br />", "\r\n", $_SESSION['preview_text']); } else { $text = str_replace("<br />", "\r\n", $row['text']); }
					
					echo $text;
					?></textarea>
				</div>
            </div>
			<div class="panel-body">
				<input class="form-control" type="text" name="pageLink_name" value="<?php echo $row['link_name']; ?>" placeholder="<?php echo language('others', 'PAGE_LINK_NAME'); ?>" />
            </div>
			<div class="panel-body">
				<input class="form-control" type="text" name="pageLink" value="<?php echo $row['link_page']; ?>"  placeholder="<?php echo language('others', 'PAGE_LINK'); ?>" />
            </div>
			<div class="panel-body">
				<small><?php echo language('others', 'PAGE_ACCESS'); ?></small>
				<select class="form-control" name="access">
					<?php
					$array = array(
					2 => language('others', 'PAGE_ACCESS_ALL'),
					1 => language('others', 'PAGE_ACCESS_LOGGED'),
					3 => language('others', 'PAGE_ACCESS_NOT_LOGGED')
					);
					foreach($array as $id => $list) {
						echo '<option '; 
						if($id == $row['logged']) {
							echo 'selected';
						}
						echo ' value="'. $id .'">'. $list .'</option>';
					}
					?>
				</select>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="edit" value="<?php echo language('buttons', 'EDIT'); ?>" />
					&nbsp;
					<input type="submit" class="btn btn-primary" name="preview" value="<?php echo language('buttons', 'PREVIEW'); ?>" />
					<?php
					if(isset($_SESSION['preview_title']) || (isset($_SESSION['preview_text']))) {
						?>
						&nbsp;
					<input type="submit" class="btn btn-primary" name="clearPreview" value="<?php echo language('buttons', 'CLEAR'); ?>" />
						<?php
					}
					?>
                </div>
            </div>
        </form>
		<?php
        if(core_message('editPage') != '') {
            echo core_message('editPage');
        } else {
			echo '&nbsp;';
		}
        ?>
    </div>
</div>
<?php template('admin/footer'); ?>