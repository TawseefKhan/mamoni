<?php
class User {
    
    function __construct($user_name) {
        $this->db = Database::get();
        $data = $this->db->select("select * from users where email = :username",array(
            ":username" => $user_name
        ));
        
        if(!isset($data[0])){
            throw new Exception("Who is this submitted User!");
        }
        
        $this->id = $data[0]["id"];
        $this->username = $data[0]["email"];
        $this->type = $data[0]["type"];
        $this->districtId = $data[0]["_district_id"];
    }
    
    /**
    * @var Database $db 
    */
    private $db;
    
    /**
    * @var integer $id 
    */
    public $id;
    
    /**
    * @var string $username 
    */
    public $username;
    
    /**
    * @var string $type 
    */
    public $type;
    
    /**
    * @var string $destrict 
    */
    public $districtId;
    
        
    static public function getUsernameById($id){
        $dt = Database::get();
        $data  = $dt->select("select email from users where id = :id", array(":id"=>$id));
        if(isset($data[0]))
            return $data[0]["email"];
        else
            return -1;
    }
}
