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
        $record->SETRANGE('model', $this->key_word);
        $record->SETRANGE('xuatxu', $this->key_word);
        $record->SETFILTERRELATION('OR');
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
        header('Content-Type: application/json');

        $this->key_word = isset($_GET['key_word'])?$_GET['key_word']:'';
        $this->limit = isset($_GET['limit'])?$_GET['limit']:-1;
        $this->offset = isset($_GET['offset'])?$_GET['offset']:0;

        echo $this->getResult();
        //echo $record::connection()->last_query;
        $this->finish();
    }
}
(new Qdmvc_Search())->run();