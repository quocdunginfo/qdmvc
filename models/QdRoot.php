<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRoot extends ActiveRecord\Model
{
    static $table_name = 'mpd_';

    # explicit pk since our pk is not "id"
    static $primary_key = 'id';

    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $count++;
        }
        return json_encode($tmp);
    }
}