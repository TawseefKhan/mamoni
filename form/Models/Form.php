<?php

class Form extends FModel{
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * creates a new for of a certain type.. will throw exception if not found
     * 
     * @param integer $formTypeId can be integer or string 
     * @return integer -1 or the id
     * 
     */
    static function save($formTypeId){
        
        if(!is_numeric($formTypeId)){
            $formTypeId = FormType::getId($formTypeId);
            
            if($formTypeId==-1)
                throw new Exception("sorry no form type of this sort");
        }
        
        FModel::$db->insert("forms", array("_form_type_id" => $formTypeId));
        
        return  FModel::$db->lastInsertId("forms_id_seq");
    }
    
    
    static function saveData($formId,$valueId, $info_id){
        FModel::$db->insert("forms_data", array(
                "_forms_id" => $formId,
                "_field_value_id" =>$valueId,
                "_field_id" => $info_id                  
            ));
    }
    
    static function getFields($formId){
        return FModel::$db->select("select * from _repo where _forms_id = :formid", array(
            ":formid" => $formId
        ));
    }
    
    /**
     * Does not work yet!!
     * 
     */
    static function clearForm($formId){
        $fields = Form::getFields($formId);
        foreach ($fields as $field){
            $cls = Helpers::getFieldType($field["field_type"], $field["field_category"]);
            $cls->deleteValue($field["_field_value_id"]);
        }
    }
    
    
    static function updateform($formId, $data, $meta=false){
        //get the form type
        $formType = FModel::$db->select("select * from _form_details where form_id = :id", array(
            ":id" => $formId
        ));

        if(isset($formType[0]))
            $formType = $formType[0];
        else
            throw new Exception ("Sorry this form do not exist");
            
        
        //loop through the fields
        foreach ($data as $key => $value)
        {
            //see if this field has already been entried
            $count = FModel::$db->countRecords("_repo", "_forms_id = :formid and field_name = :fieldname", 
                array(
                    ":formid" => $formId,
                    ":fieldname" => $key
                )
            );
            
            if($count==0){  //if not add it
                //get the field id,type
                $info = Field::populateFieldData($formType["form_type_name"], $key);

                //get the type of field class
                $cls = FHelpers::getFieldType($info["type"],$info["field_category"]);

                //get the value id + save it
                $valueId = $cls->save($info["id"], $value);

                //save the data + make the link or so to speak
                Form::saveData($formId, $valueId, $info["id"]);
            }
            else{ //if it had update it

                //get the value id, type
                $field_info = FModel::$db->select("select * from _repo where _forms_id = :formid and field_name = :fieldname",
                    array(
                        ":formid" => $formId,
                        ":fieldname" => $key
                    )
                );
                $field_info = $field_info[0];
                
                //get the respective class
                $cls = FHelpers::getFieldType($field_info["field_type"],$field_info["field_category"]);
                
                //update it different for cat value
                if(is_a($cls, "FieldCategory")){
                    
                    $value = $cls->getFieldValueId($field_info["_field_id"], $value);
                    
                    if($value==-1)
                        throw new Exception("This value is not allowed for the given field");
                    
                    FModel::$db->update("forms_data",
                            array("_field_value_id" => $value),
                            "_field_id = " . $field_info["_field_id"] . " and _forms_id = " . $formId      
                    );
                }
                else
                    $cls->update($field_info["_field_value_id"], $value);
            }
        }
        
            
        //save the meta
        if($meta!=false){
            foreach ($meta as $key => $value) {
                Meta::save("forms", $formId, $key, $value);
            }
        }   
    }
    
    /**
     * this function will add the data of a form
     * @param string $formType the form type
     * @param array $data name_of_field => data
     */
    static function addForm($formType, $data, $meta=false){
        //add / get the form
        $formId = Form::save(trim($formType));
        
        foreach ($data as $key => $value) {
            $key=trim($key);
            //get the field id/type
            $info = Field::populateFieldData($formType, $key);
            
            //get the type of field class
            $cls = FHelpers::getFieldType($info["type"],$info["field_category"]);
            
            //get the value id
            $valueId = $cls->save($info["id"], $value);
            
            //save the data
            Form::saveData($formId, $valueId, $info["id"]);
            
            //savet he meta
            if($meta!==false){
                foreach ($meta as $key => $value) {
                    Meta::save("forms", $formId, $key, $value);
                }
            }
        }
        return $formId;
    }
    
    static function deleteForm($form_id){
        //delete form meta
        FModel::$db->delete("meta", "_forms_id = $form_id");
        
        //using _repo delete all the field values
        $field_value_ids = FModel::$db->select("select * from _repo where _forms_id = $form_id");
        foreach ($field_value_ids as $valueId){
            $cls = FHelpers::getFieldType($valueId["field_type"],$valueId["field_category"]);
            $cls->deleteValue($valueId["_field_value_id"]);
        }
        
        //delete forms_data
        FModel::$db->delete("forms_data", "_forms_id = $form_id");
        
        //delete sync
        FModel::$db->delete("sync", "_form_id = $form_id");
        
        //delete forms
        FModel::$db->delete("forms", "id = $form_id");
        
        //FDatabase::display_errors();
        
        return true;
    }
    
    static function getFormType($form_id){
        $formType = FModel::$db->select("select form_type_name from _repo where _forms_id = :form_id",
                array(
                    ":form_id" => $form_id
                )
            );
        
        if(!isset($formType[0]))
        {
            return -1;
        }
        else{
            return $formType[0]["form_type_name"];
        }
    }
    
}
