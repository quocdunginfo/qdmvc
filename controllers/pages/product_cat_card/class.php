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
    public function getPagePartURL($part_name='')
    {
        return '';
        //return "http://localhost/mpd_2015/wp-admin/admin.php?page=product_card&qdrole=navigate&filterdatafield0=product_cat_id&filtervalue0=95";//quocdunginfo
    }
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
                    /*
                    'date_modified' => array(
                        'SourceExpr' => 'date_modified',
                        'DataType' => static::getDataType('date_modified')
                    ),*/
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
            /*
            'Lines' => array(
                'Type' => 'Part',
                'SubType' => 'Page',
                'PagePartID' => 'product_card',
                'SubPageLink' => array(
                    'Field' => 'product_cat_id',
                    'Type' => 'FIELD',//'CONST'
                    'Value' => 'id'
                )
            )//quocdunginfo*/
        );
    }
}