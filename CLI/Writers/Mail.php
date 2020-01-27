<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Mail name is required!", "red");
    return;
}
$email_name=$argv[2];
$fname=$email_name.".php";

if (!file_exists($_DIR."/Emails")) {
    mkdir($_DIR."/Emails", 0777, true);
}

if(file_exists($_DIR."/Emails/".$fname)){
    message("Email Template ".$email_name." already exists!", "red");
    return;
}

$fhandler = fopen($_DIR."/Emails/".$fname, 'w');



$contents =
'<?php
namespace App\Email;

use WPMVC\Core\Mailer\Email;

class '.$email_name.' extends Email{

    /**
     * Set the email content
     * @return View
     */
    public function content(){
        return $this->view("")->with($this->details);
    }

}';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Email template with name ".$email_name." has been created.", "green");