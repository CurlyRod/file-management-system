
<head>
    <title>File Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"id="main-font-link">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
   
   <?php 
       //this block of code dynamically render link from array to lessen repetive href ... rod
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . $host . "/file-management-system/src/";

        $scriptPath = [
            "assets/fonts/tabler-icons.min.css", 
            "assets/fonts/feather.css",
            "assets/fonts/fontawesome.css", 
            "assets/fonts/material.css", 
            "assets/css/style-preset.css",
            "assets/css/style.css",
            "assets/js/toastr/toastr.min.css"
        ]; 

        foreach ($scriptPath as $link) {
            echo '<link rel="stylesheet" href="' . $baseUrl . $link . '"/>' . PHP_EOL;
        }  
    ?>
</head> 

