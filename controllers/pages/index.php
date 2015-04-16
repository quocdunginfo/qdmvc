<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 15/02/2015
 * Time: 8:06 AM
 */
class Qdmvc_Page_Index {
    private static $index = array(
        'main' => array(
            'Class'=>'Qdmvc_Page_Main',
            'Caption' => array(
                'en' => 'Page Main',
                'vn' => 'Trang chính',
            )
        ),
        'product_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_Product_Card',
            'Caption' => array(
                'en' => 'Product',
                'vn' => 'Sản phẩm',
            ),
            'Model' => 'QdProduct',
            'DataPort' => 'product_port',
            'PageList' => 'product_list'
        ),
        'product_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_Product_List',
            'Caption' => array(
                'en' => 'Product List',
                'vn' => 'Product List'
            ),
            'Model' => 'QdProduct',
            'DataPort' => 'product_port'
        ),
        'product_cat_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_ProductCat_Card',
            'Caption' => array(
                'en' => 'Product Cat',
                'vn' => 'Loại sản phẩm',
            ),
            'Model' => 'QdProductCat',
            'DataPort' => 'product_cat_port',
            'PageList' => 'product_cat_list'
        ),
        'product_cat_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_ProductCat_List',
            'Caption' => array(
                'en' => 'Product Cat List',
                'vn' => 'Product Cat List',
            ),
            'Model' => 'QdProductCat',
            'DataPort' => 'product_cat_port'
        ),
        'product_order_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_ProductOrder_Card',
            'Caption' => array(
                'en' => 'Product Order',
                'vn' => 'Đơn đặt hàng (Open)',
            ),
            'Model' => 'QdProductOrder',
            'DataPort' => 'product_order_port',
            'PageList' => 'product_order_list'
        ),
        'product_order_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_ProductOrder_List',
            'Caption' => array(
                'en' => 'Product Order List',
                'vn' => 'Product Order List',
            ),
            'Model' => 'QdProductOrder',
            'DataPort' => 'product_order_port'
        ),
        'product_order_done_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_ProductOrderDone_Card',
            'Caption' => array(
                'en' => 'Product Order Done',
                'vn' => 'Đơn đặt hàng (Done)',
            ),
            'Model' => 'QdProductOrder',
            'DataPort' => 'product_order_port',
            'PageList' => 'product_order_done_list'
        ),
        'product_order_done_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_ProductOrderDone_List',
            'Caption' => array(
                'en' => 'Product Order Done List',
                'vn' => 'Product Order Done List'
            ),
            'Model' => 'QdProductOrder',
            'DataPort' => 'product_order_port'
        ),
        'feedback_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_Feedback_Card',
            'Caption' => array(
                'en' => 'Feedback',
                'vn' => 'Phản hồi KH (Open)',
            ),
            'Model' => 'QdFeedback',
            'DataPort' => 'feedback_port',
            'PageList' => 'feedback_list'
        ),
        'feedback_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_Feedback_List',
            'Caption' => array(
                'en' => 'Feedback List',
                'vn' => 'Feedback List'
            ),
            'Model' => 'QdFeedback',
            'DataPort' => 'feedback_port'
        ),
        'feedback_done_card' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_FeedbackDone_Card',
            'Caption' => array(
                'en' => 'Feedback Done',
                'vn' => 'Phản hồi KH (Done)',
            ),
            'Model' => 'QdFeedback',
            'DataPort' => 'feedback_port',
            'PageList' => 'feedback_done_list'
        ),
        'feedback_done_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_FeedbackDone_List',
            'Caption' => array(
                'en' => 'Feedback Done List',
                'vn' => 'Feedback Done List'
            ),
            'Model' => 'QdFeedback',
            'DataPort' => 'feedback_port'
        ),
        'product_setup' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_ProductSetup',
            'Caption' => array(
                'en' => 'Product Setup',
                'vn' => 'Cấu hình Sản phẩm',
            ),
            'Model' => 'QdProductSetup',
            'DataPort' => 'product_setup_port'
        ),
        'setup' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_Setup',
            'Caption' => array(
                'en' => 'General Setup',
                'vn' => 'Cấu hình chung',
            ),
            'Model' => 'QdSetup',
            'DataPort' => 'setup_port'
        ),
        'note' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_Note',
            'Caption' => array(
                'en' => 'Note',
                'vn' => 'Note'
            ),
            'Model' => 'QdNote',
            'DataPort' => 'note_port',
            'PageList' => 'note_list'
        ),
        'note_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_Note_list',
            'Caption' => array(
                'en' => 'Note List',
                'vn' => 'Note List'
            ),
            'Model' => 'QdNote',
            'DataPort' => 'note_port'
        ),
        'image' => array(
            'PageType' => 'Card',
            'Class'=>'Qdmvc_Page_Image',
            'Caption' => array(
                'en' => 'Image',
                'vn' => 'Image'
            ),
            'Model' => 'QdImage',
            'DataPort' => 'image_port',
            'PageList' => 'image_list'
        ),
        'image_list' => array(
            'PageType' => 'List',
            'Class'=>'Qdmvc_Page_Image_list',
            'Caption' => array(
                'en' => 'Image List',
                'vn' => 'Image List'
            ),
            'Model' => 'QdImage',
            'DataPort' => 'image_port'
        ),
    );
    public static function getIndex()
    {
        return static::$index;
    }
}