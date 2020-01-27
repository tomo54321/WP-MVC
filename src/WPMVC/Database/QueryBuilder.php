<?php
namespace WPMVC\Database;

use WPMVC\Core\Database\MeekroDB;
use WPMVC\Core\Database\WhereClause;
use WPMVC\Database\QueryResult;

/**
 * Database Prime Class
 */
class QueryBuilder{

    private $table;
    private $select = [];//Default to all
    private $where;
    private $query;
    private $orderBy;
    private $groupBy;
    private $take="18446744073709551615";
    private $offset = 0;
    private $db; //Meekro DB Instance

    /**
     * New Instance
     * @param String $tableName
     */
    public function __construct(String $tableName){
        $this->table=$tableName;
        $this->db = new MeekroDB();
        $this->where = new WhereClause('and');
        $this->db->error_handler = $this->handle_db_error;
    }

    /**
     * Display query after executing it
     * @return $this
     */
    public function debug(){
        $this->db->debugMode(function($args){
            echo ($args["query"]);
        });
        return $this;
    }

    /**
     * Handle Error
     * @param Array $params
     */
    private function handle_db_error($params) {
        if (isset($params['query'])) $out[] = "QUERY: " . $params['query'];
        if (isset($params['error'])) $out[] = "ERROR: " . $params['error'];
        $out[] = "";
        
        if (php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
          echo implode("\n", $out);
        } else {
          echo implode("<br>\n", $out);
        }
        
        die;
    }

    /**
     * Set which rows to select
     * @param $rows
     * @return QueryBuilder
     */
    public function select($rows){
        if(\is_array($rows)){
            $this->select = array_merge($rows, $this->select);
        }else{
            array_push($this->select, $rows);
        }
        return $this;
    }

    /**
     * Handle the where clause adding
     * @param Array $rest
     * @param WhereClause $clause
     */
    private function __where_restraint($rest, $clause){
        $objKey = (sizeof($rest) === 3?2:1);
        $value = $rest[$objKey];

        $valueType = "%s";

        if($value instanceof \DateTime){
            $value = $value->format("Y-m-d H:i:s");
        }else if(is_integer($value)){
            $valueType = "%i";
        }else if(is_double($value)){
            $valueType="%d";
        }

        $what = $rest[0].(sizeof($rest) === 3?$rest[1]:"=").$valueType;
        $clause->add($what, $value);

        unset($objKey);
        unset($operation);
        unset($what);
        unset($value);
        unset($valueType);

        return $this;
    }

    /**
     * Add some query restraints
     * @param Array $restraints
     * @return QueryBuilder
     */
    public function where(Array $restraints){
        foreach($restraints as $rest){
            $this->__where_restraint($rest, $this->where);
        }
        return $this;
    }

    /**
     * Add some or where query restraints
     * @param Array $restraints
     * @return QueryBuilder
     */
    public function orWhere(Array $restraints){
        $subclause = $this->where->addClause("or");
        foreach($restraints as $rest){
            $this->__where_restraint($rest, $subclause);
        }
        return $this;
    }

    /**
     * Add some where between 
     * @param String $colName
     * @param Array $betweenValues
     * @return $this
     */
    public function whereBetween(String $colName, Array $betweenValues){       
        $valueTypeFirst = "%s";
        if($betweenValues[0] instanceof \DateTime){
            $betweenValues[0] = $betweenValues[0]->format("Y-m-d H:i:s");
        }else if(is_integer($betweenValues[0])){
            $valueTypeFirst = "%i";
        }else if(is_double($betweenValues[0])){
            $valueTypeFirst="%d";
        }
        $valueTypeSec = "%s";
        if($betweenValues[1] instanceof \DateTime){
            $betweenValues[0] = $betweenValues[1]->format("Y-m-d H:i:s");
        }else if(is_integer($betweenValues[1])){
            $valueTypeSec = "%i";
        }else if(is_double($betweenValues[1])){
            $valueTypeSec="%d";
        }

        $this->where->add($colName." BETWEEN ".$valueTypeFirst." AND ".$valueTypeSec, $betweenValues[0], $betweenValues[1]);
        return $this;
    }

    /**
     * Where not between restraint
     */
    public function whereNotBetween(String $colName, Array $betweenValues){       
        $valueTypeFirst = "%s";
        if($betweenValues[0] instanceof \DateTime){
            $betweenValues[0] = $betweenValues[0]->format("Y-m-d H:i:s");
        }else if(is_integer($betweenValues[0])){
            $valueTypeFirst = "%i";
        }else if(is_double($betweenValues[0])){
            $valueTypeFirst="%d";
        }
        $valueTypeSec = "%s";
        if($betweenValues[1] instanceof \DateTime){
            $betweenValues[0] = $betweenValues[1]->format("Y-m-d H:i:s");
        }else if(is_integer($betweenValues[1])){
            $valueTypeSec = "%i";
        }else if(is_double($betweenValues[1])){
            $valueTypeSec="%d";
        }

        $this->where->add($colName." NOT BETWEEN ".$valueTypeFirst." AND ".$valueTypeSec, $betweenValues[0], $betweenValues[1]);
        return $this;
    }

    /**
     * Where value is null
     * @param String $col
     * @return $this
     */
    public function whereNull(String $col){
        $this->where->add($colName." IS NULL");

    }

    /**
     * Order results By
     * Args are params to order by
     * @return $this
     */
    public function orderBy(){
        $this->orderBy = "ORDER BY ";
        $args = func_get_args();
        foreach($args as $arg){
            $this->orderBy.= $this->db->formatTableName($arg);
            if(end($args) !== $arg){
                $this->orderBy.=", ";
            }  

        }
        return $this;
    }

    /**
     * Group results By
     * @return $this
     */
    public function groupBy(){
        $this->groupBy = "GROUP BY ";
        $args = func_get_args();
        foreach($args as $arg){
            $this->groupBy.= $this->db->formatTableName($arg);
            if(end($args) !== $arg){
                $this->groupBy.=", ";
            }  

        }
        return $this;
    }
     
    /**
     * Generate Select String
     * @return String
     */
    private function __select_string(){

        $selectString="";//empty the string
        foreach($this->select as $row){
            $selectString.=$this->db->formatTableName($row);//Format the row
            if(end($this->select) !== $row){//If it's not the last iteration add the comma
                $selectString.=", ";
            }
        }
        if(empty($this->select)){
            $selectString="*";
        }
        return $selectString;
    }

    /**
     * Handle Get Result
     * @param $result
     * @return Array
     */
    private function __handle_get_result($result){
        if(is_null($result)){
            return null;
        }
        $items = array();
        foreach($result as $row){
            $possClassName = "App\\".\ucfirst($this->table);

            if(class_exists($possClassName)){//If model exists?
                $items[] = new $possClassName($row);
            }else{
                $items[] = new QueryResult($row);
            }

        }
        return $items;
    }

    /**
     * Set offset (rows to skip)
     * @param Int $skip
     * @return $this
     */
    public function skip($skip){
        if(!is_integer($skip)){
            throw new \Exception("Offset must be an integer.");
            return;
        }
        $this->offset=$skip;
        return $this;
    }

    /**
     * Max rows to get.
     * @param Int $get
     * @return $this
     */
    public function take($get){
        if(!is_integer($get)){
            throw new \Exception("Getter must be an integer.");
            return;
        }
        $this->take=$get;
        return $this;
    }

    /**
     * Generate limit string
     * @return String
     */
    private function __limit_string(){
        return "LIMIT ".$this->offset.",".$this->take;
    }

    /**
     * Get Columns
     * @return Array
     */
    public function columns(){
        $qres = $this->db->query("DESC ".$this->db->formatTableName($this->table));
        $res = array();
        foreach($qres as $column){
            $res[ $column["Field"] ]=$column["Default"];
        }

        return $res;
    }

    /**
     * Insert into the database
     * @param Array $params
     * @return Int
     */
    public function insert(Array $params){
        $sant_params=array();
        foreach($params as $key=>$raw_param){
            if($raw_param instanceof \DateTime){
                $raw_param = $raw_param->format("Y-m-d H:i:s");
            }
            $sant_params[$key]=$raw_param;
        }
        $this->db->insert($this->table, $sant_params);
        return $this->db->insertId();
    }

    /**
     * Update Row
     * @param Array $data
     * @return $this
     */
    public function update(Array $data){
        $this->db->update($this->table, $data, "%l", $this->where);
        return $this;
    }

    /**
     * Get result
     * @return Array
     */
    public function get(){
        $selectString = $this->__select_string();

        $result=$this->db->query("SELECT ".$selectString." 
        FROM ".$this->db->formatTableName($this->table)." WHERE %l
        ".$this->groupBy."
        ".$this->orderBy." ".$this->__limit_string()
        , $this->where);

        return $this->__handle_get_result($result);
    }

    /**
     * Get first item
     * @return Array
     */
    public function first(){
        $selectString = $this->__select_string();

        $result = $this->db->query("SELECT ".$selectString." 
        FROM ".$this->db->formatTableName($this->table). 
        " WHERE %l 
        ".$this->groupBy." 
        ".$this->orderBy." LIMIT 0,1"
        , $this->where);

        return $this->__handle_get_result($result);
    }

    /**
     * Delete from table
     * @return $this
     */
    public function delete(){
        $this->db->delete($this->table, "%l", $this->where);
        return $this;
    }

    /**
     * Get the row name of the primary key in the table
     * @return String
     */
    public function get_primary_row(){
        $result = $this->db->query("SHOW KEYS FROM ". $this->db->formatTableName($this->table). "
        WHERE Key_name = %s"
        , "PRIMARY");
        $pk = "";
        foreach ($result as $res){
            $pk = $res["Column_name"];
        }
        return $pk;
    }

}