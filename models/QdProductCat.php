<?php
class QdProductCat extends QdRoot
{
    static $table_name = 'mpd_product_cat';

    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $tmp[$count]['name'] = $item->name;
            $tmp[$count]['parent_id'] = $item->parent_id;
            $count++;
        }
        $tmp2 = array(
            'Total' => count($tmp),
            'Rows' => $tmp
        );
        return json_encode($tmp2);
    }
}