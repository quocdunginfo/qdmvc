<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardnavigate');
class Qdmvc_View_ProductCat_Card extends Qdmvc_Layout_CardNavigate
{
    protected function formValidation()
    {
        ?>
        <script>
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
}