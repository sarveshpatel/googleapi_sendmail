<?php
 require __DIR__ . '/vendor/autoload.php';
 session_start();
    $client = new Google_Client();
    $client->setClientId("47071597710-66v98rms1tfpsrggrtg70o2go17n7tdu.apps.googleusercontent.com");
    $client->setClientSecret("VkPnd0dYAeTQCFNb9bGJaqBA");
    $client->setRedirectUri("http://localhost/googleapi_sendmail/1.php");
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
 
    $client->addScope("https://mail.google.com/");
    $client->addScope("https://www.googleapis.com/auth/gmail.compose");
    $client->addScope("https://www.googleapis.com/auth/gmail.modify");
    $client->addScope("https://www.googleapis.com/auth/gmail.readonly");
	
	
if (isset($_REQUEST['code'])) {
    //land when user authenticated
    $code = $_REQUEST['code'];
    $client->authenticate($code);
     
    $_SESSION['gmail_access_token'] = $client->getAccessToken();
    header("Location: http://localhost/googleapi_sendmail/2.php");
}
?>