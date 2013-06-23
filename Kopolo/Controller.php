<?php
/**
* Базовый контроллер, от него наследуют все остальные контроллеры (которые работают с контентом)
* 
* @version 1.5 / 27.09.2011
*/

class Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * 
     * @var string
     */
    public $template;
    
    /**
     * Ошибка 404
     * 
     * @var boolean
     */
    public $error404 = false;
    
    /**
     * Данные, подлежащие передаче в шаблон
     * 
     * @var object
     */
    protected $content;
    
    /**
     * Конструктор
     * 
     * @param array параметры: название переменной => значение
     */
    public function __construct (array $parameters=array())
    {
        $this->parameters = $parameters;
        $this->setParams($parameters);
        $this->init();
    }
    
    /**
    * получение свойства content, содержащего все переменные, которые необходимо передать в шаблон контроллера
    * 
    * @return object
    */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
    * Добавление переменной в шаблон контроллера
    * 
    * @param string название переменной в шаблоне
    * @param mixed переменная
    * @return boolean
    */
    protected function addContent($name, $var)
    {
        if (!empty($name) && is_string($name)) {
            if (!isset($this->content->$name)) {
                $this->content->$name = $var;
                return true;
            } else {
                Kopolo_Registry::warning('Переменная -' . $name . '- уже существует в шаблоне данного компонента.');
            }
        }
        return false;
    }
    
    /**
    * получение постраничной навигации
    * 
    * Example:
    *    Controller:
    *       $pager = $this->getPager($items, 3);
    *       $items = $pager->getPageData();
    *    Template:
    *       $pager->links; //HTML of pager
    * 
    * @param array     массив элементов
    * @param integer   число элементов на странице
    * @param integer   текущая страница
    * @param string    URL, использующийся в ссылках на страницы
    * @param string    тип постраничной навигации (Sliding | Jumping)
    * 
    * @return object
    */
    public function getPager(array $items, $items_per_page, $current_page=false, $url=false, $mode='Sliding') {
        include_once 'Pager/Pager.php';
        include_once 'Pager/' . $mode . '.php';
        
        /* если номер текущей страницы не передан, то получаем его из запроса (GET или POST) */
        if ($current_page==false) {
            $current_page = (isset ($_REQUEST['page']) ? $_REQUEST['page'] : 1);
            if ($current_page == 'all') {
                $items_per_page = count($items);
            }
        }
        
        /* если не передан URL, получаем его из текущего */
        if ($url==false) {
            $url = Kopolo_Registry::get('uri');
            
            /* если в URL уже содержится информация о странице, отбрасываем последний элемент URL */
            if (isset($_REQUEST['page'])) {
                $nicks = explode('/', rtrim($url, '/'));
                array_pop($nicks);
                $url = join('/', $nicks) . '/';
            }
        }
        
        /* установка параметров */
        $params = array(
            'itemData' => $items,
            'perPage' => $items_per_page,
            'currentPage' => $current_page,
            'httpMethod' => 'HTACCESS',
            'url' => $url,
            'delta' => 8,
            'append' => true,
            'separator' => ' | ',
            'clearIfVoid' => false,
            'urlVar' => (KOPOLO_USE_ENCODED_URLS==true ? 'страница' : 'page'),
            'useSessions' => true,
            'closeSession' => true,
            'mode'  => $mode,
            'altFirst'      =>  'на первую страницу',
            'firstLinkTitle'=>  'на первую страницу',
            'altLast'       =>  'на последнюю страницу',
            'lastLinkTitle' =>  'на последнюю страницу',
            'altPrev'       =>  'на предыдущую страницу',
            'prevLinkTitle' =>  'на предыдущую страницу',
            'altPage'       =>  'на страницу №',
            'altNext'       =>  'на следующую страницу',
            'nextLinkTitle' =>  'на следующую страницу',
            'prevImg'     =>   '<< назад',
            'nextImg'     =>   'вперед >>',
            'spacesBeforeSeparator'  =>  1,
            'spacesAfterSeparator'   =>  1
        );
        $pager = &Pager::factory($params);
        
        /* установка доп. параметров для шаблона (добавление в $params не работает) */
        $pager->_urlVarAll = (KOPOLO_USE_ENCODED_URLS==true ? 'все' : 'all');
        
        /* используем собственный шаблон для постраничной навигации */
        $template = Kopolo_Template::factory ('pager/'.$mode.'.tpl');
        $template->assign ('url', $url);
        $template->assign ('pager', $pager);
        $pager->links = $template->getHTML();
        
        return $pager;
    }
    
    /**
    * Установка параметров контроллера
    */
    protected function setParams()
    {
        return;
    }
    
    /**
    * в методе размещается основной код контроллера
    * в результате работы метода как правило устанавливаются данные в $this->content для вывода в шаблон
    */
    protected function init()
    {
        return;
    }
}
?>