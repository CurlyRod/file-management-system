    var baseUrl = window.location.origin + '/file-management-system/src';   
    var absolutePath = baseUrl + "/controller/client/request.php"; 
    var user_id =  $("#user_id").val(); 

    $(document).ready(function () {  
       GetAllRequest(user_id); 
       GetStatusRequest(user_id);  
    }); 
     
    $(document).on('click', '#btn_request', function () { 
       
       var filename = $("#filename").val();
        $.ajax({
            url: absolutePath ,
            type: "POST",
            data: { action: "request_file" , user_id: user_id, filename: filename },
            success: function(response) {  
                  // do the render base on the return sample 500 .. rod
                     GetAllRequest(user_id); 
                     GetStatusRequest(user_id);
                }
            });  
    }); 

    function GetAllRequest(user_id)
    {   
        $.ajax({
            url: absolutePath,
            type: "POST",
            data: { action: "get_request_file", user_id: user_id },
            success: function(response) {
                $("#user-request-container-table").html(response); 
                paginateTable("#user-request-table", 5);   
                searchUtility("#user-request-table", "#files-search"); 
            }
        });
    }   
    function GetStatusRequest(user_id)
    {
        $.ajax({
            url: absolutePath,
            type: "POST",
            data: { action: "get_status_file", user_id: user_id },
            success: function(response) {
                $("#user-status-request-container-table").html(response)
                paginateTable("#user-request-status-table", 5, "status-paginate");    
                searchUtility("#user-request-status-table", "#status-search", "status-paginate");
            }
        });
    }

