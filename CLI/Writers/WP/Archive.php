<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Archive name is required!", "red");
    return;
}
$archive_name=$argv[2];

if(!startsWith( strtolower($archive_name) , "archive-")){//archive name doesn't start with archive- as required by wordpress to override the archive?
    $archive_name="archive-".$archive_name;//We'll add it
}

$fname=$archive_name.".php";
if(file_exists($_DIR."/../".$fname)){
    message("Archive with ".$archive_name." already exists!", "red");
    return;
}

if(isset($argv[3]) && $argv[3]==="-nomvc"){

    if(file_exists($_DIR."/../archive.php")){
        copy($_DIR."/../archive.php", $_DIR."/../".$fname);
        message("Archive with name ".$archive_name." has been copied from base archive file.", "green");
        return;
    }else{
        message("Base archive doesn't exist so task couldn't be completed.", "red");
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

//Add something here that will be appeneded to all archives at the very bottom!

';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Archive with name ".$archive_name." has been generated.", "green");