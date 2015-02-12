<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 08/02/2015
 * Time: 11:32 PM
 */
class Qdmvc_View_Sanpham {
    private $data = null;
    function __construct($data){
        $this->data = $data;
    }
    public function placeHolder3()
    {
        ?>
        <script>
            // prepare the data
            var data_port = '<?=$this->data['data_port']?>';
            var fieldlist = {id: 0, name: "mac dinh", avatar: "/", product_cat_id: "0"};
            //gate way to comunicate with parent windows
            function setObj(obj) {//do not change func name
                (function($){
                    $("#id").val(obj.id);
                    $("#name").val(obj.name);
                    $("#avatar").val(obj.avatar);
                    $("#product_cat_id").val(obj.product_cat_id);
                })(jQuery);
            };
        </script>
        <?php
    }
    public function placeHolder1()
    {
        Qdmvc_Helper::qd_media_choose('cavatar', 'avatar', false);
        Qdmvc_Helper::qd_media_choose('cproduct_cat_id', 'product_cat_id', true);
        ?>
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
            <td>Product Cat ID:</td>
            <td><input type="text" id="product_cat_id" name="product_cat_id" class="text-input"/>
                <button id="cproduct_cat_id" value="...">...</button>
            </td>

        </tr>
        <?php
    }
    public function placeHolder2()
    {
        ?>
        <iframe id="list" src="http://localhost/mpd_2015/wp-admin/admin.php?page=qd_sub_page_4" width="100%" scrolling="no" frameborder="0" height="420px">
            <p>Your browser does not support iframes</p>
        </iframe>
        <?php
    }
}
$Qdmvc_Layout_Card = new Qdmvc_Layout_Card();
$Qdmvc_Layout_Card->render(new Qdmvc_View_Sanpham($data));