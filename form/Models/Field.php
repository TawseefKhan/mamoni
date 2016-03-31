<?php

class  Field extends FModel {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
    * Will through exception is not unique name.
    *
    * @param string $name Unique name of the field
    * @param integer $_formTypeId its parent form type
    *
    * @return integer the field id
    */
   static function create($name, $_formTypeId, $type, $category)
    {
        //check if this name exists
        $nameCount= FModel::$db->countRecords("field", "name = :name and _form_type_id = :id ", array(":name" => $name, ":id" => $_formTypeId));
        
       if($nameCount>0)
       {
           throw new Exception("The field name id not unique");
       }
       
       //insert the field
       FModel::$db->insert("field", array(
           "name" => $name,
           "type" => trim($type),
           "category" => $category,
           "_form_type_id"=> $_formTypeId
       ));
       
       return FModel::$db->lastInsertId("field_id_seq");
    }
    
    
    
    /**
    * @param string $name string or number
    *
    * @return void
    */
    static function delete($name)
    {
        if(is_numeric($name)){
            FModel::$db->delete("field", "id = " . $name, false);
        }
        else{
            FModel::$db->delete("field", "name = " . $name, false);
        }
    }
    
    
       /**
    * Get the field id from field name and field type name 
    * 
    * @param string $formTypeName 
    * @param String $fieldName 
    * 
    * @return integer the id of the field
    */
    static function getFieldId($formTypeName,$fieldName ){
        $data  = FModel::$db->select("select field_id from _field_details "
                . "where form_type_name=:type and field_name=:field ",
                array(":type"=>$formTypeName, ":field" => $fieldName)
                );
                
        if(isset($data[0]["field_id"]))
            return $data[0]["field_id"];
        else
            return -1;
    }
    
    
    /**
    * Get the field id from field name and field type name 
    * 
    * @param string $formTypeName 
    * @param String $fieldName 
    * 
    * @return integer the id of the field
    */
    static function getFieldId_byid($formTypeId,$fieldName ){
        $data  = FModel::$db->select("select field_id from _field_details "
                . "where form_type_id=:type and field_name=:field ",
                array(":type"=>$formTypeId, ":field" => $fieldName)
                );
                
        if(isset($data[0]["field_id"]))
            return $data[0]["field_id"];
        else
            return -1;
    }
    
    
    /**
     * this function will add the field id and the field type
     * @param string $formType the form type
     * @param array $data name_of_field => data
     */
    static  function populateFieldData($formType, $fieldName){
        $meta_data  = FModel::$db->select("select field_type as type, field_id as id, field_category from _field_details where "
                . "field_name = :fieldname and form_type_name = :formname ", array(
                    ":fieldname" => $fieldName,
                    ":formname" => $formType
                )); 
        
        if(isset($meta_data[0]))
        {
            $meta_data[0]["type"] = trim($meta_data[0]["type"]);
            return $meta_data[0];
        }
        else
            throw new Exception("Schema dont match");
    }
    
}