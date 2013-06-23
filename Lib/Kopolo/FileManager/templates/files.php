<?php
/* Шаблон выводит список файлов директории */

if (isset($files) && count($files)) {
    foreach ($files as $num => $file) { 
    ?>
        <div class="file">
            <?php 
            $filename = $file['filename'];
            if (!empty($file['thumbnail'])) { 
                $img = $file['thumbnail'];
            } else {
                $file_type_img = $config['skin_path'] . '/filetypes/' . $file['extension'] . '.png';
                if (file_exists(KOPOLO_PATH . substr($file_type_img, 1))) {
                    $img = $file_type_img;
                } else {
                    $img = $config['url'] . 'skins/' . $config['skin'] . '/filetypes/unknown.png';
                    $filename = $file['basename'];
                }
            }
            ?>
            <div class="preview">
                <img src="<?php echo $img; ?>" title="<?php echo $filename;?>" />
            </div>
            <div class="name">
                <a href="#" rel="<?php echo $selected_dir; ?>/<?php echo $file['basename']; ?>" title="<?php echo $file['basename']; ?>">
                    <?php
                        /* Trunkate name of file, if it's too much long */
                        if (mb_strlen($filename) > $config['filename']['length']) {
                            echo mb_substr($filename, 0, $config['filename']['length']) . '...';
                        } else {
                            echo $filename;
                        }
                    ?>
                </a>
            </div>
        </div>
    <?php
    }
} else {
    echo $msg['no_files_in_dir'];
}
?>
