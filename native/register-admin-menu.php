<?php

class Qdmvc_RegisterAdminMenu
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'qd_register_custom_menu_page'));
    }

    public function qd_register_custom_menu_page()
    {
        //main page
        add_menu_page('QD PLUGIN', 'QD PLUGIN', 'manage_options', 'main', array($this, 'add_page_main'));
        //sub pages
        //Auto add sub Page based on Index tree
        //return;
        foreach (Qdmvc_Page_Index::getIndex() as $p_name => $config) {

            add_submenu_page('main', $config['Caption'][Qdmvc_Config::getLanguage()], $config['Caption'][Qdmvc_Config::getLanguage()], 'manage_options', $p_name, array($this, "{$p_name}"));
        }
    }

    function __call($func, $params)
    {
        if (!in_array($func, array('add_page_main', 'qd_register_custom_menu_page'))) {
            Qdmvc::runPage($func);
        }
    }

    public function add_page_main()
    {
        Qdmvc::runPage('main');
    }
}

(new Qdmvc_RegisterAdminMenu());