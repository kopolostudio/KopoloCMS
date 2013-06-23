<?php

/**
* Генератор форм
*
* генерирует формы из данных, заданных в админпанели (поля и пр.)
*
* @version 1.0 / 15.06.2011
* @author kopolo.ru
*/

class Controller_Forms_Generator extends Kopolo_Controller
{
    /**
     * Форма контроллера по умолчанию
     * @var string
     */
    public $template = 'form.tpl';
    
    protected function init()
    {
        $form_html = '';
        
        /* получение форм текущей страницы */
        $content = Kopolo_Registry::get('content');
        $page = $content->page;
        $page_id = $page['pg_id'];
        
        $form = new Module_Forms();
        $form->form_page = $page_id;
        $form->find();
        if ($form->N > 0) {
            Kopolo_Session::initSession();
            
            while ($form->fetch()) {
                $form_html .= $this->getFormHTML(&$form);
            }
            
            /*** передача данных в шаблон ***/
            $this->content->form = $form_html;
        }
    }
    
    /**
     * Получение HTML формы по ID
     *
     * @param object объект формы
     * @return string
     */
    protected function getFormHTML(&$form)
    {
        $form_html = '';

        /* получение списка полей */
        $fields = $form->getFields($form->form_id);
        if (count($fields)) {
            $form_html = $form->createForm($form, $fields);
        } else {
            Kopolo_Registry::error('В форме "' . $form_data->form_name . '" не найдено полей.');
        }
        
        return $form_html;
    }
}
?>