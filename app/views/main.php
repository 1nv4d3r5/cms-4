<?php if (!defined('INDIRECT')) die(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>CMS</title>
        <link href="http://fonts.googleapis.com/css?family=Fugaz+One" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Share" rel="stylesheet" type="text/css">
        <link href="http://cms.atburrow.com/cms/media/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="head_wrapper">
                <h1 class="site_name">
                    <a href="./">
                        CMS
                    </a>
                </h1>
            </div>
            <div class="content_wrapper">
                <h2 class="page_title">
                    <?php echo $page_title; ?>
                </h2>
                <div class="page_content">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="menu_wrapper">
                <ul class="menu">
                    <?php foreach ($menu_items as $menu_item): ?>
                    <li>
                        <a class="menu_item" href="http://cms.atburrow.com/cms/<?php echo Slug($menu_item['title']); ?>">
                            <?php echo $menu_item['title']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                </ul>
            </div>
        </div>
    </body>
</html>