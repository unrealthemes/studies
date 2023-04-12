<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Blogfi
 */

get_header(); 
?>

	<?php get_template_part('template-parts/support'); ?>

    <div class="main">
        <div class="content">
            
			<div class="breadcrumbs">
				<?php do_action( 'echo_kama_breadcrumbs' ); ?>
            </div>

            <div class="main__row">
                <div class="main__content" id="main">

                    <div class="main__search">
						<form class="search-form" id="search-form" role="search" method="get" action="<?php echo home_url( '/' ) ?>" novalidate="novalidate">
							<input  type="search" 
									value="<?php echo get_search_query() ?>"  
									name="s" 
									class="search-form__input"
									id="s" class="header-search__input" 
									placeholder="<?php echo __('Search', 'studies'); ?>"
									required>
                            <button type="submit" class="search-form_button icon-search"></button>
                        </form>
                    </div>

                    <div class="search-result">

						<?php 
						if ( have_posts() ) : 
							while ( have_posts() ) :
								the_post();
							?>
								
								<div class="search-result__item">
									<a href="<?php the_permalink(); ?>" class="search-result__title">
										<?php the_title(); ?>
									</a>
									<div class="search-result__desc">
										<p><?php the_excerpt(); ?></p>
									</div>
								</div>

							<?php
							endwhile;
						endif;
						?>

                    </div>
					
					<?php 
						the_posts_pagination(
							[
								'end_size' => 3,   
								'mid_size' => 2,
							]
						);
					?>

                </div>
                
				<?php // get_sidebar(); ?>
				<?php get_template_part('template-parts/sidebar'); ?>

            </div>
        </div>
    </div>

<?php
get_footer();
