<?php
/**
 * Template name: Test
 */

get_header(); 

global $wpdb;

if (have_posts()) : 

    while (have_posts()) : the_post(); 
    ?>

        <main class="main">
            <div class="content">
                <?php
                // $categories = get_categories();
                // foreach ( $categories as $category ) {
                //     $url = home_url() . '/' . $category->slug;
                //     $result = '';
                //     for ($i = 1; $i <= 30; $i++) {
                //         $result .= 'Redirect 301 /' . $category->slug . '/page/'.$i.' /' . $category->slug . '<br>';
                //     }

                //     echo '<pre>';
                //     print_r( $result );
                //     echo '</pre>';
                // }


                // $args = array(
                //     'post_type' => 'post',
                //     'posts_per_page' => -1,
                // );
                // $query = new WP_Query( $args );
                // while ( $query->have_posts() ) {
                //     $query->the_post();
                //     $post_id = get_the_ID();
                //     $post_id_uk = apply_filters( 'wpml_object_id', $post_id, 'post', false, 'uk' );
                //     $title_uk = get_the_title($post_id_uk);
                //     $data = $wpdb->get_results("
                //             SELECT 
                //             *
                //             FROM `dle_post`
                //             WHERE
                //             id = $post_id_uk
                //         ", 
                //         'ARRAY_A'
                //     );

                //     if ( empty($data[0]['alt_name_ru']) ) {
                //         $slug_ru = $post_id_uk . '-' . $data[0]['alt_name'];
                //     } else {
                //         $slug_ru = $post_id_uk . '-' . $data[0]['alt_name_ru'];
                //     }

                    // $wpdb->update('wp_posts', array('post_name'=>$slug_ru), array('ID'=>$post_id));
                    
                    // echo '<pre>';
                    // print_r( $post->post_name . ' === ' . $slug_ru );
                    // echo '</pre>';
                    
                    // echo '<pre>';
                    // print_r( '-----------------------------------' );
                    // echo '</pre>';
                // }
                ?>  
            </div>
        </main>

    <?php
    endwhile; 

endif; 

get_footer();