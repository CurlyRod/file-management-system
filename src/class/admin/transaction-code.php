   <?php 
   require_once '../../database/db-conn.php'; 
    class TransactionCode{
        private $mysqli;

        public function __construct($dbConn) {
            $this->mysqli = $dbConn->getConnection();
        } 

  public function SaveTransactionCode($user_id) {
    header('Content-Type: application/json');


    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['statuscode' => 400, 'message' => 'No valid file uploaded']);
        return;
    }

    $originalName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $timestamp = time();
    $newFilename = $timestamp . '_' . $originalName;

   
    $uploadDir = "../../uploads/transaction-code/";
    $relativePath = "src/uploads/transaction-code/" . $newFilename;
    $targetPath = $uploadDir . $newFilename;

   
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo json_encode(['statuscode' => 500, 'message' => 'Failed to create upload directory']);
            return;
        }
    }

  
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        echo json_encode(['statuscode' => 500, 'message' => 'Failed to move uploaded file']);
        return;
    }

   
    $stmt = $this->mysqli->prepare("CALL SaveTransactionCode(?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
        return;
    }

    $stmt->bind_param('ssiss', $newFilename, $relativePath, $user_id, $fileType, $originalName);

   
    if (!$stmt->execute()) {
        echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }

    $stmt->close();

 
    echo json_encode([
        'statuscode' => 200,
        'message' => 'File uploaded and recorded successfully',
        'filename' => $newFilename,
        'type' => $fileType
    ]);
}



   //GET ALL FILES Resolve tickets admin only ..rod 
    public function GetAllTransactionCode()
    {
        $stmt = $this->mysqli->prepare("CALL GetAllTransactionCode()");
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


    public function ViewFiles($id)
    {
        $stmt = $this->mysqli->prepare("CALL GetPDFTransactionCode(?)");

        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["statuscode" => 500, "message" => "MYSQL error: " . $this->mysqli->error]);
            return;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $qry = $result->fetch_assoc(); 

                $storedFile = basename($qry['file_path']); 
                $originalName = $qry['original_name'];     
                
                $previewUrl = 'public/view-file.php?file=' . urlencode($storedFile) . 
                              '&path=tc' . 
                              '&name=' . urlencode($originalName);
                
                echo json_encode([
                    "statuscode" => 200,
                    "file_path" => $previewUrl,
                    "file_name" => $originalName
                ]);
            }
            
            else {
                echo json_encode(["statuscode" => 404, "message" => "File not found."]);
            }
        } else {
            echo json_encode(["statuscode" => 500, "message" => "Query execution failed."]);
        }
    }

    public function DownloadFiles($id)
    {
        $stmt = $this->mysqli->prepare("CALL GetPDFTransactionCode(?)");

        if (!$stmt) {
            http_response_code(500);
            echo json_encode([
                "statuscode" => 500,
                "message" => "MYSQL error: " . $this->mysqli->error
            ]);
            return;
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $qry = $result->fetch_assoc();

                $storedFile   = basename($qry['file_path']);
                $originalName = $qry['original_name'];

            
                $baseUrl = '/file-management-system/public/download-file.php';

                $downloadUrl = $baseUrl . '?' . http_build_query([
                    'file' => $storedFile,
                    'path' => 'tc',
                    'name' => $originalName
                ]);

                echo json_encode([
                    "statuscode" => 200,
                    "file_name" => $originalName,
                    "download_url" => $downloadUrl
                ]);
            } else {
                echo json_encode([
                    "statuscode" => 404,
                    "message" => "File not found."
                ]);
            }
        } else {
            echo json_encode([
                "statuscode" => 500,
                "message" => "Query execution failed."
            ]);
        }
    }

}