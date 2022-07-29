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
        add_action('wp_ajax_wpcm_update_settings_data', ['Mails','update_settings_data']);
    }

    public static function admin_menu(){
        add_menu_page(
            "Mail",
            "Mail",
            "manage_options",
            "menu-mails",
            function(){
                $user = get_option('wpcm_user');
                $name = get_option('wpcm_name');
                $password = get_option('wpcm_password') ? 'nopermitidoverelpassword' : '';


                if( is_plugin_active('wp_custom_mail/wp_custom_mail.php')) {
                    echo Mails::send_email("elmoises.reyderey@gmail.com","prueba de email","hola moses como estas");
                }
                else {
                    echo "<h1>plugin no activo</h1>";
                }
                ?>
                    <div style="margin: 40px;">
                        <form id="wpcm_settings_form">
                        	<table>
                        		<tr>
                        			<th>Dirección de correo electrónico del remitente</th>
                        			<td>
		                                <input type="text" id="user" name="user" value="<?=$user;?>">                				
                        			</td>
                        		</tr>
                        		<tr>
                        			<th>Nombre del reminente</th>
                        			<td>
		                                <input type="text" id="name" name="name" value="<?=$name;?>">                				
                        			</td>
                        		</tr>
                        		<tr>
                        			<th>Contraseña</th>
                        			<td>
		                                <input type="password" id="password" name="password" value="<?=$password;?>">
                        			</td>
                        		</tr>
                        	</table>
                        	<div class="btn-container">
                            	<input type="button" name="btn" id="btn" value="enviar">
                        	</div>
                        </form>
                        <style type="text/css">
                            #wpcm_settings_form input[type='text'],
                            #wpcm_settings_form input[type='password'],
                            #wpcm_settings_form input[type='email'],
                            #wpcm_settings_form input[type='text']
                            {
                                width: 350px;
                            }
                            table {
                            	width: 100%;
                            }
                            table tr {
                                padding: 10px;
                                margin: 10px;
                            }
                        </style>
                        <script>
                            jQuery("#btn").click("click", function(){
                                jQuery.ajax({
                                    url: ajaxurl,
                                    method:'post',
                                    data:{
                                        action: 'wpcm_update_settings_data',
                                        user: jQuery('#user').val( ),
                                        name: jQuery('#name').val( ),
                                        password: jQuery('#password').val( )
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

    public static function wpcm_update_settings_data( ) {
        $user = $_POST['user'];
        $name = $_POST['name'];
        $password = $_POST['password'];

        update_option('wpcm_user', $user );
        update_option('wpcm_name', $name );
        update_option('wpcm_password', $password );
    }

    public static function send_email( $to, $subject, $body ){
        $user = get_option('wpcm_user');
        $name = get_option('wpcm_name');
        $password = get_option('wpcm_password');

        try{
            //Server settings
            $mail = new PHPMailer();    
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $user;       //omartinez1618@gmail.com           //SMTP username
            $mail->Password   = $password;   //'fhhynumuxgzfksmj';        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom( $user, $name );
            $mail->addAddress( $to );     

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
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