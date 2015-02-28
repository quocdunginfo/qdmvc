<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */

$data['data_port'] = Qdmvc_Helper::getDataPortPath('sanpham_port');
$data['role'] = isset($_REQUEST['qdrole'])?$_REQUEST['qdrole']:'navigate';//lookup, navigate
$data['returnid'] = isset($_REQUEST['qdreturnid'])?$_REQUEST['qdreturnid']:'';//lookup, navigate
$data['view_style'] = 'compact';//compact, full
Qdmvc_Helper::requestCompact();
require_once(Qdmvc::getView() . 'sanpham_list.php');