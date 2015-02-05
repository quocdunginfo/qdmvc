<?php
class Qdmvc_RegisterAdminMenu{
    function __construct()
    {
        add_action( 'admin_menu', array($this, 'qd_register_custom_menu_page'));
    }
    public function qd_register_custom_menu_page(){
        add_menu_page( 'QD PLUGIN', 'QD PLUGIN', 'manage_options', 'qd_main_page', array($this, 'qd_custom_menu_page'));
        //sub
        /*
        add_submenu_page( 'qd_main_page', 'Quản lý profile', 'Quản lý profile', 'manage_options', 'qd_sub_page_1', 'qd_fn_sub_page_1' );
        */
    }

    public function qd_custom_menu_page(){
        require_once(Qdmvc::getController().'main.php');
    }
}
$Qdmvc_RegisterAdminMenu = new Qdmvc_RegisterAdminMenu();