<?php

/**
 * Register Widget
 */

add_action('elementor/widgets/register', function ($widgets_manager) {

    $file = get_stylesheet_directory()
        . '/app/elementor/widgets/rio-marquee/class-rio-marquee.php';

    if (file_exists($file)) {
        require_once $file;
        $widgets_manager->register(new \Rio_Marquee_Widget());
    } else {
        error_log('Rio-Marquee widget file not found: ' . $file);
    }
});

add_action('wp_enqueue_scripts', function () {
    wp_register_style('rio-marquee', get_stylesheet_directory_uri(). '/app/elementor/widgets/rio-marquee/marquee.css');
    wp_register_script('rio-marquee', get_stylesheet_directory_uri(). '/app/elementor/widgets/rio-marquee/marquee.js', [], false, true);
});
