<?php
/**
 * Формы
 *
 * создание форм и управление ими
 *
 * @author  kopolo.ru
 * @version 1.0 [15.06.2011]
 * @package Forms
 */

class Module_Forms extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'form_';
    public $__multilang = true;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'has_many'   => array (
            'Module_Forms_Groups'  => 'form_id',
            'Module_Forms_Fields'  => 'form_id',
            'Module_Forms_Senders' => 'form_id'
        ),
        'belongs_to' => array (
            'Module_Pages' => 'form_page'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $form_id;

    public $form_name;
    public $form_nick;
    public $form_comment;
    public $form_page;
    public $form_method;
    public $form_action;
    public $form_submit_text;
    public $form_success_text;
    public $form_error_text;
    public $form_files_dir;
    public $form_save_answers;
    public $form_send_to_email;
    
    /**
     * Получение HTML формы
     * 
     * @param object объект формы
     * @param array  список полей формы
     * @return string
     */
    public function createForm($form_data, $fields)
    {
        $form = new Kopolo_Form($form_data->form_nick);
        
        /* добавление полей */
        foreach ($fields as $field) {
            $data = array();
            if ($field['fd_type'] == 'select') {
                $variants = new Module_Forms_Fields_Variants();
                $data['options'] = $variants->getVariants($field['fd_id']);
                if (empty($data['options'])) {
                    continue;
                }
            }
            $data['label'] = $field['fd_name'];
            $element = $form->addElement(
                $field['fd_type'], ('fields[' . $field['fd_id'] . ']'), array(), $data
            );
            if ($field['fd_required'] == 1) {
                $element->addRule('required', $field['fd_required_text']);
            }
        }
        
        $form->addElement('button', 'submit', array('type' => 'submit'),array('content' => $form_data->form_submit_text));
        
        /* валидация формы */
        if (!empty($_POST)) {
            $validation = $this->validateForm(&$form_data, &$form, $fields);
        }
        
        $html = $form->html();
        
        return $html;
    }
    
    /**
     * Получение списка полей формы
     * 
     * @param integer ID формы
     * @return array
     */
    public function getFields($form_id) {
        $fields_array = array ();
        
        $fields = new Module_Forms_Fields();
        $fields->fd_form = $form_id;
        $fields->orderBy('fd_position ASC');
        $fields->find();
        if ($fields->N > 0) {
            $fields_array = $fields->fetchArray();
        }
        return $fields_array;
    }
    
    /**
     * Валидация формы
     * 
     * @param object текущая форма
     * @param object объект конструктора форм (QuickForm)
     * @param array  поля формы
     *
     * @return boolean
     */
    protected function validateForm(&$form_data, &$form, $fields)
    {
        if ($form->validate()) {
            $values = $form->getValue(); 
            
            /* загрузка файлов */
            $upload_directory = !empty($form_data->form_files_dir)?$form_data->form_files_dir:ucwords($form_data->form_nick);
            $values = $this->uploadFiles($fields, $values, $upload_directory, &$form);
            
            $values = $this->checkSelects($fields, $values);
            
            /* проверка событий и их выполнение */
            if ($form_data->form_save_answers) {
                $senser = new Module_Forms_Senders();
                $senser->sn_form    = $form_data->form_id;
                $senser->sn_date    = time();
                $senser->sn_ip      = $_SERVER['REMOTE_ADDR'];
                
                /* TO DO включить проверку, куда сохранять - в общее поле или в key-value хранилище */
                $senser->sn_answer = $this->getHTML($fields, $values);
                if ($senser->insert()) {
                    Kopolo_Messages::success($form_data->form_success_text);
                    HTTP::redirect(Kopolo_Registry::get('uri'));
                    return true;
                }
            }
        } else {
            Kopolo_Messages::error($form_data->form_error_text);
        }
        return false;
    }
    
    /**
     * Проверка типов полей с вариантами ответа
     * 
     * @param array  поля формы
     * @param array  значения формы
     *
     * @return array обновленные значения формы
     */
    protected function checkSelects($fields, $values)
    {
        foreach ($fields as $field){
            $value = @$values['fields'][$field['fd_id']];
            if ($field['fd_type'] == 'select') {
                $variants = new Module_Forms_Fields_Variants();
                $options = $variants->getVariants($field['fd_id']);
                $values['fields'][$field['fd_id']] = $options[$value];
            }
        }
        return $values;
    }
    
    /**
     * Загрузка файлов
     * 
     * @param array  поля формы
     * @param array  значения формы
     * @param string директория для загрузки (относительный путь без откр. и закр. слешей)
     *
     * @return array обновленные значения формы
     */
    protected function uploadFiles($fields, $values, $directory)
    {
        foreach ($fields as $field){
            $value = @$values['fields'][$field['fd_id']];
            if ($field['fd_type'] == 'file' && is_array($value)) {
                if (isset($value['tmp_name']) && !empty($value['tmp_name'])) {
                    $file_path = Kopolo_File::moveUploadedFile($value, $directory);
                } else {
                    $file_path = '';
                }
                $values['fields'][$field['fd_id']] = $file_path;
            }
        }
        return $values;
    }
    
    /**
     * Получение HTML с данными из формы
     * 
     * @param array  поля формы
     * @param array  значения формы
     *
     * @return string
     */
    protected function getHTML($fields, $values) 
    {
        $template = Kopolo_Template::factory ('forms/answer_data.tpl');
        $template->assign('fields', $fields);
        $template->assign('values', $values);

        return $template->getHTML();
    }
}