<?php

class  FModel {
    
    /**
    * @var FDatabase $db \
    */
    static protected $db;
    
    public function __construct() {
        FModel::$db = FDatabase::get(); 
    }
    
    static public function init(){
        FModel::$db = FDatabase::get(); 
    }
 
    static public function computeId($value, $table, $arr, $col="id"){
        
        if(!is_numeric($value))
        {
            $query = "select $col from " . $table . " where ";
            
            $count = count($arr);
            $i=1;
            foreach ($arr as $key => $value) {
                if($count == $i)
                    $query .= " $key=:$key";
                else
                    $query .= " $key=:$key" . " and ";
                
                $i++;
            }
            
            $data = FModel::$db->select($query, $arr);
            if(isset($data[0][$col]))
                return $data[0][$col];
            else {
                throw new Exception("Please make sure the schema is matching");
            }
            
        }
        else
            return $value;
        
    }
    
}