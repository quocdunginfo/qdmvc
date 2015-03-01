<?php

class QdProduct extends QdRoot
{
    static $table_name = 'mpd_product';
    /*
    protected static $fields = array(

        'id' => array(
            'name' => 'id',
            'caption' => 'ID'
        ),
        'name' => array(
            'name' => 'name',
            'caption' => 'Name'
        ),
        'model' => array(
            'name' => 'code',
            'caption' => 'Model'
        ),
        'xuatxu' => array(
            'name' => 'xuatxu',
            'caption' => 'Xuất xứ'
        ),
        'congsuat' => array(
            'name' => 'congsuat',
            'caption' => 'Công suất'
        ),
        'dongco' => array(
            'name' => 'dongco',
            'caption' => 'Trọng lượng'
        ),
        'trongluong' => array(
            'name' => 'trongluong',
            'caption' => 'Trọng lượng'
        ),
        'baohanh' => array(
            'name' => 'baohanh',
            'caption' => 'Bảo hành'
        ),
        'mota1' => array(
            'name' => 'mota1',
            'caption' => 'Mô tả'
        ),
        'mota2' => array(
            'name' => 'mota2',
            'caption' => ''
        ),
        'mota3' => array(
            'name' => 'mota3',
            'caption' => ''
        ),
        'product_cat_id' => array(
            'name' => 'product_cat_id',
            'tb_r' => 'mpd_product',
            'tb_r_f' => 'id',
            'caption' => 'Loại SP'
        ),
        'avatar' => array(
            'name' => 'avatar',
            'type' => 'image',
            'caption' => 'Avatar'
        ),
        '_product_cat_name' => array(
            'name' => '',
            'type' => 'flowfield',
            'tb_r' => 'mpd_product_cat',
            'tb_r_f' => 'name',
            'caption' => 'Avatar'
        )
    );
    */

    static $alias_attribute = array(
        'model' => 'code'
    );
    static $belongs_to = array(
        array('product_cat_obj', 'class_name' => 'QdProductCat', 'foreign_key' => 'product_cat_id', 'primary_key' => 'id')
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
            $tmp[$count]['code'] = $item->model;
            $tmp[$count]['xuatxu'] = $item->xuatxu;
            $tmp[$count]['congsuat'] = $item->congsuat;
            $tmp[$count]['dongco'] = $item->dongco;
            $tmp[$count]['trongluong'] = $item->trongluong;
            $tmp[$count]['product_cat_id'] = $item->product_cat_id;
            $tmp[$count]['active'] = $item->active;
            $tmp[$count]['_product_cat_name'] = $item->getProductCatObj()->name;
            $count++;
        }
        return $tmp;
    }

    public function getProductCatObj()
    {
        /*
        if ($this->product_cat_id > 0) {
            try {
                return QdProductCat::find($this->product_cat_id);
            } catch (Exception $e) {
                return new QdProductCat();
            }
        }
        */
        return $this->product_cat_obj;
    }

    public function getPermalink()
    {
        $query = get_permalink(Qdmvc_Helper::getPageIdByTemplate('page-templates/product-detail.php'));
        $query = add_query_arg(array('id' => $this->id, 'title' => $this->name), $query);
        return $query;
    }

    public function getBreadcrumbs()
    {
        $re = $this->getProductCatObj()->getBreadcrumbs();
        array_push($re, array('name' => $this->name, 'url' => $this->getPermalink()));
        return $re;
    }
}