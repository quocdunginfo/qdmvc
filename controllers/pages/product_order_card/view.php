<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//import libraries
Qdmvc::loadLayout('layout_card');
class Qdmvc_View_ProductOrder_Card extends Qdmvc_Layout_Card {
    protected function formValidation()
    {
        ?>
        <script>
            //trigger open windows
            (function($){
                $(document).ready(function(){
                    //validate
                    requestFormValidate(
                        [

                        ]
                    );
                });
            })(jQuery);
        </script>
        <?php
    }
}