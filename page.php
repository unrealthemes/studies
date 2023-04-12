<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package unreal-themes
 */

get_header();

	while ( have_posts() ) :
		the_post();
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
                        
						<?php the_content(); ?>

                    </div>

                    <div class="single-pagination">
                        <div class="single-pagination__prev">
                            <div class="single-pagination__title single-pagination__title_prev icon-arrow-3">Попередній розділ</div>
                            <a href="#" class="single-pagination__link">Економічна політика Петра Першого у Шведській війні за Аляску з трипільською культурою</a>
                        </div>
                        <div class="single-pagination__next">
                            <div class="single-pagination__title icon-arrow-3">Наступний розділ</div>
                            <a href="#" class="single-pagination__link">Використання електронно-обчислювальних машин (ЕОМ) та комп’ютерної техніки у селекційно-племінній роботі</a>
                        </div>
                    </div>

                </div>

				<?php // get_sidebar(); ?>
				<?php get_template_part('template-parts/sidebar'); ?>

            </div>
        </div>
    </div>

	<?php
	endwhile; // End of the loop.

get_footer();