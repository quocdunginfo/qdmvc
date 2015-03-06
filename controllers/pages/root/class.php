<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:34 PM
 */
class Qdmvc_Page_Root {
    protected $data = array();
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
    public static function getPageList()
    {

    }
    public static function getDataPort()
    {

    }
    public static function getCaption()
    {
        return 'Default Page Root Caption';
    }
}