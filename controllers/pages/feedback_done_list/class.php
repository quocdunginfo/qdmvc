<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:35 PM
 */
Qdmvc::loadPageClass('root');
Qdmvc::loadPageClass('feedback_list');
class Qdmvc_Page_FeedbackDone_List extends Qdmvc_Page_Feedback_List
{
    protected static function getPageView()
    {
        return array(
            'done' => true
        );
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_FeedbackDone_List';
    }
    public static function getPage()
    {
        return 'feedback_done_list';
    }

}
