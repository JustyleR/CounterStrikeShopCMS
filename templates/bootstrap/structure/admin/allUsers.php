<?php
template('admin/header');
$allUsers = pagination("SELECT * FROM users", 10);
?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ALL_EXISTING_USERS'); ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo language('others', 'EMAIL'); ?></th>
                        <th><?php echo language('profile', 'REGISTER_DATE'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($allUsers != NULL) {
							foreach ($allUsers[1] as $user) {
								echo '<tr>
								<td><a href="'. url .'!admin/searchUser/'.$user['email'].'">' . $user['email'] . '</a></td>
								<td>' . $user['registerDate'] . '</td>
							</tr>';
							}
						}
                    ?>
                </tbody>
            </table>
			<?php
			if($allUsers != NULL) {
				$pages = $allUsers[0];
				if($pages['prev'] != 0) {
					$prev = url . '!admin/allCodes/cPage/' . $pages['prev'];
				} else {
					$prev = '';
				}
				
				if($pages['next'] - 1 != $pages['max']) {
					$next = url . '!admin/allCodes/cPage/' . $pages['next'];
				} else {
					$next = '';
				}
			}
			?>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
				<li class="page-item"><a class="page-link" href="<?php echo $prev; ?>">Previous</a></li>
				<li class="page-item"><a class="page-link" href="<?php echo $next; ?>">Next</a></li>
				</ul>
			</nav>
        </div>
    </div>
</div>
<?php template('admin/footer'); ?>