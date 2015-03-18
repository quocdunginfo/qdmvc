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
    protected $msg = array();
    protected $action = 'update';
    private $for_card = true;
    //private $filter = array();
    function __construct()
    {

    }
    protected function pushMsg($msg)
    {
        if(is_array($msg))
        {
            $this->msg = array_merge($this->msg, $msg);
        }
        else
        {
            array_push($this->msg, $msg);
        }

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
    protected function finish($msg_array=null, $result_array=null, $total=0, $id=0)
    {
        $re = array();
        $c = $this->class;
        if($msg_array!=null)
        {
            $re['msg'] = $msg_array;
        }
        if($result_array!=null)
        {
            $re['rows'] = $c::toJSON($result_array);
        }
        $re['id'] = $id;

        if($total!=null)
        {
            $re['total'] = $total;
        }

        echo json_encode($re);
        exit(0);
    }
    private function card_return()
    {
        $this->finish($this->msg, array($this->obj),1,$this->obj->id);
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

        if($this->obj->VALIDATE())
        {
            $this->obj->save();
            $this->pushMsg('Thêm mới thành công, ID='.$this->obj->id);
        }
        else
        {
            $this->pushMsg($this->obj->GETVALIDATION());
        }
    }
    protected function update()
    {
        //update
        $c = $this->class;
        $this->obj = $c::find($this->data["id"]);
        $this->beforeInsertAssign();
        $this->assign();
        if($this->obj->VALIDATE())
        {
            $this->obj->save();
            $this->pushMsg('Cập nhật thành công, ID='.$this->obj->id);
        }
        else
        {
            $this->pushMsg($this->obj->GETVALIDATION());
        }
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

        $c = $this->class;
        $record = new $c();

        //pre filter
        $count = 99;
        if(isset($_REQUEST['filterdatafield'.$count]))//quocdunginfo
        {
            //$this->filter[$_REQUEST['filterdatafield'.$count]] = $_REQUEST['filtervalue'.$count];
            $record->SETRANGE($_REQUEST['filterdatafield'.$count], $_REQUEST['filtervalue'.$count], true);
            $count++;
        }
        $count = 0;
        while(isset($_REQUEST['filterdatafield'.$count]))
        {
            //$this->filter[$_REQUEST['filterdatafield'.$count]] = $_REQUEST['filtervalue'.$count];
            $record->SETRANGE($_REQUEST['filterdatafield'.$count], $_REQUEST['filtervalue'.$count], false);
            $count++;
        }

        //$record->SETFILTER($this->filter);
        $record->SETLIMIT($pagesize);
        $record->SETOFFSET($recordstartindex);
        $record->SETORDERBY('id', 'desc');

        $this->finish(array('List Card Return'), $record->GETLIST(), $record->COUNTLIST());
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