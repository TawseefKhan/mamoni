<?php

class CastRequest {
    static function Cast($user, $request){
        $db = Database::get();
        
        //cast to the actual id
        if($user->type=="collector")
        {
            $id = $db->select("select _form_id as id from _sync_form where _user_id = :id and local_id = :local and form_type_name = :type", 
                array(
                    ":id"=> $user->id,
                    ":local"=> $request["form_id"],
                    ":type" => $request["form_type"]
                ));
            
            //check if the form exists if not change type to add
            if(!isset($id[0]["id"]))
            {
                $request["type"]="add";
            }
            else{
                $request["type"]="update";
                $request["form_id"] = $id[0]["id"];
            }
        }
        else{
            $submitteduser = new User($request["submitted_by"]);
            //force to update
            $request["type"]="update";

            $id = $db->select("select _form_id as id from _sync_form where _user_id = :id and local_id = :local and form_type_name = :type", 
                array(
                    ":id"=> $submitteduser->id,
                    ":local"=> $request["form_id"],
                    ":type" => $request["form_type"]
                ));
            
            //check if the form exists
            if(!isset($id[0]["id"]))
            {
                throw new Exception("Cant find the form");
            }
            else{
                $request["form_id"] = $id[0]["id"];
            }
        }
        
        
        return $request;
    }
}
