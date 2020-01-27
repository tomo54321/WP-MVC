<?php
namespace WPMVC\Database;
/**
 * Database Model Class
 */
use WPMVC\Database\DB;
class Model{

    private $columns;

    /**
     * New instance of model
     * @param Array $props
     * @return $this
     */
    public function __construct(Array $props = array()){
        if(empty($props)){//Predefined Model
            $props = DB::table($this->get_table())->columns();
        }

        foreach($props as $key=>$value){
            $this->$key=$value;
            $this->columns[]=$key;
        }
    }

    /**
     * Save Changes
     * @return $this
     */
    public function save(){
        $pk_row = $this->primary_key();
        $q_builder = DB::table($this->get_table());

        $row_prep = array();

        foreach($this->columns as $col){
            $row_prep[$col]=$this->$col;
        }

        if(is_null($this->$pk_row)){//Insert into database

            $this->$pk_row = $q_builder->insert($row_prep);//Returns the ID of new row

        }else{//Update existing resource

            $q_builder->where([[$pk_row, $this->$pk_row]])->update($row_prep);

        }
    }

    /**
     * Get the table name in database
     * @return String
     */
    public static function get_table(){
        $class = explode("\\", get_called_class());
        return strtolower($class[count($class)-1]);
    }

    /**
     * Get the primary key row name
     * @return String
     */
    protected static function primary_key(){
        return DB::table(self::get_table())->get_primary_row();
    }

    /**
     * Find row with by primary key
     * @param $param
     * @return QueryResult
     */
    public static function find($param){
        $pk = self::primary_key();
        $result = DB::table(self::get_table())
        ->where([[$pk, $param]])
        ->first();
        return is_null($result)?null:$result[0];
    }

    /**
     * Get all rows
     * @return Array
     */
    public static function all(){
        $pk = self::primary_key();
        $result = DB::table(self::get_table())
        ->get();
        return $result;
    }

    /**
     * Call where and use the QueryBuilder
     * @param Array $params
     * @return QueryBuilder
     */
    public static function where(Array $params){
        return DB::table(self::get_table())->where($params);
    }

    /**
     * Call select and use the QueryBuilder
     * @param $params
     * @return QueryBuilder
     */
    public static function select($params){
        return DB::table(self::get_table())->select($params);
    }

}