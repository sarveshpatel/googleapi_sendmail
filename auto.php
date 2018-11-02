<?php
 require __DIR__ . '/vendor/autoload.php';
	$user_to_impersonate = "sarvesh@offshorewebmaster.com";
    //putenv("GOOGLE_APPLICATION_CREDENTIALS=credentials.json");
	
    $client = new Google_Client();
	putenv("GOOGLE_APPLICATION_CREDENTIALS=credential_all.json");
	//$client->setAuthConfig('client_secret.json');
    $client->useApplicationDefaultCredentials();
    $client->setSubject($user_to_impersonate);
    $client->setApplicationName("My Mailer");
	$client->setScopes('https://mail.google.com');
	$client->setScopes('https://www.googleapis.com/auth/email.migration');
	$client->setScopes('https://www.googleapis.com/auth/gmail.insert');
	$client->setScopes('https://www.googleapis.com/auth/gmail.labels');
	
    $client->addScope("https://www.googleapis.com/auth/gmail.compose");
   
	
    $service = new Google_Service_Gmail($client);
    // Process data
    try {
        $strSubject = "Set the email subject here";
        $strRawMessage = "From: Me<sarvesh@offshorewebmaster.com>\r\n";
        $strRawMessage .= "To: Foo<sdpatel.2110@gmail.com>\r\n";
        $strRawMessage .= "CC: Bar<sdpatel.2110@gmail.com>\r\n";
        $strRawMessage .= "Subject: =?utf-8?B?" . base64_encode($strSubject) . "?=\r\n";
        $strRawMessage .= "MIME-Version: 1.0\r\n";
        $strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
        $strRawMessage .= "Content-Transfer-Encoding: base64" . "\r\n\r\n";
        $strRawMessage .= "Hello World!" . "\r\n";
        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        //The special value **me** can be used to indicate the authenticated user.
        $service->users_messages->send("me", $msg);
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
	
?>