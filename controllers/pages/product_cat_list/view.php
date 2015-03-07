<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
Qdmvc::loadLayout('layout_list');
class Qdmvc_View_ProductCat_List extends Qdmvc_Layout_List
{
    protected function placeHolder1()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            //dataSourceDefine
            var dataSourceDefine = [
                {name: 'id'},
                {name: 'name'},
                {name: 'avatar'},
                {name: 'order'},
                {name: 'parent_id'}
            ];
            //dataGrid define
            var dataGridDefine = [
                {text: 'ID', datafield: 'id', columntype: 'textbox', filtertype: 'input', width: 50},
                {text: 'Name', datafield: 'name', columntype: 'textbox', filtertype: 'input', width: 250},
                {text: 'Avatar', datafield: 'avatar', columntype: 'textbox', filtertype: 'input', width: 250},
                {text: 'Order', datafield: 'order', columntype: 'textbox', filtertype: 'input', width: 70},
                {text: 'Parent id', datafield: 'parent_id', columntype: 'textbox', filtertype: 'input'}
            ];
        </script>
    <?php
    }
}