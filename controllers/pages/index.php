<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 15/02/2015
 * Time: 8:06 AM
 */
class Qdmvc_Page_Index {
    private static $index = array(
        'main' => array(
            'Class'=>'Qdmvc_Page_Main',
            'Caption' => array(
                'en' => 'Page Main'
            )
        ),
        'product_card' => array(
            'Class'=>'Qdmvc_Page_Product_Card',
            'Caption' => array(
                'en' => 'Product Card'
            )
        ),
        'product_list' => array(
            'Class'=>'Qdmvc_Page_Product_List',
            'Caption' => array(
                'en' => 'Product List'
            )
        ),
        'product_cat_card' => array(
            'Class'=>'Qdmvc_Page_ProductCat_Card',
            'Caption' => array(
                'en' => 'Product Cat Card'
            )
        ),
        'product_cat_list' => array(
            'Class'=>'Qdmvc_Page_ProductCat_List',
            'Caption' => array(
                'en' => 'Product Cat List'
            )
        ),
        'product_setup' => array(
            'Class'=>'Qdmvc_Page_ProductSetup',
            'Caption' => array(
                'en' => 'Product Setup'
            )
        )
    );
    public static function getIndex()
    {
        return static::$index;
    }
}