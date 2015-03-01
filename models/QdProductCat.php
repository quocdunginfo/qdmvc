<?php
class QdProductCat extends QdRoot
{
    static $table_name = 'mpd_product_cat';
    static $has_many = array(
        array('product_list', 'class_name' => 'QdProduct', 'primary_key' => 'id', 'foreign_key' => 'product_cat_id')
    );
    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $tmp[$count]['name'] = $item->name;
            $tmp[$count]['avatar'] = $item->avatar;
            $tmp[$count]['order'] = $item->order;
            $tmp[$count]['parent_id'] = $item->parent_id;
            $count++;
        }
        return $tmp;
    }
    public function getProducts()
    {
        return QdProduct::all(array('conditions' => 'product_cat_id = '.$this->id));
        //return $this->product_list;
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
        return QdProduct::all(array('conditions' => 'product_cat_id = '.$this->id, 'limit' => $limit, 'offset' => $offset, 'order' => 'id desc'));
        //return $this->product_list;
    }
    public function getBreadcrumbs()
    {
        $re = array();
        array_push($re,array('name' => 'Sản phẩm', 'url'=>$this->getPermalink()));
        array_push($re,array('name' => $this->name, 'url'=>$this->getPermalink()));
        return $re;
    }
    public static function getTbName()
    {
        return self::$table_name;
    }
}