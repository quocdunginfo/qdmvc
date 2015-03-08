<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
class Qdmvc_Layout_Card
{
    function __construct($page)
    {
        $this->page = $page;
        $this->data = $page->getData();
    }

    protected $page = null;
    protected $data = null;

    protected function getPageListURL()
    {
        $c = $this->page;
        if ($c::getPageList() != '') {
            return Qdmvc_Helper::getCompactPageListLink($c::getPageList());
        }
    }

    protected function generateFieldReadOnly($f_name, $value = '')
    {
        ?>
        <td>
            <input class="text-input" type="text" name="<?= $f_name ?>" id="<?= $f_name ?>" value="<?= $value ?>"
                   readonly>
        </td>
    <?php
    }

    protected function generateFieldHidden($f_name, $value = '')
    {
        ?>
        <input value="<?= $value ?>" type="hidden" name="<?= $f_name ?>" id="<?= $f_name ?>">
    <?php
    }

    protected function generateFieldImage($f_name, $value)
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

    protected function generateFieldBoolean($f_name, $value = 0)
    {
        ?>
        <td>
            <input <?= $value == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?= $f_name ?>"
                                                                 id="<?= $f_name ?>" value="1">
        </td>
    <?php
    }

    protected function generateFields()
    {
        ?>
        <?php
        foreach ($this->page->getLayout() as $group => $config) {
            if (isset($config['Type']) && isset($config['Type']) == 'Group') {
                if (isset($config['Fields'])) {
                    foreach ($config['Fields'] as $key => $f_config) {
                        $type = $f_config['DataType'];
                        $f_name = $f_config['SourceExpr'];
                        $f_val = $this->data['obj']->$f_name;
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

    protected function internalGateway()
    {
        ?>
        <script>
            function requestLookupWindow(src) {
                //set window iframe source
                //alert(src);
                (function ($) {
                    $('#windowFrame').attr('src', src);
                    $('#window').jqxWindow('open');
                })(jQuery);
            }
            function requestFormValidate(rules_) {
                (function ($) {
                    //register validate
                    $('#testForm').jqxValidator({
                        rules: rules_
                    });
                })(jQuery);
            }
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
    }

    protected function externalGateway()
    {
        ?>
        <script>
            //gate way to comunicate with parent windows
            function setObj(obj) {//do not change func name
                (function ($) {
                    $("#testForm").autofill(obj);
                    $("#testForm input").change();
                    //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                })(jQuery);
            }
            //gate way to comunicate with parent windows
            function doubleClickObj(obj) {//do not change func name
                (function ($) {
                    $('#jqxNavigationBar').jqxNavigationBar('expandAt', 0);
                })(jQuery);
            }
            function setLookupResult(value, txtId) {
                (function ($) {
                    $("#" + txtId).val(value).change();
                })(jQuery);
            }
        </script>
    <?php
    }

    protected function msgPanelLayout()
    {
        ?>
        <div id="jqxMsg">
            <span id="jqxMsgContent"></span>
        </div>
    <?php
    }

    protected function lookupWindowLayout()
    {
        ?>
        <div id="window">
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

    protected function onReadyHook()
    {
        ?>
        <script type="text/javascript">

            (function ($) {
                $(document).ready(function () {
                    //init window for lookup
                    $('#window').jqxWindow({
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

                    //validate trigger
                    $('#testForm').on('validationSuccess', function (event) {

                        var json = form2js('testForm', '.', false, null, true);//skip empty some time cause lack field
                        //begin lock
                        //$('#update').attr('disabled', 'disabled');
                        console.log(json);
                        var action = $("#id").val() > 0 ? "update" : "insert";
                        $.post(data_port, {submit: "submit", action: action, data: json})
                            .done(function (data) {
                                //data JSON
                                console.log(data);
                                //var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                                updateGrid();
                                //...
                                $("#jqxMsgContent").html(data.msg);
                                $("#jqxMsg").jqxNotification("open");
                                $("#id").val(data.id).change();
                            })
                            .fail(function (data) {
                                console.log(data);
                            })
                            .always(function () {
                                //release lock
                                $('#update').removeAttr('disabled');
                            });

                    });
                    //card form event
                    $('#update').bind('click', function (event) {
                        $('#testForm').jqxValidator('validate');
                    });
                    //card button event
                    $('#new').bind('click', function (event) {
                        //To disable
                        try {
                            $('#new').attr('disabled', 'disabled');
                            document.getElementById("testForm").reset();
                            $('#id').val("0").change();
                            $('#new').removeAttr('disabled');
                        } catch (error) {
                            console.log(error);
                        }
                    });
                    //card button event
                    $('#clone').bind('click', function (event) {
                        //To disable
                        $('#clone').attr('disabled', 'disabled');
                        $('#id').val("0").change();
                        $('#update').click();
                        $('#clone').removeAttr('disabled');
                    });
                    $('#delete').bind('click', function (event) {

                        if (!confirm("Xác nhận ?")) {
                            return false;
                        }
                        //begin lock
                        var id_ = $("#id").val();
                        console.log(id_);
                        $('#delete').attr('disabled', 'disabled');
                        $.post(data_port, {submit: "submit", action: "delete", data: {id: id_}})
                            .done(function (data) {
                                //data JSON
                                var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                                //call back to grid to updata data
                                updateGrid();
                                //....
                                $("#jqxMsgContent").html(obj.msg);
                                $("#jqxMsg").jqxNotification("open");
                            })
                            .fail(function (data) {
                                console.log("FAIL:" + data);
                            })
                            .always(function () {
                                //release lock
                                $('#delete').removeAttr('disabled');
                            });
                    });
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
                    //prevent form enter key
                    $('#testForm').keypress(function (e) {
                        if (e.which == 13) { // Checks for the enter key
                            e.preventDefault(); // Stops IE from triggering the button to be clicked

                            //simulate save click
                            $("#update").click();
                        }
                    });
                    //catch submit
                    $(document).on('submit', '#testForm', function () {
                        // code
                        //$("#update").click();
                        return false;
                    });
                    //navigation bar
                    $("#jqxNavigationBar").jqxNavigationBar({
                        width: '100%',
                        expandMode: 'multiple',
                        expandedIndexes: [0, 1]
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
        </script>
    <?php
    }

    protected function bindingField()
    {

    }

    protected function formValidation()
    {

    }

    protected function navigationBar()
    {
        ?>
        <div id='jqxWidget'>
            <div id="jqxNavigationBar">
                <div>
                    <div style='margin-top: 2px;'>
                        <div style='margin-left: 4px; float: left;'>
                            Card
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <form style="width: 100%" id="testForm" action=""
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
                            <button class="qd-action-btn" type="button" id="update">Save</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="new">New</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="delete">Delete</button>
                        </span>
                        <span>
                            <button class="qd-action-btn" type="button" id="clone">Clone</button>
                        </span>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div>
                    <div style='margin-top: 2px;'>
                        <div style='margin-left: 4px; float: left;'>
                            List
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
            </div>
        </div>
    <?php
    }

    public function render()
    {
        ?>
        <?= $this->preConfig() ?>

        <?= $this->internalGateway() ?>
        <?= $this->externalGateway() ?>

        <?= $this->lookupWindowLayout() ?>
        <?= $this->bindingField() ?>

        <?= $this->navigationBar() ?>
        <?= $this->formValidation() ?>

        <?= $this->msgPanelLayout() ?>

        <?= $this->onReadyHook() ?>
    <?php
    }
}