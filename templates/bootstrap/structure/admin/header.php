<?php csbans_checkServers(); ?>
<html>

    <head>
        <meta charset="utf-8" />

        <title>SMS CMS by JustyleR v0.01 &bull; Admin Panel</title>

        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/abootstrap.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo url . 'templates/' . template . '/assets/css/astyle.css'; ?>">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo url . 'templates/' . template . '/assets/js/bootstrap.min.js'; ?>"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.navbar-toggle-sidebar').click(function () {
                    $('.navbar-nav').toggleClass('slide-in');
                    $('.side-body').toggleClass('body-slide-in');
                    $('#search').removeClass('in').addClass('collapse').slideUp(200);
                });

                $('#search-trigger').click(function () {
                    $('.navbar-nav').removeClass('slide-in');
                    $('.side-body').removeClass('body-slide-in');
                    $('.search-input').focus();
                });
            });
        </script>


    </head>

    <body>

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
                        
                    </button>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div><!-- /.container-fluid -->
        </nav>  	<div class="container-fluid main-container">
            <div class="col-md-2 sidebar">
                <div class="row">
                    <!-- uncomment code for absolute positioning tweek see top comment in css -->
                    <div class="absolute-wrapper"> </div>
                    <!-- Menu -->
                    <div class="side-menu">
                        <nav class="navbar navbar-default" role="navigation">
                            <!-- Main Menu -->
                            <div class="side-menu-container">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="<?php echo url . '!admin/home'; ?>"><i class="fa fa-home fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'HOME'); ?></a></li>

                                    <li class="panel panel-default" id="dropdown">
                                        <a data-toggle="collapse" href="#flags">
                                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'FLAGS'); ?> <span class="caret"></span>
                                        </a>

                                        <!-- Dropdown level 1 -->
                                        <div id="flags" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <li><a href="<?php echo url . '!admin/addFlag/'; ?>"><?php echo language('menu', 'ADD_FLAG'); ?></a></li>
                                                    <li><a href="<?php echo url . '!admin/allFlags/'; ?>"><?php echo language('menu', 'VIEW_ALL_FLAGS'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </li>

                                    <li class="panel panel-default" id="dropdown">
                                        <a data-toggle="collapse" href="#users">
                                            <i class="fa fa-user fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'MEMBERS'); ?> <span class="caret"></span>
                                        </a>

                                        <!-- Dropdown level 1 -->
                                        <div id="users" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <li><a href="<?php echo url . '!admin/searchUser/'; ?>"><?php echo language('menu', 'SEARCH_USER'); ?></a></li>
                                                    <li><a href="<?php echo url . '!admin/allUsers/cPage/1'; ?>"><?php echo language('menu', 'ALL_USERS'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
									
									<li class="panel panel-default" id="dropdown">
                                        <a data-toggle="collapse" href="#sms">
                                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'SMS'); ?> <span class="caret"></span>
                                        </a>

                                        <!-- Dropdown level 1 -->
                                        <div id="sms" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <li><a href="<?php echo url . '!admin/addCode'; ?>"><?php echo language('menu', 'SMS_ADD_CODE'); ?></a></li>
                                                    <li><a href="<?php echo url . '!admin/allCodes/cPage/1'; ?>"><?php echo language('menu', 'SMS_ALL_CODES'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </li>
									
									<li class="panel panel-default" id="dropdown">
                                        <a data-toggle="collapse" href="#text">
                                            <i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'TEXT_PAGES'); ?> <span class="caret"></span>
                                        </a>

                                        <!-- Dropdown level 1 -->
                                        <div id="text" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
													<li><a href="<?php echo url . '!admin/homeText/'; ?>"><?php echo language('menu', 'TEXT_HOME'); ?></a></li>
                                                    <li><a href="<?php echo url . '!admin/smsText/'; ?>"><?php echo language('menu', 'TEXT_SMS'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </li>
									
									<li class="panel panel-default" id="dropdown">
                                        <a data-toggle="collapse" href="#pages">
                                            <i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'PAGES'); ?> <span class="caret"></span>
                                        </a>

                                        <!-- Dropdown level 1 -->
                                        <div id="pages" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
													<li><a href="<?php echo url . '!admin/addPage/'; ?>"><?php echo language('menu', 'PAGES_ADD'); ?></a></li>
                                                    <li><a href="<?php echo url . '!admin/allPages/cPage/1'; ?>"><?php echo language('menu', 'PAGES_ALL'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </li>
									<li><a href="<?php echo url . '!admin/logs/cPage/1'; ?>"><i class="fa fa-database" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'LOGS'); ?></a></li>
                                    <li><a href="<?php echo url . '!admin/settings'; ?>"><i class="fa fa-wrench" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'SITE_SETTINGS'); ?></a></li>
                                    <li><a href="<?php  echo url;  ?>"><i class="fa fa-home fa-fw" aria-hidden="true"></i> &nbsp; <?php echo language('menu', 'TO_THE_SITE'); ?></a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </nav>

                    </div>
                </div>  	
            </div>