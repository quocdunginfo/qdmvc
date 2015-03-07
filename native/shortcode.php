<?php

class Qdmvc_Shortcode
{
    function __construct()
    {
        //[qd_hocsinh_link id="10"]
        add_shortcode('qd_hocsinh_link', array($this, 'qd_fn_sc_hocsinh'));
    }

    function qd_fn_sc_hocsinh($atts)
    {
        $id = $atts['id'];
        return 'http://qd_hocsinh_link_' . $id;
    }
}
//(new Qdmvc_Shortcode());
