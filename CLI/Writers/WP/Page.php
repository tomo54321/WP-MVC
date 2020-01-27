<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Page name is required!", "red");
    return;
}
$page_name=$argv[2];

if(!startsWith( strtolower($page_name) , "page-")){//Page name doesn't start with page- as required by wordpress to override the page?
    $page_name="page-".$page_name;//We'll add it
}

$fname=$page_name.".php";
if(file_exists($_DIR."/../".$fname)){
    message("Page with ".$page_name." already exists!", "red");
    return;
}

if(isset($argv[3]) && $argv[3]==="-nomvc"){

    if(file_exists($_DIR."/../page.php")){
        copy($_DIR."/../page.php", $_DIR."/../".$fname);
        message("Page with name ".$page_name." has been copied from base page file.", "green");
        return;
    }else{
        message("Base page doesn't exist so task couldn't be completed.", "red");
        return;
    }
}

$fhandler = fopen($_DIR."/../".$fname, 'w');

$contents =
'<?php
include_once("inc/'.$_WPMVCFOLDER.'/run.php");
use WPMVC\Core\Route;

// load_models([]);//Load any models used

// Route::get("ControllerName", "ControllerFunction");
// Route::post("ControllerName", "ControllerFunction");

//Add something here that will be appeneded to all pages at the very bottom!

';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Page with name ".$page_name." has been generated.", "green");