<?php
namespace WPMVC\Database;

class QueryResult{
    /**
     * Create new Result Instance
     * @param Array $props
     */
    public function __construct(Array $props){
        foreach($props as $key=>$value){
            $this->$key=$value;
        }
    }
}