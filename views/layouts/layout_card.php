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
    protected $data = null;
    protected function placeHolder1()
    {

    }
    protected function placeHolder2()
    {

    }
    protected function placeHolder3()
    {

    }
    public function render()
    {
        ?>
        <!-- Content Place Holder 3 -->
        <?= $this->placeHolder3() ?>
        <!-- ENd Content Place Holder 3 -->
        <script>
            //gate way to comunicate with parent windows
            function setObj(obj) {//do not change func name
                (function ($) {
                    $("#testForm").autofill(obj);
                    $("#testForm input").change();
                    //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                })(jQuery);
            };
            //gate way to comunicate with parent windows
            function doubleClickObj(obj) {//do not change func name
                (function ($) {
                    $('#jqxNavigationBar').jqxNavigationBar('expandAt', 0);
                })(jQuery);
            };
            function requestLookupWindow(src) {
                //set window iframe source
                //alert(src);
                (function ($) {
                    $('#windowFrame').attr('src', src);
                    $('#window').jqxWindow('open');
                })(jQuery);

            }
            ;
            function requestFormValidate(rules_) {
                (function ($) {
                    //register validate
                    $('#testForm').jqxValidator({
                        rules: rules_
                    });
                })(jQuery);
            }
        </script>
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
        <script type="text/javascript">
            function setLookupResult(value, txtId) {
                (function ($) {
                    //alert(txtId);
                    $("#" + txtId).val(value).change();
                })(jQuery);
            }
            ;
            //update grid
            function updateGrid() {
                try {
                    document.getElementById('list').contentWindow.updateGrid();
                }catch(error)
                {
                    console.log(error);
                }
            }
            (function ($) {
                $(document).ready(function () {
                    //init window for lookup
                    $('#window').jqxWindow({
                        showCollapseButton: false,
                        maxHeight: 400,
                        maxWidth: 800,
                        minHeight: 200,
                        minWidth: 200,
                        height: 350,
                        width: 600,
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
                            $('#testForm')[0].reset();
                            $('#id').val("0").change();
                            $('#new').removeAttr('disabled');
                        }catch(error)
                        {
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
                });
            })(jQuery);
        </script>
        <script>
            (function ($) {
                $(document).ready(function () {

                    //dokcing
                    //$('#docking').jqxDocking({orientation: 'vertical', width: 900, height: 100, mode: 'docked'});
                    //$('#docking').jqxDocking('disableWindowResize', 'widget1');
                    //$('#docking').jqxDocking('hideAllCloseButtons');
                    // Create jqxNavigationBar.
                    $("#jqxNavigationBar").jqxNavigationBar({
                        width: '100%',
                        expandMode: 'multiple',
                        expandedIndexes: [0, 1]
                    });
                });
            })(jQuery);
        </script>
        <div id="jqxMsg">
            <span id="jqxMsgContent"></span>
        </div>
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
                    <form style="width: 100%" id="testForm" action=""
                          onsubmit="return false">
                        <table class="register-table">
                            <!-- Content place Holder -->
                            <?= $this->placeHolder1() ?>
                            <!-- End content place holder -->
                            <tr>
                                <td colspan="2">
                        <span>
                            <button type="button" id="update">Save</button>---
                        </span>
                        <span>
                            <button type="button" id="new">New</button>---
                        </span>
                        <span>
                            <button type="button" id="delete">Delete</button>---
                        </span>
                        <span>
                            <button type="button" id="clone">Clone</button>
                        </span>
                                </td>
                            </tr>
                        </table>
                    </form>
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
                        <iframe id="list" src="<?= $this->placeHolder2() ?>"
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
}