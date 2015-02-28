<?php
class QdProductCat extends QdRoot
{
    static $table_name = 'mpd_product_cat';

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
    }
    public function getPermalink()
    {
        $query =  get_permalink(Qdmvc_Helper::getPageIdByTemplate('page-templates/product-cat.php'));
        $query = add_query_arg( array('id' => $this->id), $query );
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
    }
    public function getBreadcrumbs()
    {
        $re = array();
        array_push($re,array('name' => 'Trang chủ', 'url'=>get_home_url()));
        array_push($re,array('name' => 'Sản phẩm', 'url'=>$this->getPermalink()));
        array_push($re,array('name' => $this->name, 'url'=>$this->getPermalink()));
        return $re;
    }



    public static function getTbName()
    {
        return self::$table_name;
    }
}