<?php 

/**
 * MyTheme's functions and definitions
 *
 * @package MyTheme
 * @since MyTheme 1.0
 */

/**
 * First, let's set the maximum content width based on the theme's
 * design and stylesheet.
 * This will limit the width of all uploaded images and embeds.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800; /* pixels */
}


if ( ! function_exists( 'mytheme_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various
	 * WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme
	 * hook, which runs before the init hook. The init hook is too late
	 * for some features, such as indicating support post thumbnails.
	 */
	function mytheme_setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be placed in the /languages/ directory.
		 */
		load_theme_textdomain( 'mytheme', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to <head>.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for two custom navigation menus.
		 */
		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'mytheme' ),
			'secondary' => __( 'Secondary Menu', 'mytheme' ),
		) );

		/**
		 * Enable support for the following post formats:
		 * aside, gallery, quote, image, and video
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video' ) );
	}
endif; // mytheme_setup
add_action( 'after_setup_theme', 'mytheme_setup' );


//bootstrap and css styles 

function load_css(){

    wp_register_style('bootstrap',get_template_directory_uri() . '/css/assets/bootstrap/bootstrap.min.css', array(),false,'all');
    wp_enqueue_style('bootstrap');

    // load main.css for all pages eg: header.php footer.php etc or we can have seperate files for header and footer
    wp_register_style('main',get_template_directory_uri() . '/css/main.css', array(),false,'all');
    wp_enqueue_style('main');

    // Load CSS specific to the homepage
    if (is_front_page()) {
        wp_enqueue_style('homepage-css', get_template_directory_uri() . '/css/assets/front-page.css');
    }

    // Load stylesheet for the cars post type archive page (e.g., http://localhost:8888/cars/)
    if (is_post_type_archive('cars')) {
        wp_enqueue_style('cars-archive-css', get_template_directory_uri() . '/css/assets/archive-cars.css');
    }

    // load seperate css file for taxonomy
    if (is_tax('brand')) {
        wp_enqueue_style('brand-taxonomy-css', get_template_directory_uri() . '/css/assets/brand.css');
    }

    // load single-cars.css file for single cars pages inside cars custom post type
    if (is_singular('cars')) {
        wp_enqueue_style('cars-single-css', get_template_directory_uri() . '/css/assets/single-cars.css');
    }

    // load css for templates pages

    // if (is_page_template('template-contact.php')) {
    //     wp_enqueue_style('template-contact', get_template_directory_uri() . '/css/contact.css');
    // }

    // Load CSS specific to the About page

    // if (is_page('about')) {
    //     wp_enqueue_style('about-css', get_template_directory_uri() . '/css/about.css');
    // }

}
add_action('wp_enqueue_scripts','load_css');


// bootstrap js, jquery , main.js

function load_js(){

    //  this line will automatically add all the jquery files needed automatically no need of js folders or files
    wp_enqueue_script('jquery'); 

    wp_register_script('bootstrap',get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery',false,true);
    wp_enqueue_script('bootstrap');

    wp_register_script('main',get_template_directory_uri() . '/js/main.js', 'jquery',false,true);
    wp_enqueue_script('main');

}
add_action('wp_enqueue_scripts','load_js');

///////

// Register Custom Post Type (Cars)

function register_car_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Cars',
            'singular_name' => 'Car',

        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array(
            'slug' => 'cars', // Base slug for cars
            'with_front' => false
        ),
        // 'publicly_queryable'    => true,
        'show_in_rest' => true // added so that posts can be accessed through REST api eg: http://localhost:8888/wp-json/wp/v2/cars
    );

    register_post_type('cars', $args);
}
add_action('init', 'register_car_post_type');


// Register Custom Taxonomy (Brands)
function register_car_brand_taxonomy() {
    $args = array(
        'labels' => array(
            'name' => 'Brands',
            'singular_name' => 'Brand',
        ),
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'brand'), // Base slug for brands
    );

    register_taxonomy('brand', array('cars'), $args);
}
add_action('init', 'register_car_brand_taxonomy');


// Adjust Permalink Structure to Include Brand
function cars_permalink_structure($post_link, $post) {
    if (is_object($post) && $post->post_type === 'cars') {
        $terms = wp_get_object_terms($post->ID, 'brand');
        if ($terms) {
            $term = $terms[0]; // Get the first brand term
            $val = "cars/$term->slug";
            $post_link = str_replace('cars', $val, $post_link);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'cars_permalink_structure', 10, 2);

// Add Custom Rewrite Rules
if (!function_exists('add_custom_rewrite_rules')) {
    function add_custom_rewrite_rules() {

            // Rule for brand archive (e.g., /cars/toyota/)
    add_rewrite_rule(
        '^cars/([^/]+)/?$',
        'index.php?taxonomy=brand&term=$matches[1]',
        'top'
    );
    
    // Rule for single car posts (e.g., /cars/toyota/innova/)
    add_rewrite_rule(
        '^cars/([^/]+)/([^/]+)/?$',
        'index.php?post_type=cars&brand=$matches[1]&name=$matches[2]',
        'top'
    );
    }
    add_action('init', 'add_custom_rewrite_rules');
}

// code to add acf fields to the REST api call 

function add_acf_to_rest_api() {
    // Check if ACF is installed and active
    if( !function_exists('get_field') ) return;

    // Hook into the REST API for the post type 'cars'
    register_rest_field('cars', 'acf_fields', array(
        'get_callback'    => function( $post ) {
            return get_fields( $post['id'] );
        },
        'schema'          => null,
    ));
}
add_action('rest_api_init', 'add_acf_to_rest_api');


?>





