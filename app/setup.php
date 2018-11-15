<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2018-10-24
 * Time: 10:10
 */

require_once get_template_directory() . '/vendor/autoload.php';

define('BADUBED_VERSION', '1.0.1');
define('BADUBED_TRANSLATION_STRING', 'badubed');

if ( ! function_exists( 'badubed_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function badubed_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Badubed, use a find and replace
		 * to change 'badubed' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( BADUBED_TRANSLATION_STRING, get_template_directory() . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', BADUBED_TRANSLATION_STRING ),
		) );
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'badubed_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'badubed_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function badubed_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'badubed_content_width', 1140 );
}
add_action( 'after_setup_theme', 'badubed_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function badubed_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', BADUBED_TRANSLATION_STRING ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', BADUBED_TRANSLATION_STRING ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'badubed_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function badubed_scripts() {
	wp_enqueue_style( 'badubed-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'main', get_template_directory_uri() . '/dist/scripts/main.js', ['jquery'], null, true );
	
	wp_enqueue_script( 'badubed-navigation', get_template_directory_uri() . '/dist/scripts/navigation.js', [], '20151215', true );
	
	wp_enqueue_script( 'badubed-skip-link-focus-fix', get_template_directory_uri() . '/dist/scripts/skip-link-focus-fix.js', [], '20151215', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'badubed_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Updater code, to automate updates from GitHub
 */
require_once get_template_directory() . '/updates/plugin-update-checker.php';

$updater = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/DoedeJaarsmaCommunicatie/Badubed/',
	get_template_directory() . '/functions.php',
	'djcee'
);

$updater->setBranch('master');

/**
 * Require certain plugins
 */

require_once get_template_directory() . '/app/helpers/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'badubed_register_required_plugins');

function badubed_register_required_plugins() {
	$plugins = [
		[
			'name'               => 'DJC Extending Elementor', // The plugin name.
			'slug'               => 'djcee', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/app/helpers/plugins/djcee.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		],
		[
			'name'      =>  'Elementor',
			'slug'      =>  'elementor',
			'required'  =>  true,
		]
	];
	
	$config = [
		'id'            =>  BADUBED_TRANSLATION_STRING,
		'menu'          =>  'tgmpa-install-plugins',
		'parent_slug'   =>  'themes.php',            // Parent menu slug.
		'capability'    =>  'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'   =>  true,                    // Show admin notices or not.
		'dismissable'   =>  true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'   =>  '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'  =>  false,                   // Automatically activate plugins after installation or not.
		'message'       =>  '',                      // Message to output right before the plugins table.
	];
	
	tgmpa( $plugins, $config);
}


$timber = new Timber\Timber();