    var baseUrl = window.location.origin + '/file-management-system/src';  
    var absolutePath = baseUrl + "/controller/admin/analytics.php";  
    var user_id =  $("#session_id").text();  
 

  $(document).ready(function () {
        GetAllMyfiles();
        GetAllTransactionCount(); 
        GetResolveCount();     
  }); 

    function GetAllMyfiles()
    {
        $.ajax({
            url: absolutePath,
            type: "POST", 
            data: { action: "get_myfiles" , user_id: user_id},
            success: function(response) {  
            var data = JSON.parse(response); 
            $("#total_myfiles").text(data.total_myfile);
            }
        });
    }  

    function GetAllTransactionCount()
    {
        $.ajax({
            url: absolutePath,
            type: "POST", 
            data: { action: "get_transacCount" },
            success: function(response) {  
            var data = JSON.parse(response); 
            $("#total_transac").text(data.totalTransac);
            }
        });
    }  
    function GetResolveCount()
    {
        $.ajax({
            url: absolutePath,
            type: "POST", 
            data: { action: "get_resolveCount" },
            success: function(response) {  
            var data = JSON.parse(response);        
            $("#total_resolve").text(data.totalResolve);
            }
        });
    } 

 