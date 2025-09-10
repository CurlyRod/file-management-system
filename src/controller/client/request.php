<?php
    require_once '../../database/db-conn.php';
    require_once '../../class/client/request.php';

    ob_start(); // START buffering to catch unwanted output
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
 

    $database = new Database(); 
    $dbConn = Database::GetInstanceConn();  
    $request = new Request($dbConn);

    if($_POST['action'] === "request_file")
    {
         $request->RequestFile($_POST["filename"], $_POST["user_id"]); 
         exit;
    }   
     if($_POST['action'] === "get_status_file")
     {
        $usersFiles = $request->GetAllRequestById($_POST["user_id"]);  
         $counter = 1; 

         if (!empty($usersFiles))
         { 
            $output = '<table id="user-request-status-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Filename</th>   
                        <th>Date Requested</th>   
                        <th>Status</th>  
                    </tr>
                </thead>
                <tbody>';
            $counter = 1; 
            foreach ($usersFiles as $userFile) 
            {   
             $filename = $userFile['filename'];   
             
             $status = '';
             if($userFile['status'] == 1)
             {
                $status = '<div class="bg-success status-container">
                               Approved
                            </div>';
             }else
             {
               $status = '<div class="bg-warning status-container">
                             Pending
                         </div>';
             }
             
             $output .= '<tr> 
                             <td>' . $counter++ . '</td>
                             <td>' . htmlspecialchars($userFile['filename']). '</td> 
                             <td>' . $userFile['date_created'] . '</td> 
                             <td>' . $status . '</td>
                        </tr>';    
            } 
            $output .= '</tbody></table>';
            echo $output;
       }
       else
       { 
          echo '<h3 class="text-center text-secondary">No files found.</h3>';
       }
   }

    if($_POST['action'] === "get_request_file")
    {   
         $usersFiles = $request->GetAllRequestById($_POST["user_id"]);  
 

         if (!empty($usersFiles))
         { 
            $output = '<table id="user-request-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Filename</th>   
                        <th>File Type</th>    
                        <th>Date Requested</th>   
                    </tr>
                </thead>
                <tbody>';
            $counter = 1; 
            foreach ($usersFiles as $userFile) 
            {   
             $filename = $userFile['filename'];   
             
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

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
                    $ext = 'FILE';
            }

             $output .= '<tr> 
                             <td>' . $counter++ . '</td>
                             <td>' . htmlspecialchars($userFile['filename']). '</td> 
                             <td>  
                                <large>
                                    <span><i class="' . $iconClass . '"></i></span>
                                    <small class="text-muted">(' . strtoupper($ext) . ')</small>
                                </large>
                            </td>
                             <td>' . $userFile['date_created'] . '</td> 
                        </tr>';    
            } 
            $output .= '</tbody></table>';
            echo $output;
       }
       else
       { 
          echo '<h3 class="text-center text-secondary">No files found.</h3>';
       }
   }  

  

?>