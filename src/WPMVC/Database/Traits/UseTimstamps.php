<?php

namespace WPMVC\Database\Traits;
/**
 * Use Timestamps Trait
 * 
 * Auto fills the 'created_at' and 'updated_at' rows
 */
trait Timestamps{
    public function save(){
        $pk_row = parent::primary_key();
        if(is_null($this->$pk_row)){//It's a new instance.
            $this->created_at=date("Y-m-d H:i:s");
        }
        $this->updated_at=date("Y-m-d H:i:s");
        parent::save();
    }
}