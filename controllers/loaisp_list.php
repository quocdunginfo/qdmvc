<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */

class Qdmvc_LSP_Controller
{
    function __construct()
    {

    }
    public function run()
    {
        $data['data_port'] = get_site_url().'?qd-api=loaisp_port';
        $data['role'] = isset($_REQUEST['qdrole'])?$_REQUEST['qdrole']:'navigate';//lookup, navigate
        $data['returnid'] = isset($_REQUEST['qdreturnid'])?$_REQUEST['qdreturnid']:'';//lookup, navigate
        $data['view_style'] = 'compact';
        Qdmvc_Helper::requestCompact();
        require_once(Qdmvc::getView() . 'loaisp_list.php');
    }
}
(new Qdmvc_LSP_Controller())->run();
