<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');
Qdmvc::loadPage('product_order_list');
class Qdmvc_Page_ProductOrderDone_List extends Qdmvc_Page_ProductOrder_List
{
    protected function getCustomPageView()
    {
        return array(
                'done' => true
            );
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductOrderDone_List';
    }
    public static function getPage()
    {
        return 'product_order_done_list';
    }

}
