<?php if ( get_field('show_widget', 'option') ) : ?>

    <aside class="main__aside aside" id="aside">
        <div class="aside__content">
            <div class="aside__title"><?php the_field('title_widget', 'option'); ?></div>

            <?php if ( have_rows('blocks_widget', 'option') ) : ?>

                <div class="table-price">

                    <?php while ( have_rows('blocks_widget', 'option') ) : the_row(); ?>
        
                        <a href="<?php the_sub_field('link_blocks_widget'); ?>" class="table-price__item">
                            <span class="table-price__title"><?php the_sub_field('txt_blocks_widget'); ?></span>
                            <span class="table-price__price"><?php the_sub_field('val_blocks_widget'); ?></span>
                        </a>

                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

            <div class="guarantee">
                <div class="guarantee__head"><?php the_field('val_g_widget', 'option'); ?></div>
                <div class="guarantee__title"><?php the_field('title_g_widget', 'option'); ?></div>
                <div class="guarantee__desc"><?php the_field('desc_g_widget', 'option'); ?></div>
                <div class="guarantee__text"><?php the_field('txt_g_widget', 'option'); ?></div>
            </div>
        </div>
    </aside>

<?php endif; ?>