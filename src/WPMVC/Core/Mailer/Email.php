<?php
namespace WPMVC\Core\Mailer;
use WPMVC\Core\Mailer\Mailer;
/**
 * Email Object Class
 */
class Email{
    
    public $to;
    public $subject;
    public $bcc=array();
    public $cc=array();
    public $details;
    public $comcontent;

    /**
     * New Instance
     * @return $this
     */
    public function __construct($details = ""){
        $this->details=$details;
        return $this;
    }

    /**
     * Set who the email is to
     * @param $to
     * @return $this
     */
    public function to($to){
        $this->to=$to;
        return $this;
    }

    /**
     * Set the email subject
     * @param String $subject
     * @return $this
     */
    public function subject($subject){
        $this->subject=$subject;
        return $this;
    }

    /**
     * Set the email bcc
     * @param $bcc
     * @return $this
     */
    public function bcc($bcc){
        $this->bcc=$bcc;
        return $this;
    }

    /**
     * Set the email cc
     * @param $cc
     * @return $this
     */
    public function cc($cc){
        $this->cc=$cc;
        return $this;
    }

    /**
     * Send email
     */
    public function send(){
        $content = method_exists($this, "content")?$this->content():"";

        if($content !== ""){
            $content = $content->__html();
        }
        $this->comcontent = $content;
        Mailer::send($this);
    }

    /**
     * Get View Contents
     * @param String $viewName
     */
    function view(String $viewName){
        return new \WPMVC\Views\ViewLoader($viewName);
    }
}