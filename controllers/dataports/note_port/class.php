<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 20/03/2015
 * Time: 10:03 PM
 */
Qdmvc::loadDataPort('root');
class Qdmvc_DataPort_Note extends Qdmvc_Dataport
{
    protected static $model = 'QdNote';
}