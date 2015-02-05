<?php
//add_action('admin_menu', 'qd_notification_bubble_in_admin_menu');

function qd_notification_bubble_in_admin_menu() {
    global $menu;
    foreach($menu as &$item)
    {
        if($item[0] == 'Dashboard')
        {
            
            $item[0] .= ' <span class="update-plugins count-5"><span class="update-count">qd</span></span>';
        }
    }
}