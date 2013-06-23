<?php

/**
 * Класс для работы с деревьями Adjacency List
 *
 * @version 0.3 [05.12.2010]
 * @package Tree
 */
 

class Kopolo_Tree_AdjacencyList extends Kopolo_Tree
{
    //public $parent;
    
    /**
     * Получение полного дерева вместе с корнем
     * 
     * @param integer максимальная вложенность
     * @return array
     */
    public function getFullTree ($nesting = 0)
    {
        $object = $this;
        $this->setFieldsNames();
        
        $object->selectAdd($this->parent_field);
        $object->find ();

        if($object->N == 0) return false;

        $list = array();
        
        /* перебирает и складывает все ноды в массив: ID родителя => массив свойств ноды */
        while ($object->fetch ()) {
            if(!isset($list[$object->{$this->parent_field}])) {
                $list[$object->{$this->parent_field}] = array();
            }
            $list[$object->{$this->parent_field}][$object->{$this->id_field}]= $object->toArray();
        }
        
        return $this->treeListTree($list, 0, $nesting);
    }

    /**
     * Перебирает массив и складывает детей в родителей (рекурсия)
     * 
     * @param array   массив: идентификатор родительского элемента => список дочерних элементов
     * @param integer ID корневого элемента
     * @param integer максимальная вложенность (0 - не ограничего)
     * @param integer текущий уровень вложенности
     * @return array дети в родительстком массиве располагаются во вложенном массиве с ключом children
     */
    private function treeListTree(&$list, $id=0, $nesting=0, $level=1)
    {
        $tree = array();
        
        /* если вложенность неограничена или текущий уровень не больше допустимого (nesting) */
        if ($nesting == 0 || ($nesting != 0 && $level <= $nesting)) {
            foreach ($list[$id] as $id_child => $object) {
                $object['level'] = $level; /*установка текущего уровня вложенности*/
                if (isset($list[$id_child])) {
                    /* рекурсивное получение потомков */
                    $object['children'] = $this->treeListTree($list, $id_child, $nesting, ++$level);
                } else {
                    $object['children'] = array();
                }
                $tree[$id_child] = $object;
            }
        }
        return $tree;
    }
    
    /**
     * Получение всех детей ноды TO DO корректное получение уровня
     *
     * @param integer ID родителя, детей которого нужно выбрать
     * @return boolean
     */
    public function getChildren($node_id)
    {
        $this->setFieldsNames();
        
        $this->whereAdd($this->parent_field . '=' . $node_id);
        $this->find();
        
        $children = $this->fetchArray();
        
        //определения уровня
        if ($node_id == 0) {
            $level = 1;
        } else {
            $level = 2; //XXX страшный престрашный костыль
        }
        
        foreach($children as $num => $child) {
            $children[$num]['level'] = $level;
        }
        
        return $children;
    }
    
    /**
     * Устанавливает свойства класса с именами ключевых необходимых полей
     *
     * @return void
     */
    private function setFieldsNames() 
    {
        /*название поля с идентификатором элемента*/
        $this->id_field = $this->__prefix . "id"; 
        
        /*название поля с идентификатором родительского элемента*/
        $this->parent_field = $this->__prefix . "parent"; 
    }
}
?>