<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_ProductSetup extends Qdmvc_Dataport {
    protected function setClass()
    {
        $this->class = 'QdProductSetup';
    }
}
(new Qdmvc_Dataport_ProductSetup())->run();