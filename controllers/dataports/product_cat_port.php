<?php
class Qdmvc_DataPort_ProductCat extends Qdmvc_Dataport {
    protected function setClass()
    {
        $this->class = 'QdProductCat';
    }
}
(new Qdmvc_DataPort_ProductCat())->run();