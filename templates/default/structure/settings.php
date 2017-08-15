<?php
template('header');
settings();
$settings = user_info($_SESSION['user_logged']);
?>

<div class="col-md-4 col-md-offset-3">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
            <input type="password" name="cpassword" class="form-control" placeholder="<?php echo language('others', 'CURRENT_PASSWORD'); ?>" maxlength="50" />
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
            <input type="text" name="npassword" class="form-control" placeholder="<?php echo language('others', 'NEW_PASSWORD'); ?>" maxlength="40" />
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0"><br /></div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
            <input type="email" name="emailtext" class="form-control" placeholder="<?php echo language('others', 'EMAIL'); ?>" maxlength="40" readonly />
            <input type="email" name="email" class="form-control" value="<?php echo $settings['email']; ?>" maxlength="40" required />
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon"><i class="glyphicon glyphicon-certificate"></i></div>
            <input type="email" name="nicknametext" class="form-control" placeholder="<?php echo language('others', 'NICKNAME'); ?>" maxlength="40" readonly />
            <input type="text" name="nickname" class="form-control" value="<?php echo $settings['nickname']; ?>" maxlength="40" required />
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon"><i class="glyphicon glyphicon-certificate"></i></div>
            <input type="email" name="passtext" class="form-control" placeholder="<?php echo language('others', 'PASSWORD_IN_GAME'); ?>" maxlength="40" readonly />
            <input type="text" name="nick_password" class="form-control" value="<?php echo $settings['nick_pass']; ?>" maxlength="40" required />
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0"><br /></div>

        <div class="input-group mb-2 mr-sm-2 mb-sm-0">

            <div class="input-group-addon"><?php echo language('others', 'LANGUAGE'); ?></div>
            <select name="lang" class="form-control">
                <?php
                $path     = 'language/';
                $results  = scandir($path);

                foreach ($results as $result) {
                    if ($result === '.' or $result === '..')
                        continue;

                    if (is_dir($path . '/' . $result)) {
                        echo '<option value="' . $result . '"';
                        if ($result === $settings['language']) {
                            echo 'selected';
                        }
                        echo '>' . $result . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0"><br /></div>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <?php
            $getAvatar = query("SELECT avatar_link FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
            if (num_rows($getAvatar) > 0) {
                $row = fetch_assoc($getAvatar);
                if ($row['avatar_link'] != NULL) {
                    echo '<img height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . 'templates/' . template . '/assets/img/avatars/' . $row['avatar_link'] . '" />';
                } else {
                    echo '<img height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . '/templates/' . template . '/assets/img/avatar.png" />';
                }
            } else {
                echo '<img height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . '/templates/' . template . '/assets/img/avatar.png" />';
            }
            ?>
            <label class="btn btn-default" for="upload-file-selector">
                <input id="upload-file-selector" name="avatar" type="file">
                <?php echo language('others', 'UPLOAD_AVATAR'); ?>
            </label>
        </div>
        <br />
        <input type="submit" name="save" class="btn btn-primary" value="<?php echo language('buttons', 'SAVE_CHANGES'); ?>" />
        <br /><br />
        <?php
        echo core_message('settings');
        ?>
    </form>
</div>
<?php template('footer'); ?>