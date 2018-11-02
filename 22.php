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
 
 //$isAccessCodeExpired = $client->isAccessTokenExpired();
 
 
//if (isset($_SESSION['gmail_access_token']) &amp;&amp; !empty($_SESSION['gmail_access_token']) &amp;&amp; $isAccessCodeExpired != 1) {
//if (isset($_SESSION['gmail_access_token'])) {
    //gmail_access_token setted;
     
    $boundary = uniqid(rand(), true);
	//echo $_SESSION['gmail_access_token']; die();
	$client->setAccessToken($data);           
    $objGMail = new Google_Service_Gmail($client);

   $strMailContent = 'This is a test mail which is <b>sent via</b> using Gmail API client library.<br/><br/><br/>Thanks,<br/><b>Premjith K.K..</b>';
   // $strMailTextVersion = strip_tags($strMailContent, '');

    $strRawMessage = "";
    $boundary = uniqid(rand(), true);
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = 'NAME';
    $strToMail = 'testyahooweb@gmail.com';
    $strSesFromName = 'Premjith GMAIL API';
    $strSesFromEmail = 'premji341800@gmail.com';
    $strSubject = 'Test mail using GMail API - with attachment - ' . date('M d, Y h:i:s A');

    $strRawMessage .= 'To: ' .$strToMailName . " <" . $strToMail . ">" . "\r\n";
    $strRawMessage .= 'From: '.$strSesFromName . " <" . $strSesFromEmail . ">" . "\r\n";

    $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
    $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
    $strRawMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";

    $filePath = 'border.pdf';
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    $mimeType = finfo_file($finfo, $filePath);
    $fileName = 'border.pdf';
    $fileData = base64_encode(file_get_contents($filePath));

    $strRawMessage .= "\r\n--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: '. $mimeType .'; name="'. $fileName .'";' . "\r\n";            
    $strRawMessage .= 'Content-ID: <' . $strSesFromEmail . '>' . "\r\n";            
    $strRawMessage .= 'Content-Description: ' . $fileName . ';' . "\r\n";
    $strRawMessage .= 'Content-Disposition: attachment; filename="' . $fileName . '"; size=' . filesize($filePath). ';' . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
    $strRawMessage .= chunk_split(base64_encode(file_get_contents($filePath)), 76, "\n") . "\r\n";
    $strRawMessage .= "--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    $strRawMessage .= $strMailContent . "\r\n";

    //Send Mails
    //Prepare the message in message/rfc822
    try {
        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        $objSentMsg = $objGMail->users_messages->send("me", $msg);

        print('Message sent object');
       // print($objSentMsg);

    } catch (Exception $e) {
        print($e->getMessage());
        unset($_SESSION['access_token']);
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
	header("Location: 22.php");
}