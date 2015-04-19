<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 20/03/2015
 * Time: 10:03 PM
 */
Qdmvc::loadDataPort('note_port');
class Qdmvc_DataPort_Log extends Qdmvc_DataPort_Note
{
    protected static $model = 'QdLog';
}