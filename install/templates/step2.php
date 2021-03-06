<?php
if (!isset($db_connect_success) || $db_connect_success==false) {
    echo '<p class="error">'.$connection_status.'</p>';
    ?>
    <form action="" method="post">
        <?php
        require_once 'templates/db_form.php';
        ?>
        <button type="submit">Продолжить установку</button>
    </form>
    <?php
} elseif (isset($config_created) && $config_created==true) {
    ?>
        <p>Соединение с базой данных успешно установлено, конфигурационный файл создан.</p>
        <?php
        if(isset($dump_loaded)) {
            if ($dump_loaded==true) {
                ?> 
                    <h1>Поздравляем, система успешно установлена</h1>
                    <p><a href="/">Перейти на главную страницу сайта</a></p>
                    <p>Пожалуйста, не забудьте удалить директорию install/</p>
                <?php 
            } else {
                ?> 
                    <p class="error">По какойто причине дамп не был загружен, вероятно все необходимые данные уже есть в базе данных</p>
                    <p>Если сайт работает нормально то, не забудьте удалить директорию install.</p>
                    <p>Если сайт не работает, то попробуйте загрузить дамп вручную, предварительно заменив все %db-prefix% на префикс базы данных. Если это не поможет обратитесь за консультацией к разработчику. </p>
                <?php
            }
            ?>
            <p><a href="/">Переход на главную страницу сайта</a></p>
            <p><a href="/admin/">Переход в систему управления сайтом</a></p>
            <p>
            Данные для входа в систему управления:<br />
            Логин: <b>admin</b><br />
            Пароль: <b>admin</b><br />
            Не забудьте сменить пароли для пользователей admin и manager в разделе "Администраторы"
            </p>
        <?php
        }
} else {
    ?>
        <p>Соединение с базой данных успешно установлено, <span class="error">но конфигурационный файл не создан</span></p>
        <p>Обратитесь за консультацией к разработчику</p>
    <?php
}


