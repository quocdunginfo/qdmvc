<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 02/03/2015
 * Time: 12:59 PM
 */
Qdmvc::loadLayout('layout_card');
class Qdmvc_Layout_CardOnly extends Qdmvc_Layout_Card {
    protected function placeHolder2()
    {
        //navigation list blank
    }
}