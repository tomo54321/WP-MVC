<?php 
if(!isset($argv[2]) || $argv[2] ==""){
    message("Controller name is required!", "red");
    return;
}
$controller_name=$argv[2];

if(!endsWith( strtolower($controller_name) , "controller")){//Controller name doesn't end in controller?
    $controller_name.="Controller";//We'll add it for best practise.
}

if (!file_exists($_DIR."/Controllers")) {
    mkdir($_DIR."/Controllers", 0777, true);
}

$fname=$controller_name.".php";
if(file_exists($_DIR."/Controllers/".$fname)){
    message("Controller ".$controller_name." already exists!", "red");
    return;
}

$fhandler = fopen($_DIR."/Controllers/".$fname, 'w');

$controller_content = '//';
if(isset($argv[3]) && $argv[3]==="-show"){
    $controller_content = '
    /**
     * Show view
     * @param Request $request
     * @return Response
    */
    public function show(Request $request){
        //
    }
    ';
}


$contents =
'<?php
namespace App\Controllers;

use WPMVC\Core\Request\Request;
use WPMVC\Core\Controller;

class '.$controller_name.' extends Controller{

    '.$controller_content.'

}';

fwrite($fhandler,$contents);

fclose($fhandler);

message("Controller with name ".$controller_name." has been created.", "green");
