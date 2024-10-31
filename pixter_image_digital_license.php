<?php
/*
Plugin Name: Image License and Protection
Plugin URI: http://www.pixter-media.com/wordpress
Description: The Smartest tool for publishers to protect their images on Wordpress sites, powered by Pixter.me, with a built in solution to sell image prints and license, at no extra hassle. The plugin places a button on the images, protecting the copy action, while offering a gallery of photo prints and image licensing.
Author: Pixter Media
Author URI: https://www.pixter.me
Text Domain: pixter-me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0

Copyright 2016 Pixter Media
*/

defined('ABSPATH') && defined('WPINC') || die;


require_once dirname(__FILE__) . '/shared_variables.php';
require_once dirname(__FILE__) . '/admin.php';
require_once dirname(__FILE__) . '/plugin_functions.php';

function plugins_loaded_pixter_image_digital_license()
{
    p1xtr_pixter_image_digital_license_plugin_loaded('pixter_image_digital_license');
}

add_action('plugins_loaded', 'plugins_loaded_pixter_image_digital_license', 999999);

function pixter_image_digital_license_activate()
{
    p1xtr_pixter_image_digital_license_activate('pixter_image_digital_license');
}

register_activation_hook(__FILE__, 'pixter_image_digital_license_activate');

function pixter_image_digital_license_activation_redirect($plugin)
{
    p1xtr_pixter_image_digital_license_activation_redirect($plugin , 'pixter_image_digital_license');
}

add_action('activated_plugin', 'pixter_image_digital_license_activation_redirect');


//	function pixter_image_digital_license_init()
//	{
//		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
//	//	wp_enqueue_script( 'pixter-me-global', 'http://ddd.rrr.com/x.js', array(), '0.1', true );
//	}
//	add_action( 'init', 'pixter_image_digital_license_init');

function show_pixter_image_digital_license()
{
    return p1xtr_pixter_image_digital_license_show_plugin('pixter_image_digital_license');
}

function pixter_image_digital_license_inline_script()
{
    p1xtr_pixter_image_digital_license_inline_script('pixter_image_digital_license');
}

add_action('wp_footer', 'pixter_image_digital_license_inline_script', 99999);


function pixter_image_digital_license_register_notice()
{
    p1xtr_pixter_image_digital_license_register_notice('pixter_image_digital_license', 'Image License and Protection');
}

add_action('admin_notices', 'pixter_image_digital_license_register_notice');


/***
 * Added By Itay 20/9/2016
 */


function pixter_image_digital_license_toggle_psk_notice()
{
    p1xtr_pixter_image_digital_license_psk_notice('pixter_image_digital_license', 'PLUGIN_OFFICAL_NAME');
}

add_action('admin_notices', 'pixter_image_digital_license_toggle_psk_notice');


function pixter_image_digital_license_eventStage($url)
{
    $data = array(
        "storename" => get_bloginfo('name'),
        "website" => get_home_url(),
        "lang" => get_bloginfo('language'),
        "uid" => get_option('p1xtr_uid'),
        "plugin_uid" => get_option('pixter_image_digital_license_uid'),
        "plugin_ver" => get_option('pixter_image_digital_license_ver'),
        "plugin_db_ver" => get_option('pixter_image_digital_license_db_ver'),
        "wp_ver" => get_bloginfo('version'),
        "php_ver" => phpversion(),
    );
    $data_string = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    //execute post
    $result = trim(curl_exec($ch));

    curl_close($ch);

    return $result;

}

function pixter_image_digital_license_active()
{
    $pixter_image_digital_license_user = get_option('pixter_image_digital_license_user');
    global $pixter_image_digital_license_admin_tools;

    $pixter_image_digital_license_admin_tools->init_options();

    $apiUrl = P1XTR_API_BASE_URL . "/api/v2/publisher/activate_wp?user=wp&api_key=" . get_option('pixter_image_digital_license_user') . "&plugin_name=" . "pixter_image_digital_license";

    pixter_image_digital_license_eventStage($apiUrl);

    if(empty($pixter_image_digital_license_user)){
        $pixter_image_digital_license_admin_tools->registerGuestUser();
    }

}

register_activation_hook(__FILE__, 'pixter_image_digital_license_active');


function pixter_image_digital_license_deactivation()
{
    $apiUrl = P1XTR_API_BASE_URL . "/api/v2/publisher/deactivate_wp?user=wp&api_key=" . get_option('pixter_image_digital_license_user') . "&plugin_name=" . "pixter_image_digital_license";

    pixter_image_digital_license_eventStage($apiUrl);
}

register_deactivation_hook(__FILE__, 'pixter_image_digital_license_deactivation');



