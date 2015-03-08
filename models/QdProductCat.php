<?php
class QdProductCat extends QdRoot
{
    static $table_name = 'mpd_product_cat';

    /*
    static $has_many = array(
        array('product_list', 'class_name' => 'QdProduct', 'primary_key' => 'id', 'foreign_key' => 'product_cat_id')
    );*/
    protected static $fields_config = array(
        'id' => array(),
        'name' => array(),
        'avatar' => array(
            'Caption' => array('en' => 'Avatar', 'vn' => 'Hình đại diện'),
            'DataType' => 'Image',
            'Description' => 'Hình đại diện',
        ),
        'order' => array(),
        'parent_id' => array(
            'Name' => 'parent_id',
            'Caption' => array('en' => 'Parent ID', 'vn' => 'Mã LSP cha'),
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
    );
    public function getProducts()
    {
        $obj = new QdProduct();
        $obj->SETFILTERDEFAULT(array('product_cat_id' => $this->id));
        return $obj;
    }
    public function getPermalink()
    {
        $query =  get_permalink(Qdmvc_Helper::getPageIdByTemplate('page-templates/product-cat.php'));
        $query = add_query_arg( array('id' => $this->id, 'title' => $this->name), $query );
        return $query;
    }
    public function getProductsSegmentURL($offset=0)
    {
        $query =  get_permalink($this->getPermalink());
        $query = add_query_arg( array('id' => $this->id, 'product-offset' => $offset), $query );
        return $query;
    }
    public function getProductsSegment($limit=2, $offset=0)
    {
        //return QdProduct::all(array('conditions' => 'product_cat_id = '.$this->id, 'limit' => $limit, 'offset' => $offset, 'order' => 'id desc'));
        return $this
            ->getProducts()
            ->REMOVEFILTER()
            ->SETLIMIT($limit)
            ->SETOFFSET($offset)
            ->SETORDERBY('id','desc')
            ->GETLIST();
    }
    public function getBreadcrumbs()
    {
        $re = array();
        array_push($re,array('name' => 'Sản phẩm', 'url'=>$this->getPermalink()));
        array_push($re,array('name' => $this->name, 'url'=>$this->getPermalink()));
        return $re;
    }
}