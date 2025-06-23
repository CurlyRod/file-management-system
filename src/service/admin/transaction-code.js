    $(document).ready(function () {
            GetAllTransactioCode();
    });

    $(document).on('click', '#add-transaction-code', function () {
        const modalHTML = `
        <div class="modal fade" id="uploadTransactionCodeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="upload-form-transaction-code" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload File</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                           <input type="file" name="file" class="form-control mb-3" required accept="application/pdf">
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
        const modal = new bootstrap.Modal(document.getElementById('uploadTransactionCodeModal'));
        modal.show();
    }); 


    $(document).on('submit', '#upload-form-transaction-code', function (e) {
        e.preventDefault();
    
        const fileInput = $(this).find('input[type="file"]')[0];
        const file = fileInput.files[0];
    
        if (!file) {
            alert("Please select a file.");
            return;
        }
    
     
       const validMimeTypes = [
             "application/pdf"
        ];
        const validExtensions = [".pdf"];
        const fileName = file.name.toLowerCase();

        const isValidType = validMimeTypes.includes(file.type);
        const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));

        if (!isValidType && !hasValidExtension) {
            alert("Invalid file type. Please upload a PDF file (.pdf).");
            return;
        }
    
        const form = $(this)[0];
        const formData = new FormData(form);
        formData.append("action", "upload_file_pdf");
    
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
            url: "../../../controller/admin/transaction-code.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if (res.statuscode === 200) {
                    $('#uploadTransactionCodeModal').modal('hide');
                    $('#upload-form-transaction-code')[0].reset();
                    $("#upload-progress").css("width", "0%").text("0%");
                    $("#upload-status").text("");
    
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000"
                    };
    
                    toastr.success(res.message); 
                    console.log(res);
                 GetAllTransactioCode();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                $("#upload-status").text("Upload failed.").removeClass("text-muted").addClass("text-danger");
            }
        });
    }); 

    function GetAllTransactioCode()
    {
        $.ajax({
            url: "../../../controller/admin/transaction-code.php",
            type: "POST", 
            data: { action: "getall_transaction_code" },
            success: function(response) {  
            $('#resolve-tickets-container-table').html(response);      
            paginateTable("#resolve-tickets-table", 10); 
            }
        });
    }  

    $(document).on('click', '#btn-view-files', function () {
        const fileId = $(this).data('id');
        fetchFilePathAndOpen(fileId);
    });
    
    function fetchFilePathAndOpen(fileId) {
        $.ajax({
            url: "../../../controller/admin/transaction-code.php",
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