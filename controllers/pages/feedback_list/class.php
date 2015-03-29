<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPage('root');

class Qdmvc_Page_Feedback_List extends Qdmvc_Page_Root
{
    public function run()
    {
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Feedback_List';
    }

    public static function getPage()
    {
        return 'feedback_list';
    }

    protected static function initFields()
    {
        return array(
            'id' => array(
                'SourceExpr' => 'id',
                'PrimaryKey' => true,
                'Width' => 50
            ),
            'customer_name' => array(
                'SourceExpr' => 'customer_name'
            ),
            'customer_email' => array(
                'SourceExpr' => 'customer_email'
            )
        );
    }
    protected static function getPageView()
    {
        return array(
            'done' => false
        );
    }
}
