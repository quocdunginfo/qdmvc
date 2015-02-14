<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
class Qdmvc_View_LoaiSP
{
    public $data = null;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function placeHolder3()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            (function ($) {
                $(document).ready(function () {
                    requestFormValidate(
                        [
                            {
                                input: '#name',
                                message: 'Name is required!',
                                action: 'keyup, blur',
                                rule: 'required'
                            }
                        ]
                    );
                });
            })(jQuery);
        </script>
    <?php
    }

    public function placeHolder1()
    {
        Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
        ?>
        <tr>
            <td>Name:</td>
            <td>
                <input type="hidden" id="id" name="id" value="0">
                <input type="text" id="name" name="name" class="text-input"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Avatar:</td>
            <td>
                <input size="70" type="text" id="avatar" name="avatar" class="text-input"/>
                <button id="cavatar" value="...">...</button>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Parent ID:</td>
            <td><input type="text" id="parent_id" name="parent_id" class="text-input"/></td>
        </tr>
    <?php
    }

    public function placeHolder2()
    {
        ?>
        <iframe id="list" src="http://localhost/mpd_2015/wp-admin/admin.php?page=qd_sub_page_2&qdrole=navigate"
                width="100%" scrolling="no" frameborder="0" height="420px">
            <p>Your browser does not support iframes</p>
        </iframe>
    <?php
    }
}

$Qdmvc_Layout_Card = new Qdmvc_Layout_Card();
$Qdmvc_Layout_Card->render(new Qdmvc_View_LoaiSP($data));
