<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Model name is required!", "red");
    return;
}
$table_name=ucfirst(strtolower($argv[2]));
$fname=$table_name.".php";

if (!file_exists($_DIR."/Models")) {
    mkdir($_DIR."/Models", 0777, true);
}

if(file_exists($_DIR."/Models/".$fname)){
    message("Model for table ".$table_name." already exists!", "red");
    return;
}

$fhandler = fopen($_DIR."/Models/".$fname, 'w');



$contents =
'<?php
namespace App;

use WPMVC\Database\Model;

class '.$table_name.' extends Model{

    //

}';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Model for table ".$table_name." has been created.", "green");