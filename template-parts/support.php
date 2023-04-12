<?php if ( get_field('show_support', 'option') ) : ?>

    <div class="support">
        <div class="content support__content">
            <div class="support__text"><?php the_field('txt_support', 'option'); ?></div>
            <div class="support__logo logo-magistr"></div>
        </div>
    </div>

<?php endif; ?>