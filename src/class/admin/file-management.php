<?php
class FileManagement {
    private $mysqli;

    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    }

    public function SaveFiles($user_id) {
        header('Content-Type: application/json');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['statuscode' => 400, 'message' => 'No valid file uploaded']);
            exit;
        }

        $filename = basename($_FILES['file']['name']);
        $uploadDir ="../../uploads/files/"; 
        
        $relativePath = "src/uploads/files/" . $filename;
        $targetPath = $uploadDir . $filename;

     
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            echo json_encode(['statuscode' => 500, 'message' => 'Failed to create upload directory']);
            exit;
        }

     
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            echo json_encode(['statuscode' => 500, 'message' => 'Failed to move uploaded file']);
            exit;
        }


        $stmt = $this->mysqli->prepare("CALL SaveFiles(?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            exit;
        }

        $stmt->bind_param('ssi', $filename, $relativePath, $user_id);
        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            exit;
        }
        $stmt->close();

        echo json_encode([
            'statuscode' => 200,
            'message' => 'File uploaded successfully',
            'filename' => $filename,
            'path' => $relativePath
        ]);
        exit;
    } 

    public function GetAllUserFiles()
    {
        $stmt = $this->mysqli->prepare("CALL GetAllUserFiles()");
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

    
    public function DeleteFilesById($id) {
        $stmt = $this->mysqli->prepare("CALL DeleteFilesById(?)");
    
        if (!$stmt) {
            die("MYSQL error: " . $this->mysqli->error);
        }
    
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            return ["statuscode" => 200, "message" => "File successfully."];
        } else {
            return ["statuscode" => 500, "message" => "Deletion failed."];
        }
    
        $stmt->close();
    }
}
?>
