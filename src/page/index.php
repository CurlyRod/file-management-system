<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<?php include './includes/head.php'?>
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
    <?php include  './includes/navbar.php' ?>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <?php include  './includes/header.php' ?>
    <!-- [ Header ] end --> 

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Main Content ] this section dynamically render by content and by invoking page... -rod -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Check</h5>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
  <?php include './includes/script.php'?>
</body>
<!-- [Body] end -->

</html> 
