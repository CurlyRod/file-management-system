<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . $host . "/file-management-system/src/";
    
    $scriptPath = [ 
        "assets/js/toastr/toastr.min.js",
        "assets/js/plugins/popper.min.js", 
        "assets/js/plugins/simplebar.min.js", 
        "assets/js/plugins/bootstrap.min.js",
        "assets/js/fonts/custom-font.js", 
        "assets/js/pcoded.js",
        "assets/js/plugins/feather.min.js" ,
   
    ]; 

    foreach ($scriptPath as $link) {
        echo '<script src="' . $baseUrl . $link . '"></script>' . PHP_EOL;
    } 
?>  
<script>
    layout_change('light');
    change_box_container('false');
    layout_rtl_change('false'); 
    preset_change("preset-1");
    font_change("Public-Sans");
</script>

