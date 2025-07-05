<?php    

require_once '../../database/db-conn.php';
require_once '../../class/admin/transaction-code.php';

ob_start(); // START buffering to catch unwanted output
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
$database = new Database(); 
$dbConn = Database::GetInstanceConn();
$transactionCode = new TransactionCode($dbConn);



if (!isset($_POST['action'])) {
    echo json_encode(['statuscode' => 400, 'message' => 'No action specified']);
    exit;
}


switch ($_POST['action']) {
    case 'upload_file_pdf':
        $user_id = $_POST['user_id'] ?? null;
        if (!$user_id) {
            echo json_encode(['statuscode' => 400, 'message' => 'User ID missing']);
            exit;
        }

       $transactionCode->SaveTransactionCode($user_id);
        break;
        ob_end_clean();
} 


if (isset($_POST['action']) && $_POST['action'] === "getall_transaction_code") {
    $usersFiles = $transactionCode->GetAllTransactionCode();  
    if (!empty($usersFiles )) {
        
        $output = '<table id="transaction-code-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Filename</th>   
                    <th>Filetype</th> 
                    <th>Owner</th>
                    <th>Date upload</th> 
                    <th style="width: 1rem; text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>';
        $counter = 1; 
        foreach ($usersFiles as $userFile) {      

            $owner = $userFile['firstname'] .' '. $userFile['lastname'] ;        
     
            $filename = $userFile['filename'];
            $fileType = $userFile['file_type'];

            // Get extension from filename info..
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            // Map extension to icon class..  need to explode to take away the the file ext... rod
            switch ($ext) {
                case 'pdf':
                    $iconClass = 'fa-solid fa-file-pdf text-danger';
                    break;      
                default:
                    $iconClass = 'fa-solid fa-file';
            }
            $output .= '<tr> 
            
                <td>' . $counter++ . '</td>
                <td>' . htmlspecialchars($userFile['original_name']) . '</td>        
                 <td>
                <large>
                    <span><i class="' . $iconClass . '"></i></span>
                    <small class="text-muted">(' . strtoupper($ext) . ')</small>
                </large>
            </td>    
                <td>' . htmlspecialchars($owner) . '</td>      
                <td>' . htmlspecialchars($userFile['date_created']) . '</td>
                <td class="action-container">
                   <span id="btn-view-files" data-id="' . htmlspecialchars($userFile['fileID']) . '"> <img src="../../../page/images/eye.png"></span>            
                   <span id="btn-delete-files" data-id="' . htmlspecialchars($userFile['fileID']) . '"> <img src="../../../page/images/trash.png"></span> 
                </td> 
            </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    } 
    else {
        echo '<h3 class="text-center text-secondary">No files found.</h3>';
    }
    exit; 
}  
if ($_POST['action'] === 'get_file_path') {
    $id = intval($_POST['id']);
    $transactionCode->ViewFiles($id); 
    exit;
}

?>