<?php

class QdProductSetup extends QdRootSetup
{
    static $table_name = 'mpd_product_setup';
    protected static $fields_config = array(
        'id' => array(),
        'product_per_segment' => array(
            'Caption' => array('en' => 'Pro Per Segment', 'vn' => '@'),
        ),
        'df_pro_cat_avatar' => array(
            'Caption' => array('en' => 'DF Pro Cat Ava', 'vn' => 'Hình mặc định Pro Cat'),
            'DataType' => 'Image'
        ),
        'df_pro_avatar' => array(
            'Caption' => array('en' => 'DF Product Ava', 'vn' => 'Hình mặc định Product'),
            'DataType' => 'Image'
        )
    );
}