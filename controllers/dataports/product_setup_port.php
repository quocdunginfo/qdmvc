<?php
class Qdmvc_Dataport_ProductSetup extends Qdmvc_Dataport {
    protected function setClass()
    {
        $this->class = 'QdProductSetup';
    }
    protected function beforeInsertAssign()
    {
        $this->obj->owner_id = get_current_user_id();
    }
    protected function beforeUpdateAssign()
    {
        $this->obj->lasteditor_id = get_current_user_id();
    }
    protected function assign()
    {
        //assign value
        $this->obj->product_per_segment = $_POST['data']['product_per_segment'];
        $this->obj->optional = $_POST['data']['optional'];

    }
}
(new Qdmvc_Dataport_ProductSetup())->run();