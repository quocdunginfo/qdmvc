<?php
class Qdmvc_LoaiSP_DP extends Qdmvc_Dataport{
    protected function setClass()
    {
        $this->class = 'QdProductCat';
    }
    protected function assign()
    {
        //assign value
        $this->obj->name = $this->data['name'];
        $this->obj->avatar = $this->data['avatar'];
        $this->obj->order = $this->data['order'];
        $this->obj->parent_id = $this->data['parent_id'];
    }
}
$Qdmvc_LoaiSP_DP = new Qdmvc_LoaiSP_DP();