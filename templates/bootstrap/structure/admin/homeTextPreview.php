<?php
template('header');
homeText();
?>

<!--Popular-->
<div class="panel panel-default">		
    <div class="panel-heading"><?php echo language('titles', 'TEXT_HOME_TITLE'); ?></div>
    <div class="panel-content">
        <p>
			<br />
            <?php
			echo bbcode_preview($_SESSION['preview']);
			?>
        </p>
    </div>
	<a href="<?php echo url . '!admin/homeText/' ?>"><?php echo language('others', 'GO_BACK'); ?></a>
</div>
</div>
</div>
</div>
<?php template('footer'); ?>