<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPageClass('root');
class Qdmvc_Page_ProductOrder_Card extends Qdmvc_Page_Root
{
    public function run()
    {
        //load View and render
        (new Qdmvc_View_ProductOrder_Card($this))->render();
    }

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
                    'product_id' => array(
                        'SourceExpr' => 'product_id',
                        'LookupURL' => static::getLookupURL('product_id')
                    ),
                    '_product_name' => array(
                        'SourceExpr' => '_product_name',
                        'ReadOnly' => static::isReadOnly('_product_name')
                    ),
                    'customer_name' => array(
                        'SourceExpr' => 'customer_name'
                    ),
                    'customer_phone' => array(
                        'SourceExpr' => 'customer_phone'
                    ),
                    'customer_email' => array(
                        'SourceExpr' => 'customer_email'
                    ),
                    'customer_address' => array(
                        'SourceExpr' => 'customer_address'
                    ),
                    'count' => array(
                        'SourceExpr' => 'count'
                    ),
                    'done' => array(
                        'SourceExpr' => 'done',
                        'DataType' => static::getDataType('done')
                    ),
                    'mota' => array(
                        'SourceExpr' => 'mota'
                    )
                )
            ),
            'Group2' => array(
                'Type' => 'Part',
                'Name' => 'Lines',
                'PagePartID' => 'product_order_list',
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

    public static function getPage()
    {
        return 'product_order_card';
    }
}