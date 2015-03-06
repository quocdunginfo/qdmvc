<?php
/*
Plugin Name: qdmvc
*/

//Because Helper is declared outside to public provider for other location use (theme)
Qdmvc::loadHelper('main');
Qdmvc::loadModel();
class Qdmvc
{
    private $included_file = array(
        'register-admin-menu.php',
        'page-meta-box.php',
        'router.php',
        'db-init.php',
        'shortcode.php',
        'menu-nav-provider.php',
        'notification/index.php',

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
        //required Qdmvc root index tree
        static::loadIndex('index');
        //required Auto load
        static::loadAutoLoad('autoload');
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
    public static function loadAutoLoad($pure_path)
    {
        require_once(Qdmvc::getPluginDirPath($pure_path).'.php');
    }
    public static function loadPageClass($name)
    {
        static::loadController('pages/' . $name . '/class');
    }
    public static function loadPage($name)
    {
        //every pages always use jqwidgets
        Qdmvc::loadUIKit();//jqwidget
        //load class
        static::loadPageClass($name);
        //load controller
        static::loadController('pages/' . $name . '/controller');
    }

    public static function loadLayout($pure_path)
    {
        require_once(static::getView('layouts/'.$pure_path.'.php'));
    }

    public static function loadController($pure_path)
    {
        require_once(static::getController($pure_path.'.php'));
    }

    public static function loadHelper($pure_path)
    {
        require_once(static::getHelper($pure_path.'.php'));
    }
    public static function loadDataPort($pure_path)
    {
        require_once(static::getController('dataports/'.$pure_path.'.php'));
    }
    public static function loadIndex($pure_path)
    {
        require_once(static::getPluginDirPath($pure_path).'.php');
    }

    /*
     * Internal use
     */
    protected static function getPluginDirPath($pure_path = '')
    {
        return plugin_dir_path(__FILE__) . $pure_path;
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