<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_Setup extends Qdmvc_Page_Root {
    public function run()
    {
        //prepare data
        if(QdSetup::GET()==null)
        {
            $obj = new QdSetup();
            $obj->save();
            $this->data['obj'] = $obj;
        }
        else
        {
            $this->data['obj'] = QdSetup::GET();
        }

        //load View and render
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_Setup';
    }

    public static function getPage()
    {
        return 'setup';
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
                    'df_language' => array(
                        'SourceExpr' => 'df_language',
                        'DataType' => static::getDataType('df_language'),
                    ),
                )
            )
        );
    }
}