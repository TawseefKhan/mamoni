<?php

class  FieldTextArray extends FieldText {
    
    public function __construct() {
        parent::__construct();
    }
    
     
    /**
    * Will through exception is not unique name.
    *
    * @param string $name Unique name of the field
    * @param integer $_formTypeId its parent form type
    *
    * @return integet the field id
    */
    static function create($name, $_formTypeId, $type="textarray", $category=false)
    {
       //call the parent create
       return parent::create($name, $_formTypeId, "textarray", false);
    }
    
    
   
    /**
    * Save a field data
    * 
    * @param integer $fieldId Id of the field or the formtype name and field name
    * @param String $value 
    * @param String $label 
    * 
    * @return integer the newly made value id
    */
    static function save($fieldId , $value, $label="N/A"){  
        $json;
        try{
            $json = json_encode($value);
        } catch (Exception $ex) {
            throw new Exception("Incorrect json");
        }
            
        return parent::save($fieldId, $json,$label);
    }
    
    static function getValue($fieldValueId){
        $num = parent::getValue($fieldValueId);
        
        if($num==-1)
            return -1;
        else
            return json_decode ($num);
    }
    

    static function update($valueId, $data, $label = 'N/A'){
        $json;
        try{
            $json = json_encode($data);
        } catch (Exception $ex) {
            throw new Exception("Incorrect json");
        }
        
        return parent::update($valueId, $json, $label);
    }

    
}