<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_cardsetup');
class Qdmvc_View_Setup extends Qdmvc_Layout_CardSetup {
    protected function onSaveOK()
    {
        parent::onSaveOK(); // TODO: Change the autogenerated stub
        ?>
        //location.reload();//reload when saving done
    <?php
    }

}