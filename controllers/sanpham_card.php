<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM
 */

$data['data_port'] = 'http://localhost/mpd_2015/?qd-api=sanpham_port';
$data['view_style'] = 'compact';
Qdmvc_Helper::requestCompact();
require_once(Qdmvc::getView() . 'sanpham_card.php');