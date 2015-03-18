<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 02/03/2015
 * Time: 12:59 PM
 */
class Qdmvc_Layout_Card
{
    protected $obj = null;
    protected $page = null;
    protected $data = null;

    function __construct($page)
    {
        $this->page = $page;
        $this->data = $page->getData();
        if (isset($this->data['obj'])) {
            $this->obj = $this->data['obj'];
        }
    }

    protected function internalGateway()
    {
        ?>
        <script>
            function requestLookupWindow(src) {
                //set window iframe source
                //alert(src);
                (function ($) {
                    $('#windowFrame').attr('src', src);
                    $('#qdwindow').jqxWindow('open');
                })(jQuery);
            }
            function requestFormValidate(rules_) {
                (function ($) {
                    //register validate
                    $('#cardForm').jqxValidator({
                        rules: rules_
                    });
                })(jQuery);
            }
        </script>
    <?php
    }

    protected function formValidation()
    {
        ?>
        <script>
            //trigger open windows
            (function ($) {
                $(document).ready(function () {
                    //auto assign value from obj
                    //validate, require
                    requestFormValidate(
                        []
                    );
                });
            })(jQuery);
        </script>
    <?php
    }

    private function progressSpinner()
    {
        ?>
        <style>
            .ajax_loader {
                background: url(<?=Qdmvc_Helper::getImgURL("ajax-loader_blue.gif")?>) no-repeat center center transparent;
                width: 100%;
                height: 100%;
            }
        </style>
        <script>
            /*
             * Ajax overlay 1.0
             * Author: Simon Ilett @ aplusdesign.com.au
             * Descrip: Creates and inserts an ajax loader for ajax calls / timed events
             * Date: 03/08/2011
             */
            function ajaxLoader (el, options) {
                // Becomes this.options
                var defaults = {
                    bgColor 		: '#fff',
                    duration		: 800,
                    opacity			: 0.7,
                    classOveride 	: false
                }
                this.options 	= jQuery.extend(defaults, options);
                this.container 	= jQuery(el);

                this.init = function() {
                    var container = this.container;
                    // Delete any other loaders
                    this.remove();
                    // Create the overlay
                    var overlay = jQuery('<div></div>').css({
                        'background-color': this.options.bgColor,
                        'opacity':this.options.opacity,
                        'width':container.width(),
                        'height':container.height(),
                        'position':'absolute',
                        'top':'0px',
                        'left':'0px',
                        'z-index':99999
                    }).addClass('ajax_overlay');
                    // add an overiding class name to set new loader style
                    if (this.options.classOveride) {
                        overlay.addClass(this.options.classOveride);
                    }
                    // insert overlay and loader into DOM
                    container.append(
                        overlay.append(
                            jQuery('<div></div>').addClass('ajax_loader')
                        ).fadeIn(this.options.duration)
                    );
                };

                this.remove = function(){
                    var overlay = this.container.children(".ajax_overlay");
                    if (overlay.length) {
                        overlay.fadeOut(this.options.classOveride, function() {
                            overlay.remove();
                        });
                    }
                }

                this.init();
            }

        </script>
        <script>
            //trigger open windows
            (function ($) {
                $(document).ready(function () {
                    //var ajax_loader;
                    $.ajaxSetup({
                        beforeSend: function () {

                        },
                        complete: function () {
                            //$('#loader').hide();
                            //ajax_loader.remove();
                        }
                        /*
                         ,success: function() {

                         }*/
                    });
                });
            })(jQuery);
        </script>

    <?php
    }

    protected function preConfig()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            //ajax_loader
            var ajax_loader;
        </script>
    <?php
    }

    private function lookupWindowLayout()
    {
        ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    //init window for lookup
                    $('#qdwindow').jqxWindow({
                        showCollapseButton: false,
                        //maxHeight: 600,
                        //maxWidth: 1020,
                        minHeight: 200,
                        minWidth: 200,
                        height: '80%',
                        width: '100%',
                        autoOpen: false,
                        isModal: true,
                        initContent: function () {
                            //$('#tab').jqxTabs({ height: '100%', width:  '100%' });
                            //$('#window').jqxWindow('focus');
                        }
                    });

                });
            })(jQuery);
        </script>

        <div id="qdwindow">
            <div id="windowHeader">
                    <span>
                        Lookup Window
                    </span>
            </div>
            <div style="overflow: hidden;" id="windowContent">
                <iframe id="windowFrame" src="" frameborder="0" marginwidth="0" marginheight="0" scrolling="auto"
                        width="100%" height="100%">
                    <p>Your browser does not support iframes</p>
                </iframe>
            </div>
        </div>
    <?php
    }

    protected function externalGateway()
    {
        ?>
        <script>
            //gate way to comunicate with parent windows
            function setObj(obj) {//do not change func name
                (function ($) {
                    $("#cardForm").autofill(obj);
                    $("#cardForm input").change();
                    //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                })(jQuery);
            }
        </script>
        <?php
    }

    private function msgPanelLayout()
    {
        ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    //register notification
                    $("#jqxMsg").jqxNotification({
                        width: 400,
                        position: "bottom-right",
                        opacity: 0.6,
                        autoOpen: false,
                        animationOpenDelay: 300,
                        autoClose: true,
                        autoCloseDelay: 4000,
                        template: "info"
                    });
                });
            })(jQuery);
        </script>

        <div id="jqxMsg">
            <span id="jqxMsgContent"></span>
        </div>
    <?php
    }

    private function generateFieldReadOnly($f_name, $value = '')
    {
        ?>

        <td>
            <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>"
                   readonly>
        </td>

    <?php
    }

    private function generateFieldHidden($f_name, $value = '')
    {
        ?>
        <input value="<?= $value ?>" type="hidden" name="<?= $f_name ?>" id="<?= $f_name ?>">
    <?php
    }

    private function generateFieldImage($f_name, $value)
    {
        ?>
        <td>
            <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>">

            <button id="c<?= $f_name ?>" value="">...</button>
            <?php
            Qdmvc_Helper::qd_media_choose("c{$f_name}", $f_name, false);
            ?>
        </td>
    <?php
    }

    private function generateFieldBoolean($f_name, $value = 0)
    {
        ?>
        <td>
            <input <?= $value == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?= $f_name ?>"
                                                                 id="<?= $f_name ?>" value="1">
        </td>
    <?php
    }

    private function generateFields()
    {
        ?>
        <?php
        foreach ($this->page->getLayout() as $group => $config) {
            if (isset($config['Type']) && isset($config['Type']) == 'Group') {
                if (isset($config['Fields'])) {
                    foreach ($config['Fields'] as $key => $f_config) {
                        $type = $f_config['DataType'];
                        $f_name = $f_config['SourceExpr'];
                        $f_val = $this->obj != null ? $this->obj->$f_name : '';
                        $f_lku = $f_config['LookupURL'];

                        if ($f_config['PrimaryKey']) {
                            $this->generateFieldHidden($f_name, $f_val);
                            continue;
                        }

                        ?>
                        <tr>

                            <!-- Caption -->
                            <td><?= $this->page->getFieldCaption($f_name) ?>:</td>
                            <!-- END Caption -->

                            <?php
                            if ($type == 'Boolean') {
                                $this->generateFieldBoolean($f_name, $f_val);
                                continue;
                            }
                            if ($f_config['ReadOnly']) {
                                $this->generateFieldReadOnly($f_name, $f_val);
                                continue;
                            }
                            if ($type == 'Image') {
                                $this->generateFieldImage($f_name, $f_val);
                                continue;
                            }
                            ?>
                            <td>
                                <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>"
                                       value="<?= $f_val ?>">
                                <?php
                                if (isset($f_lku)) {
                                    ?>
                                    <button onclick='requestLookupWindow("<?= $f_lku ?>")' class="qd-lookup-btn"
                                            data-lookupurl="<?= $f_lku ?>" id="c<?= $f_name ?>" value="">...
                                    </button>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                }
            }
        }
    }

    protected function onReadyHook()
    {
        ?>
        <script>
            (function ($) {

                $(document).ready(function () {
                    //add cardBar
                    //$('#jqxNavigationBar').jqxNavigationBar('insert', 0, 'Card', 'Content');
                    //
                });
            })(jQuery);
        </script>
    <?php
    }

    protected function onDeleteOK()
    {

    }

    protected function onCloneOK()
    {

    }

    protected function onNewOK()
    {

    }
    private function getPagePartURL()
    {
        $c = $this->page;
        return $c::getPagePartURL();
    }
    private function linesBar()
    {
        ?>
        <div>
            <div style='margin-top: 2px;'>
                <div style='margin-left: 4px; float: left;'>
                    Lines
                </div>
            </div>
        </div>
        <div>
            <div style="height: 520px; width: 100%">
                <!-- Content Place Holder 2 -->
                <iframe id="pagepart" src="<?= $this->getPagePartURL() ?>"
                        width="100%" height="99%" scrolling="no" frameborder="0">
                    <p>Your browser does not support iframes</p>
                </iframe>
                <!-- ENd Content Place Holder 2 -->
            </div>
        </div>
        <?php
    }
    private function cardBar()
    {
        ?>
        <div>
            <div style='margin-top: 2px;'>
                <div style='margin-left: 4px; float: left;'>
                    Card
                </div>
            </div>
        </div>
        <div>
            <div>
                <script>
                    (function ($) {
                        $(document).ready(function () {
                            //validate trigger
                            $("#cardForm").on("validationSuccess", function (event) {
                                //AJAX progress Bar
                                ajax_loader = new ajaxLoader("#cardForm");
                                //build data
                                var json = form2js("cardForm", ".", false, null, true);//skip empty some time cause lack field
                                //begin lock
                                //$("#update").attr("disabled", "disabled");
                                console.log(json);
                                var action = $("#id").val() > 0 ? "update" : "insert";
                                $.post(data_port, {submit: "submit", action: action, data: json})
                                    .done(function (data) {
                                        //data JSON
                                        console.log(data);
                                        //var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                                        //...
                                        $("#jqxMsgContent").html(data.msg);
                                        $("#jqxMsg").jqxNotification("open");
                                        $("#id").val(data.id).change();

                                        console.log(data.rows[0]);
                                        setObj(data.rows[0]);


                                        <?=$this->onSaveOK()?>
                                    })
                                    .fail(function (data) {
                                        console.log(data);
                                    })
                                    .always(function () {
                                        //release lock
                                        $("#qdupdate").removeAttr("disabled");
                                        ajax_loader.remove();
                                    });
                            });

                            //card form event
                            $("#qdupdate").bind("click", function (event) {
                                $("#cardForm").jqxValidator("validate");
                            });

                            //card button event
                            $("#qdnew").bind("click", function (event) {
                                //To disable
                                try {
                                    $("#qdnew").attr("disabled", "disabled");
                                    document.getElementById("cardForm").reset();
                                    $("#id").val("0").change();
                                    $("#qdnew").removeAttr("disabled");

                                    <?=$this->onNewOK()?>
                                } catch (error) {
                                    console.log(error);
                                }
                            });

                            //card button event
                            $("#qdclone").bind("click", function (event) {
                                //To disable
                                $("#qdclone").attr("disabled", "disabled");
                                $("#id").val("0").change();
                                $("#qdupdate").click();
                                $("#qdclone").removeAttr("disabled");

                                <?=$this->onCloneOK()?>
                            });

                            $("#qddelete").bind("click", function (event) {
                                if (!confirm("Xác nhận ?")) {
                                    return false;
                                }
                                //AJAX loader
                                ajax_loader = new ajaxLoader("#cardForm");
                                //begin lock
                                var id_ = $("#id").val();
                                console.log(id_);
                                $("#qddelete").attr("disabled", "disabled");
                                $.post(data_port, {submit: "submit", action: "delete", data: {id: id_}})
                                    .done(function (data) {
                                        //data JSON
                                        var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format

                                        //....
                                        $("#jqxMsgContent").html(obj.msg);
                                        $("#jqxMsg").jqxNotification("open");

                                        <?=$this->OnDeleteOK()?>
                                    })
                                    .fail(function (data) {
                                        console.log("FAIL:" + data);
                                    })
                                    .always(function () {
                                        //release lock
                                        $("#qddelete").removeAttr("disabled");
                                        ajax_loader.remove();
                                    });
                            });

                            //prevent form enter key
                            $("#cardForm").keypress(function (e) {
                                if (e.which == 13) { // Checks for the enter key
                                    e.preventDefault(); // Stops IE from triggering the button to be clicked

                                    //simulate save click
                                    $("#qdupdate").click();
                                }
                            });
                            //catch submit
                            $(document).on("submit", "#testForm", function () {
                                // code
                                return false;
                            });
                        });
                    })(jQuery);
                </script>
                <form style="width: 100%" id="cardForm" action=""
                  onsubmit="return false">
                <table class="register-table">
                    <!-- Content place Holder -->
                    <?= $this->generateFields() ?>
                    <!-- End content place holder -->
                    <tr>
                        <td colspan="2">

                            <style>
                                .qd-action-btn {
                                    margin-right: 20px;
                                }
                            </style>
                            <br>
                        <span>
                            <button class="qd-action-btn" type="button" id="qdupdate">Save</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="qdnew">New</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="qddelete">Delete</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="qdclone">Clone</button>
                        </span>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
        </div>
    <?php
    }

    protected function onSaveOK()
    {

    }

    protected function Bars()
    {
        $this->cardBar();
    }

    private function Bar()
    {
        ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    //navigation bar
                    $("#jqxNavigationBar").jqxNavigationBar({
                        width: '100%',
                        expandMode: 'multiple',
                        expandedIndexes: [0, 1]
                    });
                });
            })(jQuery);
        </script>

        <div id='jqxWidget'>
            <div id="jqxNavigationBar">
                <?= $this->Bars() ?>
            </div>
        </div>

    <?php
    }

    public function render()
    {
        ?>
        <?= $this->formValidation() ?>
        <?= $this->progressSpinner() ?>
        <?= $this->preConfig() ?>
        <?= $this->internalGateway() ?>
        <?= $this->externalGateway() ?>
        <?= $this->onReadyHook() ?>
        <?= $this->lookupWindowLayout() ?>
        <?= $this->Bar() ?>
        <?= $this->msgPanelLayout() ?>

    <?php
    }
}