<?php
template('admin/header');
pages();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
		<div class="panel-body">
			<?php
			echo '[b]<b> '. language('bbcodes', 'BOLD') .'</b>[b] , 
			[i]<i> '. language('bbcodes', 'ITALIC') .'</i>[i] , [small]<small> '. language('bbcodes', 'SMALL') .'</small>[small] , <br />
			[font=color]<font color="green"> '. language('bbcodes', 'FONT_COLOR') .'</font>[font], [url=LINK]NAME[/url]';
			?>
		</div>
		
        <form action="" method="POST">
			<div class="panel-body">
				<input class="form-control" type="text" name="pageTitle" value="<?php if(isset($_SESSION['preview_text'])) { echo $_SESSION['preview_title']; } ?>" placeholder="<?php echo language('others', 'PAGE_TITLE'); ?>" />
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <textarea cols="55" rows="10" class="form-control" name="pageText" placeholder="<?php echo language('others', 'PAGE_TEXT'); ?>" style="resize: none;"><?php
					if(isset($_SESSION['preview_text'])) { echo $_SESSION['preview_text']; }
					?></textarea>
				</div>
            </div>
			<div class="panel-body">
				<input class="form-control" type="text" name="pageLink_name" placeholder="<?php echo language('others', 'PAGE_LINK_NAME'); ?>" />
            </div>
			<div class="panel-body">
				<input class="form-control" type="text" name="pageLink" placeholder="<?php echo language('others', 'PAGE_LINK'); ?>" />
            </div>
			<div class="panel-body">
				<small><?php echo language('others', 'PAGE_ACCESS'); ?></small>
				<select class="form-control" name="access">
					<option value="2"><?php echo language('others', 'PAGE_ACCESS_ALL'); ?></option>
					<option value="1"><?php echo language('others', 'PAGE_ACCESS_LOGGED'); ?></option>
					<option value="3"><?php echo language('others', 'PAGE_ACCESS_NOT_LOGGED'); ?></option>
				</select>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="add" value="<?php echo language('buttons', 'CREATE'); ?>" />
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
        if(core_message('addPage') != '') {
            echo core_message('addPage');
        } else {
			echo '&nbsp;';
		}
        ?>
    </div>
</div>
<?php template('admin/footer'); ?>