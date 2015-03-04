<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRootSetup extends QdRoot
{
    public function on_before_create()
    {
        if(static::find(1)!=null)
        {
            exit(0);
        }

        parent::on_before_create();
    }
}