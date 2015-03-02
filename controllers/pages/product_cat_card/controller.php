<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */
class Qdmvc_Page_ProductCat_Card extends Qdmvc_Page_Root {
    public function run()
    {
        //load View and render
        (new Qdmvc_View_ProductCat_Card($this->data))->render();
    }
    protected function getPage()
    {
        return 'product_cat_card';
    }

    protected function getDataPort()
    {
        return 'product_cat_port';
    }

}
(new Qdmvc_Page_ProductCat_Card())->run();