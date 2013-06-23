<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $msg['title']; ?></title>
        <link href="<?php echo $config['url']; ?>skins/<?php echo $config['skin']; ?>/styles.css" type="text/css" rel="stylesheet" />
        <script src="<?php echo $config['url']; ?>lib/js/jquery.js" type="text/javascript" language="javascript"></script>
        <script src="<?php echo $config['url']; ?>lib/js/kopolofilemanager.js" type="text/javascript" language="javascript"></script>
        <!--script src="<?php echo $config['url']; ?>lib/js/fileuploader.js" type="text/javascript" language="javascript"></script-->
    </head>
    <body>
        <div class="toolbar">
            <?php include KFM_PATH . 'templates/toolbar.php'; ?>
        </div>
        <div class="clear"></div>
        
        <div class="tree">
            <?php include KFM_PATH . 'templates/tree.php'; ?>
        </div>
        
        <div class="content">
            <?php include KFM_PATH . 'templates/files.php'; ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <div class="info"><?php echo $msg['help_how_select_file']; ?></div>
    </body>
</html>