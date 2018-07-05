<?php template('admin/header'); ?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            Dashboard
        </div>
        <div class="panel-body">
            <div class="row">
				<div class="information-box">
					<?php
					// Simple Statistics
					$users = query("SELECT user_id FROM users");
					$flags = query("SELECT flag_id FROM flags");
					$servers = query("SELECT server_id FROM servers");
					$codes = query("SELECT sms_code_id FROM sms_codes");
					?>
					<div class="information-left" style="color: #D9534F">
						<span><strong><?php echo num_rows($users); ?></strong><br /></span>
						<span>Users</span>
					</div>
					<div class="information-middle" style="color: #5CB85C">
						<span><strong><?php echo num_rows($servers); ?></strong><br /></span>
						<span>Servers</span>
					</div>
					<div class="information-middle" style="color: #11ABC1">
						<span><strong><?php echo num_rows($flags); ?></strong><br /></span>
						<span>Flags</span>
					</div>
					<div class="information-right" style="color: #337AB7">
						<span><strong><?php echo num_rows($codes); ?></strong><br /></span>
						<span>Codes</span>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php template('admin/footer'); ?>