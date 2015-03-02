<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */
class Qdmvc_Page_Product_List extends Qdmvc_Page_Root
{
    public function run()
    {
        $this->data['role'] = isset($_REQUEST['qdrole'])?$_REQUEST['qdrole']:'navigate';//lookup, navigate
        $this->data['returnid'] = isset($_REQUEST['qdreturnid'])?$_REQUEST['qdreturnid']:'';//lookup, navigate
        $this->data['view_style'] = 'compact';//compact, full
        Qdmvc_Helper::requestCompact();

        (new Qdmvc_View_Product_List($this->data))->render();
    }

    protected function getDataPort()
    {
        return 'product_port';
    }
    protected function getPage()
    {
        return 'product_list';
    }


}
(new Qdmvc_Page_Product_List())->run();