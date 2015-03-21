<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:38 PM
 */
Qdmvc::loadPage('root');
class Qdmvc_Page_Main extends Qdmvc_Page_Root {
    public static function getPage()
    {
        return 'main';
    }
}