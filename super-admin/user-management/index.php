<?php require dirname(dirname(dirname(__FILE__))) . "/authentication/verify.php" ; ?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../src/includes/head.php'?> 
<link rel="stylesheet" href="<?php echo $baseUrl  . '/assets/css/style.css'?>" id="main-style-link"> 
<link rel="stylesheet" href="<?php echo $baseUrl . '/assets/css/custom/style.css' ?>" />  
<link rel="stylesheet" href="<?php echo $baseUrl . '/assets/js/toastr/toastr.min.css' ?>" />  
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <?php include  '../../src/includes/super-admin/navbar.php' ?>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <?php include  '../../src/includes/header.php' ?> 
    <?php include '../modal.php'?> 
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content"> 
            <!-- [ Main Content ] this section dynamically render by content and by invoking page... -rod -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-container-shadow">
                        <div class="card-header">
                            <div class="row">
                                <div class="col d-flex">
                                    <form class="px-3">
                                        <div class="form-group mb-1 d-flex align-items-center">
                                            <i data-feather="search"></i>
                                            <input id="files-search"
                                                class="form-control border-1 shadow-sm  mx-2"
                                                placeholder="Search here. . ." style="width:500px">
                                        </div>
                                        </form>
                                    </div>
                         
                                <div class="col d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary btn-sm add-user-btn"  data-bs-toggle="modal" 
                                    data-bs-target="#add-user-modal"
                                     id="add-user-files">Add</button>
                                </div> 
                                <div id="modal-container"></div>
                            </div>
                            <div class="card-body">
                                <div id="user-container-table"></div>
                                <div id="pagination" class="mt-2 d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
        <!-- Required Js --> 
        <?php include '../../src/include/scripts/scripts.php'?>  
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
         <script src="../../src/service/super-admin/user-management.js"></script>  
         <script src="../../src/include/components/pagination.js"></script> 
         <script src="../../src/include/components/toast.js"></script>   
         <script src="../../route.js"></script> 
         <script>
        function togglePassword() {
            const input = document.getElementById("user-password");
            if (input.type === "password") {
                input.type = "text";  // show password
            } else {
                input.type = "password";  // hide password
            }
        }
</script>
</body>
<!-- [Body] end -->

</html>  


