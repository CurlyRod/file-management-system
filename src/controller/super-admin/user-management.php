<?php  
 // follow the singleton pattern practice to for reusing a function and straight forward transaction.. -rod 3/06/2025
  require_once '../../database/db-conn.php';
  require_once '../../class/super-admin/user-management.php';   
  
  $database = new Database(); 
  $dbConn =  Database::GetInstanceConn();
  $userClass = new UserManagement($dbConn);

  if(isset($_POST['action']) && $_POST['action'] == "insert")
  {  
    
        $firstName = $_POST['fname']; 
        $middleName =   $_POST['mname'];
        $lastName = $_POST['lname'];  
        $email =  $_POST['email'];
        $password_hash = password_hash($_POST['user-password'], PASSWORD_DEFAULT);     
        $selectedValue = $_POST['user-role'];

        try {
            $userClass->GetRegisterUser( $firstName, $middleName, $lastName, $email, $password_hash, $selectedValue); 
        } catch (\Throwable $th) { 
            error_log('Exception occurred: ' . $th->getMessage());
        }
   }     
    
   if (isset($_POST['action']) && $_POST['action'] === "get_all") {
    $users = $userClass->GetAllUsers();

    if (!empty($users)) {
      
        $output = '<table id="user-table" class="table table-striped table-responsive" style="width:100%; font-size:0.8rem;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Role</th>

                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
        $counter = 1; 
        foreach ($users as $user) {
            
            $statusText = ($user['status_acc'] == 1) ? 'Active' : 'Inactive';
            $roleText = ""; 

            if ($user['role'] == 1) {
                $roleText = "Super Admin";
            } else if ($user['role'] == 2) {
                $roleText = "Admin";
            } else {
                $roleText = "Client";
            }            
            $output .= '<tr>
                <td>' . $counter++ . '</td>
                <td>' . htmlspecialchars($user['firstname']) . '</td>
                <td>' . htmlspecialchars($user['middlename']) . '</td>
                <td>' . htmlspecialchars($user['lastname']) . '</td>
                <td>' . htmlspecialchars($user['email']) . '</td>
                <td>' . $roleText. '</td>
         
                <td>' . htmlspecialchars($user['date_created']) . '</td>
                <td class="action-container">
                   <span id="btn-view-user" data-id="' . htmlspecialchars($user['id']) . '"> <img src="../../src/assets/images/vendor/eye.png"></span> 
                   <span id="btn-edit-user" data-id="' . htmlspecialchars($user['id']) . '"> <img src="../../src/assets/images/vendor/pencil.png"></span>  
                   <span id="btn-delete-user" data-id="' . htmlspecialchars($user['id']) . '"> <img src="../../src/assets/images/vendor/trash.png"></span> 
                </td>
            </tr>';
        }

        $output .= '</tbody></table>';

        echo $output;

    } else {
        echo '<h3 class="text-center text-secondary">No users found.</h3>';
    }

    exit;
} 
 
if (isset($_POST['action']) && $_POST['action'] === "get_by_id" && isset($_POST['id'])) {
    $userClass->GetUserById($_POST['id']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === "delete_user") {
    $id = intval($_POST['id']);
    $result = $userClass->DeleteUserById($id);
    echo json_encode($result);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'update') {

    $id = $_POST['edit-id'];
    $firstName = $_POST['editfnameModal'];
    $middleName = $_POST['editmnameModal'];
    $lastName = $_POST['editlnameModal'];
    $email = $_POST['editemailModal'];
    $role = intval($_POST['edit-user-role-modal']);
  
    $userClass->UpdateUser($id, $firstName, $middleName, $lastName, $email, $role);

    exit;
}


   
?>