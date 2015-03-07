<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);

Qdmvc::loadLayout('layout_list');
class Qdmvc_View_Product_List extends Qdmvc_Layout_List
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
                {name: 'code'},
                {name: 'xuatxu'},
                {name: 'congsuat'},
                {name: 'dongco'},
                {name: 'trongluong'},
                {name: 'active'},
                {name: 'product_cat_id'},
                {name: '_product_cat_name'}
            ];
            //dataGrid define
            var dataGridDefine = [
                {text: 'ID', datafield: 'id', columntype: 'textbox', filtertype: 'input', width: 50},
                {text: 'Code', datafield: 'code', columntype: 'textbox', filtertype: 'input', width: 70},
                {text: 'Name', datafield: 'name', columntype: 'textbox', filtertype: 'input', width: 100},
                {text: 'Avatar', datafield: 'avatar', columntype: 'textbox', filtertype: 'input', width: 250},
                {text: 'Product Cat.', datafield: '_product_cat_name', columntype: 'textbox', filtertype: 'input'}
            ];
        </script>
    <?php
    }
}