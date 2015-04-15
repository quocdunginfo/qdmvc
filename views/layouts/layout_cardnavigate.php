<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc::loadLayout('layout_card');
class Qdmvc_Layout_CardNavigate extends Qdmvc_Layout_Card
{
    protected function getPageListURL()
    {
        $c = $this->page;
        return $c->getPageListURL();
    }

    protected function internalGateway()
    {
        ?>
        <script>
            //update grid
            function updateGrid() {
                try {
                    document.getElementById('list').contentWindow.updateGrid();
                } catch (error) {
                    console.log(error);
                }
            }
        </script>
    <?php
        parent::internalGateway();
    }

    protected function externalGateway()
    {
        ?>
        <script>
            //gate way to comunicate with parent windows
            function doubleClickObj(obj) {//do not change func name
                (function ($) {
                    $('#jqxNavigationBar').jqxNavigationBar('expandAt', 0);
                    //set obj too
                    setObj(obj);
                })(jQuery);
            }
        </script>
    <?php
        parent::externalGateway();
    }

    protected function preConfig()
    {
        parent::preConfig();
        ?>
        <?= $this->bindingField() ?>

        <?php
    }


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
        ?>
        if(!formValidationError())
        {
            updateGrid();
        }

        <?php
        parent::onSaveOK();
    }
    protected function onDeleteOK()
    {
        ?>
        updateGrid();
    <?php
        parent::onDeleteOK();
    }

    protected function bindingField()
    {

    }


    protected function Bars()
    {
        parent::Bars();
        ?>
        <div>
            <div style='margin-top: 2px;'>
                <div style='margin-left: 4px; float: left;'>
                    Navigator
                </div>
            </div>
        </div>
        <div>
            <div style="height: 520px; width: 100%">
                <!-- Content Place Holder 2 -->
                <iframe id="list" src="<?= $this->getPageListURL() ?>"
                        width="100%" height="99%" scrolling="no" frameborder="0">
                    <p>Your browser does not support iframes</p>
                </iframe>
                <!-- ENd Content Place Holder 2 -->
            </div>
        </div>
    <?php
    }
}