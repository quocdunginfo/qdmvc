<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_ProductOrder extends Qdmvc_Dataport
{
    protected function setClass()
    {
        $this->class = 'QdProductOrder';
    }
}
(new Qdmvc_Dataport_ProductOrder())->run();