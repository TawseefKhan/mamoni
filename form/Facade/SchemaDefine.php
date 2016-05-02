<?php

class  SchemaDefine {
    static function create($data){
        
        //save the form type
        $FormTypeId = FormType::create(trim($data["name"]));
        
        //save form type meta
        foreach ($data["meta"] as $key => $value) {
            Meta::save("formType",$FormTypeId,$key, $value );
        }
        
        //save the fields
        foreach ($data["fields"] as $key => $value) {
            $fieldId;
            $key=trim($key);
            if($value["type"]=="bool"){
                $fieldId = FieldBool::create($key, $FormTypeId);
            }
            elseif($value["type"]=="category"){
                $fieldId = FieldCategory::create($key, $FormTypeId, $value["options"]);
            }
            elseif($value["type"]=="date"){
                $fieldId = FieldDate::create($key, $FormTypeId);
            }
            elseif($value["type"]=="number"){
                $fieldId = FieldInt::create($key, $FormTypeId);
            }
            elseif($value["type"]=="text"){
                $fieldId = FieldText::create($key, $FormTypeId);
            }
            elseif($value["type"]=="textarray"){
                $fieldId = FieldTextArray::create($key, $FormTypeId);
            }
            elseif($value["type"]=="intarray"){
                $fieldId = FieldIntArray::create($key, $FormTypeId);
            }
            
            //save the fields meta
            if(isset($value["meta"]))
            {
                foreach ($value["meta"] as $key => $value) {
                    Meta::save("field",$fieldId,$key, $value );
                }
            }
        }
    }
    
    

    
}