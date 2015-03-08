<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 02/03/2015
 * Time: 12:59 PM
 */
Qdmvc::loadLayout('layout_card');
class Qdmvc_Layout_CardOnly extends Qdmvc_Layout_Card {
    protected function getPageListURL()
    {
        //navigation list blank
        return '';
    }

    protected function onReadyHook()
    {
        ?>
        <script>
            (function($){
                $(document).ready(function(){
                    $("#new").hide();
                    $("#clone").hide();
                    $("#delete").hide();
                });
            })(jQuery);
        </script>
        <?php

        parent::onReadyHook();
    }

}