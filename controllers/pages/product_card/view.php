<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//import libraries
Qdmvc::loadLayout('layout_card');
class Qdmvc_View_Product_Card extends Qdmvc_Layout_Card {
    function __construct($data){
        $this->data = $data;
    }
    protected function placeHolder3()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            //var fieldlist = {id: 0, name: "mac dinh", avatar: "/", product_cat_id: "0"};

            //trigger open windows
            (function($){
                $(document).ready(function(){
                    //lookup
                    $('#cproduct_cat_id').click(function () {
                        requestLookupWindow("<?=Qdmvc_Helper::getLSPLookupPath('product_cat_id')?>");
                    });
                    //validate
                    requestFormValidate(
                        [

                            {
                                input: '#name',
                                message: 'Name is required!',
                                action: 'keyup, blur',
                                rule: 'required'
                            },
                            {
                                input: '#code',
                                message: 'Code is required!',
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

        </tr>
        <tr>

        </tr>
        <tr>
            <td>Name:</td>
            <td>
                <input type="hidden" id="id" name="id" value="0">
                <input type="text" id="name" name="name" class="text-input"/>
            </td>
        </tr>
        <tr>
            <td>Avatar:</td>
            <td>
                <input type="text" id="avatar" data-bind="textInput: AvatarImgUrl" name="avatar" class="text-input"/>
                <button id="cavatar" value="...">...</button><img data-bind="attr:{src: AvatarImgUrl}" style="width: 50px; height: 50px" >
            </td>
        </tr>
        <tr>
            <td>Product Cat ID:</td>
            <td><input type="text" id="product_cat_id" name="product_cat_id" class="text-input"/>
                <button id="cproduct_cat_id" value="...">...</button>

            </td>


        </tr>
        <tr>
            <td>Code:</td>
            <td>
                <input type="text" id="code" name="code" class="text-input"/>
            </td>
            <td>Xuat xu:</td>
            <td>
                <input type="text" id="xuatxu" name="xuatxu" class="text-input"/>
            </td>
        </tr>
        <tr>
            <td>Cong suat:</td>
            <td>
                <input type="text" id="congsuat" name="congsuat" class="text-input"/>
            </td>
            <td>Dong co:</td>
            <td>
                <input type="text" id="dongco" name="dongco" class="text-input"/>
            </td>
        </tr>
        <tr>
            <td>Trong luong:</td>
            <td>
                <input type="text" id="trongluong" name="trongluong" class="text-input"/>
            </td>
            <td>Active:</td>
            <td>
                <input type="checkbox" id="active" name="active" value="1" checked="checked"/>
            </td>
        </tr>
        <?php
    }
    protected function placeHolder2()
    {
        return Qdmvc_Helper::getSPCompactListLink();
    }
}