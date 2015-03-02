<?php

class QdProductSetup extends QdRoot
{
    static $table_name = 'mpd_product_setup';

    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $tmp[$count]['product_per_segment'] = $item->product_per_segment;
            $tmp[$count]['optional'] = $item->optional;
            $count++;
        }
        return $tmp;
    }
}