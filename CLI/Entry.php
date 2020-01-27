<?php
/**
 * Entry point for the CLI
 */

include_once(__DIR__."/Helpers/Colors.php");
include_once(__DIR__."/Helpers/Strings.php");
echo "\n";
$cmd_list = array(
    "help"=>array(
        "about"=>"View all available commands and how to use them",
        "message"=>"",
        "usage"=>"php Helper help",
        "include"=>"/HelpCommand.php"
    ),
    "make:model"=>array(
        "about"=>"Quickly create a model template",
        "message"=>"Creating model template...",
        "usage"=>"php Helper make:model User",
        "include"=>"/Writers/Model.php"
    ),
    "make:controller"=>array(
        "about"=>"Quickly create a controller template",
        "message"=>"Creating controller template...",
        "usage"=>array(
            "php Helper make:controller HomePageController",
            "php Helper make:controller HomePage",
            "php Helper make:controller HomePageController -show"
        ),
        "include"=>"/Writers/Controller.php"
    ),
    "make:mail"=>array(
        "about"=>"Quickly create an email template",
        "message"=>"Creating email template...",
        "usage"=>"php Helper make:email ContactFormEmail",
        "include"=>"/Writers/Mail.php"
    ),
    "config:mail"=>array(
        "about"=>"Quickly generate the mail config file",
        "message"=>"Creating config...",
        "usage"=>"php Helper config:mail",
        "include"=>"/Writers/Config/Mail.php"
    ),
    "template:page"=>array(
        "about"=>"Quickly create a Wordpress Page template",
        "message"=>"Creating page template...",
        "usage"=>array(
            "php Helper template:page [Page name To Override with no spaces]",
            "php Helper template:page page-example",
            "php Helper template:page example",
            "php Helper template:page example -nomvc",
        ),
        "include"=>"/Writers/WP/Page.php"
    ),
    "template:category"=>array(
        "about"=>"Quickly create a Wordpress Category template",
        "message"=>"Creating category template...",
        "usage"=>array(
            "php Helper template:category [Category URL To Override with no spaces]",
            "php Helper template:category category-example",
            "php Helper template:category example",
            "php Helper template:category example -nomvc",
        ),
        "include"=>"/Writers/WP/Category.php"
    ),
    "template:archive"=>array(
        "about"=>"Quickly create a Wordpress Archive template",
        "message"=>"Creating archive template...",
        "usage"=>array(
            "php Helper template:archive [Archive name To Override with no spaces]",
            "php Helper template:archive archive-example",
            "php Helper template:archive example",
            "php Helper template:archive example -nomvc",
        ),
        "include"=>"/Writers/WP/Archive.php"
    ),
    "template:single"=>array(
        "about"=>"Quickly create a Wordpress Single template",
        "message"=>"Creating single template...",
        "usage"=>array(
            "php Helper template:single [Post URL To Override with no spaces]",
            "php Helper template:single single-example",
            "php Helper template:single example",
            "php Helper template:single example -nomvc",
        ),
        "include"=>"/Writers/WP/Single.php"
    ),
);
function message(String $message, $color){
    $colors = new Colors();
    echo $colors->getColoredString($message, $color, null);
    echo "\n";
}

if(!isset($argv[1]) || $argv[1]===""){
    include_once(__DIR__.$cmd_list[ "help" ]["include"]);
    return;
}

if( isset($cmd_list[ strtolower($argv[1]) ]) ){
    message($cmd_list[ strtolower($argv[1]) ]["message"], "blue");
    include_once(__DIR__.$cmd_list[ strtolower($argv[1]) ]["include"]);
}else{
    message("Command not recognised!", "red");
    message("To view all available commands:", "red");
    message("php Helper help", "blue");
}
