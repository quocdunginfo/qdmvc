<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
class Qdmvc_Page_ProductSetup extends Qdmvc_Page_Root {
    public function run()
    {
        //prepare data
        $this->data['obj'] = QdProductSetup::find(1);
        //load View and render
        (new Qdmvc_View_ProductSetup($this->data))->render();
    }
    public static function getPage()
    {
        return 'product_setup';
    }

    public static function getDataPort()
    {
        return 'product_setup_port';
    }

}