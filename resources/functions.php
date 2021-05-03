<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__ . '/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'options', 'search-route']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__) . '/config/assets.php',
            'theme' => require dirname(__DIR__) . '/config/theme.php',
            'view' => require dirname(__DIR__) . '/config/view.php',
        ]);
    }, true);



// add_action('after_setup_theme', 'crb_initialize_carbon_yoast');
// function crb_initialize_carbon_yoast()
// {
//     include_once __DIR__ . '/vendor/autoload.php';

//     new \Carbon_Fields_Yoast\Carbon_Fields_Yoast;
// }

// add_action('admin_enqueue_scripts', 'crb_enqueue_admin_scripts');
// function crb_enqueue_admin_scripts()
// {
//     wp_enqueue_script('crb-admin', get_stylesheet_directory_uri() . '/front/js/admin.js', array('carbon-fields-yoast'));
// }


/**
    Carbon fields google maps api key
 */

add_filter('carbon_fields_map_field_api_key', 'crb_get_gmaps_api_key');
function crb_get_gmaps_api_key($key)
{
    return 'AIzaSyAin6E-W7hwbYSlG2j7UrnaX-QX6YozQMU';
}



function get_block_template($template, $args)
{
    $template = App\locate_template([$template . ".blade.php", 'resources/views/blocks/' . $template . '.blade.php']);

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);

    $data = array_merge($data, $args);

    if ($template)
        echo App\template($template, $data);
    else
        echo sprintf(__("Template for block %s not found", 'my-theme'), $template);
}


// Pre get posts events archive

add_action('pre_get_posts', 'university_adjust_queries');

function university_adjust_queries($query)
{
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {

        $today = date('Y-m-d');

        // $query->set('meta_key', 'crb_event_date');
        $query->set('orderby', 'crb_event_date');
        $query->set('order', 'ASC');
        $query->set('meta_query', [
            [
                'crb_event_date' => [
                    'key' => 'crb_event_date',
                    'value'    => $today,
                    'compare'  => '>=',
                ]
            ]
        ]);
    }

    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {

        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }


    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {

        $query->set('posts_per_page', -1);
    }
}


function pageBanner($args = null)
{

    $crb_page_banner_subtitle = carbon_get_post_meta(get_the_ID(), 'crb_page_banner_subtitle');

    $crb_page_banner_image = carbon_get_post_meta(get_the_ID(), 'crb_page_banner_image');


    if (!$args['image']) {
        $crb_page_banner_image = carbon_get_post_meta(get_the_ID(), 'crb_page_banner_image');
        $args['image'] = wp_get_attachment_url($crb_page_banner_image, 'pageBanner');

        if (is_post_type_archive()) {
            $args['image'] = wp_get_attachment_url(carbon_get_theme_option('crb_page_banner_image'), 'pageBanner');
        } else {
            $args['image'] = get_template_directory_uri() . '/front/images/ocean.jpg';
        }

        if (is_post_type_archive('event')) {
            $args['image'] = wp_get_attachment_url(carbon_get_theme_option('crb_event_banner_image'), 'pageBanner');
        }

        if (is_post_type_archive('program')) {
            $args['image'] = wp_get_attachment_url(carbon_get_theme_option('crb_program_banner_image'), 'pageBanner');
        }

        if (is_post_type_archive('professor')) {
            $args['image'] = wp_get_attachment_url(carbon_get_theme_option('crb_professor_banner_image'), 'pageBanner');
        }

        if (is_home()) {
            $args['image'] = wp_get_attachment_url(carbon_get_theme_option('crb_block_banner_image'), 'pageBanner');
        }

        if (is_archive()) {
            $args['image'] = get_template_directory_uri() . '/front/images/ocean.jpg';
        }
    }

    if (!$args['title']) {
        $args['title'] = get_the_title();

        if (is_post_type_archive()) {
            $args['title'] = post_type_archive_title('', false);
        }


        if (is_home()) {
            $args['title'] = carbon_get_theme_option('crb_block_banner_title');
        }
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = $crb_page_banner_subtitle = carbon_get_post_meta(get_the_ID(), 'crb_page_banner_subtitle');

        if (is_post_type_archive('event')) {
            $args['subtitle'] = carbon_get_theme_option('crb_event_banner_subtitle');
        }

        if (is_post_type_archive('program')) {
            $args['subtitle'] = carbon_get_theme_option('crb_program_banner_subtitle');
        }

        if (is_post_type_archive('professor')) {
            $args['subtitle'] = carbon_get_theme_option('crb_professor_banner_subtitle');
        }

        if (is_post_type_archive('campus')) {
            $args['subtitle'] = carbon_get_theme_option('crb_campus_banner_subtitle');
        }

        if (is_home()) {
            $args['subtitle'] = carbon_get_theme_option('crb_block_banner_subtitle');
        }
    }

?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url( <?php echo $args['image'] ?> );"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <?php if ($args['subtitle']) : ?>
                <div class="page-banner__intro">
                    <p><?php echo $args['subtitle'] ?> </p>
                </div>
            <?php endif ?>
        </div>
    </div>


<?php
}


/**
    Add attributes to script tags
 */


add_filter('script_loader_tag', 'fictional_script_loader_tag', 10, 2);

function fictional_script_loader_tag($tag, $handle)
{

    // Добавляем атрибут async к зарегистрированному скрипту.
    if (wp_scripts()->get_data($handle, 'async')) {
        $tag = str_replace('></', ' async></', $tag);
    }
    if (wp_scripts()->get_data($handle, 'defer')) {
        $tag = str_replace('></', ' defer></', $tag);
    }

    return $tag;
}


/**
    Custom rest routes
 */

function fictional_custom_rest()
{

    register_rest_field('post', 'authorName', [
        'get_callback' => function () {
            return get_the_author();
        }
    ]);

    register_rest_field('note', 'noteCount', [
        'get_callback' => function () {
            return count_user_posts(get_current_user_id(), 'note');
        }
    ]);
}


add_action('rest_api_init', 'fictional_custom_rest');


// Redirect subscriber accounts out of admin and onto homepage

add_action('admin_init', 'redirect_subs_to_frontend');

function redirect_subs_to_frontend()
{
    $current_user = wp_get_current_user();

    if (
        count($current_user->roles) == 1 &&
        $current_user->roles[0] == 'subscriber'
    ) {

        wp_redirect(site_url('/'));

        exit();
    }
}


// Disable adminbar for subscriber account

add_action('wp_loaded', 'no_subs_adminbar');

function no_subs_adminbar()
{
    $current_user = wp_get_current_user();

    if (
        count($current_user->roles) == 1 &&
        $current_user->roles[0] == 'subscriber'
    ) {

        show_admin_bar(false);
    }
}


// Change login page url from wordpress to site url

add_filter('login_headerurl', 'fictional_headerurl');

function fictional_headerurl()
{
    return esc_url(site_url('/'));
}


add_filter('login_enqueue_scripts', 'fictional_login_css');


function fictional_login_css()
{

    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_style('main', get_stylesheet_uri());

    return esc_url(site_url('/'));
}


add_filter('login_headertitle', 'fictional_headertitle');

function fictional_headertitle()
{

    return get_bloginfo('name');
}

// Make note private_title_format

add_filter('wp_insert_post_data', 'fictional_make_note_private', 10, 2);

function fictional_make_note_private($data, $postarr)
{

    if ($data['post_type'] == 'note') {

        if (count_user_posts(get_current_user_id(), 'note') >= 4 && !$postarr['ID']) {

            die();
        }

        $data['post_title'] = sanitize_text_field(
            $data['post_title']
        );

        $data['post_content'] = sanitize_textarea_field(
            $data['post_content']
        );
    }


    if ($data['post_type'] == 'note' && $data['post_status'] !== 'trash') {

        $data['post_status'] = 'private';
    }

    return $data;
}


/**
 * Auto update themes & plugins
 */

add_filter('auto_update_plugin', '__return_true');
add_filter('auto_update_theme', '__return_true');
