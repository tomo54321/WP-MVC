<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Category name is required!", "red");
    return;
}
$category_name=$argv[2];

if(!startsWith( strtolower($category_name) , "category-")){//category name doesn't start with category- as required by wordpress to override the category?
    $category_name="category-".$category_name;//We'll add it
}

$fname=$category_name.".php";
if(file_exists($_DIR."/../".$fname)){
    message("Category with ".$category_name." already exists!", "red");
    return;
}

if(isset($argv[3]) && $argv[3]==="-nomvc"){

    if(file_exists($_DIR."/../category.php")){
        copy($_DIR."/../category.php", $_DIR."/../".$fname);
        message("Category with name ".$category_name." has been copied from base category file.", "green");
        return;
    }else{
        message("Base category doesn't exist so task couldn't be completed.", "red");
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

//Add something here that will be appeneded to all categorys at the very bottom!

';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Category with name ".$category_name." has been generated.", "green");