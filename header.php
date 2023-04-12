<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
      "logo": "<?php the_field('logo_header', 'option'); ?>"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Library",
        "name": "Студентська бібліотека Studies",
        "address": {
        "@type": "PostalAddress",
        "streetAddress": "Болсуновська 13-15",
        "addressLocality": "Київ",
        "addressRegion": "UK",
        "postalCode": "01014"
    },
        "image": "<?php echo esc_url( site_url() ); ?>/wp-content/uploads/studies.png",
        "email": "info@studies.in.ua",
        "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "openingHours": "Mo,Tu,We,Th,Fr 07:00-20:00",
        "openingHoursSpecification": [ {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday"
            ],
            "opens": "07:00",
            "closes": "20:00"
        } ],
        "priceRange":"$"

    }
    </script>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">

        <header class="header">
            <div class="content header__content">
                <nav class="header__nav header-nav">
                    <div class="header-nav__toggle">
                        <div class="icon-menu">
                            <div class="sw-topper"></div>
                            <div class="sw-bottom"></div>
                            <div class="sw-footer"></div>
                        </div>
                    </div>
                    <div class="header-nav__dropdown">
						<?php
							if ( has_nav_menu('menu_1') ) {
								wp_nav_menu( [
									'theme_location' => 'menu_1',
									'container'      => false,
									'menu_class'     => 'header-nav__menu',
									'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								] );
							}
						?>
                    </div>
                </nav>

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo header__logo">
                    <img src="<?php the_field('logo_header', 'option'); ?>" alt="">
                </a>

                <?php if ( is_page_template('template-home.php') ) : ?>
                    <h1 class="header__title"><?php the_field('txt_header', 'option'); ?></h1>
                <?php else : ?>
                    <div class="header__title"><?php the_field('txt_header', 'option'); ?></div>
                <?php endif; ?>

                <div class="header__search header-search">
                    <form class="header-search__form" id="search-header" role="search" method="get" action="<?php echo home_url( '/' ) ?>">
                        <a href="#" class="header-search__close"></a>
                        <input type="search" 
                               value="<?php echo get_search_query() ?>"  
                               name="s" 
                               id="s" class="header-search__input" 
                               placeholder="<?php echo __('Search', 'studies'); ?>"
                               required>
                        <button type="submit" class="header-search__button icon-search"></button>
                    </form>
                    <a href="#" class="header-search__toggle icon-search"></a>
                </div>
                
            </div>
        </header>