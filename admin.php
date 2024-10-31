<?php
defined('ABSPATH') && defined('WPINC') || die;

require_once dirname(__FILE__) . '/admin-page-class/admin-page-class.php';
require_once dirname(__FILE__) . '/shared_variables.php';
require_once dirname(__FILE__) . '/admin_functions.php';

global $pixter_image_digital_license_admin_tools;
$pixter_image_digital_license_admin_tools = new p1xtr_pixter_image_digital_license_admin_tools('pixter_image_digital_license');
$pixter_image_digital_license_user = get_option('pixter_image_digital_license_user');

//if (empty($pixter_image_digital_license_user)) {
add_action('wp_ajax_register_pixter_image_digital_license_user', 'register_pixter_image_digital_license_user');

function register_pixter_image_digital_license_user()
{
    $isGuest = false;
    global $pixter_image_digital_license_admin_tools;
    $pixter_image_digital_license_admin_tools->register_user($isGuest);
    //p1xtr_pixter_image_digital_license_register_user('pixter_image_digital_license');
}

function pixter_image_digital_license_admin_page_register()
{
    p1xtr_pixter_image_digital_license_admin_page_register('pixter_image_digital_license', 'Image License and Protection');
}

add_action('pixter_image_digital_license_admin_page_class_display_register_page', 'pixter_image_digital_license_admin_page_register');
//}else{
function pixter_image_digital_license_admin_before_page()
{
    p1xtr_pixter_image_digital_license_admin_before_page('pixter_image_digital_license');
}

add_action('pixter_image_digital_license_admin_page_class_before_page', 'pixter_image_digital_license_admin_before_page');


//}
/**
 * configure your options page
 */
$config = array(
    'menu' => array('top' => 'Image License and Protection' .' settings'),
    'page_title' => 'Image License and Protection',
    'page_header_text' => 'Here you can find configurations to your Pixter.me buttons, please also check your account on <a target="_blank" href="https://publishers.pixter.me/app/">Pixter.me</a> for more details.',
    'capability' => 'install_plugins',
    'option_group' => 'pixter_image_digital_license' .'_options',
    'id' => 'pixter_image_digital_license' .'_plugin',
    'fields' => $p1xtr_pixter_image_digital_license_fields,
    'icon_url' => plugins_url('admin-icon.png', __FILE__),
    'position' => 82,
    'pixter_image_digital_license' => 'pixter_image_digital_license',
);
$options_panel = new BF_Admin_Page_Class($config);
