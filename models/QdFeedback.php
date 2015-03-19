<?php

class QdFeedback extends QdRoot
{
    static $table_name = 'mpd_feedback';

    protected static $fields_config = array(
        'customer_name' => array(
            'Caption' => array('en' => 'Customer Name', 'vn' => 'Tên KH')
        ),
        'customer_email' => array(
            'Caption' => array('en' => 'Customer Email', 'vn' => 'Email KH')
        ),
        'content' => array(
            'Caption' => array('en' => 'Content', 'vn' => 'Nội dung')
        ),
        'done' => array(
            'Caption' => array('en' => 'Done', 'vn' => 'Hoàn tất'),
            'DataType' => 'Boolean'
        ),
        'id' => array()
    );
    protected function contentOnValidate()
    {
        if($this->content!=$this->xRec()->content)
        {
            if($this->done)
            {
                $this->pushValidateError('Không thể sửa Content khi Done = true');
            }
        }
    }
    protected function customer_emailOnValidate()
    {
        if($this->customer_email!=$this->xRec()->customer_email)
        {
            if($this->done)
            {
                $this->pushValidateError('Không thể sửa Customer Email khi Done = true');
            }
        }

    }
    protected function customer_nameOnValidate()
    {
        if($this->customer_name!=$this->xRec()->customer_name)
        {
            if($this->done)
            {
                $this->pushValidateError('Không thể sửa Customer Name khi Done = true');
            }
        }
    }
}