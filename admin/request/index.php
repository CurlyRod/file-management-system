<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<?php include '../../includes/head.php'?>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <?php include  '../../includes/admin/navbar.php' ?>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <?php include  '../../includes/header.php' ?>
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
                                <div id="modal-container"></div>
                            </div>
                            <div class="card-body">
                                <div id="request-files-container-table"></div>
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
        <?php include '../../includes/script.php'?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <script src="../../../service/admin/request.js"></script>  
         <script src="../../../page/includes/js/pagination.js"></script>
         <script src="../../components/toast.js"></script> 
</body>
<!-- [Body] end -->

</html>