<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */
// use App\Classes\TableOfContentClass;


/**
 * Get permalink by template name
 */

function ut_get_permalik_by_template( $template ) {

	$result = '';

	if ( ! empty( $template ) ) {
		$pages = get_pages( [
		    'meta_key'   => '_wp_page_template',
		    'meta_value' => $template
		] );
		$template_id = $pages[0]->ID;
		$page = get_post( $template_id );
		$result = get_permalink( $page );
	}
	
	return $result;
}



/**
 * Get permalink by template name
 */

function ut_get_page_id_by_template( $template ) {

	$result = '';

	if ( ! empty( $template ) ) {
		$pages = get_pages( [
		    'meta_key'   => '_wp_page_template',
		    'meta_value' => $template
		] );
		$result = $pages[0]->ID;
	}
	
	return $result;
}



/**
 * Get name menu by location
 */

function ut_get_title_menu_by_location( $location ) {

    if ( empty( $location ) ) {
    	return false;
	}
    $locations = get_nav_menu_locations();

    if ( ! isset( $locations[ $location ] ) ) {
    	return false;
	}
    $menu_obj = get_term( $locations[ $location ], 'nav_menu' );

    return $menu_obj->name;
}



/** 
 * Admin footer modification
 */   

function ut_remove_footer_admin() {

    echo '<span id="footer-thankyou">Тема разработана <a href="https://unrealthemes.site/" target="_blank"><img src="' . get_template_directory_uri() . '/images/unreal.png" width="130"/></a></span>';
}
add_filter('admin_footer_text', 'ut_remove_footer_admin');



// add_filter('the_content', 'tableOfContent', 20);

// function tableOfContent($content) { 

// 	if ( ! is_singular() || (get_post_type() != 'post') ) {
// 		return $content;
// 	}
	
// 	$args = [
// 		'container_class' => 'content-fast',
// 		'title'           => __('Page content:', 'studies'),
// 		'headline'        => 'h1',
//         'selectors'       => 'h1',
//         'min_found'       => 2,
// 	];
	
// 	$contents = TableOfContentClass::init($args)->make_contents($content);
	
// 	return $contents . $content;
// }



add_filter('navigation_markup_template', 'ut_navigation_template', 10, 2 );

function ut_navigation_template( $template, $class ){

	return '<div class="pagination pagination_pc">%3$s</div>';
}



add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 9999999999 );

function filter_the_content_in_the_main_loop( $content ) {

    if ( ! is_singular() || (get_post_type() != 'post') ) {
		return $content;
	}

	$doc = new DOMDocument;
	$doc->loadHTML($content);
	$node = $doc->getElementById('ez-toc-container');
	$position = mb_strpos($content, '<div id="ez-toc-container"');

	if ( $node->previousSibling->length && $position !== false ) {
		$content = mb_substr( $content, $position );
	}

	// $content = '*******************'.$content;
	// $content = preg_replace('#<h1([^>]*)>(.*)</h1>#m','<h2$1>$2</h2>', $content);

	// error_log(print_r($content, true)); 

    return $content;
}



function ut_show_translate() {

	global $sitepress;

	$show_translate = true;

	if ( is_single() && 'post' == get_post_type() ) {
		$current_lang = apply_filters( 'wpml_current_language', NULL );
		$categories = wp_get_post_categories( get_the_ID() );
		$categories_other_lang = [];

		if ( $current_lang == 'uk' ) {
			$other_lang = 'ru';
		} else {
			$other_lang = 'uk';
		}

		if ( $categories ) {
			foreach ( $categories as $category ) {
				$cat_id = apply_filters( 'wpml_object_id', $category, 'category', false, $other_lang );
				$categories_other_lang[] = $cat_id;
			}
		}

		if ( isset($categories_other_lang[0]) && ! empty($categories_other_lang[0]) ) {
			$sitepress->switch_lang($other_lang);
			$term = get_term_by('id', $categories_other_lang[0], 'category');
			$show_translate = get_field('show_translate', $term);
			// $show_translate = (is_null($show_translate)) ? false : true;
		} else {
			$show_translate = true;
		}
		$sitepress->switch_lang($current_lang);
	} 

	if ( is_category() ) {
		$current_lang = apply_filters( 'wpml_current_language', NULL );
		$categories_other_lang = [];
		$term = get_queried_object();
		$curr_show_translate = get_field('show_translate', $term);
		// $curr_show_translate = (is_null($curr_show_translate)) ? false : true;

		if ( $current_lang == 'uk' ) {
			$other_lang = 'ru';
		} else {
			$other_lang = 'uk';
		}

		$sitepress->switch_lang($other_lang);
		$other_cat_id = apply_filters( 'wpml_object_id', $term->term_id, 'category', false, $other_lang );
		$other_term = get_term_by('id', $other_cat_id, 'category');
		$show_translate = get_field('show_translate', $other_term);
		// $show_translate = (is_null($show_translate)) ? false : true;

		if ( ! $curr_show_translate && $show_translate ) {

		}
		$sitepress->switch_lang($current_lang);
	}

	return $show_translate;
}


// wpml change tag link 
add_filter('wpml_hreflangs', 'ut_change_page_hreflang');
 
function ut_change_page_hreflang( $hreflang_items ) {

	if ( is_category() || ( is_single() && 'post' == get_post_type() ) ) {

		$show_translate = ut_show_translate();
		// echo '<pre>';
		// var_dump( $show_translate );
		// echo '</pre>';
		foreach ( $hreflang_items as $hreflang_code => $hreflang_url ) {
			$hreflang_url = ut_help()->redirects->get_url_for_language_switcher($hreflang_code);

			if ( $show_translate ) {
				$hreflang .= '<link rel="alternate" hreflang="' . esc_attr( $hreflang_code ) . '" href="' . esc_url( $hreflang_url ) . '" />' . PHP_EOL;
			} else {
				// $hreflang .= '<link href="' . esc_url( $hreflang_url ) . '" />' . PHP_EOL;
				$hreflang .= '';
			}
		}

		echo apply_filters( 'wpml_hreflangs_html', $hreflang );  

		return false;
	}

	return $hreflang_items;  
}



function ut_show_obj_sitemap( $obj, $type ) {

	if ( 'post' == $type ) {

		$term = null;
		$categories = wp_get_post_categories( $obj->ID );

		if ( isset($categories[1]) ) {
			$term = get_term_by('id', $categories[1], 'category');
		} else {
			$term = get_term_by('id', $categories[0], 'category');
		}

		if ( $term ) {
			$show_translate = get_field('show_translate', $term);
		} else {
			$show_translate = true;
		}

		return $show_translate;

	} else if ( 'category' == $type ) {

		$show_translate = get_field('show_translate', $obj);
		return $show_translate;
	}

	return true;
}



add_filter( 'rank_math/sitemap/enable_caching', '__return_false');


// change posts and term url and check show/hide this items (for sitemap)
add_filter( 'rank_math/sitemap/entry', function( $url, $type, $object ) {

	if ( $type == 'post' ) {

		if ( ! ut_show_obj_sitemap( $object, $type ) ) {
			return false;
		}

		$post_language_details = apply_filters( 'wpml_post_language_details', NULL, $object->ID ) ;
		$obj_url = ut_help()->redirects->get_url_sitemap($post_language_details['language_code'], $object, $type);
		$url['loc'] = $obj_url;

	} else if ( $type == 'term' ) {

		$type = ( $type == 'term' ) ? 'category' : $type;

		if ( ! ut_show_obj_sitemap( $object, $type ) ) {
			return false;
		}

		$args = array('element_id' => $object->term_id, 'element_type' => 'category' );
		$term_language_details = apply_filters( 'wpml_element_language_code', null, $args );
		$obj_url = ut_help()->redirects->get_url_sitemap($term_language_details, $object, $type);
		$url['loc'] = $obj_url;
	}

	return $url;

}, 10, 3 );



add_filter( 'rank_math/frontend/description', function( $description ) {
	return mb_strimwidth($description, 0, 250, "");
});



add_filter( 'rank_math/frontend/canonical', function( $canonical ) {

	if ( is_category() ) {
		$term = get_queried_object();
		// $canonical = home_url('/') . $term->slug;
		$current_lang = apply_filters( 'wpml_current_language', NULL );

        if ( $current_lang == 'ru' ) {
            $lang = '/ru';
        } else {
            $lang = '';
        }

        $canonical = site_url() . $lang;
        $canonical .= '/' . $term->slug;
	}

	return $canonical;
});




// add_action('template_redirect', 'ut_redirect_core', 50);
// add_action('init', 'ut_redirect_core', 50);
// add_action('wp_loaded', 'ut_redirect_core', 50);
// function ut_redirect_core(){

// 	echo '<pre>';
// 	print_r( is_ssl() );
// 	echo '</pre>';

//   if (!is_ssl()) {
//     wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
//     exit();
//   }
// }