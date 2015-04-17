<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/03/2015
 * Time: 7:08 PM
 */
Qdmvc::loadLayout('layout_card');
class Qdmvc_Layout_CardSetup extends Qdmvc_Layout_Card
{
    protected function onReadyHook()
    {
        ?>
        <script>
            (function($){
                $(document).ready(function(){
                    $("#qdnew").hide();
                    $("#qdclone").hide();
                    $("#qddelete").hide();
                    $("#qdnote").hide();
                    $("#qdimage").hide();
                });
            })(jQuery);
        </script>
        <?php
        parent::onReadyHook();
    }
}