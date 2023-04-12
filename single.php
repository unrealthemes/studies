<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package unreal-themes
 */

get_header();

	while ( have_posts() ) :
		the_post();
        $content = apply_filters('the_content', get_the_content());
        $content = preg_replace(
            '~(?:(?<=<)|(?<=</))h1(?=(?:\\s[^<>]*)?>)~i',
            'h2',
            $content
        );
	?>

	<?php get_template_part('template-parts/support'); ?>

    <div class="main">
        <div class="content">
			
			<div class="breadcrumbs">
				<?php do_action( 'echo_kama_breadcrumbs' ); ?>
            </div>

            <div class="main__row">
                <div class="main__content" id="main">
                    <div class="main__title">
						<?php the_title('<h1 class="title-h1">', '</h1>'); ?>
                    </div>
                    <div class="book-text">
                        
						<?php // echo do_shortcode('[ez-toc]'); ?>
						<?php echo $content; ?>

                    </div>

                    <?php get_template_part('template-parts/find-cost'); ?>

                    <div class="single-pagination">
                        <div class="single-pagination__prev">
                            <div class="single-pagination__title single-pagination__title_prev icon-arrow-3"><?php _e('Prev post', 'studies'); ?></div>
                            <?php
                            $prev = get_previous_post_link( '%link', '%title', true );
                            echo str_replace( '<a ', '<a class="single-pagination__link" ', $prev );
                            ?>
                        </div>
                        <div class="single-pagination__next">
                            <div class="single-pagination__title icon-arrow-3"><?php _e('Next post', 'studies'); ?></div>
                            <?php
                            $next = get_next_post_link( '%link', '%title', true ); 
                            echo str_replace( '<a ', '<a class="single-pagination__link" ', $next );
                            ?>
                        </div>
                    </div>

                </div>

				<?php // get_sidebar(); ?>
				<?php get_template_part('template-parts/sidebar'); ?>

            </div>
        </div>
    </div>

    <script>
        // $('.book-text').find('h1').replaceWith(function() {
        //     return '<h2>' + $(this).html() + '</h2>';
        // });
    </script>

	<?php
	endwhile; // End of the loop.

get_footer();