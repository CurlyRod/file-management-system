    <?php 
    require 'custom-guid.php';

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

            $guid = generateManualGUID(); // need to create GUID for look by index index... rod
            $originalName = $_FILES['file']['name'];
            $fileType = $_FILES['file']['type'];
        
    
            $timestamp = strtotime(date('Y-m-d H:i:s'));
            $newFilename = $timestamp . '_' . $originalName;
        
            
            $uploadDir = "../../uploads/files/";
            $relativePath = "src/uploads/files/" . $newFilename;
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
        

        public function GetAllUserFiles()
        {
            $stmt = $this->mysqli->prepare("CALL GetAllFilesByID()");
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
                return ["statuscode" => 200, "message" => "File deleted successfully."];
            } else {
                return ["statuscode" => 500, "message" => "Deletion failed."];
            }
        
            $stmt->close();
        } 

   
    // public function ViewFiles($id)
    // {
    //     $stmt = $this->mysqli->prepare("CALL GetFilePathByID(?)");

    //     if (!$stmt) {
    //         http_response_code(500);
    //         echo json_encode(["statuscode" => 500, "message" => "MYSQL error: " . $this->mysqli->error]);
    //         return;
    //     }

    //     $stmt->bind_param("i", $id);

    //     if ($stmt->execute()) {
    //         $result = $stmt->get_result();
    //         if ($result->num_rows > 0) {
    //             $qry = $result->fetch_assoc(); 

    //             $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    //             $host = $_SERVER['HTTP_HOST'];
    //             $previewUrl = $protocol . $host . '/FMS/src/controller/admin/file-serve.php?file=' . urlencode(basename($qry['file_path'])) . '&name=' . urlencode($qry['original_name']);

    //             echo json_encode([
    //                 "statuscode" => 200,
    //                 "file_path" => $previewUrl,
    //                 "file_name" => $qry['original_name']
    //             ]);
                

    //         } else {
    //             echo json_encode(["statuscode" => 404, "message" => "File not found."]);
    //         }
    //     } else {
    //         echo json_encode(["statuscode" => 500, "message" => "Query execution failed."]);
    //     }
    // } 
    public function ViewFiles($id)
    {
        $stmt = $this->mysqli->prepare("CALL GetFilePathByID(?)");

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
                              '&path=files' . 
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
        $stmt = $this->mysqli->prepare("CALL GetFilePathByID(?)");

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
                    'path' => 'files',
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
?> 

