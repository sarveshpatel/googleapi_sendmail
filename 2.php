<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
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
if (isset($_SESSION['gmail_access_token'])) {
		print_r($_SESSION['gmail_access_token']);
}
else
{
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


