<?php

class  FieldText extends Field {
    
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
    static function create($name, $_formTypeId, $type="text", $category=false)
    {
       //call the parent create
       return parent::create($name, $_formTypeId, "text", false);
    }
    
    
    
    /**
    * @param string $name string or number
    *
    * @return boolean
    */
    static function delete($name)
    {
        //get the id if name is inputed
        $id = FModel::computeId($name, '_field_details' , 
                array("field_name" => $name["field"], "form_type_name" => $name["type"] ),
                "field_id"
            );
        
        //delte the values
        FModel::$db->delete("field_text", "_field_id = " . $id, false);
        
        FModel::$db->display_errors();
        
        //delete the field
        return parent::delete($id);
    
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
        
        $fieldId = FModel::computeId($fieldId, '_field_details' , 
                array("field_name" => $fieldId["field"], "form_type_name" => $fieldId["type"] ),
                "field_id"
            );
        
        
        FModel::$db->insert("field_text", array("value" => $value, "_field_id" => $fieldId, "label" => $label));
        return FModel::$db->lastInsertId("field_text_id_seq");
    }
    
    static function getValue($fieldValueId){
        $data = FModel::$db->select("select value, label from field_text where id = :id",
                array(":id"=> $fieldValueId)
            );
        
        if(isset($data[0]))
            return $data[0]["value"];
        else
            return -1;
    }
    
    static function deleteValue($id){
        FModel::$db->delete("field_text", "id = ". $id);
    }
    
    static function update($valueId, $data, $label = 'N/A'){
        FModel::$db->update("field_text", array(
            "value"=>$data,
            "label" => $label
        ), "id = $valueId");
    }

    
}