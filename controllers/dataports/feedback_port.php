<?php
Qdmvc::loadDataPort('root');
class Qdmvc_Dataport_Feedback extends Qdmvc_Dataport
{
    protected function setClass()
    {
        $this->class = 'QdFeedback';
    }
}
(new Qdmvc_Dataport_Feedback())->run();