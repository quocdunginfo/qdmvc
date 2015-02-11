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
    (function ($) {

        $(document).ready(function () {
            var formObj = {name: "mac dinh", id: "0", parent_id: "0", avatar: "/"};
            //defining a 'watcher' for the object

            watch(formObj, function () {
                $("#id").val(formObj.id);
                $("#name").val(formObj.name);
                $("#avatar").val(formObj.avatar);
                $("#parent_id").val(formObj.parent_id);
            });
            /*
             $("#testForm").my({ui:{
             "#id": "id",
             "#name": "name",
             "#avatar": "avatar",
             "#parent_id": "parent_id"
             }}, formObj);*/


            // prepare the data
            var data_port = 'http://localhost/mpd_2015/?qd-api=sanpham_port';

            var theme = 'classic';

            var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'name'},
                    {name: 'avatar'},
                    {name: 'parent_id'}
                ],
                url: data_port,
                root: 'Rows',
                beforeprocessing: function (data) {
                    source.totalrecords = data.Total;
                }
            };

            var dataadapter = new $.jqx.dataAdapter(source);

            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
                {
                    width: 800,
                    source: dataadapter,
                    theme: theme,
                    autoheight: true,
                    pageable: true,
                    showfilterrow: true,
                    filterable: true,
                    showgroupsheader: true,
                    groupable: true,
                    virtualmode: true,
                    columnsresize: true,
                    rendergridrows: function () {
                        return dataadapter.records;
                    },
                    columns: [
                        {text: 'ID', datafield: 'id', columntype: 'textbox', filtertype: 'input', width: 50},
                        {text: 'Name', datafield: 'name', columntype: 'textbox', filtertype: 'input', width: 250},
                        {text: 'Avatar', datafield: 'avatar', columntype: 'textbox', filtertype: 'input', width: 250},
                        {text: 'Parent id', datafield: 'parent_id', columntype: 'textbox', filtertype: 'input'}
                    ]
                });

            //event
            $("#jqxgrid").on("filter", function (event) {
                $('#jqxgrid').jqxGrid('updatebounddata');//refresh grid when typing in filter box
            });
            $('#jqxgrid').on('rowselect', function (event) {
                // event arguments.
                var args = event.args;
                // row's bound index.
                //var rowBoundIndex = args.rowindex;
                // row's data. The row's data object or null(when all rows are being selected or unselected with a single action). If you have a datafield called "firstName", to access the row's firstName, use var firstName = rowData.firstName;
                //formObj = args.row;
                formObj.id = args.row.id;
                formObj.name = args.row.name;
                formObj.avatar = args.row.avatar;
                formObj.parent_id = args.row.parent_id;
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
                        $('#jqxgrid').jqxGrid('updatebounddata');
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
            //card form event
            $('#new').bind('click', function (event) {
                //To disable
                $('#new').attr('disabled', 'disabled');
                $('#testForm')[0].reset();
                $('#id').val("0");
                $('#new').removeAttr('disabled');
            });
            $('#delete').bind('click', function (event) {

                if (!confirm("Xác nhận ?")) {
                    return false;
                }
                //alert('Button is Clicked');
                //var x = $("#testForm").serializeArray();
                //var json = form2js('testForm', '.', false, null,true);//skip empty some time cause lack field
                //begin lock
                var id = $("#id").val();
                $('#delete').attr('disabled', 'disabled');
                $.post(data_port, {submit: "submit", action: "delete", data: {id: id}})
                    .done(function (data) {
                        //data JSON
                        var obj = data;//"ok";//jQuery.parseJSON( data );//may throw error if data aldreay JSON format
                        $('#jqxgrid').jqxGrid('updatebounddata');
                        $("#jqxMsgContent").html(obj.msg);
                        $("#jqxMsg").jqxNotification("open");
                        //$("#id").val(obj.id);
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
                width: 300, position: "bottom-right", opacity: 0.7,
                autoOpen: false, animationOpenDelay: 300, autoClose: true, autoCloseDelay: 4000, template: "info"
            });
        });
    })(jQuery);
</script>
<script>
    (function ($) {
        $(document).ready(function () {
            // Create jqxNavigationBar.
            $("#jqxNavigationBar").jqxNavigationBar({width: 800, expandMode: 'multiple', expandedIndexes: [0, 1]});
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
            <div id="jqxgrid"></div>
        </div>
    </div>
</div>