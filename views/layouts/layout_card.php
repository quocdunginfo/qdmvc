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
            var formValidation = {};
            function formValidationError() {
                for (i in formValidation) {
                    if (formValidation[i].type == 'error') {
                        return true;
                    }
                }
                return false;
            }
            function clearFormValidationMark() {
                (function ($) {
                    //clear form validation mark and tooltip
                    var $inputs = $("#cardForm :input[type=text]");
                    $inputs.each(function () {
                        $(this).css('border-color', '#ddd');//set to boootstrap default
                        try {
                            $(this).jqxTooltip('destroy');//{ content: '', position: 'bottom', name: ''});
                        } catch (error) {
                            console.log(error);
                        }
                    });

                })(jQuery);
            }
            function showMsg(msg) {
                (function ($) {
                    //clear notification
                    $('#jqxMsg').jqxNotification('closeAll');
                    //dis[lay new validation mark and msg bus

                    for (key in msg) {
                        var type = msg[key].type;
                        var template = type == '' ? 'success' : type;

                        if (msg[key].field != null && msg[key].field != '') {
                            var field = $("#cardForm input[name='" + msg[key].field + "']");
                            field.jqxTooltip({content: msg[key].msg, position: 'bottom', name: msg[key].field});

                            if (type == 'error') {
                                field.css('border-color', 'red');
                            }
                            else if (type == 'warning') {
                                field.css('border-color', 'orange');
                            }
                            else if (type == 'info') {
                                field.css('border-color', 'blue');
                            }
                        }

                        $('#jqxMsg').jqxNotification({template: template});
                        $("#jqxMsgContent").html(msg[key].msg);
                        $("#jqxMsg").jqxNotification("open");
                    }
                    /*
                     for (i = 0; i < msg.length; i++) {

                     }*/
                })(jQuery);
            }
        </script>
        <script>
            function requestLookupWindow(src) {
                //set window iframe source
                //alert(src);
                (function ($) {
                    $("#windowFrame").contents().find("body").html('');//do a trick to hide previous result
                    $('#windowFrame').attr('src', src);
                    $('#jqxlookupwin').jqxWindow('open');
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
            function ajaxLoader(el, options) {
                // Becomes this.options
                var defaults = {
                    bgColor: '#fff',
                    duration: 800,
                    opacity: 0.7,
                    classOveride: false
                }
                this.options = jQuery.extend(defaults, options);
                this.container = jQuery(el);

                this.init = function () {
                    var container = this.container;
                    // Delete any other loaders
                    this.remove();
                    // Create the overlay
                    var overlay = jQuery('<div></div>').css({
                        'background-color': this.options.bgColor,
                        'opacity': this.options.opacity,
                        'width': container.width(),
                        'height': container.height(),
                        'position': 'absolute',
                        'top': '0px',
                        'left': '0px',
                        'z-index': 99999
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

                this.remove = function () {
                    var overlay = this.container.children(".ajax_overlay");
                    if (overlay.length) {
                        overlay.fadeOut(this.options.classOveride, function () {
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
            var current_obj = null;
            var init_obj = <?=$this->data['init_obj']?>;
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
                    $('#jqxlookupwin').jqxWindow({
                        showCollapseButton: true,
                        maxHeight: 9999,
                        maxWidth: 9999,
                        minHeight: 200,
                        minWidth: 200,
                        height: '99%',
                        width: '99%',
                        autoOpen: false,
                        isModal: true,
                        initContent: function () {
                            //$('#tab').jqxTabs({ height: '100%', width:  '100%' });
                            //$('#window').jqxWindow('focus');
                        }
                    });

                    //init window for editor
                    $('#jqxwptexteditor').jqxWindow({
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

        <div id="jqxlookupwin">
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
        <div id="jqxwptexteditor">
            <div id="windowHeader">
                    <span>
                        WYSIWYG Editor Window
                    </span>
            </div>
            <div style="overflow: hidden;" id="wptexteditor_wrapper">
                <div>
                    <button type="button" id="wptexteditor_done">Done</button>
                </div>
                <?php wp_editor('', 'wptexteditor', $settings = array()); ?>
                <script>
                    var wptexteditor_returnid = 'notset';
                    (function ($) {
                        $(document).ready(function () {
                            $('#wptexteditor_done').click(function () {
                                var content = tinyMCE.get('wptexteditor').getContent();
                                $('#' + wptexteditor_returnid).val(content);
                                //close editor
                                $('#jqxwptexteditor').jqxWindow('close');
                            });
                        });
                    })(jQuery);
                    function requestEditorWindow(initVal, returnId) {
                        (function ($) {
                            wptexteditor_returnid = returnId;
                            console.log('WYSIWYG opened, returnId: ' + wptexteditor_returnid);
                            $('#jqxwptexteditor').jqxWindow('open');

                            tinyMCE.get('wptexteditor').setContent(initVal);
                        })(jQuery);
                    }
                </script>
            </div>
        </div>
    <?php
    }

    protected function externalGateway()
    {
        ?>
        <script>
            function getObj()
            {
                return current_obj;
            }
            //gate way to comunicate with parent windows
            function setObj(obj) {//do not change func name
                (function ($) {
                    //clear form validation mark but not error msg
                    clearFormValidationMark();
                    current_obj = obj;
                    //fill data
                    $("#cardForm").autofill(obj);
                    $("#cardForm input").change();
                    //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                    console.log('layout_cardnavigate -> setObj: ');console.log(obj);
                })(jQuery);
            }
            function setLookupResult(value, txtId) {
                (function ($) {
                    $("#" + txtId).val(value).change();
                    //auto close window
                    $('#jqxlookupwin').jqxWindow('close');
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
                        opacity: 0.9,
                        autoOpen: false,
                        animationOpenDelay: 300,
                        autoClose: true,
                        autoCloseDelay: 3000,
                        template: "info",
                        appendContainer: "#jqxMsgContainer"
                    });
                });
            })(jQuery);
        </script>

        <div id="jqxMsg">
            <span id="jqxMsgContent"></span>
        </div>
        <div style="position: fixed; bottom: 0px; right: 0px;">
            <div id="jqxMsgContainer">

            </div>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        //register notification
                        //card button event
                        $("#qdmsgclear").bind("click", function (event) {
                            $('#jqxMsg').jqxNotification('closeAll');
                        });
                    });
                })(jQuery);
            </script>
            <button style="opacity: 0.8;" id="qdmsgclear" class="btn btn-info pull-right">MSG</button>
            <!-- Single button -->
            <div class="btn-group dropup pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    Help <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" id="tourPageCardNewRecord">New record ?</a></li>
                    <li class="divider"></li>
                </ul>
            </div>
            <div style="clear: both"></div>
        </div>
    <?php
    }

    private function generateFieldReadOnly($f_name, $value = '')
    {
        ?>


        <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>"
               readonly>


    <?php
    }

    private function generateFieldLookup($f_name, $f_val, $f_lku)
    {
        ?>
        <div class="qd-lookup-input">
            <input class="text-input" type="text" name="<?= $f_name ?>"
                   id="<?= $f_name ?>"
                   value="<?= $f_val ?>">
            <button onclick='requestLookupWindow("<?= $f_lku ?>")'
                    data-lookupurl="<?= $f_lku ?>" id="c<?= $f_name ?>"
                    value="">...
            </button>
        </div>
    <?php
    }

    private function generateFieldDate($f_name, $value)
    {
        ?>

        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    // Create a jqxDateTimeInput
                    $("#jqxDT").jqxDateTimeInput({width: '120px', height: '24px'});
                });
            })(jQuery);
        </script>
        <div id='jqxDT'></div>

    <?php
    }

    private function generateFieldHidden($f_name, $value)
    {
        ?>
        <input value="<?= $value ?>" type="hidden" name="<?= $f_name ?>" id="<?= $f_name ?>">
    <?php
    }

    private function generateFieldCombobox($f_name, $value, $options)
    {
        ?>
        <select name="<?= $f_name ?>" id="<?= $f_name ?>">
            <?php foreach ($options as $key=>$caption): ?>
                <option value="<?=$key ?>" <?=$value==$key?'selected':''?>><?= $caption ?></option>
            <?php endforeach; ?>
        </select>
    <?php
    }

    private function generateFieldImage($f_name, $value)
    {
        ?>
        <div class="qd-lookup-input">
            <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>">

            <button id="c<?= $f_name ?>" value="">...</button>
            <?php
            Qdmvc_Helper::qd_media_choose("c{$f_name}", $f_name, false);
            ?>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        $("#<?=$f_name?>").hover(function () {
                            var imgURL = $(this).val();
                            if (imgURL != "") {
                                var content = '<img style="width: 300px;" src="' + imgURL + '" />';
                                var selector = $("#<?=$f_name?>");
                                selector.jqxTooltip({content: content, position: 'bottom', opacity: 0.8});
                                selector.jqxTooltip('open');
                            }
                        });
                    });
                })(jQuery);
            </script>
        </div>

    <?php
    }

    private function generateFieldBoolean($f_name, $value = 0)
    {
        ?>
        <input <?= $value == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?= $f_name ?>"
                                                             id="<?= $f_name ?>" value="1">
    <?php
    }

    private function generateFieldWYSIWYG($f_name, $value = 0)
    {
        ?>
        <div class="qd-lookup-input">
            <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>">

            <button id="e<?= $f_name ?>" value="">...</button>

            <script>
                (function ($) {
                    $(document).ready(function () {
                        $("#e<?=$f_name?>").click(function () {
                            requestEditorWindow($('#<?=$f_name?>').val(), '<?=$f_name?>');
                        });
                    });
                })(jQuery);
            </script>
        </div>
    <?php
    }

    private function generateFields()
    {
        ?>
        <style>
            .qd-card-grid .col-md-6 {
                /*height: 30px;*/
                margin-bottom: 7px;
            }

            .qd-card-grid .qd-field-caption {
                height: 100%;
                width: 40%;
            }

            .qd-card-grid input[type=text] {
                display: block;
                width: 250px;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }

            .qd-lookup-input {
                position: relative;
            }

            .qd-lookup-input input {
                padding-right: 35px;
            }

            .qd-lookup-input button {
                position: absolute;
                top: 0;
                right: 0;
            }
        </style>
        <div class="container qd-card-grid" style="width: 100%">
            <div class="row clearfix">
                <?php
                foreach ($this->page->getLayout() as $group => $config) :
                    if (isset($config['Type']) && $config['Type'] == 'Group') :
                        if (isset($config['Fields'])) :

                            foreach ($config['Fields'] as $key => $f_config) :
                                $type = $f_config['DataType'];
                                $f_name = $f_config['SourceExpr'];
                                if($type=='Option')
                                {
                                    $options = $this->page->getFieldOptions($f_name, $this->data['language']);
                                }
                                $f_val = $this->obj != null ? $this->obj->$f_name : '';
                                $f_lku = $f_config['LookupURL'];

                                if ($f_config['PrimaryKey']) {
                                    $this->generateFieldHidden($f_name, $f_val);
                                    continue;
                                }

                                ?>
                                <div class="col-md-6">

                                    <!-- Caption -->
                                    <div
                                        class="qd-field-caption pull-left"><?= $this->page->getFieldCaption($f_name, $this->data['language']) ?>
                                        :
                                    </div>
                                    <!-- END Caption -->
                                    <div class="pull-right">
                                        <?php
                                        if ($type == 'Boolean') {
                                            $this->generateFieldBoolean($f_name, $f_val);
                                        } else
                                            if ($f_config['ReadOnly']) {
                                                $this->generateFieldReadOnly($f_name, $f_val);
                                            } else
                                                if ($type == 'Image') {
                                                    $this->generateFieldImage($f_name, $f_val);
                                                } else
                                                    if ($type == 'Date') {
                                                        $this->generateFieldDate($f_name, $f_val);
                                                    } else
                                                        if ($type == 'WYSIWYG') {
                                                            $this->generateFieldWYSIWYG($f_name, $f_val);
                                                        } else
                                                            if ($type == 'Option') {
                                                                $this->generateFieldCombobox($f_name, $f_val, $options);
                                                            } else
                                                                if (isset($f_lku)) {
                                                                    $this->generateFieldLookup($f_name, $f_val, $f_lku);
                                                                } else {
                                                                    ?>
                                                                    <input class="text-input" type="text"
                                                                           name="<?= $f_name ?>"
                                                                           id="<?= $f_name ?>"
                                                                           value="<?= $f_val ?>">
                                                                <?php
                                                                }
                                        ?>
                                    </div>

                                    <div style="clear: both"></div>

                                </div>
                            <?php
                            endforeach;
                        endif;
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    <?php
    }

    protected function onReadyHook()
    {
        ?>
        <script>
            (function ($) {

                $(document).ready(function () {
                    //add cardBar
                    //$('#jqxNavigationBar').jqxNavigationBar('insert', 0, 'Card', 'Content');
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
                                var action = $("#id").val() != 0 ? "update" : "insert";
                                var postdata = {submit: "submit", action: action, data: json};
                                console.log(postdata);
                                $.post(data_port, postdata)
                                    .done(function (data) {
                                        //data JSON
                                        console.log(data);
                                        //var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format

                                        $("#id").val(data.id).change();

                                        console.log(data.rows[0]);

                                        clearFormValidationMark();
                                        setObj(data.rows[0]);

                                        formValidation = data.msg;
                                        showMsg(data.msg);//must be called after setObj(...)

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
                                    //set init obj
                                    setObj(init_obj);
                                    //force set id = 0
                                    $("#id").val("0").change();
                                    $("#qdnew").removeAttr("disabled");

                                    <?=$this->onNewOK()?>
                                } catch (error) {
                                    console.log(error);
                                }
                            });

                            //card button event
                            $("#qdclone").bind("click", function (event) {
                                if (!confirm("Xác nhận ?")) {
                                    return false;
                                }
                                //To disable
                                $("#qdclone").attr("disabled", "disabled");
                                $("#id").val("0").change();
                                $("#qdupdate").click();
                                $("#qdclone").removeAttr("disabled");

                                <?=$this->onCloneOK()?>
                            });

                            //card button event
                            $("#qdnote").bind("click", function (event) {
                                //To disable
                                $("#qdnote").attr("disabled", "disabled");
                                requestLookupWindow(getObj()['__sys_note_url']);
                                //alert('Module is under constructing...');

                                $("#qdnote").removeAttr("disabled");
                            });
                            $("#qdimage").bind("click", function (event) {
                                //To disable
                                $("#qdimage").attr("disabled", "disabled");
                                requestLookupWindow(getObj()['__sys_image_url']);
                                //alert('Module is under constructing...');

                                $("#qdimage").removeAttr("disabled");
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
                                        //var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format

                                        //....
                                        showMsg(data.msg);

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
                    <div>
                        <!-- Content place Holder -->
                        <?= $this->generateFields() ?>
                        <!-- End content place holder -->
                        <div>

                            <style>
                                .qd-action-btn {
                                    margin-right: 20px;
                                }
                            </style>
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
                            <span>
                                <button class="qd-action-btn" type="button" id="qdnote">Notes</button>
                            </span>
                            <span>
                                <button class="qd-action-btn" type="button" id="qdimage">Images</button>
                            </span>
                        </div>
                    </div>
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
        //render Page Part from Page Setup
        foreach ($this->page->getLayout() as $group => $config) :
            if (isset($config['Type']) && $config['Type'] == 'Part'):
                ?>
                <div>
                    <div style='margin-top: 2px;'>
                        <div style='margin-left: 4px; float: left;'>
                            Part
                        </div>
                    </div>
                </div>
                <div>
                    <div style="height: 520px; width: 100%">
                        <iframe id="pagePart_<?= $group ?>" src="<?= $this->page->getPagePartURL() ?>" frameborder="0"
                                marginwidth="0" marginheight="0" scrolling="auto"
                                width="100%" height="100%">
                            <p>Your browser does not support iframes</p>
                        </iframe>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
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
                        expandedIndexes: [0, 1, 2]
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

    protected function style()
    {
        //var_dump($this->data);
        if ($this->data['view_style'] == 'compact') {
            Qdmvc_Helper::requestCompact();
        }
        ?>
        <style>
            #wpfooter {
                display: none;
            }
        </style>
    <?php
    }

    protected function getHelpTourPipes()
    {
        return array(
            '#tourPageCardNewRecord' => array(
                '#qdnew' => 20,
                '#cardForm' => 40,
                '#qdupdate' => 60,
            ),
        );
    }

    protected function getHelpTourNodes()
    {
        //range 1 => 2999
        return array(
            20 => array(
                'Caption' => array(
                    'en' => 'Create new record for input (but NOT saved yet)',
                    'vn' => 'Tạo mới một record để nhập liệu (tuy nhiên KHÔNG lưu)'
                )
            ),
            40 => array(
                'Caption' => array(
                    'en' => 'Input record property',
                    'vn' => 'Nhập liệu cho từng thuộc tính'
                )
            ),
            60 => array(
                'Caption' => array(
                    'en' => 'Press Save button',
                    'vn' => 'Click nút lưu'
                )
            ),
            80 => array(
                'Caption' => array(
                    'en' => 'Focus on this area to see new added record',
                    'vn' => 'Quan sát ở đây để thấy record mới thêm'
                )
            ),
            100 => array(
                'Caption' => array(
                    'en' => 'Notification area, validation msg will raise beside here, click to clear msgs',
                    'vn' => 'Khi lưu, các thông báo lỗi (nếu có) sẽ xuất hiện ở đây'
                )
            ),
            101 => array(
                'Caption' => array(
                    'en' => 'Validation also marked on each field which cause error',
                    'vn' => 'Đồng thời cũng sẽ đánh dấu trên Form các Field gây lỗi (màu viền: đỏ (lỗi), vàng (cảnh báo), xanh(dữ liệu tự động gán),...)'
                )
            )
        );
    }

    protected function helpTour()
    {
        ?>
        <script>
            function ClearHelpTourMetaData() {
                (function ($) {
                    <?php
                    foreach($this->getHelpTourPipes() as $triggerBtn=>$nodeIds)
                    {
                        foreach($nodeIds as $nodeId=>$priority)
                        {
                        ?>
                    $('<?=$nodeId?>').removeAttr('data-intro');
                    $('<?=$nodeId?>').removeAttr('data-step');
                    <?php
                    }
                }
                ?>
                })(jQuery);
            }
            function HelpTourSetMetaData(elementId, intro, priority) {
                (function ($) {
                    $(elementId).attr('data-intro', intro);
                    $(elementId).attr('data-step', priority);
                })(jQuery);

            }
            (function ($) {
                $(document).ready(function () {
                    <?php foreach($this->getHelpTourPipes() as $tourPipe=>$mapping): ?>
                    $('<?=$tourPipe?>').click(function () {
                        //clear all node data-mark before start new Tour !!!!!!
                        //...https://github.com/usablica/intro.js/blob/master/example/programmatic/index.html
                        ClearHelpTourMetaData();
                        <?php
                            $count=1;
                            foreach($mapping as $elementId=>$nodeNo):
                            $tmp = $this->getHelpTourNodes();
                            $intro = $tmp[$nodeNo]['Caption']['vn'];
                            $priority = $count;
                            ?>
                        HelpTourSetMetaData('<?=$elementId?>', '<?=$intro?>', <?=$priority?>);
                        <?php
                        $count++;
                        endforeach;
                        ?>
                        introJs().start();
                    });
                    <?php endforeach; ?>
                });
            })(jQuery);
        </script>
    <?php
    }

    public function render()
    {
        ?>
        <?= $this->style() ?>
        <?= $this->helpTour() ?>

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