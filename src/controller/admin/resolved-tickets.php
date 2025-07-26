    <?php
    require_once '../../database/db-conn.php';
    require_once '../../class/admin/resolved-tickets.php';

    ob_start(); // START buffering to catch unwanted output
    ini_set('display_errors', 1);
    error_reporting(E_ALL);


    $database = new Database(); 
    $dbConn = Database::GetInstanceConn();
    $resolvedTickets = new ResolvedTickets($dbConn);


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

            $resolvedTickets->SaveResolvedTickets($user_id);
            break;
            ob_end_clean();
    } 


    if (isset($_POST['action']) && $_POST['action'] === "getall_resolved_tickets") {
        $usersFiles = $resolvedTickets->GetAllResolvedTicket();  
        if (!empty($usersFiles )) {
            
            $output = '<table id="resolve-tickets-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
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
                    case 'xls':
                    case 'xlsx':
                        $iconClass = 'fa-solid fa-file-excel text-success';
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
                    <span id="btn-download-files" data-id="' . htmlspecialchars($userFile['fileID']) . '"> <img src="../../src/assets/images/vendor/download.png"></span>  
                    <span id="btn-delete-files" data-id="' . htmlspecialchars($userFile['fileID']) . '"> <img src="../../src/assets/images/vendor/trash.png"></span> 
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
    if ($_POST['action'] === 'get_file_download') {
        $id = intval($_POST['id']);
        $resolvedTickets->DownloadFiles($id); 
        exit;
    }


    ?>