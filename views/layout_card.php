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
    public function render($place_holder)
    {
        ?>
        <!-- Content Place Holder 3 -->
        <?=$place_holder->placeHolder3()?>
        <!-- ENd Content Place Holder 3 -->

        <script type="text/javascript">
            //update grid
            function updateGrid() {
                document.getElementById('list').contentWindow.updateGrid();
            }
            (function ($) {
                $(document).ready(function () {
                    //card form event
                    $('#update').bind('click', function (event) {
                        //alert('Button is Clicked');
                        //var x = $("#testForm").serializeArray();
                        var json = form2js('testForm', '.', false, null, true);//skip empty some time cause lack field
                        //begin lock
                        $('#update').attr('disabled', 'disabled');
                        $.post(data_port, {submit: "submit", action: "update", data: json})
                            .done(function (data) {
                                //data JSON
                                var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                                updateGrid();
                                //...
                                $("#jqxMsgContent").html(obj.msg);
                                $("#jqxMsg").jqxNotification("open");
                                $("#id").val(obj.id);
                            })
                            .fail(function () {
                                alert("error");
                            })
                            .always(function () {
                                //release lock
                                $('#update').removeAttr('disabled');
                            });
                    });
                    //card button event
                    $('#new').bind('click', function (event) {
                        //To disable
                        $('#new').attr('disabled', 'disabled');
                        $('#testForm')[0].reset();
                        $('#id').val("0");
                        $('#new').removeAttr('disabled');
                    });
                    //card button event
                    $('#clone').bind('click', function (event) {
                        //To disable
                        $('#clone').attr('disabled', 'disabled');
                        $('#id').val("0");
                        $('#update').click();
                        updateGrid();
                        $('#clone').removeAttr('disabled');
                    });
                    $('#delete').bind('click', function (event) {

                        if (!confirm("Xác nhận ?")) {
                            return false;
                        }
                        //begin lock
                        var id = $("#id").val();
                        $('#delete').attr('disabled', 'disabled');
                        $.post(data_port, {submit: "submit", action: "delete", data: {id: id}})
                            .done(function (data) {
                                //data JSON
                                var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                                //call back to grid to updata data
                                updateGrid();
                                //....
                                $("#jqxMsgContent").html(obj.msg);
                                $("#jqxMsg").jqxNotification("open");
                            })
                            .fail(function () {
                                alert("error");
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
                });
            })(jQuery);
        </script>
        <script>
            (function ($) {
                $(document).ready(function () {
                    // Create jqxNavigationBar.
                    $("#jqxNavigationBar").jqxNavigationBar({
                        width: 820,
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
                    <form style="width: 100%" id="testForm" action="" onsubmit="return false">
                        <table class="register-table">
                        <!-- Content place Holder -->
                        <?=$place_holder->placeHolder1()?>
                        <!-- End content place holder -->
                        <tr>
                        <td colspan="3">
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
                    <!-- Content Place Holder 2 -->
                    <?=$place_holder->placeHolder2()?>
                    <!-- ENd Content Place Holder 2 -->
                </div>
            </div>
        </div>

    <?php
    }
}