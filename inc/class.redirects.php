<?php

class UT_Redirects {

    private static $_instance = null; 

    static public function get_instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

        add_action( 'template_redirect', [$this, 'redirect_by_post_id'] );
        // add_filter( 'wp_nav_menu_items', [$this, 'new_nav_menu_items'], 10, 2);
    }

    function redirect_by_post_id() {
 
        if ( ! is_page_template( 'template-home.php' ) && is_single() && 'post' == get_post_type() ) {
    
            global $post, $sitepress;
    
            $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
            $current_lang = apply_filters( 'wpml_current_language', NULL );
            $categories = wp_get_post_categories( $post->ID );
            $categories_other_lang = [];
    
            if ( $current_lang == 'uk' ) {
                $other_lang = 'ru';
            } else {
                $other_lang = 'uk';
            }
    
            if ( $categories ) {
                foreach ( $categories AS $category ) {
                    $cat_id = apply_filters( 'wpml_object_id', $category, 'category', false, $other_lang );
                    $categories_other_lang[] = $cat_id;
                }
            }
    
            if ( isset($categories[0]) && ! empty($categories[0]) ) {
                $curr_term = get_term_by('id', $categories[0], 'category');
                $curr_show_translate = get_field('show_translate', $curr_term);
                // $curr_show_translate = (is_null($curr_show_translate)) ? false : true;
            } else {
                $curr_show_translate = true;
            }
    
            if ( isset($categories_other_lang[0]) && ! empty($categories_other_lang[0]) ) {
                $sitepress->switch_lang($other_lang);
                $term = get_term_by('id', $categories_other_lang[0], 'category');
                $show_translate = get_field('show_translate', $term);
                // $show_translate = (is_null($show_translate)) ? false : true;
            } else {
                $show_translate = true;
            }
    
            if ( ! $curr_show_translate && $show_translate ) {
                $other_post_id = apply_filters( 'wpml_object_id', $post->ID, 'post', false, $other_lang );
                // $redirect = get_permalink( $other_post_id );
                $redirect = $this->other_permalink( $other_post_id );
                wp_redirect( $redirect, 301 );
                exit;
            }
            $sitepress->switch_lang($current_lang);
        }
    
        if ( ! is_page_template( 'template-home.php' ) && is_category() ) {
    
            global $sitepress;
    
            $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
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
            $show_translate = (is_null($show_translate)) ? false : true;
    
            if ( ! $curr_show_translate && $show_translate ) {
                // $redirect = get_term_link( $other_term );
                $redirect = $this->other_term_link( $other_term );
                wp_redirect( $redirect, 301 );
                exit;
            }
            $sitepress->switch_lang($current_lang);
        }
         
    }

    function other_term_link($other_term) {

        $current_lang = apply_filters( 'wpml_current_language', NULL );

        if ( $current_lang == 'ru' ) {
            $other_lang = '/ru';
        } else {
            $other_lang = '';
        }

        $permalink = site_url() . $other_lang;
        $permalink .= '/' . $other_term->slug;

        return $permalink;
    }

    function other_permalink($post_id) {

        $current_lang = apply_filters( 'wpml_current_language', NULL );

        if ( $current_lang == 'ru' ) {
            $other_lang = '/ru';
        } else {
            $other_lang = '';
        }

        $permalink = site_url() . $other_lang;
        // $categories = get_the_category( $post->ID ); // do not working
        $categories = wp_get_object_terms( $post_id, 'category' );

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

        $post = get_post($post_id);
        $permalink .= '/' . $post->post_name . '.html';

        return $permalink;
    }

    function new_nav_menu_items($items, $args) {
        
        global $sitepress;
        $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );

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
                foreach ( $categories AS $category ) {
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
    
        if ( ! empty( $languages ) ) : 
        ?>

            <div id="menu-item-wpml-ls-451-uk" class="menu-item wpml-ls-slot-451 wpml-ls-item wpml-ls-item-uk wpml-ls-current-language wpml-ls-menu-item wpml-ls-first-item menu-item-type-wpml_ls_menu_item menu-item-object-wpml_ls_menu_item menu-item-has-children dropdown menu-item-wpml-ls-451-uk nav-item">
            
            <?php 
            foreach ( $languages as $language ) : 
                
                if ( $language['active'] ) :
                ?>

                <a title="<?php echo $language['translated_name']; ?>" href="#" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-wpml-ls-451-uk">
                    <span itemprop="name">
                    <img class="wpml-ls-flag" src="<?php echo $language['country_flag_url']; ?>" alt="">
                    <span class="wpml-ls-native" lang="<?php echo $language['code']; ?>"><?php echo $language['translated_name']; ?></span>
                    </span>
                </a>

                <?php endif; ?>

            <?php endforeach; ?>

            <?php if ( $show_translate ) : ?>

                <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-wpml-ls-451-uk">

                <?php 
                foreach ( $languages as $language ) : 
                    
                    if ( $language['active'] ) {
                    continue;
                    }
                    ?>

                    <li id="menu-item-wpml-ls-451-ru" class="menu-item wpml-ls-slot-451 wpml-ls-item wpml-ls-item-ru wpml-ls-menu-item wpml-ls-last-item menu-item-type-wpml_ls_menu_item menu-item-object-wpml_ls_menu_item menu-item-wpml-ls-451-ru nav-item">
                        <a title="<?php echo $language['translated_name']; ?>" itemprop="url" href="<?php echo esc_url( $language['url'] ); ?>" class="dropdown-item">
                            <span itemprop="name">
                                <img class="wpml-ls-flag" src="<?php echo $language['country_flag_url']; ?>" alt="">
                                <span class="wpml-ls-native" lang="<?php echo $language['code']; ?>"><?php echo $language['translated_name']; ?></span>
                            </span>
                        </a>
                    </li>

                <?php endforeach; ?>

                </ul>

            <?php endif; ?>

            </div>

        <?php 
        endif; 
        
        return $items;
    }

    public function get_url_for_language_switcher($other_lang) {
 
        if ( is_single() && 'post' == get_post_type() ) {
    
            global $post, $sitepress;
    
            $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
            $current_lang = apply_filters( 'wpml_current_language', NULL );
            $categories = wp_get_post_categories( $post->ID );
            $categories_other_lang = [];
    
            if ( $categories ) {
                foreach ( $categories AS $category ) {
                    $cat_id = apply_filters( 'wpml_object_id', $category, 'category', false, $other_lang );
                    $categories_other_lang[] = $cat_id;
                }
            }
    
            $sitepress->switch_lang($other_lang);
            if ( isset($categories_other_lang[1]) ) {
                $term = get_term_by('id', $categories_other_lang[1], 'category');
            } else {
                $term = get_term_by('id', $categories_other_lang[0], 'category');
            }
            $other_post_id = apply_filters( 'wpml_object_id', $post->ID, 'post', false, $other_lang );
            $other_post = get_post($other_post_id);
            // $redirect = get_permalink( $other_post_id );
            $other_lang = ( $other_lang == 'uk' ) ? '' : $other_lang . '/';
            $redirect = site_url() . '/' . $other_lang . $term->slug . '/' . $other_post->post_name . '.html';
 
            $sitepress->switch_lang($current_lang);

            return $redirect;
        }
    
        if ( is_category() ) {
    
            global $sitepress;
    
            $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
            $current_lang = apply_filters( 'wpml_current_language', NULL );
            $categories_other_lang = [];
            $term = get_queried_object();
    
            $sitepress->switch_lang($other_lang);
            $other_cat_id = apply_filters( 'wpml_object_id', $term->term_id, 'category', false, $other_lang );
            $other_term = get_term_by('id', $other_cat_id, 'category');
            $other_lang = ( $other_lang == 'uk' ) ? '' : $other_lang . '/';
            $redirect = site_url() . '/' . $other_lang . $other_term->slug;
            $sitepress->switch_lang($current_lang);

            return $redirect;
        }
         
    }
    
    public function get_url_sitemap($current_lang, $obj, $type) {
 
        if ( 'post' == $type ) {
            
            $term = null;
            $categories = wp_get_post_categories( $obj->ID );

            if ( isset($categories[1]) ) {
                $term = get_term_by('id', $categories[1], 'category');
            } else {
                $term = get_term_by('id', $categories[0], 'category');
            }

            $current_lang = ( $current_lang == 'uk' ) ? '' : $current_lang . '/';

            if ( $term ) {
                $redirect = site_url() . '/' . $current_lang . $term->slug . '/' . $obj->post_name . '.html';
            } else {
                $redirect = site_url() . '/' . $current_lang . $obj->post_name . '.html';
            }

            return $redirect;
        }
    
        if ( 'category' == $type ) {
    
            $current_lang = ( $current_lang == 'uk' ) ? '' : $current_lang . '/';
            $redirect = site_url() . '/' . $current_lang . $obj->slug;

            return $redirect;
        }
         
    }

    public function generate_term_link($term) {

        $current_lang = apply_filters( 'wpml_current_language', NULL );

        if ( $current_lang == 'uk' ) {
            $other_lang = 'ru';
        } else {
            $other_lang = 'uk';
        }
        $show_translate = get_field('show_translate', $term);
        
        // show true - ukr lang
        if ( $show_translate ) {

            $curr_lang = ( $current_lang == 'uk' ) ? '' : $current_lang . '/' ;
            $link = site_url() . '/' . $curr_lang . $term->slug;

        // show false - ru lang
        } else {
            
            global $sitepress;
            $sitepress->switch_lang($other_lang);
            $other_cat_id = apply_filters( 'wpml_object_id', $term->term_id, 'category', false, $other_lang );
            $other_term = get_term_by('id', $other_cat_id, 'category');
            $curr_lang = ( $other_lang == 'uk' ) ? '' : $other_lang . '/' ;
            $link = site_url() . '/' . $curr_lang . $other_term->slug;
            $sitepress->switch_lang($current_lang);
        }
        
        return $link;
    }

} 