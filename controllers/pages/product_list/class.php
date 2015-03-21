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
        $this->data['role'] = isset($_REQUEST['qdrole']) ? $_REQUEST['qdrole'] : 'navigate';//lookup, navigate
        $this->data['returnid'] = isset($_REQUEST['qdreturnid']) ? $_REQUEST['qdreturnid'] : '';//lookup, navigate
        $this->data['view_style'] = 'compact';//compact, full
        Qdmvc_Helper::requestCompact();

        parent::run();
    }
    protected static function getViewClass()
    {
        return 'Qdmvc_View_Product_List';
    }

    protected static function initFields()
    {
        return array(
            'id' => array(
                'SourceExpr' => 'id',
                'PrimaryKey' => true,
                'Width' => 50
            ),
            'code' => array(
                'SourceExpr' => 'code',
                'Width' => 100
            ),
			'xuatxu' => array(
                'SourceExpr' => 'xuatxu',
                'Width' => 100
            ),
            '_product_cat_name' => array(
                'SourceExpr' => '_product_cat_name',
                'DataType' => static::getDataType('_product_cat_name')
            ),
			'name' => array(
                'SourceExpr' => 'name',
                'Width' => 200
            ),
        );
    }

    public static function getPage()
    {
        return 'product_list';
    }
}
