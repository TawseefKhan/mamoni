<?php

class ApiEncode {
    
    static public function printJson($arr){
        ob_clean();
        header("Content-Type: application/json");
        echo json_encode($arr);
    }
}
