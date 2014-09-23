<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
        <meta name="description" content="Aportando mi granito">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="Eduardo">
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Enorabuena > Formas parte de Ushauri</title>  
    <link href="css/style.css" type="text/css" rel="stylesheet" />  
    <link type="image/x-icon" href="./images/cliente.ico" rel="shortcut icon"/>
</head>  
<bodystyle="text-align:center;">  
    <!-- start header div -->   
    <div id="header" >  
        <h1>ushauri.hol.es</h1> 
        <h3>Sign up</h3>  
    </div>  
    <!-- end header div -->     
      
    <!-- start wrap div -->     
    <div id="wrap">  
        <!-- start PHP code -->  
        <?php  
            include('init.php');
            global $conexion;
            echo '<div st>'
            if(isset($_GET['tenedor']) && !empty($_GET['tenedor']) && isset($_GET['cuchara']) && !empty($_GET['cuchara'])){  
                // Verify data  
                $email = mysql_escape_string($_GET['cuchara']); // Set email variable  
                $hash = mysql_escape_string($_GET['tenedor']); // Set hash variable  

                print_r($email);

                $search = $conexion->query("SELECT email, hash, active FROM clientes WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error());   
                $match  = $search->num_rows; 

                if($match > 0){  
                    $conexion->query("UPDATE clientes SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error());  
                    echo '<div class="statusmsg">Tu cuenta acaba de ser activada. Ves al Area de CLientes para loguearte</div>'; 
                }else{  
                    // No match -> invalid url or account has already been activated. 
                    echo '<div class="statusmsg">Tu cuenta ha sido activada anteriormente.</div>'; 
                }

            }else{  
                // Invalid approach  
                echo '<div class="statusmsg">Los datos no coinciden</div>';
            }
            echo '<p><a href="http://10.1.29.12/~eduardo/bb/areaclientes.php">Area Clientes</a></p>'; 
        ?>  
        <!-- stop PHP Code -->  
  
          
    </div>  
    <!-- end wrap div -->   
</body>  
</html>  