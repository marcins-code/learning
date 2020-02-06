<?php


namespace App\Helper;


class ArrayHelper
{
    public function tree(array $elements, $parentId = 0)
    {
        $tree = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->tree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $tree[] = $element;
            }
        }

        return $tree;
    }
}