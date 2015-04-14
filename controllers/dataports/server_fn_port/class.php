<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 20/03/2015
 * Time: 10:03 PM
 */
class Qdmvc_Server_Fn_DataPort extends Qdmvc_Dataport
{
    protected function callServerFn()
    {
        //process from data param
        $class_name = $this->data['class'];
        $function = $this->data['fn'];
        $params = $this->data['params'];

        $re = Qdmvc_Helper::callServerFn($class_name, $function, $params);
        $this->pushMsg($re,'info');
    }

}