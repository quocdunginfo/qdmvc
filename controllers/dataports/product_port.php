<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_Product extends Qdmvc_Dataport
{
    protected function setClass()
    {
        $this->class = 'QdProduct';
    }
}
(new Qdmvc_Dataport_Product())->run();