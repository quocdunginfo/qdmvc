<?php

class QdProductSetup extends QdRootSetup
{
    static $table_name = 'mpd_product_setup';

    public static function getFieldsConfig()
    {
        return array_merge(parent::getFieldsConfig(), array(
            'product_per_segment' => array(
                'Caption' => array('en' => 'Pro Per Segment', 'vn' => 'Số Lượng SP/1trang'),
            ),
            'df_pro_cat_avatar' => array(
                'Caption' => array('en' => 'DF Pro Cat Ava', 'vn' => 'Hình mặc định Pro Cat'),
                'DataType' => 'Image'
            ),
            'df_pro_avatar' => array(
                'Caption' => array('en' => 'DF Product Ava', 'vn' => 'Hình mặc định Product'),
                'DataType' => 'Image'
            ),
            'advice_phone' => array(
                'Caption' => array('en' => 'Advice Phone', 'vn' => 'SĐT tư vấn'),
            )
        ));
    }

}