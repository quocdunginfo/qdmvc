<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 02/04/2015
 * Time: 10:51 PM
 */
class Qdmvc_Config {
    private static $language = null;
    function __construct(){

    }
    public static function getLanguage()
    {
        if(static::$language==null)
        {
            static::$language = QdSetup::GET()->df_language;
        }
        return static::$language;
    }
}