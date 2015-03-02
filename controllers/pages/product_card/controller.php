<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */
class Qdmvc_Page_Product_Card extends Qdmvc_Page_Root {
    public function run()
    {
        //prepare data

        //load View and render
        (new Qdmvc_View_Product_Card($this->data))->render();
    }

    protected function getPage()
    {
        return 'product_card';
    }
    protected function getDataPort()
    {
        return 'product_port';
    }

}
(new Qdmvc_Page_Product_Card())->run();
