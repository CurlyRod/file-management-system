<?php
class Request{ 
    private $mysqli;

    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    }


    public function GetAllRequest()
    {
        $stmt = $this->mysqli->prepare("CALL GetAllRequest()");
            if (!$stmt) {
                return null;
            }
        
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $userFiles = [];
        
                while ($row = $result->fetch_assoc()) {
                    $userFiles[] = $row;
                }    
                return $userFiles;
            }     
            return null;
    } 

}
