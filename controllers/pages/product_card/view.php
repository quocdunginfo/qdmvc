<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//import libraries
Qdmvc::loadLayout('layout_cardnavigate');
class Qdmvc_View_Product_Card extends Qdmvc_Layout_CardNavigate {
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
    protected function bindingField()
    {
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
        <?php
    }
}