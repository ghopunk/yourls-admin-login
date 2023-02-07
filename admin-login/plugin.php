<?php
/*
Plugin Name: Admin Login Page
Plugin URI: https://bloggerpemalas.com/
Description: Admin Login Page
Version: 1.0
Author: Ghopunk
Author URI: https://bloggerpemalas.com/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();
 
function ghopunk_pre_html_head( $context, $title ) {
	if( is_array($context) && $context[0] == 'login' || !is_array($context) && $context == 'login' ){
		$auth 		= yourls_is_valid_user();
		$message 	= false;
		if( $auth !== true ) {
			$message = $auth;
		}
		$plugin_url = yourls_plugin_url(dirname(__FILE__));
		$action = ( isset( $_GET['action'] ) && $_GET['action'] == 'logout' ? '?' : '' );
?>
<!DOCTYPE html>
<html <?php yourls_html_language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php echo yourls_apply_filter( 'html_head_meta_content-type', 'text/html; charset=utf-8' ); ?>" />
<?php yourls_html_favicon(); ?>
<title>Login - <?php echo $_SERVER['HTTP_HOST'];?></title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW, NOODP, NOYDIR">
<script src="<?php yourls_site_url(); ?>/js/jquery-3.5.1.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
<style type="text/css">
	* {margin: 0;padding: 0;}
	#notify {margin: 45px auto;width: 365px;}
	.error-notice {background: linear-gradient(to bottom, #DD5952 0px, #BC3E33 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);color: #FFFFFF;border-radius: 4px;box-shadow: 0 2px 2px #2B2B2B;padding: 5px 10px 5px 5px;}
	.error-notice a{color: #FFFFFF;}
	#login-header {font-size:120%;text-align: center;background: linear-gradient(to bottom, #666666 0px, #CCCCCC 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);border-color: -moz-use-text-color -moz-use-text-color #A1A1A1;border-radius: 5px 5px 0 0;border-style: none none solid;border-width: 0 0 1px medium;padding: 10px;position: relative;}
	#login-footer {padding: 10px;text-align: center;}
	#login-sub {background: linear-gradient(to bottom, #CCCCCC 0px, #FFFFFF 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);border-top: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;color: #4C4C4C;font-size: 12px;height: 250px;padding-left: 30px;padding-right: 30px;padding-top: 30px;border-radius:0 0 5px 5px;}
	.login_box {width: 220px;border-radius: 5px;height: 319px;margin: 0 auto;position: relative;	width: 356px;}
	.login_text {color: #4C4C4C;font-size: 12px;font-weight: bold;padding-bottom: 8px;padding-left: 4px;width: 100%;}
	.login_input {margin-left:15%;background: none repeat scroll 0 0 rgba(0, 0, 0, 0);border: 0 none;border-radius: 0;box-shadow: none;outline: 0 none;color: #000000;font-size: 13px;height: 32px;width:85%}
	.input_login_box {background-image:url("<?php echo $plugin_url;?>/image/icon-username.png");}
	.input_password_box {background-image:url("<?php echo $plugin_url;?>/image/icon-password.png");}
	.input_login_box, .input_password_box {font-family:helvetica;background-position:6px 6px;background-color: #FFFFFF;background-repeat: no-repeat;border: 2px solid #BEBEBE;border-radius: 5px;box-shadow: 0 10px 10px #E9E9E9 inset;height: 32px;}
	input:-moz-placeholder, input::-moz-placeholder {color: #7F7F7F;font-family: Georgia,serif;font-style: italic;}
	input:focus:-moz-placeholder, input:focus::-moz-placeholder {color: #AAAAAA;transition: color 0.2s ease 0s;}
	.login-btn {float: left;padding-top: 22px;}
	.register-btn {float: right;padding-top: 22px;}
	#login_submit{background-color: #F78E1E;background-image: linear-gradient(#F78E1E, #E47513);border: 1px solid #CC6600;border-radius: 3px;color: #FFFFFF;cursor: pointer;font-weight: bold;overflow: visible;padding: 5px 25px;width: auto;}
	#register_submit{background-color: #49afcd;background-image: linear-gradient(#5bc0de,#2f96b4);border: 1px solid #599fb4;border-radius: 3px;color: #FFFFFF;cursor: pointer;font-weight: bold;overflow: visible;padding: 5px 25px;width: auto;}
</style>
</head>
<body>
	<div id="container">
		<div id="notify">
			<noscript>
				<div class="error-notice" style="text-align:center;">
					JavaScript is disabled in your browser.<br>
					You must enable JavaScript!<br><?php echo $_SERVER['HTTP_HOST'];?> require JavaScript function.
				</div>
			</noscript>
			<?php if( !empty($message) ){ ?>
			<div class="error-notice" style="text-align:center;"><?php echo $message; ?></div>
			<?php } ?>
		</div>
		<div class="login_box">
			<div id="login-header">
				<?php echo $_SERVER['HTTP_HOST'];?>
			</div>
			<div id="login-sub">
				<form method="post" action="<?php echo $action; ?>">
					<?php
						yourls_do_action( 'login_form_top' );
					?>
					<div class="login_text">Username</div>
					<div class="input_login_box">
						<input name="username" required placeholder="Enter your username" type="text" id="username" class="login_input" disabled>
					</div>
					<div class="login_text" style="margin-top:20px;">Password</div>
					<div class="input_password_box">
						<input name="password" required placeholder="Enter your password" type="password" id="password" class="login_input" disabled>
					</div>
					<?php
						yourls_do_action( 'login_form_bottom' );
					?>
					<?php 
						yourls_nonce_field('admin_login'); 
					?>
					<div class="login-btn">
						<button tabindex="3" id="login_submit" type="submit" name="submit" style="display:none;" value="<?php yourls_e( 'Login' ); ?>">Log in</button>
					</div>
					<?php
						yourls_do_action( 'login_form_end' );
					?>
				</form>
			</div>
			<div id="login-footer">
				<span style="position: relative; top: 20%;">&copy; <?php echo gmdate("Y");?> <?php echo $_SERVER['HTTP_HOST'];?></span>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#username').removeAttr('disabled');
			$('#password').removeAttr('disabled');
			$('#login_submit').show();
			$('#username').focus();
		});
	</script>
</body>
</html>
<?php
	die();
	}
}
yourls_add_action( 'pre_html_head', 'ghopunk_pre_html_head', 10, 2 );

function ghopunk_verify_nonce( $verify, $action, $nonce, $user, $return ) {
	if( false === $verify 
		&& $action === 'admin_login' 
		&& isset( $_REQUEST['nonce'] ) && $nonce === $_REQUEST['nonce']
		&& isset( $_REQUEST['username'] )
	) {
		$nonce 	= yourls_create_nonce( $action, $_REQUEST['username'] );
		$valid	= yourls_create_nonce( $action, $user );
		if( $nonce === $valid ) {
			$verify = true;
		}
	}
	return $verify;
}
yourls_add_filter( 'verify_nonce', 'ghopunk_verify_nonce', 10, 5 );