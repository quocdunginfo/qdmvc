<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:36 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_ProductSetup extends Qdmvc_Page_Root {
    public function run()
    {
        //prepare data
        if(QdProductSetup::GET()==null)
        {
            $obj = new QdProductSetup();
            $obj->save();
            $this->data['obj'] = $obj;
        }
        else
        {
            $this->data['obj'] = QdProductSetup::GET();
        }

        //load View and render
        parent::run();
    }

    protected static function getViewClass()
    {
        return 'Qdmvc_View_ProductSetup';
    }

    public static function getPage()
    {
        return 'product_setup';
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
                    'product_per_segment' => array(
                        'SourceExpr' => 'product_per_segment'
                    ),
                    'df_pro_cat_avatar' => array(
                        'SourceExpr' => 'df_pro_cat_avatar',
                        'DataType' => static::getDataType('df_pro_cat_avatar')
                    ),
                    'df_pro_avatar' => array(
                        'SourceExpr' => 'df_pro_avatar',
                        'DataType' => static::getDataType('df_pro_avatar')
                    ),
                    'advice_phone' => array(
                        'SourceExpr' => 'advice_phone',
                        'DataType' => static::getDataType('advice_phone')
                    ),
                )
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