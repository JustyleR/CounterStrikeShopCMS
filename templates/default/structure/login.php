<?php
template('header');
login();
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-5">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo language('titles', 'LOGIN'); ?></h3>
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php echo language('others', 'EMAIL'); ?>" name="email" type="email" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php echo language('others', 'PASSWORD'); ?>" name="password" type="password" required>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" name="login" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'LOGIN'); ?>" />
                            <br />
                            <a href="index.php?p=register" class="btn btn-outline btn-warning btn-block"><?php echo language('menu', 'MAKE_REGISTRATION'); ?></a>
                            <a href="index.php?p=lostPassword" class="btn btn-outline btn-info btn-block"><?php echo language('menu', 'LOST_PASSWORD'); ?></a>
                        </fieldset>
                        <p>
                        <center>&nbsp;<?php core_message('login'); ?></center>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php template('footer'); ?>