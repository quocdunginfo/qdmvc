<?php

class Qdmvc_Dataport_Product extends Qdmvc_Dataport
{
    protected function setClass()
    {
        $this->class = 'QdProduct';
    }

    protected function beforeInsertAssign()
    {
        $this->obj->owner_id = get_current_user_id();
    }

    protected function beforeUpdateAssign()
    {
        $this->obj->lasteditor_id = get_current_user_id();
    }
}
(new Qdmvc_Dataport_Product())->run();