<?php if (!defined('INDIRECT')) die(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <link href="http://fonts.googleapis.com/css?family=Fugaz+One" 
              rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Share" 
              rel="stylesheet" type="text/css">
        <style type="text/css">
            img {
                border: none;
            }
            
            div.wrapper {
                width: 500px;
                margin-left: auto;
                margin-right: auto;
                padding: 20px;
            }
            
            h2.page_title {
                font-family: Fugaz One, Helvetica;
                text-align: center;
            }
            
            div.auth_status {
                font-family: Helvetica;
                text-align: center;
                margin-bottom: 10px;
            }
            
            label.auth_input_label {
                font-family: Share, Helvetica;
                display: block;
                text-align: right;
                width: 140px;
                float: left;
                padding: 6px 0 0 0;
            }
            
            input.auth_input {
                font-family: Share;
                font-size: 1em;
                padding: 4px 2px;
                border: solid 1px #aacfe4;
                width: 200px;
                margin: 2px 0 20px 10px;
            }
            
            a.login_button {
                margin-left: auto;
                margin-right: auto;
                width: 100px;
            }
            
            a.button {
                font-family: Helvetica;
                display: block;
                height: 29px;
                border-radius: 9px;
                text-decoration: none;
                color: #000000;
                font-weight: bold;
                text-shadow: #FFFFFF 0 0 2px;
                background: #EEEEEE;
                border: 1px solid #EEEEEE;
                background: -moz-linear-gradient(top, #EEEEEE 0%, #CCCCCC 100%);
                background: -webkit-gradient(linear, left top, left bottom,
                    color-stop(0%, #EEEEEE), color-stop(100%, #CCCCCC));
                background: -webkit-linear-gradient(top, #EEEEEE 0%,
                    #CCCCCC 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #EEEEEE 0%,
                    #CCCCCC 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #EEEEEE 0%,
                    #CCCCCC 100%); /* IE10+ */
                background: linear-gradient(top, #EEEEEE 0%, #CCCCCC 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(
                    startColorstr = '#EEEEEE', endColorstr = '#CCCCCC',
                    GradientType = 0); /* IE6-9 */
            }

            a.button:active {
                background: #EEEEEE; /* Old browsers */
                background: -moz-linear-gradient(top,  #eeeeee 0%,
                    #dddddd 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom,
                    color-stop(0%,#eeeeee), color-stop(100%,#dddddd));
                background: -webkit-linear-gradient(top,  #eeeeee 0%,
                    #dddddd 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #eeeeee 0%,
                    #dddddd 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #eeeeee 0%,
                    #dddddd 100%); /* IE10+ */
                background: linear-gradient(top,  #eeeeee 0%,
                    #dddddd 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient(
                    startColorstr='#eeeeee', endColorstr='#cccccc',
                    GradientType=0 ); /* IE6-9 */
                outline: none;
            }

            a.button img {
                float: left;
                margin: 2px 5px 3px 5px;
                width: 24px;
                height: 24px;
            }

            a.button div {
                float: left;
                font-size: 0.9em;
                text-align: center;
                margin: 6px 15px 3px 5px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2 class="page_title"><?php echo $page_title; ?></h2>
            <div class="page_content">
                <?php if (isset($auth_status)): ?>
                    <div class="auth_status"><?php echo $auth_status; ?></div>
                <?php endif; ?>
                <form action="<?php echo URL::Absolute('admin/auth/login'); ?>"
                    method="post" style="margin-left: auto; margin-right: auto;
                    width: 450px;" id="login_form">
                    <div class="auth_input_wrapper">
                        <label class="auth_input_label">Username</label>
                        <input class="auth_input" type="text" name="username"
                               value=""/>
                    </div>
                    <div class="auth_input_wrapper">
                        <label class="auth_input_label">Password</label>
                        <input class="auth_input" type="password"
                               name="password"/>
                    </div>
                    <a href="javascript:void(0);" class="button login_button" 
                        onclick="document.getElementById('login_form').submit();
                            return false;">
                        <img src="<?php echo URL::Absolute(
                                'media/img/lock.png'); ?>"/>
                        <div>Login</div>
                    </a>
                    <input type="hidden" name="action" value="login"/>
                </form>
            </div>
        </div>
    </body>
</html>
