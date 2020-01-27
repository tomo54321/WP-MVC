<?php
namespace WPMVC\Database;

use WPMVC\Database\QueryBuilder;
/**
 * Database Prime Class
 */
class DB{
    /**
     * Set query table
     * @param String $table
     * @return WPMVC\Database\DB
     */
    public static function table(String $table){
        return new QueryBuilder($table);
    }

}