<?php

/**
 * Класс для работы с деревьями NestedSets
 *
 * @author      Kopolo [kopolo.ru]
 * @license     http://kopolocms.ru/license/
 * @package     Tree
 * @version     0.1 [01.07.2010]
 */
 

class Kopolo_Tree_NestedSets extends Kopolo_Tree
{
    public $level = 'level';
    public $left = 'left';
    public $right = 'right';

    /**
     * Получение полного дерева вместе с корнем
     *
     * @return boolean
     */
    public function getFullTree($nesting = 0)
    {
        return;
    }

    /**
     * Получение ветки дерева начиная с определенной ноды, включая её
     *
     * @return boolean
     */
    public function getBranch($node_id, $additional_fields = false)
    {
        $node = $this->get ($node_id);
        if ($node != false) { // XXX: точно ли на false проверять?
            $left = $this->left;
            $right = $this->right;
            $node_left = $node->$left;
            $node_right = $node->$right;
            $this->whereAdd ($this->__prefix . $this->left . ">=" . $node_left);
            $this->whereAdd ($this->__prefix . $this->right . "<=" . $node_right);
            $this->orderBy($this->__prefix . $this->left);
            $this->find ();
            return $this->fetchArray ();
        } else {
            return false;
            // TODO: Обработка ошибки
        }
    }
    
    
    /**
     * Получение родителя ноды
     *
     * @return boolean
     */
    public function getParent($node_id, $additional_fields = false)
    {
        return;
    }
    
    
    /**
     * Получение всех родителей ноды
     *
     * @return boolean
     */
    public function getParents($node_id, $additional_fields = false)
    {
        return;
    }
    
    
   
    /**
     * Получение всех детей ноды
     *
     * @return boolean
     */
    public function getChildren($node_id, $nesting = 0, $additional_fields = false)
    {
        return;
    }
    
    
    
    /**
     * Добавление ноды
     *
     * @param $parent_node_id (integer) - ID ноды, которой добавляется потомок, по умолчанию - в корень
     * @param $position (integer) - позиция вставляемой ноды, по умолчанию - в конец
     * @param $additional_fields (array) - ассоциативный массив дополнительных полей для добавления, название поля => значение, по умолчанию не добавлять
     * @return integer - ID вставленной записи
     */
    public function addNode($parent_node_id = false, $position = 0, $additional_fields = false)
    {
        return;
    }
    
    /**
     * Создание корня дерева
     *
     * @return boolean
     */
    public function addRoot($additional_fields = false)
    {
        return;
    }
    
    
    /**
     * Удаление ноды
     *
     * @return boolean
     */
    public function deleteNode($node_id)
    {
        return;
    }
    
    
    /**
     * Удаление ноды
     *
     * @return boolean
     */
    public function deleteBranch($node_id)
    {
        return;
    }
    
    
    /**
     * Удаление (очистка) дерева
     *
     * @return boolean
     */
    public function deleteTree()
    {
        return;
    }
    
    
    /**
     * Перемещение ноды
     *
     * @return boolean
     */
    public function moveNode($moving_node_id, $position, $parent_node_id = 0)
    {
        return;
    }
    
    
    /**
     * Копирование ноды
     *
     * @return boolean
     */
    public function copyNode()
    {
        return;
    }
    
    
    /**
     * Копирование ветви
     *
     * @return boolean
     */
    public function copyBranch()
    {
        return;
    }
    
    
    /**
     * Создание дерева
     *
     * @return boolean
     */
    public function createTree($array = false, $nesting = 1, $count_children = 1)
    {
        return;
    }
    
    
    /**
     * Получение всех нод указанного уровня
     *
     * @return boolean
     */
    public function getByLevel($level = 1)
    {
        return;
    }
    
    /**
     * Проверка, есть ли у ноды потомки
     *
     * @return integer - число детей
     */
    public function hasChildren($node_id)
    {
        return;
    }
    
    
    /**
     * Конвертирование дерева в другой вид
     *
     * @return boolean
     */
    public function convertTree($tree_type_from, $tree_type_to)
    {
        return;
    }
   
}

?>