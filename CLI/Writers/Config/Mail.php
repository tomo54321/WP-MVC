<?php
if(file_exists($_DIR."/config/mail.php")){
    message("Mail config already exists!", "red");
    return;
}

if (!file_exists($_DIR."/config")) {
    mkdir($_DIR."/config", 0777, true);
}

$fhandler = fopen($_DIR."/config/mail.php", 'w');

$contents =
'<?php
/**
 * Email configuration
 * Use this file to specify connection details and other
 * settings to connect to your mail server
 * 
 * @package WPMVC
 */

/**
 * There is a variable set before the file 
 * is included to prevent direct loads of 
 * the file and leaking of mail server info. (That could be bad D:)
*/
if(!isset($WPMVC_ENV) || $WPMVC_ENV!==true){
    http_response_code(401);
    echo "Access Denied.";
    exit;
}

$config = array(

    /**
     * WPMVC Emails are powered by PHPMailer
     * for variables you can use, take a look here:
     * https://github.com/PHPMailer/PHPMailer
    */
    "SERVER"=>array(
        "Host"=>"localhost",                //The Mail Server Host
        "SMTPAuth"=>true,                   //Enable SMTP authentication
        "Username"=>"user@example.com",     //SMTP Username
        "Password"=>"password",             //SMTP Password
        "Port"=>587                         //TCP port to connect to
    ),

    /**
     * These aren\'t part of PHPMailer
     * Do not refer to their documentation for this section onwards.
    */
    "FROM_EMAIL_ADDRESS"=>"user@example.com",
    "FROM_MAIL_NAME"=>"My Name",

);

';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Mail config has been generated!", "green");