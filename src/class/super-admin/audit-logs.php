<?php   
class AuditLogs{

    private $mysqli;
    
    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    }

    public function AuditLog($logs)
    {
          $stmt = $this->mysqli->prepare("CALL DB_Logger(?)");
    
            if (!$stmt) {
                die("MYSQL error: " . $this->mysqli->error);
            }
    
            $stmt->bind_param("s", $logs);          
    
            if ($stmt->execute()) {
                $result = ["statuscode" => 200, "message" => "Logger Registered"];
                echo json_encode($result);
            } else {
                die("Database error: " . $stmt->error);
            }
    
            $stmt->close(); 
        }  
}


?>