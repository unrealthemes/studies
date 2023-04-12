<?php

class UT_Breadcrumbs {

    private static $_instance = null; 

    static public function get_instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

        // add_filter( 'kama_breadcrumbs_l10n', 'breadcrumbs_l10n' );
        add_filter( 'kama_breadcrumbs_args', [$this, 'breadcrumbs_args'] );

    }

    function breadcrumbs_l10n( $l10n ) {

        echo '<pre>';
        print_r( $l10n );
        echo '</pre>';
        // $my_l10n = [
        //     'home' => __('Home', 'studies'),
        // ];
    
        return $l10n;
    }

    public function breadcrumbs_args( $args ) {

        $args['sep'] = '<span class="breadcrumbs__separator"></span>';

        return $args;
    }

} 