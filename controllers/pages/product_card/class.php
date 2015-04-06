<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_Product_Card extends Qdmvc_Page_Root
{
    protected static $fields_show = null;

    protected static function initFields()
    {
        return array(
                'General' => array(
                    'Type' => 'Group',
                    'Fields' => array(
                        'id' => array(
                            'SourceExpr' => 'id',
                            'PrimaryKey' => true
                        ),
                        'name' => array(
                            'SourceExpr' => 'name'
                        ),
                        'avatar' => array(
                            'SourceExpr' => 'avatar',
                            'DataType' => static::getDataType('avatar')
                        ),
                        'product_cat_id' => array(
                            'SourceExpr' => 'product_cat_id',
                            'LookupURL' => static::getLookupURL('product_cat_id')
                        ),
                        '_product_cat_name' => array(
                            'SourceExpr' => '_product_cat_name',
                            'ReadOnly' => static::isReadOnly('_product_cat_name')
                        ),
                        'code' => array(
                            'SourceExpr' => 'code'
                        ),
                        'price' => array(
                            'SourceExpr' => 'price'
                        ),
                        'congsuat' => array(
                            'SourceExpr' => 'congsuat'
                        ),
                        'trongluong' => array(
                            'SourceExpr' => 'trongluong'
                        ),
                        'xuatxu' => array(
                            'SourceExpr' => 'xuatxu'
                        ),
                        'dongco' => array(
                            'SourceExpr' => 'dongco'
                        ),
                        'active' => array(
                            'SourceExpr' => 'active',
                            'DataType' => static::getDataType('active')
                        ),
                        'mota1' => array(
                            'SourceExpr' => 'mota1',
                            'DataType' => static::getDataType('mota1')
                        ),
                    )
                )
            );
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Product_Card';
    }


    public static function getPage()
    {
        return 'product_card';
    }
}