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
        $tmp2 = array(
            'Total' => QdProductCat::count(),
            'Rows' => $tmp
        );
        return json_encode($tmp2);
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
}