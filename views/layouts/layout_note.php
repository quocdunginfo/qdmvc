<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardnavigate');
class Qdmvc_Layout_Note extends Qdmvc_Layout_CardNavigate
{
    protected function onReadyHook()
    {
        ?>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {

                });
            })(jQuery);
        </script>
        <?php
        parent::onReadyHook();
    }
    protected function onSaveOK()
    {
        parent::onSaveOK();
    }
    protected function onDeleteOK()
    {
        parent::onDeleteOK();
    }
}