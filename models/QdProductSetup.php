<?php

class QdProductSetup extends QdRootSetup
{
    static $table_name = 'mpd_product_setup';
    protected static $fields_config = array(
        'id' => array(),
        'product_per_segment' => array(),
        'optional' => array()
    );
}