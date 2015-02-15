<?php
class Qdmvc_SanPham_DP extends Qdmvc_Dataport{
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
    protected function assign()
    {
        //assign value
        $this->obj->name = $_POST['data']['name'];
        $this->obj->avatar = $_POST['data']['avatar'];
        $this->obj->code = $_POST['data']['code'];
        $this->obj->xuatxu = $_POST['data']['xuatxu'];
        $this->obj->congsuat = $_POST['data']['congsuat'];
        $this->obj->dongco = $_POST['data']['dongco'];
        $this->obj->trongluong = $_POST['data']['trongluong'];
        $this->obj->active = $_POST['data']['active'];
        if($this->obj->active==null || $this->obj->active!=1)
        {
            $this->obj->active = 0;
        }
        $this->obj->product_cat_id = $this->data['product_cat_id'];
    }
}
$Qdmvc_SanPham_DP = new Qdmvc_SanPham_DP();