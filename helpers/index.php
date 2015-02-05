<?php

class Qdmvc_Helper
{
    function __construct()
    {

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
    public static function qd_media_choose($btnID, $txtID, $getID = true)
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
                        text: jQuery(this).data('uploader_button_text'),
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                <?=$btnID?>_file_frame.on('select', function () {
                    // We set multiple to false so only get one image from the uploader
                    attachment = <?=$btnID?>_file_frame.state().get('selection').first().toJSON();
                    jQuery('#<?=$txtID?>').val(<?=$getID===true?'attachment.id':'attachment.url'?>);
                    // Do something with attachment.id and/or attachment.url here
                });

                // Finally, open the modal
                <?=$btnID?>_file_frame.open();
            });
        </script>
    <?php
    }
}