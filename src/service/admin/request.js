
    var baseUrl = window.location.origin + '/file-management-system/src';  
    var absolutePath = baseUrl + "/controller/admin/request.php";  

    $(document).ready(function () {
        GetAllRequest();
    });

    function GetAllRequest()
    {
        $.ajax({
            url: absolutePath,
            type: "POST", 
            data: { action: "get_all_request_files" },
            success: function(response) {  
            $('#request-files-container-table').html(response);      
                paginateTable("#request-file-table", 10);   
                searchUtility("#request-file-table", "#files-search"); 
            }
        });
}  