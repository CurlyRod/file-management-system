
    var baseUrl = window.location.origin + '/file-management-system/src';  
    var absolutePath = baseUrl + "/controller/admin/request.php";  

    $(document).ready(function () {
        GetAllRequest();
    });

function GetAllRequest() {
    $.ajax({
        url: absolutePath,
        type: "POST",
        data: { action: "get_all_request_files" },
        success: function (response) {
            $('#request-files-container-table').html(response);
            const rowCount = $("#request-file-table tbody tr").length;
            if (rowCount > 0) {
                paginateTable("#request-file-table", 10);
                searchUtility("#request-file-table", "#files-search");
            } else {
           
                $("#pagination").empty();
            }
        }
    });
}

    
      $(document).on('click', '#accept_file_request', function () { 
        let fileGuid = $("#file_id").data("id");

        const fileID = $(this).data('id'); 
        if (confirm("Are you sure you want to approve this File request?")) {
            $.ajax({
                url: absolutePath,
                type: "POST",
                data: {
                    action: "accept_file_client",
                    file_id: fileID, 
                    guid_file: fileGuid
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.statuscode === 200) {
                      toastModal(res.message); 
                      GetAllRequest();
                    } else {
                         toastModal(res.message, "warning");
                    }
                }
            });
        }
    }); 


    
      $(document).on('click', '#decline_file_request', function () { 
        let fileGuid = $("#file_id").data("id");
        const fileID = $(this).data('id'); 
        if (confirm("Are you sure you want to decline this File request?")) {
            $.ajax({
                url: absolutePath,
                type: "POST",
                data: {
                    action: "decline_file_client",
                    file_id: fileID, 
                    guid_file: fileGuid
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.statuscode === 200) {
                      toastModal(res.message); 
                      GetAllRequest();
                    } else {
                         toastModal(res.message, "warning");
                    }
                }
            });
        }
    });