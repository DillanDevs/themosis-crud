<?php

use Themosis\Core\Application;


$theme = Application::getInstance()->loadTheme(__DIR__, 'config');


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('themosis-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script('rut-validate', get_stylesheet_directory_uri() . '/assets/js/rut-validate.js', [], null, true);
});


add_action('after_setup_theme', function () {
    $menus = config('menus');
    $translated = [];
    foreach ($menus as $loc => $label) {
        $translated[$loc] = __($label, THEME_TD);
    }
    register_nav_menus($translated);
});

add_action('after_setup_theme', function () {
    $sidebars = config('sidebars');
    foreach ($sidebars as $args) {
        $args['name'] = __($args['name'], THEME_TD);
        $args['description'] = __($args['description'], THEME_TD);
        register_sidebar($args);
    }
});

$theme->assets([$theme->getPath('dist') => $theme->getUrl('dist')]);
$theme->views($theme->config('theme.views', []));
$theme->providers($theme->config('theme.providers', []));
$theme->includes([$theme->getPath('inc')]);
$theme->images($theme->config('images'));
$theme->menus($theme->config('menus'));
$theme->sidebars($theme->config('sidebars'));
$theme->support($theme->config('support', []));
$theme->templates($theme->config('templates', []));

