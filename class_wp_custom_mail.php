<?php
class WP_custom_mail{
	public static function init( ) {
		add_action('admin_menu', array( $this, 'wpcm_admin_menu'));
		add_action('wp_ajax_wpcm_send_mail', array( $this, 'wpcm_send_mail'));
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

	public statis function wpcm_send_mail(){
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