<?php    
require_once '../../database/db-conn.php';  

class Request
{
    private $mysqli;
    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    } 
    
    public function RequestFile($guid, $filename, $user_id)
    {
        // Validation
        if (empty($filename) || empty($user_id)) {
            echo json_encode([
                'statuscode' => 400,
                'message'    => 'Filename and User ID are required!',
                'data'       => null
            ]);
            return;
        }

        $stmt = $this->mysqli->prepare("CALL RequestFile(?, ?, ?)");
        if (!$stmt) {
            echo json_encode([
                'statuscode' => 500,
                'message'    => 'Prepare failed: ' . $this->mysqli->error,
                'data'       => null
            ]);
            return;
        }

        $stmt->bind_param("ssi", $guid, $filename, $user_id);
        if (!$stmt->execute()) {
            echo json_encode([
                'statuscode' => 500,
                'message'    => 'Execute failed: ' . $stmt->error,
                'data'       => null
            ]);
            $stmt->close();
            return;
        }

        $stmt->close();

        echo json_encode([
            'statuscode' => 200,
            'message'    => 'File request submitted successfully!',
            'data'       => [
                'guid_file' => $guid,
                'filename'  => $filename,
                'user_id'   => $user_id
            ]
        ]);
    }

    public function GetAllRequestById($id)
    {
        $stmt = $this->mysqli->prepare("CALL GetRequestById(?)"); 
                
        if (!$stmt) {
            http_response_code(500);
            echo json_encode([
                "statuscode" => 500,
                "message" => "MYSQL error: " . $this->mysqli->error
            ]);
            return [];
        } 

        $stmt->bind_param("i", $id);

        $userFiles = [];

        if ($stmt->execute()) {
            $result = $stmt->get_result();  
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $userFiles[] = $row;
                }
            }
            $result->free();
        }

        $stmt->close();
        $this->mysqli->next_result();

        return $userFiles;
    }  
  

    public function GetAllRequestTransactionById($id)
    {
        $stmt = $this->mysqli->prepare("CALL Client_GetTransationFile(?)"); 
                
        if (!$stmt) {
            http_response_code(500);
            echo json_encode([
                "statuscode" => 500,
                "message" => "MYSQL error: " . $this->mysqli->error
            ]);
            return [];
        } 

        $stmt->bind_param("i", $id);

        $userFiles = [];

        if ($stmt->execute()) {
            $result = $stmt->get_result();  
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $userFiles[] = $row;
                }
            }
            $result->free();
        }

        $stmt->close();
        $this->mysqli->next_result();
        return $userFiles;
    }  
 


    

}

?>