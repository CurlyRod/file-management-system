    var baseUrl = window.location.origin + '/file-management-system/src';   
    var absolutePath = baseUrl + "/controller/client/request.php"; 
    
    console.log(absolutePath);
    $(document).on('click', '#btn_request', function () { 
       var user_id =  $("#user_id").val(); 
       var filename = $("#filename").val();
        $.ajax({
            url: absolutePath ,
            type: "POST",
            data: { action: "request_file" , user_id: user_id, filename: filename },
            success: function(response) { 
                 console.log(response);
                }
            });  
    });