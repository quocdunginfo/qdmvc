<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:30 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_Feedback_Card extends Qdmvc_Page_Root
{
    protected static function getViewClass()
    {
        return 'Qdmvc_View_Feedback_Card';
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
                    'customer_name' => array(
                        'SourceExpr' => 'customer_name'
                    ),
                    'customer_email' => array(
                        'SourceExpr' => 'customer_email'
                    ),
                    'done' => array(
                        'SourceExpr' => 'done',
                        'DataType' => static::getDataType('done')
                    ),
                    'content' => array(
                        'SourceExpr' => 'content'
                    )
                )
            )
        );
    }

    public static function getPage()
    {
        return 'feedback_card';
    }
}