    var baseUrl = window.location.origin + '/file-management-system/src';   
    var absolutePath = baseUrl + "/controller/client/request.php"; 
    var user_id =  $("#user_id").val(); 
    let guid;

    $(document).ready(function () {  
        GetAllRequest(user_id); 
        GetStatusRequest(user_id);   
        GetAllTransactioCode(); 

        $('#select-request-file').on('change', function() {
            guid = $(this).val(); 
            //  var filename = $('#select-request-file option:selected').text(); 
            // console.log("Selected GUID:", guid);
            // console.log("Selected Filename:", filename);
        });
    });  
    
    
    $(document).on('click', '#btn_request', function () {
    if (confirm("Do you want to proceed with requesting this file?")) {
        let guid     = $('#select-request-file').val();
        let filename = $('#select-request-file option:selected').text();

        console.log("Sending Request:", { guid, filename, user_id });

        $.ajax({
            url: absolutePath,
            type: "POST",
            dataType: "json",  
            data: {
                action: "request_file",
                user_id: user_id,
                filename: filename,
                guid_file: guid
            },
            success: function (res) {
                console.log("Response from PHP:", res);

                if (res.statuscode === 200) {
                  
                    GetAllRequest(user_id);
                    GetStatusRequest(user_id);

                    GetAllTransactioCode().done(() => {
                        $('#select-request-file').val(null).trigger('change');
                    });

                    toastModal(res.message);
                } else {
                
                    toastModal(res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
            }
        });
    }
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
    function GetAllTransactioCode() {
        return $.ajax({
            url: absolutePath,
            type: "POST",
            dataType: "json",
            data: { action: "getall_transaction_code", user_id: user_id },
            success: function(response) {
            
                let dataArray = Array.isArray(response) ? response : [];

                $('#select-request-file').empty();

                if ($.fn.select2 && $('#select-request-file').hasClass("select2-hidden-accessible")) {
                    $('#select-request-file').select2('destroy');
                }

                if (dataArray.length > 0) {
                    let selectData = dataArray.map(item => ({
                        id: item.guid_file,
                        text: item.filename
                    }));

                    $('#select-request-file')
                        .append('<option></option>')
                        .select2({
                            allowClear: true,
                            placeholder: "Choose File.",
                            data: selectData,
                            width: '100%'
                        });
                } else {
                    $('#select-request-file').select2({
                        placeholder: "No files available",
                        width: '100%'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
            }
        });
    }

    function toastModal(result)
    {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr.success(result); 
    }