<?php

class UT_Nav_Menu {

    private static $_instance = null; 

    static public function get_instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

        add_filter('wp_nav_menu_objects', [$this, 'nav_menu_objects'], 10, 2);

    }

    function nav_menu_objects( $items, $args ) {
    
        foreach ( $items as &$item ) {
            $img_url = get_field('img_menu_item', $item);
            
            if ( $img_url ) {
                $item->title .= '<img src="' . $img_url . '" alt="">';    
            }
        }
        return $items;
    }

} 