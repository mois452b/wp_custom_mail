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
        add_action('wp_ajax_wpcm_update_settings_data', ['Mails','wpcm_update_settings_data']);
        add_action('wp_ajax_wpcm_send_email_test', ['Mails','send_email_test']);
        add_action( 'swastarkencl_issuance_saved', ['Mails', 'swastarkencl_issuance_saved'] );
    }

    public static function swastarkencl_issuance_saved($issuance, $from_status, $to_status){
        if(true) {
            $full_name = $issuance->receiver_names.' '.$issuance->receiver_paternal;
            $order_id = $issuance->order_id;
            $reference_issuance = $issuance->freight_order;
            $link_tracking = "https://starkencl.com/".$reference_issuance;
            ob_start();
            include '../template/en_transito.php';
            $content = ob_get_contents();
            ob_end_clean();
            Mails::send_email( $issuance->receiver_email ,"En Transito", $content );
        }
    }

    public static function admin_menu(){
        add_menu_page(
            "Mail",
            "Mail",
            "manage_options",
            "menu-mails",
            function(){
                $emailfrom = get_option('wpcm_emailfrom');
                $name = get_option('wpcm_name');
                $username = get_option('wpcm_username');
                $password = get_option('wpcm_password') ? 'nopermitidoverelpassword' : '';
                $host = get_option('wpcm_host') ? get_option('wpcm_host') : '';
                $port = get_option('wpcm_port') ? get_option('wpcm_port') : '';
                $autenticated = get_option('wpcm_autenticated') == "true" ? 'checked' : '';
                $encrypted = get_option('wpcm_encrypted') == "true"  ? 'checked' : '';
                $checked = get_option('wpcm_checked') == "true"  ? 'checked' : '';


        $to = get_option('wpcm_emailfrom');
        $subject = "Prueba de email desde Plugin Mail";
        $body = 'esto es una prueba de email desde el plugin mail';
        // echo Mails::send_email( $to, $subject, $body );
        echo get_option('wpcm_emailfrom');
        echo get_option('wpcm_password');
                ?>
                    <div style="margin: 40px;">
                        <form id="wpcm_settings_form">
                        	<table>
                        		<tr>
                        			<th>Email From</th>
                        			<td>
		                                <input type="text" id="emailfrom" name="emailfrom" value="<?=$emailfrom;?>">                				
                        			</td>
                        		</tr>
                        		<tr>
                        			<th>Nombre del reminente</th>
                        			<td>
		                                <input type="text" id="name" name="name" value="<?=$name;?>">                				
                        			</td>
                        		</tr>
                                <tr>
                                    <th>SMTP username</th>
                                    <td>
                                        <input type="text" id="username" name="username" value="<?=$username;?>">
                                    </td>
                                </tr>
                        		<tr>
                        			<th>SMTP password</th>
                        			<td>
		                                <input type="password" id="password" name="password" value="<?=$password;?>">
                        			</td>
                        		</tr>
                                <tr>
                                    <th>SMTP Host</th>
                                    <td>
                                        <input type="text" id="host" name="host" value="<?=$host;?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>SMTP Port</th>
                                    <td>
                                        <input type="text" id="port" name="port" value="<?=$port;?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Autenticacion SMTP</th>
                                    <td>
                                        <input type="checkbox" id="autenticated" name="autenticated" <?=$autenticated;?>>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Encriptado</th>
                                    <td>
                                        <input type="checkbox" id="encrypted" name="encrypted" <?=$encrypted;?>>
                                    </td>
                                </tr>
                                <tr>
                                    <th>enviar mail al generar emision</th>
                                    <td>
                                        <input type="checkbox" id="checked" name="checked" <?=$checked;?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                            	       <input type="button" name="btn" id="btn" value="update">    
                                    </td>
                                    <td>
                                       <input type="button" name="send-test-mail" id="send-test-mail" value="Enviar mail de prueba">    
                                    </td>
                                </tr>
                        	</table>
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
                            	width: 70%;
                            }
                            table tr {
                                padding: 10px;
                                margin: 10px;
                                text-align: left;
                            }
                        </style>
                        <script>
                            jQuery("#btn").click("click", function(){
                                console.log("btn")
                                jQuery.ajax({
                                    url: ajaxurl,
                                    method:'post',
                                    data:{
                                        action: 'wpcm_update_settings_data',
                                        emailfrom: jQuery('#emailfrom').val( ),
                                        name: jQuery('#name').val( ),
                                        username: jQuery('#username').val( ),
                                        password: jQuery('#password').val( ),
                                        host: jQuery('#host').val( ),
                                        port: jQuery('#port').val( ),
                                        autenticated: document.querySelector('#autenticated').checked,
                                        encrypted: document.querySelector('#encrypted').checked,
                                        checked: document.querySelector('#checked').checked
                                    },
                                    success: function(response){
                                        console.log(response);
                                        location.reload( );
                                    }
                                });
                            });
                            jQuery('#send-test-mail').click('click', function( ) {
                                console.log("entro")
                                jQuery.ajax({
                                    url: ajaxurl,
                                    method:'post',
                                    data:{
                                        action: 'wpcm_send_email_test'
                                    },
                                    success: function(response){
                                        console.log(response);
                                    }
                                });
                            });
                        </script>
                    </div>
    
                <?php
            },
            "",
            6
        );
    }

    public static function wpcm_update_settings_data( ) {
        $emailfrom = $_POST['emailfrom'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $host = $_POST['host'];
        $port = $_POST['port'];
        $autenticated = $_POST['autenticated'];
        $encrypted = $_POST['encrypted'];
        $checked = $_POST['checked'];

        update_option('wpcm_emailfrom', $emailfrom );
        update_option('wpcm_name', $name );
        update_option('wpcm_username', $username );
        update_option('wpcm_password', $password );
        update_option('wpcm_host', $host );
        update_option('wpcm_port', $port );
        update_option('wpcm_autenticated', $autenticated );
        update_option('wpcm_encrypted', $encrypted );
        update_option('wpcm_checked', $checked );
    }

    public static function send_test_email( ) {
        $to = get_option('wpcm_emailfrom');
        $subject = "Prueba de email desde Plugin Mail";
        $body = 'esto es una prueba de email desde el plugin mail';
        Mails::send_email( $to, $subject, $body );
    }

    public static function send_email( $to, $subject, $body ){
        $emailfrom = get_option('wpcm_emailfrom');
        $name = get_option('wpcm_name');
        $username = get_option('wpcm_username');
        $password = get_option('wpcm_password');
        $host = get_option('wpcm_host');
        $port = get_option('wpcm_port');
        $autenticated = get_option('wpcm_autenticated');
        $encrypted = get_option('wpcm_encrypted');
        $checked = get_option('wpcm_checked');

        try{
            //Server settings
            $mail = new PHPMailer();    
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $host //'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = $autenticated == "true" ? true : false;                                   //Enable SMTP authentication
            $mail->username   = $username;                                  //SMTP emailfromname
            $mail->Password   = $password;                              //SMTP password
            $mail->SMTPSecure = $encrypted == "true" ? PHPMailer::ENCRYPTION_SMTPS : null;            //Enable implicit TLS encryption
            $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom( $emailfrom, $name );
            $mail->addAddress( $to, 'moises' );     

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