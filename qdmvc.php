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
    private $included_file = array('page-meta-box.php','controllers/index.php','router.php', 'db-init.php', 'load-model.php', 'shortcode.php'
    /*, 'menu-nav-provider.php'*/, 'notification/index.php', 'load-layout.php', 'register-admin-menu.php'
    );
	private $dependencies = array('phpactiverecords', 'jqwidgets');
    function __construct()
    {
		require_once(ABSPATH.'wp-admin/includes/plugin.php');
		foreach($this->dependencies as $item)
		{
			//check dependency
			if (!is_plugin_active($item . "/$item.php" ) ) {
			  //plugin is not activated
			  echo 'Require plugin '.$item;
			  return;
			} 
		}
		$this->init();
    }

    private function init()
    {
        //include files...
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
        Qdmvc::loadUIKit();
        return Qdmvc::getPluginDirPath() . 'controllers/';
    }

    public static function getModel()
    {
        return Qdmvc::getPluginDirPath() . 'models/';
    }
    private static function loadUIKit()
    {
        QdJqwidgets::registerResource(true);
    }
}
$qdmvc = new Qdmvc();
require('plugin/simple_html_dom.php');