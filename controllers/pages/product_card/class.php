<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
class Qdmvc_Page_Product_Card extends Qdmvc_Page_Root
{
    protected static $fields_show = array(
        'Group1' => array(
            'Type' => 'Group',
            'Name' => 'General',
            'Fields' => array(
                'id' => array(
                    'SourceExpr' => 'id'
                ),
                'avatar' => array(
                    'SourceExpr' => 'avatar'
                ),
                'product_cat_id' => array(
                    'SourceExpr' => 'product_cat_id'
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
                    'SourceExpr' => 'active'
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

    public function run()
    {
        //load View and render
        (new Qdmvc_View_Product_Card($this->data))->render();
    }

    public static function getPage()
    {
        return 'product_card';
    }
    public static function getPageList()
    {
        return 'product_list';
    }

    public static function getDataPort()
    {
        return 'product_port';
    }
}