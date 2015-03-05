<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 15/02/2015
 * Time: 8:06 AM
 */
class Qdmvc_Page_Index {
    private static $index = array(
        'main' => 'Qdmvc_Page_Main',
        'product_card' => 'Qdmvc_Page_Product_Card',
        'product_cat_card' => 'Qdmvc_Page_ProductCat_Card',
        'product_cat_list' => 'Qdmvc_Page_ProductCat_List',
        'product_list' => 'Qdmvc_Page_Product_List',
        'product_setup' => 'Qdmvc_Page_ProductSetup'
    );
    public static function getIndex()
    {
        return static::$index;
    }
}