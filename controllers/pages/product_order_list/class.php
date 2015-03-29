<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_ProductOrder_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductOrder_List';
    }

    public static function getPage()
    {
        return 'product_order_list';
    }

    protected static function getPageView()
    {
        return array(
            'done' => false
        );
    }

    protected static function initFields()
    {
        return array(
            'id' => array(
                'SourceExpr' => 'id',
                'PrimaryKey' => true,
                'Width' => 50
            ),
            '_product_name' => array(
                'SourceExpr' => '_product_name',
                'Width' => 100
            ),
            'customer_name' => array(
                'SourceExpr' => 'customer_name'
            ),
            'count' => array(
                'SourceExpr' => 'count',
                'Width' => 100
            )
        );
    }

}
