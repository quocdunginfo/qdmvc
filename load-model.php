<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:21 PM
 */
$hgtfr_con = QdPhpactiverecords::getCon();
ActiveRecord\Config::initialize(function($cfg) use ($hgtfr_con)
{
    $model_dir = Qdmvc::getModel();
    $cfg->set_model_directory($model_dir);
    $cfg->set_connections($hgtfr_con);

    # default connection is now production
    $cfg->set_default_connection('production');
});
