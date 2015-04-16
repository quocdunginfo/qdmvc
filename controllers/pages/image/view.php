<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardnavigate');
class Qdmvc_View_Image extends Qdmvc_Layout_CardNavigate {

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

                        ]
                    );
                });
            })(jQuery);
        </script>
        <?php
    }
}