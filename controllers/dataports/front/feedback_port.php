<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_FrontFeedback extends Qdmvc_Dataport
{
    protected function setClass()
    {
        $this->class = 'QdFeedback';
    }
    private static $submit_fields = array('customer_name', 'customer_email', 'content');
    protected function delete()
    {
        $this->pushMsg('Không được phép xóa');
        $this->finish();
    }

    protected function update()
    {
        $this->pushMsg('Không được phép sửa');
        $this->finish();
    }
    protected function assign()
    {
        foreach(static::$submit_fields as $item)
        {
            if(isset($_POST['data'][$item]))
            {
                $this->obj->$item = $_POST['data'][$item];
            }
        }
    }
}
(new Qdmvc_Dataport_FrontFeedback())->run();