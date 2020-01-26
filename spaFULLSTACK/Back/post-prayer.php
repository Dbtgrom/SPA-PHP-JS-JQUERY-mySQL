<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

 require_once 'func.php';
 require_once 'entry.php';

 $link = db_connect();
 $error = '';
 $is_valid = TRUE;
 
 if (isset($_POST['buttonPost'])){
    if(empty($_POST['textPrayer'])){
        $error = "No prayer no answer!";
    }
    $post_data = trim(filter_input(INPUT_POST, 'textPrayer', FILTER_SANITIZE_STRING));
    $post_data = addslashes(mysqli_real_escape_string($link, $post_data));
    
    $artist_id = $_SESSION['uname'];
  
    $query = "INSERT INTO prayers(artistID, text) VALUES('$artist_id', '$post_data')";
         
        if($post_request = mysqli_query($link, $query)){
         
            header('location: ../Front/index.php?showPost=1');
        }
        
}

?>