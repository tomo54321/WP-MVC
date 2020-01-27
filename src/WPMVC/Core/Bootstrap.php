<?php
namespace WPMVC\Core;

class Bootstrap{
    /**
     * We'll load in the controller
     * @param String path
     * @return boolean
     */
    public static function loadController($path){
        $controllers_path= get_stylesheet_directory()."/inc/" ."Controllers/".$path;
        if(!file_exists($controllers_path)){
            throw new \Exception("Controller ".$path." doesn't exist, expected filepath: Controllers/".$path);
            return false;
        }
        include_once($controllers_path);
        return true;
    }

    /**
     * We'll load in the models user want's to use
     * @param $modelFileNames
     * @return boolean
     */
    public static function loadModels($modelFileNames){
        if(!\is_array($modelFileNames)){//If it's a singular model we'll add make it an array.
            $modelFileNames = array($modelFileNames);
        }
        foreach($modelFileNames as $path){
            $model_path= get_stylesheet_directory()."/inc/" ."Models/".$path.".php";
            if(!file_exists($model_path)){
                throw new \Exception("Model ".$path." doesn't exist, expected filepath: Models/".$path.".php");
                return false;
            }
            include_once($model_path);
        }
        return true;
    }

    /**
     * We'll load in the emails user want's to use
     * @param $emailFileNames
     * @return boolean
     */
    public static function loadEmails($emailFileNames){
        if(!\is_array($emailFileNames)){//If it's a singular model we'll add make it an array.
            $emailFileNames = array($emailFileNames);
        }
        foreach($emailFileNames as $path){
            $email_path= get_stylesheet_directory()."/inc/" ."Emails/".$path.".php";
            if(!file_exists($email_path)){
                throw new \Exception("Email ".$path." doesn't exist, expected filepath: Emails/".$path.".php");
                return false;
            }
            include_once($email_path);
        }
        return true;
    }

    /**
     * We'll load in the config specified
     * @param String $cfgName
     * @return Array
     */
    public static function loadCFG(String $cfgName){
        $cfg_path= get_stylesheet_directory()."/inc/" ."config/".$cfgName.".php";
        if(!file_exists($cfg_path)){
            throw new \Exception("Config ".$cfgName." doesn't exist, expected filepath: config/".$cfgName.".php");
            return array();
        }
        $WPMVC_ENV=true;
        include_once($cfg_path);
        if(!is_array($config)){
            throw new \Exception("Config ".$cfgName." is invalid and cannot be loaded.");
            return array();
        }
        return $config;
    }
}