<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
?>
<script type="text/javascript">
    (function($) {
        $(document).ready(function () {
            // prepare the data
            var theme = 'classic';

            var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'name'},
                    {name: 'parent_id'}
                ],
                url: 'http://localhost/mpd_2015/?qd-api=sanpham_port',
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
                    virtualmode: true,
                    rendergridrows: function () {
                        return dataadapter.records;
                    },
                    columns: [
                        {text: 'ID', datafield: 'id', width: 250},
                        {text: 'Name', datafield: 'name', width: 250},
                        {text: 'Parent id', datafield: 'parent_id'}
                    ]
                });
        });
    })( jQuery );
</script>

<div id="jqxgrid"></div>




