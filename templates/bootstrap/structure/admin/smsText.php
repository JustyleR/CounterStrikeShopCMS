<?php
template('admin/header');
smsText();
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
		<div class="panel-body">
			<?php
			echo '[b]<b> '. language('bbcodes', 'BOLD') .'</b>[b] , 
			[i]<i> '. language('bbcodes', 'ITALIC') .'</i>[i] , [small]<small> '. language('bbcodes', 'SMALL') .'</small>[small] , <br />
			[font=color]<font color="green"> '. language('bbcodes', 'FONT_COLOR') .'</font>[font]';
			?>
		</div>
		
        <form action="" method="POST">
            <div class="panel-body">
                <div class="input-group">
                    <textarea cols="55" rows="10" class="form-control" name="smsText" style="resize: none;"><?php
					$getText = query("SELECT * FROM sms_text");
					if(isset($_SESSION['preview'])) {
						echo bbcode_brFix($_SESSION['preview']);
					} else {
						echo bbcode_brFix(fetch_assoc($getText)['text']);
					}
					?></textarea>
				</div>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="submit" class="btn btn-primary" name="edit" value="<?php echo language('buttons', 'EDIT'); ?>" />
					&nbsp;
					<input type="submit" class="btn btn-primary" name="preview" value="<?php echo language('buttons', 'PREVIEW'); ?>" />
					<?php
					if(isset($_SESSION['preview'])) {
						?>
						&nbsp;
					<input type="submit" class="btn btn-primary" name="clearPreview" value="<?php echo language('buttons', 'CLEAR'); ?>" />
						<?php
					}
					?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php template('admin/footer'); ?>