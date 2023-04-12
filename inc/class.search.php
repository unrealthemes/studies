<?php

class UT_Search {

    private static $_instance = null; 

    static public function get_instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

        add_filter('excerpt_more', function( $more ) {
            return '...';
        });

        add_filter( 'the_content', [$this, 'search_highlight'] );
        add_filter( 'get_the_excerpt', [$this, 'search_highlight'] );
        add_filter( 'the_title', [$this, 'search_highlight'] );
    }

    function search_highlight( $text ) {

        // settings
        $styles = ['',
            'color: #000; background: #99ff66;',
            'color: #000; background: #ffcc66;',
            'color: #000; background: #99ccff;',
            'color: #000; background: #ff9999;',
            'color: #000; background: #FF7EFF;',
        ];
    
        // for the search pages and the main loop only.
        if( ! is_search() || ! in_the_loop() )
            return $text;
    
        $query_terms = get_query_var( 'search_terms' );
    
        if( empty( $query_terms ) ) 
            $query_terms = array_filter( (array) get_search_query() );
    
        if( empty( $query_terms ) )
            return $text;
    
        $n = 0;
        foreach( $query_terms as $term ){
            $n++;
    
            $term = preg_quote( $term, '/' );
            $text = preg_replace_callback( "/$term/iu", static function( $match ) use ( $styles, $n ){
                // return '<span style="'. $styles[ $n ] .'">'. $match[0] .'</span>';
                return '<b>'. $match[0] .'</b>';
            }, $text );
        }
    
        return $text;
    }

} 