    var baseUrl = window.location.origin + '/file-management-system/src';  
    var absolutePath = baseUrl + "/controller/admin/resolved-tickets.php"; 
    
    $(document).ready(function () {
        GetAllResolvedTicket();
    });
    
    $(document).on('click', '#add-resolved-tickets', function () {
        const modalHTML = `
        <div class="modal fade" id="uploadResolvedTicketsModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="upload-form-resolved-tickets" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload File</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                           <input type="file" name="file" class="form-control mb-3" required accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
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
        const modal = new bootstrap.Modal(document.getElementById('uploadResolvedTicketsModal'));
        modal.show();
    }); 


    $(document).on('submit', '#upload-form-resolved-tickets', function (e) {
        e.preventDefault();
    
        const fileInput = $(this).find('input[type="file"]')[0];
        const file = fileInput.files[0];
    
        if (!file) {
            alert("Please select a file.");
            return;
        }
    
     
        const validMimeTypes = [
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", 
            "application/vnd.ms-excel" 
        ];
        const validExtensions = [".xlsx", ".xls"];
        const fileName = file.name.toLowerCase();
    
        const isValidType = validMimeTypes.includes(file.type);
        const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
    
        if (!isValidType && !hasValidExtension) {
            alert("Invalid file type. Please upload an Excel file (.xlsx or .xls).");
            return;
        }
    
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
            url: absolutePath,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if (res.statuscode === 200) {
                    $('#uploadResolvedTicketsModal').modal('hide');
                    $('#upload-form-resolved-tickets')[0].reset();
                    $("#upload-progress").css("width", "0%").text("0%");
                    $("#upload-status").text("");
    
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000"
                    };
    
                    toastr.success(res.message);
                    GetAllResolvedTicket();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                $("#upload-status").text("Upload failed.").removeClass("text-muted").addClass("text-danger");
            }
        });
    });
     
 
    function GetAllResolvedTicket()
    {
        $.ajax({
            url: absolutePath,
            type: "POST", 
            data: { action: "getall_resolved_tickets" },
            success: function(response) {  
            //console.log(response); 
            $('#resolve-tickets-container-table').html(response);      
            paginateTable("#resolve-tickets-table", 10); 
            }
        });
    }  

    $(document).ready(function () {
    
        GetAllResolvedTicket();  

        // search function... -rod
        $(document).on('keyup', '#files-search', function () {
            let value = $(this).val().toLowerCase();
            let visibleRows = 0;
        
            $('#resolve-tickets-table tbody tr').each(function () {
                const isVisible = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(isVisible);
        
                if (isVisible) visibleRows++;
            });
            
            if (value === "") {
                paginateTable("#resolve-tickets-table", 10);
            } else {
                $('#pagination').html(''); 
            }
        }); 
    });   
    
    $(document).on('click', '#btn-download-files', function () {
        const fileID = $(this).data('id');
        if (confirm("Are you sure you want to download this File?")) 
            {
                $.ajax({
                    url: absolutePath,
                    type: "POST",
                    data: {
                        action: "get_file_download",
                        id: fileID
                    },
                    success: function (response) {
                        try {
                            const res = JSON.parse(response);
            
                            if (res.statuscode === 200) {
                           
                                window.open(res.download_url, '_blank');
                            } else {
                                alert(res.message || "Download failed.");
                            }
                        } catch (e) {
                            console.error("JSON parse error:", response);
                            alert("Server returned invalid JSON.");
                        }
                    },
                    error: function () {
                        alert("AJAX failed.");
                    }
                });
            }
    });
    