<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
Qdmvc::loadPageClass('root');
class Qdmvc_Page_ProductCat_Card extends Qdmvc_Page_Root {
    public function run()
    {
        //load View and render
        (new Qdmvc_View_ProductCat_Card($this))->render();
    }
    public static function getPage()
    {
        return 'product_cat_card';
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
                        'LookupType' => static::getDataType('avatar')
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
                'Name' => 'Lines',
                'PagePartID' => 'product_cat_list'
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