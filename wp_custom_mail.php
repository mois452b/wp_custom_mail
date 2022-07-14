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

register_activation_hook(__FILE__, 'wpcm__activation');
register_deactivation_hook(__FILE__, 'wpcm__deactivation');
add_action('admin_menu', 'wpcm_admin_menu');
add_action('wp_ajax_wpcm_send_mail', 'wpcm_send_mail');

function wpcm__activation(){

}

function wpcm__deactivation(){
    
}

function wpcm_admin_menu(){

    add_menu_page(
        "Mail",
        "Mail",
        "manage_options",
        "menu-mails",
        function(){
            ?>
                <div style="margin: 40px;">
                    <button id="btn" class="button button-primary">Send Mail</button>
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

function wpcm_send_mail(){
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'omartinez1618@gmail.com';                  //SMTP username
        $mail->Password   = 'fhhynumuxgzfksmj';       //vsgweaowshtdgxdh        //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('omartinez1618@gmail.com', 'Octavio Martinez');
        $mail->addAddress('elmoises.reyderey@gmail.com', 'Moises Rodriguez');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        ob_start( );
        include WP_PLUGIN_DIR.'/wp_custom_mail/template/index.html';
        $body = ob_get_contents( );
        ob_end_clean( );
        echo $body;

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject 2';
        $mail->Body    = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    wp_die();
}