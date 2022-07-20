<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mails{
    
    public static function activation(){

    }

    public static function deactivation(){
        
    }

    public static function init(){
        add_action('admin_menu', ['Mails','admin_menu']);
        add_action('wp_ajax_wpcm_send_email', ['Mails','send_email']);
    }

    public static function admin_menu(){
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
                                        action: 'wpcm_send_email'
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

    public static function send_email2(){
        echo "hola";
        wp_die();
    }

    public static function send_email(){
        try{
            //Server settings
            $mail = new PHPMailer();    
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'omartinez1618@gmail.com';                  //SMTP username
            $mail->Password   = 'fhhynumuxgzfksmj';       //vsgweaowshtdgxdh        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom( get_option('admin_email') , 'Octavio J Martinez');
            $mail->addAddress('omartinez1618@gmail.com', 'Octavio Martinez');     
        
            //Content
            ob_start( );
            include WP_PLUGIN_DIR.'/wp_custom_mail/template/index.html';
            $body = ob_get_contents( );
            ob_end_clean();
            //echo $body;

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject 2';
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        }
        catch(Exception $e){
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        wp_die();
    }

}