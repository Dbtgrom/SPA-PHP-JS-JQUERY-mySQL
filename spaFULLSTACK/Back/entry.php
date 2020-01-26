<?php
       if(!isset($_SESSION)) 
       { 
           session_start(); 
       } 
       require_once 'func.php';
       $link = db_connect();
       $error = '';
       $cookie_name = 'user';
       $cookie_value = "This is a cookie";
       if (isset($_POST['login-submit'])){
       
           if($_POST['token'] == $_SESSION['csrf_token']){
           if(empty($_POST['username'])){
               $error = "Username needed!";
           }
           elseif(empty($_POST['password'])){
               $error = "Please insert password!";
           }
     
          else{
               $name_log= strtolower(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL));
               $log_pwd = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
               $log_query = "SELECT * FROM users WHERE uname = '$name_log'";
               if($log_req = mysqli_query($link, $log_query)){
                   if(mysqli_num_rows($log_req)> 0){
                       $row_arr = mysqli_fetch_assoc($log_req);
                       if(password_verify($log_pwd, $row_arr['psw'])){
                        $_SESSION['id'] = $row_arr['id'];
                        $_SESSION['uname'] = $row_arr['uname'];
                       $_SESSION['the_guy'] = $_SERVER['HTTP_USER_AGENT'];
                       $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                          
                          setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                          header("location: index.php");
                       }
                       }
                   
               }
             
                  

                        
          $error = "You must register!"; 
          }
       }
       else{
           $error = "NO NO NO!!!!";
       }
       }
       if(isset($_GET["log_out"])){
        setcookie($cookie_name, "" ,-3600,"/");
       

        session_destroy();
        header("location: index.php");
    }
    
       $csrf_token = hash("sha256", rand(10000000, 99999999));
       $_SESSION['csrf_token'] = $csrf_token;
        ?>