<html>

    <head>
        <meta charset="utf-8" />

        <title>SMS CMS by JustyleR v0.01</title>

        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/style.css'; ?>">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo url . 'templates/' . template . '/assets/js/bootstrap.min.js'; ?>"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(window).load(function () {
                $(".se-pre-con").fadeOut("slow");
            })
        </script>


    </head>

    <body>
        <div class="se-pre-con"></div>
        <?php
        if (isset($_SESSION['user_logged'])) {
            ?>
            <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand"><?php echo language('others', 'CPANEL'); ?></a>
                    </div>

                </div>
            </nav>
            <?php
        }
        ?>

        <div class = "container-fluid">
            <div class = "row">
                <?php
                if (isset($_SESSION['user_logged'])) {
                    ?>
                    <div class = "col-md-3 pad-top-10">

                        <div class = "panel-group">
                            <!---->
                            <div class = "panel panel-default">
                                
                                <div class="panel-content">
                                    <div class="user-name">
                                        <?php
                                        $getAvatar = query("SELECT avatar_link FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
                                        if (num_rows($getAvatar) > 0) {
                                            $row = fetch_assoc($getAvatar);
                                            if ($row['avatar_link'] != NULL) {
                                                echo '<img class="thumbnail img-responsive center-block" height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . 'templates/' . template . '/assets/img/avatars/' . $row['avatar_link'] . '" />';
                                            } else {
                                                echo '<img class="thumbnail img-responsive center-block" height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . '/templates/' . template . '/assets/img/avatar.png" />';
                                            }
                                        } else {
                                            echo '<img class="thumbnail img-responsive center-block" height="' . avatar_h . '" width="' . avatar_w . '" src="' . url . '/templates/' . template . '/assets/img/avatar.png" />';
                                        }
                                        ?>
                                        <strong><?php echo user_info($_SESSION['user_logged'])['email']; ?></strong><br />
                                        <button onclick="location.href = '<?php echo url . 'money'; ?>'" class="btn btn-sm btn-success"><?php echo user_info($_SESSION['user_logged'])['balance']; ?><i class="glyphicon glyphicon-usd"></i></button>
                                    </div>
                                </div>
                                <div class="panel-body list-group">
                                    <a href="<?php echo url . 'home' ?>" class="list-group-item"><i class="fa fa-home fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'HOME'); ?></a>
                                    <a href="<?php echo url . 'buyFlags/' ?>" class="list-group-item"><i class="fa fa-money fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'BUY_FLAGS'); ?></a>
                                    <a href="<?php echo url . 'flags/' ?>" class="list-group-item"><i class="fa fa-cloud fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'CURRENT_FLAGS'); ?></a>
                                    <a href="<?php echo url . 'logs' ?>" class="list-group-item"><i class="fa fa-history fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'LOG'); ?></a>
                                    <a href="<?php echo url . 'settings' ?>" class="list-group-item"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'SETTINGS'); ?></a>
                                    <?php
                                    if (isset($_SESSION['admin_logged'])) {
                                        echo '<a href="' . url . '!admin/home" class="list-group-item"><i class="fa fa-mail-forward fa-fw" aria-hidden="true"></i> &nbsp; ' . language('menu', 'TO_ADMIN_PANEL') . '</a>';
                                    }
                                    ?>
                                    <a href="<?php echo url . 'logout' ?>" class="list-group-item"><i class="fa fa-window-close fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'LOGOUT'); ?></a>
                                </div>
                            </div>
                            <!---->

                        </div>
                    </div>
                    <?php
                }
                echo '<div class="col-md-9 pad-top-10">';
                ?>