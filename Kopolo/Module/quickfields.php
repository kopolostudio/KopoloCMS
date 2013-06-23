<?php 
    /**
     * Стандартные типы полей, содержащие все настройки по умолчанию.
     * 
     * Если у поля нет определения и его название без префикса совпадает с названием quickfield, 
     * то используются соответствующий quickfield (например, "pg_name" - используется "name",
     * поле при этом можно вообще не определять).
     * 
     * Любое свойство quickfield может быть переопределено в определении поля с указанием 
     * переопределемого quickfield, например:
     *    'pg_name' => array (
     *        'quickfield' => 'name',
     *        'length' => 10
     *    )
     * 
     * @var array
     * @version 2 / 11.06.2011
     */
    $quickfields = array();
    
    $quickfields['id'] = array (
        'type' => 'integer',
        'unsigned' => 1,
        'notnull' => 1,
        'default' => 0,
        'primary' => 1,
        'autoincrement' => 1,
        'title' => 'ID',
        'form' => false,
        'actions' => false
    );
     
    $quickfields['parent'] = array (
        'type' => 'integer',
        'unsigned' => 1,
        'notnull' => 1,
        'default' => 0,
        'title' => 'Родитель',
        'form' => false,
        'actions' => false
    );
    
    $quickfields['name'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Название',
        'form' => array (
            'type' => 'text',
            'rules' => array(
                'required' => 'Заполнение этого поля обязательно'
            )
        ),
        'actions' => array (
            'list' => array (
                'editable' => true,
                'sortable' => true
            )
        ),
        'multilang' => true
    );
    
    $quickfields['picture'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Изображение',
        'form' => array (
            'type' => 'picture',
            'comment' => 'типы: jpg, gif, png; размер до ' . KOPOLO_MAX_IMAGE_WIDTH . 'х' . KOPOLO_MAX_IMAGE_HEIGHT . 'px; вес до ' . floor(KOPOLO_MAX_IMAGE_SIZE/1024) . ' Кб',
            'rules' => array(
                'maxfilesize' => array(
                    'message'=>'Вес файла превышает 1,5 Мб',
                    'options'=>KOPOLO_MAX_IMAGE_SIZE
                ),
                'mimetype' => array(
                    'message'=>'Переданный файл не является файлом типа: jpg, gif, png',
                    'options'=>array('image/gif', 'image/png', 'image/jpeg', 'image/pjpeg')
                ),
                'maximagesize' => array(
                    'message'=>'Размеры изображения превышают 1200х1200 px',
                    'options'=>array(
                        'maxwidth'=>KOPOLO_MAX_IMAGE_WIDTH,
                        'maxheight'=> KOPOLO_MAX_IMAGE_HEIGHT
                        /*, 'reversible'=>true //Проверка без учета формата изображения, шириной считаем большую сторону*/
                    )
                )
            ),
            'data' => array(
                'language'=>'ru',
                'filemanager'=>true
            )
        )
    );
    
    $quickfields['info'] = array (
        'type' => 'text',
        'length' => 5000,
        'default' => null,
        'title' => 'Информация',
        'form' => array (
            'type' => 'wysiwyg'
        ),
        'multilang' => true
    );
    
    $quickfields['nick'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Псевдоним',
        'form' => array (
            'type' => 'text',
            'comment' => 'название для использования в ULR (адресе страницы), допустимые символы: ' . (KOPOLO_USE_ENCODED_URLS==true?'русские и ':'') . 'латинские буквы в нижнем регистре, цифры, дефис и нижнее подчеркивание',
            'rules' => array(
                'required' => 'Заполнение этого поля обязательно',
                'regex' => array(
                    'message'=>'Недопустимые символы',
                    'options'=>(KOPOLO_USE_ENCODED_URLS==true?'/^[а-яa-z0-9_-]+$/u':'/^[a-z0-9_-]+$/')
                ),
            )
        ),
        'actions' => array (
            'list' => array (
                'editable' => true
            )
        )
    );
    
    $quickfields['email'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'E-mail',
        'form' => array (
            'type' => 'text',
            'comment' => 'введите корректный e-mail адрес',
            'rules' => array(
                'regex' => array(
                    'message'=>'Неправильный адрес',
                    'options'=>'/^[a-z,0-9]{1}[0-9,a-z,._+-]+@([a-z,0-9]{1}[0-9,a-z,_-]*[a-z,0-9]{1}[.])+[a-z,0-9]{2,5}+$/'
                ),
            )
        ),
        'actions' => array (
            'list' => array (
                'editable' => true
            )
        )
    );
    
    $quickfields['title'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Заголовок (title)',
        'form' => array (
            'type' => 'text'
        ),
        'multilang' => true
    );
    
    $quickfields['keywords'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Ключевые слова (keywords)',
        'form' => array (
            'type' => 'text'
        ),
        'multilang' => true
    );
    
    $quickfields['description'] = array (
        'type' => 'text',
        'length' => 255,
        'default' => null,
        'title' => 'Описание (description)',
        'form' => array (
            'type' => 'text'
        ),
        'multilang' => true
    );
    
    $quickfields['position'] = array (
        'type' => 'integer',
        'unsigned' => 1,
        'notnull' => 1,
        'default' => 1,
        'title' => 'Позиция',
        'form' => array (
            'type' => 'select'
        ),
        'actions' => array (
            'list' => false
        )
    );
    
    $quickfields['is_active'] = array (
        'type' => 'boolean',
        'notnull' => 1,
        'default' => 1,
        'title' => 'Активность',
        'form' => array (
            'type' => 'checkbox',
            'options' => array (
                0 => 'не активен',
                1 => 'активен'
            )
        ),
        'actions' => array (
            'list' => array (
                'editable' => true,
                'sortable' => true
            )
        )
    );
    
    $quickfields['is_system'] = array (
        'type' => 'boolean',
        'notnull' => 1,
        'default' => 0,
        'title' => 'Системная позиция (удаление запрещено)',
        'form' => array (
            'type' => 'checkbox'
        ),
        'actions' => false
    );
    
    $quickfields['date'] = array (
        'type' => 'integer',
        'unsigned' => 1,
        'notnull' => 1,
        'default' => 0,
        'title' => 'Дата',
        'form' => array (
            'type' => 'date',
            'rules' => array(
                'required' => 'Заполнение этого поля обязательно'
            )
        ),
        'actions' => array (
            'list' => array (
                'sortable' => true
            )
        )
    );
    
    $quickfields['datetime'] = $quickfields['date'];
    $quickfields['datetime']['title'] = 'Дата и время';
    $quickfields['datetime']['form']['type'] = 'datetime';
    
    $quickfields['last_modified'] = array (
        'type' => 'timestamp',
        'title' => 'Изменено',
        'form' => array (
            'type' => 'static'
        ),
        'actions' => false
    );
    
    $quickfields['added'] = array (
        'type' => 'timestamp',
        'title' => 'Добавлено',
        'form' => array (
            'type' => 'static'
        )
    );