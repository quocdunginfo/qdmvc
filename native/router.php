<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 10/02/2015
 * Time: 12:31 AM
 */
class Qdmvc_Router {

    /**
     * PHP5 constructor method.
     *
     * This method loads other methods of the class.
     *
     * @return    void
     *
     * @access    public
     * @since     2.0
     */
    public function __construct() {

    }
    public function run()
    {
        //register query var
        add_filter( 'query_vars', 'qd_addnew_query_vars', 10, 1 );
        function qd_addnew_query_vars($vars)
        {
            $vars[] = 'qd-api'; // for data port
            $vars[] = 'qdrole'; // for view
            $vars[] = 'qdreturnid'; // for lookup (parent id)
            //$vars[] = 'download'; // var1 is the name of variable you want to add
            return $vars;
        }


        //redirect to wanted controller
        add_action( 'parse_request', 'qd_wpse9870_parse_request' );
        function qd_wpse9870_parse_request( &$wp )
        {
            if ( array_key_exists( 'qd-api', $wp->query_vars ) ) {

                Qdmvc::runDataPort($wp->query_vars['qd-api']);
                exit(0);
            }
            return;
        }
    }

}
$obj = new Qdmvc_Router();
$obj->run();