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
                            <div class="col first-container" style="border:1px solid grey;">
                                <span class="header-container">
                                    <h5>Request a File</h5>
                                </span>
                                <div class="content">
                                    <span>
                                        <label>NAME</label>
                                        <input class="form-control form-control-md mb-1" type="text">
                                    </span>
                                    <span>
                                        <label class>FILE NAME</label>
                                        <input class="form-control form-control-md" type="text">
                                    </span>
                                    <span>
                                        <button type="button" class="btn-request">Request</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col second-container" style="border:1px solid grey;">
                                <div class="content">
                                    <div class="search-container">
                                        <div class="col-3">
                                            <h5>Status of Request</h5>
                                        </div>
                                        <div class="col">
                                            <form class="px-3">
                                                <div class="form-group mb-1 d-flex align-items-center">
                                                    <i data-feather="search"></i>
                                                    <input id="files-search"
                                                        class="form-control border-1 shadow-sm  mx-2"
                                                        placeholder="Search here. . .">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-search mt-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">First</th>
                                                    <th scope="col">Last</th>
                                                    <th scope="col">Handle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Mark</td>
                                                    <td>Otto</td>
                                                    <td>@mdo</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Jacob</td>
                                                    <td>Thornton</td>
                                                    <td>@fat</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td colspan="2">Larry the Bird</td>
                                                    <td>@twitter</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="list-requested-file">
                            <div class="header-requested-title" >
                                <div class="row">
                                    <div class="col-2">
                                        <h5>List of Requested Files</h5>
                                    </div>
                                    <div class="col">
                                        <form class="px-3">
                                            <div class="form-group mb-1 d-flex align-items-center">
                                                <i data-feather="search"></i>
                                                <input id="files-search" class="form-control border-1 shadow-sm  mx-2"
                                                    placeholder="Search here. . .">
                                            </div>
                                        </form>
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
        <script src="../../src/include/components/toast.js"></script>

</body>
<!-- [Body] end -->

</html>