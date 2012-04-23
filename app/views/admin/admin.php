<?php if (!defined('INDIRECT')) die(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $site_name; ?> Administration</title>
        <link href="http://fonts.googleapis.com/css?family=Fugaz+One"
              rel="stylesheet" type="text/css"/>
        <link href="http://fonts.googleapis.com/css?family=Share" 
              rel="stylesheet" type="text/css"/>
        <link href="<?php echo URL::Absolute('media/css/style.css'); ?>" 
              rel="stylesheet" type="text/css"/>
        <?php if (isset($head)): ?>
            <?php echo $head; ?>
        <?php endif; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="head_wrapper">
                <h1 class="site_name">
                    <a href="<?php echo URL::Absolute('admin'); ?>">
                        <?php echo $site_name; ?> Administration
                    </a>
                </h1>
                <div style="float: right; color: #FFFFFF; font-weight: bold; 
                     margin: 35px 0 0 0;">
                    <span>Welcome, <?php echo strlen($user['first_name']) > 0 ? 
                    $user['first_name'] : $user['username'] ?></span>
                    <a href="<?php echo URL::Absolute('admin/auth/logout'); ?>"
                       >Logout</a>
                </div>
            </div>
            <div class="content_wrapper">
                <h2 class="page_title">
                    <?php echo $page_title; ?>
                </h2>
                <div class="page_content">
                    <?php if (isset($status_message)): ?>
                        <h3><?php echo $status_message; ?></h3>
                    <? endif; ?>
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="menu_wrapper">
                <ul class="menu">
                    <?php if ($user['permission_manage_users']): ?>
                        <li><a href="<?php echo URL::Absolute('admin/user'); ?>"
                               class="menu_item">Users</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo URL::Absolute('admin/page'); ?>"
                           class="menu_item">Pages</a></li>
                    <li><a href="<?php echo URL::Absolute('admin/blog'); ?>"
                           class="menu_item">Blog</a></li>
                </ul>
            </div>
        </div>
    </body>
</html>