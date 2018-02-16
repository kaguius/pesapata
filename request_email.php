<?php
include_once('includes/db_conn.php');

session_start();
if (!empty($_SESSION)){
	$userid = $_SESSION["userid"] ;
	$adminstatus = $_SESSION["adminstatus"] ;
	$station = $_SESSION["station"] ;
	$username = $_SESSION["username"];
}

if (!empty($_GET)){	
	$tenant_id = $_GET['payment_type'];
	$commissions = $_GET['commissions'];
} 

$email = 'samson.wachira@gmail.com; mwendamuringi@gmail.com; wangui.joyce@yahoo.com';
$name = 'Pesa Pata Direct Administrator';

$mailto = $email ;
$subject = "[Pesa Pata Direct] Commissions Request" ;
$formurl = "request.php" ;
$thankyouurl = "index.php" ;

echo $thankyouurl;
$uself = 0;
$use_envsender = 0;
$use_sendmailfrom = 0;
$use_webmaster_email_for_from = 0;
$use_utf8 = 1;
$my_recaptcha_private_key = '' ;

// -------------------- END OF CONFIGURABLE SECTION ---------------

$headersep = (!isset( $uself ) || ($uself == 0)) ? "\r\n" : "\n" ;
$content_type = (!isset( $use_utf8 ) || ($use_utf8 == 0)) ? 'Content-Type: text/plain; charset="iso-8859-1"' : 'Content-Type: text/plain; charset="utf-8"' ;
if (!isset( $use_envsender )) { $use_envsender = 0 ; }
if (isset( $use_sendmailfrom ) && $use_sendmailfrom) {
	ini_set( 'sendmail_from', $mailto );
}
$envsender = "-f$mailto" ;
$http_referrer = getenv( "HTTP_REFERER" );

if ( preg_match( "/[\r\n]/", $fullname ) || preg_match( "/[\r\n]/", $email ) ) {
	header( "Location: $errorurl" );
	exit ;
}
if (strlen( $my_recaptcha_private_key )) {
	require_once( 'recaptchalib.php' );
	$resp = recaptcha_check_answer ( $my_recaptcha_private_key, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );
	if (!$resp->is_valid) {
		header( "Location: $errorurl" );
		exit ;
	}
}
if (empty($email)) {
	$email = $mailto ;
}
$fromemail = (!isset( $use_webmaster_email_for_from ) || ($use_webmaster_email_for_from == 0)) ? $email : $mailto ;

if (function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc()) {
	$comments = stripslashes( $comments );
}

$messageproper =
	"Hi, \n" .
	"\n" .
	"Please remit the amount KES $commissions to $username" .
	"\n" .
	"\n" .
	"Best Regards, \n" .
	"---\n" .
	"Pesa Pata Direct\n" .
	"Client Services Team\n" .
	"\n\n------------------------------------------------------------\n" ;

//echo $messageproper;

$headers =
	"From: \"$name\" <$fromemail>" . $headersep . "Reply-To: \"$name\" <$email>" . $headersep . "X-Mailer: chfeedback.php 2.15.0" .
	$headersep . 'MIME-Version: 1.0' . $headersep . $content_type ;

if ($use_envsender) {
	mail($mailto, $subject, $messageproper, $headers, $envsender );
}
else {
	mail($mailto, $subject, $messageproper, $headers );
}
?>

<script type="text/javascript">
<!--
	/*alert("Either the Email Address or the Password do not match the records in the database or you have been disabled from the system, please contact the system admin at www.e-kodi.com/contact.php");*/
	document.location = "<?php echo $thankyouurl ?>";
	//-->
</script>
