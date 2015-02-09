<?php

/*
Plugin Name: qdmvc
*/

//Load model 1st
//require_once('load-model.php');
//then Helper declare outside because of public provider for other part use
require_once(Qdmvc::getHelper() . 'index.php');

class Qdmvc
{
    private $included_file = array('router.php', 'db-init.php', 'load-model.php', 'shortcode.php'
    , 'menu-nav-provider.php', 'notification/index.php', 'register-admin-menu.php'
    );

    function __construct()
    {
        $this->init();
    }

    private function init()
    {
        foreach ($this->included_file as $item) {
            require_once(Qdmvc::getPluginDirPath() . $item);
        }
        //loading widgets
        require_once(Qdmvc::getWidget() . 'index.php');
    }

    public static function getPluginDirPath()
    {
        return plugin_dir_path(__FILE__);
    }

    public static function getWidget()
    {
        return Qdmvc::getPluginDirPath() . 'widgets/';
    }

    public static function getHelper()
    {
        return Qdmvc::getPluginDirPath() . 'helpers/';
    }

    public static function getView()
    {
        return Qdmvc::getPluginDirPath() . 'views/';
    }

    public static function getController()
    {
        return Qdmvc::getPluginDirPath() . 'controllers/';
    }

    public static function getModel()
    {
        return Qdmvc::getPluginDirPath() . 'models/';
    }
}
$qdmvc = new Qdmvc();

