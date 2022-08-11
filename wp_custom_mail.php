<?php
/**
 * Plugin Name: Versatil Custom Mail SwA
 * Plugin URI: https://github.com/zenx5/wp_custom_mail
 * Description: Complemento para Swastarkencl
 * Version: 1.0.0
 * Author: Octavio Martinez
 * Author URI: https://github.com/zenx5 
 * 
 */


require 'vendor/autoload.php';
 
register_activation_hook(__FILE__, ['Mails','activation']);
register_deactivation_hook(__FILE__, ['Mails','deactivation']);
add_action('init', ['Mails','init']);

