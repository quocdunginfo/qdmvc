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
    protected $data = null;
    protected $page = null;

    function __construct($page)
    {
        $this->page = $page;
        $this->data = $page->getData();
    }

    protected function preConfig()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';//quocdunginfo
        </script>
    <?php
    }

    protected function generateFields()
    {
        ?>
        <script>
            var defaultline = {};
            var dataSourceDefine = [
                <?php
                $c = $this->page->getModel();
                foreach($c::getFieldsConfig() as $key=>$config) {
                    ?>
                {name: '<?=$key?>'},
                <?php
            }
            ?>
            ];
            var cellbeginedit = function (row, datafield, columntype, value) {
                //check field can edit when linked to Header page

                return true;
            }

            var dataGridDefine = [
                <?php
                    foreach($this->page->getLayout() as $key=>$config)//quocdunginfo
                    {
                        $f_name = $config['SourceExpr'];
                        $caption = $this->page->getFieldCaption($f_name, $this->data['language']);
                        $width = $this->page->getWidth($f_name);

                        ?>
                {
                    text: '<?=$caption?>',
                    datafield: '<?=$f_name?>',
                    columntype: 'textbox',
                    filtertype: 'input',
                    cellbeginedit: cellbeginedit,
                    // update the editor's value before saving it.
                    cellvaluechanging: function (row, column, columntype, oldvalue, newvalue) {
                        console.log('jqxgrid cell value changed');
                    },
                    <?=$width!=''?'width: '.$width:''?>
                },
                <?php
            }
        ?>
            ];
        </script>
    <?php
    }

    protected function externalGateway()
    {
        ?>
        <script>
            function updateGrid() {
                //update databound
                (function ($) {
                    jQuery('#jqxgrid').jqxGrid('updatebounddata');
                })(jQuery);

            }
        </script>
    <?php
    }

    protected function internalGateway()
    {
        ?>
        <script>
            function gridGetSelectedRow(){//not work
                (function ($) {
                    var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                    if (getselectedrowindexes.length > 0) {
                        // returns the selected row's data.
                        var row = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[0]);
                        return row;
                    }
                    return null;
                })(jQuery);
            }
        </script>
        <?php
    }
    protected function lookupToolbar()
    {
        ?>
        <!-- Lookup toolbar -->
        <div>
            <button id="qdchoose" type="button">Choose</button>

            <script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        /*
                         $('#qdaddline').click(function () {
                         $('#jqxgrid').jqxGrid('addrow', null, {});

                         //updateGrid();//quocdunginfo
                         });
                         $('#deleteline').click(function () {
                         //$('#jqxgrid').jqxGrid('addrow', null, {});
                         //updateGrid();//quocdunginfo
                         });
                         */

                        $('#qdchoose').click(function () {

                            //$('#jqxgrid').jqxGrid('addrow', null, {});

                            var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                            if (getselectedrowindexes.length > 0)
                            {
                                // returns the selected row's data.

                                var row = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[0]);
                                try {
                                    parent.setLookupResult(row.<?=$this->data['getfield']?>, "<?=$this->data['returnid']?>");

                                }catch(error)
                                {
                                    console.log(error);
                                }
                            }
                        });
                    });
                })(jQuery);
            </script>
        </div>

        <?php
    }
    public function render()
    {
        if($this->data['view_style']=='compact')
        {
            Qdmvc_Helper::requestCompact();
        }
        ?>
        <?= $this->preConfig() ?>
        <?= $this->externalGateway() ?>
        <?= $this->internalGateway() ?>
        <?= $this->generateFields() ?>

        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    var theme = 'classic';
                    var source =
                    {
                        datatype: "json",
                        datafields: dataSourceDefine,
                        url: data_port,
                        root: 'rows',
                        beforeprocessing: function (data) {
                            source.totalrecords = data.total;
                        }
                    };

                    var dataadapter = new $.jqx.dataAdapter(source);

                    // initialize jqxGrid
                    $("#jqxgrid").jqxGrid(
                        {
                            width: '100%',
                            height: '100%',
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
                            /*Enable Inline Editing*/
                            /*editable: true,
                            editmode: "dblclick",*/
                            columnsresize: true,
                            //scrollmode: 'deferred',
                            rendergridrows: function () {
                                return dataadapter.records;
                            },
                            columns: dataGridDefine
                            /*
                             columns: [
                             { text: 'Ship Name', datafield: 'parent_id', columntype: 'combobox' }
                             ]*/
                        });

                    //event
                    $("#jqxgrid").on("filter", function (event) {
                        $('#jqxgrid').jqxGrid('updatebounddata');//refresh grid when typing in filter box
                    });
                    $('#jqxgrid').on('rowselect', function (event) {
                        // event arguments.
                        var args = event.args;
                        var row = args.row;
                        // row's bound index.
                        //var rowBoundIndex = args.rowindex;
                        // row's data. The row's data object or null(when all rows are being selected or unselected with a single action). If you have a datafield called "firstName", to access the row's firstName, use var firstName = rowData.firstName;
                        //formObj = args.row;

                        //call pass obj to CARD
                        try {
                            <?php
                            if($this->data['role']=='navigate')
                            {
                                echo 'parent.clearFormValidationMark();';
                                echo 'parent.setObj(args.row, true);';
                            }
                            ?>
                        }catch(error)
                        {
                            console.log(error);
                        }
                    });
                    $('#jqxgrid').on('rowdoubleclick', function (event) {
                        rbindex = event.args.rowindex;
                        obj = $(this).jqxGrid('getrowdata', rbindex);
                        parent.doubleClickObj(obj);
                    });
                    $("#jqxgrid").on("pagechanged", function (event) {
                        console.log('jqxgrid page changed');
                    });
                    $("#jqxgrid").on("bindingcomplete", function (event) {
                        console.log('jqxgrid binding complete');
                        try {
                            //auto select first row
                            /*
                            var index = $('#jqxgrid').jqxGrid('getrowboundindex', 0);
                            $('#jqxgrid').jqxGrid('selectrow', index);
                            */
                            /*
                            var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                            if (getselectedrowindexes.length > 0)
                            {
                                // returns the selected row's data.

                                var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[0]);
                                console.log(selectedRowData);

                            }
                            */
                            //select 1st row on screen
                            var visiblerows = $("#jqxgrid").jqxGrid('getloadedrows');
                            $("#jqxgrid").jqxGrid('selectrow', visiblerows[0].boundindex);

                        } catch (error) {
                            console.log(error);
                        }
                    });
                });
            })(jQuery);
        </script>

        <div id='jqxWidget'>
            <?php
            if($this->data['role']=='lookup')
            {
                $this->lookupToolbar();
            }
            ?>

            <div id="jqxgrid"></div>
        </div>
    <?php
    }
}