<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPage('root');
Qdmvc::loadPage('feedback_card');
class Qdmvc_Page_FeedbackDone_Card extends Qdmvc_Page_Feedback_Card
{
    public static function getPage()
    {
        return 'feedback_done_card';
    }
    protected static function getViewClass()
    {
        return 'Qdmvc_View_FeedbackDone_Card';
    }
}