<?php
class QdProduct extends QdRoot
{
    static $table_name = 'mpd_product';

    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $tmp[$count]['name'] = $item->name;
            $tmp[$count]['avatar'] = $item->avatar;
            $tmp[$count]['code'] = $item->code;
            $tmp[$count]['xuatxu'] = $item->xuatxu;
            $tmp[$count]['congsuat'] = $item->congsuat;
            $tmp[$count]['dongco'] = $item->dongco;
            $tmp[$count]['trongluong'] = $item->trongluong;
            $tmp[$count]['product_cat_id'] = $item->product_cat_id;
            $tmp[$count]['active'] = $item->active;
            $tmp[$count]['_product_cat_name'] = $item->getProductCatObj()->name;
            $count++;
        }
        $tmp2 = array(
            'Total' => QdProduct::count(),
            'Rows' => $tmp
        );
        return json_encode($tmp2);
    }
    public function getProductCatObj()
    {
        if($this->product_cat_id > 0)
        {
            try {
                return QdProductCat::find($this->product_cat_id);
            } catch (Exception $e) {
                return new QdProductCat();
            }
        }
    }
}