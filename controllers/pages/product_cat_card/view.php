<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_card');
class Qdmvc_View_ProductCat_Card extends Qdmvc_Layout_Card
{
    function __construct($data)
    {
        $this->data = $data;
    }

    protected function placeHolder3()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            (function ($) {
                $(document).ready(function () {
                    //lookup
                    //lookup
                    $('#cproduct_cat_id').click(function () {
                        requestLookupWindow("<?=Qdmvc_Helper::getLSPLookupPath('parent_id')?>");
                    });
                    //validate
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

    protected function placeHolder1()
    {
        Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
        ?>
        <script>
            (function($) {
                $(document).ready(function(){
                    // Here's my data model
                    var mViewModel = function() {
                        this.AvatarImgUrl = ko.observable("");
                    };
                    ko.applyBindings(new mViewModel());
                });
            })(jQuery);
        </script>
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
            <td colspan="3">
                <input type="text" id="avatar" data-bind="textInput: AvatarImgUrl" name="avatar" class="text-input"/>
                <button id="cavatar" value="...">...</button><img data-bind="attr:{src: AvatarImgUrl}" style="width: 50px; height: 50px" >
            </td>

        </tr>
        <tr>
            <td>Parent ID:</td>
            <td><input type="text" id="parent_id" name="parent_id" class="text-input"/>

                <button id="cproduct_cat_id" value="...">...</button>
            </td>
            <td>Order:</td>
            <td><input type="text" id="order" name="order" class="text-input"/></td>
        </tr>
    <?php
    }

    protected function placeHolder2()
    {
        return Qdmvc_Helper::getLSPCompactListLink();
    }
}