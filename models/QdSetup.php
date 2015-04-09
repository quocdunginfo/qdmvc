<?php

class QdSetup extends QdRootSetup
{
    static $table_name = 'mpd_setup';
    protected static $fields_config = array(
        'id' => array(),
        'df_language' => array(
            'Caption' => array('en' => 'DF Language', 'vn' => 'Ngôn ngữ mặc định'),
            'DataType' => 'Option',
            'Options' => array(
                'en' => array(
                    'Caption' => array('en' => 'English', 'vn' => 'Tiếng Anh'),
                ),
                'vn' => array(
                    'Caption' => array('en' => 'Vietnamese', 'vn' => 'Tiếng việt'),
                ),
            )
        ),

    );

    public function save($validate = true)
    {
        $re = parent::save($validate);
        if($re)
        {
            $this->pushValidateError('', 'Cần tải lại trang Web để có hiệu lực', 'warning');
        }
        return $re;
    }

}