<?php
class Response {
    
    public function __construct(){
        $this->status = 2;
        $this->data = array();
    }
    
    
    /*
     * @var int $status
     */
    public $status;
    
     /*
     * @var array $message
     */
    public $message;
    
    /*
     * @var array $data
     */
    public $data;
    
    /*
     * @var DateTime $timestamp
     */
    public $timestamp;
      
    
    public function addMessage($msg){
        $this->message=$msg;
    }
    
    public function getArray(){
        return  array(
            "status" => $this->status,
            "message" => $this->message,
            "data" => $this->data
            //"timestamp" => $this->timestamp
        );
    }
}
