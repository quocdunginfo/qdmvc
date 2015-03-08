<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPageClass('root');
class Qdmvc_Page_ProductCat_List extends Qdmvc_Page_Root
{
    public function run()
    {
        $this->data['role'] = isset($_REQUEST['qdrole'])?$_REQUEST['qdrole']:'navigate';//lookup, navigate
        $this->data['returnid'] = isset($_REQUEST['qdreturnid'])?$_REQUEST['qdreturnid']:'';//lookup, navigate
        $this->data['view_style'] = 'compact';
        Qdmvc_Helper::requestCompact();

        (new Qdmvc_View_ProductCat_List($this))->render();
    }

    public static function getPage()
    {
        return 'product_cat_list';
    }
}