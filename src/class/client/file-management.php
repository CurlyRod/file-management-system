<?php
 require 'custom-guid.php';

    class FileManagement {
        private $mysqli;

        public function __construct($dbConn) {
            $this->mysqli = $dbConn->getConnection();
        } 

        public function GetAllUserFilesByID($user_id)
        {
        $stmt = $this->mysqli->prepare("CALL Client_GetAllFilesByID(?)");
        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            return null;
        }

        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result();
        $userFiles = [];

        while ($row = $result->fetch_assoc()) {
            $userFiles[] = $row;
        }

        $stmt->close();
        return $userFiles;
     }
    


        public function SaveFiles($user_id) {
            header('Content-Type: application/json');
        
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['statuscode' => 400, 'message' => 'No valid file uploaded']);
                exit;
            }

            $guid = generateManualGUID(); // need to create GUID for look by index index... rod
            $originalName = $_FILES['file']['name'];
            $fileType = $_FILES['file']['type'];
        
    
            $timestamp = strtotime(date('Y-m-d H:i:s'));
            $newFilename = $timestamp . '_' . $originalName;
        
            
            $uploadDir = "../../uploads/client/";
            $relativePath = "src/uploads/client/" . $newFilename;
            $targetPath = $uploadDir . $newFilename;
    
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                echo json_encode(['statuscode' => 500, 'message' => 'Failed to create upload directory']);
                exit;
            }
        
        
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                echo json_encode(['statuscode' => 500, 'message' => 'Failed to move uploaded file']);
                exit;
            }

            $stmt = $this->mysqli->prepare("CALL SaveFilesByUser(?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
                exit;
            }
        
            $stmt->bind_param('ssisss', $newFilename, $relativePath, $user_id, $fileType, $originalName, $guid);
            
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
        
    }


?>