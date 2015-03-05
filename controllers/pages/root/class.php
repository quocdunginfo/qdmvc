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
        $this->data['data_port'] = Qdmvc_Helper::getDataPortPath($this->getDataPort());
    }
    public function run()
    {

    }
    protected function loadView($name='view')
    {
        Qdmvc::loadController('/pages/'.$this->getPage().'/'.$name);
    }
    protected function getPage()
    {

    }
    protected function getDataPort()
    {

    }
    public function getCaption()
    {
        return 'Default Page Root Caption';
    }
}