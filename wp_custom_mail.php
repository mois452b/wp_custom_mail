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
 // use PHPMailer\PHPMailer\PHPMailer;
 // use PHPMailer\PHPMailer\SMTP;
 // use PHPMailer\PHPMailer\Exception;

register_activation_hook(__FILE__, array('WP_custom_mail', 'wpcm__activation'));
register_deactivation_hook(__FILE__, array('WP_custom_mail', 'wpcm__deactivation'));
add_action('init', array('WP_custom_mail', 'init'));

class WP_custom_mail{
    public static function init( ) {
        add_action('admin_menu', array('WP_custom_mail', 'wpcm_admin_menu'));
        add_action('wp_ajax_wpcm_send_mail', array('WP_custom_mail', 'wpcm_send_mail'));
    }

    public static function wpcm__activation(){

    }

    public static function wpcm__deactivation(){
        
    }

    public static function wpcm_admin_menu(){

        add_menu_page(
            "Mail",
            "Mail",
            "manage_options",
            "menu-mails",
            function(){
                ?>
                    <div style="margin: 40px;">
                        <form>
                            <div>
                                <label>Dirección de correo electrónico del remitente</label>
                                <input type="text" name="user">
                            </div>
                            <div>
                                <label>Nombre del remitente</label>
                                <input type="text" name="name">
                            </div>
                            <div>
                                <label>Contraseña</label>
                                <input type="password" name="password">
                            </div>
                            <input type="submit" name="btn">
                        </form>
                        <style type="text/css">
                            #swpsmtp_settings_form input[type='text'],
                            #swpsmtp_settings_form input[type='password'],
                            #swpsmtp_settings_form input[type='email'],
                            #swpsmtp_settings_form input[type='text']
                            {
                                width: 350px;
                            }
                        </style>
                        <script>
                            jQuery("#btn").click("click", function(){
                                jQuery.ajax({
                                    url: ajaxurl,
                                    method:'post',
                                    data:{
                                        action: 'wpcm_send_mail'
                                    },
                                    success: function(response){
                                        console.log(response);
                                    }
                                });
                            })
                        </script>
                    </div>

                <?php
            },
            "",
            6
        );
    }

    public static function wpcm_send_mail(){
        $mail = new wp_custom_mail( );
        try {
            $mail->user( 'omartinez1618@gmail.com', 'omartinez1618@gmail.com' );
            $mail->host('smtp.gmail.com');
            $mail->port(465);

            $mail->to('elmoises.reyderey@gmail.com');
            $mail->subject('hola moises');
            $mail->body('ejemplo de boy');
            // $mail->send( );

            echo 'Message has been sent correctamente';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        wp_die();
    }
}