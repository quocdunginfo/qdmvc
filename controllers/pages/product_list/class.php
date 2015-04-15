<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_Product_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Product_List';
    }

    protected static function initFields()
    {
        return array_merge(
            parent::initFields(),
            array(
                'code' => array(
                    'SourceExpr' => 'code',
                    'Width' => 100
                ),
                'name' => array(
                    'SourceExpr' => 'name',
                    'Width' => 200
                ),
                'price' => array(
                    'SourceExpr' => 'price',
                    'Width' => 100
                ),
                '_product_cat_name' => array(
                    'SourceExpr' => '_product_cat_name',
                    'DataType' => static::getDataType('_product_cat_name')
                ),
            )
        );
    }

    public static function getPage()
    {
        return 'product_list';
    }
}
