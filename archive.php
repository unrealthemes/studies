<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package unreal-themes
 */

get_header();

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
$category = get_queried_object();
$args = [ 'parent' => $category->cat_ID ];

if ( in_array( $category->cat_ID, $alphabet_cats ) ) {
	$args['orderby'] = 'name';
	$args['order'] = 'ASC';
}

$child_categories = get_categories($args);
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
						<?php the_archive_title( '<h1 class="title-h1">', '</h1>' ); ?>
                    </div>
                    <div class="category-books">
                        
						<?php 
						if ( $child_categories ) :

							echo '<ul class="book-list">';
							foreach ( $child_categories as $child_category ) :
								// $term_link = get_category_link($child_category->term_id)
								// $term_link = home_url() . '/' . $child_category->slug;
								$term_link = ut_help()->redirects->generate_term_link($child_category);
								?>

									<li id="post-<?php echo $child_category->term_id; ?>" class="book-list__item">
										<a href="<?php echo $term_link; ?>" class="book-list__title">
											<?php echo $child_category->name; ?>
										</a>
									</li>
									<!-- #post-<?php echo $child_category->term_id; ?> -->

								<?php
							endforeach;
							echo '<ul>';

						elseif ( ! get_the_archive_description() ) :

							echo '<ul class="book-list">';
							while ( have_posts() ) :
								the_post();
							?>

								<li id="post-<?php the_ID(); ?>" <?php post_class("book-list__item"); ?>>
									<a href="<?php the_permalink(); ?>" class="book-list__title">
										<?php the_title(); ?>
									</a>
								</li>
								<!-- #post-<?php the_ID(); ?> -->

							<?php
							endwhile;
							echo '<ul>';

						else :
							the_archive_description();
						endif;
						?>

                    </div>

					<?php get_template_part('template-parts/find-cost'); ?>

                </div>

				<?php // get_sidebar(); ?>
				<?php get_template_part('template-parts/sidebar'); ?>

            </div>
        </div>
    </div>

<?php
get_footer();