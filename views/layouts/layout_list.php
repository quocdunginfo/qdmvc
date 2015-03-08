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
            var data_port = '<?=$this->data['data_port']?>';
        </script>
    <?php
    }

    protected function generateFields()
    {
        ?>

        <script>
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
            //dataGrid define
            var dataGridDefine = [
                <?php
                    foreach($this->page->getLayout() as $key=>$config)
                    {
                        $f_name = $config['SourceExpr'];
                        $caption = $this->page->getFieldCaption($f_name);
                        $width = $this->page->getWidth($f_name);

                        ?>
                {
                    text: '<?=$caption?>',
                    datafield: '<?=$f_name?>',
                    columntype: 'textbox',
                    filtertype: 'input', <?=$width!=''?'width: '.$width:''?>
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
                jQuery('#jqxgrid').jqxGrid('updatebounddata');
            }
        </script>
    <?php
    }

    protected function internalGateway()
    {

    }

    public function render()
    {
        ?>
        <?= $this->externalGateway() ?>
        <?= $this->internalGateway() ?>
        <?= $this->preConfig() ?>
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
                        <?php
                        if($this->data['role']=='navigate')
                        {
                            echo 'parent.setObj(args.row);';
                        }
                        else
                        {
                            echo 'parent.setLookupResult(args.row.id, "'.$this->data['returnid'].'");';
                        }
                        ?>
                        console.log(args.row);

                    });
                    $('#jqxgrid').on('rowdoubleclick', function (event) {
                        parent.doubleClickObj(event.args.row);
                    });
                    $("#jqxgrid").on("pagechanged", function (event) {
                        //alert("page changed");
                    });
                    $("#jqxgrid").on("bindingcomplete", function (event) {
                        try {
                            //auto select first row
                            var index = $('#jqxgrid').jqxGrid('getrowboundindex', 0);
                            $('#jqxgrid').jqxGrid('selectrow', index);
                        } catch (error) {
                            console.log(error);
                        }
                    });
                });
            })(jQuery);
        </script>

        <div id='jqxWidget'>
            <div id="jqxgrid"></div>
        </div>
    <?php
    }
}