<?php
/*
Name: 			Contact Form
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version:	5.7.2
*/

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

require_once('php-mailer/PHPMailerAutoload.php');

// Step 1 - Enter your email address below.
$email = 'contato@innovareti.com.br';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

$fields = array(
	0 => array(
		'text' => 'Nome',
		'val' => $_POST['name']
	),
	1 => array(
		'text' => 'E-mail',
		'val' => $_POST['email']
	),
	2 => array(
		'text' => 'Telefone',
		'val' => $_POST['telefone']
	),
	3 => array(
		'text' => 'Assunto',
		'val' => 'Contato Humanflow'
	),
	4 => array(
		'text' => 'Mensagem',
		'val' => $_POST['message']
	)
);

$subject = "Contato site HumanFlow";

$message = '';

foreach($fields as $field) {
	$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
}

$mail = new PHPMailer(true);

try {

	$mail->SMTPDebug = $debug;                                 // Debug Mode

	// Step 2 (Optional) - If you don't receive the email, try to configure the parameters below:

	//$mail->IsSMTP();                                         // Set mailer to use SMTP
	//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
	//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
	//$mail->Username = 'user@example.com';                    // SMTP username
	//$mail->Password = 'secret';                              // SMTP password
	//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
	//$mail->Port = 587;   								       // TCP port to connect to

	$mail->AddAddress($email);	 						       // Add another recipient

	$mail->AddCC('elton.nicolau@innovareti.com.br', 'Elton Nicolau');          // Add a "Cc" address. 

	$mail->SetFrom($email, $_POST['name']);
	$mail->AddReplyTo($_POST['email'], $_POST['name']);

	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	$mail->Send();
	$arrResult = array ('response'=>'success');

} catch (phpmailerException $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
} catch (Exception $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
}

if ($debug == 0) {
	echo json_encode($arrResult);
}