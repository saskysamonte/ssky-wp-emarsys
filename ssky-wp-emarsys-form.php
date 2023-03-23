<?php
/**
 * sSky WP Emarsys Main Form.
 * @author: Sasky Samonte
 */


 /**
  * Newsletter Form
  * @since: 1.0.0
 */
function ssky_wp_emarsys_newsletterform( $fname, $lname, $email, $mobile ) {
    global $fname, $lname, $email, $mobile;
    $ssky_wp_emarsys_options = get_option( 'ssky_wp_emarsys_options' );
    
    echo '
     <br/>
     <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="wpcf7-form">
         '. wp_nonce_field( 'ssky_wp_emarsys_nonce' ) . '
         <div class="cf7_form_1_container">
             <div class="columns_wrap">
                 <span class="wpcf7-form-control-wrap">
                     <label>First Name:</label>
                     <input type="text" class="wpcf7-form-control wpcf7-text" name="fname">
                 </span>
             </div>
             <br/>
             <div class="columns_wrap">
                 <span class="wpcf7-form-control-wrap">
                     <label>Last Name:</label>
                     <input type="text" class="wpcf7-form-control wpcf7-text" name="lname">
                 </span>
             </div>
             <br/>
             <div class="columns_wrap">
                 <span class="wpcf7-form-control-wrap">
                     <label>Email:</label>
                     <input type="email" class="wpcf7-form-control wpcf7-email" name="email">
                 </span>
             </div>
             <br/>
             <div class="columns_wrap">
                 <span class="wpcf7-form-control-wrap">
                     <label>Mobile:</label>
                     <input type="text" class="wpcf7-form-control wpcf7-text" name="mobile">
                 </span>
             </div>
             <br/>
             <div class="columns_wrap" style="text-align: center;">
                 <span class="wpcf7-list-item">
                     <label><input type="checkbox" id="checkbox" name="checkbox" value="1" aria-invalid="false">
                         <span class="wpcf7-list-item-label">' . $ssky_wp_emarsys_options['ssky_wp_emarsys_terms_conditions'] . '</span>
                     </label>
                 </span>
             </div>
             <div class="columns_wrap" style="text-align: center;">
                 <input type="submit" id="submitBtn" class="wpcf7-form-control wpcf7-submit" name="submit" value="Submit" disabled/>
             </div>
 
         </div>
     </form>
     
     <script>
         jQuery(document).ready(function() {
             var checkbox = jQuery("#checkbox");
             checkbox.click(function() {
                 if (jQuery(this).is(":checked")) {
                     jQuery("#submitBtn").removeAttr("disabled");
                 } else {
                     jQuery("#submitBtn").attr("disabled", "disabled");
                 }
             });
         }); 
     </script>
     
     ';
 }


/**
  * Main Form
  * @since: 1.0.0
 */

 function ssky_wp_emarsys_newsletterform_validation( $fname, $lname, $email, $mobile )  {
    global $customize_error_validation;
    $customize_error_validation = new WP_Error;
    if ( empty( $fname ) && empty( $lname ) && empty( $email ) && empty( $mobile ) ) {
        $customize_error_validation->add('field', 'Please fill the filed form');
    }
    
    if ( empty( $fname ) ) {
        $customize_error_validation->add('field', 'First name is required');
    }
    
    if ( empty( $lname ) ) {
        $customize_error_validation->add('field', 'Last name is required');
    }

    if ( empty( $email ) ) {
        $customize_error_validation->add('field', 'Email address is required');
    }
    
    if ( empty( $mobile ) ) {
        $customize_error_validation->add('field', 'Mobile number is required');
    }

    if ( is_wp_error( $customize_error_validation ) ) {
        foreach ( $customize_error_validation->get_error_messages() as $error ) {
            echo '<span style="color: red; font-weight: bold;">* ';
            echo $error . '</span><br/>';
        }
    }
}


/**
  * Form Send to Emarsys API
  * @since: 1.0.0
 */
function ssky_wp_emarsys_newsletterform_send_api() {
    global $customize_error_validation, $fname, $lname, $email, $mobile;
    $ssky_wp_emarsys_options = get_option( 'ssky_wp_emarsys_options' );
    $post_data = wp_unslash( $_POST );
    $nonce     = isset( $post_data['_wpnonce'] ) ? $post_data['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'ssky_wp_emarsys_nonce' ) ) {
        return;
    }
    if ( 1 > count( $customize_error_validation->get_error_messages() ) ) {

        $data_array = array(
            "key_id" => "3",
            "contacts" => [
                [ 
                  "1" => $fname,
                  "2" => $lname,
                  "3" => $email,
                  "31" => true,
                  "37" => $mobile,
                  "50647" => "1" //
                ]
            ]
        );
        

        
        $data_encode = json_encode($data_array);
        $ssky_wp_emarsys_api = new sSKY_WP_Emarsys_API($ssky_wp_emarsys_options['ssky_wp_emarsys_api_username'], $ssky_wp_emarsys_options['ssky_wp_emarsys_api_password']);
     
        $send_data = $ssky_wp_emarsys_api->send('POST', 'contact', $data_encode);
        $decoded = json_decode($send_data, true);
		
		//var_dump($decoded);

        if(!empty($decoded['errorMessage']) && $decoded['errorMessage'] === 'Credentials are invalid.' ){
            echo '<span style="color: red; font-weight: bold;">' . $decoded['errorMessage'] . '</span>';
            echo '<br/>';
        } else {
            if(!empty($decoded['data']['ids'])) {
                echo '<span style="color: green; font-weight: bold;">' . $ssky_wp_emarsys_options['ssky_wp_emarsys_success_message'] . '</span>';
            } else {
                if($decoded['data']['errors']){
                     foreach($decoded['data']['errors'] as $key => $value ){
                       echo '<span style="color: red; font-weight: bold;">This email '  . $key . ' already subscribed!</span>';
                       echo '<br/>';
                    }
                }   else {
                      echo '<span style="color: green; font-weight: bold;">' . $ssky_wp_emarsys_options['ssky_wp_emarsys_success_message'] . '</span>';
                      echo '<br/>';
                }
            }
        }

    }
}

/**
  * Form Process
  * @since: 1.0.0
 */
function ssky_wp_emarsys_newsletterform_process() {
    global $fname, $lname, $email, $mobile;
    if ( isset($_POST['submit'] ) ) {
        ssky_wp_emarsys_newsletterform_validation(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['email'],
            $_POST['mobile']
       );

        $fname =   sanitize_text_field( $_POST['fname'] );
        $lname  =   sanitize_text_field( $_POST['lname'] );
        $email      =   sanitize_email( $_POST['email'] );
        $mobile      =   sanitize_text_field( $_POST['mobile'] );

        ssky_wp_emarsys_newsletterform_send_api(
            $fname,
            $lname,
            $email,
            $mobile
        );

    }
    ssky_wp_emarsys_newsletterform(
        $fname,
        $lname,
        $email,
        $mobile
    );
}

/**
  * Generate Random Key for WP Nonce
  * @since: 1.0.0
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


/**
  * Newsletter Form Shortcode
  * @since: 1.0.0
 */
add_shortcode( 'ssky_wp_emarsys_form', 'ssky_wp_emarsys_form' );
function ssky_wp_emarsys_form() {
    ob_start();
    ssky_wp_emarsys_newsletterform_process();
    return ob_get_clean();
}