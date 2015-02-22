<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 12/02/2015
 * Time: 11:19 PM
 */
class Qdmvc_Layout
{
    private $layouts = array('layout_card.php', 'layout_list.php');
    function __construct()
    {
        foreach($this->layouts as $item)
        {
            require_once(Qdmvc::getView() . $item);
        }
    }
}
$Qdmvc_Layout = new Qdmvc_Layout();