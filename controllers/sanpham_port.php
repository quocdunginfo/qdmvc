<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:35 PM

 */
header('Content-Type: application/json');
if(isset($_POST["submit"]))
{
    $msg = '';
    $obj = null;
    if($_POST["action"]=='delete')
    {
        $obj = QdProduct::find($_POST['data']['id']);
        $obj->delete();
        $msg = 'Xóa thành công, ID='.$obj->id;
    }
    else
    {
        $add = ($_POST['data']['id'] == '0') || ($_POST['data']['id'] == '');
        //init obj
        if ($add) {
            //insert
            $obj = new QdProduct();
            $obj->owner_id = get_current_user_id();
        } else {
            //update
            $obj = QdProduct::find($_POST['data']['id']);
            $obj->lasteditor_id = get_current_user_id();
        }
        //assign value
        $obj->name = $_POST['data']['name'];
        $obj->avatar = $_POST['data']['avatar'];
        $obj->code = $_POST['data']['code'];
        $obj->xuatxu = $_POST['data']['xuatxu'];
        $obj->congsuat = $_POST['data']['congsuat'];
        $obj->dongco = $_POST['data']['dongco'];
        $obj->trongluong = $_POST['data']['trongluong'];
        $obj->active = $_POST['data']['active'];
        if($obj->active==null || $obj->active!=1)
        {
            $obj->active = 0;
        }
        $obj->product_cat_id = $_POST['data']['product_cat_id'];
        //action
        $obj->save();
        if ($add) {
            //insert
            $msg = 'Thêm thành công, ID=' . $obj->id;
        } else {
            //update
            $msg = 'Cập nhật thành công, ID=' . $obj->id;
        }
    }

    $arr = array(
        'msg' => $msg,
        'id' => $obj->id
    );
    //return
    echo json_encode($arr);
}
else
{
    $recordstartindex = isset($_REQUEST['recordstartindex'])?$_REQUEST['recordstartindex']:0;
    $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
    $filterdatafield0 = isset($_REQUEST['filterdatafield0'])?$_REQUEST['filterdatafield0']:'id';
    $filtervalue0 = isset($_REQUEST['filtervalue0'])?$_REQUEST['filtervalue0']:'';
    echo QdProduct::toJSON(QdProduct::all(
        array(
            'limit' => $pagesize,
            'offset' => $recordstartindex,
            'order' => 'id desc',
            'conditions' => array($filterdatafield0.' LIKE \'%'.$filtervalue0.'%\''))
        )
    );
}
exit(0);