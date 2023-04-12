<?php 
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
?>

<?php if ( ! empty( $languages ) ) : ?>

    <div class="footer__lang">
        <select name="lang_choice_1" id="lang_choice_1" class="pll-switcher-select niceSelect-style-dark" onchange="location = this.value;">

            <?php 
            foreach ( $languages as $language ) : 
                
                if ( $language['active'] ) :
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                ?>

                    <option value="<?php echo esc_url( $actual_link ); ?>" selected='selected'>
                        <?php echo $language['translated_name']; ?>
                    </option>

                <?php endif; ?>

            <?php endforeach; ?>

            <?php if ( $show_translate || is_page_template('template-home.php') ) : ?>

                <?php 
                foreach ( $languages as $language ) : 
                    
                    if ( $language['active'] ) {
                        continue;
                    }

                    if ( is_page_template( 'template-home.php' ) ) {
                        $url = $language['url'];
                    } else {
                        $url = ut_help()->redirects->get_url_for_language_switcher($language['code']);
                    }
                ?>

                    <option value="<?php echo esc_url( $url ); ?>">
                        <?php echo $language['translated_name']; ?>
                    </option>

                <?php endforeach; ?>

            <?php endif; ?>

        </select>
    </div>

<?php endif; ?>