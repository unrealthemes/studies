<?php
/**
 * Template name: Home
 */

get_header(); 

$parent_cats = get_field('tabs_parent_cats_home');

if (have_posts()) : 

    while (have_posts()) : the_post(); 
    ?>

        <div class="offer">
            <div class="content">
                <nav class="category-nav">
                    <ul class="category-nav__menu">

                        <?php if ( have_rows('parent_cats_home') ) : ?>

                            <?php while ( have_rows('parent_cats_home') ) : the_row(); ?>

                                <li>
                                    <a href="<?php the_sub_field('link_parent_cats_home'); ?>">
                                        <span>
                                            <img src="<?php the_sub_field('img_parent_cats_home'); ?>" alt=""> 
                                            <?php the_sub_field('txt_parent_cats_home'); ?>
                                        </span>
                                    </a>
                                </li>

                            <?php endwhile; ?>

                        <?php endif; ?>

                        <li class="category-nav__other">
                            <a href="<?php the_field('link_home'); ?>">
                                <?php the_field('txt_link_home'); ?>
                                <span class="icon-arrow-long icon-arrow"></span>
                            </a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>

        <?php get_template_part('template-parts/support'); ?>

        <main class="main">
            <div class="content">
                <div class="search">
                    <div class="search__content">
                        <div class="search__title title"><?php the_field('title_search_home'); ?></div>
                        <form class="search__form" id="search-form" role="search" method="get" action="<?php echo home_url( '/' ) ?>">
                            <input type="search" 
                               value="<?php echo get_search_query() ?>"  
                               name="s" 
                               id="s" class="hsearch__input" 
                               placeholder="<?php echo __('Search', 'studies'); ?>"
                               required>
                            <button type="submit" class="search__button icon-search"></button>
                        </form>
                    </div>
                </div>

                <?php get_template_part('template-parts/find-cost'); ?>
                
                <?php if ( $parent_cats ) : ?>

                    <div class="categories-preview">
                        <div class="categories-preview__list">
                            <div class="cat-tub">
                                <div class="cat-tub__current"></div>
                                <ul class="cat-tub__dropdown">

                                    <?php 
                                    foreach ( (array)$parent_cats as $key => $parent_cat ) : 
                                        $term_link = get_term_link( $parent_cat->term_id, $parent_cat->taxonomy );
                                    ?>

                                        <li>
                                            <a href="<?php echo $term_link; ?>" class="cat-tub__item" data-cat="<?php echo $key; ?>">
                                                <?php echo $parent_cat->name; ?>
                                            </a>
                                        </li>

                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                        <div class="categories-preview__content">

                            <?php 
                            foreach ( (array)$parent_cats as $key => $parent_cat ) : 
                                $child_cats = get_terms( 
                                    $parent_cat->taxonomy, 
                                    [
                                        'parent' => $parent_cat->term_id, 
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                        'hide_empty' => false
                                    ] 
                                );
                            ?>

                                <?php if ( $term_link ) : ?>

                                    <div class="categories-preview__item" data-cat="<?php echo $key; ?>">
                                        <ul class="book-list book-list_showfirst7">

                                            <?php 
                                            foreach ( (array)$child_cats as $ch_key => $child_cat ) : 
                                                // $term_link = get_term_link( $child_cat->term_id, $child_cat->taxonomy );
                                                $term_link = ut_help()->redirects->generate_term_link($child_cat);
                                            ?>  

                                                <li class="book-list__item">
                                                    <a href="<?php echo $term_link; ?>" class="book-list__title">
                                                        <?php echo $child_cat->name; ?>
                                                    </a>
                                                </li>

                                            <?php endforeach; ?>

                                        </ul>
                                        <div class="book-list-more">
                                            <a  href="#" 
                                                class="link-style js-show-all-books" 
                                                data-show="<?php echo __('Show more', 'studies'); ?>" 
                                                data-hide="<?php echo __('Hide', 'studies'); ?>">
                                            <?php echo __('Show more', 'studies'); ?>
                                            </a>
                                        </div>
                                    </div>

                                <?php endif; ?>

                            <?php endforeach; ?>
                            
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </main>

    <?php
    endwhile; 

endif; 

get_footer();