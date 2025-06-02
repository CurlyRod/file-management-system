$(document).on('submit', '#add-user-form', function(e) {   
    e.preventDefault();  

    var formData = $(this).serialize() + "&action=insert";
    $.ajax({
        url: "../../controller/user-management.php",
        type: "POST",
        data: formData,
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statuscode === 200) {
                $("#add-user-modal").modal('hide');
                $("#add-user-form")[0].reset();
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});
