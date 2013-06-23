<?php
    /**
     * Стандартные типы полей БД, содержащие все настройки по умолчанию
     *
     * @var array
     * @link http://docs.kopolocms.ru/wiki/Quicktypes/
     */
    $quicktypes = array (
        'key' => array (
            'type' => 'integer',
            'unsigned' => 1,
            'notnull' => 1,
            'default' => 0,
            'primary' => 1,
            'autoincrement' => 1
        ),
        'bool' => array (
            'type' => 'boolean',
            'notnull' => 1,
            'default' => 0,
            'form' => array (
                'type' => 'checkbox',
            ),
            'actions' => array (
                'list' => array (
                    'editable' => true,
                    'sortable' => true
                )
            )
        ),
        'text' => array (
            'type' => 'text',
            'length' => 255,
            'form' => array (
                'type' => 'text'
            ),
            'multilang' => true
        ),
        'textarea' => array (
            'type' => 'text',
            'length' => 2000,
            'form' => array (
                'type' => 'textarea'
            ),
            'multilang' => true
        ),
        'select' => array (
            'type' => 'integer',
            'unsigned' => 1,
            'notnull' => 1,
            'default' => 0,
            'form' => array (
                'type' => 'select'
            )
        ),
        'checkbox' => array (
            'type' => 'boolean',
            'notnull' => 1,
            'default' => 0,
            'form' => array (
                'type' => 'checkbox',
                'options' => array (
                    0 => 'нет',
                    1 => 'да'
                )
            ),
            'actions' => array (
                'list' => array (
                    'editable' => true,
                    'sortable' => true
                )
            )
        ),
        'integer' => array (
            'type' => 'integer',
            'unsigned' => 1,
            'notnull' => 1,
            'default' => 0,
            'form' => array (
                'type' => 'text',
                'comment' => 'допустимые символы: только цифры',
                'rules' => array(
                    'regex' => array(
                        'message'=>'Недопустимые символы',
                        'options'=>'/^[0-9]+$/'
                    ),
                )
            )
        )
    );