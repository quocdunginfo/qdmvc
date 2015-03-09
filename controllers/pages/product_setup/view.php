<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardsetup');
class Qdmvc_View_ProductSetup extends Qdmvc_Layout_CardSetup {

    protected function formValidation()
    {
        ?>
        <script>
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
}