<?php
function showInfo($cmd, $cmd_details){
    message($cmd, "cyan");
    message($cmd_details["about"], "blue");
    if(is_array($cmd_details["usage"])){
        message("Usage:", "green");
        foreach($cmd_details["usage"] as $usage){
            message($usage, "green");
        }
    }else{
        message("Usage: ".$cmd_details["usage"], "green");
    }
    message("-----------------", "yellow");
}

if(isset($argv[2]) && $argv[2] !=""){
    if(isset($cmd_list[ $argv[2] ])){
        showInfo($argv[2], $cmd_list[ $argv[2] ]);
    }
}

    message("-----------------", "yellow");
    message("WPMVC Helper Interface", "green");
    message("All Helper Commands", "green");
    message("-----------------", "yellow");
foreach($cmd_list as $cmd=>$cmd_details){
    showInfo($cmd, $cmd_details);
}
