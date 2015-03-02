<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardonly');
class Qdmvc_View_ProductSetup extends Qdmvc_Layout_CardOnly {
    function __construct($data){
        $this->data = $data;
    }
    protected function placeHolder3()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';

            //trigger open windows
            (function($){
                $(document).ready(function(){
                    //auto assign value from obj

                    //validate, require
                    requestFormValidate(
                        [
                            {
                                input: '#product_per_segment',
                                message: 'PPS is required!',
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
        ?>
        <script>
            (function($) {
                $(document).ready(function(){
                    // Here's my data model

                });
            })(jQuery);
        </script>
        <tr>

        </tr>
        <tr>

        </tr>
        <tr>
            <td>Product Per Segment:</td>
            <td>
                <input type="hidden" id="id" name="id" value="1">
                <input type="text" id="product_per_segment" name="product_per_segment" class="text-input" value="<?=$this->data['obj']->product_per_segment?>"/>
            </td>
        </tr>

        <tr>
            <td>Optional:</td>
            <td><input type="text" id="optional" name="optional" class="text-input" value="<?=$this->data['obj']->optional?>"/>
            </td>


        </tr>

        <?php
    }
}