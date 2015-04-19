<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_Log_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Log_List';
    }

    public static function getPage()
    {
        return 'log_list';
    }

    protected static function initFields()
    {
        return array_merge(
            parent::initFields(),
            array(
                'location' => array(
                    'SourceExpr' => 'location',
                ),
                'action' => array(
                    'SourceExpr' => 'action',
                ),
            ));
    }

}
