<?php

class QdImage extends QdNote
{
    static $table_name = 'mpd_image';

    protected static $fields_config = array(
        'id' => array(),
        'content' => array(
            'Caption' => array('en' => 'Description', 'vn' => 'Mô tả'),
        ),
        'path' => array(
            'Caption' => array('en' => 'Image', 'vn' => 'Hình ảnh'),
            'DataType' => 'Image',
        ),
        'order' => array(
            'Caption' => array('en' => 'Order', 'vn' => 'Thứ tự'),
        ),
        'model' => array(),
        'model_id' => array()
    );

    public static function getInitObj()
    {
        $obj = new QdImage();
        $obj->active = true;
        return $obj;
    }

    protected function orderOnValidate($field_name)
    {
        if($this->{$field_name}=='' || $this->{$field_name}<=0)
        {
            $this->pushValidateError($field_name, 'Thứ tự phải lớn hơn 0');
        }
    }

}