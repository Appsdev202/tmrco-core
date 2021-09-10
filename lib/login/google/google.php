<?php

function google_footer_function_login_script() {
    $google_client_ID = get_theme_mod('google_client_ID', '');
    $google_client_ID_script =  "<script type='text/javascript'> var google_client_ID = '{$google_client_ID}' </script>";
    echo $google_client_ID_script;

    ?>
	<script type="text/javascript">
        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function(){
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    //373496230444-uf119vqdp0hsrkujdjt6ucms3scp4v0d.apps.googleusercontent.com
                    client_id: google_client_ID,
                    cookiepolicy: 'single_host_origin',
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                attachSignin(document.getElementById('gSignIn2'));
            });
        };

        function attachSignin(element) {
            /*console.log(element.id);*/
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    jQuery(document).ready(function($){
                        var profile = googleUser.getBasicProfile();
                        var id_token = googleUser.getAuthResponse().id_token;
                        //Google AJAX Login
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajax_object.ajaxurl,
                            data: {
                                'action': 'ajaxgooglelogin', //calls wp_ajax_nopriv_ajaxlogin
                                'id_token': id_token,
                                'useremail': profile.getEmail(),
                                'userfirst': profile.getGivenName(),
                                'userlast': profile.getFamilyName(),
                                'security': $( 'form#login #security2').val() },
                            success: function(data){
                                //$('form#login div.login-error').text(data.message);
                                if (data.loggedin == true){
                                    $('form#login div.login-error').removeClass('alert-danger').addClass('alert-success');
                                    $('form#login div.login-error').text(data.message);
                                    document.location.href = ajax_object.redirecturl;
                                }else{
                                    $('form#login div.login-error').removeClass('alert-success').addClass('alert-danger');
                                    $('form#login div.login-error').text(data.message);
                                }
                                if($('.login-error').text() == ''){
                                    $('form#login div.login-error').hide();
                                }else{
                                    $('form#login div.login-error').show();
                                }
                            }
                        });
                    });


                }, function(error) {
                    //alert(JSON.stringify(error, undefined, 2));
                });
        }
        startApp();
	</script>
<?php }


$google_client_ID = get_theme_mod('google_client_ID', '');

if($google_client_ID){
    add_action( 'wp_footer', 'google_footer_function_login_script' );
}




//Google Login
add_action( 'wp_ajax_nopriv_ajaxgooglelogin', 'rimtm_ajax_google_login' );
function rimtm_ajax_google_login(){
    check_ajax_referer( 'ajax-login-nonce2', 'security' );
    
    $usermail = $_POST['useremail'];
    if( $usermail ){
        $userdata = get_user_by( 'email', $usermail );
        if(isset($userdata->ID)){
            wp_set_current_user( $userdata->ID );
            wp_set_auth_cookie( $userdata->ID );
            echo json_encode(array( 'loggedin'=>true, 'message'=> 'Login successful, redirecting...' ));
        }else{
            $user_name = substr( $usermail, 0, strpos( $usermail, '@' ));
            
            if( username_exists( $user_name ) ){
                while( 2 > 1 ){
                    $random     = substr( str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 2 );
                    $user_name  = $user_name + $random;
                    if( !username_exists( $user_name ) ){ break; }
                }
            }
            $user_input = array(
                'first_name'    =>  $_POST['userfirst'],
                'last_name'     =>  $_POST['userlast'],
                'user_login'    =>  $user_name,
                'user_email'    =>  $usermail,
              	'display_name'	=>  $user_name,
                'user_pass'     =>  NULL
            );
            $user_id = wp_insert_user( $user_input );
            if ( ! is_wp_error( $user_id ) ) {
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );
                echo json_encode(array( 'loggedin'=>true, 'message'=> 'Login successful, redirecting...' ));
            } else {
                echo json_encode(array('loggedin'=>false, 'message'=> 'Wrong username or password.'));
            }
            
        }
        die();
    }
}


if($google_client_ID){
    add_action('wp_enqueue_scripts','load_google_login_script');
}


if( ! function_exists('load_google_login_script')){
	function load_google_login_script(){
		wp_enqueue_script( 'google-login-api-client', 'https://apis.google.com/js/api:client.js', array(), false, false);
	}
}