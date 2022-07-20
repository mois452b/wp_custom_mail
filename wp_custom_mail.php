<?php
/**
 * Plugin Name: Custom Mails
 * Plugin URI: https://kavavdigital.com
 * Description: 
 * Version: 6.7.0
 * Author: Octavio Martinez
 * Author URI: https://github.com/zenx5 
 * 
 */


require 'vendor/autoload.php';

 
register_activation_hook(__FILE__, 'wpcm__activation');
register_deactivation_hook(__FILE__, 'wpcm__deactivation');
add_action('init', ['Mails','init']);

