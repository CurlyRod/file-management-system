$(document).ready(function () {
    GetAllRequest();
});

function GetAllRequest()
{
    $.ajax({
        url: "../../../controller/admin/request.php",
        type: "POST", 
        data: { action: "get_all_request_files" },
        success: function(response) {  
        //console.log(response); 
        $('#request-files-container-table').html(response);      
        paginateTable("#request-file-table", 10); 
        }
    });
}  