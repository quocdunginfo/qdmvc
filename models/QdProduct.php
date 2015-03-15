<?php

class QdProduct extends QdRoot
{
    static $table_name = 'mpd_product';

    protected static $fields_config = array(
        //SAMPLE FIELD CONFIG
        '_product_cat_name' => array(
            'Name' => 'product_cat_name',
            'Caption' => array('en' => 'Product Cat Name', 'vn' => 'Tên loại SP'),
            'DataType' => 'Text',
            'FieldClass' => 'FlowField',
            'FieldClass_FlowField' => array(
                'Method' => 'Lookup',
                'Table' => 'QdProductCat',
                'Field' => 'name',
                'TableFilter' =>  array(
                    0 => array(
                        'Field' => 'id',
                        'Type' => 'FIELD',
                        'Value' => 'product_cat_id'
                    )
                )
            )
        ),
        'product_cat_id' => array(
            'Name' => 'product_cat_id',
            'Caption' => array('en' => 'Product Cat ID', 'vn' => 'Mã loại SP'),
            'DataType' => 'Code',
            'Numeric' => true,
            'Description' => '',
            'Editable' => true,
            'InitValue' => '0',
            'FieldClass' => 'Normal',//'FlowField'
            'TableRelation' => array(
                'Table' => 'QdProductCat',
                'Field' => 'id',
                'TableFilter' => array(
                    /*
                    0 => array(
                        'Condition' => array(
                            'Field' => '',
                            'Type' => 'CONST',//'FIELD'
                            'Value' => ''
                        ),
                        'Field' => '',
                        'Type' => 'FIELD',
                        'Value' => ''
                    )
                    */

                )
            )
        ),
        'avatar' => array(
            'Caption' => array('en' => 'Avatar', 'vn' => 'Hình đại diện'),
            'DataType' => 'Image',
            'Description' => 'Hình đại diện',
        ),
        'active' => array(
            'Caption' => array('en' => 'Active', 'vn' => 'Kích hoạt'),
            'DataType' => 'Boolean',
            'InitValue' => true,
        ),
        'id' => array(),
        'name' => array(),
        'code' => array(),
        'xuatxu' => array(),
        'congsuat' => array(),
        'dongco' => array(),
        'trongluong' => array(),
        'baohanh' => array(),
        'mota1' => array(),
        'mota2' => array(),
        'mota3' => array(),
    );
    static $alias_attribute = array(
        'model' => 'code'
    );
    static $belongs_to = array(
        array('product_cat_obj', 'class_name' => 'QdProductCat', 'foreign_key' => 'product_cat_id', 'primary_key' => 'id')
    );
    public function getProductCatObj()
    {
        return $this->product_cat_obj;
    }

    public function getPermalink()
    {
        $query = get_permalink(Qdmvc_Helper::getPageIdByTemplate('page-templates/product-detail.php'));
        $query = add_query_arg(array('id' => $this->id/*, 'title' => $this->name*/), $query);
        return $query;
    }

    public function getBreadcrumbs()
    {
        $re = $this->getProductCatObj()->getBreadcrumbs();
        array_push($re, array('name' => $this->name, 'url' => $this->getPermalink()));
        return $re;
    }
    /*
     * Validation
     *
     */
    protected function nameOnValidate()
    {
        if($this->name=='')
        {
            $this->pushValidateError('Name bắt buộc');
        }
        if($this->active==1)
        {
            if($this->name!=$this->xRec()->name)
            {
                $this->pushValidateError('Không thể sửa Name khi Active=1');
            }
        }
    }
    protected function activeOnValidate()
    {
        if($this->active ==0 && $this->active != $this->xRec()->active)
        {
            if($this->code != 1)
            {
                $this->pushValidateError('Code phải bằng 1 mới tắt được Active');
            }
        }
    }
    protected function codeOnValidate()
    {
        if($this->code == '')
        {
            if($this->name!=null)
            {
                $this->code = strtoupper($this->name);
            }
        }
    }
    protected function product_cat_idOnValidate()
    {
        //check exit
        if($this->getProductCatObj()==null)
        {
            $this->pushValidateError('Product Cat không tồn tại!');
        }
    }
}