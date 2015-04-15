<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_ProductCat_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductCat_List';
    }

    protected static function initFields()
    {
        return array_merge(
            parent::initFields(),
            array(
                'parent_id' => array(
                    'SourceExpr' => 'parent_id',
                    'Width' => 100
                ),
                'order' => array(
                    'SourceExpr' => 'order',
                    'Width' => 100
                ),
                'name' => array(
                    'SourceExpr' => 'name'
                ),
            ));
    }

    public static function getPage()
    {
        return 'product_cat_list';
    }
}