<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_Image_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Image_List';
    }

    public static function getPage()
    {
        return 'image_list';
    }

    protected static function initFields()
    {
        return array_merge(
            parent::initFields(),
            array(
                'order' => array(
                    'SourceExpr' => 'order',
                ),
                'path' => array(
                    'SourceExpr' => 'path',
                ),
            ));
    }

}
