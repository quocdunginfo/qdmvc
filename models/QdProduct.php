<?php

class QdProduct extends QdRoot
{
    static $table_name = 'mpd_product';
    public static function getFieldsConfig()
    {
        return array_merge(parent::getFieldsConfig(), array(
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
            'name' => array(
                'Caption' => array('vn' => 'Tên SP'),
            ),
            'code' => array(
                'Caption' => array('vn' => 'Mã SP'),
            ),
            'price' => array(
                'Caption' => array('vn' => 'Giá'),
            ),
            'xuatxu' => array(
                'Caption' => array('vn' => 'Xuất xứ'),
            ),
            'congsuat' => array(
                'Caption' => array('vn' => 'Công suất'),
            ),
            'dongco' => array(
                'Caption' => array('vn' => 'Động cơ'),
            ),
            'trongluong' => array(
                'Caption' => array('vn' => 'Trọng lượng'),
            ),
            'baohanh' => array(
                'Caption' => array('vn' => 'Bảo hành'),
            ),
            'mota1' => array(
                'Caption' => array('vn' => 'Mô tả'),
                'DataType' => 'WYSIWYG',
            ),
            'mota2' => array(
                'Caption' => array('vn' => 'Mô tả 2'),
                'DataType' => 'WYSIWYG',
            ),
            'mota3' => array(),
        ));
    }

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
    protected function nameOnValidate($field_name)
    {
        if($this->$field_name=='')
        {
            $this->pushValidateError($field_name, 'Name bắt buộc');
        }
        /*
        if($this->active==1)
        {
            if($this->name!=$this->xRec()->name)
            {
                $this->pushValidateError($field_name, 'Không thể sửa Name khi Active=1');
            }
        }
        */
    }
    protected function activeOnValidate($field_name)
    {
        /*
        if($this->active ==0 && $this->active != $this->xRec()->active)
        {
            if($this->code != 1)
            {
                $this->pushValidateError($field_name, 'Code phải bằng 1 mới tắt được Active');
            }
        }
        */
    }
    protected function codeOnValidate($field_name)
    {
        if($this->$field_name == '')
        {
            if($this->name!=null)
            {
                $this->pushValidateError($field_name, 'Code tự động in hoa và bằng Name', 'info');
                $this->$field_name = strtoupper($this->name);
            }
        }
    }
    protected function priceOnValidate($field_name)
    {
        if($this->$field_name!='' && $this->$field_name <= 0)
        {
            $this->pushValidateError($field_name, 'Price phải lớn hơn 0', 'error');
        }
    }
    protected function product_cat_idOnValidate($field_name)
    {
        //check exit
        if($this->getProductCatObj()==null)
        {
            $this->pushValidateError($field_name, 'Product Cat không tồn tại!');
            if(!$this->is_new_record())
            {
                $this->$field_name = $this->xRec()->$field_name;
            }
        }
    }
    protected function avatarOnValidate($field_name)
    {
        if($this->$field_name=='')
        {
            $pro_setup = QdProductSetup::GET();
            $this->$field_name = $pro_setup->df_pro_avatar;
            $this->pushValidateError($field_name, 'Tự động gán Avatar mặc định cho Product', 'info');
        }
    }

    public static function getInitObj()
    {
        $obj = new QdProduct();
        $obj->trongluong = 'KG';
        return $obj;
    }

}