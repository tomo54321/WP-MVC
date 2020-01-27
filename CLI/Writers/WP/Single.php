<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Post name is required!", "red");
    return;
}
$single_name=$argv[2];

if(!startsWith( strtolower($single_name) , "single-")){//single name doesn't start with single- as required by wordpress to override the single?
    $single_name="single-".$single_name;//We'll add it
}

$fname=$single_name.".php";
if(file_exists($_DIR."/../".$fname)){
    message("Single file with ".$single_name." already exists!", "red");
    return;
}

if(isset($argv[3]) && $argv[3]==="-nomvc"){

    if(file_exists($_DIR."/../single.php")){
        copy($_DIR."/../single.php", $_DIR."/../".$fname);
        message("single with name ".$single_name." has been copied from base single file.", "green");
        return;
    }else{
        message("Base single doesn't exist so task couldn't be completed.", "red");
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

//Add something here that will be appeneded to all singles at the very bottom!

';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Single with name ".$single_name." has been generated.", "green");