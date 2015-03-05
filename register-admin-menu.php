<?php
class Qdmvc_RegisterAdminMenu {
    function __construct()
    {
        add_action( 'admin_menu', array($this, 'qd_register_custom_menu_page'));
    }
    public function qd_register_custom_menu_page(){
        //main page
        add_menu_page( 'QD PLUGIN', 'QD PLUGIN', 'manage_options', 'main', array($this, 'add_sub_page_main'));
        //sub pages
        //Auto add sub Page based on Index tree
        foreach(Qdmvc_Page_Index::getIndex() as $p_name=>$c_name) {
            Qdmvc::loadPageClass($p_name);

            add_submenu_page('main', $c_name::getCaption(), $c_name::getCaption(), 'manage_options', $p_name, array($this, "add_sub_page_{$p_name}") );

        }
    }
    public function add_sub_page_main()
    {
        Qdmvc::loadPage('main');
    }
    public function add_sub_page_product_card()
    {
        Qdmvc::loadPage('product_card');
    }
    public function add_sub_page_product_list()
    {
        Qdmvc::loadPage('product_list');
    }
    public function add_sub_page_product_cat_card()
    {
        Qdmvc::loadPage('product_cat_card');
    }
    public function add_sub_page_product_cat_list()
    {
        Qdmvc::loadPage('product_cat_list');
    }
    public function add_sub_page_product_setup()
    {
        Qdmvc::loadPage('product_setup');
    }
}
(new Qdmvc_RegisterAdminMenu());