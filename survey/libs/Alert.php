<?php
class Alert
{
	private $MSG = array("ERROR"=> array(), "MESSAGE"=> array() );
	

	function __construct() {
		@session_start();
   }


	public function error_count()
	{
		return count($this->MSG["ERROR"]);
	}
	
	public function save_msg()
	{
            if(($this->MSG["ERROR"]>0) || ($this->MSG["MESSAGE"]>0)){
                    $message="";
                    foreach($this->MSG["ERROR"] as $error)
                    {
                            $message.=$error;
                    }
                    //$message.="<br /> <br />";
                    foreach($this->MSG["MESSAGE"] as $msg)
                    {
                            $message.=$msg;
                    }
                    setcookie('message',$message, time()+3600,"/");
            }
	}
	
	public function set_message($msg)
	{
		$this->MSG['MESSAGE'][]=$msg;
	}
	
	public function set_error($msg)
	{
		$this->MSG["ERROR"][]=$msg;
	}

}
