<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;


/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('custom-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('styles', get_template_directory_uri() . '/front/bundled-assets/styles.fb206ecfa1f6ed23e277.css', null);

    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAin6E-W7hwbYSlG2j7UrnaX-QX6YozQMU', null, '1.0', true);
    // wp_script_add_data( 'googleMap', 'async', true );
    wp_script_add_data('googleMap', 'defer', true);

    wp_enqueue_script('vendors', get_template_directory_uri() . '/front/bundled-assets/vendors~scripts.8c97d901916ad616a264.js', null, '1.0', true);
    // wp_script_add_data( 'vendors', 'async', true );
    wp_script_add_data('vendors', 'defer', true);

    wp_enqueue_script('main', get_template_directory_uri() . '/front/bundled-assets/scripts.fb206ecfa1f6ed23e277.js', null, '1.0', true);
    // wp_script_add_data( 'main', 'async', true );
    wp_script_add_data('main', 'defer', true);


    wp_localize_script('main', 'fictionalUniversityData', [
        'rootUrl' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);

    // if (is_single() && comments_open() && get_option('thread_comments')) {
    //     wp_enqueue_script('comment-reply');
    // }


}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */

    register_nav_menus([
        'primary_navigation' => __('Header menu', 'sage'),
        'footer_location_1' => __('Footer location 1', 'sage'),
        'footer_location_2' => __('Footer location 2', 'sage')

    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    add_image_size('profLandscape', 400, 260, true);
    add_image_size('profPortrait',  480, 650, true);
    add_image_size('pageBanner',  1500, 350, true);




    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });


    // Carbon fields
    collect(glob(config('theme.dir') . '/app/fields/*.php'))
        ->map(function ($field) {
            return require_once($field);
        });


    // Carbon blocks
    collect(glob(config('theme.dir') . '/app/fields/blocks/*.php'))
        ->map(function ($field) {
            return require_once($field);
        });
});
