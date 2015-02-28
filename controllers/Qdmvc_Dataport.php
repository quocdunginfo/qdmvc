<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 15/02/2015
 * Time: 9:20 AM
 */
class Qdmvc_Dataport {
    protected $class = '';
    protected $obj = null;
    protected $data = null;
    protected $msg = '';
    protected $action = 'update';
    private $for_card = true;
    private $filter = array();
    function __construct()
    {

    }
    public function run()
    {
        $this->setClass();
        header('Content-Type: application/json');

        $this->for_card = isset($_POST) && isset($_POST['submit']);
        if($this->for_card)
        {
            $this->loadPostValue();
            if($this->action=='delete')
            {
                $this->delete();
            }
            else if ($this->action=='update')
            {
                $this->update();
            }
            else if ($this->action=='insert')
            {
                $this->insert();
            }
            $this->card_return();
        }
        else
        {
            $this->list_return();
        }
        //exit
        $this->finish();
    }
    protected function setClass()
    {

    }
    private function finish()
    {
        exit(0);
    }
    private function card_return()
    {
        $arr = array(
            'msg' => $this->msg,
            'id' => $this->obj->id
        );
        //return
        echo json_encode($arr);
    }
    protected function beforeInsertAssign()
    {

    }
    protected function beforeUpdateAssign()
    {

    }
    private function insert()
    {
        //insert
        $c = $this->class;
        $this->obj = new $c();
        $this->beforeInsertAssign();
        $this->assign();
        //action
        $this->obj->save();
        $this->msg = 'Thêm mới thành công, ID='.$this->obj->id;
    }
    private function update()
    {
        //update
        $c = $this->class;
        $this->obj = $c::find($this->data["id"]);
        $this->beforeInsertAssign();
        $this->assign();
        $this->obj->save();
        $this->msg = 'Cập nhật thành công, ID='.$this->obj->id;
    }
    private function delete()
    {
        $c = $this->class;
        $this->obj = $c::find($this->data['id']);
        $this->obj->delete();
        $this->msg = 'Xóa thành công, ID='.$this->obj->id;
    }
    protected function assign()
    {

    }
    private function loadPostValue()
    {
        $this->data = $_POST['data'];
        $this->action = $_POST['action'];
    }
    private function list_return()
    {
        $recordstartindex = isset($_REQUEST['recordstartindex'])?$_REQUEST['recordstartindex']:0;
        $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $count = 0;
        while(isset($_REQUEST['filterdatafield'.$count]))
        {
            $this->filter[$_REQUEST['filterdatafield'.$count]] = $_REQUEST['filtervalue'.$count];
            $count++;
        }
        $c = $this->class;
        $record = new $c();

        $record->SETFILTER($this->filter);
        $record->SETLIMIT($pagesize);
        $record->SETOFFSET($recordstartindex);
        $record->SETORDERBY('id', 'desc');

        echo json_encode(array(
            'rows' => $c::toJSON($record->GETLIST()),
            'total' => $record->COUNTLIST(),
            'msg' => 'List Card Return'
        ));
    }
}