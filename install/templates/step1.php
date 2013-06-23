<table>
    <tr>
        <td>
            <h2>Основные требования к настройкам сервера</h2>
            <p>Список основных характеристик и настроек сервера, без которых корректная работа системы невозможна:</p>
            <table>
            <?php
            foreach ($requirements as $param) {
                if (isset($param['pass']) && $param['pass']==true) {
                    $value = '<strong class="success">Да</strong>';
                } else {
                    $value = '<strong class="error">Нет</strong>';
                }
                echo '<tr>
                    <td>'.$param['text'].'</td><td>'.$value.'</td>
                </tr>';
            }?>
            </table>
            
            <h2>Рекомендуемые настройки сервера</h2>
            <?php if($all_recommendations_pass!=true) {?><p>KopoloCMS будет работать с этими настройками, но возможна некорректная работа.</p><?php }?>
            <table>
            <tr>
                <th rowspan="2">Параметр</th>
                <td colspan="2">Значение</td>
            </tr>
            <tr>
                <th>Рекомендуемое</th>
                <th>Текущее</th>
            </tr>
            <?php
            $values_names = array(
                0=>'Выкл',
                1=>'Вкл'
            );
            foreach ($recommendations as $param) {
                $recommended = (int) $param['recommended'];
                $value = (int) $param['value'];
                echo '<tr>
                    <td>'.$param['text'].'</td>
                    <td><strong>'.$values_names[$recommended].'</strong></td>
                    <td><strong class="'.($recommended!=$value?'error':'success').'">'.$values_names[$value].'</strong></td>
                </tr>';
            }
            ?>
            </table>
        </td>
        <td>
            <?php 
            if ($all_requirements_pass == true) {
                //Сервер прошел проверку на соответствие основным требованиям
                ?>
                <form action="" method="post">
                    <?php
                    require_once 'db_form.php';
                    ?>
                    <button type="submit">Проверить соединение</button>
                </form>
                <?php
            } else {
                ?> 
                <h2 class="error">Сервер не прошел проверку на соответствие основным характеристикам и рекомендациям, дальнейшая работа установщика невозможна.</h2>
                <p>Вы можете попробовать установить систему вручную, на свой риск</p>
                <?php
            }
            ?>
        </td>
    </tr>
</table>