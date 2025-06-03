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
    <?php include  '../../includes/navbar.php' ?>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <?php include  '../../includes/header.php' ?>
    <!-- [ Header ] end -->
    <?php include './modal/modal.php'?>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] this section dynamically render by content and by invoking page... -rod -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col d-flex">
                                    <form class="px-3">
                                        <div class="form-group mb-1 d-flex align-items-center">
                                            <i data-feather="search"></i>
                                            <input id="user-search"
                                                class="form-control border-1 shadow-sm  mx-2"
                                                placeholder="Search here. . ." style="width:400px">
                                        </div>
                                        </form>
                                    </div>
                         
                                <div class="col d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary btn-sm add-user-btn"
                                        data-bs-toggle="modal" data-bs-target="#add-user-modal">Add user</button>
                                </div>
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
        <?php include '../../includes/script.php'?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../../../service/user-management.js"></script>
        <script>
        function togglePassword() {
            const passwordInput = document.getElementById("user-password");
            const icon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.setAttribute("data-feather", "eye");
            } else {
                passwordInput.type = "password";
                icon.setAttribute("data-feather", "eye-off");
            }

            feather.replace();
        }
        feather.replace();
        </script>

</body>
<!-- [Body] end -->

</html>