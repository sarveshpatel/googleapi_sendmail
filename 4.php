<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
  $client = new Google_Client();
print_r($_SESSION);
  $client->setClientId("47071597710-66v98rms1tfpsrggrtg70o2go17n7tdu.apps.googleusercontent.com");
    $client->setClientSecret("VkPnd0dYAeTQCFNb9bGJaqBA");
    $client->setRedirectUri("http://localhost/googleapi_sendmail/1.php");
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
$client->setAccessToken('ya29.GltCBkYtfDXOhBVeeNSj89lGYFljZ1HvUad85ngh_ihBixR_pM9g45Sa2bAcjq_Ng0dbHvhCWN4VZRMn8WU_P_GS_ho6tuTxAJJqIk902KAOZ-jfJXA27XTo95y6');            
$isAccessCodeExpired = $client->isAccessTokenExpired();
    $objGMail = new Google_Service_Gmail($client);

   $strMailContent = 'This is a test mail which is <b>sent via</b> using Gmail API client library.<br/><br/><br/>Thanks,<br/><b>Premjith K.K..</b>';
   // $strMailTextVersion = strip_tags($strMailContent, '');

    $strRawMessage = "";
    $boundary = uniqid(rand(), true);
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = 'NAME';
    $strToMail = 'sdpatel.2110@gmail.com';
    $strSesFromName = 'Premjith GMAIL API';
    $strSesFromEmail = 'sarvesh@offshorewebmaster.com';
    $strSubject = 'Test mail using GMail API - with attachment - ' . date('M d, Y h:i:s A');

    $strRawMessage .= 'To: ' .$strToMailName . " <" . $strToMail . ">" . "\r\n";
    $strRawMessage .= 'From: '.$strSesFromName . " <" . $strSesFromEmail . ">" . "\r\n";

    $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
    $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
    $strRawMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";

    $filePath = 'token.json';
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    $mimeType = finfo_file($finfo, $filePath);
    $fileName = 'token.json';
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
        
    }
?>