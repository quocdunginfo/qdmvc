<?php
/*
Plugin Name: qdmvc
*/

//Because Helper is declared outside to public provider for other location use (theme)
Qdmvc::loadHelper('main');
Qdmvc::loadModel();
Qdmvc::loadRouter();
class Qdmvc
{
    private $included_file = array(
        'native/register-admin-menu',
        'native/page-meta-box',
        'native/db-init',
        'native/shortcode',
        'native/menu-nav-provider',
        'notification/index',

    );
    //dependency plugins
    private $dependencies = array('phpactiverecords', 'jqwidgets');

    function __construct()
    {

    }

    private function init()
    {
        //required Qdmvc root index tree
        static::loadIndex('index');
        //require related library
        foreach ($this->included_file as $item) {
            static::load($item);
        }
        //loading widgets
        require_once(Qdmvc::getWidget('index.php'));
    }

    /*
     * External use
     */
    public static function loadPageClass($name)
    {
        static::loadController('pages/' . $name . '/class');
    }
    public static function loadPage($name)
    {
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
        require_once(static::getPluginDir($pure_path).'.php');
    }

    /*
     * Internal use
     */
    protected static function getPluginDir($pure_path = '')
    {
        return plugin_dir_path(__FILE__) . $pure_path;
    }

    protected static function getWidget($path='')
    {
        return Qdmvc::getPluginDir('widgets/'.$path);
    }
    protected static function getHelper($path='')
    {
        return Qdmvc::getPluginDir('helpers/'.$path);
    }

    protected static function getView($path='')
    {
        return (Qdmvc::getPluginDir('views/'.$path));
    }

    protected static function getModel($path='')
    {
        return (Qdmvc::getPluginDir('models/'.$path));
    }

    protected static function getController($path='')
    {
        return (Qdmvc::getPluginDir('controllers/'.$path));
    }
    public function run()
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
        //2nd level construct
        $this->init();
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
    public static function load($pure_path)
    {
        require_once(Qdmvc::getPluginDir($pure_path).'.php');
    }
    public static function loadRouter()
    {
        static::load('native/router');
    }
}
if(is_admin())
{
    QdJqwidgets::registerResource(true);
    (new Qdmvc())->run();
}