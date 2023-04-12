<?php

/**
 * Get instance of helper
 */
function ut_help() {
  return UT_Theme_Helper::get_instance();
}

/**
 * Main class of all tehe,e settings
 */
class UT_Theme_Helper {

  private static $_instance = null;

  public $redirects;
  public $breadcrumbs;
  public $nav_menu;
  public $search;

  private function __construct() {

  }

  protected function __clone() {

  }

  static public function get_instance() {

  	if ( is_null( self::$_instance ) ) {
  	  self::$_instance = new self();
  	}
  	return self::$_instance;
  }

  /**
   * Load files, plugins, add hooks and filters and do all magic
   */
  function init() {

  	// load needed files
  	$this->import();
  	$this->load_classes();
  	$this->register_hooks();

  	return $this;
  }

  function load_classes() {

  	$this->redirects = UT_Redirects::get_instance();
  	$this->breadcrumbs = UT_Breadcrumbs::get_instance();
  	$this->nav_menu = UT_Nav_Menu::get_instance();
  	$this->search = UT_Search::get_instance();
  }

  /**
   * Register all needed hooks
   */
  public function register_hooks() {

  	add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts_n_styles' ] );
  	add_action( 'after_setup_theme',  [ $this, 'register_menus' ] );
  	add_action( 'after_setup_theme',  [ $this, 'add_theme_support' ] );

	add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
	// remove_filter( 'the_content', 'wpautop' );
  }

  function register_menus() {

  	register_nav_menus( [
  	  'menu_1' => esc_html__( 'Header', 'unreal-theme' ),
  	  'menu_2' => esc_html__( 'Footer', 'unreal-theme' ),
  	] );
  }

  public function add_theme_support() {

  	add_theme_support( 'title-tag' );
  	add_theme_support( 'post-thumbnails' );
  	add_theme_support( 'html5', [
  	  'search-form',
  	  'comment-form',
  	  'comment-list',
  	  'gallery',
  	  'caption',
  	] );
  	add_theme_support( 'woocommerce' );

	if ( function_exists('acf_add_options_page') ) {
		acf_add_options_page(
			[
				'page_title'    => 'Налаштування теми',
				'menu_title'    => 'Налаштування теми',
				'menu_slug'     => 'theme-general-settings',
				'capability'    => 'edit_posts',
				'redirect'      => false
			]
		);
	}
  }

  function load_scripts_n_styles() {
  	// ========================================= CSS ========================================= //
  	wp_enqueue_style( 'ut-style', get_stylesheet_uri() );
  	wp_enqueue_style( 'ut-woo', get_template_directory_uri() . '/styles/style.css' );
  	// wp_enqueue_style( 'ut-fancyboxcss', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css' );
  	// ========================================= JS ========================================= //
  	//////////////////////////////////////
  	wp_deregister_script('jquery-core');
  	wp_register_script('jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', false, null, true);
  	wp_deregister_script('jquery');
  	wp_register_script('jquery', false, array('jquery-core'), null, true);
  	//////////////////////////////////////
  	wp_enqueue_script( 'ut-slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), date("Ymd"), true );
  	wp_enqueue_script( 'ut-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), date("Ymd"), true );
  	wp_enqueue_script( 'ut-nice-select', get_template_directory_uri() . '/js/jquery.nice-select.min.js', array('jquery'), date("Ymd"), true );
  	wp_enqueue_script( 'ut-main', get_template_directory_uri() . '/js/main.js', array('jquery'), date("Ymd"), true );
  	// wp_enqueue_script( 'ut-fancyboxjs', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('ut-main'), date("Ymd"), true );

  }

  public function add_async_defer_attr( $tag, $handle, $src ) {

    if ( 'ut-googleapis' === $handle ) {
      return str_replace( ' src', ' async defer src', $tag );
    }

    return $tag;
  }

  public function import() {

  	include_once 'class.redirects.php';
  	// include_once 'class.table-of-content.php';
  	include_once 'template-functions.php';
  	include_once 'class.breadcrumbs.php';
  	include_once 'class.nav-menu.php';
  	include_once 'class.search.php';
  }

}
