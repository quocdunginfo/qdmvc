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
            $this->loadGetValue();
        }
        //exit
        $this->finish();
    }
    protected function setClass()
    {
        //$this->class = '';
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
        $this->obj = new $this->class();
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
        //assign value
        //$this->obj->name = $this->data['name'];
        //$this->obj->avatar = $this->data['avatar'];
        //$this->obj->parent_id = $this->data['parent_id'];
    }
    private function loadPostValue()
    {
        $this->data = $_POST['data'];
        $this->action = $_POST['action'];
    }
    private function loadGetValue()
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
        echo $c::toJSON($c::all(
                array(
                    'limit' => $pagesize,
                    'offset' => $recordstartindex,
                    'order' => 'id desc',
                    'conditions' => array($this->getFilterString()))
            )
        );
    }
    private function getFilterString()
    {
        $tmp = '';
        // correct approach
        while ( ($item = current($this->filter)) !== FALSE ) {

            $tmp .= key($this->filter) .' LIKE \'%'.$item.'%\' AND';
            next($this->filter);
        }
        $tmp .=' 1=1';
        return $tmp;
    }
}