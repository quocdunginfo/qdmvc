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
        if($this->{$field_name}!='')
        {
            if($this->{$field_name}<=0)
            {
                $this->pushValidateError($field_name, 'Thứ tự phải lớn hơn 0');
            }
        }
        else
        {
            $this->{$field_name} = $this->GETMAX($field_name) + 10;
            $this->pushValidateError($field_name, 'Thứ tự được gán tự động RANGE +10', 'info');
        }

    }
    public function GETMAX($field)
    {
        //$query = array_merge(static::_generateQuery($this->record_filter), array('select' => "max(`{$field}`)"));
        $record = new QdImage();
        $record->SETRANGE('model', $this->model);
        $record->SETRANGE('model_id', $this->model_id);
        $list = $record->GETLIST();
        $max = 0;
        foreach($list as $item)
        {
            if($item->{$field} >= $max)
            {
                $max = $item->{$field};
            }
        }
        return $max;
    }
}