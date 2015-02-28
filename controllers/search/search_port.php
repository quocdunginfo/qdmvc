<?php
class Qdmvc_Search {
    private $key_word = '';
    private $limit = 10;
    private $offset = 0;
    function __construct()
    {

    }
    protected function finish()
    {
        exit(0);
    }
    protected function getResult()
    {
        $re = array();
        $record = new QdProduct();
        $record->SETRANGE('name', $this->key_word);
        //$record->REMOVERANGE('name');
        $record->SETLIMIT($this->limit);

        $products = $record->GETLIST();
        //var_dump($products);
        foreach($products as $item)
        {
            array_push($re, array('name' => $item->name, 'url' => $item->getPermalink()));
        }
        return json_encode($re);
    }
    public function run()
    {
        $this->key_word = $_GET['key_word'];
        $this->limit = $_GET['limit'];
        $this->offset = $_GET['offset'];

        echo $this->getResult();
        $this->finish();
    }
}
(new Qdmvc_Search())->run();