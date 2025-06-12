<?php 
require_once '../../database/db-conn.php'; 
class ResolvedTickets {
    private $mysqli;

    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    }  

    public function SaveResolvedTickets($user_id) {
        header('Content-Type: application/json');
    
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['statuscode' => 400, 'message' => 'No valid file uploaded']);
            exit;
        }

        $originalName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
    
 
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $newFilename = $timestamp . '_' . $originalName;
    
        
        $uploadDir = "../../uploads/resolved-tickets/";
        $relativePath = "src/uploads/resolved-tickets/" . $newFilename;
        $targetPath = $uploadDir . $newFilename;
   
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            echo json_encode(['statuscode' => 500, 'message' => 'Failed to create upload directory']);
            exit;
        }
    
    
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            echo json_encode(['statuscode' => 500, 'message' => 'Failed to move uploaded file']);
            exit;
        }

        $stmt = $this->mysqli->prepare("CALL SaveResolvedTickets(?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            exit;
        }
    
        $stmt->bind_param('ssiss', $newFilename, $relativePath, $user_id, $fileType, $originalName);
        
        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            exit;
        }
    
        $stmt->close();
    
        echo json_encode([
            'statuscode' => 200,
            'message' => 'File uploaded successfully',
            'filename' => $newFilename,
            'type' => $fileType
        ]);
        exit;
    } 

    //GET ALL FILES Resolve tickets admin only ..rod 
    public function GetAllResolvedTicket()
    {
        $stmt = $this->mysqli->prepare("CALL GetAllResolvedTicket()");
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

?>