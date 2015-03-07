<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:34 PM
 */
class Qdmvc_Page_Root {
    protected $data = array();
    protected static $fields_show = array();
    function __construct()
    {
        $this->loadView();
        //build data_port value
        $this->data['data_port'] = Qdmvc_Helper::getDataPortPath(static::getDataPort());
    }
    public function run()
    {

    }
    protected function loadView($name='view')
    {
        Qdmvc::loadController('/pages/'.static::getPage().'/'.$name);
    }
    public static function getPage()
    {

    }
    public function getFieldCaption($field_name, $lang='en')
    {
        $c = static::getModel();
        return $c::getFieldCaption($field_name, $lang);
    }
    public function getLayout()
    {
        return static::$fields_show;
    }
    public static function getPageList()
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['PageList']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['PageList'];
        }
    }
    public static function getDataPort()
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['DataPort']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['DataPort'];
        }
    }
    public static function getModel()
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['Model']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['Model'];
        }
    }
    public static function getCaption($lang='en')
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['Caption'][$lang]))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['Caption'][$lang];
        }
        else {
            return 'Default Page Root Caption';
        }
    }
    public function getData()
    {
        return $this->data;
    }
}