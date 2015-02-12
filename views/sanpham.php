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
    function updateGrid() {
        //update databound
        jQuery('#jqxgrid').jqxGrid('updatebounddata');
    };
    (function ($) {


        $(document).ready(function () {
            // prepare the data
            var data_port = '<?=$data['data_port']?>';
            //dataSourceDefine
            var dataSourceDefine = [
                {name: 'id'},
                {name: 'name'},
                {name: 'avatar'},
                {name: 'parent_id'}
            ];
            //dataGrid define
            var dataGridDefine = [
                {text: 'ID', datafield: 'id', columntype: 'textbox', filtertype: 'input', width: 50},
                {text: 'Name', datafield: 'name', columntype: 'textbox', filtertype: 'input', width: 250},
                {text: 'Avatar', datafield: 'avatar', columntype: 'textbox', filtertype: 'input', width: 250},
                {text: 'Parent id', datafield: 'parent_id', columntype: 'textbox', filtertype: 'input'}
            ];

            /* 2 ways data binding
             $("#testForm").my({ui:{
             "#id": "id",
             "#name": "name",
             "#avatar": "avatar",
             "#parent_id": "parent_id"
             }}, formObj);*/

            var theme = 'classic';
            var source =
            {
                datatype: "json",
                datafields: dataSourceDefine,
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
                    pagesize: 5,
                    editable: true,
                    editmode: "dblclick",
                    columnsresize: true,
                    rendergridrows: function () {
                        return dataadapter.records;
                    },
                    columns: dataGridDefine
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

                //call pass obj to CARD
                //...
                //var $f = $("#sanpham_card");
                //$f[0].contentWindow.setObj2();  //works
                document.getElementById('sanpham_card').contentWindow.setObj(args.row);
            });



            //register notification
            $("#jqxMsg").jqxNotification({
                width: 400, position: "bottom-right", opacity: 0.6,
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
            <iframe id="sanpham_card" src="http://localhost/mpd_2015/wp-admin/admin.php?page=qd_sub_page_2" width="100%" scrolling="no" marginheight="0" marginwidth="0" frameborder="0" >
                <p>Your browser does not support iframes</p>
            </iframe>
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