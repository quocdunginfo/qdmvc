<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_FrontProductOrder extends Qdmvc_Dataport
{
    private static $submit_fields = array('product_id', 'customer_name','customer_phone', 'customer_email', 'customer_address', 'mota', 'count');
    protected function setClass()
    {
        $this->class = 'QdProductOrder';
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

    protected function delete()
    {
        $this->msg = 'Không được phép xóa, ID='.$this->obj->id;
        return false;
    }

    protected function update()
    {
        $this->msg = 'Không được phép sửa, ID='.$this->obj->id;
        return false;
    }
}
(new Qdmvc_Dataport_FrontProductOrder())->run();