<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/03/2015
 * Time: 7:08 PM
 */
class Qdmvc_Layout_Navigation
{
    protected $page = null;
    protected $data = null;
    function __construct($page)
    {
        $this->page = $page;
        $this->data = $page->getData();
    }

    public function render()
    {
        Qdmvc_Helper::requestCompact();
        ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    height = $(window).height();

                    $("#splitter").jqxSplitter({width: '99%', height: height, panels: [{size: 250}]});
                    // Create jqxTree
                    var data = <?=Qdmvc_Page_Index::buildJSONTree($this->data['language'])?>;
                    // prepare the data
                    var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id'},
                            {name: 'parentid'},
                            {name: 'text'},
                            {name: 'value'}
                        ],
                        id: 'id',
                        localdata: data
                    };
                    // create data adapter.
                    var dataAdapter = new $.jqx.dataAdapter(source);
                    // perform Data Binding.
                    dataAdapter.dataBind();
                    var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{
                        name: 'text',
                        map: 'label'
                    }]);
                    $('#jqxTree').jqxTree({source: records, height: '100%', width: '100%'});
                    //$('#jqxTree').jqxTree({  height: '100%', width: '100%' });
                    $('#jqxTree').css('visibility', 'visible');
                    $('#jqxTree').on('select', function (event) {
                        //$("#ContentPanel").html("<div style='margin: 10px;'>" + event.args.element.id + "</div>");
                        //add tab
                        var args = event.args;
                        var item = $(this).jqxTree('getItem', args.element);
                        console.log(item);
                        var label = item.label;
                        var url = item.value;
                        if(url=='')
                        {
                            return;//ignore folder
                        }
                        //check existed
                        var totaltab = $('#jqxTabs').jqxTabs('length');
                        var i=0;
                        for(i=0;i<totaltab;i++)
                        {
                            var title = $('#jqxTabs').jqxTabs('getTitleAt', i);
                            if(title==label)
                            {
                                $('#jqxTabs').jqxTabs('select', i);//switch to tab
                                return;//ignore duplicate tab
                            }
                        }

                        $('#jqxTabs').jqxTabs('addLast', label, '<iframe id="pagepart" src="'+url+'" width="100%" height="99%" scrolling="yes" frameborder="0"><p>Your browser does not support iframes</p> </iframe>');
                    });
                    //Tabs
                    $('#jqxTabs').jqxTabs({height: '100%', width: '100%', showCloseButtons: true});
                });
            })(jQuery);
        </script>
        <div id="splitter">
            <div>
                <div style="visibility: hidden; border: none;" id='jqxTree'>
                </div>
            </div>
            <div id="ContentPanel">
                <div id='jqxTabs' style="float: left;">
                    <ul style="margin-left: 30px;" id="unorderedList">
                        <li>Home</li>
                    </ul>
                    <div>
                        Home page content
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
}