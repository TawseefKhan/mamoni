<?php

class Meta extends FModel{
    
    /**
    * Save the meta tag for field
    *
    * @param string $type formType, forms, field
    * @param integer $id the id of the linking element
    * @param string $name name of the data
    * @param string $value the value of the data
    * @return void
    */
    static function save($type, $id, $name, $value, $valueArray=false){
        
        if($valueArray&&(!in_array($name, $valueArray)))
                return -1;
        
        //check 
        if($type=="formType"){
            $metaId = FModel::$db->select("select id from meta where name = :name and _form_type_id = :_form_type_id",
                    array(
                       ":name" =>  $name,
                        ":_form_type_id" => $id
                    )            
                );
            
            if(isset($metaId[0]))
            {
                FModel::$db->update("meta", array(
                    "value" => $value
                ),
                "id = "  .  $metaId[0]['id'] 
                );
            }
            else{
                FModel::$db->insert("meta", array(
                    "name" => $name, 
                    "value" => $value,
                    "_form_type_id" => $id
                ));
            }
        }
        elseif($type=="forms"){
            $metaId = FModel::$db->select("select id from meta where name = :name and _forms_id = :_forms_id",
                    array(
                       ":name" =>  $name,
                        ":_forms_id" => $id
                    )            
                );
            if(isset($metaId[0]))
            {
                FModel::$db->update("meta", array(
                    "value" => $value
                ),
                "id = "  .  $metaId[0]['id']      
                );
            }
            else{
                FModel::$db->insert("meta", array(
                    "name" => $name, 
                    "value" => $value,
                    "_forms_id" => $id
                ));
            }
        }
        elseif($type=="field"){
            $metaId = FModel::$db->select("select id from meta where name = :name and _field_id = :_field_id",
                    array(
                       ":name" =>  $name,
                        ":_field_id" => $id
                    )            
                );
            if(isset($metaId[0]))
            {
                FModel::$db->update("meta", array(
                    "value" => $value
                ),
                "id = "  . $metaId[0]['id']     
                );
            }
            else{
                FModel::$db->insert("meta", array(
                    "name" => $name, 
                    "value" => $value,
                    "_field_id" => $id
                ));
            }
        }
    }
    
    static function getFormMeta($formId, $valueArray=false){
        
        $queryStr=" and name in (";
        if($valueArray){
            for ($i=0; $i<count($valueArray); $i++){
                if((count($valueArray)-1)==$i){
                    
                    $queryStr .= "'" . $valueArray[$i] . "')";
                }
                else{
                    $queryStr .= "'" . $valueArray[$i] . "',";
                }
            }
        }
        else
            $queryStr="";
        
        
        $data = FModel::$db->select("select name, value from meta where _forms_id  = :formid" . $queryStr,
                array(
                    ":formid" => $formId
                ));
        
        if(isset($data[0]))
        {
            $arr;
            foreach ($data as $val){
                $arr[$val["name"]] = $val["value"];
            }
            return $arr;
        }
        else 
            return false;
    }
}


