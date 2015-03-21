<?php
Qdmvc::loadDataPort('root');
Qdmvc::loadDataPort('product_order');
class Qdmvc_Dataport_FrontProductOrder extends Qdmvc_Dataport_ProductOrder
{
    private static $submit_fields = array('product_id', 'customer_name','customer_phone', 'customer_email', 'customer_address', 'mota', 'count');

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
        $this->pushMsg('Không được phép xóa, ID='.$this->obj->id);
        $this->finish();
    }

    protected function update()
    {
        $this->pushMsg('Không được phép sửa, ID='.$this->obj->id);
        $this->finish();
    }
}