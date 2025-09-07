<?php    
require_once '../../database/db-conn.php'; 
class Request
{
    private $mysqli;
    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    } 
    
    public function RequestFile($filename, $user_id)
    {   
        if(!isset($filename) && !isset($user_id)){
             echo json_encode(['statuscode' => 500, 'message' => 'Filename is required!']);
             return;
        } 

        $stmt = $this->mysqli->prepare("CALL RequestFile(?, ?)");
        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            return;
        }  
        
        $stmt->bind_param("si", $filename, $user_id);
        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            return;
        } 
        $stmt->close();

        echo json_encode([
            'statuscode' => 200,
            'message' => 'File request submitted successfully!',
            'filename' => $filename,
        ]);

   }

}

?>