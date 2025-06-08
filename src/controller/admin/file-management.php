
 

 <?php
require_once '../../database/db-conn.php';
require_once '../../class/admin/file-management.php';

ob_start(); // START buffering to catch unwanted output
ini_set('display_errors', 1);
error_reporting(E_ALL);


$database = new Database(); 
$dbConn = Database::GetInstanceConn();
$fileManagement = new FileManagement($dbConn);

if (!isset($_POST['action'])) {
    echo json_encode(['statuscode' => 400, 'message' => 'No action specified']);
    exit;
}

switch ($_POST['action']) {
    case 'upload_file':
        $user_id = $_POST['user_id'] ?? null;
        if (!$user_id) {
            echo json_encode(['statuscode' => 400, 'message' => 'User ID missing']);
            exit;
        }

        $fileManagement->SaveFiles($user_id);
        break;
        ob_end_clean();
} 

if (isset($_POST['action']) && $_POST['action'] === "get_all_files") {
    $usersFiles = $fileManagement->GetAllUserFiles();  
  //   echo json_encode($usersFiles);
    if (!empty($usersFiles )) {
      
        $output = '<table id="user-file-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
        $counter = 1; 
        foreach ($usersFiles as $userFile) {             
            $output .= '<tr>
                <td>' . $counter++ . '</td>
                <td>' . htmlspecialchars($userFile['filename']) . '</td>         
                <td>' . htmlspecialchars($userFile['user_id']) . '</td>
                <td>' . htmlspecialchars($userFile['date_created']) . '</td>
                <td class="action-container">
                   <span id="btn-view-user" data-id="' . htmlspecialchars($userFile['id']) . '"> <img src="../../../page/images/eye.png"></span> 
                   <span id="btn-edit-user" data-id="' . htmlspecialchars($userFile['id']) . '"> <img src="../../../page/images/pencil.png"></span>  
                   <span id="btn-delete-files" data-id="' . htmlspecialchars($userFile['id']) . '"> <img src="../../../page/images/trash.png"></span> 
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

if (isset($_POST['action']) && $_POST['action'] === "delete_files") {
    $id = intval($_POST['id']);
    $result = $fileManagement->DeleteFilesById($id); 
    echo json_encode($result);
    exit;
}
?>
