<?php
       if(!isset($_SESSION)) 
       { 
           session_start(); 
       } 
       include_once('../Back/func.php');
       $link = db_connect();
       $is_valid = TRUE;
       $error = '';
       if (isset($_POST['register-submit'])){
           if(empty($_POST['username-reg'])){
               $error = "Please insert name!";
           }
           elseif(empty($_POST['password-reg'])){
               $error = "Please insert password!";
           }
           elseif(empty($_POST['email-reg'])){
               $error = "Please insert email!";
           }
          else{
               $reg_name = trim(filter_input(INPUT_POST, 'username-reg', FILTER_SANITIZE_STRING));
               $email_reg = strtolower(filter_input(INPUT_POST,'email-reg', FILTER_SANITIZE_EMAIL));
               $reg_pwd = trim(filter_input(INPUT_POST, 'password-reg', FILTER_SANITIZE_STRING));
               $check_mail = "SELECT * FROM users WHERE email = '$email_reg'";
               $check_mail_query = mysqli_query($link, $check_mail);
               if(mysqli_num_rows($check_mail_query) > 0){
                   $error = "Email already exists in the system!";
                   $is_valid = FALSE;
               }
               else{
                  $reg_pwd = password_hash($reg_pwd, PASSWORD_BCRYPT);
               }
               $reg_query = "INSERT INTO users(uname, email, psw) VALUES ('$reg_name', '$email_reg', '$reg_pwd')";
               if($is_valid){
               if($reg_request = mysqli_query($link, $reg_query)){
                   header("location:index.php");              }
                   
               }   
           }
       }
             if (isset($_POST['log_submit'])){
           if($_POST['token'] == $_SESSION['csrf_token']){
           if(empty($_POST['u_email'])){
               $error = "Please insert email!";
           }
           elseif(empty($_POST['pswd'])){
               $error = "Please insert password!";
           }
     
          else{
               $email_log = strtolower(filter_input(INPUT_POST, 'u_email', FILTER_SANITIZE_EMAIL));
               $log_pwd = trim(filter_input(INPUT_POST, 'pswd', FILTER_SANITIZE_STRING));
               $log_query = "SELECT * FROM users WHERE email = '$email_log'";
               if($log_req = mysqli_query($link, $log_query)){
                   if(mysqli_num_rows($log_req)> 0){
                       $row_arr = mysqli_fetch_assoc($log_req);
                       if(password_verify($log_pwd, $row_arr['pwd'])){
                           header("location: blog.php");
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
        ?>