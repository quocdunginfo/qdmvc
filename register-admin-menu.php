<?php
class Qdmvc_RegisterAdminMenu {
    function __construct()
    {
        add_action( 'admin_menu', array($this, 'qd_register_custom_menu_page'));
    }
    public function qd_register_custom_menu_page(){
        //main page
        add_menu_page( 'QD PLUGIN', 'QD PLUGIN', 'manage_options', 'qd_main_page', array($this, 'qd_custom_menu_page'));
        //sub pages

        add_submenu_page( 'qd_main_page', 'Loại SP', 'Loại SP', 'manage_options', 'qd_sub_page_1', array($this,'qd_fn_sub_page_1' ));
        add_submenu_page( 'qd_main_page', 'LSP List', 'LSP List', 'manage_options', 'qd_sub_page_2', array($this,'qd_fn_sub_page_2' ));
        add_submenu_page( 'qd_main_page', 'Sản phẩm', 'Sản phẩm', 'manage_options', 'qd_sub_page_3', array($this,'qd_fn_sub_page_3' ));
        add_submenu_page( 'qd_main_page', 'SP List', 'SP List', 'manage_options', 'qd_sub_page_4', array($this,'qd_fn_sub_page_4' ));
        add_submenu_page( 'qd_main_page', 'SP Setup', 'SP Setup', 'manage_options', 'qd_sub_page_5', array($this,'qd_fn_sub_page_5' ));
    }
    public function qd_custom_menu_page(){
        Qdmvc::loadPage('main');
    }
    public function qd_fn_sub_page_1(){
        Qdmvc::loadPage('product_cat_card');
    }
    public function qd_fn_sub_page_2(){
        Qdmvc::loadPage('product_cat_list');
    }
    public function qd_fn_sub_page_3(){
        Qdmvc::loadPage('product_card');
    }
    public function qd_fn_sub_page_4(){
        Qdmvc::loadPage('product_list');
    }
    public function qd_fn_sub_page_5(){
        Qdmvc::loadPage('product_setup');
    }
}
(new Qdmvc_RegisterAdminMenu());