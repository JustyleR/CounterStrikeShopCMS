<?php
template('header');
smsText();
?>

<!--Popular-->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-body">
            <?php
			echo bbcode_preview($_SESSION['preview']);
			?>
		</div>
        <div class="panel-body">
            <form action="" method="POST">
                <fieldset>
                    <div class="form-group">
                        <input style="width:150px;" class="form-control" placeholder="<?php echo language('others', 'SMS_CODE'); ?>" value="WYSR49" name="code" type="text" autofocus required>
                    </div>
                    <input style="width:150px;" type="submit" name="add" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'REDEEM_SMS_CODE'); ?>" />
                </fieldset>
                <p>
                    <br />
                    &nbsp;<?php core_message('money'); ?>
                </p>
            </form>
        </div>
		<a href="<?php echo url . '!admin/smsText/' ?>"><?php echo language('others', 'GO_BACK'); ?></a>
		
    </div>
</div>
</div>
</div>
</div>
<?php template('footer'); ?>