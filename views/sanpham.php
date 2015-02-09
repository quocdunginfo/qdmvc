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
                    {name: 'countryName'},
                ],
                url: 'http://api.geonames.org/searchJSON?q=london&maxRows=30&username=demo',
                root: 'geonames',
                beforeprocessing: function (data) {
                    source.totalrecords = 60;//data[0].TotalRows;
                }
            };

            var dataadapter = new $.jqx.dataAdapter(source);

            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
                {
                    width: 600,
                    source: dataadapter,
                    theme: theme,
                    autoheight: true,
                    pageable: true,
                    virtualmode: true,
                    rendergridrows: function () {
                        return dataadapter.records;
                    },
                    columns: [
                        {text: 'Country Name', datafield: 'countryName', width: 250}
                    ]
                });
        });
    })( jQuery );
</script>

<div id="jqxgrid"></div>




