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
        $this->obj->owner_id = get_current_user_id();
    }

    protected function beforeUpdateAssign()
    {
        $this->obj->lasteditor_id = get_current_user_id();
    }
    protected function insert()
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
    protected function update()
    {
        //update
        $c = $this->class;
        $this->obj = $c::find($this->data["id"]);
        $this->beforeInsertAssign();
        $this->assign();
        $this->obj->save();
        $this->msg = 'Cập nhật thành công, ID='.$this->obj->id;
    }
    protected function delete()
    {
        $c = $this->class;
        $this->obj = $c::find($this->data['id']);
        $this->obj->delete();
        $this->msg = 'Xóa thành công, ID='.$this->obj->id;
    }
    private function loadPostValue()
    {
        $this->data = $_POST['data'];
        $this->action = $_POST['action'];
    }
    protected function list_return()
    {
        $recordstartindex = isset($_REQUEST['recordstartindex'])?$_REQUEST['recordstartindex']:0;
        $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $count = 0;
        if(isset($_REQUEST['filterdatafield99']))//quocdunginfo
        {
            $this->filter[$_REQUEST['filterdatafield99']] = $_REQUEST['filtervalue99'];
        }
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
    protected function assign()
    {
        //assign value
        $c = $this->class;
        foreach ($c::getFieldsConfig() as $key => $value) {
            if($c::ISFLOWFIELD($key))
            {
                continue;
            }
            //Boolean
            if (
                in_array($c::getDataType($key), array('Boolean'))
            ) {
                if (isset($_POST['data'][$key])) {
                    $this->obj->$key = 1;
                }
                else
                {
                    $this->obj->$key = 0;
                }
            }else {
                if (isset($_POST['data'][$key])) {
                    $this->obj->$key = $_POST['data'][$key];
                }
            }

        }
    }
}