<?php

class QdLog extends QdNote
{
    static $table_name = 'mpd_log';
    public static $ACTION_UNDEFINED = 0;
    public static $ACTION_INSERT = 1;
    public static $ACTION_MODIFY = 2;
    public static $ACTION_DELETE = 3;

    public static function getFieldsConfig()
    {
        return array_merge(parent::getFieldsConfig(), array(
            'action' => array(
                'Caption' => array('en' => 'Action', 'vn' => 'Hành động'),
                'DataType' => 'Option',
                'Options' => array(
                    '0' => array(
                        'Caption' => array('en' => 'Undefined', 'vn' => 'Không xác định'),
                    ),
                    '1' => array(
                        'Caption' => array('en' => 'Insert', 'vn' => 'Thêm mới'),
                    ),
                    '2' => array(
                        'Caption' => array('en' => 'Modify', 'vn' => 'Sửa'),
                    ),
                    '3' => array(
                        'Caption' => array('en' => 'Delete', 'vn' => 'Xóa'),
                    ),
                )
            ),
            'location' => array(
                'Caption' => array('en' => 'Location', 'vn' => 'Nơi phát sinh'),
            ),

        ));
    }

    public static function getInitObj($model='', $model_id='', $action=0, $location='')
    {
        $obj = new QdLog();
        $obj->model = $model;
        $obj->model_id = $model_id;
        $obj->action = $action;
        $obj->location = $location;
        return $obj;
    }
}