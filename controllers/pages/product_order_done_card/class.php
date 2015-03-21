<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPage('root');
Qdmvc::loadPage('product_order_card');
class Qdmvc_Page_ProductOrderDone_Card extends Qdmvc_Page_ProductOrder_Card
{
    public static function getPage()
    {
        return 'product_order_done_card';
    }
    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductOrderDone_Card';
    }
}