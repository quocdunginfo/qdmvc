<?php

class QdNote extends QdRoot
{
    static $table_name = 'mpd_note';

    protected static $fields_config = array(
        'id' => array(),
        'content' => array(),
        'model' => array(),
        'model_id' => array()
    );
}