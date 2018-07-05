<?php
template('admin/header');
editUser();
$email     = core_POSTP(core_page()[2]);
?>
<div class="col-md-4 col-md-offset-3 content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo language('titles', 'VIEW_USER'); ?>
        </div>
        <div class="panel-body">
            <?php
            $checkUser = query("SELECT * FROM users WHERE email LIKE'$email%'");
            if (num_rows($checkUser) > 0) {
                $row = fetch_assoc($checkUser);
                $_SESSION['original_email'] = $row['email'];
                ?>
                <form action="" method="POST">
                    <div class="panel-body">
                        <label for="email"><?php echo language('others', 'EMAIL'); ?></label>
                        <div class="input-group">
                            <input size="35" type="email" class="form-control" name="email" placeholder="<?php echo language('others', 'EMAIL'); ?>" value="<?php echo $row['email']; ?>" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <label for="password"><?php echo language('profile', 'NEW_PASSWORD'); ?></label>
                        <div class="input-group">
                            <input size="35" type="password" class="form-control" name="password" placeholder="<?php echo language('profile', 'NEW_PASSWORD'); ?>" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <label for="nickname"><?php echo language('others', 'NICKNAME'); ?></label>
                        <div class="input-group">
                            <input size="35" type="text" class="form-control" name="nickname" placeholder="<?php echo language('others', 'NICKNAME'); ?>" value="<?php echo $row['nickname']; ?>" aria-describedby="basic-addon1">
                        </div>
                        <label for="nickname-password"><?php echo language('others', 'PASSWORD_IN_GAME'); ?></label>
                        <div class="input-group">
                            <input size="35" type="text" class="form-control" name="nickname_pass" placeholder="<?php echo language('others', 'PASSWORD_IN_GAME'); ?>" value="<?php echo $row['nicknamePass']; ?>" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <label for="balance"><?php echo language('others', 'BALANCE'); ?></label>
                        <div class="input-group">
                            <input size="5" type="text" class="form-control" name="balance" placeholder="<?php echo language('others', 'BALANCE'); ?>" value="<?php echo $row['balance']; ?>" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <label for="inputPassword4"><?php echo language('others', 'GROUP'); ?></label>
                        <div class="input-group">
                            <select name="type" class="form-control">
                                <?php
                                $array = array(
                                        "0" => language('groups', 'banned'),
                                        "1" => language('groups', 'member'),
                                        "2" => language('groups', 'admin')
                                        );
                                foreach($array as $id=>$type) {
                                    echo '<option value="'.$id.'"';  
                                    if($row['type'] == $id) {
                                        echo 'selected';
                                    }
                                    echo '>'. $type .'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
					
					<div class="panel-body">
                        <label for="balance"><a href=""><input type="submit" class="btn btn-danger" name="delete" value="<?php echo language('buttons', 'DELETE'); ?>"></a></label>
                    </div>
                    
                    <div class="panel-body">
                        <div class="input-group">
                            <input type="submit" class="btn btn-primary" name="edit" value="<?php echo language('buttons', 'EDIT'); ?>">
                        </div>
                    </div>
                </form>
            
                &nbsp; <?php core_message('edit_user'); ?>
                <?php
            } else {
                echo language('messages', 'USER_NOT_FOUND') . '<br /><a href="' . url . '!admin/searchUser/">' . language('menu', 'GO_BACK') . '</a>';
            }
            ?>
        </div>
    </div>
</div>
</div>
<?php template('admin/footer'); ?>