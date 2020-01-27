### Wordpress MVC Theme Framework
This project probably shouldn't be used in production just yet.

## How to setup
Currently, cloning this repo won't work please follow the below steps to get setup.

 - Create an `inc` folder in your theme (If you don't have one already)
 - Clone this repo to a `wpmvc` folder inside the `inc` folder you just created.
 - Move the `Helper` file into the `inc` folder
 - Inside of the `inc` folder create the following folders: `config`, `Controllers`, `Emails`, `Models` and `Views`
 - Inside of the `config` folder create a `mail.php` file and paste the [email config](#Email-Config-File) into it and fill in your email server credentials.
 - You're ready to begin using!
 
 
 ## Email Config File
 ```php
 <?php
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
        "Host"=>"smtp.mailtrap.io",         //The Mail Server Host
        "SMTPAuth"=>true,                   //Enable SMTP authentication
        "Username"=>"",                     //SMTP Username
        "Password"=>"",                     //SMTP Password
        "Port"=>587,                        //TCP port to connect to
        "SMTPOptions"=>array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
          )
        )
    ),

    /**
     * These aren't part of PHPMailer
     * Do not refer to their documentation for this section onwards.
    */
    "FROM_EMAIL_ADDRESS"=>"user@example.com",
    "FROM_MAIL_NAME"=>"My Name",

);

 ```
