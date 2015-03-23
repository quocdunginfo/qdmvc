<?php

class QdProductOrder extends QdRoot
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
        //SAMPLE FIELD CONFIG
        '_product_name' => array(
            'Name' => '_product_name',
            'Caption' => array('en' => 'Product Name', 'vn' => 'Tên SP'),
            'DataType' => 'Text',
            'FieldClass' => 'FlowField',
            'FieldClass_FlowField' => array(
                'Method' => 'Lookup',
                'Table' => 'QdProduct',
                'Field' => 'name',
                'TableFilter' =>  array(
                    0 => array(
                        'Field' => 'id',
                        'Type' => 'FIELD',
                        'Value' => 'product_id'
                    )
                )
            )
        ),
        'customer_name' => array(
            'Caption' => array('en' => 'Customer Name', 'vn' => 'Tên KH')
        ),
        'customer_email' => array(),
        'customer_address' => array(),
        'customer_phone' => array(),
        'count' => array(
            'Caption' => array('en' => 'Quantity', 'vn' => 'SL đặt')
        ),
        'done' => array(
            'DataType' => 'Boolean'
        ),
        'mota' => array(),
        'id' => array()
    );
    static $belongs_to = array(
        array('product_obj', 'class_name' => 'QdProduct', 'foreign_key' => 'product_id', 'primary_key' => 'id')
    );
    public function getProduct()
    {
        return $this->product_obj;
    }

    public function save($validate = true)
    {
        if(!$this->is_new_record())
        {
            if($this->done) {
                if ($this->xRec()->done) {
                    $this->pushValidateError('Không thể sửa khi Done = true');
                    return false;
                }
            }
        }
        return parent::save($validate);
    }
    public function delete()
    {
        if($this->done)
        {
            $this->pushValidateError('Không thể xóa khi Done = true');
            return false;
        }
        return parent::delete();
    }

}