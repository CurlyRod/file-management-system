
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
    
      $(document).on('click', '#accept_file_request', function () { 
        let fileGuid = $("#file_id").data("id");
     console.log("Clicked file guid:", fileGuid);
        const fileID = $(this).data('id');
        if (confirm("Are you sure you want to approve this File request?")) {
            $.ajax({
                url: absolutePath,
                type: "POST",
                data: {
                    action: "accept_file_client",
                    id: fileID
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.statuscode === 200) {
                        alert(res.message);
                        GetAllUserFiles(); 
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });