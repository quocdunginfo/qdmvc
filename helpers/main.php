<?php

class Qdmvc_Helper
{
    public static $data_type = array(
        'image' => 'image',
        'flowfield' => 'flowfield'
    );
    public static function loadPHPDOMLibrary()
    {
        require('simple_html_dom.php');
    }
    public static function getDataPortPath($name, $pre_filter_arr=null)
    {
        // .../?qd-api != ...?qd-api [VERY IMPORTANT SINCE AJAX POST NOT WORK]
        $tmp = '';
        if($pre_filter_arr!=null) {
            $count = 99;
            foreach ($pre_filter_arr as $key => $value) {
                $value = $value === true ? 1 : ($value===false?0:$value);
                $tmp .= "&filterdatafield{$count}={$key}&filtervalue{$count}={$value}";
                $count++;
            }
        }
        return get_site_url()."/?qd-api={$name}".$tmp;
    }
    function __construct()
    {

    }
    public static function getNoneText()
    {
        return '[Not set]';
    }
    public function callServerFn($class, $fn, $params)
    {
        return $class::$fn;
    }
    public static function getCompactPageListLink($page_name, $filter_array=array())
    {
        $filter_string = '';
        $count=0;
        foreach($filter_array as $key=>$value)
        {
            $filter_string .= "&filterdatafield{$count}={$key}&filtervalue{$count}={$value}";
            $count++;
        }
        return admin_url("admin.php?page={$page_name}&qdrole=navigate{$filter_string}");
    }
    public static function getCompactPagePartLink($page_name, $filterfield, $filtervalue)
    {
        return admin_url("admin.php?page={$page_name}&filterfield={$filterfield}&filtervalue={$filtervalue}");//quocdunginfo
    }

    public static function getNoneLink()
    {
        return 'javascript:void(0)';
    }
    public static function getLookupPath($page_list, $return_id, $getfield='id', $multi=0)
    {
        return get_admin_url(null, "admin.php?page={$page_list}&qdrole=lookup&qdreturnid={$return_id}&qdgetfield={$getfield}&qdmulti=0");
    }
    public static function getSlider($metaslider_shortcode)
    {
        self::loadPHPDOMLibrary();
        if($metaslider_shortcode!='')
        {
            $slider_html = do_shortcode($metaslider_shortcode);
            $html = str_get_html($slider_html);
            $ret = $html->find('img');
            return $ret;
        }
        else
        {
            return array();
        }
    }
    public static function getPageIdByTemplate($template_path_from_theme)
    {
        $re = 0;
        $args = array(
            'post_type' => 'page',//it is a Page right?
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => $template_path_from_theme, // template name as stored in the dB
                )
            )
        );
        $the_query = new WP_Query($args);
        // The Loop
        if ( $the_query->have_posts() ) {
            $the_query->the_post();
            $re = get_the_ID();
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();
        return $re;
    }

    public static function qd_datetime_to_js($datetime)
    {
        if ($datetime != null) {
            $year = $datetime->format("Y");
            $month_0 = $datetime->format("m") - 0;
            $day = $datetime->format("d");
            return $year . ', ' . $month_0 . ', ' . $day;
        }
        return '';
    }

    public static function qd_js_to_datetime($year_month_date)
    {
        $arr = explode(',', $year_month_date);
        $tmp = DateTime::createFromFormat('Y, m, d', $arr[0] . ', ' . ($arr[1] + 1) . ', ' . $arr[2]);
        return $tmp;
    }

    /**
     * Init media uploader
     */
    public static function qd_media_choose($btnID, $txtID, $getID = false)
    {
        wp_enqueue_media();
        ?>
        <script>
            // Uploading files
            var <?=$btnID?>_file_frame;

            jQuery('#<?=$btnID?>').live('click', function (event) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (<?=$btnID?>_file_frame) {
                    <?=$btnID?>_file_frame.open();
                    return;
                }

                // Create the media frame.
                <?=$btnID?>_file_frame = wp.media.frames.<?=$btnID?>_file_frame = wp.media({
                    title: jQuery(this).data('uploader_title'),
                    button: {
                        text: jQuery(this).data('uploader_button_text')
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                <?=$btnID?>_file_frame.on('select', function () {
                    // We set multiple to false so only get one image from the uploader
                    attachment = <?=$btnID?>_file_frame.state().get('selection').first().toJSON();
                    jQuery('#<?=$txtID?>').val(<?=$getID===true?'attachment.id':'attachment.url'?>).change();
                    // Do something with attachment.id and/or attachment.url here
                });

                // Finally, open the modal
                <?=$btnID?>_file_frame.open();
            });
        </script>
    <?php
    }
    public static function getImgURL($path)
    {
        return plugins_url( '../views/imgs/'.$path , __FILE__);
    }
    public static function sanitize_title_with_dashes($string)
    {
        //chuyen co dau thanh khong dau
        return sanitize_title_with_dashes(static::coDauThanhKhongDau($string));
    }
    public static function coDauThanhKhongDau ( $string ) {
        $trans = array ( 'à'=>'a','á'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a',
            'ă'=>'a','ằ'=>'a','ắ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ầ'=>'a','ấ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a',
            'À'=>'a','Á'=>'a','Ả'=>'a','Ã'=>'a','Ạ'=>'a',
            'Ă'=>'a','Ằ'=>'a','Ắ'=>'a','Ẳ'=>'a','Ẵ'=>'a','Ặ'=>'a',
            'Â'=>'a','Ầ'=>'a','Ấ'=>'a','Ẩ'=>'a','Ẫ'=>'a','Ậ'=>'a',
            'đ'=>'d','Đ'=>'d',
            'è'=>'e','é'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e',
            'ê'=>'e','ề'=>'e','ế'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
            'È'=>'e','É'=>'e','Ẻ'=>'e','Ẽ'=>'e','Ẹ'=>'e',
            'Ê'=>'e','Ề'=>'e','Ế'=>'e','Ể'=>'e','Ễ'=>'e','Ệ'=>'e',
            'ì'=>'i','í'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
            'Ì'=>'i','Í'=>'i','Ỉ'=>'i','Ĩ'=>'i','Ị'=>'i',
            'ò'=>'o','ó'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o',
            'ô'=>'o','ồ'=>'o','ố'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
            'ơ'=>'o','ờ'=>'o','ớ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
            'Ò'=>'o','Ó'=>'o','Ỏ'=>'o','Õ'=>'o','Ọ'=>'o',
            'Ô'=>'o','Ồ'=>'o','Ố'=>'o','Ổ'=>'o','Ỗ'=>'o','Ộ'=>'o',
            'Ơ'=>'o','Ờ'=>'o','Ớ'=>'o','Ở'=>'o','Ỡ'=>'o','Ợ'=>'o',
            'ù'=>'u','ú'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u',
            'ư'=>'u','ừ'=>'u','ứ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
            'Ù'=>'u','Ú'=>'u','Ủ'=>'u','Ũ'=>'u','Ụ'=>'u',
            'Ư'=>'u','Ừ'=>'u','Ứ'=>'u','Ử'=>'u','Ữ'=>'u','Ự'=>'u',
            'ỳ'=>'y','ý'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y',
            'Y'=>'y','Ỳ'=>'y','Ý'=>'y','Ỷ'=>'y','Ỹ'=>'y','Ỵ'=>'y'
        );
        return strtr( $string , $trans ) ;
    }
    public static function requestCompact()
    {
        ?>
        <style>
            @media all, screen {
                #wpadminbar, #adminmenuback, #adminmenuwrap, #wpfooter {
                    display: none !important;
                }
                #wpbody-content{
                    padding-bottom: 0px;
                }
                #wpcontent, #wpbody {
                    margin: 0px !important;
                    padding: 0px !important;
                    /*width: 100%;*/
                    /*height: 100%;*/
                }

                html.wp-toolbar {
                    padding: 0 !important;
                }
            }
        </style>
        <?php
    }
}