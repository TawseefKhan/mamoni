<?php

class  FieldIntArray extends FieldTextArray {
    
    public function __construct() {
        parent::__construct();
    }
    
    static function getValue($fieldValueId){
        
        $num = parent::getValue($fieldValueId);
        $arr = (array)  json_decode($num);
        
        $rarr=array();
        foreach ($arr as $key => $value){
            $rarr[]=  intval($value);
        }
        
        
        return json_encode($rarr);
    }
}