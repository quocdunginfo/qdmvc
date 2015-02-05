<?php

/*
Plugin Name: qdmvc
*/

class Qdmvc
{
    private $included_file = array('db-init.php', 'shortcode.php', 'register-admin-menu.php'
    , 'menu-nav-provider.php', 'notification/index.php'
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
$Qdmvc = new Qdmvc();
//Helper declare outside because of public provider for other part use
require_once(Qdmvc::getHelper().'index.php');
