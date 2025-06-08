
 // Insert user -rod   
$(document).on('submit', '#add-user-form', function(e) {   
    e.preventDefault();  

    var formData = $(this).serialize() + "&action=insert";
    $.ajax({
        url: "../../../controller/super-admin/user-management.php",
        type: "POST",
        data: formData,
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statuscode === 200) {
                $("#add-user-modal").modal('hide');
                $("#add-user-form")[0].reset();
                console.log(response);  
                GetAllUsers();
               
            }
        },
        error: function(error) {
            console.error("AJAX error:", error);
        }
    });
}); 
// view 


//render
$(document).ready(function () {
  
    GetAllUsers();   

    // search function... -rod
    $(document).on('keyup', '#user-search', function () {
        let value = $(this).val().toLowerCase();
        let visibleRows = 0;
    
        $('#user-table tbody tr').each(function () {
            const isVisible = $(this).text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(isVisible);
    
            if (isVisible) visibleRows++;
        });
          
        if (value === "") {
            paginateTable("#user-table", 10);
        } else {
            $('#pagination').html(''); 
        }
    }); 
});  

function GetAllUsers()
{
    $.ajax({
        url: "../../../controller/super-admin/user-management.php",
        type: "POST",
        data: { action: "get_all" },
        success: function(response) {
            $('#user-container-table').html(response); 
              paginateTable("#user-table", 10);
        }
    });
} 

$(document).on('click', '#btn-view-user', function () {
    const userId = $(this).data('id');

    $.ajax({
        url: "../../../controller/super-admin/user-management.php",
        type: "POST",
        data: {
            action: "get_by_id",
            id: userId
        },
        success: function (response) {
            const res = JSON.parse(response);

            if (res.statuscode === 200) {
                const user = res.data;

                $('#dynamic-user-modal').remove();
                const modalHtml = `
                    <div class="modal fade" id="dynamic-user-modal" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">User Info: ${user.firstname} ${user.lastname}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p><strong>Email:</strong> ${user.email}</p>
                            <p><strong>Role:</strong> ${getRoleName(user.role)}</p>
                            <p><strong>Status:</strong> ${user.status == 1 ? 'Active' : 'Inactive'}</p>
                            <p><strong>Created:</strong> ${user.date_created}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                `;
                $('body').append(modalHtml);
                const modal = new bootstrap.Modal(document.getElementById('dynamic-user-modal'));
                modal.show();
            } else {
                alert(res.message || "User not found.");
            }
        },
        error: function () {
            alert("Error loading user data.");
        }
    });
});  

// delete user 

$(document).on('click', '#btn-delete-user', function () {
    const userId = $(this).data('id');

    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: "../../../controller/super-admin/user-management.php",
            type: "POST",
            data: {
                action: "delete_user",
                id: userId
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.statuscode === 200) {
                    alert(res.message);
                    GetAllUUsers(); 
                } else {
                    alert(res.message);
                }
            }
        });
    }
});



$(document).on('click', '#btn-edit-user', function() {
    const userId = $(this).data('id');

    $.ajax({
        url: '../../../controller/super-admin/user-management.php',
        type: 'POST',
        data: { action: 'get_by_id', id: userId },
        success: function(response) {
          const res = JSON.parse(response);
            if (res.statuscode === 200) {
                $('#editUserModal #edit-id').val(res.data.id);
                $('#editUserModal #editfnameModal').val(res.data.firstname);
                $('#editUserModal #editmnameModal').val(res.data.middlename);
                $('#editUserModal #editlnameModal').val(res.data.lastname);
                $('#editUserModal #editemailModal').val(res.data.email);
                $('#editUserModal #edit-user-role-modal').val(res.data.role);

                $('#editUserModal').modal('show');
            } else {
                alert('User not found');
            }
        }
    });
});


$(document).on('submit', '#edit-user-form', function(e) {
    e.preventDefault();

    var formData = $(this).serialize() + "&action=update";

    $.ajax({
        url: '../../../controller/super-admin/user-management.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            const res = JSON.parse(response);
            if (res.statuscode === 200) {
                $('#editUserModal').modal('hide');
                alert(res.message);
                GetAllUsers(); 
            } else {
                alert('Update failed: ' + res.message);
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
        }
    });
});


function getRoleName(role) {
    switch (parseInt(role)) {
        case 1: return 'Super Admin';
        case 2: return 'Admin';
        default: return 'Client';
    }
} 

