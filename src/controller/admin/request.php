<?php
require_once '../../database/db-conn.php';
require_once '../../class/admin/request.php';

ob_start(); // START buffering to catch unwanted output
ini_set('display_errors', 1);
error_reporting(E_ALL);


$database = new Database(); 
$dbConn = Database::GetInstanceConn();
$fileRequest = new Request($dbConn);

if (isset($_POST['action']) && $_POST['action'] === "get_all_request_files") {
    $usersFiles = $fileRequest->GetAllRequest();  
  //   echo json_encode($usersFiles);
    if (!empty($usersFiles )) {
        
        $output = '<table id="request-file-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
            <thead>
                <tr>
                    <th>#</th>
                     <th>Name</th>
                    <th>Filename</th>   
                    <th>Filetype</th> 
                     <th>Date Request</th> 
                    <th style="width: 1rem; text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>';
        $counter = 1; 
        foreach ($usersFiles as $userFile) {      

            $owner = $userFile['firstname'] .' '. $userFile['lastname'] ;        
     
            $filename = $userFile['filename'];

            // Get extension from filename
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            // Map extension to icon class
            switch ($ext) {
                case 'pdf':
                    $iconClass = 'fa-solid fa-file-pdf text-danger';
                    break;
                case 'doc':
                case 'docx': 
                    $iconClass = 'fa-solid fa-file-word text-primary';
                    break;
                case 'xls':
                case 'xlsx':
                    $iconClass = 'fa-solid fa-file-excel text-success';
                    break;
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'gif':
                    $iconClass = 'fa-solid fa-file-image text-primary';
                    break;
                case 'zip':
                case 'rar':
                    $iconClass = 'fa-solid fa-file-archive text-warning';
                    break;
                case 'txt':
                    $iconClass = 'fa-solid fa-file-lines text-primary';
                    break;
                default:
                    $iconClass = 'fa-solid fa-file';
            }
            $output .= '<tr> 
            
                <td>' . $counter++ . '</td>
                  <td>' . htmlspecialchars($owner) . '</td>  
                     <td>' . htmlspecialchars($userFile['filename']) . '</td>   
                 <td>
                <large>
                    <span><i class="' . $iconClass . '"></i></span>
                    <small class="text-muted">(' . strtoupper($ext) . ')</small>
                </large>
            </td>     
                <td>' . htmlspecialchars($userFile['date_created']) . '</td>
                <td class="action-container">
                   <span id="btn-view-files" data-id="' . htmlspecialchars($userFile['id']) . '"> <button class="btn btn-primary btn-sm">Accept</button></span> 
                         <span id="btn-view-files" data-id="' . htmlspecialchars($userFile['id']) . '"> <button class="btn btn-danger btn-sm">Decline</button></span> 
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

?>