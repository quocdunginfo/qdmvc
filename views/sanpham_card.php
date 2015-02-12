<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
?>
<script type="text/javascript">
    //gate way to comunicate with parent windows
    function setObj(obj) {
        formObj.id = obj.id;
        formObj.name = obj.name;
        formObj.avatar = obj.avatar;
        formObj.parent_id = obj.parent_id;
    };
    var formObj = {name: "default", id: "0", parent_id: "0", avatar: "/"};


    (function ($) {

        $(document).ready(function () {
            // prepare the data
            var data_port = '<?=$data['data_port']?>';
            //register Watcher for the object
            watch(formObj, function () {
                $("#id").val(formObj.id);
                $("#name").val(formObj.name);
                $("#avatar").val(formObj.avatar);
                $("#parent_id").val(formObj.parent_id);
            });




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
                        //update grid
                        parent.updateGrid();
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
                $('#clone').removeAttr('disabled');
                $('#update').click();
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
                width: 400, position: "top-right", opacity: 0.6,
                autoOpen: false, animationOpenDelay: 300, autoClose: true, autoCloseDelay: 4000, template: "info"
            });
        });
    })(jQuery);
</script>
<div id="jqxMsg">
    <span id="jqxMsgContent"></span>
</div>
<div id='jqxWidget'>
    <div>
        <form style="width: 100%" id="testForm" action="" onsubmit="return false">
            <table class="register-table">
                <tr>
                    <td>Name:</td>
                    <td>
                        <input type="hidden" id="id" name="id" value="0">
                        <input type="text" id="name" name="name" class="text-input"/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Avatar:</td>
                    <td>
                        <input size="70" type="text" id="avatar" name="avatar" class="text-input"/>
                        <button id="cavatar" value="...">...</button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Parent ID:</td>
                    <td><input type="text" id="parent_id" name="parent_id" class="text-input"/></td>
                </tr>
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
</div>