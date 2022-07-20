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
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;

include 'class_wp_custom_mail.php';

register_activation_hook(__FILE__, array('WP_custom_mail', 'wpcm__activation'));
register_deactivation_hook(__FILE__, array('WP_custom_mail', 'wpcm__deactivation'));
add_action('init', array('WP_custom_mail', 'init'));

