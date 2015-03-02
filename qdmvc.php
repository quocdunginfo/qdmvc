<?php
/*
Plugin Name: qdmvc
*/

//Because Helper is declared outside to public provider for other location use (theme)
Qdmvc::loadHelper('index');
Qdmvc::loadModel();
class Qdmvc
{
    private $included_file = array(
        'page-meta-box.php',
        'controllers/index.php',
        'router.php',
        'db-init.php',
        'shortcode.php',
        'menu-nav-provider.php',
        'notification/index.php',
        'register-admin-menu.php'
    );
    //dependency plugins
    private $dependencies = array('phpactiverecords', 'jqwidgets');

    function __construct()
    {
        //check dependency
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        foreach ($this->dependencies as $item) {
            if (!is_plugin_active($item . "/$item.php")) {
                //plugin is not activated
                echo 'Require plugin ' . $item;
                return;
            }
        }
        //init 2nd construct
        $this->init();
    }

    private function init()
    {
        //require related library
        foreach ($this->included_file as $item) {
            require_once(Qdmvc::getPluginDirPath($item));
        }
        //loading widgets
        require_once(Qdmvc::getWidget() . 'index.php');
    }

    /*
     * External use
     */
    public static function loadPage($name)
    {
        //every pages always use jqwidgets
        Qdmvc::loadUIKit();//jqwidget
        static::loadController('pages/' . $name . '/controller');
    }

    public static function loadLayout($name)
    {
        require_once(static::getView('layouts/'.$name.'.php'));
    }

    public static function loadController($name)
    {
        require_once(static::getController($name.'.php'));
    }

    public static function loadHelper($name)
    {
        require_once(static::getHelper($name.'.php'));
    }
    public static function loadDataPort($name)
    {
        require_once(static::getController('dataports/'.$name.'.php'));
    }

    /*
     * Internal use
     */
    protected static function getPluginDirPath($path = '')
    {
        return plugin_dir_path(__FILE__) . $path;
    }

    protected static function getWidget($name='')
    {
        return Qdmvc::getPluginDirPath('widgets/'.$name);
    }
    protected static function getHelper($name='')
    {
        return Qdmvc::getPluginDirPath('helpers/'.$name);
    }

    protected static function getView($name='')
    {
        return (Qdmvc::getPluginDirPath('views/'.$name));
    }

    protected static function getModel($name='')
    {
        return (Qdmvc::getPluginDirPath('models/'.$name));
    }

    protected static function getController($name='')
    {
        return (Qdmvc::getPluginDirPath('controllers/'.$name));
    }

    protected static function loadUIKit()
    {
        QdJqwidgets::registerResource(true);
    }

    public static function loadModel()
    {
        $connection = QdPhpactiverecords::getCon();
        ActiveRecord\Config::initialize(function ($cfg) use ($connection) {
            $model_dir = Qdmvc::getModel();
            $cfg->set_model_directory($model_dir);
            $cfg->set_connections($connection);

            # default connection is now production
            $cfg->set_default_connection('production');
        });
    }
}

(new Qdmvc());