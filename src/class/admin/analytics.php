<?php   
class Analytics { 
    private $mysqli;

    public function __construct($dbConn) {
        $this->mysqli = $dbConn->getConnection();
    } 

    public function GetTotalMyfilesByID($Id) {   
        $userID = (int) $Id;   


        $stmt = $this->mysqli->prepare("CALL Admin_GetAllMyFiles(?)");    
        if (!$stmt) {
            die("MYSQL error: " . $this->mysqli->error);
        }

        $stmt->bind_param("i", $userID);

        // Execute
        if ($stmt->execute()) {

            // Get result
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $totalMyfiles = $row['Myfiles']; 
                $stmt->close();
                 echo json_encode(["statuscode" => 200, "total_myfile" => $totalMyfiles]);
            } else {
                $stmt->close();
               echo json_encode(["statuscode" => 404, "message" => "No files found."]);
            }

        } else {
            $stmt->close();
            return ["statuscode" => 500, "message" => "Query failed."];
        }
    } 
     public function GetTotalTransactionCount() {   
        $stmt = $this->mysqli->prepare("CALL Admin_GetAllTransactCount()");    
        if (!$stmt) {
            die("MYSQL error: " . $this->mysqli->error);
        }


        // Execute
        if ($stmt->execute()) {

            // Get result
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $totalTransac = $row['total_transac']; 
                $stmt->close();
                 echo json_encode(["statuscode" => 200, "totalTransac" => $totalTransac]);
            } else {
                $stmt->close();
               echo json_encode(["statuscode" => 404, "message" => "No files found."]);
            }

        } else {
            $stmt->close();
            return ["statuscode" => 500, "message" => "Query failed."];
        }
    } 

     public function GetTotalResolveCount() {   
        $stmt = $this->mysqli->prepare("CALL Admin_GetTotalResolveCount");    
        if (!$stmt) {
            die("MYSQL error: " . $this->mysqli->error);
        }


        // Execute
        if ($stmt->execute()) {

            // Get result
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $totalResolve = $row['total_resolve']; 
                $stmt->close();
                 echo json_encode(["statuscode" => 200, "totalResolve" => $totalResolve ]);
            } else {
                $stmt->close();
               echo json_encode(["statuscode" => 404, "message" => "No files found."]);
            }

        } else {
            $stmt->close();
            return ["statuscode" => 500, "message" => "Query failed."];
        }
    }
}


?>