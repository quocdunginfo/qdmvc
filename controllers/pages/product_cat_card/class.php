<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
class Qdmvc_Page_ProductCat_Card extends Qdmvc_Page_Root {
    public function run()
    {
        //load View and render
        (new Qdmvc_View_ProductCat_Card($this->data))->render();
    }
    public static function getPage()
    {
        return 'product_cat_card';
    }


    public static function getDataPort()
    {
        return 'product_cat_port';
    }

    public static function getPageList()
    {
        return 'product_cat_list';
    }
}