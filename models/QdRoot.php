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

    static $before_update = array('on_before_update'); # new records only

    public function on_before_update()
    {
        $this->date_modified = new DateTime();
    }

    static $before_create = array('on_before_create'); # new records only

    public function on_before_create()
    {
        $this->date_created = new DateTime();
    }

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
    protected static $fields = array(
        'id' => array(
            'name' => 'id',
            'caption' => 'ID'
        )
    );

    public static function getTbName()
    {
        return static::$table_name;
    }
    public static function getPF($field_name)//get Physical Field
    {
        return static::$fields[$field_name];
    }
    public static function getType($field_name)
    {
        if (array_key_exists('type', static::$fields[$field_name]))
        {
            return static::$fields[$field_name]['type'];
        }
    }
}