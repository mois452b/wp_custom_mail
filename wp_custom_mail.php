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

function send_mail( ) {
	wp_mail('elmoises.reyderey@gmail.com', 'Prueba de envio de email', 'enviando un email a travez de wp_mail() de wordpress');
}

add_action( 'init', 'send_mail' );

function configuracion_smtp( $phpmailer ){
    $phpmailer->isSMTP(); 
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 25;
    $phpmailer->Username = 'moisesgabrielrodriguezruiz@gmail.com';
    $phpmailer->Password = '30810280';
    $phpmailer->SMTPSecure = false;
    $phpmailer->From = 'moisesgabrielrodriguezruiz@gmail.com';
    $phpmailer->FromName='Moises rodriguez';
    $phpmailer->AddAddress='elmoises.reyderey@gmail.com';
    $phpmailer->Subject='prueba de email';
    $phpmailer->Body='enviando email por medio de phpmailer';
    $phpmailer->AltBody='enviando email por medio de phpmailer';
	
	
}

add_action( 'phpmailer_init', 'configuracion_smtp' );