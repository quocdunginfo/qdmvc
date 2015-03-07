<?php

class QdProduct extends QdRoot
{
    static $table_name = 'mpd_product_order';

    protected static $fields_config = array(
        'product_id' => array(
            'Name' => 'product_id',
            'Caption' => array('en' => 'Product ID', 'vn' => 'Mã SP'),
            'DataType' => 'Code',
            'Numeric' => true,
            'Description' => '',
            'Editable' => true,
            'InitValue' => '0',
            'FieldClass' => 'Normal',//'FlowField'
            'TableRelation' => array(
                'Table' => 'QdProduct',
                'Field' => 'id',
                'TableFilter' => array(
                )
            )
        ),
        'customer_name' => array(),
        'customer_email' => array(),
        'customer_address' => array(),
        'customer_phone' => array(),
        'count' => array(),
        'done' => array(),
        'mota' => array()
    );
    static $belongs_to = array(
        array('product_obj', 'class_name' => 'QdProduct', 'foreign_key' => 'product_id', 'primary_key' => 'id')
    );
    public function getProduct()
    {
        return $this->product_obj;
    }
}