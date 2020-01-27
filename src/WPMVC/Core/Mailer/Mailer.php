<?php
namespace WPMVC\Core\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use WPMVC\Core\Mailer\Email;
use WPMVC\Core\Core;

/**
 * Mailer Class
 */
class Mailer{
    
    /**
     * Send an email
     * @param Email $email
     * @return Boolean
     */
    public static function send(Email $email){
        $mail = new PHPMailer(true);

        $mail_config = Core::getConfig("mail");

        try{

            //Connection settings
            $mail->isSMTP();
            foreach ($mail_config["SERVER"] as $setting_name=>$setting){
                $mail->$setting_name=$setting;
            }
            
            //Email recipients specified in object
            $mail->setFrom($mail_config["FROM_EMAIL_ADDRESS"], ($mail_config["FROM_MAIL_NAME"] ?? bloginfo('name')) );
            $mail->addAddress($email->to);
            foreach($email->cc as $carboncopy){
                $mail->addCC($carboncopy);
            }
            foreach($email->bcc as $blindcarboncopy){
                $mail->addBCC($blindcarboncopy);
            }

            //Email Content
            $mail->isHTML(true);
            $mail->Subject = $email->subject;
            $mail->Body = $email->comcontent;
            $mail->AltBody = \strip_tags($email->comcontent);

            $mail->send();
            return true;

        }catch(Exception $ex){
            die("Email ".get_class($email)." couldn't be sent. Exception: ".$mail->ErrorInfo);
            return false;
        }

    }

}