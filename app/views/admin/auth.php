<?php if (!defined('INDIRECT')) die(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo "{$settings['site_name']} Administration - Authentication"; ?></title>
        <link href="http://fonts.googleapis.com/css?family=Fugaz+One" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Share" rel="stylesheet" type="text/css">
        <link href="<?php echo URL::Absolute('media/css/style.css'); ?>" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            label.auth_input_label {
                display: block;
                font-weight: bold;
                text-align: right;
                width: 140px;
                float: left;
                padding: 6px 0 0 0;
            }
            
            input.auth_input {
                float: left;
                font-size: 12px;
                padding: 4px 2px;
                border: solid 1px #aacfe4;
                width: 200px;
                margin: 2px 0 20px 10px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="head_wrapper">
                <h1 class="site_name">
                    <a href="<?php echo URL::Absolute(); ?>">
                        CMS
                    </a>
                </h1>
            </div>
            <div class="content_wrapper">
                <h2 class="page_title"><?php echo $page_title; ?></h2>
                <div class="page_content">
                    <form action="." method="post" style="margin: 10px 0 0 0; width: 400px;">
                        <label class="auth_input_label">Username</label>
                        <input class="auth_input" type="text" name="username" value=""/>
                        
                        <label class="auth_input_label">Password</label>
                        <input class="auth_input" type="password" name="password"/>
                        
                        <input type="submit" value="Login" style="margin-left: 150px;"/>
                        <input type="hidden" name="action" value="login"/>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>