<?php

class QdNote extends QdRoot
{
    static $table_name = 'mpd_note';

    protected static $fields_config = array(
        'id' => array(),
        'content' => array(),
        'model' => array(),
        'model_id' => array()
    );

    public static function getInitObj()
    {
        $obj = new QdNote();
        $obj->content = 'Mặc định';
        return $obj;
    }

}