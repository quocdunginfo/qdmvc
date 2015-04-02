<?php

class QdSetup extends QdRootSetup
{
    static $table_name = 'mpd_setup';
    protected static $fields_config = array(
        'id' => array(),
        'df_language' => array(
            'Caption' => array('en' => 'DF Language', 'vn' => 'Ngôn ngữ mặc định'),
        ),

    );
}