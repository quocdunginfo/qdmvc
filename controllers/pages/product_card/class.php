<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPageClass('root');
class Qdmvc_Page_Product_Card extends Qdmvc_Page_Root
{
    protected static $fields_show = null;

    protected static function initFields()
    {
        return array(
                'Group1' => array(
                    'Type' => 'Group',
                    'Name' => 'General',
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
                        'code' => array(
                            'SourceExpr' => 'code'
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
                        )
                    )
                ),
                'Group2' => array(
                    'Type' => 'Part',
                    'Name' => 'Lines',
                    'PagePartID' => 'product_list',
                    /*
                    'SubPageLink' => array(
                        'Field' => '',
                        'Type' => 'FIELD',//'CONST',
                        'Value' => ''
                    )*/
                )
                /* SAMPLE
                ,
                'Group2' => array(
                    'Type' => 'Part',
                    'Name' => 'Lines',
                    'PagePartID' => '',
                    'SubPageLink' => array(
                        'Field' => '',
                        'Type' => 'FIELD',//'CONST',
                        'Value' => ''
                    )
                )
                */
            );
    }

    public function run()
    {
        //load View and render
        (new Qdmvc_View_Product_Card($this))->render();
    }

    public static function getPage()
    {
        return 'product_card';
    }
}