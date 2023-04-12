	
		<footer class="footer">
            <div class="content">
                <div class="registration-bg"></div>
                <!-- <div class="registration registration_footer">

                    <div class="registration__content">
                        <div class="title">Твою роботу може якісно написати кандидат наук!</div>
                        <div class="after-title">Заповни цю форму і ти дізнаєшся вартість написання своєї роботи у <strong>розширеному калькуляторі цін</strong></div>
                        <form action="/" class="registration__form" id="registration-form">
                            <div class="form-item form-item_33">
                                <div class="label">Ім'я:</div>
                                <input type="text" name="name">
                            </div>
                            <div class="form-item form-item_33">
                                <div class="label">Е-мейл:</div>
                                <input type="email" name="email">
                            </div>
                            <div class="form-item form-item_button">
                                <button type="submit" class="button">Дізнатися вартість</button>
                            </div>
                            <div class="form-recapcha">
                                <div class="form-recapcha__title">Щоб продовжити, підтвердіть, що ви не робот:</div>
                                <div class="form-recapcha__body">
                                    <div id="g-recaptcha"></div>
                                </div>
                                <div class="form-recapcha__button">
                                    <button type="submit" class="button" disabled>Продовжити</button>
                                </div>
                            </div>
                        </form>
                        <div class="benefit">
                            <div class="benefit__item">
                                <figure class="benefit__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/benefit-1.svg" alt="">
                                </figure>
                                <div class="benefit__desc">Працюємо <br>офіційно</div>
                            </div>
                            <div class="benefit__item">
                                <figure class="benefit__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/benefit-2.svg" alt="">
                                </figure>
                                <div class="benefit__desc">Гарантуємо <br>конфіденційність</div>
                            </div>
                            <div class="benefit__item">
                                <figure class="benefit__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/benefit-3.svg" alt="">
                                </figure>
                                <div class="benefit__desc">Пишемо <br>без&nbsp;плагіату</div>
                            </div>
                            <div class="benefit__item">
                                <figure class="benefit__icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/benefit-4.svg" alt="">
                                </figure>
                                <div class="benefit__desc">100% <br>гарантія якості</div>
                            </div>
                        </div>
                    </div>
                    <div class="magistr-label magistr-label_big">
                        <span class="logo-magistr"></span>
                        <span>Агенство Магістр</span>
                    </div>
                </div> -->
                <div class="footer__row">
                    
                    <?php get_template_part('template-parts/lang-switcher'); ?>

                    <div class="footer__copyright"><?php echo get_field('copyright_footer', 'option')  . ' ' . date('Y'); ?></div>
                    <div class="footer__text"><span><?php the_field('txt_footer', 'option'); ?></span></div>
                </div>
            </div>
        </footer>
    </div>

    <div id="modal" class="modal">
        <span id="modal-close" class="modal-close">&times;</span>
        <img id="modal-content" class="modal-content">
        <!-- <div id="modal-caption" class="modal-caption"></div> -->
    </div>

    <!--
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script type="text/javascript">
        var verifyCallback = function(response) {
            $('.form-recapcha__button .button').removeAttr('disabled');
        };
        var expiredCallback = function(response) {
            $('.form-recapcha__button .button').attr('disabled', 'disabled');
        };
        var onloadCallback = function() {
            grecaptcha.render('g-recaptcha', {
                'sitekey': '6LfBPI4aAAAAADnN9MsthKgAkl7SBXFhKLW5TOmt',
                'callback': verifyCallback,
                'expired-callback': expiredCallback,
            });
        };
    </script>
	-->

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!-- <script src="js/jquery-3.6.0.min.js"></script> -->

	<?php // get_template_part('template-parts/modals/..'); ?>
	
	<?php wp_footer(); ?>

</body>

</html>
