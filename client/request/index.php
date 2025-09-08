<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./index.css">
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
    <!-- [ Sidebar Menu ] start -->
    <?php include  '../../src/includes/client/navbar.php' ?>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <?php include  '../../src/includes/header.php' ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] this section dynamically render by content and by invoking page... -rod -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-container-shadow">
                        <div class="row content" style="padding:1rem;">
                            <div class="col first-container">
                                <span class="header-container">
                                    <h5>Request a File</h5>
                                </span>
                                <div class="content">
                                    <form action="POST">
                                        <span>
                                            <input type="hidden" name="user_id" id="user_id" value="3">
                                            <label>NAME</label>
                                            <input class="form-control form-control-md mb-1" type="text">
                                        </span>
                                        <span>
                                            <label class>FILE NAME</label>
                                            <input class="form-control form-control-md" id='filename' type="text">
                                        </span>
                                        <span>
                                            <button type="button" class="btn-request" id="btn_request">Request</button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="col second-container">
                                <div class="content">
                                    <div class="search-container">
                                        <div class="col-4 d-flex justify-content-start">
                                            <h5>Status of Request</h5>
                                        </div>
                                        <div class="col">
                                            <form class="px-1">
                                                <div class="form-group mb-1 d-flex align-items-center">
                                                    <i data-feather="search"></i>
                                                    <input id="status-search"
                                                        class="form-control border-1 shadow-sm  mx-2"
                                                        placeholder="Search here. . .">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                  <div id="user-status-request-container-table"></div>
                                  <div id="status-paginate" class="mt-2 d-flex justify-content-center"></div>
                                </div>
                            </div>
                            <div class="list-requested-file">
                                <div class="header-requested-title">
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-center">
                                            <h5>List of Requested Files</h5>
                                        </div>
                                        <div class="col">
                                            <form class="px-1">
                                                <div class="form-group mb-1 d-flex align-items-center">
                                                    <i data-feather="search"></i>
                                                    <input id="files-search"
                                                        class="form-control border-1 shadow-sm  mx-2"
                                                        placeholder="Search here. . .">
                                                </div>
                                            </form>
                                        </div> 
                                          <div class="card-body">
                                                <div id="user-request-container-table"></div>
                                                <div id="pagination" class="mt-2 d-flex justify-content-center"></div>
                                            </div>
                                    </div>
                                </div>
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
        <script src="../../src/include/components/pagination.js"></script>
        <script src="../../src/include/components/search.js"></script>
        <script src="../../src/include/components/toast.js"></script>
        <script src="../../src/service/client/request.js"></script>

</body>
<!-- [Body] end -->

</html>