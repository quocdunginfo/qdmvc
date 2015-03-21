<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_ProductCat_Card extends Qdmvc_Page_Root {
    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductCat_Card';
    }

    public static function getPage()
    {
        return 'product_cat_card';
    }
    public function getPagePartURL()
    {
        return Qdmvc_Helper::getCompactPagePartLink(static::getPageList(), $this->data['filter'][0]['filterfield'], $this->data['filter'][0]['filtervalue']);
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
                    'name' => array(
                        'SourceExpr' => 'name'
                    ),
                    'avatar' => array(
                        'SourceExpr' => 'avatar',
                        'DataType' => static::getDataType('avatar')
                    ),
                    'parent_id' => array(
                        'SourceExpr' => 'parent_id',
                        'LookupURL' => static::getLookupURL('parent_id')
                    ),
                    'order' => array(
                        'SourceExpr' => 'order'
                    )
                )
            ),
            'Group2' => array(
                'Type' => 'Part',
                'SubType' => 'Page',
                'Name' => 'Lines',
                'PagePartID' => 'product_list',
                'SubPageLink' => array(
                    'Field' => 'product_cat_id',
                    'Type' => 'FIELD',//'CONST'
                    'Value' => 'id'
                )
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
}