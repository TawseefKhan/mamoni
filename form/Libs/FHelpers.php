<?php

class FHelpers {
    static function getFieldType($type, $cat){
        $cls;
        $type=trim($type);
        
        if(($type=="text")&&($cat)){
            $cls = new FieldCategory();
        }
        else if($type=="text"){
            $cls = new FieldText();
        }
        else if($type=="bool"){
            $cls = new FieldBool();
        }
        else if($type=="date"){
            $cls = new FieldDate();
        }
        else if($type=="number"){
            $cls = new FieldInt();
        }
        
        else if($type=="textarray"){
            $cls = new FieldTextArray();
        }
        
        else if($type=="intarray"){
            $cls = new FieldTextArray();
        }
        return $cls;
    }
}
