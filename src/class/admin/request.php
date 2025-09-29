<?php
class Request{ 
    private $mysqli;

    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    }


    public function GetAllRequest()
    {
        $stmt = $this->mysqli->prepare("CALL Admin_GetAllRequest()");
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

    
    public function AcceptRequestFile($guid_file, $file_id)
    {
        $stmt = $this->mysqli->prepare("CALL Admin_AcceptRequest(?,?)");
        
        if (!$stmt) {
                return null;
            }  

        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            return;
        }

         $stmt->bind_param("si", $guid_file, $file_id);
    
        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            return;
        }

        $stmt->close(); 

        echo json_encode([
            'statuscode' => 200,
            'message' => 'File request accepted!',
        ]);
    } 


    public function DeclineRequestFile($guid_file, $file_id)
    {
        $stmt = $this->mysqli->prepare("CALL Admin_DeclinedRequest(?,?)");
        
        if (!$stmt) {
                return null;
            }  

        if (!$stmt) {
            echo json_encode(['statuscode' => 500, 'message' => 'Prepare failed: ' . $this->mysqli->error]);
            return;
        }

         $stmt->bind_param("si", $guid_file, $file_id);
    
        if (!$stmt->execute()) {
            echo json_encode(['statuscode' => 500, 'message' => 'Execute failed: ' . $stmt->error]);
            $stmt->close();
            return;
        }

        $stmt->close(); 

        echo json_encode([
            'statuscode' => 200,
            'message' => 'File request decline!',
        ]);
    }


}
