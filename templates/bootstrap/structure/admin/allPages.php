<?php
template('admin/header');
$allPages = pagination("SELECT * FROM pages", 10);
?>
<div class="col-md-10 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'ALL_EXISTING_PAGES'); ?>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo language('others', 'PAGE_LINK_NAME'); ?></th>
                        <th class="text-right"><?php echo language('others', 'ACTION'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                       if($allPages != NULL) {
							foreach ($allPages[1] as $page) {
								echo '<tr>
								<td>' . $page['link_name'] . '</td>
								<td class="text-right">
                                <a class="btn btn-primary btn-xs" href="' . url . '!admin/editPage/' . $page['page_id'] . '/"><span class="glyphicon glyphicon-edit"></span> ' . language('others', 'EDIT') . '</a>
                                <a class="btn btn-danger btn-xs" href="' . url . '!admin/deletePage/' . $page['page_id'] . '"><span class="glyphicon glyphicon-remove-circle"></span> ' . language('others', 'DELETE') . '</a>
                            </td>
							</tr>';
							}
						}
                    ?>
                </tbody>
            </table>
			<?php
			if($allPages != NULL) {
				$pages = $allPages[0];
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