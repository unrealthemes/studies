<?php
/**
 * unreal-themes functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package unreal-themes 
 */


include_once 'inc/loader.php'; // main helper for theme

ut_help()->init();



function remove_parent_cats_from_link( $permalink, $post, $leavename ) {

    $permalink = home_url();
    // $categories = get_the_category( $post->ID ); // do not working
    $categories = wp_get_object_terms( $post->ID, 'category' );
    
    if ( $categories ) { 
        foreach ( $categories as $category ) {
            $permalink .= '/' . $category->slug;
        }
        // Make sure we use the same start cat as the permalink generator
        // usort( $cats, '_usort_terms_by_ID' ); // order by ID
        // $category = $cats[0]->slug;

        // if ( $parent = $cats[0]->parent ) {
        //     // If there are parent categories, collect them and replace them in the link
        //     $parentcats = get_category_parents( $parent, false, '/', true );
        //     // str_replace() is not the best solution if you can have duplicates:
        //     // myexamplesite.com/luxemburg/luxemburg/ will be stripped down to myexamplesite.com/
        //     // But if you don't expect that, it should work
        //     $permalink = str_replace( $parentcats, '', $permalink );
        // }
    }

    $permalink .= '/' . $post->post_name . '.html';

    return $permalink;
}
add_filter( 'post_link', 'remove_parent_cats_from_link', 100, 3 );



// function order_posts_by_title( $query ) { 


    // if ( $query->is_home() && $query->is_main_query() ) { 
 
        //   $query-set( 'orderby', 'title' ); 
        //   $query-set( 'order', 'ASC' ); 
 
    // } 
 
//  } 
 
//  add_action( 'pre_get_posts', 'order_posts_by_title' );



function ut_next_post_sort( $sql ) {

    global $post;

    $alphabet_cats = [
        // підручники uk, ru,
        456, 459,
        // лекції
        461, 464,
        // семінари
        460, 463,
        // шпаргалки
        457, 458,
        // інше
        462, 465,
    ];
    $categories = wp_get_post_categories( $post->ID );

    if ( isset($categories[0]) ) {
        $category = get_term( $categories[0], 'category' );
    }

    if ( in_array( $category->parent, $alphabet_cats ) ) {
    //     $args['orderby'] = 'ID';
    //     $args['order'] = 'DESC';
        // $sql = 'ORDER BY p.post_date ASC LIMIT 1';
        $sql = 'ORDER BY p.menu_order desc LIMIT 1';
    }

    // $pattern = '/post_date/';
    // $replacement = 'menu_order';
    // $sql = preg_replace( $pattern, $replacement, $sql )

    echo '<pre>';
    print_r( $sql );
    echo '</pre>';

    echo '<pre>';
    print_r( $category->parent );
    echo '</pre>';

    // return preg_replace( $pattern, $replacement, $sql );
    return $sql;
}

// add_filter( 'get_next_post_sort', 'ut_next_post_sort' );
// add_filter( 'get_previous_post_sort', 'wpse73190_gist_adjacent_post_sort' );


// function my_previous_post_where() {

// 	global $post, $wpdb;

// 	return $wpdb->prepare( "WHERE p.menu_order < %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
// }
// add_filter( 'get_previous_post_where', 'my_previous_post_where' );

// function my_next_post_where() {

// 	global $post, $wpdb;

// 	return $wpdb->prepare( "WHERE p.menu_order > %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
// }
// add_filter( 'get_next_post_where', 'my_next_post_where' );

// function my_previous_post_sort() {

// 	return "ORDER BY p.ID asc LIMIT 1";
// }
// add_filter( 'get_previous_post_sort', 'my_previous_post_sort' );

// function my_next_post_sort() {

// 	return "ORDER BY p.ID desc LIMIT 1";
// }
// add_filter( 'get_next_post_sort', 'my_next_post_sort' );