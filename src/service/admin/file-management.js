    function GetAllFolders()
    {
        $.ajax({
            url: "../../../controller/admin/files-management.php",
            type: "POST",
            data: { action: "get_all_folders" },
            success: function(response) {
            $("#user-files-container-table").html(response);
            }
        });
    }  

    

    $(document).on('click', '#add-user-files', function () {
        const modalHTML = `
        <div class="modal fade" id="uploadModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="upload-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload File</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" class="form-control mb-3" required>
                            <input type="hidden" name="user_id" value="3">

                            <div class="progress mb-2" style="height: 20px;">
                                <div id="upload-progress" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                            </div>
                            <div id="upload-status" class="text-center text-muted"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        `;

        $('#modal-container').html(modalHTML);
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    });


    $(document).on('submit', '#upload-form', function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);
        formData.append("action", "upload_file");

        $.ajax({
            xhr: function () {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        const percent = Math.round((evt.loaded / evt.total) * 100);
                        $("#upload-progress").css("width", percent + "%").text(percent + "%");
                    }
                }, false);
                return xhr;
            },
            url: "../../../controller/admin/file-management.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                console.log("Raw response object:", res); 
                // if (res.statuscode === 200) {
                //     $("#upload-status").text(res.message).removeClass("text-muted").addClass("text-success");
                // } else {
                //     $("#upload-status").text(res.message).addClass("text-danger");
                // } 
                
                if (res.statuscode === 200) {
                
                    $('#uploadModal').modal('hide'); 
            
                    $('#upload-form')[0].reset();
                    $("#upload-progress").css("width", "0%").text("0%");
                    $("#upload-status").text(""); 


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
                    
                    toastr.success(res.message); 
                    GetAllUserFiles();
                }          
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                $("#upload-status").text("Upload failed.").removeClass("text-muted").addClass("text-danger");
            }
        });
    });  



    $(document).ready(function () {
    
        GetAllUserFiles();   

        // search function... -rod
        $(document).on('keyup', '#files-search', function () {
            let value = $(this).val().toLowerCase();
            let visibleRows = 0;
        
            $('#user-file-table tbody tr').each(function () {
                const isVisible = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(isVisible);
        
                if (isVisible) visibleRows++;
            });
            
            if (value === "") {
                paginateTable("#user-file-table", 10);
            } else {
                $('#pagination').html(''); 
            }
        }); 
    });  

    // delete user 

    $(document).on('click', '#btn-delete-files', function () {
        const fileID = $(this).data('id');
        console.log(fileID);
        if (confirm("Are you sure you want to delete this File?")) {
            $.ajax({
                url: "../../../controller/admin/file-management.php",
                type: "POST",
                data: {
                    action: "delete_files",
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



    function GetAllUserFiles()
    {
        $.ajax({
            url: "../../../controller/admin/file-management.php",
            type: "POST", 
            data: { action: "get_all_files" },
            success: function(response) {  
            //console.log(response); 
            $('#user-files-container-table').html(response);      
            paginateTable("#user-files-container-table", 10); 
            }
        });
    }  

    $(document).on('click', '#btn-view-files', function () {
        const fileId = $(this).data('id');
        fetchFilePathAndOpen(fileId);
    });
    
    function fetchFilePathAndOpen(fileId) {
        $.ajax({
            url: "../../../controller/admin/file-management.php",
            type: "POST",
            data: {
                action: "get_file_path",
                id: fileId
            },
            dataType: "json",
            success: function (res) { 
                console.log(res);
                if (res.statuscode === 200) {
                    window.open(res.file_path, '_blank');
                } else {
                    alert(res.message || "Failed to retrieve file.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }
        
    
    
    

