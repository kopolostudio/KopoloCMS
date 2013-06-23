<?php
/* Шаблон выводит дерево директорий (рекурсивно) */

if (isset($tree) && is_array($tree)) {
?>
    <ul class="level-<?php echo !empty($dir['level'])?$dir['level']:0; ?>">
    <?php
    foreach ($tree as $num => $dir) {
        $dir_path[$dir['level']] = (isset($dir_path[$dir['level']-1]) ? $dir_path[$dir['level']-1] : '') . '/' . $dir['name'];
    ?>
        <li>
            <?php
            /* субдиректории */
            if (isset($dir['subdir']) && count($dir['subdir'])) {
                ?><a href="#" class="expand"></a><?php
            } else {
                ?><a href="#" class="empty"></a><?php
            }
            ?>
            <a href="#" rel="<?php echo $dir_path[$dir['level']]; ?>" title="<?php echo $dir['name']; ?>" class="folder<?php if(isset($selected_dir) && $selected_dir == $dir_path[$dir['level']]){echo ' selected';}?>">
                <span>
                <?php
                    /* Trunkate name of directory, if it's too much long */
                    if (mb_strlen($dir['name']) > $config['dirname']['length']) {
                        echo mb_substr($dir['name'], 0, $config['dirname']['length']) . '...';
                    } else {
                        echo $dir['name'];
                    }
                ?>
                </span>
            </a>
            <?php
            /* субдиректории */
            if (isset($dir['subdir']) && count($dir['subdir'])) {
                $tree = $dir['subdir'];
                include 'tree.php';
            }
            ?>
        </li>
    <?php
    }
    ?>
    </ul>
<?php
}
?>