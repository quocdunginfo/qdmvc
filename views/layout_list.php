<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
//Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
class Qdmvc_Layout_List
{
    public function render($place_holder)
    {
        ?>
        <?=$place_holder->placeHolder1()?>
        <script type="text/javascript">
            function updateGrid() {
                //update databound
                jQuery('#jqxgrid').jqxGrid('updatebounddata');
            };
            (function ($) {
                $(document).ready(function () {
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
                            autoheight: false,
                            pageable: true,
                            showfilterrow: true,
                            filterable: true,
                            showgroupsheader: true,
                            groupable: true,
                            virtualmode: true,
                            pagesize: 10,
                            //editable: true,
                            //editmode: "dblclick",
                            columnsresize: true,
                            //scrollmode: 'deferred',
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
                        parent.setObj(args.row);
                    });

                    //register notification
                    $("#jqxMsg").jqxNotification({
                        width: 400, position: "bottom-right", opacity: 0.6,
                        autoOpen: false, animationOpenDelay: 300, autoClose: true, autoCloseDelay: 4000, template: "info"
                    });
                });
            })(jQuery);
        </script>
        <div id="jqxMsg">
            <span id="jqxMsgContent"></span>
        </div>
        <div id='jqxWidget'>
            <div id="jqxgrid"></div>
        </div>
        <?php
    }
}