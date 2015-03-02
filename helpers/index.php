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
    public static function getDataPortPath($name)
    {
        return get_site_url()."/?qd-api={$name}";// .../?qd-api != ...?qd-api [VERY IMPORTANT SINCE AJAX POST NOT WORK]
    }
    function __construct()
    {

    }
    public static function getSPCompactListLink()
    {
        return admin_url('admin.php?page=qd_sub_page_4&qdrole=navigate');
    }
    public static function getLSPCompactListLink()
    {
        return admin_url('admin.php?page=qd_sub_page_2&qdrole=navigate');
    }
    public static function  getNoneLink()
    {
        return 'javascript:void(0)';
    }
    public static function getLSPLookupPath($return_id)
    {
        return get_admin_url(null, 'admin.php?page=qd_sub_page_2&qdrole=lookup&qdreturnid='.$return_id);
    }
    public static function getSlider($metaslider_id)
    {
        self::loadPHPDOMLibrary();

        $slider_html = do_shortcode("[metaslider id=$metaslider_id]");
        $html = str_get_html($slider_html);
        $ret = $html->find('img');
        return $ret;
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
    public static function requestCompact()
    {
        ?>
        <style>
            @media all, screen {
                #wpadminbar, #adminmenuback, #adminmenuwrap, #wpfooter {
                    display: none !important;
                }

                #wpcontent, #wpbody {
                    margin: 0px !important;
                    padding: 0px !important;
                }

                html.wp-toolbar {
                    padding: 0 !important;
                }
            }
        </style>
        <?php
    }
}