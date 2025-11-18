
<?php  
    require __DIR__. "/authentication/db-conn.php";
    require __DIR__. "/authentication/authentication.php" ;   
 ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/assets/css/plugins/bootstrap.min.css"> 
    <link rel="stylesheet" href="./index.css">
    <title>Document</title>
</head>
<style> 


</style>
<body>
     <form method="POST">
      <div class="container">
        <div class="row login-container">
            <div class="col login-container">
                <div class="p login-title">
                    Centralized sap documentation files access grant system
                </div> 
                  <?php if($is_invalid): ?>
                         <div id="invalid-credential-alert" 
                              class="alert alert-danger text-center p-2" 
                              role="alert">Invalid Credential </div> 
                 <?php endif; ?>
                <div class="span-text-field">      
                    <span>
                        <label>EMAIL</label>
                        <input class="form-control form-control-lg" type="text" name="email">
                    </span>
                   <span>
                        <label>PASSWORD</label>
                        <input class="form-control form-control-lg" type="password" name="password" >
                   </span>
                </div>
                <div class="span btn-container">
                    <button type="submit" class="btn-login">LOGIN</button>
                </div>
            </div>
            <div class="col banner-container">
            <img src="./src/assets/images/vendor/banner.png" alt="">
            </div>
        </div>
    </div>
  </form>
</body>

</html> 

<script>
    const alertElement = document.getElementById('invalid-credential-alert');
    if (alertElement) {
        setTimeout(() => {
            alertElement.classList.add('fade-out');
        }, 2000); 
        setTimeout(() => {
            alertElement.style.display = 'none';
        }, 3000); 
    }
</script>