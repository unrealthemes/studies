<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package unreal-themes
 */

get_header();
?>

	<main class="main">
		<div class="content">
			<div class="error-body text-center">
				<h1 class="text-danger">404</h1>
				<h3><?php _e('Page not found!', 'studies'); ?></h3>
				<p>
					<a href="<?php echo home_url(); ?>" class="btn-danger">
						<?php _e('Return to the main page', 'studies'); ?>
					</a>
				</p>
			</div>
		</div>
	</main>

<?php
get_footer();
