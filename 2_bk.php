<?php
session_start();
if(isset($_SESSION['test'])){
date_default_timezone_set("Asia/Calcutta"); 
require __DIR__ . '/vendor/autoload.php';
 //print_r($_SESSION); die();
    $client = new Google_Client();
    $client->setClientId("47071597710-66v98rms1tfpsrggrtg70o2go17n7tdu.apps.googleusercontent.com");
    $client->setClientSecret("VkPnd0dYAeTQCFNb9bGJaqBA");
    //$client->setRedirectUri("http://localhost/googleapi_sendmail/1.php");
    $client->setAccessType('offline');
    //$client->setApprovalPrompt('force');
 
    $client->addScope("https://mail.google.com/");
    $client->addScope("https://www.googleapis.com/auth/gmail.compose");
    $client->addScope("https://www.googleapis.com/auth/gmail.modify");
    $client->addScope("https://www.googleapis.com/auth/gmail.readonly");
 
	$data = Array ( 'access_token' => 'ya29.GltCBjVHWczRTX2FzDCzc52DfGiFFqC6c0RcrJmNQcIscBifkCbwBzCm5TMRj8xZ_CATtScfjFPsb1nZU6Pzy1qgRUuaK2IWDUU12yO8kiR0epvSGzQPwa-PyUF_', 
	'expires_in' => 3600, 
	'refresh_token' => '1/9h4rTQSsW5DJyCNTiDrOMNnFFXtWF3ewGjHwPR7xI08', 
	'scope' => 'https://www.googleapis.com/auth/gmail.compose https://www.googleapis.com/auth/gmail.modify https://www.googleapis.com/auth/gmail.readonly https://mail.google.com/', 
	'token_type' => 'Bearer', 
	'created' => '1540547346' 
	) ;
	/*
	Array ( [access_token] => ya29.GltFBq9rnI1C9GNYAQ34-iA5591Ji6t7pMuB7fznS7TmKvWYb6b4Fnt6COno3Ao0Bg1_DQlr3LWzo11dAAWN9p9_qkxxbKbr4QCImkypg8nAimai1ZKs6KKIXhAL [expires_in] => 3600 [refresh_token] => 1/uOIIqzJTNbXv2qhEp3ts3MqbWX5JM0KvnpIwGBMmzaZUvyFzA46RTx3d10lW3cJu [scope] => https://www.googleapis.com/auth/gmail.compose https://www.googleapis.com/auth/gmail.modify https://www.googleapis.com/auth/gmail.readonly https://mail.google.com/ [token_type] => Bearer [created] => 1540804894 )
	*/
 //$isAccessCodeExpired = $client->isAccessTokenExpired();
 
 
//if (isset($_SESSION['gmail_access_token']) &amp;&amp; !empty($_SESSION['gmail_access_token']) &amp;&amp; $isAccessCodeExpired != 1) {
//if (isset($_SESSION['gmail_access_token'])) {
    //gmail_access_token setted;
     
    $boundary = uniqid(rand(), true);
	//echo $_SESSION['gmail_access_token']; die();
	$client->setAccessToken($data);
	$datap ='';
    //$datap = $client->setAccessToken($data);            
    $objGMail = new Google_Service_Gmail($client);
     
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = 'Sarvesh';
    $strToMail = 'testyahooweb@gmail.com';
    $strSesFromName = 'sylviane';
    $strSesFromEmail = 'sylviane.virginie@trans-madikera.com';
    $strSubject = 'Test mail using GMail API' . date('M d, Y h:i:s A');
	$strRawMessage ='';
    $strRawMessage .= 'To: ' . $strToMailName . " <" . $strToMail . ">" . "\r\n";
    $strRawMessage .= 'From: '. $strSesFromName . " <" . $strSesFromEmail . ">" . "\r\n";
 
    $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
    $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
    $strRawMessage .= 'Content-type: Multipart/Alternative; boundary="' . $boundary . '"' . "\r\n";
	
	/**** file upload ****/
	$mimeType = 'application/pdf';
	$fileName = 'border.pdf';
	$filePath  = 'border.pdf';
	
	
    $strRawMessage .= "\r\n--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: '. $mimeType .'; name="'. $fileName .'";' . "\r\n";            
    $strRawMessage .= 'Content-ID: <' . $strSesFromEmail . '>' . "\r\n";            
    $strRawMessage .= 'Content-Description: ' . $fileName . ';' . "\r\n";
    $strRawMessage .= 'Content-Disposition: attachment; filename="' . $fileName . '"; size=' . filesize($filePath). ';' . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
    $strRawMessage .= chunk_split(base64_encode(file_get_contents($filePath)), 76, "\n") . "\r\n";
    $strRawMessage .= '--' . $boundary . "\r\n";
	/**** file upload ****/
 
    $strRawMessage .= "\r\n--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
    $strRawMessage .= "this is a test!" . "\r\n";
 
    $strRawMessage .= "--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    $strRawMessage .= "this is a tes2t!" . "\r\n";

	$con=  mysqli_connect("localhost","root","","google_api");
	$dateCreated = date('Y-m-d h:i:s');
	$sql ="insert into datastore (`id`,`tokendata`,`type`,`dateCreated`)  values (NULL,'".serialize($data)."','".serialize($datap)."','".$dateCreated."')";
	$res = mysqli_query($con,$sql);
    //Send Mails
    //Prepare the message in message/rfc822
    try {
        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        $objSentMsg = $objGMail->users_messages->send("me", $msg);
 
        print('Message sent object');
		echo "<pre>";
        //	print_r($objSentMsg);
		echo "</pre>";
 
    } catch (Exception $e) {
		//echo '1';
        print($e->getMessage());
        //unset($_SESSION['gmail_access_token']);
    }
	
	
//}

/*
else {
    // Failed Authentication
    if (isset($_REQUEST['error'])) {
      echo "error auth";
    }
    else{
        // Redirects to google for User Authentication
        $authUrl = $client->createAuthUrl();
        header("Location: $authUrl");
    }
}
 
function encodeRecipients($recipient){
    $recipientsCharset = 'utf-8';
    if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
        $recipient = '=?' . $recipientsCharset . '?B?'.base64_encode($regs[1]).'?= <'.$regs.'&#91;2&#93>';
    }
    return $recipient;
}
*/

}else{
	$_SESSION['test'] ='1';
	header("Location: 2.php");
}