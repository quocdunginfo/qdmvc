<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
Qdmvc::loadPageClass('root');
class Qdmvc_Page_ProductCat_Card extends Qdmvc_Page_Root {
    public function run()
    {
        //load View and render
        (new Qdmvc_View_ProductCat_Card($this))->render();
    }
    public static function getPage()
    {
        return 'product_cat_card';
    }
}